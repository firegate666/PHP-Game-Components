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

namespace cx\php\game\techtree;

class TechTreeItem
{

	/**
	 *
	 * @var String
	 */
	protected $key;

	/**
	 *
	 * @var String
	 */
	protected $name;

	/**
	 *
	 * @var String
	 */
	protected $description;

	/**
	 *
	 * @var array
	 */
	protected $dependencies = array ();

	/**
	 *
	 * @param $key String       	
	 * @return TechTreeItem $this
	 */
	public function addDependency($key)
	{
		$this->dependencies [$key] = $key;
		return $this;
	}

	/**
	 *
	 * @return array
	 */
	public function getDependencies() {
		return $this->dependencies;
	}

	/**
	 *
	 * @return the $key
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 *
	 * @return the $name
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 *
	 * @return the $description
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 *
	 * @param $key string       	
	 * @return TechTreeItem $this
	 */
	public function setKey($key)
	{
		$this->key = $key;
		return $this;
	}

	/**
	 *
	 * @param $name string       	
	 * @return TechTreeItem $this
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 *
	 * @param $description string       	
	 * @return TechTreeItem $this
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	public function toArray() {
		$result = array(
			'key' => $this->getKey(),
			'name' => $this->getName(),
			'description' => $this->getDescription(),
			'dependencies' => $this->getDependencies()
		);

		return $result;
	}

}
