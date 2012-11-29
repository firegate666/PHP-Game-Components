function SpriteManager() {

	var sprites = new Array();

	/**
	 * add sprite to collection
	 *
	 * @return void
	 */
	this.addSprite = function(sprite) {
		sprites.push(sprite);
	};

	/**
	 * set player sprite that reacts on the mouse
	 *
	 * @return void
	 */
	this.setPlayer = function(next_player) {

		$.each(sprites, function(k, v) {
			v.setPlayer(false);
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
		console.log(status);
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
