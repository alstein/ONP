$(document).ready(function() {

 $.validator.addMethod("valid_editor", function(value, element){
               var oEditor = FCKeditorAPI.GetInstance(element.name);
               var fieldvalue = oEditor.GetXHTML(true);
               if(fieldvalue=="" && document.getElementById('videotypee').checked )
               { 
                  return false;
               } else { 
                  return true;
               }
         }, "Please enter editor decription"); 
    $.validator.addMethod("chkvideotype", function(value, element){
                var temp = document.getElementById('videotype').checked;
                return true;
         }, "Please enter value use be greater than zero(0)");
   
var validator = $("#home_form").validate({
    errorElement:'div',
            rules: {
             display_by:
                      {
                        required: true
                      },
                image:
                     {
                       required: function(value, element){
                                        var temp = document.getElementById('videotype').checked;
                                        if(temp == false)
                                        {
                                            temp = false;
                                        }
                                        else
                                        {
                                            if(document.getElementById('old_image').value != '')
                                            {
                                                temp = false;
                                            }
                                            else
                                            {
                                                temp = true;
                                            }
                                        }
                                        return temp;
                                    },
                         accept: "jpg|png|gif"
                     },
                       description:{
                      valid_editor: function(value, element){
                                        var temp = document.getElementById('videotypee').checked;
				        return temp; 
			    },
			    maxlength:200
                       }
            },
            messages: 
            {
             display_by:
                      {
                        required: "Please select display by"
                      },
                image:{
                        required:"Please upload .jpg,.gif,.png file.",
                        accept: "Please provide valid file format"
                      },
                        description:{
				 valid_editor: "Please enter description.",
				 maxlength: $.format("Enter maximum {0} characters")
			    }
            }
    });


});

