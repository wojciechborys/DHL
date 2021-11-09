(function($){
    "use strict";

    $.widget("custom.combobox", {
        _create: function(){
            this.wrapper = $("<span>")
                .addClass("combobox-wrapper")
                .insertAfter(this.element);

            this.element.hide();
            this._createAutocomplete();
        },

        _createAutocomplete: function(){
            var selected = this.element.children(":selected"),
                value = selected.val() ? selected.text() : "";

            this.input = $("<input>")
                .appendTo(this.wrapper)
                .val(value)
                .addClass("form-control content-calc__input content-calc__input--text content-calc__input--country ui-widget ui-widget-content ui-state-default ui-corner-left")
                .autocomplete({
                    delay: 0,
                    minLength: 0,
                    position: {at: "left bottom", my: "left top", collision: "flip"},
                    source: $.proxy(this, "_source")
                })
                .focus(function(){
                    var $t = $(this);
                    $t.autocomplete("instance").search($t.val());
                });

            this._on(this.input, {
                autocompleteselect: function(event, ui){
                    ui.item.option.selected = true;
                    this._trigger("select", event, {
                        item: ui.item.option
                    });

                //    this.input.trigger('input', event);
                },

                autocompletechange: "_removeIfInvalid"
            });
        },

        _source: function(request, response){
            var matcher = new RegExp('^'+$.ui.autocomplete.escapeRegex(request.term), "i");

            response(this.element.children("option").map(function(){
                var text = $(this).text();

                if (this.value && (!request.term || matcher.test(text))) {
                    return {
                        label: text,
                        value: text,
                        option: this
                    };
                }
            }));
        },

        _removeIfInvalid: function(event, ui){
            // Selected an item, nothing to do
            if (ui.item) {
                return;
            }

            // Search for a match (case-insensitive)
            var value = this.input.val(),
                valueLowerCase = value.toLowerCase(),
                valid = false;

            this.element.children("option").each(function(){
                if ($(this).text().toLowerCase() === valueLowerCase) {
                    this.selected = valid = true;
                    return false;
                }
            });

            // Found a match, nothing to do
            if (valid) {
                return;
            }

            // Remove invalid value
            this.input.val("");
            this.element.val("");

            this.input.autocomplete("instance").term = "";
        },

        _destroy: function(){
            this.wrapper.remove();
            this.element.show();
        }
    });

})(jQuery);
