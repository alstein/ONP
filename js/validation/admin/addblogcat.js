$(document).ready(function()
{
    $("#frmRegistration").validate({
                                        errorElement:'div',
                                                    rules: {
                                                                category_name:
                                                                {
                                                                       required: true,
                                                                        minlength: 1,
                                                                        maxlength:50,
                                                                        nospace:true
                                                                }


                                                            },
                                                messages:
                                                        {
                                                            category_name:
                                                            {
                                                                    required: "Please enter category",
                                                                    minlength:  $.format("Enter at least {0} characters"),
                                                                    maxlength: $.format("Enter maximum {0} characters")
                                                            }

                                                        }
                                });

});
