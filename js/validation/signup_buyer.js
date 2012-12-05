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

	$('#frm_buyer').validate({
		errorElement:'div',
		rules: {
			email:{
				required: true,
				email: true,
				minlength: 4,
				maxlength: 50,
				remote: {url:SITEROOT + "/modules/signupconfirm/ajax_check_user.php",type:"post"}
			},
			uname:{
			    required:true,
			    minlength: 4,
			    maxlength: 50,
			    remote: {url:SITEROOT + "/modules/signupconfirm/ajax_check_user.php",type:"post"},
			    noSpace: true
			},
			buyername:{
			    required:true,
			    character: true,
			    minlength: 4,
			    maxlength: 100
			},
			password:{
				required: true,
				minlength: 6,
				maxlength: 20,
				noSpace: true
			},
			confirm_password: {
				required: true,
				equalTo:'#password'
			},
                        postalcode: {
				postcodes: true
				
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
			uname:{
				required: "Please enter username",
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters."),
				remote: "This username is already exist."
			},
			buyername:{
				required: "Please enter fullname",
				character: "Please enter characters only",
				minlength: jQuery.format("Enter at least {0} characters."),
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
			}
		},
	      success: function(label) {
		      // set &nbsp; as text for IE
		      label.hide();
	      }
	});
});

