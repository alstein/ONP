

$(document).ready(function()
{

         $.validator.addMethod("numdotOnly", function(value, element){
		var temp;
		temp = true;
		str = /[^0-9.]/;
		temp = !str.test(value);
		
		if(temp)
		{
			var prodDiscprice = value;
			var totDotInprodDiscprice = 0;
			var noFirstDotInprodDiscprice = 'no';
			for(var i=0; i<prodDiscprice.length;i++)
			{
				if(prodDiscprice[0] == '.')
				{
					noFirstDotInprodDiscprice = 'yes';
				}
			
				if(prodDiscprice[i] == '.')
				{
					totDotInprodDiscprice++;
				}
			}
			if(totDotInprodDiscprice > 1 || noFirstDotInprodDiscprice == 'yes'){
				temp = false;
			}else{
				temp = true;
			}
		}
		return temp;
	}, "Only numbers and .(decimal) is allowed.");

jQuery.validator.addMethod("numGreatZero", function(value, element){
                var temp;
                temp = true;
                temp = !(value<=0);
                return temp;
         }, "Please enter value must be greater than zero(0)");


	
$("#frm").validate({
        errorElement:'div',
        rules: {
                    credit_amount_pound:
                                        {
                                            required: true,
                                            numdotOnly: true,
                                            maxlength: 4
                                        },
                            credit_amount_euro:
                                                {
                                                    required: true,
                                                    numdotOnly: true,
                                                    maxlength: 4
                                                },
                            credit_amount_dollar:
                                                {
                                                    required: true,
                                                    numdotOnly: true,
                                                    maxlength: 4
                                                },
                                no_of_coupons: 
                                                {
                                                    required:true,
                                                    number : true,
                                                    numGreatZero : true,
                                                    maxlength:3
                                                }
                },
                     messages:
                        {
                            credit_amount_pound:
                                            {
                                                required: "Please enter credit amount value for pound.",
                                                numdotOnly: "Please enter numbers only",
                                                maxlength: jQuery.format("Enter at most {0} numbers")
                                            },
                            credit_amount_euro:
                                            {
                                                required: "Please enter credit amount value for euro.",
                                                numdotOnly: "Please enter numbers only",
                                                maxlength: jQuery.format("Enter at most {0} numbers")
                                            },
                            credit_amount_dollar:
                                            {
                                                required: "Please enter credit amount value for dollar.",
                                                numdotOnly: "Please enter numbers only",
                                                maxlength: jQuery.format("Enter at most {0} numbers")
                                            },
                                no_of_coupons:
                                            {
                                                required: "Please enter deal purchase maximum limit per user.",
                                                maxlength:jQuery.format("Enter maximum {0} digits")
                                            }
                        }
                });
                                    $("#msg").fadeOut(5000);

});
