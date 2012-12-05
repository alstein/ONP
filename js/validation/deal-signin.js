$(document).ready(function() {


         jQuery.validator.addMethod("noSpace", function(value, element) { 
                return value.indexOf(" ") < 0 && value != ""; 
                }, "Only A-Z, a-z & _ is allowed without space");

	 $("#dealsignin").validate({
        
       
   
        

		errorElement:'div',
		rules: {
			lemail : {
				required: true,
                                noSpace: true,
				email: true
			},
			lpassword : {
				required: true
			}
		},
		messages: {
			lemail: {
				required: "Please enter email address",
				email: "Please enter valid email address"
			},
			lpassword: {
				required: "Please provide password"
			}
		},

		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
	});
});