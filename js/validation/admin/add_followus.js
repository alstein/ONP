$(document).ready(function()
{
 	jQuery.validator.addMethod("web",

	function(value,element)
	{
	return this.optional(element)|| /^(http|https|ftp):\/\/www\.([a-z]+\.)+[\w-]{2,4}$/i.test(value);
	}, "Please enter valid link");
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
                            link:
                            {
                            	required: true,
				web: true
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