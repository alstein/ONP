$(document).ready(function()
{
		jQuery.validator.addMethod("web",

	function(value,element)
	{
	return this.optional(element)|| /^(http|https|ftp):\/\/www\.([a-z]+\.)+[\w-]{2,4}$/i.test(value);
	}, "Please enter valid website name");

    $("#home_form").validate({
        errorElement:'div',
        rules: {
                    freevoucher:
                            {
                            	required: true,
				web: true
                            },
                    monyback:
                            {
                            	required: true,
				web: true
                            },
                    travel:
                            {
                            	required: true,
				web: true
                            },
                    services:
                            {
                            	required: true,
				web: true
                            }
                },
                     messages:
                        {
                    freevoucher:
                            {
                                required: "Please enter free voucher link.",
				web: "Please enter valid free voucher link."
                            },
                    monyback:
                            {
                                required: "Please enter cashback link.",
				web: "Please enter valid cashback link."
                            },
                    travel:
                            {
                                required: "Please enter travel link.",
				web: "Please enter valid travel link."
                            },
                    services:
                            {
                                required: "Please enter services link.",
				web: "Please enter valid services link."
                            }
                        }
                                });
                                    $("#msg").fadeOut(5000);

});