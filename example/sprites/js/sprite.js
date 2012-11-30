
function Sprite(sprite_data)
{

	var position,
		halfWidth,
		halfHeight,
		properties = {
			x: sprite_data.x,
			y: sprite_data.y,
			facing: sprite_data.facing,
			start: 0,
			sprite_data: sprite_data,
			object: null
		};

	var animation_class = null;

	var moving = false;

	var manager = null;

	this.setManager = function(my_manager) {
		manager = my_manager;
	};

	this.init = function(target) {
		return this.initView(target)
			.registerEvents()
			.update();
	};

	/**
	 * set player status of sprite
	 *
	 * @return {Sprite}
	 */
	this.setPlayer = function(isPlayer) {
		properties.sprite_data.player = isPlayer;
		if (isPlayer) {
			properties.object.addClass('player');
		} else {
			properties.object.removeClass('player');
		}

		return this;
	};

	/**
	 * get player status of sprite
	 *
	 * @return {boolean}
	 */
	this.isPlayer = function() {
		return properties.sprite_data.player;
	}

	this.setAnimationClass = function() {
		properties.object.removeClass(animation_class);
		animation_class = properties.facing + '_' + pad(properties.start + '', 2);
		properties.object.addClass(animation_class);
	};

	this.initView = function(target) {
		properties.start = 0;

		properties.object = $('<div class="sprite '+properties.sprite_data.type+' '+(properties.sprite_data.player ? 'player' : '')+'"></div>')
			.appendTo($(target));

		$(properties.object).css({
			top: properties.y + 'px',
			left: properties.x + 'px',
			zIndex : properties.sprite_data.zIndex++
		});

		position = $(properties.object).position();
		halfWidth = $(properties.object).width() / 2;
		halfHeight = $(properties.object).height() / 2;

		this.setAnimationClass();
		return this;
	};

	this.registerEvents = function() {
		var self = this;

		$(properties.object).bind('move', function(eventObject, eventData) {
			if (properties.sprite_data.player) {
				self.move(eventData.x, eventData.y);
			}
		});

		$(properties.object).bind('click', function(eventObject) {
			manager.setPlayer(self);
			eventObject.stopPropagation();
		});

		return this;
	};

	/**
	 * initialite sprite movement to given coordinates
	 *
	 * @param {integer} x
	 * @param {integer} y
	 * @return {Sprite}
	 */
	this.move = function(x, y) {

		if (!x && x !== 0 && y && y !== 0) {
			// no move
			return this;
		}

		if (!x && x !== 0) {
			x = position.left + halfWidth;
		}

		if (!y && y !== 0) {
			y = position.top + halfHeight;
		}

		// source center
		var position_x = position.left + halfWidth,
			position_y = position.top + halfHeight,
			position_x2 = x - halfWidth,
			position_y2 = y - halfHeight,
			angle = calculateFacingAngle(x, y, position_x, position_y),
			animation_duration = 4000,
			distance = Math.sqrt((position_x2-position_x)*(position_x2-position_x)+(position_y2-position_y)*(position_y2-position_y));

		properties.facing = calculateFacing(angle);

		if (Math.abs(distance) < 200) {
			animation_duration = 1500;
		}

		moving = true;

		$(properties.object).clearQueue().animate({
			top : position_y2 + 'px',
			left : position_x2 + 'px'
		}, {
			duration: animation_duration,
			queue: true,
			easing: 'swing',
			step: function() {

			},
			complete: function(now, fx) {
				moving = false;
			}
		});

		return this;
	};

	/**
	 * update sprite
	 *
	 * @return {Sprite}
	 */
	this.update = function() {
		var self = this;

		properties.start += moving ? 2 : 1;
		if (properties.start >= properties.sprite_data.maxFrame)
			properties.start = properties.sprite_data.minFrame;

		position = $(properties.object).position();
		self.setAnimationClass();

		return this;
	};

}
