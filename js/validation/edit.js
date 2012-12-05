$(document).ready(function() {

	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	}, "Space is not allowed");

	$('#frmEdit').validate({
		    errorElement:'div',
		    rules: {
                            email:{
				required:true,
				email: true
			    },    
			    buyername:{
				required:true,
				noSpace: true,
				minlength: 4,
				maxlength: 50
			    },
			    fname:{
				required:true,
				noSpace: true,
				character: true,
				minlength: 4,
				maxlength: 100
			    },
			    lname:{
				required:true,
				noSpace: true,
				character: true,
				minlength: 4,
				maxlength: 100
			    }
		    },
		    messages: {
                             email:{
				    required: "Please enter email",
				    email: "Enter valid email id"
			    },    
			    buyername:{
				    required: "Please enter username",
				    minlength: jQuery.format("Enter at least {0} characters."),
				    maxlength: jQuery.format("Enter at most {0} characters.")
			    },
			    fname:{
				    required: "Please enter first name",
				    character: "Please enter characters only",
				    minlength: jQuery.format("Enter at least {0} characters."),
				    maxlength: jQuery.format("Enter at most {0} characters.")
			    },
			    lname:{
				    required: "Please enter last name",
				    character: "Please enter characters only",
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

