$(document).ready(function() {

	$('#frmdeal').validate({
		    errorElement:'div',
		    rules: {
			min_amount_de:{
				required: true
				
			},
			offer_for_weekend:{
				required: true
				
			},
			mimimum_offer_amount:{
				required:function(){	//alert($("#min_amount_de").val());
					if($('input[name=min_amount_de]:checked').val()=='yes')
						return true;
					else
						return false;
				},
				number:true
			},
			condition:{
				required: true
			}

		    },
		    messages: {
			min_amount_de:{
				required: "Please checked the minimum offer amount."
			
			},
			offer_for_weekend:{
				required: "Please checked the Offer for weekend."
			
			},
			mimimum_offer_amount:{
				required: "Please enter the amount."
			},
			condition:{
				required: "Please enter the conditions."
			
			}
			
		},
		success: function(label) {
			
			label.hide();
		}
        });
});

