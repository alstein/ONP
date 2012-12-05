$(document).ready(function()
{
    $("#addfrmblog").validate({
                                        errorElement:'div',
                                                    rules: {
                                                                city:
                                                                {
                                                                       	required: true
                                                                },
									deal:
									{
										required: true
									},
										category:
										{
											required: true
										},
											blogtitle:
											{
												required: true,
												minlength: 2,
												maxlength:150
											}
                                                            },
                                                messages:
                                                        {
                                                            city:
                                                            {
                                                                    required: "Please select city"
                                                            },
									deal:
									{
										required: "Please select deal"
									},
										category:
										{
											required: "Please select category"
										},
											blogtitle:
											{
												required: "Please enter blog title",
												minlength:  $.format("Enter at least {0} characters"),
												maxlength: $.format("Enter maximum {0} characters")											}
                                                        }
                                });

});