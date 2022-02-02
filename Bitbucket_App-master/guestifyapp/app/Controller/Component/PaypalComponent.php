<?php
/**
 * component for paypal API calls
 *
 * @package app
 * @subpackage controllers.components
 */
class PaypalComponent extends Object {

    # standard component functions (do NOT mess aroung with this!)
    public function initialize(Controller $controller, $settings = array()) {
        $this->controller = $controller;
    }

    public function startup(Controller $controller) {
    }

    public function shutdown(Controller $controller) {
    }

    public function beforeRender(Controller $controller) {
    }

    public function beforeRedirect(Controller $controller, $url, $status = NULL, $exit = true) {
    }

    public $PROXY_HOST      = '127.0.0.1';
    public $PROXY_PORT      = '808';

    # PayPal API setup
    public $API_Sandbox     = true;
    public $API_Endpoint    = '';
    public $API_UserName    = '';
    public $API_Password    = '';
    public $API_Signature   = '';
    public $API_Version     = '';
    public $API_Localecode  = '';


    public $URL_PAYPAL      = '';
    public $URL_POLLUPGRADE_RETURN      = '';
    public $URL_POLLUPGRADE_CANCEL      = '';

    # BN Code is only applicable for partners
    public $sBNCode         = "PP-ECWizard";
    public $USE_PROXY       = false;



    /**
    * format the nvpstr for SetExpressCheckout
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param mixed $data
    * @return mixed $nvpstr
    */
    public function prepareExpressCheckout($data) {
        if(!$data) {
            return false;
        }

        #pr($data);
        #exit;

        # define general settings
        $nvpstr = "";
        $nvpstr .= "&METHOD=SetExpressCheckout";
        $nvpstr .= "&SOLUTIONTYPE=Sole";
        $nvpstr .= "&VERSION=".$this->API_Version;
        $nvpstr .= "&LOCALECODE=".$this->API_Localecode;
        $nvpstr .= "&CURRENCYCODE=EUR";
        $nvpstr .= "&RETURNURL=".$this->URL_POLLUPGRADE_RETURN;
        $nvpstr .= "&CANCELURL=".$this->URL_POLLUPGRADE_CANCEL;
        $nvpstr .= "&NOTETOBUYER=" . urlencode(__('Thank you for your purchase!', true));
        $nvpstr .= "&REQCONFIRMSHIPPING=0";
        $nvpstr .= "&NOSHIPPING=1";


        # add some style to the checkout page
        $nvpstr .= "&HDRIMG=https://s3.us-east-1.amazonaws.com/media-guestify/live/guestify_logo_word_brand_inverse_150.png";


        $nvpstr .= "&HDRBORDERCOLOR=ABD46E";
        $nvpstr .= "&PAYFLOWCOLOR=E0EBF6";

        # define the TOTALS of the checkout
        $nvpstr .= "&PAYMENTREQUEST_0_PAYMENTACTION=Sale";
        $nvpstr .= "&PAYMENTREQUEST_0_DESC=" . urlencode($data['Invoice']['description']);
        $nvpstr .= "&PAYMENTREQUEST_0_CURRENCYCODE=EUR";
        $nvpstr .= "&PAYMENTREQUEST_0_ITEMAMT=".$data['Invoice']['final_netto'];
        $nvpstr .= "&PAYMENTREQUEST_0_TAXAMT=".$data['Invoice']['final_vat'];
        $nvpstr .= "&PAYMENTREQUEST_0_AMT=".$data['Invoice']['final_total'];
        $nvpstr .= "&PAYMENTREQUEST_0_ALLOWEDPAYMENTMETHOD=InstantPaymentOnly";

        # define the item if the checkout (currently only one for the plan subscription, user will follow!);
        #$nvpstr .= "&L_PAYMENTREQUEST_0_ITEMCATEGORY0=Digital";    // comment this in when using live!
        $nvpstr .= "&L_PAYMENTREQUEST_0_NAME0=".urlencode('guestify Poll Upgrade');
        $nvpstr .= "&L_PAYMENTREQUEST_0_DESC0=".urlencode($data['Invoice']['description']);
        $nvpstr .= "&L_PAYMENTREQUEST_0_AMT0=".$data['Invoice']['final_netto'];
        $nvpstr .= "&L_PAYMENTREQUEST_0_TAXAMT0=".$data['Invoice']['final_vat'];
        $nvpstr .= "&L_PAYMENTREQUEST_0_QTY0=1";

        # uncomment to see what will be sent to paypal
        #$check = $this->deformatNVP($nvpstr);
        #pr($check);
        #exit;

        # set session data to handle the "doExpressCheckout" function
        $_SESSION["CURRENCYCODE"]  = 'EUR';
        $_SESSION["PAYMENTTYPE"]   = 'Sale';
        $_SESSION["PAYMENTAMOUNT"] = $data['Invoice']['final_total'];
        $_SESSION["NVPSTR"]        = $nvpstr;

        return $nvpstr;
    }



    # see https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_r_SetExpressCheckout for
    # description of each part-string and API
    function SetExpressCheckout($nvpstr) {
        # call the paypal API and set the prev. defined data
        $result = $this->hash_call("SetExpressCheckout", $nvpstr);
        return $result;
    }


    /* get the prev. defined details and some more from the paypal API */
    function GetExpressCheckoutDetails( $token ) {
        $nvpstr = "&TOKEN=" . urldecode($token);
        $result = $this->hash_call("GetExpressCheckoutDetails", $nvpstr);
        $ack = strtoupper($result["ACK"]);
        return $result;
    }


    /* get all information about a recurring payment profile */
    /* ACTIONS: */
    function ManageRecurringPaymentsProfileStatus($profile_id, $action) {
        $nvpstr = '';
        $nvpstr  .= '&METHOD=ManageRecurringPaymentsProfileStatus';
        $nvpstr  .= '&ACTION='.$action;
        $nvpstr  .= '&PROFILEID='.$profile_id;
        $result = $this->hash_call("ManageRecurringPaymentsProfileStatus", $nvpstr);
        return $result;
    }


    /* create a recurring payment profile on paypal */
    function CreateRecurringPaymentsProfile( $nvpstr) {
        $result = $this->hash_call("CreateRecurringPaymentsProfile", $nvpstr);
        return $result;
    }


    /* get all information about a recurring payment profile */
    function GetRecurringPaymentsProfileDetails( $profile_id ) {
        $nvpstr  = '&METHOD=GetRecurringPaymentsProfileDetails&PROFILEID='.$profile_id;
        $result = $this->hash_call("GetRecurringPaymentsProfileDetails", $nvpstr);
        return $result;
    }



    /**
      '-------------------------------------------------------------------------------------------------------------------------------------------
      * hash_call: Function to perform the API call to PayPal using API signature
      * @methodName is name of API  method.
      * @nvpStr is nvp string.
      * returns an associtive array containing the response from the server.
      '-------------------------------------------------------------------------------------------------------------------------------------------
    */
    function hash_call($methodName,$nvpStr) {
        //declaring of global variables
        global $API_Endpoint, $API_Version, $API_UserName, $API_Password, $API_Signature;
        global $USE_PROXY, $PROXY_HOST, $PROXY_PORT;
        global $gv_ApiErrorURL;
        global $sBNCode;

        //setting the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        //turning off the server and peer verification(TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);

        //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
        //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php
        if($this->USE_PROXY)
            curl_setopt($ch, CURLOPT_PROXY, $this->PROXY_HOST. ":" . $this->PROXY_PORT);

        //NVPRequest for submitting to server
        $nvpreq = "METHOD=" . urlencode($methodName) . "&VERSION=" . urlencode($this->API_Version) . "&PWD=" . urlencode($this->API_Password) . "&USER=" . urlencode($this->API_UserName) . "&SIGNATURE=" . urlencode($this->API_Signature) . $nvpStr . "&BUTTONSOURCE=" . urlencode($this->sBNCode);

        //setting the nvpreq as POST FIELD to curl
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        //getting response from server
        $response = curl_exec($ch);


        //converting NVPResponse to an Associative Array
        $nvpResArray = $this->deformatNVP($response);
        $nvpReqArray = $this->deformatNVP($nvpreq);
        $_SESSION['nvpReqArray'] = $nvpReqArray;

        if (curl_errno($ch)) {
            // moving to display page to display curl errors
              $_SESSION['curl_error_no'] = curl_errno($ch) ;
              $_SESSION['curl_error_msg'] = curl_error($ch);

              //Execute the Error handling module to display errors.
        } else {
             //closing the curl
            curl_close($ch);
        }

        return $nvpResArray;
    }


    /*'----------------------------------------------------------------------------------
     Purpose: Redirects to PayPal.com site.
     Inputs:  NVP string.
     Returns:
    ----------------------------------------------------------------------------------
    */
    function RedirectToPayPal ( $token ) {
        // Redirect to paypal.com here
        $payPalURL = $this->URL_PAYPAL . $token;
        #header("Location: ".$payPalURL);
        $this->controller->redirect($payPalURL);
    }


    /*'----------------------------------------------------------------------------------
     * This function will take NVPString and convert it to an Associative Array and it will decode the response.
      * It is usefull to search for a particular key and displaying arrays.
      * @nvpstr is NVPString.
      * @nvpArray is Associative Array.
       ----------------------------------------------------------------------------------
      */
    function deformatNVP($nvpstr) {

        $result = array();

        $temp = explode('&', $nvpstr);

        foreach($temp as $key => $combined) {

            $temp2 = explode('=', $combined);
            if(isset($temp2[0]) && isset($temp2[1])) {
                $result[$temp2[0]] = $temp2[1];
            }
        }

        return $result;

        /*
        $intial = 0;
        $nvpArray = array();

        while(strlen($nvpstr)) {
            //postion of Key
            $keypos = strpos($nvpstr, '=');
            //position of value
            $valuepos = strpos($nvpstr, '&') ? strpos($nvpstr, '&'): strlen($nvpstr);

            //getting the Key and Value values and storing in a Associative Array
            $keyval = substr($nvpstr, $intial, $keypos);
            $valval = substr($nvpstr, $keypos+1, $valuepos - $keypos-1);
            //decoding the respose
            $nvpArray[urldecode($keyval)] = urldecode( $valval);
            $nvpstr = substr($nvpstr, $valuepos+1, strlen($nvpstr));
        }
        return $nvpArray;
        */


    }


    function DoExpressCheckoutPayment($token = null) {

        //Format the other parameters that were stored in the session from the previous calls
        // ADD THE MISSING PAYMENT INFO SO IT SHOWS UP ON THE PAYERS BILLING!
        #$token              = urlencode($_SESSION['TOKEN']);
        #$paymentType        = urlencode($_SESSION['PAYMENTTYPE']);
        #$currencyCodeType   = urlencode($_SESSION['CURRENCYCODE']);
        #$payerID            = urlencode($_SESSION['PAYER_ID']);
        #$serverName         = urlencode($_SERVER['']);


        $nvpstr = $_SESSION['NVPSTR'];
        $nvpstr = str_replace("&METHOD=SetExpressCheckout", "", $nvpstr);

        $nvpstr = '&TOKEN=' . urldecode($token);
        $nvpstr .= '&PAYERID=' . urlencode($_SESSION['PAYERID']);
        $nvpstr .= '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode($_SESSION['PAYMENTTYPE']);
        $nvpstr .= '&PAYMENTREQUEST_0_AMT=' . $_SESSION['PAYMENTAMOUNT'];
        $nvpstr .= '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($_SESSION['CURRENCYCODE']);
        $nvpstr .= '&IPADDRESS=' . urlencode($_SERVER['REMOTE_ADDR']);

        /*
        $nvpstr  = '&TOKEN=' . $token . '&PAYERID=' . $payerID . '&PAYMENTREQUEST_0_PAYMENTACTION=' . $paymentType . '&PAYMENTREQUEST_0_AMT=' . $FinalPaymentAmt;
        $nvpstr .= '&PAYMENTREQUEST_0_CURRENCYCODE=' . $currencyCodeType . '&IPADDRESS=' . $serverName;
        */

         /* Make the call to PayPal to finalize payment
            If an error occured, show the resulting errors
            */
        $resArray = $this->hash_call("DoExpressCheckoutPayment",$nvpstr);

        /* Display the API response back to the browser.
           If the response from PayPal was a success, display the response parameters'
           If the response was an error, display the errors received using APIError.php.
           */
        $ack = strtoupper($resArray["ACK"]);

        return $resArray;
    }


}
