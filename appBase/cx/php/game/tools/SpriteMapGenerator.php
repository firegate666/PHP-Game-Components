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

class SpriteMapGenerator {

	protected $direction_array = array(
		'n' => array(),
		'ne' => array(),
		'e' => array(),
		'se' => array(),
		's' => array(),
		'sw' => array(),
		'w' => array(),
		'nw' => array()
	);

	public function __constructor(array $direction_array = null) {
		if ($direction_array !== null) {
			$this->direction_array = $direction_array;
		}
	}

	/**
	 *
	 * @param string $path_to_spriteframes
	 * @param string $direction_frame_regex
	 */
	protected function loadSortedSpriteFrames($path_to_spriteframes, $direction_frame_regex) {
		$spritedir = scandir($path_to_spriteframes);
		sort($spritedir);

		foreach ($spritedir as $sprite) {
			if ($sprite == '.' || $sprite == '..') {
				continue;
			}

			preg_match($direction_frame_regex, $sprite, $data);
			if (count($data) !== 3) {
				continue;
			}

			$this->direction_array[$data[1]][] = $path_to_spriteframes . '/' . $sprite;
		}
	}

	/**
	 *
	 * @return \stdClass {x: integer, y: integer}
	 */
	protected function getSpriteDimension() {
		$dim = new \stdClass();
		$img = imagecreatefrompng(current($this->direction_array));

		$dim->x = imagesx($img);
		$dim->y = imagesy($img);

		return $dim;
	}

	/**
	 *
	 * @param integer $width
	 * @param integer $height
	 * @return ressource
	 */
	protected function getEmptySpriteMap($width, $height) {
		$spritemap_img = imagecreatetruecolor($width, $height);
		imagealphablending($spritemap_img, false);
		imagesavealpha( $spritemap_img, true );
		return $spritemap_img;
	}

	/**
	 *
	 * @param string $path_to_spriteframes
	 * @param string $direction_frame_regex
	 * @return ressource
	 */
	public function generate($path_to_spriteframes, $direction_frame_regex = '/([a-zA-Z]+)([0-9]+)/') {
		$this->loadSortedSpriteFrames($path_to_spriteframes, $direction_frame_regex);

		$sprite_dimension = $this->getSpriteDimension();

		$spritemap_w = $sprite_dimension->x * count(current($this->direction_array));
		$spritemap_h = $sprite_dimension->y * count($this->direction_array);

		$spritemap_img = $this->getEmptySpriteMap($spritemap_w, $spritemap_h);

		$dst_x = 0;
		$dst_y = 0;

		foreach ($this->direction_array as $direction) {
			$dst_x = 0;
			foreach ($direction as $frame) {
				$sprite_img = imagecreatefrompng($frame);
				imagecopy ($spritemap_img , $sprite_img, $dst_x, $dst_y, 0, 0, $sprite_dimension->x, $sprite_dimension->y);


				$dst_x += $sprite_dimension->x;
			}
			$dst_y += $sprite_dimension->y;
		}

		return $spritemap_img;
	}

}
