<?php
/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
	public $import = array('table' => 'users');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'account_id' => '1',
			'role_id' => '1',
			'gender' => 0,
			'lastname' => 'Admin',
			'firstname' => 'Admin',
			'email' => 'appadmin@guestify.net',
			'password' => '5b981ba800f7c228159b34ddc7e18890478d79a8',
			'user_pin' => '987654321',
			'last_login' => '2015-09-15 11:50:38',
			'status' => '1',
			'locale' => 'deu',
			'activation_hash' => null,
			'valid_until' => null,
			'welcome_mail_count' => '0',
			'created' => '0000-00-00 00:00:00',
			'modified' => '2015-09-15 11:50:38',
			'deleted' => 0
		),
		array(
			'id' => '2',
			'account_id' => '2',
			'role_id' => '2',
			'gender' => 0,
			'lastname' => 'Nachname',
			'firstname' => 'Vorname1',
			'email' => 'haxenhaus@guestify.net',
			'password' => 'efc1d61bb17fe84c0cd49a02d3bf03ff7a1d1c00',
			'user_pin' => '43435',
			'last_login' => '2015-09-15 15:20:29',
			'status' => '1',
			'locale' => 'deu',
			'activation_hash' => null,
			'valid_until' => null,
			'welcome_mail_count' => '0',
			'created' => '0000-00-00 00:00:00',
			'modified' => '2015-09-15 15:20:29',
			'deleted' => 0
		),
		array(
			'id' => '3',
			'account_id' => '3',
			'role_id' => '2',
			'gender' => 0,
			'lastname' => 'Lastname',
			'firstname' => 'Firstname',
			'email' => 'e.blumstengel@gmail.com',
			'password' => '51e309daf2cec086f9c037ccf21e972e47bde4fd',
			'user_pin' => '12345',
			'last_login' => '2015-07-08 13:34:33',
			'status' => '1',
			'locale' => 'deu',
			'activation_hash' => 'cea95a582c38f9dab1e3527b93df04dd3',
			'valid_until' => '2015-06-22 20:57:53',
			'welcome_mail_count' => '1',
			'created' => '2014-10-07 01:39:26',
			'modified' => '2015-07-08 13:34:33',
			'deleted' => 0
		),
		array(
			'id' => '4',
			'account_id' => '4',
			'role_id' => '2',
			'gender' => 0,
			'lastname' => 'Test',
			'firstname' => 'Test',
			'email' => 'jean.wichert@gmail.com',
			'password' => '451801c7592158ae4cd27878e71613149c3b0fb4',
			'user_pin' => '12345',
			'last_login' => null,
			'status' => '1',
			'locale' => 'deu',
			'activation_hash' => null,
			'valid_until' => '2015-06-16 14:00:27',
			'welcome_mail_count' => '1',
			'created' => '2015-06-16 13:56:13',
			'modified' => '2015-06-16 14:00:27',
			'deleted' => 0
		),
		array(
			'id' => '5',
			'account_id' => '5',
			'role_id' => '2',
			'gender' => 0,
			'lastname' => 'Tomato',
			'firstname' => 'Luigi',
			'email' => 'jean.wichert+luigi@gmail.com',
			'password' => '451801c7592158ae4cd27878e71613149c3b0fb4',
			'user_pin' => '11111',
			'last_login' => '2015-07-20 09:29:33',
			'status' => '1',
			'locale' => 'eng',
			'activation_hash' => '0abc91703d39a67a2f84bc23cd92a2cb5',
			'valid_until' => '2015-07-28 13:09:37',
			'welcome_mail_count' => '1',
			'created' => '2015-07-20 09:29:32',
			'modified' => '2015-07-21 13:09:38',
			'deleted' => 0
		),
		array(
			'id' => '6',
			'account_id' => '6',
			'role_id' => '2',
			'gender' => 0,
			'lastname' => 'Wurst',
			'firstname' => 'Hans',
			'email' => 'poloparts@gmx.de',
			'password' => 'b469f4d37b644705bb85b13ae41bab7095431389',
			'user_pin' => '11111',
			'last_login' => '2016-02-02 14:21:37',
			'status' => '1',
			'locale' => 'eng',
			'activation_hash' => 'f3109b7e8db68943778617ef5cd358ae',
			'valid_until' => '2015-11-05 12:28:10',
			'welcome_mail_count' => '0',
			'created' => '2015-10-29 12:28:10',
			'modified' => '2016-02-02 14:21:37',
			'deleted' => 0
		),
	);

}
