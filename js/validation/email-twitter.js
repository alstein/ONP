$(document).ready(function() {

	
	 $("#frmReset").validate({
        

		errorElement:'div',
		rules: {
			emailname: {
				required: true,
				email: true
			}
		},
		messages: {
			emailname: {
				required: "Please enter email address",
				email: "Please enter valid email address"
			}
		},

		
		success: function(label) {
			
			label.hide();
		}
	});

});