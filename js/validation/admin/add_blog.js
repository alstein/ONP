$(document).ready(function()
{
    $("#frmRegistration").validate({
		errorElement:'div',
		rules: {
				title:
				{
					required: true,
					minlength: 2,
                                        maxlength:50
				},
				metadescription:
				{
					required: true,
					minlength: 2,
			                maxlength:400
				},
				metakeyword:
				{
					required: true,
					minlength: 2,
			                maxlength:200
				},
				date:
				{
					required: true
				},
				city_id:
				{
					required: true
				},
				description:
				{
					required: true,
					minlength: 2,
			                maxlength:400
				}
			},
		messages:
			{
				title:
				{
					 required: "Please enter title",
					 minlength:  $.format("Enter at least {0} characters"),
                                         maxlength: $.format("Enter maximum {0} characters")
				},
				metadescription:
				{
					 required: "Please enter meta description",
					 minlength:  $.format("Enter at least {0} characters"),
			                 maxlength: $.format("Enter maximum {0} characters")
				},
				metakeyword:
				{
					 required: "Please enter meta keyword",
					 minlength:  $.format("Enter at least {0} characters"),
			                 maxlength: $.format("Enter maximum {0} characters")
				},
				date:
				{
					required: "Please select date"
				},
				city_id:
				{
					required: "Please select city"
				},
				description:
				{
					 required: "Please enter description",
					 minlength:  $.format("Enter at least {0} characters"),
			                 maxlength: $.format("Enter maximum {0} characters")
				}
			}
			});
			 $("#frmRegistration").submit(function()
	                  {
                           if($('#bid').val()=='')
                           {
	                     var currentTime = new Date();
                             var month = currentTime.getMonth() + 1;
                             var day = currentTime.getDate();
                             var year = currentTime.getFullYear();
                             var cd = new Date(year,(month-1),day);
                            // var docFrm=document.frmRegistration;
                             var blogDate = new Date($('#date_Year_ID').val(), $('#date_Month_ID').val(), $('#date_Day_ID').val());
                             if(cd > blogDate)
                             {
                                 $('#err_date').show();
                                 $('#err_date').addClass('error');
                                 $('#err_date').html("Date should be greater than or equal to current date.");
                                 return false;
                            }
                            else
                           {
                                   $('#err_date').hide();
                                   $('#err_date').removeClass('error');
                                   $('#err_date').html("");
                                    return true;
                           }
                         }
                       });
	
});