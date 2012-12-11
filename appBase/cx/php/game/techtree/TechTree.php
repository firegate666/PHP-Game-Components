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

class TechTree
{

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
	 * @var TechTreeItem[]
	 */
	protected $items = array ();

	/**
	 *
	 * @param $item TechTreeItem       	
	 * @throws TechTreeItemExistsException
	 * @return TechTree $this
	 */
	public function addItem(TechTreeItem $item)
	{
		if (array_key_exists ( $item->getKey (), $this->items ))
		{
			throw new TechTreeItemExistsException ( $item->getKey () );
		}
		$this->items [$item->getKey ()] = $item;
		return $this;
	}

	/**
	 *
	 * @param $key String       	
	 * @return TechTreeItem/false
	 */
	public function getItem($key)
	{
		if (array_key_exists ( $key, $this->items ))
		{
			return $this->items [$key];
		}
		return false;
	}

	/**
	 * get all tech tree items
	 *
	 * @return TechTreeItem[]
	 */
	public function getItems() {
		return $this->items;
	}

	/**
	 *
	 * @return string $name
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 *
	 * @return string $description
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 *
	 * @param $name string       	
	 * @return TechTree $this
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 *
	 * @param $description string       	
	 * @return TechTree $this
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	public function toArray() {
		$result = array(
			'name' => $this->getName(),
			'description' => $this->getDescription(),
			'items' => array()
		);

		foreach ($this->getItems() as $item) {
			$result['items'][] = $item->toArray();
		}

		return $result;
	}

}
