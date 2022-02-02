<?php
/**
 * LogsEmails controller
 *
 * @package app
 * @subpackage controllers
 */
class LogsEmailsController extends AppController {

    public $name = 'LogsEmails';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(
            'logger_email'
        ));
    }



    /**
    * catch, read and save any incoming logger-notifications
    * from the Amazon SNS service
    * 
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function logger_email() {

        #$post = '{"Type" : "Notification","MessageId" : "0b666407-5aae-5128-95cc-29c191621e44","TopicArn" : "arn:aws:sns:eu-west-1:458055026501:Email-Notifications","Message" : "{\"notificationType\":\"Delivery\",\"mail\":{\"timestamp\":\"2015-05-08T14:34:50.787Z\",\"source\":\"noreply@cooltra.com\",\"messageId\":\"0000014d33f34623-4331536e-6c01-4bc9-a162-118db51efb8e-000000\",\"destination\":[\"e.blumstengel@gmail.com\"]},\"delivery\":{\"timestamp\":\"2015-05-08T14:34:52.339Z\",\"processingTimeMillis\":1552,\"recipients\":[\"e.blumstengel@gmail.com\"],\"smtpResponse\":\"250 2.0.0 OK 1431095692 s4si13060214wix.58 - gsmtp\",\"reportingMTA\":\"a6-225.smtp-out.eu-west-1.amazonses.com\"}}","Timestamp" : "2015-05-08T14:34:52.475Z","SignatureVersion" : "1","Signature" : "QDOTfyY0k2qzcADfkl//kO7Zj0sBdeW5U+1TWr7jYtbvv8E2br4Fi94Q8u/QQF+jzeM4FrGPQfgkCyh7AXHWmkI2iow8Q0Ke4/f3HFwcChM1XdrdLI+q0jhtcuEqJ0id4hbZ6sbSx9iAFHoP0/YgMmNpDwxvz34xsuHQaMmhZcBB97TDR89YcKKzcBUduVUUSq/TquxFWyMWEq8sxt14TJfb29j+EEUTKf7oVP/lGilwcjNuRWLDAcbrq0jn62BPQ2t44OPALPWanx/GIngbClZ+K8/t9HX5bgNNU/3RPjm5S5TKwsHTWFjHD+6GlIb40YGASkLzhiuK2/+QCd2UUw==","SigningCertURL" : "https://sns.eu-west-1.amazonaws.com/SimpleNotificationService-d6d679a1d18e95c2f9ffcf11f4f9e198.pem","UnsubscribeURL" : "https://sns.eu-west-1.amazonaws.com/?Action=Unsubscribe&SubscriptionArn=arn:aws:sns:eu-west-1:458055026501:Email-Notifications:61c1dd3c-5084-47c5-8b45-4acc28db5163"}';
        #$post = json_decode($post, true);

        $post = json_decode(file_get_contents('php://input'), true);
        $this->LogsEmail->log($post, 'notifications_sns');

        if(empty($post)) {
            header('Status: 200');
            exit(0);
        }

        $record = array();

        # remap the data
        if(isset($post['Type'])) {
            $record['type'] = $post['Type'];
        }
        if(isset($post['MessageId'])) {
            $record['message_id'] = $post['MessageId'];
        }
        if(isset($post['TopicArn'])) {
            $record['topic_arn'] = $post['TopicArn'];
        }

        if(isset($post['Message'])) {
            $post['Message'] = json_decode($post['Message'], true);
        }

        if(isset($post['Message']['notificationType'])) {
            $record['notification_type'] = $post['Message']['notificationType'];
        }

        if(isset($post['Message']['mail']['timestamp'])) {
            $record['mail_timestamp'] = $post['Message']['mail']['timestamp'];
        }
        if(isset($post['Message']['mail']['source'])) {
            $record['mail_source'] = $post['Message']['mail']['source'];
        }
        if(isset($post['Message']['mail']['messageId'])) {
            $record['mail_message_id'] = $post['Message']['mail']['messageId'];
        }
        if(isset($post['Message']['mail']['destination'])) {
            $record['mail_destination'] = json_encode($post['Message']['mail']['destination']);
        }


        # sub-object "delivery" for type "Delivery"
        if(isset($post['Message']['delivery']['timestamp'])) {
            $record['delivery_timestamp'] = $post['Message']['delivery']['timestamp'];
        }
        if(isset($post['Message']['delivery']['processingTimeMillis'])) {
            $record['delivery_processing_time'] = $post['Message']['delivery']['processingTimeMillis'];
        }
        if(isset($post['Message']['delivery']['recipients'])) {
            $record['delivery_recipients'] = json_encode($post['Message']['delivery']['recipients']);
        }
        if(isset($post['Message']['delivery']['smtpResponse'])) {
            $record['delivery_smtp_response'] = $post['Message']['delivery']['smtpResponse'];
        }
        if(isset($post['Message']['delivery']['reportingMTA'])) {
            $record['delivery_reporting_mta'] = $post['Message']['delivery']['reportingMTA'];
        }

        # sub-object "bounce" for type "Bounce"
        # ......

        # sub-object "complaint" for type "Complaint"
        # ......

        if(isset($post['Timestamp'])) {
            $record['timestamp'] = $post['Timestamp'];
        }
        if(isset($post['SignatureVersion'])) {
            $record['signature_version'] = $post['SignatureVersion'];
        }
        if(isset($post['Signature'])) {
            $record['signature'] = $post['Signature'];
        }
        if(isset($post['SigningCertURL'])) {
            $record['signing_cert_url'] = $post['SigningCertURL'];
        }
        if(isset($post['UnsubscribeURL'])) {
            $record['unsubscribe_url'] = $post['UnsubscribeURL'];
        }

        $record['data_origin'] = json_encode($post);

        $LogsEmail = ClassRegistry::init('LogsEmail');
        $LogsEmail->log($record, 'notifications_sns_formatted');

        $LogsEmail->create();
        $LogsEmail->save($record);

        header('Status: 200');
        exit(0);
    }


    /**
    * delete a log entry record
    * 
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $id
    * @return void
    */
    public function delete($id = null) {
        if(!$id) {
            $this->Session->setFlash(__('Invalid Id!', true), 'default', array('class' => 'negative'));
            $this->redirect($this->referer());
        }
        
        $this->LogsEmail->id = $id;
        if($this->LogsEmail->saveField('deleted', 1)) {
            $this->Session->setFlash(__('Log deleted!', true), 'default', array('class' => 'positive'));
            $this->redirect($this->referer());
        } else {
            $this->Session->setFlash(__('Could not delete log!', true), 'default', array('class' => 'negative'));
            $this->redirect($this->referer());
        }
    }


    /**
    * view all redirects within system in a paginated list
    * 
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function index() {

        $this->paginate['LogsEmail'] = array(
            'conditions' => array(
                'LogsEmail.deleted' => 0
            ),
            'fields' => array(
                'LogsEmail.id',
                'LogsEmail.type',
                'LogsEmail.notification_type',
                'LogsEmail.mail_timestamp',
                'LogsEmail.mail_source',
                'LogsEmail.mail_destination',
                'LogsEmail.delivery_timestamp',
                'LogsEmail.delivery_processing_time',
                'LogsEmail.delivery_recipients',
                'LogsEmail.delivery_smtp_response'
            ),
            'order' => 'LogsEmail.id DESC',
            'limit' => 30
        );
        
        $logs_emails = $this->paginate('LogsEmail');
        
        $this->set(compact('logs_emails'));
    }


    /**
    * view an email log entry
    * 
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param int $id
    * @return void
    */
    public function view($id = null) {
        if(!$id) {
            $this->Session->setFlash(__('Invalid Id!', true), 'default', array('class' => 'negative'));
            $this->redirect($this->referer());
        }

        $log = $this->LogsEmail->find('first', array(
            'conditions' => array(
                'LogsEmail.deleted' => 0,
                'LogsEmail.id' => $id
            )
        ));

        $this->set(compact('log'));
    }

}

