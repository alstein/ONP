$(document).ready(function()
{
    $("#frm").validate({
                                        errorElement:'div',
                                                    rules: {
                                                                dealid:
                                                                {
                                                                       required: true
                                                                },
                                                                ques:
                                                                {
                                                                       required: true
                                                                }
                                                            },
                                                messages:
                                                        {
                                                            dealid:
                                                            {
                                                                    required: "Please select category"

                                                            },
                                                            ques:
                                                            {
                                                                    required: "Please enter qustion"

                                                            }
                                                        }
                                });

});