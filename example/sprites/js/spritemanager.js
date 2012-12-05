function SpriteManager() {

	var sprites = new Array();

	/**
	 * add sprite to collection
	 *
	 * @return void
	 */
	this.addSprite = function(sprite) {
		sprite.setManager(this);
		sprites.push(sprite);
	};

	/**
	 * set player sprite that reacts on the mouse
	 *
	 * @param {Sprite} next_player
	 * @return void
	 */
	this.setPlayer = function(next_player) {
		$.each(sprites, function(k, v) {
			v.setPlayer(false);

			if (v == next_player) {
				next_player = k;
			}
		});

		sprites[next_player].setPlayer(true);
	}

	/**
	 * print out manager status
	 *
	 * @return void
	 */
	this.status = function() {
		var status = {sprites: {}};
		$.each(sprites, function(k, sprite) {
			status.sprites[k] = {isPlayer: sprite.isPlayer(), object: sprite};
		});
		return status;
	}

	this.animation_loop_update = 0;

	/**
	 * update loop
	 *
	 * @return void
	 */
	this.updateSprites = function() {
		if (this.animation_loop_update === 0) {
			this.animation_loop_update = new Date().getTime();
		}

		var self = this;

		window.requestAnimFrame(function() {
			var current = new Date().getTime(),
				delta = current - self.animation_loop_update;

			if (delta >= 40) {
				$.each(sprites, function(k, sprite) {
					sprite.update();
				});
				self.animation_loop_update = new Date().getTime();
			}

			self.updateSprites();
		});
	}

}
