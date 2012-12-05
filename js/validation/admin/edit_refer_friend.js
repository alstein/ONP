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


/*jQuery.validator.addMethod("numdotOnly", function(value, element){
                var temp;
                temp = true;
                str = /[^0-9.]/;
                temp = !str.test(value);
                return temp;
         }, "Only numbers and .(decimal) is allowed.");
	*/
$("#home_form").validate({
        errorElement:'div',
        rules: {
                    refer_amount_pound:
                            {
                            	required: true,
                            	numdotOnly: true,
                            	maxlength: 4
				
                            },
                    refer_amount_euro:
                            {
                            	required: true,
                            	numdotOnly: true,
                            	maxlength: 4
				
                            },
                    refer_amount_dollar:
                            {
                            	required: true,
                            	numdotOnly: true,
                            	maxlength: 4
				
                            },
                    setting:
                            {
                            	required: true
                            }
                },
                     messages:
                        {
                       refer_amount_pound:
                            {
                                required: "Please enter refer amount value for pound.",
                                numdotOnly: "Please enter numbers only",
                                maxlength: jQuery.format("Enter at most {0} numbers")
				
                            },
                       refer_amount_euro:
                            {
                                required: "Please enter refer amount value for euro.",
                                numdotOnly: "Please enter numbers only",
                                maxlength: jQuery.format("Enter at most {0} numbers")
				
                            },
                       refer_amount_dollar:
                            {
                                required: "Please enter refer amount value for dollar.",
                                numdotOnly: "Please enter numbers only",
                                maxlength: jQuery.format("Enter at most {0} numbers")
				
                            },
                    setting:
                            {
                                required: "Please select setting ON / OFF value."
                            }
                        }
                                });
                                    $("#msg").fadeOut(5000);

});