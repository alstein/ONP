$(document).ready(function(){


	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	}, "Space is not allowed");

	$("#frmReset").validate({
		errorElement:'div',
		rules: {
			newpass:{
				required: true,
				noSpace: true,
				minlength:6,
				maxlength:20
			},
			conpass:{
				required: true,
				equalTo: '#newpass'
			}
		},
		messages: {
			newpass:{
				required: "Please enter new password",
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters.")
			},
			conpass:{
				required: "Please enter confirm password",
				equalTo: "Enter the same password as above"
			}
		}
	});
});
