/*$(document).ready(function() {
	$.validator.addMethod("noSpace", function(value, element) { 
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

	$.validator.addMethod("emailchk", function(value, element) {
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

	$('#frmnewslettreg').validate({
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
			email:{
				required: true,
				email: true,
				emailchk:true,
				minlength: 4,
				maxlength: 50
			},
			location: {
				required: true,
				minlength: 4,
				maxlength: 50
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
			email:{
				required: "Please enter an email address",
				email: "Please enter a valid email address",
				emailchk:"Please enter a valid email address",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			},
			location: {
				required: "Please enter location",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			}
		},
	      success: function(label) {
		      // set &nbsp; as text for IE
		      label.hide();
	      }
	});
});
*/

function validateSubscriber(frmObj)
{
// 	document.getElementById('error_first_name').innerHTML="";
// 	document.getElementById('error_last_name').innerHTML="";
	document.getElementById('error_email').innerHTML="";
	document.getElementById('error_location').innerHTML="";
// 	document.getElementById('error_password').innerHTML="";
// 	document.getElementById('error_re_password').innerHTML="";
	document.getElementById('error_contact_detail').innerHTML="";
	var isError = true;

/*
	var fname = (frmObj.first_name.value).replace(/^[\s]+/g,"");
	if(fname.replace(/^[\s]+/g,"")=="")
	{
		document.getElementById('error_first_name').innerHTML="Please enter first name";
		isError = false;
	}else
	{
		if(!IsText(fname))
		{
			document.getElementById('error_first_name').innerHTML="Please enter valid first name";
			isError = false;
		}

		if(fname.length < 4)
		{
			document.getElementById('error_first_name').innerHTML="Please enter at least 4 characters";
			isError = false;
		}
	}

	var lname = (frmObj.last_name.value).replace(/^[\s]+/g,"");
	if(lname.replace(/^[\s]+/g,"")=="")
	{
		document.getElementById('error_last_name').innerHTML="Please enter surname";
		isError = false;
	}else
	{
		if(!IsTextWithSpace(lname))
		{
			document.getElementById('error_last_name').innerHTML="Please enter valid surname";
			isError = false;
		}

		if(fname.length < 4)
		{
			document.getElementById('error_last_name').innerHTML="Please enter at least 4 characters";
			isError = false;
		}
	}
*/

	var emailid = (frmObj.email.value).replace(/^[\s]+/g,"");
	if(emailid.replace(/^[\s]+/g,"")=="")
	{
		document.getElementById('error_email').innerHTML="Please enter email";
		isError = false;
	}else
	{
		if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailid)))
		{
			document.getElementById('error_email').innerHTML="Please enter valid email";
			isError = false;
		}
	}

	var location = (frmObj.location.value).replace(/^[\s]+/g,"");
	if(location.replace(/^[\s]+/g,"")=="")
	{
		document.getElementById('error_location').innerHTML="Please select location";
		isError = false;
	}/*else
	{
		if(!IsTextWithSpace(location))
		{
			document.getElementById('error_location').innerHTML="Please select valid location";
			isError = false;
		}
	}*/

/*
	var password = (frmObj.password.value).replace(/^[\s]+/g,"");
	if(password.replace(/^[\s]+/g,"")=="")
	{
		document.getElementById('error_password').innerHTML="Please enter password";
		isError = false;
	}else
	{
		if(!IsPassword(password))
		{
			document.getElementById('error_password').innerHTML="Please enter valid password";
			isError = false;
		}

		if(password.length < 6)
		{
			document.getElementById('error_password').innerHTML="Please enter at least 6 characters";
			isError = false;
		}
	}

	var re_password = (frmObj.re_password.value).replace(/^[\s]+/g,"");
	if(re_password.replace(/^[\s]+/g,"")=="")
	{
		document.getElementById('error_re_password').innerHTML="Please enter your password again";
		isError = false;
	}else
	{
		if(password.replace(/^[\s]+/g,"") != re_password.replace(/^[\s]+/g,""))
		{
			document.getElementById('error_re_password').innerHTML="Please enter the same password again";
			isError = false;
		}
	}
*/

	var contact_detail = (frmObj.contact_detail.value).replace(/^[\s]+/g,"");
	if(contact_detail.replace(/^[\s]+/g,"")!="")
	{
		if(!IsNumber(contact_detail))
		{
			document.getElementById('error_contact_detail').innerHTML="Please enter valid mobile number";
			isError = false;
		}
	}
	
	return isError; //frmObj.submit();
}

function IsText(sText)
{
	var ValidChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var IsText=true;
	var Char;
	var pos;
	
	for (i = 0; i < sText.length && IsText == true; i++) 
	{ 
		Char = sText.charAt(i); 
		if (ValidChars.indexOf(Char) == -1) 
		{
			IsText = false;
			pos = i;
		}
	}
	return IsText;
}

function IsTextWithSpace(sText)
{
	var ValidChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ";
	var IsText=true;
	var Char;
	var pos;
	
	for (i = 0; i < sText.length && IsText == true; i++) 
	{ 
		Char = sText.charAt(i); 
		if (ValidChars.indexOf(Char) == -1) 
		{
			IsText = false;
			pos = i;
		}
	}
	return IsText;
}

function IsPassword(sText)
{
	var ValidChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	var IsText=true;
	var Char;
	var pos;
	
	for (i = 0; i < sText.length && IsText == true; i++) 
	{ 
		Char = sText.charAt(i); 
		if (ValidChars.indexOf(Char) == -1) 
		{
			IsText = false;
			pos = i;
		}
	}
	return IsText;
}

function IsNumber(sText)
{
	var ValidChars = "1234567890";
	var IsNum=true;
	var Char;
	var pos;
	
	for (i = 0; i < sText.length && IsNum == true; i++) 
	{ 
		Char = sText.charAt(i); 
		if (ValidChars.indexOf(Char) == -1) 
		{
			IsNum = false;
			pos = i;
		}
	}
	return IsNum;
}
