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

if (defined ( 'DEBUG' ) && DEBUG)
{
	ini_set ( 'display_errors', 'On' );
	error_reporting ( E_ALL );
}
else
{
	ini_set ( 'display_errors', 'Off' );
	error_reporting ( E_ERROR );
}

/**
 * register our namespace auto-loader
 */
spl_autoload_register ( function ($class_name)
{
	$class_name = __DIR__ . '/' . str_replace ( '\\', '/', $class_name ) . '.php';
	if (file_exists ( $class_name ))
	{
		require_once $class_name;
	}
} );

/**
 * var_export all function arguments wrapped in <pre></pre>
 */
function debug()
{
	print '<pre>';
	foreach ( func_get_args () as $k => $v )
	{
		var_export ( $v );
	}
	print '</pre>';
}
