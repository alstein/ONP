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

  $("#frmSystemEmails").validate({
       	errorElement:'div',
 	  rules: {
 	          message:{
 	                          valid_editor:true
                          }
                 },
        messages:{
 	           message:{
 	                          valid_editor: "Please enter message." 
                           }
 	         }
        });
    $("#msg").fadeOut(5000);
});




