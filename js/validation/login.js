$(document).ready(function() {

	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	},"Space is not allowed");



	$('#frm').validate({
		    errorElement:'div',
		    rules: {
			lemail:{
				required: true,
				email: true
			},
			lpassword:{
				required: true,
				noSpace: true,
				minlength: 6,
				maxlength: 20
			}
			
		},
		    messages: {
			lemail:{
				required: "Please enter an email id.",
				email: "Please enter a valid email id."
				
			},
			lpassword:{
				required: "Please enter password",
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters.")
			}
			
		},
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
        });
});

