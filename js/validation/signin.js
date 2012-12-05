$(document).ready(function()
{
	jQuery.validator.addMethod("noSpace", function(value, element) {
	  return value.indexOf(" ") < 0 && value != ""; 
	},"Space is not allowed");

	$.validator.addMethod("postcodes",function(value, element) {
			var regularex="^([a-zA-Z]){1}([0-9][0-9]|[0-9]|[a-zA-Z][0-9][a-zA-Z]|[a-zA-Z][0-9][0-9]|[a-zA-Z][0-9]){1}([        ])([0-9][a-zA-z][a-zA-z]){1}$"; 
			var check = false;
			var re = new RegExp(regularex);
			return this.optional(element) || re.test(value);
		},"Please enter a valid postcode."
	);

	jQuery.validator.addMethod("email", function(value, element) {
		var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		return rege.test($('#email').val());
	},"Please enter valid email address");

	jQuery.validator.addMethod("sellerEmail", function(value, element) {
		var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		return rege.test(document.forms['frmsigninSeller']['email'].value);
	},"Please enter valid email address");
	

	$('#frmsignin').validate({
		errorElement:'div',
		rules: {
			email:{
				required: true,
				email: true,
				minlength: 4,
				maxlength: 50
			},
			pass:{
				required: true,
				minlength: 6,
				maxlength: 20
			}
		},
		messages: {
			email:{
				required: "Please enter an email address.",
				email: "Please enter a valid email address.",
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters.")
			},
			pass:{
				required: "Please enter password",
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters.")
			}
		},
	      success: function(label) {
		      // set &nbsp; as text for IE
		      label.hide();
	      }
	});

	$('#frmsigninSeller').validate({
		errorElement:'div',
		rules: {
			email:{
				required: true,
				sellerEmail: true,
				minlength: 4,
				maxlength: 50
			},
			pass:{
				required: true,
				minlength: 6,
				maxlength: 20
			}
		},
		messages: {
			email:{
				required: "Please enter an email address.",
				sellerEmail: "Please enter a valid email address.",
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters.")
			},
			pass:{
				required: "Please enter password",
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

// START Other functions

function changeFrm(type)
{
	if(type == 'seller')
	{
		$('#frmsignin').hide();
		$('#frmsigninSeller').show();
		$('#signinLbl').html('Seller');
	}else
	{
		$('#frmsigninSeller').hide();
		$('#frmsignin').show();
		$('#signinLbl').html('Buyer');
	}
}

// END Other functions

