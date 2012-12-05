$(document).ready(function() {

	$('#frmdeal').validate({
		    errorElement:'div',
		    rules: {
			name_of_key:{
				required: true,
				minlength: 2,
				maxlength: 50
				
			},
			phone_no:{
				required: true,
				number: true,
				//minlength:10,
				maxlength:12
			},
			mail:{
				required: true,
				email: true
			},
			agree:{
				required: true
			}

		    },
		    messages: {
			name_of_key:{
				required: "Please enter the name of key.",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			phone_no:{
				required: "Please enter the phone no..",
			//	minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			
			},
			mail:{
				required: "Please enter email.",
				email: "Please enter correct email address",
			        emailchk: "Please enter correct email address"
			},
			agree:{
				required: "Please Agree to Term & Conditions."
			}
		},
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
        });
});

