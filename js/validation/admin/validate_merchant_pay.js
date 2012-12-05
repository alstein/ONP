

$(document).ready(function(){

	jQuery.validator.addMethod("show_percentage", function(value, element) {
		
		if(value >99 || value<0)
		{
			return false;
		}
		else
		{
			return true;
		}
	},"% should be less than equal to the 99 and greater than or equal to 0");
     $("#home_form").validate({
       	errorElement:'div',
			rules: {
					merchant_pay : {
						required: true,	
						number:true,
						show_percentage:true
					},
					customer_pay:{
						required: true,	
						number:true,
						show_percentage:true
					}
			},
			messages:{
					merchant_pay : {
							required: "Please enter merchant pay in %."
					},
					customer_pay : {
							required: "Please enter customer pay in %."
					}
		
			}
        });
 });