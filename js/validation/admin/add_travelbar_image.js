$(document).ready(function()
{

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
                    rules: 
                        {
                                    imagetitle:
                                            {
                                                required: true
                                            },
                                    image:
                                            {
                                                required: true,
                                                accept: ".jpg,.gif,.png,.jpeg"
                                            },
                                            link:
                                            {
                                                required: true,
                                                url_double_dot: true,
                                                url:true
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
                                            required: "Please enter image title."
                                        },
                                image:
                                        {
                                            required: "Please upload image.",
                                            accept: "Please provide valid image format."
                                        },
                                link:
                                        {
                                            required: "Please enter link.",
                                            url:"Please enter correct format link."
                                        },
                              status:
                                        {
                                            required: "Please select status."
                                        }
                        }
        });
         $("#msg").fadeOut(5000);

});