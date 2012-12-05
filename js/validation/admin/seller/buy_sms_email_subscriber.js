$(document).ready(function(){

	jQuery.validator.addMethod("noSpace", function(value, element) {
		return value.indexOf(" ") < 0 && value != "";
	}, "Only A-Z, a-z & _ is allowed without space");

	jQuery.validator.addMethod("lettersonly", function(value, element)
	{
		return this.optional(element) || /^[a-z]+$/i.test(value);
	}, "Please enter only character");
	
	$.validator.addMethod("fullname", function(value, element) {
		return this.optional(element) || /^[a-zA-Z \_]+$/i.test(value);
	}, "Please enter only character allowed with space");
	
	$.validator.addMethod("newemail", function(value, element){
		return this.optional(element) || /^([\w])(([\-.]|[_]+)?([\w]+))*@([\w-]+\.)+[\w-]{2,4}?$/i.test(value);
	}, "Please enter valid email");

	$.validator.addMethod("qtychk", function(value, element){
		if(parseInt(value) > 0)
		{
			return true;
		}else{
			return false;
		}
	}, "Quantity must be greater than Zero");

	$.validator.addMethod("chkremqty", function(value, element){
		if(parseInt(value) > 0)
		{
			if(parseInt($('#remQty').val()) < parseInt(value))
				return false;
			else
				return true;
		}else{
			return false;
		}
	}, "Quantity must be greater than Zero");

	$.validator.addMethod("number", function(value, element){
		return this.optional(element) || /^ *[0-9]+ *$/.test(value);
	}, "Please enter numeric value");

	$.validator.addMethod("chkval", function(value, element){
		if(value == 0)
			return false;
		else
			return true;
	}, "Amount should be greater than zero");

	$.validator.addMethod("postcodes", function(value, element){
		var temp;
		temp = true;
		str = /[^a-zA-Z0-9 ]/;
		temp = !str.test(value);
		return temp;
	}, "Only 0 to 9, a to z, A to Z and space is allowed.");



	$("#frm").validate({
	errorElement:'div',
	rules:{
// START of Billing Address Validation //
		fname:{
				required:true,
				lettersonly:true,
				maxlength:50
		},
		lname:{
				required:true,
				lettersonly:true,
				maxlength:50
		},
		address1:{
				required:true,
				minlength:4,
				maxlength:300
		},
		address2:{
				maxlength:300
		},
		city:{
				required:true
		},
		state:{
				required:true
		},
		postcode:{
				required:true,
				postcodes:true,
				minlength:5,
				maxlength:15
		},
// END of Billing Address Validation //

// START of Payment Info Validation //
		ccfname:{
			required: true,
			lettersonly:true,
// 			fullname: true,
			maxlength:50
		},
		cclname:{
			required: true,
			lettersonly:true,
// 			fullname: true,
			maxlength:50
		},
		cctype:{
			required: true
		},
		ccnumber:{
			required: true,
			number: true,
			minlength:function(){
					var cctypeval = document.getElementById("cctype").value;
					if(cctypeval=="American Express"){return 15;}else{return 16;}
				},
			maxlength:function(){
					var cctypeval = document.getElementById("cctype").value;
					if(cctypeval=="American Express"){return 15;}else{return 16;}
				}
		},
		cccode:{
			required: true,
			minlength:3,
			maxlength:4,
			number:true
		},
// END of Payment Info Validation //
		final_value: {
			chkval: true
		},
		terms:{
			required: true
		}
	},
	
	messages:{
// START of Billing Address Validation //
		fname:{
			required: "Please enter first name",
			maxlength: $.format("Enter maximum {0} characters")
		},
		lname:{
			required: "Please enter last name",
			maxlength: $.format("Enter maximum {0} characters")
		},
		address1:{
			required: "Please enter billing address",
			minlength:jQuery.format("Enter minimum {0} characters"),
			maxlength: $.format("Enter maximum {0} characters")
		},
		address2:{
			maxlength: $.format("Enter maximum {0} characters")
		},
		city:{
			required: "Please enter city name"
		},
		state:{
			required: "Please select state"
		},
		postcode:{
			required: "Please enter postal code",
			number: "Please enter numbers only",
			minlength:jQuery.format("Enter minimum {0} characters"),
			maxlength: $.format("Enter maximum {0} characters")
		},
// END of Billing Address Validation //

// START of Payment Info Validation //
		ccname:{
			required: "Please enter card holder full name",
			fullname: "Please enter only aplhabeats",
			maxlength: $.format("Enter maximum {0} characters")
		},
		cctype:{
			required: "Please enter card type"
		},
		ccnumber:{
			required: "Please enter card number",
			number: "Please enter numbers only",
			minlength:jQuery.format("Enter minimum {0} characters"),
			maxlength: $.format("Enter maximum {0} characters")
		},
		cccode:{
			required: "Please enter cvv number",
			minlength:jQuery.format("Enter minimum {0} characters"),
			maxlength: $.format("Enter maximum {0} characters"),
			number: "Please enter numbers only"
		},
// END of Payment Info Validation //
		final_value: {
			chkval: "Total amount should be greater than zero"
		},
		terms: {
			required: "Please accept terms and condition"
		}
	},
	success: function(div) {
		div.hide();
	}
    });
});
