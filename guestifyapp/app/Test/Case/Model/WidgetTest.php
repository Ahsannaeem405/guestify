<?php
App::uses('I18n', 'I18n');
App::uses('Widget', 'Model');

/**
 * Widget Test Case
 *
 */
class WidgetTest extends CakeTestCase {

	/**
 	* Fixtures
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @var array
 	*/
	public $fixtures = array(
		'app.invoice',
		'app.upgrade',
		'app.translate',
		'app.widget',
		'app.widget_element',
		'app.poll',
		'app.user'
	);


	/**
 	* setUp method
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function setUp() {
		parent::setUp();

		Cache::delete('object_map', '_cake_core_');
		$this->Widget = ClassRegistry::init('Widget');
		$this->User = ClassRegistry::init('User');
	}


	/**
 	* tearDown method
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function tearDown() {
		unset($this->Widget);
		unset($this->User);
		parent::tearDown();
	}


	/**
 	* testActivate method, 
 	* tested with: wrong input, wrong widget_id, proper widget_id 
 	* 			   incl. db change check
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testActivate(){
		$result = $this->Widget->activate('malicious data');
		$this->assertFalse($result);

		$result = $this->Widget->activate(0);
		$this->assertFalse($result);

		$widget = $this->Widget->id = 3;

		$before = $this->Widget->field('status');
		$this->assertEquals($before, 0);

		$result = $this->Widget->activate(3);
		$this->assertTrue($result);

		$after = $this->Widget->field('status');
		$this->assertEquals($after, 1);
	}


	/**
 	* testAdd method, User is needed, because user information is saved with a 
 	* new widget, after a bad add attempt the validation Errors have to be reset
 	* to an empty array so a new add attempt can be made, 
 	* tested with: faulty input data, empty input data, wrong input data, 
 	* 			   proper input data
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testAdd() {
		$this->User->id = 6;

		$user = array(
			'id' => '6',
			'account_id' => '6',
		);

		User::store($user);

		$data = array(
			'Widget' => array(
				'account_id' => '2',
				'host_id' => '1',
				'poll_id' => '1',
				'name' => 'MyWidget',
				'period' => 'month_6',
				'format' => 'square',
				'width' => '200',
				'height' => '300',
				'style' => 'standard'
			)
		);

		$result = $this->Widget->add($data);
		$this->assertFalse($result);
		$this->Widget->validationErrors = array();

		$emptyWidget = array(
			'Widget' => array(
				'account_id' => '',
				'host_id' => '',
				'poll_id' => '',
				'name' => '',
				'period' => '',
				'format' => '',
				'width' => '',
				'height' => '',
				'style' => '',
				'gsi' => '',
				'trend' => '',
				'ratingcount' => '',
				'ratinglabel' => '',
				'select_comment_count' => ''
			)
		);

		$result = $this->Widget->add($emptyWidget);
		$this->assertFalse($result);
		$this->Widget->validationErrors = array();

		$result = $this->Widget->add('malicious code');
		$this->assertFalse($result);
		$this->Widget->validationErrors = array();

		$data2 = array(
			'Widget' => array(
				'account_id' => '6',
				'host_id' => '7',
				'poll_id' => '12',
				'name' => 'Mein erstes Widget',
				'period' => 'month_6',
				'format' => 'portrait',
				'width' => '200',
				'height' => '200',
				'style' => 'aquarell',
				'ratingcount' => 1,
				'select_comment_count' => 'top5'
			)
		);

		$result2 = $this->Widget->add($data2);
		$this->assertTrue($result2);

		//get the id of the new widget and get all the data from the db that was just added
		$data2['Widget']['id'] = $this->Widget->field('id');
		$result3 = $this->Widget->getByIdForEdit($data2['Widget']['id']);
		
		//since the data differs when taken out from the db, array_diff checks
		//if all fields of $data2 are in $result3, if so array_diff returns
		//an empty array, ! will return true on an empty array
		$containsAllValues = !array_diff($data2['Widget'], $result3['Widget']);
		$this->assertTrue($containsAllValues);
	}


	/**
 	* testDeactivate method, 
 	* tested with: wrong input, wrong widget_id, proper widget_id incl. db change check
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testDeactivate(){
		$result = $this->Widget->deactivate('malicious data');
		$this->assertFalse($result);

		$result = $this->Widget->deactivate(0);
		$this->assertFalse($result);

		$widget = $this->Widget->id = 1;

		$before = $this->Widget->field('status');
		$this->assertEquals($before, 1);

		$result = $this->Widget->deactivate(1);
		$this->assertTrue($result);

		$after = $this->Widget->field('status');
		$this->assertEquals($after, 0);
	}


	/**
 	* testEdit method, User is needed, because an authentication check is performed 
 	* when trying to edit a widget, after a bad edit attempt the validation Errors 
 	* have to be reset to an empty array so a new edit attempt can be made, 
 	* tested with: wrong widget_id, empty widget data, wrong poll_id, 
 	* 			   proper input data incl. db change check
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testEdit(){
		$this->User->id = 6;

		$user = array(
			'id' => '6',
			'account_id' => '6',
		);

		User::store($user);

		$result = $this->Widget->edit();
		$this->assertFalse($result);
		
		$fakeWidgetId = array(
			'Widget' => array(
				'id' => '50',
				'account_id' => '6',
				'host_id' => '7',
				'poll_id' => '12',
				'name' => 'MyWidget',
				'period' => 'month_6',
				'format' => 'square',
				'width' => '200',
				'height' => '300',
				'style' => 'standard',
				'gsi' => '1',
				'trend' => '1',
				'ratingcount' => '1',
				'ratinglabel' => '1',
				'select_comment_count' => 'top5'
			)
		);

		$result = $this->Widget->edit($fakeWidgetId);
		$this->assertFalse($result);
		$this->Widget->validationErrors = array();

		$emptyWidget = array(
			'Widget' => array(
				'id' => '',
				'account_id' => '',
				'host_id' => '',
				'poll_id' => '',
				'name' => '',
				'period' => '',
				'format' => '',
				'width' => '',
				'height' => '',
				'style' => '',
				'gsi' => '',
				'trend' => '',
				'ratingcount' => '',
				'ratinglabel' => '',
				'select_comment_count' => ''
			)
		);

		$result = $this->Widget->edit($emptyWidget);
		$this->assertFalse($result);
		$this->Widget->validationErrors = array();

		$fakePollId = array(
			'Widget' => array(
				'id' => '1',
				'account_id' => '6',
				'host_id' => '7',
				'poll_id' => '5',
				'name' => 'MyWidget',
				'period' => 'month_6',
				'format' => 'square',
				'width' => '200',
				'height' => '300',
				'style' => 'standard',
				'gsi' => '1',
				'trend' => '1',
				'ratingcount' => '1',
				'ratinglabel' => '1',
				'select_comment_count' => 'top5'
			)
		);

		$result = $this->Widget->edit($fakePollId);
		$this->assertFalse($result);
		$this->Widget->validationErrors = array();

		$before = array(
			'Widget' => array(
				'id' => '1',
				'account_id' => '6',
				'host_id' => '7',
				'poll_id' => '12',
				'name' => 'MyWidget',
				'period' => 'month_6',
				'format' => 'square',
				'width' => '200',
				'height' => '300',
				'style' => 'standard',
				'gsi' => '1',
				'trend' => '1',
				'ratingcount' => '1',
				'ratinglabel' => '1',
				'select_comment_count' => 'top5'
			)
		);

		$edit = array(
			'Widget' => array(
				'id' => '1',
				'account_id' => '6',
				'host_id' => '7',
				'poll_id' => '12',
				'name' => 'WidgetOne',
				'period' => 'month_3',
				'format' => 'portrait',
				'width' => '100',
				'height' => '400',
				'style' => 'retro',
				'gsi' => '0',
				'trend' => '0',
				'ratingcount' => '0',
				'ratinglabel' => '0',
				'select_comment_count' => 'last5'
			)
		);

		$after = array(
			'Widget' => array(
				'id' => '1',
				'account_id' => '6',
				'host_id' => '7',
				'poll_id' => '12',
				'name' => 'WidgetOne',
				'period' => 'month_3',
				'format' => 'portrait',
				'width' => '100',
				'height' => '400',
				'style' => 'retro',
				'select_comment_count' => 'last5'
			)
		);

		//checks that the data in $before is the same as the current db data, by checking that all 
		//fields of $before are contained in $result, if so array_diff returns an empty array, 
		//! will return true on an empty array, so we know what data is
		//in the db before we perform the edit
		$result = $this->Widget->getByIdForEdit(1);
		$containsAllValues = !array_diff($before['Widget'], $result['Widget']);
		$this->assertTrue($containsAllValues);

		$result = $this->Widget->edit($edit);
		$this->assertTrue($result);

		//checks that the data in $after is the same as the db data after the edit, by checking that
		//all fields of $after are contained in $result, if so array_diff returns an empty array,
		//! will return true on an empty array, so we know that the data has been changed
		$result = $this->Widget->getByIdForEdit(1);
		$containsAllValues = !array_diff($after['Widget'], $result['Widget']);
		$this->assertTrue($containsAllValues);
	}


	/**
 	* testGetById method, 
 	* tested with: wrong widget_id, wrong input data, proper widget_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetById(){
		$result = $this->Widget->getById(0);
		$this->assertFalse($result);

		$result = $this->Widget->getById('malicious data');
		$this->assertFalse($result);
		
		$result = $this->Widget->getById(2);
		
		$expected = array('Widget' => array(
				'name' => 'hasenwidget',
				'period' => 'year_1',
				'format' => 'portrait',
				'width' => 200,
				'height' => 800,
				'style' => 'retro',
				'status' => 1,
				'hash' => 'b4ac80f7d9e80b9c6bb6',
				'id' => 2
			),
			'Poll' => array(
				'title' => 'Umfrage',
				'id' => 11
			),
			'WidgetElement' => array(
				'0' => array(
					'type' => 'gsi',
					'param' => '',
					'widget_id' => 2
				),
				'1' => array(
					'type' => 'trend',
					'param' => '',
					'widget_id' => 2
				),
				'2' => array(
					'type' => 'ratingcount',
					'param' => '',
					'widget_id' => 2
				),
				'3' => array(
					'type' => 'ratinglabel',
					'param' => '',
					'widget_id' => 2
				),
			)
		);
		
		$this->assertNotEmpty($result);
		$this->assertInternalType('array', $result);
		$this->assertEquals($expected, $result);
	}


	/**
 	* testGetByIdForEdit method, 
 	* tested with: wrong widget_id, wrong input data, proper widget_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetByIdForEdit(){
		$result = $this->Widget->getByIdForEdit(0);
		$this->assertFalse($result);
		
		$result = $this->Widget->getByIdForEdit('malicious data');
		$this->assertFalse($result);

		$expected = array(
			'Widget' => array(
				'id' => '1',
				'account_id' => '6',
				'host_id' => '7',
				'poll_id' => '12',
				'name' => 'MyWidget',
				'period' => 'month_6',
				'format' => 'square',
				'width' => '200',
				'height' => '300',
				'style' => 'standard',
				'gsi' => '1',
				'ratingcount' => '1',
				'ratinglabel' => '1',
				'select_comment_count' => 'top5'
			)
		);

		$result = $this->Widget->getByIdForEdit(1);
		
		//checks if all fields from $expected are contained in $result, if so array_diff returns
		//an empty array, ! will return true on an empty array, so we know the expected
		//data was read from the db
		$containsAllValues = !array_diff($expected['Widget'], $result['Widget']);
		$this->assertTrue($containsAllValues);
	}


	/**
 	* testGetCommentChoices method, checks if the expected array is returned
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetCommentChoices(){
		$expected = array(
				'none' => __('None'), 
            	'last5' => __('Last 5'), 
            	'top5' => __('Top 5'), 
            	'last10' => __('Last 10'), 
            	'top10' => __('Top 10')
			);

		$result = $this->Widget->getCommentChoices();

		$this->assertEquals($expected, $result);
	}


	/**
 	* testGetCommentChoicesKeys method, checks if the expected array is returned
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetCommentChoicesKeys(){
		$expected = array(
				'none', 
            	'last5', 
            	'top5', 
            	'last10', 
            	'top10'
			);

		$result = $this->Widget->getCommentChoicesKeys();

		$this->assertEquals($expected, $result);
	}


	/**
 	* testGetFormats method, checks if the expected array is returned
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetFormats(){
		$expected = array(
				'portrait' => __('Portrait'), 
	            'landscape' => __('Landscape'), 
	            'square' => __('Square')
			);

		$result = $this->Widget->getFormats();

		$this->assertEquals($expected, $result);
	}


	/**
 	* testGetFormatsKeys method, checks if the expected array is returned
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetFormatsKeys(){
		$expected = array(
				'portrait', 
	            'landscape', 
	            'square'
			);

		$result = $this->Widget->getFormatsKeys();

		$this->assertEquals($expected, $result);
	}


	/**
 	* testGetPeriods method, checks if the expected array is returned
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetPeriods(){
		$expected = array(
	            'week_1' => __('One week'),
	            'month_1' => __('One month'), 
	            'month_3' => __('Three months'), 
	            'month_6' => __('Six months'), 
	            'year_1' => __('One Year'), 
	            'all' => __('From the beginning')
			);

		$result = $this->Widget->getPeriods();

		$this->assertEquals($expected, $result);
	}


	/**
 	* testGetPeriodsKeys method, checks if the expected array is returned
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetPeriodsKeys(){
		$expected = array(
	            'week_1',
	            'month_1', 
	            'month_3', 
	            'month_6', 
	            'year_1', 
	            'all'
			);

		$result = $this->Widget->getPeriodsKeys();

		$this->assertEquals($expected, $result);
	}


	/**
 	* testGetStyles method, checks if the expected array is returned
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetStyles(){
		$expected = array(
	            'standard' => __('Standard'),
	            'nubuck' => __('Nubuck'), 
	            'retro' => __('Retro'), 
	            'newage' => __('Newage'), 
	            'party' => __('Party'), 
	            'aquarell' => __('Aquarell')
			);

		$result = $this->Widget->getStyles();

		$this->assertEquals($expected, $result);
	}


	/**
 	* testGetStylesKeys method, checks if the expected array is returned
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetStylesKeys(){
		$expected = array(
	            'standard',
	            'nubuck', 
	            'retro', 
	            'newage', 
	            'party', 
	            'aquarell'
			);

		$result = $this->Widget->getStylesKeys();

		$this->assertEquals($expected, $result);
	}


	/**
 	* testGetWidgetElementTypes method, checks if the expected array is returned
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetWidgetElementTypes(){
		$expected = array(
	            'gsi' => __('GSI'), 
	            'trend' => __('Trend'), 
	            'ratingcount' => __('Ratingcount'), 
	            'ratinglabel' => __('Ratinglabel')
			);

		$result = $this->Widget->getWidgetElementTypes();

		$this->assertEquals($expected, $result);
	}


	/**
 	* testGetWidgetElementTypesKeys method, checks if the expected array is returned
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
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
 	* testRemove method,
 	* tested with: wrong widget_id, wrong input data, proper widget_id 
 	*              incl. db check of deleted flag before and after the remove
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testRemove(){
		$result = $this->Widget->remove(0);
		$this->assertFalse($result);

		$result = $this->Widget->remove('malicious data');
		$this->assertFalse($result);

		$id = 1;
		$this->Widget->id = $id;

		$this->assertEquals(0, $this->Widget->field('deleted'));

		$result = $this->Widget->remove(1);
		$this->assertTrue($result);

		$this->assertEquals(1, $this->Widget->field('deleted'));
	}


	/**
 	* testTranslateCommentChoice method,
 	* tested with: wrong input data, proper input data, no input data
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testTranslateCommentChoice(){
		$expected = 'error';
		$result = $this->Widget->translateCommentChoice('fakedata');
		$this->assertEquals($expected, $result);
		
		$expected = 'Last 5 Comments';
		$result = $this->Widget->translateCommentChoice('last5');
		$this->assertEquals($expected, $result);

		$result = $this->Widget->translateCommentChoice();
		$this->assertFalse($result);
	}


	/**
 	* testTranslateFormat method,
 	* tested with: wrong input data, proper input data, no input data
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testTranslateFormat(){
		$expected = 'error';
		$result = $this->Widget->translateFormat('fakedata');
		$this->assertEquals($expected, $result);
		
		$expected = 'Landscape';
		$result = $this->Widget->translateFormat('landscape');
		$this->assertEquals($expected, $result);

		$result = $this->Widget->translateFormat();
		$this->assertFalse($result);
	}


	/**
 	* testTranslatePeriod method,
 	* tested with: wrong input data, proper input data, no input data
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testTranslatePeriod(){
		$expected = 'error';
		$result = $this->Widget->translatePeriod('fakedata');
		$this->assertEquals($expected, $result);
		
		$expected = 'Three months';
		$result = $this->Widget->translatePeriod('month_3');
		$this->assertEquals($expected, $result);

		$result = $this->Widget->translatePeriod();
		$this->assertFalse($result);
	}


	/**
 	* testTranslateStyle method,
 	* tested with: wrong input data, proper input data, no input data
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testTranslateStyle(){
		$expected = 'error';
		$result = $this->Widget->translateStyle('fakedata');
		$this->assertEquals($expected, $result);
		
		$expected = 'Standard';
		$result = $this->Widget->translateStyle('standard');
		$this->assertEquals($expected, $result);

		$result = $this->Widget->translateStyle();
		$this->assertFalse($result);
	}


	/**
 	* testTranslateWidgetElementType method,
 	* tested with: wrong input data, simple type widget_element, 
 	* 			   comment type widget_element, no input data
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testTranslateWidgetElementType(){
		$expected = 'error';
		$result = $this->Widget->translateWidgetElementType('fakedata');
		$this->assertFalse($result);
		
		$expected = 'GSI';
		$widgetelement['type'] = 'gsi';
		$result = $this->Widget->translateWidgetElementType($widgetelement);
		$this->assertEquals($expected, $result);

		$widgetelement['type'] = 'comment';
		$widgetelement['param'] = 'top10';

		$expected = 'Top 10 Comments';
		$result = $this->Widget->translateWidgetElementType($widgetelement);
		$this->assertEquals($expected, $result);

		$result = $this->Widget->translateWidgetElementType();
		$this->assertFalse($result);
	}

}
