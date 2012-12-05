$(document).ready(function() {

	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	},"Space is not allowed");

$.validator.addMethod("postcodes",function(value, element) {
            var regularex="^([a-zA-Z]){1}([0-9][0-9]|[0-9]|[a-zA-Z][0-9][a-zA-Z]|[a-zA-Z][0-9][0-9]|[a-zA-Z][0-9]){1}([        ])([0-9][a-zA-z][a-zA-z]){1}$"; 
					var check = false;
            var re = new RegExp(regularex);
            return this.optional(element) || re.test(value);
        },
        "Please enter a valid postcode."
    );


	$('#frmt').validate({
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
			uname:{
			    required:true,
			    minlength: 4,
			    maxlength: 50,
			    remote: {url:SITEROOT + "/modules/signupconfirm/ajax_check_user.php",type:"post"},
			    noSpace: true
			},
			fname:{
			    required:true,
			    character: true,
			    minlength: 4,
			    maxlength: 100,
			    noSpace: true
			},
			lname:{
			    required:true,
			    character: true,
			    minlength: 4,
			    maxlength: 100,
			    noSpace: true
			},
			zip:{
			    required:true,
                             postcodes:true
			},
			contact:{
			    required:true
			},
                         companyname:{
			    required:true
                            
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
			uname:{
				required: "Please enter username",
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters."),
				remote: "This username is already exist"
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
				required: "Please enter postal code"
			},
			contact:{
				required: "Please enter contact details"
			},
                         companyname:{
				required: "Please enter company name"
			}
			
		},
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
        });
});

