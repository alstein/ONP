$(document).ready(function()
{
$("#home_form").validate({
        errorElement:'div',
        rules: {
                    qr_link:
                            {
                            	required: true,
                            	 url:true
				
                            },
                    option_1:
                            {
                            	required: true
                            },
                    option_2:
                            {
                            	required: true
                            },
                    option_3:
                            {
                            	required: true
                            },
                    option_4:
                            {
                            	required: true
                            },
                    option_5:
                            {
                            	required: true
                            }
                },
                     messages:
                        {
                       qr_link:
                            {
                                required: "Please enter QR code url.",
                                url: "Please enter valid url."
				
                            },
                    option_1:
                            {
                                required: "Please enter value."
				
                            },
                    option_2:
                            {
                                required: "Please enter value."
				
                            },
                    option_3:
                            {
                                required: "Please enter value."
				
                            },
                    option_4:
                            {
                                required: "Please enter value."
				
                            },
                    option_5:
                            {
                                required: "Please enter value."
				
                            }
                        }
                                });
                                    $("#msg").fadeOut(5000);

});