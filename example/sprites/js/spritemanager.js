var SpriteManager = function() {

	this.sprites = new Array();

	this.animation_loop_update = 0;

}

/**
 * add sprite to collection
 *
 * @return void
 */
SpriteManager.prototype.addSprite = function(sprite) {
	sprite.setManager(this);
	this.sprites.push(sprite);
};

/**
 * set player sprite that reacts on the mouse
 *
 * @param {Sprite} next_player
 * @return void
 */
SpriteManager.prototype.setPlayer = function(next_player) {
	$.each(this.sprites, function(k, v) {
		v.setPlayer(false);

		if (v == next_player) {
			next_player = k;
		}
	});

	this.sprites[next_player].setPlayer(true);
}

/**
 * print out manager status
 *
 * @return void
 */
SpriteManager.prototype.status = function() {
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
SpriteManager.prototype.updateSprites = function() {
	if (this.animation_loop_update === 0) {
		this.animation_loop_update = new Date().getTime();
	}

	var self = this;

	window.requestAnimFrame(function() {
		var current = new Date().getTime(),
			delta = current - self.animation_loop_update;

		if (delta >= 40) {
			$.each(self.sprites, function(k, sprite) {
				sprite.update();
			});
			self.animation_loop_update = new Date().getTime();
		}

		self.updateSprites();
	});
}
