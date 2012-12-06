<?php

	require_once __DIR__ . '/class.JavaScriptPacker.php';

	function packJS($js_infile, $js_outfile) {

		if (!file_exists($js_outfile) || filemtime($js_outfile) < filemtime($js_infile)) {
			$packer = new JavaScriptPacker(file_get_contents($js_infile), 'Normal', true, false);
			file_put_contents($js_outfile, $packer->pack());
		}
	}

	packJS(__DIR__ . '/js/common.js', __DIR__ . '/js/min/common.min.js');
	packJS(__DIR__ . '/js/sprite_data.js', __DIR__ . '/js/min/sprite_data.min.js');
	packJS(__DIR__ . '/js/spritemanager.js', __DIR__ . '/js/min/spritemanager.min.js');
	packJS(__DIR__ . '/js/sprite.js', __DIR__ . '/js/min/sprite.min.js');
	packJS(__DIR__ . '/js/game.js', __DIR__ . '/js/min/game.min.js');
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

		<?php if (isset($_GET['dev'])): ?>
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
