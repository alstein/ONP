$(document).ready(function() {


	$('#sub').validate({
		    errorElement:'div',
		rules: {
                        sub_email: {
                                    required: true,
                                    email: true
                                },
			sub_code: {
                                    required: true,
                                    number: true
                                }

		},
		messages: {
                        sub_email: {
                                    required: "Please enter email address",
                                    email: "Please enter valid email address"
                                },
                        sub_code: {
                                    required: "Please enter your postcode",
                                    number: "Only enter numaric"
                                }
			
		}
	
	});
	jQuery("#msg").fadeOut(5000);
});
