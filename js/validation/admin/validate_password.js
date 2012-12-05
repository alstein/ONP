

$(document).ready(function(){

     $("#home_form").validate({
       	errorElement:'div',
			rules: {
					password : {
						required: true,	
						minlength:6,
						maxlength:20
					}
			},
			messages:{
					password : {
							required: "Please enter password.",
							minlength: jQuery.format("Enter at least {0} characters"),
							maxlength: jQuery.format("Enter at most {0} characters")

					}
			}
        });
 });