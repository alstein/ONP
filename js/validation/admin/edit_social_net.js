$(document).ready(function()
{
$("#home_form").validate({
        errorElement:'div',
        rules: {
                    facebook:
                            {
                            	required: true
				
                            },
                    twitter:
                            {
                            	required: true
				
                            }
                },
                     messages:
                        {
                       facebook:
                            {
                                required: "Please enter URL of facebook page."
				
                            },
                    twitter:
                            {
                                required: "Please enter twitter username."
				
                            }
                        }
                                });
                                    $("#msg").fadeOut(5000);

});