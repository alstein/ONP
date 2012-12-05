$(document).ready(function()
{

//  $.validator.addMethod('positiveNumber',
//     function (value) { 
//         return Number(value) > 0;
//     }, 'Enter a positive number.');
    
//     $.validator.addMethod("numGreatZero", function(value, element){
//                 var temp;
//                 temp = true;
//                 temp = !(value<=0);
//                 return temp;
//          }, "Please enter value use be greater than zero(0)");
 
    $("#home_form").validate({
        errorElement:'div',
        rules: {
                    imagetitle:
                            {
                            	required: true
                            },
                     image:
                            {
                            	//required: true,
                            	accept: ".jpg,.gif,.png,.jpeg"
                            },
                   status:
                            {
                            	required: true
                            }
                },
                     messages:
                        {
                    imagetitle:
                            {
                                required: "Please enter image title"
                            },
                    image:
                            {
                                required: "Please upload image logo"
                            },
                  status:
                            {
                                required: "Please select status"
                            }
                        }
        });

});