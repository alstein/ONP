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
jQuery.validator.addMethod("url_double_dot", function(value, element) {
			for(var i=0; i<value.length; i++)
			{
				if(value[i] == '.' && value[(parseInt(i)+1)] == '.')
					return false;
			}
			return true;
		},"Please enter valid URL");

 
    $("#home_form").validate({
        errorElement:'div',
        rules: {
                    imagetitle:
                            {
                            	required: true,
												minlength:2,
												maxlength:255

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
                                required: "Please enter image title.",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")

                            },
                    image:
                            {
                                accept: "Please provide valid image format."
                            },
                  status:
                            {
                                required: "Please select status."
                            }
                        }
        });
         $("#msg").fadeOut(5000);

});