(function(window) {

	window.SpriteManager = function() {

		this.sprites = new Array();
		this.animation_loop_update = 0;

	}

	/**
	* add sprite to collection
	*
	* @return void
	*/
	window.SpriteManager.prototype.addSprite = function(sprite) {

		sprite.setManager(this);
		this.sprites.push(sprite);

	};

	/**
	* set player sprite that reacts on the mouse
	*
	* @param {Sprite} next_player
	* @return void
	*/
	window.SpriteManager.prototype.setPlayer = function(next_player) {

		var sprite_id;

		for (sprite_id in this.sprites) {
			if (this.sprites.hasOwnProperty(sprite_id)) {
				this.sprites[sprite_id].setPlayer(false);

				if (this.sprites[sprite_id] == next_player) {
					next_player = sprite_id;
				}
			}
		}

		this.sprites[next_player].setPlayer(true);

	}

	/**
	* print out manager status
	*
	* @return void
	*/
	window.SpriteManager.prototype.status = function() {

		var status = {sprites: {}};

		$.each(this.sprites, function(k, sprite) {
			status.sprites[k] = {isPlayer: sprite.isPlayer(), object: sprite};
		});

		return status;

	}

	/**
	* update loop
	*
	* @return void
	*/
	window.SpriteManager.prototype.updateSprites = function() {

		if (this.animation_loop_update === 0) {
			this.animation_loop_update = new Date().getTime();
		}

		var self = this;

		window.requestAnimFrame(function(current) {
			var sprite_id,
				delta = current - self.animation_loop_update;

			if (delta >= 40) {

				for (sprite_id in self.sprites) {
					if (self.sprites.hasOwnProperty(sprite_id)) {
						self.sprites[sprite_id].update();
					}
				}

				if (self.animation_loop_update) {
					delta = 40;
				}

				self.animation_loop_update = new Date().getTime() - (delta - 40);
			}

			self.updateSprites();
		});

	}

})(window);
