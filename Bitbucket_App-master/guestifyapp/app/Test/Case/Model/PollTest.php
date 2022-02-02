<?php
App::uses('I18n', 'I18n');
App::uses('Poll', 'Model');

/**
 * Widget Test Case
 *
 */
class PollTest extends CakeTestCase {

	/**
 	* Fixtures
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @var array
 	*/
	public $fixtures = array(
		'app.translate',
		'app.account',
		'app.poll',
		'app.group',
		'app.question',
		'app.polls_view',
		'app.answer',
		'app.host'
	);


	/**
 	* setUp method
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function setUp(){
		parent::setUp();
		Cache::delete('object_map', '_cake_core_');
		$this->Poll = ClassRegistry::init('Poll');
	}


	/**
 	* tearDown method
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function tearDown(){
		unset($this->Poll);
		parent::tearDown();
	}


	/**
 	* testCheckIfPollExists method,
 	* tested with: wrong poll_id, wrong input, proper poll_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testCheckIfPollExists(){
		$result = $this->Poll->checkIfPollExists(0);
		$this->assertFalse($result);

		$result = $this->Poll->checkIfPollExists('malicious data');
		$this->assertFalse($result);

		$result = $this->Poll->checkIfPollExists(6);
		$this->assertTrue($result);
	}


	/**
 	* testGetPollsHostIdForWidget method, the poll_id validation 
 	* is already performed in widget.php when the data comes in from the form
 	* tested with: no poll_id, proper poll_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetPollsHostIdForWidget(){
		$result = $this->Poll->getPollsHostIdForWidget();
		$this->assertFalse($result);

		$result = $this->Poll->getPollsHostIdForWidget(12);
		$this->assertEquals(7, $result);
	}


	/**
 	* testGetPollsListForWidget method, expected is a list for
 	* a selection form in an array
 	* tested with: no poll_id, wrong poll_id, proper poll_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetPollsListForWidget(){
		$result = $this->Poll->getPollsListForWidget();
		$this->assertFalse($result);
		
		$result = $this->Poll->getPollsListForWidget('malicious data');
		$this->assertFalse($result);

		$expected = array(
				'Lummerbratenhaus' => array(
						'12' => 'Superuser'
					),
				'Würstchenbude' => array(
						'11' => 'Umfrage'
					)
			);
		$result = $this->Poll->getPollsListForWidget(6);
		$this->assertNotEmpty($result);
		$this->assertInternalType('array', $result);
		$this->assertEquals($expected, $result);
	}


	/**
 	* testGetPollsTitleForWidget method,
 	* tested with: no poll_id, wrong poll_id, proper poll_id
 	*
 	* @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @return void
 	*/
	public function testGetPollsTitleForWidget(){
		$result = $this->Poll->getPollsTitleForWidget();
		$this->assertFalse($result);
		
		$result = $this->Poll->getPollsTitleForWidget('malicious data');
		$this->assertFalse($result);

		$expected = array(
				'Poll' => array(
					'id' => 12,
					'title' => 'Superuser'
					)
			);
		$result = $this->Poll->getPollsTitleForWidget(12);
		$this->assertNotEmpty($result);
		$this->assertInternalType('array', $result);
		$this->assertEquals($expected, $result);
	}

}
