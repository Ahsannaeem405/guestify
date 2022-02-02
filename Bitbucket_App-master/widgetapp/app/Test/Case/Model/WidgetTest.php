<?php
App::uses('I18n', 'I18n');
App::uses('Widget', 'Model');

/**
 * Widget Test Cases
 *
 */
class WidgetTest extends CakeTestCase {

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
	* Call protected/private method of a class.
	*
	*@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @param object &$object    Instantiated object that we will run method on.
	* @param string $methodName Method name to call
	* @param array  $parameters Array of parameters to pass into method.
	* @return mixed Method return.
	*/
	public function invokeMethod(&$object, $methodName, array $parameters = array())
	{
	    $reflection = new \ReflectionClass(get_class($object));
	    $method = $reflection->getMethod($methodName);
	    $method->setAccessible(true);

	    return $method->invokeArgs($object, $parameters);
	}



	/**
    * testCalculateGsiForComments method, invoke needed because function is private
    * pass to invoke: Object, methodname, parameter for method in an array
    * input is a guest-entry with its answers to a poll
    * tested with: proper input, no input
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
    */
    public function testCalculateGsiForComments(){
        $input = array(
            '0' => array(
                'Guest' => array(
                    'id' => 36,
                    'comment_customer' => 'testcomment1',
                    'name' => 'testguest1',
                    'ip' => '127.0.0.1',
                    'created' => '2015-11-25 18:00:00'
                ),

                'Answer' => array(
                    '0' => array(
                        'rating' => 2,
                        'Question' => array(
                            'scale' => 4,
                        )
                    ),

                    '1' => array(
                        'rating' => 2,
                        'Question' => array(
                            'scale' => 4,
                        )
                    ),

                    '2' => array(
                        'rating' => 2,
                        'Question' => array(
                            'scale' => 4,
                        )
                    ),

                    '3' => array(
                        'rating' => 2,
                        'Question' => array(
                            'scale' => 4,
                        )
                    ),

                    '4' => array(
                        'rating' => 2,
                        'Question' => array(
                            'scale' => 4,
                        )
                    ),

                    '5' => array(
                        'rating' => 2,
                        'Question' => array(
                            'scale' => 4,
                        )
                    )
                )
            ),

            '1' => array(
                'Guest' => array(
                    'id' => 35,
                    'comment_customer' => 'testcomment2',
                    'name' => 'testguest2',
                    'ip' => '127.0.0.1',
                    'created' => '2015-11-25 18:00:00'
                ),

                'Answer' => array(
                    '0' => array(
                        'rating' => 1,
                        'Question' => array(
                            'scale' => 4,
                        )
                    ),

                    '1' => array(
                        'rating' => 1,
                        'Question' => array(
                            'scale' => 4,
                        )
                    ),

                    '2' => array(
                        'rating' => 2,
                        'Question' => array(
                            'scale' => 4,
                        )
                    ),

                    '3' => array(
                        'rating' => 2,
                        'Question' => array(
                            'scale' => 4,
                        )
                    ),

                    '4' => array(
                        'rating' => 3,
                        'Question' => array(
                            'scale' => 4,
                        )
                    ),

                    '5' => array(
                        'rating' => 3,
                        'Question' => array(
                            'scale' => 4,
                        )
                    )
                )
            )
        );

        $expected = array(
            '0' => array(
                'Guest' => array(
                    'id' => 36,
                    'comment_customer' => 'testcomment1',
                    'name' => 'testguest1',
                    'ip' => '127.0.0.1',
                    'created' => '2015-11-25 18:00:00',
                    'gsi' => 5
                )
            ),

            '1' => array(
                'Guest' => array(
                    'id' => 35,
                    'comment_customer' => 'testcomment2',
                    'name' => 'testguest2',
                    'ip' => '127.0.0.1',
                    'created' => '2015-11-25 18:00:00',
                    'gsi' => 5
                )
            )
        );

        $result = $this->invokeMethod($this->Widget, 'calculateGsiForComments', array($input));
        $this->assertEquals($expected, $result);
        
        $result = $this->invokeMethod($this->Widget, 'calculateGsiForComments', array(''));
        $this->assertFalse($result);
    }


    /**
 	* testGetStartDate method, pass period and poll_id
    * tested with: proper input pair, wrong period, no poll_id
 	*
 	*@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetStartDate(){
		$result = $this->Widget->getStartDate('month_3', 1);
		$today = date('Y-m-d');
		$expected = date('Y-m-d', strtotime($today . ' - 3 month'));
		$this->assertEquals($expected, $result);

		$result = $this->Widget->getStartDate('month_5', 1);
		$this->assertFalse($result);

		$result = $this->Widget->getStartDate('month_3');
		$this->assertFalse($result);
	}
	

	/**
 	* testGetWidgetElementTypesKeys method, checked if the returned
    * array has all the right entries
 	*
 	*@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetWidgetElementTypesKeys(){
		$expected = array(
	            'gsi',
	            'trend',
	            'ratingcount',
	            'ratinglabel'
			);

		$result = $this->Widget->getWidgetElementTypesKeys();
		$this->assertEquals($expected, $result);
	}


	/**
 	* testGetByHash method, check views of widget before getting the widget,
    * getting a complete widget with all possible widgetelements by submitting
    * a proper hash and than checking the views for the widget again,
    * tested with: proper hash, wrong hash, no hash
 	*
 	*@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetByHash(){
		$expected = array(
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
	        //trend needs to be changed depending on the date of testing
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
            //comments are depending on the db entries, and might be subject to change
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
		);	
		
		$this->Widget->id = 1;
		$viewsBefore = $this->Widget->field('views');
		$result = $this->Widget->getByHash('587d5138fb8e1a6a35f6');
		$viewsAfter = $this->Widget->field('views');
		$this->assertEquals($expected, $result);
		//checking if view got increased by getting the widget
        $this->assertEquals($viewsBefore +1, $viewsAfter);

		$result = $this->Widget->getByHash('malicious data');
		$this->assertFalse($result);

		$result = $this->Widget->getByHash();
		$this->assertFalse($result);
	}


	/**
 	* testFindByHash method, invoke needed because function is private
    * pass to invoke: Object, methodname, parameter for method in an array
    * tested with: proper hash, no hash, wrong hash
 	*
 	*@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testFindByHash(){
		$result = $this->invokeMethod($this->Widget, 'findByHash', array('587d5138fb8e1a6a35f6'));
		$this->assertTrue($result);

		$result = $this->invokeMethod($this->Widget, 'findByHash', array(''));
		$this->assertFalse($result);

		$result = $this->invokeMethod($this->Widget, 'findByHash', array('fakehashnumber'));
		$this->assertFalse($result);
	}


	/**
 	* testGetComments method, invoke needed because function is private
    * pass to invoke: Object, methodname, parameter for method in an array,
    * build two expected arrays, one for last comment
    * branch and one for top comment branch,
    * tested with: two proper inputs, no input
 	*
 	*@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetComments(){
		$expected = array(
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
        );

        $expected2 = array(
            '0' => array(
                'Guest' => array(
                    'id' => 25,
                    'comment_customer' => 'wie immer super! weiter so!',
                    'name' => null,
                    'created' => '2015-11-23 15:24:51',
                    'gsi' => 10
                )
            ),

            '1' => array(
                'Guest' => array(
                    'id' => 22,
                    'comment_customer' => 'wie immer super, nur das wetter war heute nicht so toll ;)',
                    'name' => null,
                    'created' => '2015-11-23 15:22:22',
                    'gsi' => 9.6
                )
            ),

            '2' => array(
                'Guest' => array(
                    'id' => 36,
                    'comment_customer' => null,
                    'name' => null,
                    'created' => '2015-11-25 18:00:00',
                    'gsi' => 8.3
                )
            ),

            '3' => array(
                'Guest' => array(
                    'id' => 24,
                    'comment_customer' => 'gerne wieder :)',
                    'name' => null,
                    'created' => '2015-11-23 15:24:07',
                    'gsi' => 8.3
                )
            ),

            '4' => array(
                'Guest' => array(
                    'id' => 21,
                    'comment_customer' => 'War OK, danke!',
                    'name' => null,
                    'created' => '2015-11-23 15:19:56',
                    'gsi' => 7.5
                )
            )
        );

		$result = $this->invokeMethod($this->Widget, 'getComments', array('last10', 'month_6', '12'));
		$this->assertEquals($expected, $result);

		$result = $this->invokeMethod($this->Widget, 'getComments', array(''));
		$this->assertFalse($result);

		$result = $this->invokeMethod($this->Widget, 'getComments', array('top5', 'month_6', '12'));
        $this->assertEquals($expected2, $result);
	}


    /**
    * testGetGsi method, invoke needed because functions is private
    * pass to invoke: Object, methodname, parameter for method in an array
    * tested with: two proper inputs, no poll_id, no period type
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
    */
    public function testGetGsi(){
        $result = $this->invokeMethod($this->Widget, 'getGsi', array('month_6', '11'));
        $this->assertEquals(6.8, $result);
        
        $result = $this->invokeMethod($this->Widget, 'getGsi', array('all', '2'));
        $this->assertEquals(0, $result);

        $result = $this->invokeMethod($this->Widget, 'getGsi', array('month_6', ''));
        $this->assertFalse($result);

        $result = $this->invokeMethod($this->Widget, 'getGsi', array('', '11'));
        $this->assertFalse($result);
    }


    /**
    * testGetRatingCount method, invoke needed because functions is private
    * pass to invoke: Object, methodname, parameter for method in an array
    * tested with: two proper inputs, no poll_id, no period type 
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
    */
    public function testGetRatingCount(){
        $result = $this->invokeMethod($this->Widget, 'getRatingCount', array('month_6', '11'));
        $this->assertEquals(8, $result);
        
        $result = $this->invokeMethod($this->Widget, 'getRatingCount', array('all', '2'));
        $this->assertEquals(0, $result);

        $result = $this->invokeMethod($this->Widget, 'getRatingCount', array('month_6', ''));
        $this->assertFalse($result);

        $result = $this->invokeMethod($this->Widget, 'getRatingCount', array('', '11'));
        $this->assertFalse($result);
    }


    /**
    * testGetReviewlabel method, invoke needed because functions is private
    * pass to invoke: Object, methodname, parameter for method in an array
    * tested with: one proper input, three critical value inputs 
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
    */
    public function testGetReviewlabel(){
        $result = $this->invokeMethod($this->Widget, 'getReviewlabel', array('10'));
        $this->assertEquals('<small class="text-center label label-success gsi-base">Amazing!</small>', $result);
        
        $result = $this->invokeMethod($this->Widget, 'getReviewlabel', array('0'));
        $this->assertEquals('<small class="text-center label label-default gsi-base">No rating</small>', $result);

        $result = $this->invokeMethod($this->Widget, 'getReviewlabel', array('11'));
        $this->assertFalse($result);

        $result = $this->invokeMethod($this->Widget, 'getReviewlabel', array('-1'));
        $this->assertFalse($result);
    }


    /**
    * testGetTrend method, invoke needed because functions is private
    * pass to invoke: Object, methodname, parameter for method in an array
    * !!!expected arrays are subject to change, depending on the date of testing!!! 
    * especially the testcase with the period of week_1!!! positive testcases 3 & 4 were 
    * added to increase code coverage
    * tested with: four proper inputs, no poll_id, no period, no account_id, wrong period
    *
    *@author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
    */
    public function testGetTrend(){
        $today = date('Y-m-d');
        
        $expected1 = array(
            'month' => array(
                '2015-02' => 0,
                '2015-03' => 0,
                '2015-04' => 0,
                '2015-05' => 0,
                '2015-06' => 0,
                '2015-07' => 0,
                '2015-08' => 0,
                '2015-09' => 7.3,
                '2015-10' => 8.3,
                '2015-11' => 5.6,
                '2015-12' => 0,
                '2016-01' => 0,
                '2016-02' => 0
            )
        );
        $result = $this->invokeMethod($this->Widget, 'getTrend', array('6', 'year_1', '12'));
        $this->assertEquals($expected1, $result);
        
        $expected2 = $expected1;
        unset($expected2['month']['2015-02']);
        unset($expected2['month']['2015-03']);
        unset($expected2['month']['2015-04']);
        unset($expected2['month']['2015-05']);
        unset($expected2['month']['2015-06']);
        unset($expected2['month']['2015-07']);

        $result = $this->invokeMethod($this->Widget, 'getTrend', array('6', 'month_6', '12'));
        $this->assertEquals($expected2, $result);

        $expected3 = array(
            'day' => array(
                date('Y-m-d', strtotime($today . ' - 6 day')) => 0,
                date('Y-m-d', strtotime($today . ' - 5 day')) => 0,
                date('Y-m-d', strtotime($today . ' - 4 day')) => 0,
                date('Y-m-d', strtotime($today . ' - 3 day')) => 0,
                date('Y-m-d', strtotime($today . ' - 2 day')) => 0,
                date('Y-m-d', strtotime($today . ' - 1 day')) => 0,
                date('Y-m-d') => 0
            )
        );
        $result = $this->invokeMethod($this->Widget, 'getTrend', array('6', 'week_1', '12'));
        $this->assertEquals($expected3, $result);
        
        $expected4 = array(
            'year' => array(
                '2014' => 7.1,
                '2015' => 6.1
            )
        );
        $result = $this->invokeMethod($this->Widget, 'getTrend', array('6', 'all', '12'));
        $this->assertEquals($expected4, $result);
        
        $result = $this->invokeMethod($this->Widget, 'getTrend', array('6', 'month_12', ''));
        $this->assertFalse($result);

        $result = $this->invokeMethod($this->Widget, 'getTrend', array('6', '', '12'));
        $this->assertFalse($result);

        $result = $this->invokeMethod($this->Widget, 'getTrend', array('', 'month_12', '12'));
        $this->assertFalse($result);

        $result = $this->invokeMethod($this->Widget, 'getTrend', array('6', 'month_5', '12'));
        $this->assertFalse($result);
    }

}
