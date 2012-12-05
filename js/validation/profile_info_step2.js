$(document).ready(function() {

	$('#frm').validate({
		    errorElement:'div',
		    rules: {
			chk_category:{
				required: true
				
			}

		    },
		    messages: {
			chk_category:{
				required: "Please select category."
				
			}
		},
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
        });
});

