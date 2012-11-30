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

	/**
	 * update loop
	 *
	 * @return void
	 */
	this.updateSprites = function() {
		var self = this;
		window.setTimeout(function() {
			$.each(sprites, function(k, sprite) {
				sprite.update();
			});
			self.updateSprites();
		}, 1000 / 25);
	}

}
