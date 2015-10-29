var Wpfc_New_Dialog = {
	id : "",
	buttons: [],
	clone: "",
	dialog: function(id, buttons){
		var self = this;
		self.clone = jQuery("div[template-id='" + id + "']").clone();

		self.id = id + "-" + new Date().getTime();
		self.buttons = buttons;
		
		self.clone.attr("id", self.id);
		self.clone.removeAttr("template-id");

		jQuery("body").append(self.clone);
		
		self.clone.show();
		
		self.clone.draggable();
		self.clone.position({my: "center", at: "center", of: window});
		self.clone.find(".close-wiz").click(function(){
			self.remove(this);
		});
		
		self.show_buttons();
	},
	remove: function(button){
		jQuery(button).closest("div[id^='wpfc-modal-']").remove();
	},
	show_buttons: function(){
		var self = this;
		if(typeof self.buttons != "undefined"){
			jQuery.each(self.buttons, function( index, value ) {
				self.clone.find("button[action='" + index + "']").show();
				self.clone.find("button[action='" + index + "']").click(function(){
					value(this);
				});
			});
		}
	}
};