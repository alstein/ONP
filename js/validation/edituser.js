$(document).ready(function() {
	// validate signup form on keyup and submit

        jQuery.validator.addMethod("noSpace", function(value, element) {
                    return value.indexOf(" ") < 0;
                },"Space is not allowed");
	
	$.validator.addMethod("noSpecialChars", function(value, element) {
	      return /^[a-zA-Z\_]+$/i.test(value);
	},"Only A-Z, a-z & _ is allowed without space");
	
	jQuery.validator.addMethod("zipcode", function(value, element) { 
	  return /^\d{5}(-\d{4})?$/.test(value);
	},"Please enter valid Postcode");


jQuery.validator.addMethod("letterspaceonly", function(value, element) {
	return this.optional(element) || /^([a-z]+([\s][a-z]+)?)+$/i.test(value);
	}, "Letters and Single space only");



//      	$.validator.addMethod("numbersonly",
// 	function(value, element)
// 	{
// 	return this.optional(element) || /^[0-9]+$/i.test(value);
// 	}, "Enter number only");
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

  var userid = document.getElementById('userid').value;

  var validator = $("#frmUserProfile").validate({
    errorElement:'div',
    rules: {
         first_name:{
		required: true,
		letterspaceonly:true,
		minlength: 2,
		maxlength:50
         },
         last_name:{
		required: true,
		letterspaceonly:true,
		minlength: 2,
		maxlength:50
         },
		cat_ref:{
			required:true
		},
	address:{
		required:true
	},
        email: {
                required: true,
                email: true,
                emailchk: true,
                minlength: 5,
                maxlength: 50,
                remote: {url:SITEROOT + "/admin/user/ajax_check_user.php?userid="+userid , type:"post"}
        },
        password:{
                minlength: 6,
                maxlength: 20,
                noSpace: true
        },
		  new_password:{
				equalTo: "#password",
                minlength: 6,
                maxlength: 20,
                noSpace: true
        },
        zipcode:{


		postcodes: true,
		minlength: 6,
		maxlength: 8
        },
	countryid: {
		required: true
	},
	
	contactnumber: {

		number:true,
		minlength: 8,
                maxlength: 12
	},
	pimage:{accept: "jpg|jpeg|png|gif|bmp|JPG|JPEG|PNG|GIF|BMP"}
    },
    messages: {
         first_name:{
                required: "Enter first name",
                minlength: jQuery.format("Enter at least {0} characters"),
                maxlength: "required maximum 50 characters"
         },
         last_name:{
                required: "Enter last name",
                minlength: jQuery.format("Enter at least {0} characters"),
                maxlength: "required maximum 50 characters"
         },
	cat_ref:{
			required: "Please select category preferance"
		},
	address:{
		required: "Please enter address"
	},
         email: {
               required: "Please enter email address",
               email: "Please enter a valid email address",
               emailchk: "Please enter a valid email address",
               minlength: jQuery.format("Enter at least {0} characters"),
               maxlength: "required maximum 50 characters",
               remote: "Email is already in use."
         },
         password:{
               minlength: jQuery.format("Enter at least {0} characters"),
               maxlength: jQuery.format("Enter at most {0} characters")
         },
		 new_password:{
				equalTo: "please enter password same as above",
               minlength: jQuery.format("Enter at least {0} characters"),
               maxlength: jQuery.format("Enter at most {0} characters")
         },
			
         
          contactnumber:{
                   
                     minlength:  $.format("Enter at least {0} numbers"),
                     maxlength: $.format("Enter maximum {0} numbers"),
                     number: "Please enter valid phone number."
         },
         zipcode:{
        
			postcodes: "Please enter valid post code/zip code",
			minlength: jQuery.format("Enter at least {0} characters"),
			maxlength: jQuery.format("Enter at most {0} characters")
         },
	countryid: {
		required: "Please select country"
	},
		pimage:{accept: "Please upload jpg,jpeg,png,gif image only"}
       },
           // set this class to error-labels to indicate valid fields
        success: function(label) {
                     // set &nbsp; as text for IE
                     label.hide();
            }
          
  });
  // propose username by combining first- and lastname
  $("#username").focus(function() {
          var first_name = $("#first_name").val();
          var last_name = $("#last_name").val();
          if(first_name && last_name && !this.value) {
                  this.value = first_name + "." + last_name;
                  this.value = this.value.toLowerCase();
          }
  });
});