$(document).ready(function() {

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
     // 	 $.validator.addMethod("valid_editor", function(value, element){
//                var oEditor = FCKeditorAPI.GetInstance(element.name);
//                var fieldvalue = oEditor.GetXHTML(true);
//                if(fieldvalue=="") {
//                   return false;
//                } else {
//                   return true;
//                }
//          }, "Please enter  description");

$('#frm').validate({
		    errorElement:'div',
		    rules: {
                            pagename:
                                    {
                                         required:true,
                                         minlength: 2,
			                 maxlength:100
                                    },
			    pagetitle:
			             {
			                 required:true,
			                 minlength: 2,
			                 maxlength:200
                                     },
			    description:
			             {
			                  valid_editor:true,
			                  minlength: 5,
			                  maxlength:400
			             }
		    },
		    messages: {
                             pagename:
                                    {
                                         required: "Please enter name.",
                                         minlength:  $.format("Enter at least {0} characters"),
                                         maxlength: $.format("Enter maximum {0} characters")
                                    },
			    pagetitle:
			             {
			                 required: "Please enter title.",
			                 minlength:  $.format("Enter at least {0} characters"),
                                         maxlength: $.format("Enter maximum {0} characters")
                                     },
			    description:
                                    {
                                         required: "Please enter description.",
                                         minlength:  $.format("Enter at least {0} characters"),
                                         maxlength: $.format("Enter maximum {0} characters")
                                    }
		}
		
	  });
    $("#msg").fadeOut(5000);
});




