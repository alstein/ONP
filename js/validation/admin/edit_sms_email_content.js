$(document).ready(function()
{
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

//                             $.validator.addMethod("valid_editor", function(value, element){
//                             var oEditor = FCKeditorAPI.GetInstance(element.name);
//                             var fieldvalue = oEditor.GetXHTML(true);
//                             if(fieldvalue=="")
//                             { 
//                                 return false;
//                             } else { 
//                                 return true;
//                             }
//                         }, "Please enter editor decription"); 
	
        $("#home_form").validate({
                                        errorElement:'div',
                                        rules:  {
                                                 sms_content:
                                                            {
                                                                required: true,
                                                                maxlength: 160
                                                            },
                                                 description:
                                                            {
                                                                valid_editor: true
                                                            }
                                                },
                                        messages:
                                                {
                                                 sms_content:
                                                            {
                                                                required: "Please enter SMS Content.",
                                                                maxlength: jQuery.format("Enter at most {0} numbers")	
                                                            },
                                                 description:
                                                            {
                                                                valid_editor: "Please enter Email Content."
                                                            }
                                                }
                                });
                                    $("#msg").fadeOut(5000);

});