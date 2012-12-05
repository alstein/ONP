$(document).ready(function()
{

//  $.validator.addMethod('positiveNumber',
//     function (value) { 
//         return Number(value) > 0;
//     }, 'Enter a positive number.');
    
    $.validator.addMethod("numGreatZero", function(value, element){
                var temp;
                temp = true;
                temp = !(value<=0);
                return temp;
         }, "Please enter value use be greater than zero(0)");

    
    $("#frmRegistration").validate({
        errorElement:'div',
        rules: {
                    pacname:
                            {
                            	required: true,
				remote: {url:SITEROOT + "/admin/modules/package/ajax_check_name.php?packid="+$("#packid").val(),type:"post"}
                            },
                    deals:
                            {
                            	required: true,
                            	number: true,
                            	numGreatZero : true
                            },
                    packprice:
                            {
                            	required: true,
                            	numGreatZero : true,
                            	number: true
                            },
                   costper:
                            {
                            	required: true,
                            	numGreatZero : true,
                            	number: true
                            },
                   costperdeal:
                            {
                            	required: true,
                            	numGreatZero : true,
                            	number: true
                            },
                packduration:
                            {
                            	required: true,
                            	numGreatZero : true,
                            	number: true
                            }
                },
                     messages:
                        {
                    pacname:
                            {
                                required: "Please enter package name",
                                remote: "This package name is already in use."
                            },
                    deals:
                            {
                                required: "Please enter number # deals per month",
                                number: "Please enter numbers only."
                            },
                    packprice:
                            {
                                required: "Please enter pack price",
                                number: "Please enter numbers only."
                            },
                   costper:
                            {
                                required: "Please enter # cost per success deal",
                                number: "Please enter numbers only."
                            },
                  costperdeal:
                            {
                                required: "Please enter cost per  deal",
                                number: "Please enter numbers only."
                            },
                packduration:
                            {
                                required: "Please enter package duration",
                                number: "Please enter numbers only."
                            }
                        }
                                });

});