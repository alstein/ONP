jQuery(document).ready(function() {
	jQuery("#openinviter").validate({
		errorElement:'div',
		rules: {
			email_box: {
				required: true,
				email: true
			}
		},
		messages: {
			email_box: {
				required: "Please enter email address",
				 email:"Please enter a valid email address"
			}
		},
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
	});
	jQuery("#msg").fadeOut(5000);
});
