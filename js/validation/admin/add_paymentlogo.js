$(document).ready(function()
{
 
    $("#home_form").validate({
        errorElement:'div',
        rules: {
                    imagetitle:
                            {
                            	required: true
                            },
                     image:
                            {
                            	required: true,
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