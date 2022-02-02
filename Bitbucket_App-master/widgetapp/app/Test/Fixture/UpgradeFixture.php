<?php
/**
 * UpgradeFixture
 *
 */
class UpgradeFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
	public $import = array('table' => 'upgrades');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'account_id' => '3',
			'host_id' => '3',
			'poll_id' => '9',
			'valid_from' => '2015-07-08 13:29:51',
			'valid_until' => '2016-07-08 13:29:51',
			'created' => '2015-07-08 13:29:51',
			'modified' => '2015-07-08 13:29:51',
			'deleted' => 0
		),
		array(
			'id' => '2',
			'account_id' => '5',
			'host_id' => '5',
			'poll_id' => '10',
			'valid_from' => '2015-07-20 09:31:48',
			'valid_until' => '2016-07-20 09:31:48',
			'created' => '2015-07-20 09:31:48',
			'modified' => '2015-07-20 09:31:48',
			'deleted' => 0
		),
		array(
			'id' => '3',
			'account_id' => '6',
			'host_id' => '6',
			'poll_id' => '11',
			'valid_from' => '2015-10-29 12:32:04',
			'valid_until' => '2016-10-29 12:32:04',
			'created' => '2015-10-29 12:32:04',
			'modified' => '2015-10-29 12:32:04',
			'deleted' => 0
		),
	);

}
