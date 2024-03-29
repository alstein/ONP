$(document).ready(function(){

	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	},"Only A-Z, a-z & _ is allowed without space");
	
	$.validator.addMethod("noSpecialChars", function(value, element) {
	      return /^[a-zA-Z\_]+$/i.test(value);
	},"Only A-Z, a-z & _ is allowed without space");
	
	jQuery.validator.addMethod("zipcode", function(value, element) { 
	  return /^\d{5}(-\d{4})?$/.test(value);
	},"Please enter valid Postcode");

	$.validator.addMethod("postcodes", function(value, element){
			var temp;
			temp = true;
			str = /[^a-zA-Z0-9 ]/;
			temp = !str.test(value);
			return temp;
	}, "Only 0 to 9, a to z, A to Z and space is allowed.");

	jQuery.validator.addMethod("emailchk", function(value, element) {
			var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			return rege.test($('#email').val());
	},"Please enter valid email address");

	$("#frmRegistration").validate({
		errorElement:'div',
		rules: {
		      first_name:{
			      required: true,
			      noSpace:true,
			      noSpecialChars:true,
			      minlength: 2,
			      maxlength:50
		      },
		      last_name:{
			      required: true,
			      noSpace:true,
			      noSpecialChars:true,
			      minlength: 2,
			      maxlength:50
		      },
		      username:{
			      required: true,
			      noSpace:true,
			      minlength: 4,
			      maxlength:30,
			      remote: SITEROOT + "/admin/user/ajax_check_admin_user.php"
		      },
			address:{
				required:true
			},
		      email:{
			      required: true,
			      email: true,
			      emailchk: true,
			     remote: SITEROOT + "/admin/user/ajax_check_whole_user.php"
		      },
		      password:{
			      required: true,
			      noSpace:true,
			      minlength:6,
			      maxlength:15
		      },
		      zipcode:{
			      required: true,
				postcodes: true,
				minlength: 6,
				maxlength: 8,
				number:true

		      },
		      cpassword: {
			      required: true,
			      equalTo:'#password'
		      },
			countryid: {
				required: true
			},
			city: {
				required: true
			},
			level: {
				required: true
			}
		},
		messages: {
		      first_name:{
			      required: "Please enter first name",
			      minlength:  $.format("Enter at least {0} characters"),
			      maxlength: $.format("Enter maximum {0} characters")
		      },
		      last_name:{
			      required: "Please enter last name",
			      minlength: $.format("Enter at least {0} characters"),
			      maxlength: $.format("Enter maximum {0} characters")
		      },
		      username:{
			      required: "Please enter username",
			      minlength: $.format("Enter at least {0} characters"),
			      maxlength: $.format("Enter maximum {0} characters"),
			      remote: "This username is already in use"
		      },
			address:{
				required: "Please enter address"
			},
		      email:{
			      required: "Please enter email address",
			      email: "Please enter correct email address",
			      emailchk: "Please enter correct email address",
			      remote: "This email address is already in use"
		      },
		      password:{
			      required: "Please enter password",
			      minlength: $.format("Please enter at least {0} characters"),
			      maxlength: $.format("$site_updatesEnter maximum {0} characters")
		      },
		      zipcode:{
                                required:"Please enter postcode",
				postcodes: "Please enter valid post code/zip code",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
                      },
		      cpassword: {
			      required: "Please type your password again.",
			      equalTo: "Enter the same password as above"
		      },
			countryid: {
				required: "Please select country"
			},
			city: {
				required: "Please enter city"
			},
			level: {
				required: "Please select access level"
			}
		}
	});
	
	// propose username by combining first- and lastname
	$("#username").focus(function() {
				var first_name = $("#first_name").val();
				var last_name = $("#last_name").val();
				if(first_name && last_name && !this.value) {
							this.value = first_name + "_" + last_name;
							this.value = this.value.toLowerCase();
				}
	});
});
