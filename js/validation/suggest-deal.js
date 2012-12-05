$(document).ready(function(){
	$("#frmdeal").validate({
		errorElement:'div',
		rules:{
                        product_name:{
				required: true,
				minlength:4,
				maxlength:500
                        },
			comment:{
				//required: true,
				//minlength:4,
				maxlength:1000
			}
		},
		messages:{
		        product_name:{
				required: "Please enter product name ",
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters.")
			},
		        comment:{
				//required: "Please enter description ",
				//minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters.")
			}
	        },
		success: function(label) {
			// set &nbsp; as text for IE
		    label.hide();
		}
	});
});