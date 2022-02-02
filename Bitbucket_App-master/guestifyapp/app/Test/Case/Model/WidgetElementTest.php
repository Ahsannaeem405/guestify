<?php
App::uses('I18n', 'I18n');
App::uses('Widget', 'Model');

/**
 * Widget Test Case
 *
 */
class WidgetElementTest extends CakeTestCase {

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
		$this->WidgetElement = ClassRegistry::init('WidgetElement');
	}


	/**
 	* tearDown method
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function tearDown() {
		unset($this->WidgetElement);
		parent::tearDown();
	}


	/**
	* Call protected/private method of a class.
	*
	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
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
 	* testActivate method, check that widget_element is deactivated,
 	* activate and check the deleted-flag again, activate a new widget_element
 	* tested with: proper input pair, no widget_element_type, no widget_id, proper input pair,
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testActivate(){
		$this->WidgetElement->id = 1;
		
		$before = $this->WidgetElement->field('deleted');
		$this->assertEquals(1, $before);
		
		$result = $this->WidgetElement->activate('gsi', '1');
		$this->assertTrue($result);

		$after = $this->WidgetElement->field('deleted');
		$this->assertEquals(0, $after);

		$result = $this->WidgetElement->activate('', '1');
		$this->assertFalse($result);

		$result = $this->WidgetElement->activate('ratingcount', '');
		$this->assertFalse($result);

		$result = $this->WidgetElement->activate('ratingcount', '4');
		$this->assertTrue($result);
	}


	/**
 	* testAdd method, add a widget_element and check if the type
 	* was saved correctly (one simple widget_element, one comment),
 	* tested with: proper input pairs, no widget_element_type, no widget_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testAdd(){
		$result = $this->WidgetElement->add('ratingcount', '6');
		$this->assertTrue($result);

		$this->WidgetElement->id = 23;
		$result = $this->WidgetElement->field('type');
		$this->assertEquals('ratingcount', $result);

		$result = $this->WidgetElement->add('top5', '4');
		$this->assertTrue($result);

		$result = $this->WidgetElement->add('', '7');
		$this->assertFalse($result);

		$result = $this->WidgetElement->add('ratingcount', '');
		$this->assertFalse($result);
	}


	/**
 	* testDeactivate method, check that widget_element is active,
 	* deactivate and check the deleted-flag again,
 	* tested with: proper input pair, no widget_element_type, no widget_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testDeactivate(){
		$this->WidgetElement->id = 2;
		
		$before = $this->WidgetElement->field('deleted');
		$this->assertEquals(0, $before);
		
		$result = $this->WidgetElement->deactivate('ratingcount', '1');
		$this->assertTrue($result);

		$after = $this->WidgetElement->field('deleted');
		$this->assertEquals(1, $after);

		//check if double deactivations does not cause a problem
		$result = $this->WidgetElement->deactivate('ratingcount', '1');
		$this->assertTrue($result);

		$result = $this->WidgetElement->deactivate('', '1');
		$this->assertFalse($result);

		$result = $this->WidgetElement->deactivate('ratingcount', '');
		$this->assertFalse($result);
	}


	/**
 	* testDoesExist method, invoke needed because function is private
    * pass to invoke: Object, methodname, parameter for method in an array
    * tested with: proper input pair, no widget_element_type, wrong widget_id, wrong input pair
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testDoesExist(){
		$result = $this->invokeMethod($this->WidgetElement, 'doesExist', array('gsi', '1'));
        $this->assertTrue($result);

		$result = $this->invokeMethod($this->WidgetElement, 'doesExist', array('', '1'));
        $this->assertFalse($result);

        $result = $this->invokeMethod($this->WidgetElement, 'doesExist', array('gsi', '0'));
        $this->assertFalse($result);

        $result = $this->invokeMethod($this->WidgetElement, 'doesExist', array('fakedata', '100'));
        $this->assertFalse($result);
	}


	/**
 	* testEditCommentCount method, tested change, deactivation, reactivation
 	* on the same widget_element and adding a new widget_element,
 	* tested with: proper input pairs, no comment_type, no widget_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testEditCommentCount(){
		$this->WidgetElement->id = 4;
		$before = $this->WidgetElement->field('param');
		$this->assertEquals('top5', $before);

		$result = $this->WidgetElement->editCommentCount('last5', '1');
		$this->assertTrue($result);

		$after = $this->WidgetElement->field('param');
		$this->assertEquals('last5', $after);

		$result = $this->WidgetElement->editCommentCount('none', '1');
		$this->assertTrue($result);

		$after = $this->WidgetElement->field('param');
		$afterDeact = $this->WidgetElement->field('deleted');

		$this->assertEquals('none', $after);
		$this->assertEquals(1, $afterDeact);

		$result = $this->WidgetElement->editCommentCount('top10', '1');
		$this->assertTrue($result);

		$after = $this->WidgetElement->field('param');
		$afterAct = $this->WidgetElement->field('deleted');

		$this->assertEquals('top10', $after);
		$this->assertEquals(0, $afterAct);

		$result = $this->WidgetElement->editCommentCount('top10', '2');
		$this->assertTrue($result);

		$result = $this->WidgetElement->editCommentCount('', '1');
		$this->assertFalse($result);

		$result = $this->WidgetElement->editCommentCount('last5', '');
		$this->assertFalse($result);
	}


	/**
 	* testGetIdForEdit method, invoke needed because function is private
    * pass to invoke: Object, methodname, parameter for method in an array
    * tested with: proper input pair, wrong widget_id, wrong widget_element_type
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetIdForEdit(){
		$result = $this->invokeMethod($this->WidgetElement, 'getIdForEdit', array('gsi', '1'));
        $this->assertEquals(1, $result);

        $result = $this->invokeMethod($this->WidgetElement, 'getIdForEdit', array('gsi', '0'));
        $this->assertFalse($result);

		$result = $this->invokeMethod($this->WidgetElement, 'getIdForEdit', array('fakedata', '1'));
        $this->assertFalse($result);
	}


	/**
 	* testIsActive method, invoke needed because function is private
    * pass to invoke: Object, methodname, parameter for method in an array
    * tested with: two proper widget_element_ids, two wrong widget_element_ids
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testIsActive(){
		$result = $this->invokeMethod($this->WidgetElement, 'isActive', array('2'));
        $this->assertTrue($result);

        $result = $this->invokeMethod($this->WidgetElement, 'isActive', array('1'));
        $this->assertFalse($result);

        $result = $this->invokeMethod($this->WidgetElement, 'isActive', array('0'));
        $this->assertFalse($result);

        $result = $this->invokeMethod($this->WidgetElement, 'isActive', array('fakedata'));
        $this->assertFalse($result);
	}

}