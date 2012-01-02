<?php

require_once 'biz/behnke/game/test/TechTreeTest.php';

/**
 * Static test suite.
 */
class testSuite extends PHPUnit_Framework_TestSuite {
	
	/**
	 * Constructs the test suite handler.
	 */
	public function __construct() {
		$this->setName ( 'testSuite' );
		
		$this->addTestSuite ( 'TechTreeTest' );
	
	}
	
	/**
	 * Creates the suite.
	 */
	public static function suite() {
		return new self ();
	}
}

