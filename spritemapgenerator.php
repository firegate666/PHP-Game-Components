<?php
die('disabled');

$dir = __DIR__ . '/flying_soul_blonde';

$spritemap = array(
	'n' => array(),
	'ne' => array(),
	'e' => array(),
	'se' => array(),
	's' => array(),
	'sw' => array(),
	'w' => array(),
	'nw' => array()
);

$spritedir = scandir($dir);

sort($spritedir);

$sprite_w = null;
$sprite_h = null;

foreach ($spritedir as $sprite) {
	if ($sprite == '.' || $sprite == '..') {
		continue;
	}

	if ($sprite_w === null) {
		$img = imagecreatefrompng($dir . '/' . $sprite);
		$sprite_w = imagesx($img);
		$sprite_h = imagesy($img);
	}


	preg_match('/([a-zA-Z]+)([0-9]+)/', $sprite, $data);
	if (count($data) !== 3) {
		continue;
	}

	$spritemap[$data[1]][] = $dir . '/' . $sprite;
}

$spritemap_w = $sprite_w * count(current($spritemap));
$spritemap_h = $sprite_h * count($spritemap);

echo "Create spritemap {$spritemap_w} x {$spritemap_h}" . PHP_EOL;

$spritemap_img = imagecreatetruecolor($spritemap_w, $spritemap_h);
imagealphablending($spritemap_img, false);
imagesavealpha( $spritemap_img, true );
$dst_x = 0;
$dst_y = 0;

foreach ($spritemap as $direction) {
	$dst_x = 0;
	foreach ($direction as $frame) {
		$sprite_img = imagecreatefrompng($frame);
		imagecopy ($spritemap_img , $sprite_img, $dst_x, $dst_y, 0, 0, $sprite_w, $sprite_h);


		$dst_x += $sprite_w;
	}
	$dst_y += $sprite_h;
}

imagepng($spritemap_img, $dir . '/spritemap.png', 9);

