$(document).ready(function() {
	// validate signup form on keyup and submit
	 $("#frmcomment").validate({
		errorElement:'div',
		rules: {
			comment : {
				required: true,
				minlength: 6,
				maxlength: 400
			}
		},
		messages: {
			comment: {
				required: "Please enter your comment",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			}
		},

		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
	});

});