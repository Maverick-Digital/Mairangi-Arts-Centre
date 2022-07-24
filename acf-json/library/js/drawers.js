/* Jonathan Snook - MIT License - https://github.com/snookca/prepareTransition */
!(function(a){a.fn.prepareTransition=function(){return this.each(function(){var b=a(this);b.one("TransitionEnd webkitTransitionEnd transitionend oTransitionEnd",function(){b.removeClass("is-transitioning")});var c=["transition-duration","-moz-transition-duration","-webkit-transition-duration","-o-transition-duration"];var d=0;a.each(c,function(a,c){d=parseFloat(b.css(c))||d});if(d!=0){b.addClass("is-transitioning");b[0].offsetWidth}})}})(jQuery);

// Timber functions
window.timber = window.timber || {};

timber.initCache = function () {
  timber.cache = {
    // General
    $html                    : jQuery('html'),
    $body                    : jQuery('body'),
  };
};

timber.init = function () {
  FastClick.attach(document.body);
  timber.initCache();
 // timber.accessibleNav();
  timber.drawersInit();
 // timber.mobileNavToggle();
//  timber.responsiveVideos();
 
};


timber.drawersInit = function () {
  timber.LeftDrawer = new timber.Drawers('NavDrawer', 'right');
	//timber.RightDrawer = new timber.Drawers('inclusions', 'right');
	//	timber.TermsDrawer = new timber.Drawers('terms', 'terms');
	//	timber.EnquireDrawer = new timber.Drawers('enquire', 'enquire');

	//timber.ResourceDrawer = new timber.Drawers('ResourceDrawer', 'resource');
    //timber.ResourceDrawer = new timber.Drawers('MenuDrawer', 'right_menu');

};

timber.getHash = function () {
  return window.location.hash;
};


/*============================================================================
  Drawer modules
  - Docs http://shopify.github.io/Timber/#drawers
==============================================================================*/

timber.Drawers = (function () {
  var Drawer = function (id, position, options) {
    var defaults = {
      close: '.js-drawer-close',
      open: '.js-drawer-open-' + position,
      openClass: 'js-drawer-open',
      dirOpenClass: 'js-drawer-open-' + position
    };

    this.$nodes = {
      parent: jQuery('body, html'),
      page: jQuery('#PageContainer'),
      moved: jQuery('.is-moved-by-drawer')
    };

    this.config = jQuery.extend(defaults, options);
    this.position = position;

    this.$drawer = jQuery('#' + id);

    if (!this.$drawer.length) {
      return false;
    }

    this.drawerIsOpen = false;
    this.init();
  };

  Drawer.prototype.init = function () {
    var $openBtn = jQuery(this.config.open);
    console.log('Drawer.prototype.init');

    // Add aria controls
    $openBtn.attr('aria-expanded', 'false');

    $openBtn.on('click', jQuery.proxy(this.open, this));
    this.$drawer.find(this.config.close).on('click', jQuery.proxy(this.close, this));
  };

  Drawer.prototype.open = function (evt) {
    // Keep track if drawer was opened from a click, or called by another function
    var externalCall = false;

    // don't open an opened drawer
    if (this.drawerIsOpen) {
      return;
    }
	  var $hamburger = jQuery(".hamburger");
    $hamburger.toggleClass("is-active");
    // Prevent following href if link is clicked
    if (evt) {
      evt.preventDefault();
    } else {
      externalCall = true;
    }

    // Without this, the drawer opens, the click event bubbles up to $nodes.page
    // which closes the drawer.
    if (evt && evt.stopPropagation) {
      evt.stopPropagation();
      // save the source of the click, we'll focus to this on close
      this.$activeSource = jQuery(evt.currentTarget);
    }

    if (this.drawerIsOpen && !externalCall) {
      return this.close();
    }

    // Add is-transitioning class to moved elements on open so drawer can have
    // transition for close animation
    this.$nodes.moved.addClass('is-transitioning');
    this.$drawer.prepareTransition();

    this.$nodes.parent.addClass(this.config.openClass + ' ' + this.config.dirOpenClass);
    this.drawerIsOpen = true;

    // Set focus on drawer
    Drawer.prototype.trapFocus(this.$drawer, 'drawer_focus');

    // Run function when draw opens if set
    if (this.config.onDrawerOpen && typeof(this.config.onDrawerOpen) == 'function') {
      if (!externalCall) {
        this.config.onDrawerOpen();
      }
    }

    if (this.$activeSource && this.$activeSource.attr('aria-expanded')) {
      this.$activeSource.attr('aria-expanded', 'true');
    }

    this.bindEvents();
  };

  Drawer.prototype.close = function () {
    // don't close a closed drawer
    if (!this.drawerIsOpen) {
      return;
    }
    var $hamburger = jQuery(".hamburger");
    $hamburger.toggleClass("is-active");
    // deselect any focused form elements
    jQuery(document.activeElement).trigger('blur');

    // Ensure closing transition is applied to moved elements, like the nav
    this.$nodes.moved.prepareTransition({ disableExisting: true });
    this.$drawer.prepareTransition({ disableExisting: true });

    this.$nodes.parent.removeClass(this.config.dirOpenClass + ' ' + this.config.openClass);

    this.drawerIsOpen = false;

    // Remove focus on drawer
    Drawer.prototype.removeTrapFocus(this.$drawer, 'drawer_focus');

    if (this.$activeSource && this.$activeSource.attr('aria-expanded')) {
      this.$activeSource.attr('aria-expanded', 'false');
    }
  


    this.unbindEvents();
  };

  Drawer.prototype.trapFocus = function ($container, eventNamespace) {
    var eventName = eventNamespace ? 'focusin.' + eventNamespace : 'focusin';

    $container.attr('tabindex', '-1');

    $container.focus();

    jQuery(document).on(eventName, function (evt) {
      if ($container[0] !== evt.target && !$container.has(evt.target).length) {
        $container.focus();
      }
    });
  };

  Drawer.prototype.removeTrapFocus = function ($container, eventNamespace) {
    var eventName = eventNamespace ? 'focusin.' + eventNamespace : 'focusin';

    $container.removeAttr('tabindex');
    jQuery(document).off(eventName);
  };

  Drawer.prototype.bindEvents = function() {
    // Lock scrolling on mobile
    this.$nodes.page.on('touchmove.drawer', function () {
      return false;
    });

    // Clicking out of drawer closes it
    this.$nodes.page.on('click.drawer', jQuery.proxy(function () {
      this.close();
      return false;
    }, this));

    // Pressing escape closes drawer
    this.$nodes.parent.on('keyup.drawer', jQuery.proxy(function(evt) {
      if (evt.keyCode === 27) {
        this.close();
      }
    }, this));
  };

  Drawer.prototype.unbindEvents = function() {
    this.$nodes.page.off('.drawer');
    this.$nodes.parent.off('.drawer');
  };

  return Drawer;
})();


timber.init = function () {
  timber.drawersInit();
};

jQuery(timber.init);


