$(document).ready(function()
{
    $("#frmRegistration").validate({
                                        errorElement:'div',
                                                    rules: {
                                                                faqcname:
                                                                {
                                                                       	required: true,
                                                                        minlength: 1,
                                                                        maxlength:30
                                                                }/*,
                                                                catdec:
                                                                {
                                                                        required: true,
                                                                        minlength: 10,
                                                                        maxlength:250,


                                                                }*/


                                                            },
                                                messages:
                                                        {
                                                            faqcname:
                                                            {
                                                                    required: "Please enter category",
                                                                    minlength:  $.format("Enter at least {0} characters"),
                                                                    maxlength: $.format("Enter maximum {0} characters")
                                                            }/*,
                                                            catdec:
                                                            {
                                                                    required: "Please enter description",
                                                                    minlength:  $.format("Enter at least {0} characters"),
                                                                    maxlength: $.format("Enter maximum {0} characters")

                                                            }*/

                                                        }
                                });

});