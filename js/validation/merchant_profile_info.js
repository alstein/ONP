$(document).ready(function() {  
jQuery.validator.addMethod("noSpace", function(value, element) {
	return value.indexOf(" ") < 0 && value != ""; 
}, "Only A-Z, a-z & _ is allowed without space");

	$.validator.addMethod("noSpecialChars", function(value, element) {
		return /^[a-zA-Z\_]+$/i.test(value);
	}, "Only A-Z, a-z & _ is allowed without space");

	$.validator.addMethod("postcodes", function(value, element){
		var temp;
		temp = true;
		str = /[^a-zA-Z0-9 ]/;
		temp = !str.test(value);
		return temp;
	}, "Only 0 to 9, a to z, A to Z and space is allowed.");

	$.validator.addMethod("alphaOnly", function(value, element){
		var temp;
		temp = true;
		str = /[^a-zA-Z - & @ # $ ^ & % * ( ) !]/;
		temp = !str.test(value);
		return temp;
	}, "Only a to z, A to Z and special charecters is allowed.");

	jQuery.validator.addMethod("url_double_dot", function(value, element) {
		for(var i=0; i<value.length; i++)
		{
			if(value[i] == '.' && value[(parseInt(i)+1)] == '.')
				return false;
		}
		return true;
	},"Please enter valid URL");


jQuery.validator.addMethod("emailchk", function(value, element) {
		var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		return rege.test($('#email').val());
},"Please enter valid email address");

	$('#frmMerchantRegistration').validate({ 
		    errorElement:'div',
		    rules: {
			email:{ 
				
				required: true,
				email: true,
				emailchk:true,
				remote: "http://testwww.offersnpals.com/admin/user/ajax_check_whole_user.php"
			},
			password:{
				required: true,
				noSpace:true,
				minlength: 6,
				maxlength: 20
			},
			cpassword:{
				required: true,
				equalTo: "#password"
			},
			business_name: {
				required: true,
				minlength: 3,
				maxlength: 100,
				alphaOnly:true
				
			},
			contact_person:{
			    	required: true,
				minlength: 3,
				maxlength: 100,
				alphaOnly:true
			   
			},
			address1:{
				required: true,
				minlength: 3,
				maxlength:500
			},
			countryid:{
				required: true
				
			},
			state:{
				required: true
				
			},
			cityid:{
				required: true
				
			},
			phone:{
				required:true,
			    number:true,
				//minlength: 10,
				maxlength:12
			},
			website:{
			  //  url:true,
				maxlength:255
			}

		    },
		    messages: {
			email:{
				required: "Please enter email address",
				email: "Please enter correct email address",
				emailchk:"Please enter correct email address",
				remote: "This email address is already in use"
				
			},
			password:{
				required: "please enter password",
				noSpace: "Space is not allowed",
				minlength: $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter at least {0} characters")
			},
			cpassword: {
				required: "please enter confirm password",
				equalTo: "please enter password same as above"
			},
			first_name:{
				required: "Please enter first name",
				minlength: $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			last_name:{
				required: "Please enter last name",
				minlength: $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			business_name:{
				required: "Please enter business name",
				minlength: $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			contact_person:{
				required: "Please enter contact person",
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters.")
			},
			address1:{
				required: "Please enter address.",
				minlength: $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			countryid:{
				required: "Please select Country."
			},
			state:{
				required: "Please select state."
			},
			cityid:{
				required: "Please select city."
			},
			phone:{
				required: "Please enter Phone number",
				number: "Please enter number",
				//minlength: $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter at least {0} characters")
			},
			website:{
				url: "Please enter valid URL",
				maxlength:$.format("Enter maximum {0} characters")
			
			}
			
		},
		success: function(label) {  
			// set &nbsp; as text for IE
			label.hide();
		}
        });
		
});

