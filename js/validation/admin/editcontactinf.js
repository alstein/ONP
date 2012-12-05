$(document).ready(function(){
	jQuery("#frm").validate({
		errorElement:'div',
		rules: {
			lineone: {
				required: true,
		 	},
			linetwo: {
				required: true,
		 	}
		},
		messages: {
			lineone: {
					required: "Please enter contact information",
			},
			linetwo: {
				required: "Please enter contact information",
		 	}
		},
});
});
