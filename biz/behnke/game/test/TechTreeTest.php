<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once __DIR__.'/../techtree/TechTree.php';

/**
 * test case.
 */
class TechTreeTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * 
	 * @var \biz\behnke\game\techtree\TechTree
	 */
	protected $tt;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$this->tt = new \biz\behnke\game\techtree\TechTree();
		// TODO Auto-generated TechTreeTest::setUp()
	}
	
	public function testFails() {
		$this->assertNotEquals(true, true);
	}
	
	public function testSetName() {
		$name = 'My Name';
		$this->tt->setName($name);
		$this->assertAttributeSame($name, 'name', $this->tt);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated TechTreeTest::tearDown()
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}

}

