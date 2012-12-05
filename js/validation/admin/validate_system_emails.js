$(document).ready(function(){
       $.validator.addMethod("valid_editor", function(value, element) { 
		var editorcontent = CKEDITOR.instances[element.name].getData().replace(/<[^>]*>/gi, '');
		if (editorcontent.length)
		{
			return true;
		}else
		{
			return false;
		}
	}, "Please enter description");


     $("#frmSystemEmails").validate({
       	errorElement:'div',
 	  rules: {
         	  subject : {
			required: true
			},
                  message:{
			valid_editor: true
			}
                 },
        messages:{
                subject : {
			required: "Please enter subject."
			  },
                        message:{
			valid_editor: "Please enter message."
				}
 	         }
        });
 });