window.requestAnimFrame = (function(){
	"use strict";
	return window.requestAnimationFrame       ||
		window.webkitRequestAnimationFrame ||
		window.mozRequestAnimationFrame    ||
		window.oRequestAnimationFrame      ||
		window.msRequestAnimationFrame     ||
		function( callback ){
			window.setTimeout(callback, 1000 / 60);
		};
})();

/**
 * calculate angle
 *
 * @param {integer} x2
 * @param {integer} y2
 * @param {integer} x1
 * @param {integer} y1
 * @return {float}
 */
function calculateFacingAngle(x2, y2, x1, y1) {
	"use strict";

	return Math.atan2(y2 - y1, x2 - x1) * (180 / Math.PI);
}

/**
 * calculate the view direction
 *
 * @param {float} angle
 * @return {string}
 */
function calculateFacing(angle) {
	"use strict";

	var step = 22.5;

	if (angle > 0 - step && angle < 0 + step)
		return 'e';
	else if (angle > 45 - step && angle < 45 + step)
		return 'se';
	else if (angle > 90 - step && angle < 90 + step)
		return 's';
	else if (angle > 135 - step && angle < 135 + step)
		return 'sw';
	else if (angle > 180 - step || angle < -180 + step)
		return 'w';
	else if (angle > -135 - step && angle < -135 + step)
		return 'nw';
	else if (angle > -90 - step && angle < -90 + step)
		return 'n';
	else if (angle > -45 - step && angle < -45 + step)
		return 'ne';

	return null;
}

/**
 * pad the number up to length with zeros
 *
 * @param {integer} number
 * @param {integer} length
 * @return {string}
 */
function pad(number, length) {
	"use strict";

	var str = '' + number;

	while (str.length < length) {
		str = '0' + str;
	}

	return str;
}

/**
 * preload all sprite frames
 *
 * @param {object} spritemap
 * @return void
 */
function preloadImages(spritemap) {
	"use strict";

	var directions = [ 'n', 'ne', 'e', 'se', 's', 'sw', 'w', 'nw' ],
		i,
		loaded_sprite_types = {};

	$.each(spritemap, function(k, v) {
		if (!loaded_sprite_types[v.type]) {
			$.each(directions, function(k2, v2) {
				loaded_sprite_types[v.type] = true;
				for (i = v.minFrame; i < v.maxFrame; i++) {
					var img = new Image();
					img.src = v.type + '/' + v2 + pad(i, 2) + '.png';
				}
			});
		}
	});
}
