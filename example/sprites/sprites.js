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
 * 
 * @param sprite
 */
function animate(sprite) {
	window.setTimeout(function() {
		var start = jQuery(sprite).data('start');
		var type = jQuery(sprite).attr('name');
		var picnum = start + "";
		picnum = pad(picnum, 2);

		jQuery(sprite).css('background-image',
				'url("flying_soul_blonde/ne' + picnum + '.png")');
		start++;
		if (start >= sprites[type].maxFrame)
			start = sprites[type].minFrame;
		jQuery(sprite).data('start', start);
		animate(sprite);
	}, 100);
}

jQuery(function() {

	jQuery('html').click(function(event) {
		var x = event.pageX;
		var y = event.pageY;
		console.log({
			top : y + 'px',
			left : x + 'px'
		});
		jQuery('.player').each(function() {
			jQuery(this).animate({
				top : (y - (jQuery(this).height() / 2)) + 'px',
				left : (x - (jQuery(this).width() / 2)) + 'px'
			}, 5000, 'swing', function() {
				// complete
			});
		});

	});

	preloadImages();
	var zIndex = 1;

	jQuery('.sprite').each(function() {
		var type = jQuery(this).attr('name');

		jQuery(this).data('start', 0);

		jQuery(this).css({
			width : sprites[type].style.width + 'px',
			height : sprites[type].style.height + 'px',
			backgroundImage : 'url("' + type + '/ne00.png")',
			zIndex : zIndex++
		});

		animate(this);
	});

});
