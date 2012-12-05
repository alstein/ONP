$(document).ready(function() {

        $.validator.addMethod("validemail", function(email, element) {
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
            return emailPattern.test(email);
        }, "Please enter a valid email address");

	// validate signup form on keyup and submit
	 $("#frmcontact").validate({
		errorElement:'div',
		rules: {
			fname: {
				required: true,
                                character: true,
				minlength: 4,
				maxlength: 50
			},
			email: {
				required: true,
                                validemail: true,
				email: true,
				minlength: 4,
				maxlength: 50
			},
			subject: {
				required: true,
				maxlength: 100
			},
			message: {
				//required: true,
				//minlength: 10,
				maxlength: 500
			},
			cap_code:{
				required:true
			},
			
			n1:{
				required: true,
				equalTo:'#cap_code'
			}
		},
		messages: {
			fname: {
				required: "Please enter full name",
				character: "Please enter characters only",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			email: {
				required: "Please enter email address",
				email:"Please enter valid email address",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			subject : {
				required: "Please select subject",
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			message : {
				//required: "Please enter message",
				//minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			cap_code:{
					required: "Please enter the Security Code indicated"
				},
	
			n1:{
					required: "Please enter the Security Code indicated.",
				equalTo: "Enter the code as indicated"
	
			}
		},

		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
	});
        //$('#mg').fadeOut(6000);

});