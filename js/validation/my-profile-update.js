$(document).ready(function() {
	jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != "";
	},"Space is not allowed");

	jQuery.validator.addMethod("noSpaceForPass", function(value, element) { 
	  return value.indexOf(" ") < 0;
	},"Space is not allowed");

   /*$.validator.addMethod("post",function(value, element) {
			var regularex="^([a-zA-Z]){1}([0-9][0-9]|[0-9]|[a-zA-Z][0-9][a-zA-Z]|[a-zA-Z][0-9][0-9]|[a-zA-Z][0-9]){1}([        ])([0-9][a-zA-z][a-zA-z]){1}$";
			var check = false;
			var re = new RegExp(regularex);
			return this.optional(element) || re.test(value);
		},"Please enter a valid postcode.");*/
    $.validator.addMethod("postcodes", function(value, element){
                var temp;
                temp = true;
                str = /[^a-zA-Z0-9 ]/;
                temp = !str.test(value);
                return temp;
         }, "Only 0 to 9, a to z, A to Z and space is allowed.");

	$('#frmprofile').validate({
		errorElement:'div',
		rules: {
			postalcode: {
				postcodes : true,
				minlength: 6,
				maxlength:8
			},
			sec_postalcode: {
				postcodes : true,
				minlength: 6,
				maxlength:8
			}
		},
		messages: {
			postalcode: {
				postcodes: "please enter valid post code/zip code",
				minlength: jQuery.format("Enter at least {0} digits"),
				maxlength: jQuery.format("Enter at most {0} digits")
			},
			sec_postalcode: {
				postcodes: "please enter valid post code/zip code",
				minlength: jQuery.format("Enter at least {0} digits"),
				maxlength: jQuery.format("Enter at most {0} digits")
			}
		},
	      success: function(label) {
		      // set &nbsp; as text for IE
		      label.hide();
	      }
	});
});

