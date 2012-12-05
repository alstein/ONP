$(document).ready(function() {

	$('#frm_comment').validate({
		    errorElement:'div',
		    rules: {
			txt_thinking:{
				required: true
				
			}

		    },
		    messages: {
			txt_thinking:{
				required: "Please enter the comment."
			
			}
			
		}
		
        });
});

