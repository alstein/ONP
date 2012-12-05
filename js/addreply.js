$(document).ready(function()
{
	$("#frm").validate({
		errorElement:'div',
			rules: {
						subject:
						{
								required: true,
								maxlength:200
						},
						message:
						{
								required: true,
								maxlength:50000
						}
					},
			messages:
					{
						subject:
						{
								required: "Please enter subject",
								maxlength: $.format("Enter maximum {0} characters")
						},
						message:
						{
								required: "Please enter message",
								maxlength: $.format("Enter maximum {0} characters")
						}
					}
	});

});
