

$(document).ready(function(){

     $("#frm").validate({
       	errorElement:'div',
			rules: {
					pass : {
						required: true,	
						minlength:6,
						maxlength:20
					}
			},
			messages:{
					pass : {
							required: "Please enter password.",
							minlength: jQuery.format("Enter at least {0} characters"),
							maxlength: jQuery.format("Enter at most {0} characters")

					}
			}
        });
 });