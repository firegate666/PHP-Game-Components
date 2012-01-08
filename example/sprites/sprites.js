var sprites_frames_per_second = 25;

function calculateFacingAngle(x2, y2, x1, y1)
{
	return Math.atan2(y2-y1, x2-x1) * (180 / Math.PI);
}

function calculateFacing(angle)
{
	var step = 22.5;
	if (angle > 0-step && angle < 0+step)
		return 'e';
	else if (angle > 45-step && angle < 45+step)
		return 'se';
	else if (angle > 90-step && angle < 90+step)
		return 's';
	else if (angle > 135-step && angle < 135+step)
		return 'sw';
	else if (angle > 180-step || angle < -180+step)
		return 'w';
	else if (angle > -135-step && angle < -135+step)
		return 'nw';
	else if (angle > -90-step && angle < -90+step)
		return 'n';
	else if (angle > -45-step && angle < -45+step)
		return 'ne';
}

function pad(number, length) {

	var str = '' + number;
	while (str.length < length) {
		str = '0' + str;
	}

	return str;

}

var sprites = {
	flying_soul_blonde : {
		'style' : {
			width : 128,
			height : 128
		},
		minFrame : 0,
		maxFrame : 15
	}
}

/**
 * preload all sprite frames
 */
function preloadImages() {
	jQuery.each(sprites, function(k, v) {
		for (i = v.minFrame; i < v.maxFrame; i++) {
			var img = new Image();
			img.src = k + '/ne' + pad(i, 2) + '.png';
		}
	})
}

/**
 * flip through the frames and switch sprite image
 */
function animate() {
	window.setTimeout(function() {
		jQuery('.sprite').each(
				function() {
					var start = jQuery(this).data('start');
					var type = jQuery(this).attr('name');
					var direction = jQuery(this).attr('direction');
					var picnum = start + "";
					picnum = pad(picnum, 2);

					jQuery(this).css(
							'background-image',
							'url("' + type + '/' + direction + picnum
									+ '.png")');
					start++;
					if (start >= sprites[type].maxFrame)
						start = sprites[type].minFrame;
					jQuery(this).data('start', start);
					animate(this);
				});
	}, 1000 / sprites_frames_per_second);
}

jQuery(function() {

	jQuery('html').click(
			function(event) {
				var x = event.pageX;
				var y = event.pageY;

				jQuery('.player').each(
						function() {

							var position = jQuery(this).position();
							var halfWidth = jQuery(this).width() / 2;
							var halfHeight = jQuery(this).height() / 2;

							// source center
							var position_x = position.left + halfWidth;
							var position_y = position.top + halfHeight;

							// destination top/left
							var position_x2 = x - halfWidth;
							var position_y2 = y - halfHeight;

							var angle = calculateFacingAngle(x, y, position_x, position_y);
							var facing = calculateFacing(angle);

							jQuery(this).attr('direction', facing);
							
							jQuery(this).clearQueue().animate({
								top : position_y2 + 'px',
								left : position_x2 + 'px'
							}, 5000, 'swing', function() {
								// complete
							});
						});

			});

	preloadImages();
	var zIndex = 1;

	// initialize all sprites
	jQuery('.sprite').each(function() {
		var type = jQuery(this).attr('name');
		var direction = jQuery(this).attr('direction');

		jQuery(this).data('start', 0);

		jQuery(this).css({
			width : sprites[type].style.width + 'px',
			height : sprites[type].style.height + 'px',
			backgroundImage : 'url("' + type + '/' + direction + '00.png")',
			zIndex : zIndex++
		});

	});
	// start animation loop
	animate();

});
