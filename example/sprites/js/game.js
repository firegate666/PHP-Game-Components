var SM = new SpriteManager();

$(function() {

	$('#game').hide();

	preloadImages(sprites);

	var zIndex = 1,
		counter = 0;

	$.each(sprites, function (k, sprite_data) {
		sprite_data.zIndex = zIndex++;
		SM.addSprite((new Sprite(sprite_data)).init($('#game')));

		$('#controls').append('<button class="'+sprite_data.type+'" onclick="SM.setPlayer('+counter+')">'
			+'Set '+(counter++)
			+'</button>');
	});

	$('#game').click(function(event) {
		var x = event.pageX - $(this).position().left,
			y = event.pageY - $(this).position().top;

		// honor game field bounds
		x = Math.max(64, x);
		y = Math.max(64, y);
		x = Math.min($(this).width()-64, x);
		y = Math.min($(this).height()-64, y);

		$('.sprite').trigger('move', {
			x : x,
			y : y
		});

	});

	SM.updateSprites();

	$('#game').show();

});
