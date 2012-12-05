$(document).ready(function() {
	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	},"Space is not allowed");
	
	$.validator.addMethod("alphaOnly", function(value, element){
                var temp;
                temp = true;
                str = /[^a-zA-Z -]/;
                temp = !str.test(value);
                return temp;
         }, "Only a to z, A to Z and - is allowed.");

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

//      $.validator.addMethod("numbersonly",
// 	function(value, element)
// 	{
// 	return this.optional(element) || /^[0-9]+$/i.test(value);
// 	}, "Enter number only");


// $.validator.addMethod("postcodes",function(value, element) {
//             var regularex="^([a-zA-Z]){1}([0-9][0-9]|[0-9]|[a-zA-Z][0-9][a-zA-Z]|[a-zA-Z][0-9][0-9]|[a-zA-Z][0-9]){1}([        ])([0-9][a-zA-z][a-zA-z]){1}$"; 
// 					var check = false;
//             var re = new RegExp(regularex);
//             return this.optional(element) || re.test(value);
//         },
//         "Please enter a valid postcode."
//     );

	$('#frmregistration').validate({
		errorElement:'div',
		rules: {
			first_name:{
				required:true,
				minlength: 4,
				maxlength: 50,
				noSpace: true,
				alphaOnly: true
			},
			last_name:{
				required:true,
				minlength: 4,
				maxlength: 50,
				noSpace: true,
				alphaOnly: true
			},
			address:{
				required:true
			},
			email:{
				required: true,
				email: true,
				emailchk:true,
				minlength: 4,
				maxlength: 50,
 				remote: SITEROOT + "/modules/registration/ajax_check_user.php"
			},
			password:{
				required: true,
				minlength: 6,
				maxlength: 20,
				noSpace: true
			},
			re_password: {
				required: true,
				equalTo:'#password'
			},
			countryid: {
				required: true
			},
			state: {
				required: true
			},
			city: {
				required: true
			},
			postalcode: {
				required: true,
				postcodes: true,
				minlength: 6,
				maxlength: 8
			},
			contact_detail: {
				number: true
			},
			terms: {
				required: true
			}
		},
		messages: {
			first_name:{
				required: "Please enter first name",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters"),
				noSpace:  "Please enter valid first name",
				alphaOnly:  "Please enter valid first name"
			},
			last_name:{
				required: "Please enter last name",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters"),
				noSpace:  "Please enter valid last name",
				alphaOnly:  "Please enter valid last name"
			},
			address:{
				required: "Please enter address"
			},
			email:{
				required: "Please enter an email address",
				email: "Please enter a valid email address",
				emailchk:"Please enter a valid email address",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters"),
				remote: "This email address is already registered"
			},
			password:{
				required: "Please enter password",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			re_password: {
				required: "Please enter your password again",
				equalTo: "Please enter the same password as above"
			},
			countryid: {
				required: "Please select country"
			},
			state: {
				required: "Please select Countie State"
			},
			city: {
				required: "Please select City Town"
			},
			postalcode: {
				required:"Please enter postcode",
				postcodes: "Please enter valid post code/zip code",
                                minlength: jQuery.format("Enter at least {0} characters"),
                                maxlength: jQuery.format("Enter at most {0} characters")
			},
			contact_detail: {
				number: "Please enter numeric value only"
			},
			terms: {
				required: "Please accept the terms and conditions"
			}
		},
	      success: function(label) {
		      // set &nbsp; as text for IE
		      label.hide();
	      }
	});
});

