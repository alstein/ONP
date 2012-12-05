$(document).ready(function(){

        $.validator.addMethod("alphaOnly", function(value, element){
			var temp;
			temp = true;
			str = /[^a-zA-Z -]/;
			temp = !str.test(value);
			return temp;
		}, "Only a to z, A to Z and - is allowed.");
		
// 	$.validator.addMethod("noSpecialChars", function(value, element) {
// 	      return /^[a-zA-Z\_]+$/i.test(value);
// 	},"Only A-Z, a-z & _ is allowed without space");
	
	jQuery.validator.addMethod("emailchk", function(value, element) {
			var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			return rege.test($('#email').val());
	},"Please enter valid email address");

             $("#frm").validate({
		errorElement:'div',
		rules: {
			name:{
				required: true,
				//noSpecialChars:true,
				alphaOnly:true,
				minlength: 2,
				maxlength:50
			},
                        email:{
				required: true,
				email: true,
				emailchk:true
				
			},
			message:{
				required: true,
				minlength: 10
			}
		},
		messages: {
			name:{
				required: "Please enter name",
				//noSpecialChars: "Please enter valid name",
				alphaOnly:  "Please enter valid name",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: "required maximum 50 characters"
			},
			email:{
				required: "Please enter emailid.",
				email:"Please enter valid email address",
				emailchk:"Please enter correct email address"
			},
                       	message:{
				required:"Please enter message.",
				minlength: jQuery.format("Enter at least {0} characters")
			}
		}
		
	});
       $('#contact_us').submit(function(){
            if ($('div.error').is(':visible'))
            { }
            else 
            {
                $('#Submit').hide(); 
                $('#buttonregister').append("<input type='button' name='Submit' id='Submit' value='Submit' class='buybtn2'>");
            }
        });
	$("#msg").fadeOut(5000);
});
