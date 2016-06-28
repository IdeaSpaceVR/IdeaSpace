// ============================================================
//
// Vanilla Color Picker v 0.1.4
//
// http://github.com/miroshko/vanilla-color-picker
//
// This project is licensed under the terms of the MIT license.
//
// ============================================================

(function(global) {

  // @todo: bind in as a build step, so css is readable
  var basicCSS = '.vanilla-color-picker { display: inline-block; position: absolute; width: 204px; padding: 5px; background-color: #393939; border-radius: 5px; box-shadow: 1px 1px 2px 1px rgba(0,0,0,0.3) } .vanilla-color-picker-single-color { display: inline-block; width: 20px; height: 20px; margin: 1px 2px 0; border-radius: 2px; }'+
                  '.no-color { background: linear-gradient(45deg, #ffffff 0%,#ffffff 47%,#ff0f0f 51%,#ff0f0f 51%,#ff0f0f 51%,#ffffff 55%,#ffffff 100%); }';
  function singleColorTpl(color, index, picked, noColor) {
    var pickedClass = picked ? "vanilla-color-picker-single-color-picked" : '';
    if (color === 'noColor' && noColor) {
      return '<div class="vanilla-color-picker-single-color no-color ' + pickedClass + '" tabindex="' + index + '" data-color="' + noColor + '"></div>';  
    } else {
      return '<div class="vanilla-color-picker-single-color ' + pickedClass + '" tabindex="' + index + '" data-color="' + color + '" style="background-color:' + color + '"></div>';
    }
  }
  var DEFAULT_COLORS = ['red', 'yellow', 'green'];

  // 

  function addBasicStyling() {
    if (document.getElementById('vanilla-color-picker-style')) {
      return;
    }
    var style = document.createElement('style');
    style.setAttribute('type', 'text/css');
    style.setAttribute('id', 'vanilla-color-picker-style');
    style.innerHTML = basicCSS;
    var firstInHead = global.document.head.children[0];
    if (firstInHead) {
      global.document.head.insertBefore(style, firstInHead);
    } else {
      global.document.head.appendChild(style);
    }
    
  }

  function MessageMediator() {
    this.subscribers = {};
    this.on = function(eventName, callback) {
      this.subscribers[eventName] = this.subscribers[eventName] || [];
      this.subscribers[eventName].push(callback);
      return this;
    };

    this.emit = function(eventName) {
      var arguments_ = arguments;
      (this.subscribers[eventName] || []).forEach(function(callback) {
        callback.apply(null, Array.prototype.splice.call(arguments_, 1));
      });
    };
  }

  function SinglePicker(elem, colors, className, positionOnTop, noColor) {
    MessageMediator.apply(this);
    this.targetElem = elem;
    this.elem = null;
    var this_ = this;

    this._initialize = function() {
      this._createPickerElement();

      this._positionPickerElement();
      this._addEventListeners();
    };

    this.destroy = function() {
      try {
        this.elem.parentNode.removeChild(this.elem);
      }
      catch (e) {
        // http://stackoverflow.com/a/22934552
      }
    };

    this._positionPickerElement = function() {
      var left = this.targetElem.offsetLeft;
      var top = this.targetElem.offsetTop;
      var height = this.targetElem.offsetHeight;
      this.elem.style.left = left + 'px';
      if(positionOnTop) {
        this.elem.style.top = (top - height - this.elem.offsetHeight) + 'px';
        var posistionRealativeToWindow = this.elem.getBoundingClientRect(),
            topCorrection = posistionRealativeToWindow.top < 0 ? posistionRealativeToWindow.top : 0;
        this.elem.style.top = parseInt(this.elem.style.top, 10) - topCorrection + 'px';
        // medium editor specific code, we have to modify color picker position
        // if this is too height and go beyond window
        var activeToolbar = document.querySelector('.medium-editor-toolbar-active');
        if (activeToolbar && topCorrection) {
          this.elem.style.left = activeToolbar.offsetWidth + 5 + 'px';
        }
      } else {
        this.elem.style.top = (top + height) + 'px';
      }
    };

    this._onFocusLost = function() {
      setTimeout(function() {
        if (this_.elem.contains(document.activeElement)) {
          // because blur is not propagating
          document.activeElement.addEventListener('blur', this_._onFocusLost);
        } else {
          this_.emit('lostFocus');
        }
      }, 1);
    };

    this._createPickerElement = function() {
      this.elem = document.createElement('div');
      this.elem.classList.add('vanilla-color-picker');
      if (className) {
        this.elem.classList.add(className);
      }

      var currentlyChosenColorIndex = colors.indexOf(this.targetElem.dataset.vanillaPickerColor);

      for (var i = 0; i < colors.length; i++) {
        this.elem.innerHTML += singleColorTpl(colors[i], i + 1, i == currentlyChosenColorIndex, noColor);
      }
      this.targetElem.parentNode.parentNode.appendChild(this.elem);
      this.elem.setAttribute('tabindex', 1);

      var toFocus = currentlyChosenColorIndex > -1 ? currentlyChosenColorIndex : 0;

      this.elem.children[toFocus].focus();
      this.elem.children[toFocus].addEventListener('blur', this_._onFocusLost);
    };

    this._addEventListeners = function() {
      var _this = this;
      this.elem.addEventListener('click', function(e) {
        e.stopPropagation();
        if (e.target.classList.contains('vanilla-color-picker-single-color')) {
          _this.emit('colorChosen', e.target.dataset.color);
        }
      });
      this.elem.addEventListener('keydown', function(e) {
        e.stopPropagation();
        var ENTER = 13;
        var ESC = 27;
        var keyCode = e.which || e.keyCode;
        if (keyCode == ENTER) {
          _this.emit('colorChosen', e.target.dataset.color); 
        }
        if(keyCode == ESC) {
          _this.emit('lostFocus');
        }
      });
    };

    this._initialize();
  }

  function PickerHolder(elem) {
    MessageMediator.apply(this);
    // an alias for more intuitivity
    this.set = this.emit;

    this.colors = DEFAULT_COLORS;
    this.className = '';
    this.elem = elem;
    this.currentPicker = null;
    this.positionOnTop = false;
    var this_ = this;

    this._initialize = function() {
      this._addEventListeners();
    };

    this._addEventListeners = function() {
      this.elem.addEventListener('click', this.openPicker);
      this.elem.addEventListener('focus', this.openPicker);
      this.on('positionOnTop', function() {
        this_.positionOnTop = true;
      });
      this.on('customColors', function(colors) {
        if (!colors instanceof Array) {
          throw new Error('Colors must be an array');
        }
        this_.colors = colors;
      });
      this.on('defaultColor', function(color) {
        if (!this_.elem.dataset.vanillaPickerColor) {
          this_._updateElemState(color);
          this_.emit('colorChosen', color, this_.elem);
        }
      });
      this.on('noColor', function(color) {
        this_.noColor = color;
      });
      this.on('className', function(className) {
        this_.className = className;
      });
    };

    this._updateElemState = function(color) {
      this.elem.dataset.vanillaPickerColor = color;
      this.elem.value = color;
    };

    this.destroyPicker = function() {
      if (!this_.currentPicker){
        return;
      }
      this_.currentPicker.destroy();
      this_.currentPicker = null;
      this_.emit('pickerClosed');
    };

    this.openPicker = function() {
      if (this_.currentPicker) {
        return;
      }
      this_.currentPicker = new SinglePicker(this_.elem, this_.colors, this_.className, this_.positionOnTop, this_.noColor);
      this_.currentPicker.on('colorChosen', function(color) {
        this_._updateElemState(color);
        this_.destroyPicker();
        this_.emit('colorChosen', color, this_.elem);
      });
      this_.currentPicker.on('lostFocus', function() {
        this_.destroyPicker();
      });
      this_.emit('pickerCreated');
    };

    this._initialize();
  }

  function vanillaColorPicker(element, options) {
    // @todo: move from here
    addBasicStyling();
    return new PickerHolder(element, options);
  }

  if (global.define && global.define.amd) {
    define([], function() {
      return vanillaColorPicker;
    });
  } else {
    global.vanillaColorPicker = vanillaColorPicker;
  }
})(this || window);