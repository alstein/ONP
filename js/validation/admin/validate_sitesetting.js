$(document).ready(function()
{
jQuery.validator.addMethod("email",function(value, element)
{
	return this.optional(element) || /^([\w])(([\w]+))*@([\w]+\.)+[\w]{2,4}?$/i.test(value);
}, "Please enter valid email");

var val_a = $("#txt_id").val();

    $("#frmEdit").validate({
		errorElement:'div',
		rules: {
				parameter:{
					required:true	
					},
				desc:
				{

					required:true,
					email: function(){
            					if(val_a == '5' || val_a=='6')
						{
							return true;
            					}
						}
				}
			},
		messages:
			{

				parameter:
				{
					required:"Please enter description"
				},
				desc:
				{
					required:"Please enter description",
					email: "Please enter valid email id "
				}
			}
                });

});
