/*
    A simple jQuery modalmm (http://github.com/kylefox/jquery-modalmm)
    Version 0.9.1
*/

(function (factory) {
  // Making your jQuery plugin work better with npm tools
  // http://blog.npmjs.org/post/112712169830/making-your-jquery-plugin-work-better-with-npm
  if(typeof module === "object" && typeof module.exports === "object") {
    factory(require("jquery"), window, document);
  }
  else {
    factory(jQuery, window, document);
  }
}(function($, window, document, undefined) {

  var modalmms = [],
      getCurrent = function() {
        return modalmms.length ? modalmms[modalmms.length - 1] : null;
      },
      selectCurrent = function() {
        var i,
            selected = false;
        for (i=modalmms.length-1; i>=0; i--) {
          if (modalmms[i].$blocker) {
            modalmms[i].$blocker.toggleClass('current_modal',!selected).toggleClass('behind',selected);
            selected = true;
          }
        }
      };

  $.modalmm = function(el, options) {
    var remove, target;
    this.$body = $('body');
    this.options = $.extend({}, $.modalmm.defaults, options);
    this.options.doFade = !isNaN(parseInt(this.options.fadeDuration, 10));
    this.$blocker = null;
    if (this.options.closeExisting)
      while ($.modalmm.isActive())
        $.modalmm.close(); // Close any open modalmms.
    modalmms.push(this);
    if (el.is('a')) {
      target = el.attr('href');
      this.anchor = el;
      //Select element by id from href
      if (/^#/.test(target)) {
        this.$elm = $(target);
        if (this.$elm.length !== 1) return null;
        this.$body.append(this.$elm);
        this.open();
      //AJAX
      } else {
        this.$elm = $('<div>');
        this.$body.append(this.$elm);
        remove = function(event, modalmm) { modalmm.elm.remove(); };
        this.showSpinner();
        el.trigger($.modalmm.AJAX_SEND);
        $.get(target).done(function(html) {
          if (!$.modalmm.isActive()) return;
          el.trigger($.modalmm.AJAX_SUCCESS);
          var current = getCurrent();
          current.$elm.empty().append(html).on($.modalmm.CLOSE, remove);
          current.hideSpinner();
          current.open();
          el.trigger($.modalmm.AJAX_COMPLETE);
        }).fail(function() {
          el.trigger($.modalmm.AJAX_FAIL);
          var current = getCurrent();
          current.hideSpinner();
          modalmms.pop(); // remove expected modalmm from the list
          el.trigger($.modalmm.AJAX_COMPLETE);
        });
      }
    } else {
      this.$elm = el;
      this.anchor = el;
      this.$body.append(this.$elm);
      this.open();
    }
  };

  $.modalmm.prototype = {
    constructor: $.modalmm,

    open: function() {
      var m = this;
      this.block();
      this.anchor.blur();
      if(this.options.doFade) {
        setTimeout(function() {
          m.show();
        }, this.options.fadeDuration * this.options.fadeDelay);
      } else {
        this.show();
      }
      $(document).off('keydown.modalmm').on('keydown.modalmm', function(event) {
        var current = getCurrent();
        if (event.which === 27 && current.options.escapeClose) current.close();
      });
      if (this.options.clickClose)
        this.$blocker.click(function(e) {
          if (e.target === this)
            $.modalmm.close();
        });
    },

    close: function() {
      modalmms.pop();
      this.unblock();
      this.hide();
      if (!$.modalmm.isActive())
        $(document).off('keydown.modalmm');
    },

    block: function() {
      this.$elm.trigger($.modalmm.BEFORE_BLOCK, [this._ctx()]);
      this.$body.css('overflow','hidden');
      this.$blocker = $('<div class="' + this.options.blockerClass + ' blocker current_modal"></div>').appendTo(this.$body);
      selectCurrent();
      if(this.options.doFade) {
        this.$blocker.css('opacity',0).animate({opacity: 1}, this.options.fadeDuration);
      }
      this.$elm.trigger($.modalmm.BLOCK, [this._ctx()]);
    },

    unblock: function(now) {
      if (!now && this.options.doFade)
        this.$blocker.fadeOut(this.options.fadeDuration, this.unblock.bind(this,true));
      else {
        this.$blocker.children().appendTo(this.$body);
        this.$blocker.remove();
        this.$blocker = null;
        selectCurrent();
        if (!$.modalmm.isActive())
          this.$body.css('overflow','');
      }
    },

    show: function() {
      this.$elm.trigger($.modalmm.BEFORE_OPEN, [this._ctx()]);
      if (this.options.showClose) {
        this.closeButton = $('<a href="#close-modalmm" rel="modalmm:close" class="close-modalmm ' + this.options.closeClass + '">' + this.options.closeText + '</a>');
        this.$elm.append(this.closeButton);
      }
      this.$elm.addClass(this.options.modalmmClass).appendTo(this.$blocker);
      if(this.options.doFade) {
        this.$elm.css({opacity: 0, display: 'inline-block'}).animate({opacity: 1}, this.options.fadeDuration);
      } else {
        this.$elm.css('display', 'inline-block');
      }
      this.$elm.trigger($.modalmm.OPEN, [this._ctx()]);
    },

    hide: function() {
      this.$elm.trigger($.modalmm.BEFORE_CLOSE, [this._ctx()]);
      if (this.closeButton) this.closeButton.remove();
      var _this = this;
      if(this.options.doFade) {
        this.$elm.fadeOut(this.options.fadeDuration, function () {
          _this.$elm.trigger($.modalmm.AFTER_CLOSE, [_this._ctx()]);
        });
      } else {
        this.$elm.hide(0, function () {
          _this.$elm.trigger($.modalmm.AFTER_CLOSE, [_this._ctx()]);
        });
      }
      this.$elm.trigger($.modalmm.CLOSE, [this._ctx()]);
    },

    showSpinner: function() {
      if (!this.options.showSpinner) return;
      this.spinner = this.spinner || $('<div class="' + this.options.modalmmClass + '-spinner"></div>')
        .append(this.options.spinnerHtml);
      this.$body.append(this.spinner);
      this.spinner.show();
    },

    hideSpinner: function() {
      if (this.spinner) this.spinner.remove();
    },

    //Return context for custom events
    _ctx: function() {
      return { elm: this.$elm, $elm: this.$elm, $blocker: this.$blocker, options: this.options };
    }
  };

  $.modalmm.close = function(event) {
    if (!$.modalmm.isActive()) return;
    if (event) event.preventDefault();
    var current = getCurrent();
    current.close();
    return current.$elm;
  };

  // Returns if there currently is an active modalmm
  $.modalmm.isActive = function () {
    return modalmms.length > 0;
  };

  $.modalmm.getCurrent = getCurrent;

  $.modalmm.defaults = {
    closeExisting: true,
    escapeClose: true,
    clickClose: true,
    closeText: 'Close',
    closeClass: '',
    modalmmClass: "modalmm",
    blockerClass: "jquery-modalmm",
    spinnerHtml: '<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div>',
    showSpinner: true,
    showClose: true,
    fadeDuration: null,   // Number of milliseconds the fade animation takes.
    fadeDelay: 1.0        // Point during the overlay's fade-in that the modalmm begins to fade in (.5 = 50%, 1.5 = 150%, etc.)
  };

  // Event constants
  $.modalmm.BEFORE_BLOCK = 'modalmm:before-block';
  $.modalmm.BLOCK = 'modalmm:block';
  $.modalmm.BEFORE_OPEN = 'modalmm:before-open';
  $.modalmm.OPEN = 'modalmm:open';
  $.modalmm.BEFORE_CLOSE = 'modalmm:before-close';
  $.modalmm.CLOSE = 'modalmm:close';
  $.modalmm.AFTER_CLOSE = 'modalmm:after-close';
  $.modalmm.AJAX_SEND = 'modalmm:ajax:send';
  $.modalmm.AJAX_SUCCESS = 'modalmm:ajax:success';
  $.modalmm.AJAX_FAIL = 'modalmm:ajax:fail';
  $.modalmm.AJAX_COMPLETE = 'modalmm:ajax:complete';

  $.fn.modalmm = function(options){
    if (this.length === 1) {
      new $.modalmm(this, options);
    }
    return this;
  };

  // Automatically bind links with rel="modalmm:close" to, well, close the modalmm.
  $(document).on('click.modalmm', 'a[rel~="modalmm:close"]', $.modalmm.close);
  $(document).on('click.modalmm', 'a[rel~="modalmm:open"]', function(event) {
    event.preventDefault();
    $(this).modalmm();
  });
}));
