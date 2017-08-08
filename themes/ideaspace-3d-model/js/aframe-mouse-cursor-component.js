/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var _lodash = __webpack_require__(1);

	var _lodash2 = _interopRequireDefault(_lodash);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	if (typeof AFRAME === 'undefined') {
		throw 'mouse-cursor Component attempted to register before AFRAME was available.';
	}

	var IS_VR_AVAILABLE = AFRAME.utils.device.isMobile() || window.hasNonPolyfillWebVRSupport;

	/**
	 * Mouse Cursor Component for A-Frame.
	 */
	AFRAME.registerComponent('mouse-cursor', {
		schema: {},

		/**
	  * Called once when component is attached. Generally for initial setup.
	  * @protected
	  */
		init: function init() {
			this._raycaster = new THREE.Raycaster();
			this._mouse = new THREE.Vector2();
			this._isMobile = this.el.sceneEl.isMobile;
			this._isStereo = false;
			this._active = false;
			this._isDown = false;
			this._intersectedEl = null;
			this._attachEventListeners();
			this._canvasSize = false;
			/* bind functions */
			this.__getCanvasPos = this._getCanvasPos.bind(this);
			this.__getCanvasPos = this._getCanvasPos.bind(this);
			this.__onEnterVR = this._onEnterVR.bind(this);
			this.__onExitVR = this._onExitVR.bind(this);
			this.__onDown = this._onDown.bind(this);
			this.__onMouseMove = this._onMouseMove.bind(this);
			this.__onRelease = this._onRelease.bind(this);
			this.__onTouchMove = this._onTouchMove.bind(this);
			this.__onComponentChanged = this._onComponentChanged.bind(this);
		},


		/**
	  * Called when component is attached and when component data changes.
	  * Generally modifies the entity based on the data.
	  * @protected
	  */
		update: function update(oldData) {},


		/**
	  * Called when a component is removed (e.g., via removeAttribute).
	  * Generally undoes all modifications to the entity.
	  * @protected
	  */
		remove: function remove() {
			this._removeEventListeners();
			this._raycaster = null;
		},


		/**
	  * Called on each scene tick.
	  * @protected
	  */
		// tick (t) { },

		/**
	  * Called when entity pauses.
	  * Use to stop or remove any dynamic or background behavior such as events.
	  * @protected
	  */
		pause: function pause() {
			this._active = false;
		},


		/**
	  * Called when entity resumes.
	  * Use to continue or add any dynamic or background behavior such as events.
	  * @protected
	  */
		play: function play() {
			this._active = true;
		},


		/*==============================
	  =            events            =
	  ==============================*/

		/**
	  * @private
	  */
		_attachEventListeners: function _attachEventListeners() {
			var el = this.el;
			var sceneEl = el.sceneEl;
			var canvas = sceneEl.canvas;
			/* if canvas doesn't exist, listen for canvas to load. */

			if (!canvas) {
				el.sceneEl.addEventListener('render-target-loaded', this._attachEventListeners.bind(this));
				return;
			}

			window.addEventListener('resize', this.__getCanvasPos);
			document.addEventListener('scroll', this.__getCanvasPos);
			/* update _canvas in case scene is embedded */
			this._getCanvasPos();

			/* scene */
			sceneEl.addEventListener('enter-vr', this.__onEnterVR);
			sceneEl.addEventListener('exit-vr', this.__onExitVR);

			/* Mouse Events */
			canvas.addEventListener('mousedown', this.__onDown);
			canvas.addEventListener('mousemove', this.__onMouseMove);
			canvas.addEventListener('mouseup', this.__onRelease);
			canvas.addEventListener('mouseout', this.__onRelease);

			/* Touch events */
			canvas.addEventListener('touchstart', this.__onDown);
			canvas.addEventListener('touchmove', this.__onTouchMove);
			canvas.addEventListener('touchend', this.__onRelease);

			/* Element component change */
			el.addEventListener('componentchanged', this.__onComponentChanged);
		},


		/**
	  * @private
	  */
		_removeEventListeners: function _removeEventListeners() {
			var el = this.el;
			var sceneEl = el.sceneEl;
			var canvas = sceneEl.canvas;

			if (!canvas) {
				return;
			}

			window.removeEventListener('resize', this.__getCanvasPos);
			document.removeEventListener('scroll', this.__getCanvasPos);

			/* scene */
			sceneEl.removeEventListener('enter-vr', this.__onEnterVR);
			sceneEl.removeEventListener('exit-vr', this.__onExitVR);

			/* Mouse Events */
			canvas.removeEventListener('mousedown', this.__onDown);
			canvas.removeEventListener('mousemove', this.__onMouseMove);
			canvas.removeEventListener('mouseup', this.__onRelease);
			canvas.removeEventListener('mouseout', this.__onRelease);

			/* Touch events */
			canvas.removeEventListener('touchstart', this.__onDown);
			canvas.removeEventListener('touchmove', this.__onTouchMove);
			canvas.removeEventListener('touchend', this.__onRelease);

			/* Element component change */
			el.removeEventListener('componentchanged', this.__onComponentChanged);
		},


		/**
	  * Check if the mouse cursor is active
	  * @private
	  */
		_isActive: function _isActive() {
			return !!(this._active || this._raycaster);
		},


		/**
	  * @private
	  */
		_onDown: function _onDown(evt) {
			if (!this._isActive()) {
				return;
			}

			this._isDown = true;

			this._updateMouse(evt);
			this._updateIntersectObject();

			if (!this._isMobile) {
				this._setInitMousePosition(evt);
			}
			if (this._intersectedEl) {
				this._emit('mousedown');
			}
		},


		/**
	  * @private
	  */
		_onRelease: function _onRelease() {
			if (!this._isActive()) {
				return;
			}

			/* check if mouse position has updated */
			if (this._defMousePosition) {
				var defX = Math.abs(this._initMousePosition.x - this._defMousePosition.x);
				var defY = Math.abs(this._initMousePosition.y - this._defMousePosition.y);
				var def = Math.max(defX, defY);
				if (def > 0.04) {
					/* mouse has moved too much to recognize as click. */
					this._isDown = false;
				}
			}

			if (this._isDown && this._intersectedEl) {
				if (this._isDown) {
					this._emit('click');
				}
				this._emit('mouseup');
			}
			this._isDown = false;
			this._resetMousePosition();
		},


		/**
	  * @private
	  */
		_onMouseMove: function _onMouseMove(evt) {
			if (!this._isActive()) {
				return;
			}

			this._updateMouse(evt);
			this._updateIntersectObject();

			if (this._isDown) {
				this._setMousePosition(evt);
			}
		},


		/**
	  * @private
	  */
		_onTouchMove: function _onTouchMove(evt) {
			if (!this._isActive()) {
				return;
			}

			this._isDown = false;
		},


		/**
	  * @private
	  */
		_onEnterVR: function _onEnterVR() {
			if (IS_VR_AVAILABLE) {
				this._isStereo = true;
			}
			this._getCanvasPos();
		},


		/**
	  * @private
	  */
		_onExitVR: function _onExitVR() {
			this._isStereo = false;
			this._getCanvasPos();
		},


		/**
	  * @private
	  */
		_onComponentChanged: function _onComponentChanged(evt) {
			if (evt.detail.name === 'position') {
				this._updateIntersectObject();
			}
		},


		/*=============================
	  =            mouse            =
	  =============================*/

		/**
	  * Get mouse position from size of canvas element
	  * @private
	  */
		_getPosition: function _getPosition(evt) {
			var _canvasSize = this._canvasSize,
			    w = _canvasSize.width,
			    h = _canvasSize.height,
			    offsetW = _canvasSize.left,
			    offsetH = _canvasSize.top;


			var cx = void 0,
			    cy = void 0;
			if (this._isMobile) {
				var touches = evt.touches;

				if (!touches || touches.length !== 1) {
					return;
				}
				var touch = touches[0];
				cx = touch.clientX;
				cy = touch.clientY;
			} else {
				cx = evt.clientX;
				cy = evt.clientY;
			}

			/* account for the offset if scene is embedded */
			cx = cx - offsetW;
			cy = cy - offsetH;

			if (this._isStereo) {
				cx = cx % (w / 2) * 2;
			}

			var x = cx / w * 2 - 1;
			var y = -(cy / h) * 2 + 1;

			return { x: x, y: y };
		},


		/**
	  * Update mouse
	  * @private
	  */
		_updateMouse: function _updateMouse(evt) {
			var pos = this._getPosition(evt);
			if (!pos) {
				return;
			}

			this._mouse.x = pos.x;
			this._mouse.y = pos.y;
		},


		/**
	  * Update mouse position
	  * @private
	  */
		_setMousePosition: function _setMousePosition(evt) {
			this._defMousePosition = this._getPosition(evt);
		},


		/**
	  * Update initial mouse position
	  * @private
	  */
		_setInitMousePosition: function _setInitMousePosition(evt) {
			this._initMousePosition = this._getPosition(evt);
		},
		_resetMousePosition: function _resetMousePosition() {
			this._initMousePosition = this._defMousePosition = null;
		},


		/*======================================
	  =            scene children            =
	  ======================================*/

		/**
	  * @private
	  */
		_getCanvasPos: function _getCanvasPos() {
			this._canvasSize = this.el.sceneEl.canvas.getBoundingClientRect(); // update _canvas in case scene is embedded
		},


		/**
	  * Get non group object3D
	  * @private
	  */
		_getChildren: function _getChildren(object3D) {
			var _this = this;

			return object3D.children.map(function (obj) {
				return obj.type === 'Group' ? _this._getChildren(obj) : obj;
			});
		},


		/**
	  * Get all non group object3D
	  * @private
	  */
		_getAllChildren: function _getAllChildren() {
			var children = this._getChildren(this.el.sceneEl.object3D);
			return (0, _lodash2.default)(children);
		},


		/*====================================
	  =            intersection            =
	  ====================================*/

		/**
	  * Update intersect element with cursor
	  * @private
	  */
		_updateIntersectObject: function _updateIntersectObject() {
			var _raycaster = this._raycaster,
			    el = this.el,
			    _mouse = this._mouse;
			var scene = el.sceneEl.object3D;

			var camera = this.el.getObject3D('camera');
			this._getAllChildren();
			/* find intersections */
			// _raycaster.setFromCamera(_mouse, camera) /* this somehow gets error so did the below */
			_raycaster.ray.origin.setFromMatrixPosition(camera.matrixWorld);
			_raycaster.ray.direction.set(_mouse.x, _mouse.y, 0.5).unproject(camera).sub(_raycaster.ray.origin).normalize();

			/* get objects intersected between mouse and camera */
			var children = this._getAllChildren();
			var intersects = _raycaster.intersectObjects(children);

			if (intersects.length > 0) {
				/* get the closest three obj */
				var obj = void 0;
				intersects.every(function (item) {
					if (item.object.parent.visible === true) {
						obj = item.object;
						return false;
					} else {
						return true;
					}
				});
				if (!obj) {
					this._clearIntersectObject();
					return;
				}
				/* get the entity */
				var _el = obj.parent.el;
				/* only updates if the object is not the activated object */

				if (this._intersectedEl === _el) {
					return;
				}
				this._clearIntersectObject();
				/* apply new object as intersected */
				this._setIntersectObject(_el);
			} else {
				this._clearIntersectObject();
			}
		},


		/**
	  * Set intersect element
	  * @private
	  * @param {AEntity} el `a-entity` element
	  */
		_setIntersectObject: function _setIntersectObject(el) {
			this._intersectedEl = el;
			if (this._isMobile) {
				return;
			}
			el.addState('hovered');
			el.emit('mouseenter');
			this.el.addState('hovering');
		},


		/**
	  * Clear intersect element
	  * @private
	  */
		_clearIntersectObject: function _clearIntersectObject() {
			var el = this._intersectedEl;

			if (el && !this._isMobile) {
				el.removeState('hovered');
				el.emit('mouseleave');
				this.el.removeState('hovering');
			}

			this._intersectedEl = null;
		},


		/*===============================
	  =            emitter            =
	  ===============================*/

		/**
	  * @private
	  */
		_emit: function _emit(evt) {
			var _intersectedEl = this._intersectedEl;

			this.el.emit(evt, { target: _intersectedEl });
			if (_intersectedEl) {
				_intersectedEl.emit(evt);
			}
		}
	});

/***/ }),
/* 1 */
/***/ (function(module, exports) {

	/* WEBPACK VAR INJECTION */(function(global) {/**
	 * lodash (Custom Build) <https://lodash.com/>
	 * Build: `lodash modularize exports="npm" -o ./`
	 * Copyright jQuery Foundation and other contributors <https://jquery.org/>
	 * Released under MIT license <https://lodash.com/license>
	 * Based on Underscore.js 1.8.3 <http://underscorejs.org/LICENSE>
	 * Copyright Jeremy Ashkenas, DocumentCloud and Investigative Reporters & Editors
	 */

	/** Used as references for various `Number` constants. */
	var INFINITY = 1 / 0,
	    MAX_SAFE_INTEGER = 9007199254740991;

	/** `Object#toString` result references. */
	var argsTag = '[object Arguments]',
	    funcTag = '[object Function]',
	    genTag = '[object GeneratorFunction]';

	/** Detect free variable `global` from Node.js. */
	var freeGlobal = typeof global == 'object' && global && global.Object === Object && global;

	/** Detect free variable `self`. */
	var freeSelf = typeof self == 'object' && self && self.Object === Object && self;

	/** Used as a reference to the global object. */
	var root = freeGlobal || freeSelf || Function('return this')();

	/**
	 * Appends the elements of `values` to `array`.
	 *
	 * @private
	 * @param {Array} array The array to modify.
	 * @param {Array} values The values to append.
	 * @returns {Array} Returns `array`.
	 */
	function arrayPush(array, values) {
	  var index = -1,
	      length = values.length,
	      offset = array.length;

	  while (++index < length) {
	    array[offset + index] = values[index];
	  }
	  return array;
	}

	/** Used for built-in method references. */
	var objectProto = Object.prototype;

	/** Used to check objects for own properties. */
	var hasOwnProperty = objectProto.hasOwnProperty;

	/**
	 * Used to resolve the
	 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
	 * of values.
	 */
	var objectToString = objectProto.toString;

	/** Built-in value references. */
	var Symbol = root.Symbol,
	    propertyIsEnumerable = objectProto.propertyIsEnumerable,
	    spreadableSymbol = Symbol ? Symbol.isConcatSpreadable : undefined;

	/**
	 * The base implementation of `_.flatten` with support for restricting flattening.
	 *
	 * @private
	 * @param {Array} array The array to flatten.
	 * @param {number} depth The maximum recursion depth.
	 * @param {boolean} [predicate=isFlattenable] The function invoked per iteration.
	 * @param {boolean} [isStrict] Restrict to values that pass `predicate` checks.
	 * @param {Array} [result=[]] The initial result value.
	 * @returns {Array} Returns the new flattened array.
	 */
	function baseFlatten(array, depth, predicate, isStrict, result) {
	  var index = -1,
	      length = array.length;

	  predicate || (predicate = isFlattenable);
	  result || (result = []);

	  while (++index < length) {
	    var value = array[index];
	    if (depth > 0 && predicate(value)) {
	      if (depth > 1) {
	        // Recursively flatten arrays (susceptible to call stack limits).
	        baseFlatten(value, depth - 1, predicate, isStrict, result);
	      } else {
	        arrayPush(result, value);
	      }
	    } else if (!isStrict) {
	      result[result.length] = value;
	    }
	  }
	  return result;
	}

	/**
	 * Checks if `value` is a flattenable `arguments` object or array.
	 *
	 * @private
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is flattenable, else `false`.
	 */
	function isFlattenable(value) {
	  return isArray(value) || isArguments(value) ||
	    !!(spreadableSymbol && value && value[spreadableSymbol]);
	}

	/**
	 * Recursively flattens `array`.
	 *
	 * @static
	 * @memberOf _
	 * @since 3.0.0
	 * @category Array
	 * @param {Array} array The array to flatten.
	 * @returns {Array} Returns the new flattened array.
	 * @example
	 *
	 * _.flattenDeep([1, [2, [3, [4]], 5]]);
	 * // => [1, 2, 3, 4, 5]
	 */
	function flattenDeep(array) {
	  var length = array ? array.length : 0;
	  return length ? baseFlatten(array, INFINITY) : [];
	}

	/**
	 * Checks if `value` is likely an `arguments` object.
	 *
	 * @static
	 * @memberOf _
	 * @since 0.1.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is an `arguments` object,
	 *  else `false`.
	 * @example
	 *
	 * _.isArguments(function() { return arguments; }());
	 * // => true
	 *
	 * _.isArguments([1, 2, 3]);
	 * // => false
	 */
	function isArguments(value) {
	  // Safari 8.1 makes `arguments.callee` enumerable in strict mode.
	  return isArrayLikeObject(value) && hasOwnProperty.call(value, 'callee') &&
	    (!propertyIsEnumerable.call(value, 'callee') || objectToString.call(value) == argsTag);
	}

	/**
	 * Checks if `value` is classified as an `Array` object.
	 *
	 * @static
	 * @memberOf _
	 * @since 0.1.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is an array, else `false`.
	 * @example
	 *
	 * _.isArray([1, 2, 3]);
	 * // => true
	 *
	 * _.isArray(document.body.children);
	 * // => false
	 *
	 * _.isArray('abc');
	 * // => false
	 *
	 * _.isArray(_.noop);
	 * // => false
	 */
	var isArray = Array.isArray;

	/**
	 * Checks if `value` is array-like. A value is considered array-like if it's
	 * not a function and has a `value.length` that's an integer greater than or
	 * equal to `0` and less than or equal to `Number.MAX_SAFE_INTEGER`.
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is array-like, else `false`.
	 * @example
	 *
	 * _.isArrayLike([1, 2, 3]);
	 * // => true
	 *
	 * _.isArrayLike(document.body.children);
	 * // => true
	 *
	 * _.isArrayLike('abc');
	 * // => true
	 *
	 * _.isArrayLike(_.noop);
	 * // => false
	 */
	function isArrayLike(value) {
	  return value != null && isLength(value.length) && !isFunction(value);
	}

	/**
	 * This method is like `_.isArrayLike` except that it also checks if `value`
	 * is an object.
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is an array-like object,
	 *  else `false`.
	 * @example
	 *
	 * _.isArrayLikeObject([1, 2, 3]);
	 * // => true
	 *
	 * _.isArrayLikeObject(document.body.children);
	 * // => true
	 *
	 * _.isArrayLikeObject('abc');
	 * // => false
	 *
	 * _.isArrayLikeObject(_.noop);
	 * // => false
	 */
	function isArrayLikeObject(value) {
	  return isObjectLike(value) && isArrayLike(value);
	}

	/**
	 * Checks if `value` is classified as a `Function` object.
	 *
	 * @static
	 * @memberOf _
	 * @since 0.1.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is a function, else `false`.
	 * @example
	 *
	 * _.isFunction(_);
	 * // => true
	 *
	 * _.isFunction(/abc/);
	 * // => false
	 */
	function isFunction(value) {
	  // The use of `Object#toString` avoids issues with the `typeof` operator
	  // in Safari 8-9 which returns 'object' for typed array and other constructors.
	  var tag = isObject(value) ? objectToString.call(value) : '';
	  return tag == funcTag || tag == genTag;
	}

	/**
	 * Checks if `value` is a valid array-like length.
	 *
	 * **Note:** This method is loosely based on
	 * [`ToLength`](http://ecma-international.org/ecma-262/7.0/#sec-tolength).
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is a valid length, else `false`.
	 * @example
	 *
	 * _.isLength(3);
	 * // => true
	 *
	 * _.isLength(Number.MIN_VALUE);
	 * // => false
	 *
	 * _.isLength(Infinity);
	 * // => false
	 *
	 * _.isLength('3');
	 * // => false
	 */
	function isLength(value) {
	  return typeof value == 'number' &&
	    value > -1 && value % 1 == 0 && value <= MAX_SAFE_INTEGER;
	}

	/**
	 * Checks if `value` is the
	 * [language type](http://www.ecma-international.org/ecma-262/7.0/#sec-ecmascript-language-types)
	 * of `Object`. (e.g. arrays, functions, objects, regexes, `new Number(0)`, and `new String('')`)
	 *
	 * @static
	 * @memberOf _
	 * @since 0.1.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is an object, else `false`.
	 * @example
	 *
	 * _.isObject({});
	 * // => true
	 *
	 * _.isObject([1, 2, 3]);
	 * // => true
	 *
	 * _.isObject(_.noop);
	 * // => true
	 *
	 * _.isObject(null);
	 * // => false
	 */
	function isObject(value) {
	  var type = typeof value;
	  return !!value && (type == 'object' || type == 'function');
	}

	/**
	 * Checks if `value` is object-like. A value is object-like if it's not `null`
	 * and has a `typeof` result of "object".
	 *
	 * @static
	 * @memberOf _
	 * @since 4.0.0
	 * @category Lang
	 * @param {*} value The value to check.
	 * @returns {boolean} Returns `true` if `value` is object-like, else `false`.
	 * @example
	 *
	 * _.isObjectLike({});
	 * // => true
	 *
	 * _.isObjectLike([1, 2, 3]);
	 * // => true
	 *
	 * _.isObjectLike(_.noop);
	 * // => false
	 *
	 * _.isObjectLike(null);
	 * // => false
	 */
	function isObjectLike(value) {
	  return !!value && typeof value == 'object';
	}

	module.exports = flattenDeep;

	/* WEBPACK VAR INJECTION */}.call(exports, (function() { return this; }())))

/***/ })
/******/ ]);