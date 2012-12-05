$(document).ready(function(){
	$("#frm_send_news").validate({
		errorElement:'div',
		rules: {
                        subject:{
				required: true,
			},
			editor2:{
				required: true,
				maxlength: 1000
			}
		},
		messages:{
			subject:{
				required: "Please enter subject"
			},
			editor2:{
				required:"Please enter message content ",
				maxlength: jQuery.format("Enter at most {0} characters")
			}
		}
		
	});

});
