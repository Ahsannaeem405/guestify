<?php
/**
 * Payment model
 *
 * @package app
 * @subpackage models
 */
class PaymentPP extends AppModel {

    public $name = 'PaymentPP';

    public $useTable = 'payments_pp';

    public $belongsTo = array(
        'Account',
        'Host',
        'Invoice',
        'Poll',
        'User'
    );

    public $actsAs = array(
        'Containable'
    );


}
