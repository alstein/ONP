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
                    link:
                            {
                            	required: true
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
                                accept: "Please provide valid image format"
                            },
                    link:
                            {
                                required: "Please enter link"
                            },
                  status:
                            {
                                required: "Please select status"
                            }
                        }
        });

});