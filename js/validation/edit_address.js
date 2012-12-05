$(document).ready(function() {

	$('#frmEdit').validate({
		errorElement:'div',
		rules: {
			addrline1:{
			    required:true,
			    maxlength: 255
			}/*,
			zip:{
			    required:true
			}*/
		},
		messages:{
			addrline1:{
				required: "Please enter address",
				maxlength: jQuery.format("Enter at most {0} characters.")
			}/*,
			zip:{
				required: "Please enter post code"
			}*/

		},
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}

        });
});

