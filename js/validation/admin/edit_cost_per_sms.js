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
	
$("#home_form").validate({
        errorElement:'div',
        rules: {
                    sms:
                            {
                            	required: true,
                            	numdotOnly: true,
                            	maxlength: 4
				
                            },
                    email:
                            {
                            	required: true,
                            	numdotOnly: true,
                            	maxlength: 4
				
                            }
                },
                     messages:
                        {
                       sms:
                            {
                                required: "Please enter cost per sms value.",
                                numdotOnly: "Please enter numbers only",
                                maxlength: jQuery.format("Enter at most {0} numbers")
				
                            },
                    email:
                            {
                                required: "Please enter cost per email value.",
                                numdotOnly: "Please enter numbers only",
                                maxlength: jQuery.format("Enter at most {0} numbers")
				
                            }
                        }
                                });
                                    $("#msg").fadeOut(5000);

});