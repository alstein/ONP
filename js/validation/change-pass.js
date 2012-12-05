$(document).ready(function(){

	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	},"Space is not allowed");

	$("#frmPass").validate({
		errorElement:'div',
		rules:{
			oldpassword:{
				required: true,
				noSpace: true,
				minlength:6,
				maxlength:20
			},
			password:{
				required: true,
				noSpace: true,
				minlength: 6,
				maxlength: 20
			},
			confirm_password: {
				required: true,
				equalTo:'#password'
			}
		},
		messages:{
		        oldpassword:{
				required: "Please enter your old password",
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters.")
			},
		        password:{
				required: "Please enter your password",
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters.")
			},
		        confirm_password: {
				required: "Please enter your password again.",
				equalTo: "Enter the same password as above"
			}
	        },
		success: function(label) {
			// set &nbsp; as text for IE
		    label.hide();
		}
	});
});