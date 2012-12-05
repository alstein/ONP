$(document).ready(function() {
	$.validator.addMethod("alphaOnly", function(value, element){
		var temp;
		temp = true;
		str = /[^a-zA-Z -]/;
		temp = !str.test(value);
		return temp;
	}, "Only a to z, A to Z and - is allowed.");

	$('#frm').validate({
		    errorElement:'div',
		    rules: {
			city:{
				required: true,
				minlength: 3,
				maxlength: 100,
				alphaOnly:true
			},
			rel_status:{
				required: true
			},
			grad_collage:{
				minlength: 2,
				maxlength:100
			},
			under_grad_collage:{
				minlength: 2,
				maxlength:100
			},
			music:{
				minlength: 2,
				maxlength:100
			},
			activity:{
				minlength: 2,
				maxlength:100
			}

		    },
		    messages: {
			city:{
				required: "Please city name.",
				minlength: jQuery.format("Enter at least {0} characters."),
				maxlength: jQuery.format("Enter at most {0} characters.")
				
			},
			rel_status:{
				required: "Please select Relationship status."
			},
			grad_collage:{
				minlength:  $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			under_grad_collage:{
				minlength:  $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			music:{
				minlength:  $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			activity:{
				minlength:  $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			}

			
		},
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
        });
});

