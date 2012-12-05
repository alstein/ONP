$(document).ready(function(){

	$("#frm_send_news").validate({
		errorElement:'div',
		rules: {
			newsletter: {
				required: true		
			},
// 			to: {
// 				required: true	
// 			},
			subject:{
				required: true,
                                minlength: 1,
                                maxlength: 50
			}
		},
		messages: {
			newsletter:{
				required: "Please select message"
			},
// 			to:{
// 				required: "Please enter email address"
// 			},
			subject:{
				required: "Please enter subject",
				minlength: jQuery.format("Enter at least {0} characters"),
				maxlength: jQuery.format("Enter at most {0} characters")
			}			
		},
		success: function(label) {
			label.hide();
		}
	});

        $('#frm_send_news').submit(function() {
	  //validation for msg content
          var fckBody= FCKeditorAPI.GetInstance("nl_pagecontent");
          var checkeditor = fckBody.GetXHTML(true);

          if(checkeditor.length <= 7)
	  {
	     alert('Description should not be empty');
	    return false;
	  }
          return true;
        });

	$('#msg').fadeOut(5000);
});

