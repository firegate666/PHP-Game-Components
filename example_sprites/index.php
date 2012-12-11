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

define ( 'DEBUG', isset($_GET['dev']));
require_once __DIR__ . '/../appBase/index.php';

use cx\php\game\tools\JavaScriptPacker;

$jspacker = new JavaScriptPacker('\lib\JavaScriptPacker');
$jspacker->writePackedJavascript(array(
	__DIR__ . '/js/common.js' => __DIR__ . '/js/min/common.min.js',
	__DIR__ . '/js/sprite_data.js' => __DIR__ . '/js/min/sprite_data.min.js',
	__DIR__ . '/js/spritemanager.js' => __DIR__ . '/js/min/spritemanager.min.js',
	__DIR__ . '/js/sprite.js' => __DIR__ . '/js/min/sprite.min.js',
	__DIR__ . '/js/game.js' => __DIR__ . '/js/min/game.min.js'
));

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sprite Example</title>

		<meta http-equiv="content-type" content="text/html; charset=UTF-8">

		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/main.css" />

		<link rel="stylesheet" type="text/css" href="css/sprite_flying_soul_blonde.css" />
		<link rel="stylesheet" type="text/css" href="css/sprite_airdragon.css" />

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script type="text/javascript" src="js/lib/jquerypp.min.js"></script>

		<?php if (DEBUG): ?>
			<script type="text/javascript" src="js/common.js"></script>
			<script type="text/javascript" src="js/sprite_data.js"></script>
			<script type="text/javascript" src="js/spritemanager.js"></script>
			<script type="text/javascript" src="js/sprite.js"></script>
			<script type="text/javascript" src="js/game.js"></script>
		<?php else: ?>
			<script type="text/javascript" src="<?= file_exists('js/min/common.min.js') ? 'js/min/common.min.js' : 'js/common.js' ?>"></script>
			<script type="text/javascript" src="<?= file_exists('js/min/sprite_data.min.js') ? 'js/min/sprite_data.min.js' : 'js/sprite_data.js' ?>"></script>
			<script type="text/javascript" src="<?= file_exists('js/min/spritemanager.min.js') ? 'js/min/spritemanager.min.js' : 'js/spritemanager.js' ?>"></script>
			<script type="text/javascript" src="<?= file_exists('js/min/sprite.min.js') ? 'js/min/sprite.min.js' : 'js/sprite.js' ?>"></script>
			<script type="text/javascript" src="<?= file_exists('js/min/game.min.js') ? 'js/min/game.min.js' : 'js/game.js' ?>"></script>
		<?php endif; ?>

	</head>

	<body>

		<div id="game"></div>

	</body>

</html>
