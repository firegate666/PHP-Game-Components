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

namespace cx\php\game\tools;

class JavaScriptPacker {

	/**
	 *
	 * @var string
	 */
	protected $packer_class = null;

	/**
	 *
	 * @param string $packer_class
	 */
	public function __construct($packer_class) {
		$this->packer_class = $packer_class;
	}

	/**
	 * write packed javascript
	 *
	 * @param string[] $js_files array key is in file, array value is out file
	 * @return void
	 */
	public function writePackedJavascript($js_files) {
		foreach ($js_files as $js_infile => $js_outfile) {
			if ((!file_exists($js_outfile) || filemtime($js_outfile) < filemtime($js_infile)) && is_writable($js_outfile)) {
				$packer = new $this->packer_class(file_get_contents($js_infile), 'Normal', true, false);
				file_put_contents($js_outfile, $packer->pack());
			}
		}
	}
}
