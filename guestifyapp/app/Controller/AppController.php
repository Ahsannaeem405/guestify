<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package     app.Controller
 * @link        http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'email',
                        'password' => 'password'
                    ),
                    'scope' => array(
                        'User.role_id' => array(1, 2)
                    )
                )
            ),
            /*
            'loginRedirect' => array(
                'controller' => 'pages',
                'action' => 'display', 'dashboard'
            ),
            */
            'logoutRedirect' => array(
                'controller' => 'pages',
                'action' => 'display', 'logout'
            )
        ),
        'Permission',
        'RequestHandler',
        'Session',
        /*
        'DebugKit.Toolbar' => array(
            'cache' => array('engine' => 'Apc')
        ),
        */
    );

    public $helpers = array(
        'Form',
        'Html',
        'Js',
        'Label',
        'Session',
        'Tracker'
    );

    public $locale = 'eng';

    public $formats = array();

    public $config = array();

    public $periods = array();

    public $firstPollId = 0;


    /**
    * setup a single tracker for a given empail
    * connected to a model and foreign key
    *
    * receives the current Email-object, define
    * tracker information and set it into the email
    * so the tracker-helper can work with the details
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param object $Email, string $model, int $f_key
    * @return object
    */
    public function setupSingleTracker($Email = null, $model = null, $f_key = null) {

        # prepare & create the tracker
        $tracker_options = array(
            'sender_email' => array_keys($Email->from())[0],
            'type' => $Email->template()['template'],
            'recipient_email' => array_keys($Email->to())[0],
            'recipient_model' => $model,
            'recipient_f_key' => $f_key
        );

        $Tracker = ClassRegistry::init('Tracker');
        $tracker = $Tracker->createTrackerSingle($tracker_options);
        $Email->viewVars(compact('tracker'));

        return $Email;
    }


    public function beforeFilter() {

        // pr($this->params);
        // exit;


        if ($this->request->here == '/') {
            $locale = $this->Session->read('Config.language');
            if(empty($locale)) {
                return $this->redirect('/en', 301);
            } else {
                $this->redirect('/' . substr($locale, 0, 2), 301);
            }
        }

        // if ($this->request->here == '/en') {
        //     $this->Session->write('Config.language', 'en');
        // }

        # check for link tracking-urls
        // $query = $this->params->query;
        // if(isset($query['t_id']) && isset($query['e_id'])) {
        //     if(Configure::read('Environment') == 'LOCAL') {
        //         $ip = $_SERVER['REMOTE_ADDR'];
        //     } else {
        //         $ip = $_SERVER['HTTP_X_REALIP'];
        //     }

        //     $tracker_update = array(
        //         #'campaign_id' => $query['campaign_id'],
        //         'email_id' => $query['email_id'],
        //         'link' => Configure::read('NON_SSL_HOST') . $_SERVER['REQUEST_URI'],
        //         'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        //         'ip' => $ip
        //     );

        //     $Tracker = ClassRegistry::init('Tracker');
        //     $Tracker->updateLinkTracker($tracker_update);

        //     unset($this->params->query);
        // }


        #$locale = Configure::read('Config.language');
        $this->currentUser = $this->Auth->user();
        $this->isAuthed = !empty($this->currentUser);

        # add anything needed for logged in users
        if($this->Session->check('Auth.User.id')) {
            $this->loadModel('User');
            User::store($this->Auth->user());

            if(!$this->Permission->isAdmin()) {
                $Poll = ClassRegistry::init('Poll');
                $this->firstPollId = $Poll->getFirstPollId(User::get('account_id'));
            }
        }

        $locale = $this->setupLocale();

        if($this->isAuthed) {
            $this->Auth->allow();
        }

        $this->setMainConfig();

        # define standard formats for views
        switch($locale) {
            case 'eng':
                $this->formats['date'] = 'Y-m-d';
                $this->formats['date_placeholder'] = 'YYYY-mm-dd';
                $this->formats['time'] = 'H:i';
                $this->formats['year_month'] = 'Y-m';
                $this->formats['chart_month_day'] = '%m-%d';
                $this->formats['chart_year_month'] = '%y-%m';
                $this->formats['time_with_seconds'] = 'H:i:s';
                $this->formats['datetime'] = 'Y-m-d H:i:s';
                $this->formats['currency'] = array(
                    'places' => 2,
                    'before' => '$ ',
                    'escape' => false,
                    'decimals' => ',',
                    'thousands' => '.'
                );
                break;
            case 'deu':
                $this->formats['date'] = 'd.m.Y';
                $this->formats['date_placeholder'] = 'TT.MM.JJJJ';
                $this->formats['time'] = 'H:i';
                $this->formats['year_month'] = 'm.Y';
                $this->formats['chart_month_day'] = '%d.%m';
                $this->formats['chart_year_month'] = '%m.%y';
                $this->formats['time_with_seconds'] = 'H:i:s';
                $this->formats['datetime'] = 'd.m.Y H:i:s';
                $this->formats['currency'] = array(
                    'places' => 2,
                    'before' => '€ ',
                    'escape' => false,
                    'decimals' => ',',
                    'thousands' => '.'
                );
                break;
        }

    }


    public function beforeRender() {

        # set layout for the logged in section(s)
        if(($this->here != '/') && ($this->here != '/en') && ($this->here != '/de')) {
            $this->layout = 'authed';
        } else {
            $this->layout = 'default';
        }

        $this->set('formats', $this->formats);
        $this->set('config', $this->config);

        $this->set('firstPollId', $this->firstPollId);

        if($this->Session->check('Auth.User.id') && class_exists('User')) {
            $Poll = ClassRegistry::init('Poll');
            $statistics_list = $Poll->getSelectablePollsList(User::get('Account.id'), $this->locale, $plain = false, $show_ids = false);
            $this->set('statistics_list', $statistics_list);
        }
    }


    /**
    * create a PDF of a given billing and return the filename of the
    * temp file on disk (produces files with names like
    * 'invoice_<invoice_number>_<timestamp>.pdf'
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $invoice_id
    * @return string $filename or false
    */
    public function generateUpgradeInvoice($invoice_id = null) {
        if(!$invoice_id) {
            return false;
        }

        $Invoice = ClassRegistry::init('Invoice');
        $invoice = $Invoice->getInvoice($invoice_id);
        $polls = $Invoice->Poll->getPollsList($invoice['Invoice']['account_id'], $this->locale);
        $invoice['Invoice']['country_name'] = $Invoice->Country->getCountryName($invoice['Invoice']['country_id'], $this->locale);

        $filename = 'invoice_'.Configure::read('Invoice.number_prefix').$invoice['Invoice']['invoice_number'].'_'.md5(strtotime(date('Y-m-d H:i:s'))).'.pdf';

        $formats = $this->formats;

        $genders = $Invoice->Account->User->getGenders();

        $this->set(compact('currency', 'formats', 'genders', 'invoice', 'filename', 'polls'));

        # define pdf settings
        $this->layout = 'pdf';

        #$this->autoRender = false;
        App::import('Vendor','xtcpdf');
        $tcpdf = new XTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $tcpdf->SetCreator(PDF_CREATOR);
        $tcpdf->SetAuthor("guestify.net");
        $tcpdf->SetTitle('guestify Invoice');
        $tcpdf->SetSubject('Invoice #'  . $invoice['Invoice']['invoice_number']);
        $tcpdf->setHeaderFont(array('freesans','',40));
        $tcpdf->xheadercolor = array(255,255,255);
        $tcpdf->xheadertext = 'Michael Bisse . 4030 Wake Forest Road STE 439 . Raleigh . NC, 27609 . USA';
        $tcpdf->xfootertext = 'Michael Bisse . 4030 Wake Forest Road STE 439 . Raleigh . NC, 27609 . USA . Email: info@guestify.net . Web: www.guestify.net . T: 012345678 . F: 012345678';
        $tcpdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);
        $tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $tcpdf->setCellPaddings(0,0,0,0);
        $tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $tcpdf->AddPage();

        $View = new View($this, false);
        $html = $View->element("Invoices/invoice_pdf");

        $tcpdf->writeHTML($html, true, false, true, false, '');
        $tcpdf->Output(APP. 'files/'.$filename, 'F');

        return $filename;
    }


    /**
    * set global config parameters
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function setMainConfig() {
        // SET LOCAL TAXES
        $this->config['tax_percent_standard']           = 4.75;
        $this->config['tax_percent_standard_multiply']  = 1.475;
        $this->config['tax_percent_standard_divider']   = 1.475;

        // SET PERIOD PRICES
        $this->config['prices'] = array(
            'm' => 9.99, // 1 month
            'h' => 75.00, // 1/2 year
            'y' => 145.00, // 1 year
        );

        // SET PERIOD SPANS
        $this->config['periods'] = array(
            'm' => '+ 1 month',
            'h' => '+ 6 month',
            'y' => '+ 1 year',
        );

        // SET PERIOD NAMES
        $this->config['periods_by_name'] = array(
            'm' => '1 Month',
            'h' => '6 Months',
            'y' => '1 Year'
        );

        return;
    }


    public function setupLocale() {

        $here = $this->here;

        // setup locale
        if(!$this->Session->check('Auth.User.id')) {

            $locale = '';

            if($here == '/') {

                $locale = 'eng';

            } elseif(($here == '/de') || strpos($this->here, '/de/') !== false) {

                $locale = 'deu';

            } elseif(($here == '/en') || strpos($this->here, '/en/') !== false) {

                $locale = 'eng';

            } else {

                $locale = $this->Session->read('Config.language');

                if(empty($locale) && ($this->here == '/')) {

                    // if(empty($locale)) {
                    //     $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
                    //     switch ($lang){
                    //         case "en":
                    //             $locale = 'eng';
                    //             break;
                    //         case "de":
                    //             $locale = 'deu';
                    //             break;
                    //         default:
                    //             $locale = Configure::read('Language.default');
                    //             break;
                    //     }
                    // }

                    $locale = 'eng';

                } else {

                    // if(empty($locale)) {
                    //     $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
                    //     switch ($lang){
                    //         case "en":
                    //             $locale = 'eng';
                    //             break;
                    //         case "de":
                    //             $locale = 'deu';
                    //             break;
                    //         default:
                    //             $locale = Configure::read('Language.default');
                    //             break;
                    //     }
                    // }
                }
            }
        } else {
            $locale = $this->Session->read('Config.language');
        }


        if(empty($locale)) {
            $locale = Configure::read('Language.default');
        }

        Configure::write('Config.language', $locale);
        $this->Session->write('Config.language', $locale);

        $this->locale = $locale;

        $locale = Configure::read('Language.default');

        return $locale;
    }


}
