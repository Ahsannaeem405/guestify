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
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @var array
 	*/
	public $fixtures = array(
		'app.account',
		'app.invoice',
		'app.upgrade',
		'app.host',
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
		CakeSession::delete('Auth.User');
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
 	* testActivate method, User is needed, because an authentication check is performed 
 	* when trying to activate a widget,
 	* tested: proper activation with db change check and redirect check, activation try 
 	* with wrong User and db no-change check with redirect check, exception with no widget_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	* @expectedException NotFoundException
 	*/
	public function testActivate() {
		$this->User->id = 6;
		$user = array(
			'id' => '6',
			'account_id' => '6',
		);
		User::store($user);

		$this->Widget->id = 3;
		$before = $this->Widget->field('status');
		$result = $this->testAction('/widgets/activate/3');
		$after = $this->Widget->field('status');
		$this->assertNotEquals($before, $after);
		$this->assertContains('/test', $this->headers['Location']);

		//wrong User test
		$this->User->id = 8;
		$user = array(
			'id' => '8',
			'account_id' => '8',
		);
		User::store($user);

		$this->Widget->id = 3;
		$before = $this->Widget->field('status');
		$result = $this->testAction('/widgets/activate/3');
		$after = $this->Widget->field('status');
		$this->assertEquals($before, $after);
		$this->assertContains('/Widgets', $this->headers['Location']);

		$this->testAction('/widgets/activate/');
	}


	/**
 	* testAdd method, User is needed, because user information is saved with a 
 	* new widget, post request and get request (typical site request) are tested,
 	* tested: redirect check and db change check, return value type with no param submitted
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

		//test post request
		$data = array(
			'Widget' => array(
				'account_id' => '6',
				'host_id' => '7',
				'poll_id' => '12',
				'name' => 'Mein zweites Widget',
				'period' => 'month_6',
				'format' => 'portrait',
				'width' => '200',
				'height' => '200',
				'ratingcount' => 1,
				'select_comment_count' => 'top5'
			)
		);

		$result = $this->testAction('/widgets/add', array(
				'data' => $data,
				'method' => 'post'
			));
		$this->assertContains('/Widgets', $this->headers['Location']);
		$this->Widget->id = 8;
		$this->assertTrue($this->Widget->exists());
		$checkstyle = $this->Widget->field('style');
		$this->assertEquals('standard', $checkstyle);

		//test get request (normal site request)
		$result = $this->testAction('/widgets/add', array(
				'return' => 'vars',
				'method' => 'get'
			));		
		$this->assertInternalType('array', $result);
	}


	/**
 	* testAdd method, test of the Ajax part of the add method has to be done separately
 	* tested: return value with proper poll_id, return value with wrong poll_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testAddAjaxAction() {
	    $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
	    $url = Router::url(array('controller' => 'widgets', 'action' => 'add', '?' => array('poll_id' => 12)));
	    $result = $this->testAction($url);
	    $this->assertEquals('"limited"', $result);

	    $url = Router::url(array('controller' => 'widgets', 'action' => 'add', '?' => array('poll_id' => 100)));
	    $result = $this->testAction($url);
	    $this->assertEquals('false', $result);
	}


	/**
 	* testDeactivate method, User is needed, because an authentication check is performed 
 	* when trying to deactivate a widget,
 	* tested: proper deactivation with db change check and redirect check, deactivation try 
 	* with wrong User and db no-change check with redirect check, exception with no widget_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	* @expectedException NotFoundException
 	*/
	public function testDeactivate() {
		$this->User->id = 6;
		$user = array(
			'id' => '6',
			'account_id' => '6',
		);
		User::store($user);

		$this->Widget->id = 1;
		$before = $this->Widget->field('status');
		$result = $this->testAction('/widgets/deactivate/1');
		$after = $this->Widget->field('status');
		$this->assertNotEquals($before, $after);
		$this->assertContains('/test', $this->headers['Location']);

		//wrong User test
		$this->User->id = 8;
		$user = array(
			'id' => '8',
			'account_id' => '8',
		);
		User::store($user);

		$this->Widget->id = 1;
		$before = $this->Widget->field('status');
		$result = $this->testAction('/widgets/deactivate/1');
		$after = $this->Widget->field('status');
		$this->assertEquals($before, $after);
		$this->assertContains('/Widgets', $this->headers['Location']);

		$this->testAction('/widgets/deactivate');
	}


	/**
 	* testEdit method, User is needed, because an authentication check is performed 
 	* when trying to edit a widget, put request and get request (typical site request) are tested,
 	* tested: redirect with wrong widget_id, redirect check and db change check with proper widget_id,
 	* return value type with no param submitted, exception with no widget_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	* @expectedException NotFoundException
 	*/
	public function testEdit() {
		$this->User->id = 6;
		$user = array(
			'id' => '6',
			'account_id' => '6',
		);
		User::store($user);

		//test put request
		$data = array(
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

		$result = $this->testAction('/widgets/edit/20', array(
				'data' => $data,
				'method' => 'put'
			));
		$this->assertContains('/test', $this->headers['Location']);

		$data['Widget']['id'] = 1;
		$this->Widget->id = 1;
		$before = $this->Widget->field('name');
		$result = $this->testAction('/widgets/edit/1', array(
				'data' => $data,
				'method' => 'put'
			));
		$after = $this->Widget->field('name');
		$this->assertNotEquals($before, $after);
		$this->assertContains('/Widgets', $this->headers['Location']);

		//test get request (typical site request)
		$result = $this->testAction('/widgets/edit/1', array(
				'return' => 'vars',
				'method' => 'get'
			));		
		$this->assertInternalType('array', $result);

		//exception test
		$this->testAction('/widgets/edit');
	}


	/**
 	* testIndex method, User is needed, because a list of the users widgets will be shown,
 	* tested: return type
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testIndex() {
		$this->User->id = 6;
		$user = array(
			'id' => '6',
			'account_id' => '6',
		);
		User::store($user);

		$result = $this->testAction('/widgets/index', array('return' => 'vars'));
		$this->assertInternalType('array', $result['widgets']);
	}




	/**
 	* testRemove method, User is needed, because an authentication check is performed 
 	* when trying to remove a widget,
 	* tested: redirect with wrong widget_id, redirect check & deleted flag check in db with 
 	* proper widget_id, exception with no widget_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	* @expectedException NotFoundException
 	*/
	public function testRemove() {
		$this->User->id = 1;
		$user = array(
			'id' => '1',
			'account_id' => '1',
		);
		User::store($user);

		$result = $this->testAction('/widgets/remove/1');		
		$this->assertContains('/Widgets', $this->headers['Location']);

		$this->Widget->id = 6;
		$before = $this->Widget->field('deleted');
		$result = $this->testAction('/widgets/remove/6');
		$after = $this->Widget->field('deleted');
		$this->assertNotEquals($before, $after);
		$this->assertContains('/Widgets', $this->headers['Location']);
		
		$this->testAction('/widgets/remove');
	}


	/**
 	* testSettings method, User is needed, because an authentication check is performed 
 	* when trying to go to the settings site of a widget,
 	* tested: redirect with wrong widget_id, return type with proper widget_id, exception with no widget_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	* @expectedException NotFoundException
 	*/
	public function testSettings() {
		$this->User->id = 6;
		$user = array(
			'id' => '6',
			'account_id' => '6',
		);
		User::store($user);

		$result = $this->testAction('/widgets/settings/20');		
		$this->assertContains('/Widgets', $this->headers['Location']);

		$this->Widget->id = 1;
		$result = $this->testAction('/widgets/settings/1', array('return' => 'vars'));		
		$this->assertInternalType('array', $result['widget']);		

		$this->testAction('/widgets/settings');
	}

}
