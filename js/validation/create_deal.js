$(document).ready(function() {

   jQuery.validator.addMethod("negative",
    function(value, element)
    {
	if(value >0)
	{
	return true;
	}
	else
	{
	return false;
	}
//     return this.optional(element) ||/^\d?$/i.test(value);
    }, "Please enter positive value  ");  

jQuery.validator.addMethod("noSpace", function(value, element) {
	return value.indexOf(" ") < 0 && value != ""; 
}, "Only A-Z, a-z & _ is allowed without space");

jQuery.validator.addMethod("noZero", function(value, element) {
	return value > 0 && value != ""; 
}, "Please enter maximum numbers greater than 0");


	$.validator.addMethod("noSpecialChars", function(value, element) {
		return /^[a-zA-Z\_]+$/i.test(value);
	}, "Only A-Z, a-z & _ is allowed without space");

	$.validator.addMethod("postcodes", function(value, element){
		var temp;
		temp = true;
		str = /[^a-zA-Z0-9 ]/;
		temp = !str.test(value);
		return temp;
	}, "Only 0 to 9, a to z, A to Z and space is allowed.");



	$.validator.addMethod("max_number2", function(value, element){
		var temp;
		temp = true;
		str = /[^0-9]/;
		temp = !str.test(value);
		return temp;
	}, "Only 0 to 9 is allowed.");

	$.validator.addMethod("alphaOnly", function(value, element){
		var temp;
		temp = true;
		str = /[^a-zA-Z -]/;
		temp = !str.test(value);
		return temp;
	}, "Only a to z, A to Z and - is allowed.");


 $.validator.addMethod("CheckDOB", function (value, element) {
        var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!

	var yyyy = today.getFullYear();
	if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} 
	var today = yyyy+'-'+mm+'-'+dd;
	
        var redeemfrom = $('#redeemfrom').val();
	var redeemto = $('#redeemto').val();

	if(redeemfrom >= today ) {

            return true;
        }
        return false;  
    }, "Redeem date must be grater than today's date.");

 $.validator.addMethod("Redeemto", function (value, element) {
        var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!

	var yyyy = today.getFullYear();
	if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} 
	var today = yyyy+'-'+mm+'-'+dd;
	
        var redeemfrom = $('#redeemfrom').val();
	var redeemto = $('#redeemto').val();

	if(redeemto >= today ) {

            return true;
        }
        return false;  
    }, "Redeem To date must be grater than today's date.");

 $.validator.addMethod("lastdate", function (value, element) {
        var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!

	var yyyy = today.getFullYear();
	if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} 
	var today = yyyy+'-'+mm+'-'+dd;
	
        var lastdate = $('#lastdate').val();
	var redeemto = $('#redeemto').val();

	if(lastdate > today ) {

            return true;
        }
        return false;  
    }, "Last Date date must be grater than today's date.");

 $.validator.addMethod("RedeemDate", function (value, element) {
       
        var redeemfrom = $('#redeemfrom').val();
	var redeemto = $('#redeemto').val();

	if(redeemto >= redeemfrom ) {

            return true;
        }
        return false;  
    }, "Redeem To date must be grater than Redeem From date.");

	jQuery.validator.addMethod("fanonly", function(value, element) {
		var fan_only = document.getElementById('fan_only').checked;
		var all = document.getElementById('all').checked;
		
		if(fan_only== false && all==false)
		{
			return false;
		}
		else
		{
			return true;
		}
		
},"Please atleast check one send to type.");

	jQuery.validator.addMethod("show_percentage", function(value, element) {
		
		if(value >100)
		{
			return false;
		}
		else
		{
			return true;
		}
		
},"% should be less than 100.");

	$('#frm').validate({
		    errorElement:'div',
		    rules: {
			category:{
				
				required: true
			},
			sel_off:{
				required: true,
				number:true,
				show_percentage:true,
				negative:true
			},
			deal_name: {
				required: true,
				minlength: 3,
				maxlength: 100,
				alphaOnly:true
				
			},
			originalprice: {
				required: true,
				number:true,
				negative:true
				
			},
			max_number: {
				required: true,
				number:true,
				noZero: true,
				max_number2:true,
				negative:true
				
			},
			
			lastdate:{
				required: true,
				lastdate:true
			},
			redeemfrom:{
				required: true,
				CheckDOB:true
				
			},
			redeemto:{
				required: true,
				Redeemto:true,
				RedeemDate:true
				
				
			},
			deal_photo:{
				required:true,
				accept: "jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG"
				
			},
			all:{
			    fanonly:true 
			},
			chk_agree:{
					required:true
			}

		    },
		    messages: {
			category:{
				required: "Please select category."
				
			},
			sel_off:{
				required: "please enter how many % off on deal"
			},
			deal_name:{
				required: "Please enter deal name",
				minlength: $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters")
			},
			originalprice:{
				required: "Please enter original price."
			},
			max_number:{
				required: "Please enter maximum numbers that can be bought."
			},
			lastdate:{
				required: "Please select last date to buy deal."
			},
			redeemfrom:{
				required: "Please select redeem from date."
			},
			redeemto:{
				required: "Please select redeem to date."
			},
			deal_photo:{
				required: "Please upload deal picture.",
				 accept: "Please provide valid image format"
			},
			chk_agree:{
				required: "Please accept terms and conditions."
			}
			
			
		},
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
        });
		
});

