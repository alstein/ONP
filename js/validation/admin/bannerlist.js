$(document).ready(function(){
	jQuery("#frm").validate({
		errorElement:'div',
		rules: {
			name: {
				required: true,
		 	}
		},
		messages: {
			name: {
					required: "Please enter name information",
			}
		},
});
});
