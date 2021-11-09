/**!
 * uiMorphingButton_fixed.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */
;( function(window, $) {
	'use strict';

	var transEndEventNames = {
			'transition': 'transitionend',
			'WebkitTransition': 'webkitTransitionEnd',
			'MozTransition': 'transitionend',
			'OTransition': 'oTransitionEnd',
			'msTransition': 'MSTransitionEnd'
		},
        support = {},
        div = document.createElement('div'),
		transEndEventName, t;

    for (t in transEndEventNames) {
        if (typeof div.style[t] !== 'undefined') {
            transEndEventName = transEndEventNames[t];
            support.transitions = true;
            break;
        }
    }

    var $body = $('body');

	function extend( a, b ) {
		for (var key in b) {
			if( b.hasOwnProperty( key ) ) {
				a[key] = b[key];
			}
		}
		return a;
	}

	function UIMorphingButton( el, options ) {
		this.el = el.jquery ? el : $(el);

		extend( this.options, options );
		this._init();
	}

	UIMorphingButton.prototype.options = {
        buttonSelector:'[data-morph="button"]',
        contentSelector:'[data-morph="content"]',
		closeEl : '[data-morph="close"]',
        activeClass: 'morph--active',
        openClass: 'morph--open',
        scrollClass: 'morph--scroll',
        bodyNoScrollClass: 'body--noscroll',
        noTransitionClass: 'morph__content--no-transition',
		onBeforeOpen : function() { return false; },
		onAfterOpen : function() { return false; },
		onBeforeClose : function() { return false; },
		onAfterClose : function() { return false; }
	};

	UIMorphingButton.prototype._init = function() {
		// the button
	//	this.button = this.el.querySelector( 'button' );
		this.button = this.el.find( this.options.buttonSelector );
		// state
		this.expanded = false;
		// content el
	//	this.contentEl = this.el.querySelector( '.morph-content' );
		this.contentEl = this.el.find( this.options.contentSelector );
		// init events
		this._initEvents();
	};

	UIMorphingButton.prototype._initEvents = function() {
		var self = this;
		// open
		this.button.on( 'click', function(e){
            e.preventDefault();
            self.toggle(); }
        );

		// close
		if (this.options.closeEl !== '') {
			var closeEl = this.el.find( this.options.closeEl );

			if( closeEl.length ) {
				closeEl.on('click', function(e) {
                    e.preventDefault();
                    self.toggle();
                });
			}
		}
	};

	UIMorphingButton.prototype.toggle = function() {
		if (this.isAnimating){
            return false;
        }

		// callback
		if ( this.expanded ) {
            this.el.removeClass( this.options.scrollClass );
            $body.removeClass( this.options.bodyNoScrollClass );
			this.options.onBeforeClose();
		} else {
			// add class active (solves z-index problem when more than one button is in the page)
		//	classie.addClass( this.el, 'active' );
			this.el.addClass( this.options.activeClass );
			this.options.onBeforeOpen();
		}

		this.isAnimating = true;

		var self = this,
			onEndTransitionFn = function( ev ) {
				if( ev.target !== this ) {
                    return false;
                }

				if( support.transitions ) {
					// open: first opacity then width/height/left/top
					// close: first width/height/left/top then opacity
					if( self.expanded && ev.originalEvent.propertyName !== 'opacity' || !self.expanded && ev.originalEvent.propertyName !== 'width' && ev.originalEvent.propertyName !== 'height' && ev.originalEvent.propertyName !== 'left' && ev.originalEvent.propertyName !== 'top' ) {
						return false;
					}
				//	this.removeEventListener( transEndEventName, onEndTransitionFn );
					$(this).off( transEndEventName, onEndTransitionFn );
				}

				self.isAnimating = false;

				// callback
				if( self.expanded ) {
					// remove class active (after closing)
				//	classie.removeClass( self.el, 'active' );
					self.el.removeClass( self.options.activeClass + ' ' + self.options.scrollClass );
					self.options.onAfterClose();
				} else {
                    self.el.addClass( self.options.scrollClass );
                    $body.addClass( self.options.bodyNoScrollClass );
					self.options.onAfterOpen();
				}

				self.expanded = !self.expanded;
			};

		if( support.transitions ) {
		//	this.contentEl.addEventListener( transEndEventName, onEndTransitionFn );
			this.contentEl.on( transEndEventName, onEndTransitionFn );
		}
		else {
			onEndTransitionFn();
		}

		// set the left and top values of the contentEl (same like the button)
		var buttonPos = this.button.get(0).getBoundingClientRect();
		// need to reset
	//	classie.addClass( this.contentEl, 'no-transition' );
		this.contentEl.addClass( this.options.noTransitionClass );
	//	this.contentEl.style.left = 'auto';
	//	this.contentEl.style.top = 'auto';
		this.contentEl.css({
            left: 'auto',
            top: 'auto'
        });

		// add/remove class "open" to the button wraper
		window.setTimeout( function() {
		//	self.contentEl.style.left = buttonPos.left + 'px';
		//	self.contentEl.style.top = buttonPos.top + 'px';
			self.contentEl.css({
                left: buttonPos.left + 'px',
                top: buttonPos.top + 'px'
            });

			if( self.expanded ) {
			//	classie.removeClass( self.contentEl, 'no-transition' );
                self.contentEl.removeClass( self.options.noTransitionClass );
			//	classie.removeClass( self.el, 'open' );
				self.el.removeClass( self.options.openClass );
			} else {
				window.setTimeout( function() {
				//	classie.removeClass( self.contentEl, 'no-transition' );
                    self.contentEl.removeClass( self.options.noTransitionClass );
				//	classie.addClass( self.el, 'open' );
					self.el.addClass( self.options.openClass );
				}, 25 );
			}
		}, 25 );
	};

	// add to global namespace
	window.UIMorphingButton = UIMorphingButton;

})(window, jQuery);
