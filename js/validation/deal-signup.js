$(document).ready(function() {

	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	}, "Space is not allowed");

	$('#dealsignup').validate({
		    errorElement:'div',
		    rules: {
			    email:{
				    required: true,
				    email: true,
				    minlength: 4,
				    maxlength: 50,
				    remote: {url:SITEROOT + "/modules/signupconfirm/ajax_check_user.php",type:"post"}
			    },
			    addrline1:{
				    required: true,
				    maxlength: 255
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
			    },
                            zip:{
				required:true
			    },
			    uname:{
				required:true,
				minlength: 4,
				maxlength: 50
			    },
			    buyername:{
				required:true,
				minlength: 4,
				maxlength: 50
			    }
		    },
		    messages: {
			    email:{
				    required: "Please enter an email address.",
				    email: "Please enter a valid email address.",
				    minlength: jQuery.format("Enter at least {0} characters."),
				    maxlength: jQuery.format("Enter at most {0} characters."),
				    remote: "This email address is already registered"
			    },
			    addrline1:{
				    required: "Please enter address",
				    maxlength: jQuery.format("Enter at most {0} characters.")
			    },
			    password:{
				    required: "Please enter password",
				    minlength: jQuery.format("Enter at least {0} characters."),
				    maxlength: jQuery.format("Enter at most {0} characters.")
			    },
			    confirm_password: {
				    required: "Please enter your password again.",
				    equalTo: "Please enter the same password as above"
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
			    },
			    zip:{
				    required: "Please enter zip code"
			    },
			    uname:{
				    required: "Please enter username",
				    minlength: jQuery.format("Enter at least {0} characters."),
				    maxlength: jQuery.format("Enter at most {0} characters.")
			    },
			    buyername:{
				    required: "Please enter fullname",
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

