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

/**
 * create techtree from xml
 */
class XMLTechTreeFactory extends TechTreeFactory
{

	/**
	 *
	 * @see cx\php\game\techtree.TechTreeFactory::loadTree()
	 *
	 * @param $source String
	 *       	 path to XML
	 * @throws TechTreeItemExistsException
	 * @return TechTree
	 */
	public function loadTree($source = null)
	{
		$xml = new \SimpleXMLElement ( $source, 0, true );
		$tt = new TechTree ();
		$tt->setName ( ( string ) $xml ['name'] );
		$tt->setDescription ( ( string ) $xml->description );
		
		foreach ( $xml->techtreeitem as $entryXml )
		{
			$tt->addItem ( $this->getTechTreeItem ( $entryXml ) ); // TechTreeItemExistsException
		}
		
		return $tt;
	
	}

	/**
	 * create techtree item
	 *
	 * @param $xml \SimpleXMLElement       	
	 * @return TechTreeItem
	 */
	protected function getTechTreeItem(\SimpleXMLElement $xml)
	{
		$tti = new TechTreeItem ();
		$tti->setKey ( ( string ) $xml ['key'] )
			->setName ( ( string ) $xml ['name'] )
			->setDescription ( ( string ) $xml->description );
		
		foreach ( $xml->dependson as $dependency )
		{
			$tti->addDependency ( ( string ) $dependency ['key'] );
		}
		
		return $tti;
	}

}
