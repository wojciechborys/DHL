Number.isInteger = Number.isInteger || function(value) {
    return typeof value === "number" && 
           isFinite(value) && 
           Math.floor(value) === value;
};

(function($) {

    var $body = $('body'),
        $document = $(document),
        $window = $(window);

    // fixed navbar
    var FixedNavbar = function(banner, reference) {
        var self = this;

    	this.$navbar = banner.jquery ? banner : $(banner);

        if (Number.isInteger(reference)) {
            this.refDistance = reference;
        } else {
            reference = reference.jquery ? reference : $(reference);
            this.refDistance = reference.offset().top;
        }

    	this.calculate();
    	this.maybeChange();

    	$window.on('resize', function() {
    		self.calculate();
    		self.maybeChange();
    	})
    	.on('scroll', function() {
    		self.maybeChange();
    	});
    };

    FixedNavbar.prototype.calculate = function() {
    	// this.distance = this.$navbar.offset().top;
        this.navbarHeight = this.$navbar.height();
    };

    FixedNavbar.prototype.shouldStick = function() {
        var st, b, d;

        if($body.hasClass('body--always-fixed-baner')) {
          return true;
        }
        
        if (typeof window.pageYOffset !== 'undefined') {
            st = pageYOffset;
        } else {
            b = document.body; //IE 'quirks'
            d = document.documentElement; //IE with doctype

            st = d.clientHeight ? d.scrollTop : b.scrollTop;
        }

    	return (st >= this.navbarHeight);
    };

    FixedNavbar.prototype.maybeChange = function() {
        var hc = this.$navbar.hasClass('banner--fixed');

    	if (this.shouldStick()) {
    		if (!hc) {
    			this._makeSticky();
    		}
    	} else {
    		if (hc) {
    			this._unMakeSticky();
    		}
    	}
    };

    FixedNavbar.prototype._makeSticky = function() {
    	this.$navbar.addClass('banner--fixed');
    	$body.addClass("body--fixed-banner");
    };

    FixedNavbar.prototype._unMakeSticky = function() {
      this.$navbar.removeClass('banner--fixed');
        $body.removeClass("body--fixed-banner");
    };

    window.FixedNavbar = FixedNavbar;

})(jQuery);
