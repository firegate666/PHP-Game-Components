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

use cx\php\game\component\ComponentLoader;

abstract class TechTreeFactory
{

	protected static $singleton;

	/**
	 * hide constructor from public
	 */
	private function __construct()
	{
	
	}

	/**
	 *
	 * @param $source mixed       	
	 * @return TechTree
	 */
	abstract function loadTree($source = null);

	/**
	 *
	 * @return TechTreeFactory
	 */
	public static function getInstance()
	{
		if (is_null ( static::$singleton ))
		{
			$class_name = get_called_class ();
			static::$singleton = new $class_name ();
		}
		return static::$singleton;
	}
}
