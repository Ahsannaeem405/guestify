<?php
/**
 * AccountFixture
 *
 */
class AccountFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
	public $import = array('table' => 'accounts');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'company_name' => 'guestify Headquarters',
			'address' => 'Hansaring 4',
			'zipcode' => '50670',
			'city' => 'Köln',
			'country_id' => '1',
			'phone' => null,
			'mobile' => null,
			'fax' => null,
			'ust_id' => null,
			'subdomain' => 'backend',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'deleted' => 0
		),
		array(
			'id' => '2',
			'company_name' => 'FHW Gastronomie GmbH',
			'address' => 'Frankenwerft 19',
			'zipcode' => '50667',
			'city' => 'Köln',
			'country_id' => '1',
			'phone' => '+49 (0) 221 947 24 00',
			'mobile' => '',
			'fax' => '+49 (0) 221 947 24 02',
			'ust_id' => '123',
			'subdomain' => 'haxenhaus',
			'created' => '0000-00-00 00:00:00',
			'modified' => '2014-10-05 18:11:15',
			'deleted' => 0
		),
		array(
			'id' => '3',
			'company_name' => 'Company Name2',
			'address' => '',
			'zipcode' => '',
			'city' => '',
			'country_id' => '1',
			'phone' => '',
			'mobile' => '',
			'fax' => '',
			'ust_id' => null,
			'subdomain' => '',
			'created' => '2014-10-07 01:39:26',
			'modified' => '2015-07-08 13:29:35',
			'deleted' => 0
		),
		array(
			'id' => '4',
			'company_name' => 'Pizza Luigi',
			'address' => 'Musterweg 1',
			'zipcode' => '12345',
			'city' => 'Köln',
			'country_id' => '1',
			'phone' => '',
			'mobile' => '',
			'fax' => '',
			'ust_id' => null,
			'subdomain' => '',
			'created' => '2015-06-16 13:56:13',
			'modified' => '2015-06-16 13:56:13',
			'deleted' => 0
		),
		array(
			'id' => '5',
			'company_name' => 'Pizzeria Tomato GmbH',
			'address' => 'Richard-Wagner-Strasse 1',
			'zipcode' => '50674',
			'city' => 'Köln',
			'country_id' => '1',
			'phone' => null,
			'mobile' => null,
			'fax' => null,
			'ust_id' => null,
			'subdomain' => '',
			'created' => '2015-07-20 09:29:32',
			'modified' => '2015-07-20 09:30:36',
			'deleted' => 0
		),
		array(
			'id' => '6',
			'company_name' => 'Würstchenbude',
			'address' => 'Am Nil 5469',
			'zipcode' => '99586',
			'city' => 'Kairo',
			'country_id' => '65',
			'phone' => null,
			'mobile' => null,
			'fax' => null,
			'ust_id' => null,
			'subdomain' => '',
			'created' => '2015-10-29 12:28:10',
			'modified' => '2015-10-29 12:29:51',
			'deleted' => 0
		),
	);

}
