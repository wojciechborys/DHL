jQuery(function(a){function e(){return wp.media({title:"Wstaw obraz",library:{type:"image"},button:{text:"Uzyj obrazu"},multiple:!1})}function t(e){return a("<img />").attr("src",e).attr("class","ap-image").attr("data-choose-image","")}var i;a("body").on("click","[data-choose-image]",function(o){var n=a(this),d=n.closest("[data-image-box]").find("[data-image-preview]"),r=n.closest("[data-image-box]").find("[data-image-id]");o.preventDefault(),i||(i=e(),i.on("select",function(){var a=i.state().get("selection").first().toJSON(),e=t(a.url);d.find("[data-choose-image]").remove(),e.appendTo(d),r.val(a.id),n.parent().find("[data-remove-image]").removeClass("hidden")})),i.open()}).on("click","[data-remove-image]",function(e){var t=a(this);e.preventDefault(),t.addClass("hidden").closest("[data-image-box]").find("[data-image-preview]").children().remove(),t.closest("[data-image-box]").find("[data-image-id]").val("")})});
//# sourceMappingURL=admin-post.js.map