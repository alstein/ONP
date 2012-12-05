$(document).ready(function() {

	 $("#frmAction").validate({
		errorElement:'div',
		rules: {
			email_id: {
				required: true,
				minlength: 5,
				maxlength: 50
			},
                        message_subject:{
				required: true,
				minlength: 5,
				maxlength: 50,
                        },
                        msg_details:{
                                required: true,
                                minlength: 10,
                                maxlength: 500
                        }	
		},
		messages: {
			email_id: {
				required: "Please enter email address",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
                        message_subject:{
				required: "Please enter subject",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
                        },	
			msg_details: {
				required: "Please enter message",
				minlength: jQuery.format("Please enter at least {0} characters"),
				maxlength: jQuery.format("Please enter at most {0} characters")
			}
		}
	});
        $("#msg").fadeOut(2000);
});
