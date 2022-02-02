<?php
/**
 * Invoice model
 *
 * @package app
 * @subpackage models
 */
class Invoice extends AppModel {

    public $name = 'Invoice';

    public $virtualFields = array(
        'daysdiff' => 'DATEDIFF( NOW( ) ,  Invoice.valid_until )'
    );

    public $belongsTo = array(
        'Account',
        'Country',
        'Host',
        'Poll'
    );

    public $hasOne = array(
        'PaymentPP'
    );

    public $actsAs = array(
        'Containable'
    );


    /**
    * get the total amount of pending invoices
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $account_id
    * @return int
    */
    public function getPendingAmount($account_id = null) {

        if(!$account_id) {
            return 0;
        }

        $invoices = $this->find('all', array(
            'conditions' => array(
                'Invoice.deleted' => 0,
                'Invoice.account_id' => $account_id,
                'Invoice.status' => 1
            )
        ));

        $pending = 0;

        foreach($invoices as $invoice) {
            $pending += $invoice['Invoice']['final_total'];
        }

        return $pending;
    }

    /**
    * get the total amount of pending invoices
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return int
    */
    public function getPendingAmountOverall() {

        $invoices = $this->find('all', array(
            'conditions' => array(
                'Invoice.deleted' => 0,
                'Invoice.status' => 1
            )
        ));

        $pending = 0;

        foreach($invoices as $invoice) {
            $pending += $invoice['Invoice']['final_total'];
        }

        return $pending;
    }

    /**
    * get the total amount of invoices revenues
    *
    * @author jean wichert <jean.wichert@gmail.com>
    * @access public
    * @param void
    * @return int
    */
    public function getRevenuesAmountOverall() {

        $invoices = $this->find('all', array(
            'conditions' => array(
                'Invoice.deleted' => 0
            )
        ));

        $revenues = 0;

        foreach($invoices as $invoice) {
            $revenues += $invoice['Invoice']['final_total'];
        }

        return $revenues;
    }


    /**
    * get an invoice record by its id
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $invoice_id
    * @return boolean | mixed $invoice
    */
    public function getInvoice($invoice_id = null) {
        if(!$invoice_id) {
            return false;
        }

        $invoice = $this->find('first', array(
            'contain' => array(
                'Account',
                'PaymentPP',
                'Host',
                'Poll'
            ),
            'conditions' => array(
                'Invoice.deleted' => 0,
                'Invoice.id' => $invoice_id
            )
        ));

        return $invoice;
    }

    /**
    * generate the next invoice number depending on year, month and current number
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return string $number
    */
    public function getNextInvoiceNumber() {
        $last = $this->find('first', array(
            'conditions' => array(
                'Invoice.deleted' => 0,
                'SUBSTRING(`Invoice`.`invoice_number`, 1, 4)' => date('Y')
            ),
            'order' => 'CAST(last_invoice AS SIGNED) DESC',
            'fields' => array(
                'SUBSTRING(`Invoice`.`invoice_number`, 6) AS last_invoice'
            )
        ));

        if (empty($last)) {
            $number = date('Y') . '-0001' ;
        } else {
            $temp_number = $last[0]['last_invoice'] + 1;
            if($temp_number <= 9999) {
                $number = date('Y') . '-' . ($this->leadingZeros($last[0]['last_invoice'] + 1, 4));
            } else {
                $number = date('Y') . '-' . ($this->leadingZeros($last[0]['last_invoice'] + 1, 5));
            }
        }

        return $number;
    }

    /**
    * get an array of payment types
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getPaymentTypes() {
        return array(
            1 => __('PayPal', true),
            2 => __('On Account', true)
        );
    }

    /**
    * get an array of invoice statuses
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return array
    */
    public function getStatuses() {
        return array(
            0 => __('undefined', true),
            1 => __('pending', true),
            2 => __('paid', true),
            3 => __('denied', true),
            4 => __('failed', true),
            5 => __('refunded', true)
        );
    }

    /**
    * add leading zeros to a given number, based on a given int for the length
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return int $num, int $numDigits
    */
    public function leadingZeros($num, $numDigits) {
        return sprintf("%0".$numDigits."d",$num);
    }

}
