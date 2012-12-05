$(document).ready(function(){

	$("#billfrmol").validate({
		errorElement:'div',
		rules: {
			title:{
				required: true		
			},
                        link:{
				required: true		
			},        
                        desc:{
				required: true,
                                email: true                        
			}
		},
		messages: {
			title:{
				required: "Please enter payment method."
			},
                        link:{
				required: "Please enter link."
			},
                        desc:{
				required: "Please enter payment details.",
                                email:"Enter valid email id."                                
			}
		}
		
	});

});
