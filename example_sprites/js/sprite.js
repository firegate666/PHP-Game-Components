(function($, window) {

	/**
	 * constructor
	 */
	window.Sprite = function (sprite_data)
	{

		this.position = null;
		this.halfWidth = null;
		this.halfHeight = null;
		this.moving = false;
		this.manager = null;
		this.move_timer_id = null;
		this.last_position = null;

		this.properties = {
			x: sprite_data.x,
			y: sprite_data.y,
			facing: sprite_data.facing,
			start: 0,
			sprite_data: sprite_data,
			object: null
		};

	};

	/**
	 * update sprite frames
	 *
	 * @return {Sprite}
	 */
	window.Sprite.prototype.updateSpriteFrames = function() {
		var y_offset = 0,
			x_offset = 0;

		switch (this.properties.facing) {
			case 'n':
				y_offset = 0 * this.halfHeight * 2;
				break;
			case 'nw':
				y_offset = 1 * this.halfHeight * 2;
				break;
			case 'w':
				y_offset = 2 * this.halfHeight * 2;
				break;
			case 'sw':
				y_offset = 3 * this.halfHeight * 2;
				break;
			case 's':
				y_offset = 4 * this.halfHeight * 2;
				break;
			case 'se':
				y_offset = 5 * this.halfHeight * 2;
				break;
			case 'e':
				y_offset = 6 * this.halfHeight * 2;
				break;
			case 'ne':
				y_offset = 7 * this.halfHeight * 2;
				break;
		}

		this.properties.start += this.moving ? 2 : 1;
		if (this.properties.start >= this.properties.sprite_data.maxFrame) {
			this.properties.start = this.properties.sprite_data.minFrame;
		}

		x_offset = this.properties.start * this.halfWidth * 2;

		$(this.properties.object)
			.css('background-position', x_offset + 'px ' + y_offset + 'px')
		;

		return this;
	};

	/**
	 * update sprite position
	 *
	 * @return {Sprite}
	 */
	window.Sprite.prototype.updateSpritePosition = function() {
		this.position = $(this.properties.object).position();

		return this;
	};

	/**
	 * update sprite
	 *
	 * @return {Sprite}
	 */
	window.Sprite.prototype.update = function() {
		return this.updateSpriteFrames()
			.updateSpritePosition();
	};

	/**
	 * check if sprite is in collision with another sprite
	 *
	 * @param {Sprite} another_sprite
	 * @return {boolean}
	 */
	window.Sprite.prototype.collides = function(another_sprite) {

		if (another_sprite === this) {
			return false;
		}

		return !(this.position.left > (another_sprite.position.left + another_sprite.halfWidth*2)
			|| (this.position.left + this.halfWidth*2) < another_sprite.position.left
			|| this.position.top > (another_sprite.position.top + another_sprite.halfHeight*2)
			|| (this.position.top + this.halfHeight*2) < another_sprite.position.top
		);
	};

	/**
	 * stop moving
	 *
	 * @return {Sprite}
	 */
	window.Sprite.prototype.stop = function() {
		this.moving = false;
		$(this.properties.object).stop(true, false);

		return this;
	};

	/**
	 * initialite sprite movement to given coordinates
	 *
	 * @param {integer} x
	 * @param {integer} y
	 * @param {integer} speed_factor
	 * @return {Sprite}
	 */
	window.Sprite.prototype.move = function(x, y, speed_factor) {

		var self = this;

		if ((typeof(x) == 'undefined' && typeof(y) == 'undefined') || (!x && x !== 0 && !y && y !== 0)) {
			// no move
			return this;
		}

		if (!x && x !== 0) {
			x = this.position.left + this.halfWidth;
		}

		if (!y && y !== 0) {
			y = this.position.top + this.halfHeight;
		}

		// source center
		var position_x = this.position.left + this.halfWidth,
			position_y = this.position.top + this.halfHeight,
			position_x2 = x - this.halfWidth,
			position_y2 = y - this.halfHeight,
			angle = calculateFacingAngle(x, y, position_x, position_y),
			animation_duration = 4000 / speed_factor,
			distance = Math.sqrt((position_x2-position_x)*(position_x2-position_x)+(position_y2-position_y)*(position_y2-position_y));

		if (Math.abs(distance) < 200) {
			animation_duration = animation_duration / 2;
		}

		window.clearTimeout(this.move_timer_id);

		this.move_timer_id = window.setTimeout(function(){
			self.properties.facing = calculateFacing(angle);

			self.stop();
			self.moving = true;
			self.last_position = {top: position_y, left: position_x};
			$(self.properties.object).animate({
				top : position_y2 + 'px',
				left : position_x2 + 'px'
			}, {
				duration: animation_duration,
				queue: true,
				easing: 'swing',
				step: function(now, fx) {
				},
				complete: function(now, fx) {
					self.moving = false;
					window.clearTimeout(self.move_timer_id);
				}
			});
		}, 300);

		return this;

	};

	/**
	 * set sprite manager
	 *
	 * @return {Sprite}
	 */
	window.Sprite.prototype.setManager = function(my_manager) {

		this.manager = my_manager;

	};

	/**
	 * initialize sprite
	 *
	 * @return {Sprite}
	 */
	window.Sprite.prototype.init = function(target) {

		return this.initView(target)
			.registerEvents()
			.update();

	};

	/**
	 * set player status of sprite
	 *
	 * @return {Sprite}
	 */
	window.Sprite.prototype.setPlayer = function(isPlayer) {

		this.properties.sprite_data.player = isPlayer;

		if (isPlayer) {
			this.properties.object.addClass('player');
		} else {
			this.properties.object.removeClass('player');
		}

		return this;

	};

	/**
	 * get player status of sprite
	 *
	 * @return {boolean}
	 */
	window.Sprite.prototype.isPlayer = function() {

		return this.properties.sprite_data.player;

	};

	/**
	 * set collision state
	 *
	 * @param {boolean} has_collision
	 * @return Sprite
	 */
	window.Sprite.prototype.setCollision = function(has_collision) {
		if (has_collision) {
			this.properties.object.addClass('collision');
		} else {
			this.properties.object.removeClass('collision');
		}

		return this;
	};

	window.Sprite.prototype.hasCollision = function() {
		return this.properties.object.hasClass('collision');
	};

	window.Sprite.prototype.initView = function(target) {

		this.properties.start = 0;

		this.properties.object = $('<div class="sprite '+this.properties.sprite_data.type+' '+(this.properties.sprite_data.player ? 'player' : '')+'"></div>')
			.appendTo($(target));

		$(this.properties.object).css({
			top: this.properties.y + 'px',
			left: this.properties.x + 'px',
			zIndex : this.properties.sprite_data.zIndex++
		});

		this.position = $(this.properties.object).position();
		this.halfWidth = $(this.properties.object).width() / 2;
		this.halfHeight = $(this.properties.object).height() / 2;

		return this;

	};

	window.Sprite.prototype.registerEvents = function() {

		var self = this;

		$(this.properties.object).on('move', function(eventObject, eventData) {
			if (self.properties.sprite_data.player || eventData.force) {
				self.move(eventData.x, eventData.y, eventData.speed);
			}
		});

		$(this.properties.object).on('click', function(eventObject) {
			self.manager.setPlayer(self);
			eventObject.stopPropagation();
		});

		return this;

	};

})(jQuery, window);
