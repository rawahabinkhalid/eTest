/*!
 * AdminLTE v3.0.0-rc.1 (https://adminlte.io)
 * Copyright 2014-2019 Colorlib <http://colorlib.com>
 * Licensed under MIT (https://github.com/almasaeed2010/AdminLTE/blob/master/LICENSE)
 */
(function (global, factory) {
  typeof exports === "object" && typeof module !== "undefined"
    ? factory(exports)
    : typeof define === "function" && define.amd
    ? define(["exports"], factory)
    : ((global = global || self), factory((global.adminlte = {})));
})(this, function (exports) {
  "use strict";

  /**
   * --------------------------------------------
   * AdminLTE ControlSidebar.js
   * License MIT
   * --------------------------------------------
   */
  var ControlSidebar = (function ($) {
    /**
     * Constants
     * ====================================================
     */
    var NAME = "ControlSidebar";
    var DATA_KEY = "lte.controlsidebar";
    var EVENT_KEY = "." + DATA_KEY;
    var JQUERY_NO_CONFLICT = $.fn[NAME];
    var Event = {
      COLLAPSED: "collapsed" + EVENT_KEY,
      EXPANDED: "expanded" + EVENT_KEY,
    };
    var Selector = {
      CONTROL_SIDEBAR: ".control-sidebar",
      CONTROL_SIDEBAR_CONTENT: ".control-sidebar-content",
      DATA_TOGGLE: '[data-widget="control-sidebar"]',
      CONTENT: ".content-wrapper",
      HEADER: ".main-header",
      FOOTER: ".main-footer",
    };
    var ClassName = {
      CONTROL_SIDEBAR_ANIMATE: "control-sidebar-animate",
      CONTROL_SIDEBAR_OPEN: "control-sidebar-open",
      CONTROL_SIDEBAR_SLIDE: "control-sidebar-slide-open",
      LAYOUT_FIXED: "layout-fixed",
      NAVBAR_FIXED: "layout-navbar-fixed",
      NAVBAR_SM_FIXED: "layout-sm-navbar-fixed",
      NAVBAR_MD_FIXED: "layout-md-navbar-fixed",
      NAVBAR_LG_FIXED: "layout-lg-navbar-fixed",
      NAVBAR_XL_FIXED: "layout-xl-navbar-fixed",
      FOOTER_FIXED: "layout-footer-fixed",
      FOOTER_SM_FIXED: "layout-sm-footer-fixed",
      FOOTER_MD_FIXED: "layout-md-footer-fixed",
      FOOTER_LG_FIXED: "layout-lg-footer-fixed",
      FOOTER_XL_FIXED: "layout-xl-footer-fixed",
    };

    var ControlSidebar =
      /*#__PURE__*/
      (function () {
        function ControlSidebar(element, config) {
          this._element = element;
          this._config = config;

          this._init();
        } // Public

        var _proto = ControlSidebar.prototype;

        _proto.show = function show() {
          // Show the control sidebar
          if (this._config.controlsidebarSlide) {
            $("html").addClass(ClassName.CONTROL_SIDEBAR_ANIMATE);
            $("body")
              .removeClass(ClassName.CONTROL_SIDEBAR_SLIDE)
              .delay(300)
              .queue(function () {
                $(Selector.CONTROL_SIDEBAR).hide();
                $("html").removeClass(ClassName.CONTROL_SIDEBAR_ANIMATE);
                $(this).dequeue();
              });
          } else {
            $("body").removeClass(ClassName.CONTROL_SIDEBAR_OPEN);
          }

          var expandedEvent = $.Event(Event.EXPANDED);
          $(this._element).trigger(expandedEvent);
        };

        _proto.collapse = function collapse() {
          // Collapse the control sidebar
          if (this._config.controlsidebarSlide) {
            $("html").addClass(ClassName.CONTROL_SIDEBAR_ANIMATE);
            $(Selector.CONTROL_SIDEBAR)
              .show()
              .delay(10)
              .queue(function () {
                $("body")
                  .addClass(ClassName.CONTROL_SIDEBAR_SLIDE)
                  .delay(300)
                  .queue(function () {
                    $("html").removeClass(ClassName.CONTROL_SIDEBAR_ANIMATE);
                    $(this).dequeue();
                  });
                $(this).dequeue();
              });
          } else {
            $("body").addClass(ClassName.CONTROL_SIDEBAR_OPEN);
          }

          var collapsedEvent = $.Event(Event.COLLAPSED);
          $(this._element).trigger(collapsedEvent);
        };

        _proto.toggle = function toggle() {
          var shouldOpen =
            $("body").hasClass(ClassName.CONTROL_SIDEBAR_OPEN) ||
            $("body").hasClass(ClassName.CONTROL_SIDEBAR_SLIDE);

          if (shouldOpen) {
            // Open the control sidebar
            this.show();
          } else {
            // Close the control sidebar
            this.collapse();
          }
        }; // Private

        _proto._init = function _init() {
          var _this = this;

          this._fixHeight();

          this._fixScrollHeight();

          $(window).resize(function () {
            _this._fixHeight();

            _this._fixScrollHeight();
          });
          $(window).scroll(function () {
            if (
              $("body").hasClass(ClassName.CONTROL_SIDEBAR_OPEN) ||
              $("body").hasClass(ClassName.CONTROL_SIDEBAR_SLIDE)
            ) {
              _this._fixScrollHeight();
            }
          });
        };

        _proto._fixScrollHeight = function _fixScrollHeight() {
          var heights = {
            scroll: $(document).height(),
            window: $(window).height(),
            header: $(Selector.HEADER).outerHeight(),
            footer: $(Selector.FOOTER).outerHeight(),
          };
          var positions = {
            bottom: Math.abs(
              heights.window + $(window).scrollTop() - heights.scroll
            ),
            top: $(window).scrollTop(),
          };
          var navbarFixed = false;
          var footerFixed = false;

          if ($("body").hasClass(ClassName.LAYOUT_FIXED)) {
            if (
              $("body").hasClass(ClassName.NAVBAR_FIXED) ||
              $("body").hasClass(ClassName.NAVBAR_SM_FIXED) ||
              $("body").hasClass(ClassName.NAVBAR_MD_FIXED) ||
              $("body").hasClass(ClassName.NAVBAR_LG_FIXED) ||
              $("body").hasClass(ClassName.NAVBAR_XL_FIXED)
            ) {
              if ($(Selector.HEADER).css("position") === "fixed") {
                navbarFixed = true;
              }
            }

            if (
              $("body").hasClass(ClassName.FOOTER_FIXED) ||
              $("body").hasClass(ClassName.FOOTER_SM_FIXED) ||
              $("body").hasClass(ClassName.FOOTER_MD_FIXED) ||
              $("body").hasClass(ClassName.FOOTER_LG_FIXED) ||
              $("body").hasClass(ClassName.FOOTER_XL_FIXED)
            ) {
              if ($(Selector.FOOTER).css("position") === "fixed") {
                footerFixed = true;
              }
            }

            if (positions.top === 0 && positions.bottom === 0) {
              $(Selector.CONTROL_SIDEBAR).css("bottom", heights.footer);
              $(Selector.CONTROL_SIDEBAR).css("top", heights.header);
              $(
                Selector.CONTROL_SIDEBAR +
                  ", " +
                  Selector.CONTROL_SIDEBAR +
                  " " +
                  Selector.CONTROL_SIDEBAR_CONTENT
              ).css(
                "height",
                heights.window - (heights.header + heights.footer)
              );
            } else if (positions.bottom <= heights.footer) {
              if (footerFixed === false) {
                $(Selector.CONTROL_SIDEBAR).css(
                  "bottom",
                  heights.footer - positions.bottom
                );
                $(
                  Selector.CONTROL_SIDEBAR +
                    ", " +
                    Selector.CONTROL_SIDEBAR +
                    " " +
                    Selector.CONTROL_SIDEBAR_CONTENT
                ).css(
                  "height",
                  heights.window - (heights.footer - positions.bottom)
                );
              } else {
                $(Selector.CONTROL_SIDEBAR).css("bottom", heights.footer);
              }
            } else if (positions.top <= heights.header) {
              if (navbarFixed === false) {
                $(Selector.CONTROL_SIDEBAR).css(
                  "top",
                  heights.header - positions.top
                );
                $(
                  Selector.CONTROL_SIDEBAR +
                    ", " +
                    Selector.CONTROL_SIDEBAR +
                    " " +
                    Selector.CONTROL_SIDEBAR_CONTENT
                ).css(
                  "height",
                  heights.window - (heights.header - positions.top)
                );
              } else {
                $(Selector.CONTROL_SIDEBAR).css("top", heights.header);
              }
            } else {
              if (navbarFixed === false) {
                $(Selector.CONTROL_SIDEBAR).css("top", 0);
                $(
                  Selector.CONTROL_SIDEBAR +
                    ", " +
                    Selector.CONTROL_SIDEBAR +
                    " " +
                    Selector.CONTROL_SIDEBAR_CONTENT
                ).css("height", heights.window);
              } else {
                $(Selector.CONTROL_SIDEBAR).css("top", heights.header);
              }
            }
          }
        };

        _proto._fixHeight = function _fixHeight() {
          var heights = {
            window: $(window).height(),
            header: $(Selector.HEADER).outerHeight(),
            footer: $(Selector.FOOTER).outerHeight(),
          };

          if ($("body").hasClass(ClassName.LAYOUT_FIXED)) {
            var sidebarHeight = heights.window - heights.header;

            if (
              $("body").hasClass(ClassName.FOOTER_FIXED) ||
              $("body").hasClass(ClassName.FOOTER_SM_FIXED) ||
              $("body").hasClass(ClassName.FOOTER_MD_FIXED) ||
              $("body").hasClass(ClassName.FOOTER_LG_FIXED) ||
              $("body").hasClass(ClassName.FOOTER_XL_FIXED)
            ) {
              if ($(Selector.FOOTER).css("position") === "fixed") {
                sidebarHeight =
                  heights.window - heights.header - heights.footer;
              }
            }

            $(
              Selector.CONTROL_SIDEBAR + " " + Selector.CONTROL_SIDEBAR_CONTENT
            ).css("height", sidebarHeight);

            if (typeof $.fn.overlayScrollbars !== "undefined") {
              $(
                Selector.CONTROL_SIDEBAR +
                  " " +
                  Selector.CONTROL_SIDEBAR_CONTENT
              ).overlayScrollbars({
                className: this._config.scrollbarTheme,
                sizeAutoCapable: true,
                scrollbars: {
                  autoHide: this._config.scrollbarAutoHide,
                  clickScrolling: true,
                },
              });
            }
          }
        }; // Static

        ControlSidebar._jQueryInterface = function _jQueryInterface(operation) {
          return this.each(function () {
            var data = $(this).data(DATA_KEY);

            if (!data) {
              data = new ControlSidebar(this, $(this).data());
              $(this).data(DATA_KEY, data);
            }

            if (data[operation] === "undefined") {
              throw new Error(operation + " is not a function");
            }

            data[operation]();
          });
        };

        return ControlSidebar;
      })();
    /**
     *
     * Data Api implementation
     * ====================================================
     */

    $(document).on("click", Selector.DATA_TOGGLE, function (event) {
      event.preventDefault();

      ControlSidebar._jQueryInterface.call($(this), "toggle");
    });
    /**
     * jQuery API
     * ====================================================
     */

    $.fn[NAME] = ControlSidebar._jQueryInterface;
    $.fn[NAME].Constructor = ControlSidebar;

    $.fn[NAME].noConflict = function () {
      $.fn[NAME] = JQUERY_NO_CONFLICT;
      return ControlSidebar._jQueryInterface;
    };

    return ControlSidebar;
  })(jQuery);

  /**
   * --------------------------------------------
   * AdminLTE Layout.js
   * License MIT
   * --------------------------------------------
   */
  var Layout = (function ($) {
    /**
     * Constants
     * ====================================================
     */
    var NAME = "Layout";
    var DATA_KEY = "lte.layout";
    var JQUERY_NO_CONFLICT = $.fn[NAME];
    var Selector = {
      HEADER: ".main-header",
      MAIN_SIDEBAR: ".main-sidebar",
      SIDEBAR: ".main-sidebar .sidebar",
      CONTENT: ".content-wrapper",
      BRAND: ".brand-link",
      CONTENT_HEADER: ".content-header",
      WRAPPER: ".wrapper",
      CONTROL_SIDEBAR: ".control-sidebar",
      LAYOUT_FIXED: ".layout-fixed",
      FOOTER: ".main-footer",
    };
    var ClassName = {
      HOLD: "hold-transition",
      SIDEBAR: "main-sidebar",
      CONTENT_FIXED: "content-fixed",
      SIDEBAR_FOCUSED: "sidebar-focused",
      LAYOUT_FIXED: "layout-fixed",
      NAVBAR_FIXED: "layout-navbar-fixed",
      FOOTER_FIXED: "layout-footer-fixed",
    };
    var Default = {
      scrollbarTheme: "os-theme-light",
      scrollbarAutoHide: "l",
      /**
       * Class Definition
       * ====================================================
       */
    };

    var Layout =
      /*#__PURE__*/
      (function () {
        function Layout(element, config) {
          this._config = config;
          this._element = element;

          this._init();
        } // Public

        var _proto = Layout.prototype;

        _proto.fixLayoutHeight = function fixLayoutHeight() {
          var heights = {
            window: $(window).height(),
            header: $(Selector.HEADER).outerHeight(),
            footer: $(Selector.FOOTER).outerHeight(),
            sidebar: $(Selector.SIDEBAR).height(),
          };

          var max = this._max(heights);

          if ($("body").hasClass(ClassName.LAYOUT_FIXED)) {
            $(Selector.CONTENT).css(
              "min-height",
              max - heights.header - heights.footer
            ); // $(Selector.SIDEBAR).css('min-height', max - heights.header)

            if (typeof $.fn.overlayScrollbars !== "undefined") {
              $(Selector.SIDEBAR).overlayScrollbars({
                className: this._config.scrollbarTheme,
                sizeAutoCapable: true,
                scrollbars: {
                  autoHide: this._config.scrollbarAutoHide,
                  clickScrolling: true,
                },
              });
            }
          } else {
            if (heights.window > heights.sidebar) {
              $(Selector.CONTENT).css(
                "min-height",
                heights.window - heights.header - heights.footer
              );
            } else {
              $(Selector.CONTENT).css(
                "min-height",
                heights.sidebar - heights.header
              );
            }
          }
        }; // Private

        _proto._init = function _init() {
          var _this = this;

          // Enable transitions
          $("body").removeClass(ClassName.HOLD); // Activate layout height watcher

          this.fixLayoutHeight();
          $(Selector.SIDEBAR).on(
            "collapsed.lte.treeview expanded.lte.treeview collapsed.lte.pushmenu expanded.lte.pushmenu",
            function () {
              _this.fixLayoutHeight();
            }
          );
          $(window).resize(function () {
            _this.fixLayoutHeight();
          });
          $("body, html").css("height", "auto");
        };

        _proto._max = function _max(numbers) {
          // Calculate the maximum number in a list
          var max = 0;
          Object.keys(numbers).forEach(function (key) {
            if (numbers[key] > max) {
              max = numbers[key];
            }
          });
          return max;
        }; // Static

        Layout._jQueryInterface = function _jQueryInterface(config) {
          return this.each(function () {
            var data = $(this).data(DATA_KEY);

            var _config = $.extend({}, Default, $(this).data());

            if (!data) {
              data = new Layout($(this), _config);
              $(this).data(DATA_KEY, data);
            }

            if (config === "init") {
              data[config]();
            }
          });
        };

        return Layout;
      })();
    /**
     * Data API
     * ====================================================
     */

    $(window).on("load", function () {
      Layout._jQueryInterface.call($("body"));
    });
    $(Selector.SIDEBAR + " a").on("focusin", function () {
      $(Selector.MAIN_SIDEBAR).addClass(ClassName.SIDEBAR_FOCUSED);
    });
    $(Selector.SIDEBAR + " a").on("focusout", function () {
      $(Selector.MAIN_SIDEBAR).removeClass(ClassName.SIDEBAR_FOCUSED);
    });
    /**
     * jQuery API
     * ====================================================
     */

    $.fn[NAME] = Layout._jQueryInterface;
    $.fn[NAME].Constructor = Layout;

    $.fn[NAME].noConflict = function () {
      $.fn[NAME] = JQUERY_NO_CONFLICT;
      return Layout._jQueryInterface;
    };

    return Layout;
  })(jQuery);

  /**
   * --------------------------------------------
   * AdminLTE PushMenu.js
   * License MIT
   * --------------------------------------------
   */
  var PushMenu = (function ($) {
    /**
     * Constants
     * ====================================================
     */
    var NAME = "PushMenu";
    var DATA_KEY = "lte.pushmenu";
    var EVENT_KEY = "." + DATA_KEY;
    var JQUERY_NO_CONFLICT = $.fn[NAME];
    var Event = {
      COLLAPSED: "collapsed" + EVENT_KEY,
      SHOWN: "shown" + EVENT_KEY,
    };
    var Default = {
      autoCollapseSize: false,
      screenCollapseSize: 768,
      enableRemember: false,
      noTransitionAfterReload: true,
    };
    var Selector = {
      TOGGLE_BUTTON: '[data-widget="pushmenu"]',
      SIDEBAR_MINI: ".sidebar-mini",
      SIDEBAR_COLLAPSED: ".sidebar-collapse",
      BODY: "body",
      OVERLAY: "#sidebar-overlay",
      WRAPPER: ".wrapper",
    };
    var ClassName = {
      SIDEBAR_OPEN: "sidebar-open",
      COLLAPSED: "sidebar-collapse",
      OPEN: "sidebar-open",
      SIDEBAR_MINI: "sidebar-mini",
      /**
       * Class Definition
       * ====================================================
       */
    };

    var PushMenu =
      /*#__PURE__*/
      (function () {
        function PushMenu(element, options) {
          this._element = element;
          this._options = $.extend({}, Default, options);

          this._init();

          if (!$(Selector.OVERLAY).length) {
            this._addOverlay();
          }
        } // Public

        var _proto = PushMenu.prototype;

        _proto.show = function show() {
          $(Selector.BODY)
            .addClass(ClassName.OPEN)
            .removeClass(ClassName.COLLAPSED);

          if (this._options.enableRemember) {
            localStorage.setItem("remember" + EVENT_KEY, ClassName.OPEN);
          }

          var shownEvent = $.Event(Event.SHOWN);
          $(this._element).trigger(shownEvent);
        };

        _proto.collapse = function collapse() {
          $(Selector.BODY)
            .removeClass(ClassName.OPEN)
            .addClass(ClassName.COLLAPSED);

          if (this._options.enableRemember) {
            localStorage.setItem("remember" + EVENT_KEY, ClassName.COLLAPSED);
          }

          var collapsedEvent = $.Event(Event.COLLAPSED);
          $(this._element).trigger(collapsedEvent);
        };

        _proto.isShown = function isShown() {
          if ($(window).width() >= this._options.screenCollapseSize) {
            return !$(Selector.BODY).hasClass(ClassName.COLLAPSED);
          } else {
            return $(Selector.BODY).hasClass(ClassName.OPEN);
          }
        };

        _proto.toggle = function toggle() {
          if (this.isShown()) {
            this.collapse();
          } else {
            this.show();
          }
        };

        _proto.autoCollapse = function autoCollapse() {
          if (this._options.autoCollapseSize) {
            if ($(window).width() <= this._options.autoCollapseSize) {
              if (this.isShown()) {
                this.toggle();
              }
            } else {
              if (!this.isShown()) {
                this.toggle();
              }
            }
          }
        };

        _proto.remember = function remember() {
          if (this._options.enableRemember) {
            var toggleState = localStorage.getItem("remember" + EVENT_KEY);

            if (toggleState == ClassName.COLLAPSED) {
              if (this._options.noTransitionAfterReload) {
                $("body")
                  .addClass("hold-transition")
                  .addClass(ClassName.COLLAPSED)
                  .delay(10)
                  .queue(function () {
                    $(this).removeClass("hold-transition");
                    $(this).dequeue();
                  });
              } else {
                $("body").addClass(ClassName.COLLAPSED);
              }
            }
          }
        }; // Private

        _proto._init = function _init() {
          var _this = this;

          this.remember();
          this.autoCollapse();
          $(window).resize(function () {
            _this.autoCollapse();
          });
        };

        _proto._addOverlay = function _addOverlay() {
          var _this2 = this;

          var overlay = $("<div />", {
            id: "sidebar-overlay",
          });
          overlay.on("click", function () {
            _this2.collapse();
          });
          $(Selector.WRAPPER).append(overlay);
        }; // Static

        PushMenu._jQueryInterface = function _jQueryInterface(operation) {
          return this.each(function () {
            var data = $(this).data(DATA_KEY);

            var _options = $.extend({}, Default, $(this).data());

            if (!data) {
              data = new PushMenu(this, _options);
              $(this).data(DATA_KEY, data);
            }

            if (operation === "toggle") {
              data[operation]();
            }
          });
        };

        return PushMenu;
      })();
    /**
     * Data API
     * ====================================================
     */

    $(document).on("click", Selector.TOGGLE_BUTTON, function (event) {
      event.preventDefault();
      var button = event.currentTarget;

      if ($(button).data("widget") !== "pushmenu") {
        button = $(button).closest(Selector.TOGGLE_BUTTON);
      }

      PushMenu._jQueryInterface.call($(button), "toggle");
    });
    $(window).on("load", function () {
      PushMenu._jQueryInterface.call($(Selector.TOGGLE_BUTTON));
    });
    /**
     * jQuery API
     * ====================================================
     */

    $.fn[NAME] = PushMenu._jQueryInterface;
    $.fn[NAME].Constructor = PushMenu;

    $.fn[NAME].noConflict = function () {
      $.fn[NAME] = JQUERY_NO_CONFLICT;
      return PushMenu._jQueryInterface;
    };

    return PushMenu;
  })(jQuery);

});
//# sourceMappingURL=adminlte.js.map
