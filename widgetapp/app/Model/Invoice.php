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

}
