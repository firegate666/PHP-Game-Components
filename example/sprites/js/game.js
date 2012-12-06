var SM = new SpriteManager();

$(function() {

	$('#game').hide();

	preloadImages(sprites);

	var zIndex = 1;

	$.each(sprites, function (k, sprite_data) {
		sprite_data.zIndex = zIndex++;
		SM.addSprite((new Sprite(sprite_data)).init($('#game')));
	});

	$('#game').on('click dblclick', function(event) {
		var x = event.pageX - $(this).position().left,
			y = event.pageY - $(this).position().top;

		// honor game field bounds
		x = Math.max(64, x);
		y = Math.max(64, y);
		x = Math.min($(this).width()-64, x);
		y = Math.min($(this).height()-64, y);

		$('.sprite').trigger('move', {
			x : x,
			y : y,
			speed: event.type === 'dblckick' ? 1.6 : 1
		});

	});

	SM.updateSprites();

	$('#game')
		.show()
		.on('resize', function() {
			$(this).find('.sprite').each(function() {
				var x, y;

				if (($(this).position().top + $(this).height()) > $(window).innerHeight()) {
					y = $(window).innerHeight() - ($(this).height() / 2);
				}

				if (($(this).position().left + $(this).width()) > $(window).innerWidth()) {
					x = $(window).innerWidth() - ($(this).width() / 2);
				}

				$(this).trigger('move', {x: x, y: y, force: true});
			});
		});

});
