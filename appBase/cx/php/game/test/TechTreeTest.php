<?php
/**************************************************************************
 *
 * Copyright 2011-2012 Marco Behnke <marco@php.cx>
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 **************************************************************************/

require_once 'PHPUnit/Framework/TestCase.php';
use cx\php\game\techtree\TechTree;

/**
 * test case.
 */
class TechTreeTest extends PHPUnit_Framework_TestCase
{

	/**
	 *
	 * @var \biz\behnke\game\techtree\TechTree
	 */
	protected $tt;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp ();
		$this->tt = new TechTree ();
		// TODO Auto-generated TechTreeTest::setUp()
	}

	public function testSetName()
	{
		$name = 'My Name';
		$this->tt->setName ( $name );
		$this->assertAttributeSame ( $name, 'name', $this->tt );
	}

	public function testLoadTree() {
		$loader = cx\php\game\techtree\XMLTechTreeFactory::getInstance();
		$this->tt = $loader->loadTree('<?xml version="1.0" encoding="UTF-8"?>
			<techtree name="Example Tech Tree">
				<description>This is an example tech tree</description>

				<techtreeitem key="WPN_KNIFE" name="Knife">
					<description>This is a knife.</description>
				</techtreeitem>

				<techtreeitem key="WPN_SWORD" name="Sword">
					<description>This is a sword.</description>
					<dependson key="WPN_KNIFE" />
				</techtreeitem>

				<techtreeitem key="WPN_BOW" name="Bow">
					<description>This is a bow.</description>
					<dependson key="WPN_KNIFE" />
					<dependson key="WPN_SWORD" />
				</techtreeitem>

			</techtree>', false);

		$this->assertEquals('Example Tech Tree', $this->tt->getName());
		$this->assertEquals('This is an example tech tree', $this->tt->getDescription());
		$this->assertEquals(3, count($this->tt->getItems()));
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		// TODO Auto-generated TechTreeTest::tearDown()

		parent::tearDown ();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct()
	{
		// TODO Auto-generated constructor
	}

}
