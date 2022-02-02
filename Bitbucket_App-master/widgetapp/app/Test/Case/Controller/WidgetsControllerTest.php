<?php
App::uses('I18n', 'I18n');
App::uses('Widget', 'Model');

/**
 * Widget Test Case
 *
 */
class WidgetsControllerTest extends ControllerTestCase {

	/**
 	* Fixtures
 	*
 	*@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @var array
 	*/
	public $fixtures = array(
		'app.answer',
		'app.guest',
		'app.host',
		'app.poll',
		'app.question',
		'app.translate',
		'app.widget',
		'app.widget_element'
	);

	/**
 	* setUp method
 	*
 	*@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function setUp() {
		parent::setUp();
		Cache::delete('object_map', '_cake_core_');
		$this->Widget = ClassRegistry::init('Widget');
	}


	/**
 	* tearDown method
 	*
 	*@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function tearDown() {
		unset($this->Widget);
		parent::tearDown();
	}


	/**
 	* testDeactivated method, checks if redirect is correct
 	*
 	*@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testDeactivated() {
		$this->testAction('/widgets/deactivated', array(
				'return' => 'view'
			));
		$this->assertRegExp('/Sorry, the widget is not active!/', $this->view);
	}


	/**
 	* testShow method, checking a complete widget with all possible
 	* widgetelemets and two failure redirects
 	* tested with: proper hash, wrong hash, no hash
 	*
 	*@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testShow() {
		$expected = array(
			'widget' => array(
	    		'Widget' => array(
		            'account_id' => '6',
		            'poll_id' => '12',
		            'name' => 'MyWidget',
		            'period' => 'month_6',
		            'format' => 'landscape',
		            'width' => '500',
		            'height' => '200',
		            'style' => 'standard',
		            'id' => '1',
		            'gsi' => 6.1,
		            'ratingcount' => 11,
		            'ratinglabel' => '<small class="text-center label label-warning gsi-base">Average</small>',
		            'select_comment_count' => 'last10',
		            'trend' => array(
	                    'month' => array(
	                        '2015-08' => 0,
	                        '2015-09' => 7.3,
	                        '2015-10' => 8.3,
	                        '2015-11' => 5.6,
	                        '2015-12' => 0,
	                        '2016-01' => 0,
	                        '2016-02' => 0
	                    )
					),
		            'comments' => array(
	                    0 => array(
	                        'Guest' => array(
	                            'id' => '36',
	                            'comment_customer' => '',
	                            'name' => null,
	                            'ip' => '127.0.0.1',
	                            'created' => '2015-11-25 18:00:00',
	                            'gsi' => 8.3
	                        )
	                    ),

	                    1 => array(
	                        'Guest' => array(
	                            'id' => '35',
	                            'comment_customer' => '',
	                            'name' => null,
	                            'ip' => '127.0.0.1',
	                            'created' => '2015-11-25 18:00:00',
	                            'gsi' => 7.1
	                        )
	                    ),

	                    2 => array(
	                        'Guest' => array(
	                            'id' => '37',
	                            'comment_customer' => '',
	                            'name' => null,
	                            'ip' => '127.0.0.1',
	                            'created' => '2015-11-25 12:00:00',
	                            'gsi' => 7.1
	                        )
	                    ),

	                    3 => array(
	                        'Guest' => array(
	                            'id' => '40',
	                            'comment_customer' => '',
	                            'name' => null,
	                            'ip' => '127.0.0.1',
	                            'created' => '2015-11-24 18:00:00',
	                            'gsi' => 2.5
	                        )
	                    ),

	                    4 => array(
	                        'Guest' => array(
	                            'id' => '39',
	                            'comment_customer' => '',
	                            'name' => null,
	                            'ip' => '127.0.0.1',
	                            'created' => '2015-11-24 18:00:00',
	                            'gsi' => 2.5
	                        )
	                    ),

	                    5 => array(
	                        'Guest' => array(
	                            'id' => '38',
	                            'comment_customer' => '',
	                            'name' => null,
	                            'ip' => '127.0.0.1',
	                            'created' => '2015-11-24 12:00:00',
	                            'gsi' => 2.5
	                        )
	                    ),

	                    6 => array(
	                        'Guest' => array(
	                            'id' => '26',
	                            'comment_customer' => 'naja das geht aber besser! definitiv!',
	                            'name' => '',
	                            'ip' => '127.0.0.1',
	                            'created' => '2015-11-23 15:25:44',
	                            'gsi' => 5.8
	                        )
	                    ),

	                    7 => array(
	                        'Guest' => array(
	                            'id' => '25',
	                            'comment_customer' => 'wie immer super! weiter so!',
	                            'name' => '',
	                            'ip' => '127.0.0.1',
	                            'created' => '2015-11-23 15:24:51',
	                            'gsi' => 10.0
	                        )
	                    ),

	                    8 => array(
	                        'Guest' => array(
	                            'id' => '24',
	                            'comment_customer' => 'gerne wieder :)',
	                            'name' => '',
	                            'ip' => '127.0.0.1',
	                            'created' => '2015-11-23 15:24:07',
	                            'gsi' => 8.3
	                        )
	                    ),

	                    9 => array(
	                        'Guest' => array(
	                            'id' => '23',
	                            'comment_customer' => 'erste und letzte mal hier!!!!',
	                            'name' => '',
	                            'ip' => '127.0.0.1',
	                            'created' => '2015-11-23 15:23:17',
	                            'gsi' => 3.3
	                        )
						)
	                )
		        ),

			    'Host' => array(
			        'id' => '7',
			        'name' => 'Lummerbratenhaus',
			        'logo' => null
			    )
			)	
		);
		
		$this->testAction('/widgets/show/587d5138fb8e1a6a35f6');
		$this->assertEquals($expected, $this->vars);

		$this->testAction('/widgets/show/11111111111111111111');
		$this->assertContains('/deactivated', $this->headers['Location']);

		$this->testAction('/widgets/show');
		$this->assertContains('/deactivated', $this->headers['Location']);
	}

}
