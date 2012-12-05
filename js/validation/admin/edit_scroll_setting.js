$(document).ready(function()
{

$("#home_form").validate({
        errorElement:'div',
        rules: {
                        group_scroll:
                                    {
                                        required: true	
                                    },
                        group_speed:
                                    {
                                        required: true,
                                        number: true
                                        //maxlength: 4
                                    },
                        daily_scroll:
                                    {
                                        required: true
                                    },
                        daily_speed:
                                    {
                                        required: true,
                                        number: true
                                    },
                        free_scroll:
                                    {
                                        required: true
                                    },
                        free_speed:
                                    {
                                        required: true,
                                        number: true
                                    },
                     travel_speed:
                                    {
                                        required: true,
                                        number: true
                                    },
                      travel_scroll:
                                    {
                                        required: true
                                    }
                },
                messages:
                        {
                group_scroll:
                            {
                                required: "Please select setting ON / OFF value."
                            },
                group_speed:
                            {
                                required: "Please enter scroll speed.",
                                number: "Please enter numbers only"
                                //maxlength: jQuery.format("Enter at most {0} numbers")				
                            },
                daily_scroll:
                            {
                                 required: "Please select setting ON / OFF value."
                            },
                daily_speed:
                            {
                                required: "Please enter scroll speed.",
                                number: "Please enter numbers only"
                            },
                 free_scroll:
                            {
                                 required: "Please select setting ON / OFF value."
                            },
                free_speed:
                            {
                                required: "Please enter scroll speed.",
                                number: "Please enter numbers only"
                            },
                travel_scroll:
                            {
                                 required: "Please select setting ON / OFF value."
                            },
                travel_speed:
                            {
                                required: "Please enter scroll speed.",
                                number: "Please enter numbers only"
                            }
                        }
                                });
                                    $("#msg").fadeOut(5000);

});