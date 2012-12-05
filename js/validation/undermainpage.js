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
//          }, "Please enter editor decription");
         
	$('#frmPage').validate({
		    errorElement:'div',
		    rules: {
                            undermaintenance_name:{
				required:true
				
			    },
			    description:{
				valid_editor:true
				
			    }
		    },
		    messages: {
                             undermaintenance_name:{
				    required: "Please enter title."
			    },
			    description:{
				 valid_editor: "Please enter description."
			    }
		}
		
	  });
    $("#msg").fadeOut(5000);
});

