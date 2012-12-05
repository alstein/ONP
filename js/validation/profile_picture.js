$(document).ready(function() {

	$('#frm').validate({
		    errorElement:'div',
		    rules: {
				photo:{
					required: true,
					accept: "jpg|jpeg|gif|png"	
				}
		    },
		    messages: {
			photo:{
				 required: "Please upload profile picture.",
				 accept: "Please provide valid image format"
			}
		},
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
        });
});

