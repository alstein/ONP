$(document).ready(function(){
//document.getElementById('password').focus();
jQuery.validator.addMethod("noSpace", function(value, element) { 
  return value.indexOf(" ") < 0 && value != ""; 
}, "Only A-Z, a-z & _ is allowed without space");

$.validator.addMethod("noSpecialChars", function(value, element) {
       return /^[a-zA-Z\_]+$/i.test(value);
}, "Only A-Z, a-z & _ is allowed without space");

jQuery.validator.addMethod("zipcode", function(value, element) { 
  return /^\d{5}(-\d{4})?$/.test(value);
}, "Please enter valid Postcode");


	$("#reg").validate({
		errorElement:'div',
		rules:{
			email: {
				required: true,
				email: true,
				remote: {url:SITEROOT + "/modules/rconfirm/ajax_check_user.php",type:"post"}
			},
			city:{
				required:true
			},
			password:{
				required: true,
				minlength:6,
				maxlength:20
			},
			fname:{
				required:true,
				minlength: 2,
				maxlength: 100,
            noSpace: true,
            noSpecialChars:true
			},
         lname:{
            required:true,
            minlength: 2,
            maxlength: 100,
            noSpace: true,
            noSpecialChars:true
         },
         Pcode:{
            required:true
         }
		},
	
		messages:{
			email: {
				required: "Please enter email address",
				email: "Please enter valid email address",
				remote: "This email address is already a registered"
			},
			city:{
				required: "Please enter city"
			},
			password:{
				required:"Please enter your password"
			},
			fname:{
				required: "Please enter your first name"
			},
			lname:{
				required: "Please enter last name"
			},
			Pcode:{
				required: "Please enter postcode"
			}
		},
		success: function(label) {
			label.hide();
		}
	});
});