$(document).ready(function(){

	$("#billfrm").validate({
		errorElement:'div',
		rules: {
			title:{
				required: true		
			},
			subcategory: {
				required: true		
			},
                        desc:{
				required: true
			}
		},
		messages: {
			title:{
				required: "Please enter payment information."
			},
			desc:{
				required: "Please enter payment details."
			}
		}
		
	});

});
