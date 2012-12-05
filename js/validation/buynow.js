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

	$.validator.addMethod("postcodes", function(value, element){
		var temp;
		temp = true;
		str = /[^a-zA-Z0-9 ]/;
		temp = !str.test(value);
		return temp;
	}, "Only 0 to 9, a to z, A to Z and space is allowed.");


// $("#gft_chk").click(function() {
// 	$("#gft_to").valid();
// 	$("#gft_from").valid();
// 	$("#gft_frndEmail").valid();
// 	$("#gft_msg").valid();
// });


	$("#dealbuynow").validate({
	errorElement:'div',
	rules:{
// START of Gift Validation //
		gft_to:{
			required: "#gft_chk:checked",
			fullname: "#gft_chk:checked",
			maxlength:50
		},
		gft_from:{
			required: "#gft_chk:checked",
			fullname: "#gft_chk:checked",
			maxlength:50
		},
		gft_frndEmail:{
			required: "#gft_chk:checked",
			newemail: "#gft_chk:checked"
		},
		gft_msg:{
			required: "#gft_chk:checked"
		},
// END of Gift Validation //

// START of Promotion Code Validation //
		prmoCode:{
			required: "#prmo_chk:checked",
			remote: {url:SITEROOT + "/modules/deal/ajax_check_promotion_code.php",type:"post"}
		},
// END of Promotion Code Validation //

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

/*
// START of Payment Info Validation //
		ccfname:{
			required: "#totAmtNotZero_chk:checked",
			lettersonly:true,
// 			fullname: true,
			maxlength:50
		},
		cclname:{
			required: "#totAmtNotZero_chk:checked",
			lettersonly:true,
// 			fullname: true,
			maxlength:50
		},
		cctype:{
			required: "#totAmtNotZero_chk:checked"
		},
		ccnumber:{
			required: "#totAmtNotZero_chk:checked",
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
			required: "#totAmtNotZero_chk:checked",
			minlength:3,
			maxlength:4,
			number:true
		},
// END of Payment Info Validation //
*/
		quantity:{
			required: true,
			number: true,
			qtychk: true,
			chkremqty: true,
			maxlength: 50
		},
		terms:{
			required: true
		},
		delivery_service_option:{
			required: true
		}
	},
	
	messages:{
// START of Gift Validation //
		gft_to: {
			required: "Please enter gift receiver name",
			fullname: "Please enter only aplhabeats",
			maxlength: $.format("Enter maximum {0} characters")
		},
		gft_from: {
			required: "Please enter gift sender name",
			fullname: "Please enter only aplhabeats",
			maxlength: $.format("Enter maximum {0} characters")
		},
		gft_frndEmail:{
			required: "Please enter receiver email",
			newemail: "Please enter valid email address"
		},
		gft_msg:{
			required: "Please enter message"
		},
// END of Gift Validation //

// START of Promotion Code Validation //
		prmoCode:{
			required: "Please enter promotion code",
			remote: "Please enter valid code"
		},
// END of Promotion Code Validation //

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

/*
// START of Payment Info Validation //
		ccfname:{
			required: "Please enter card holder first name",
			maxlength: $.format("Enter maximum {0} characters")
		},
		cclname:{
			required: "Please enter card holder last name",
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
*/

		quantity:{
			required: "Please enter quantity",
			number: "Please enter numeric value only",
			qtychk: "Quantity must be greater than Zero",
			chkremqty: "Quantity must be less than or equal to "+$('#remQty').val(),
			maxlength: $.format("Enter maximum {0} digits")
		},
		terms: {
			required: "Please accept terms and condition"
		},
		delivery_service_option:{
			required: "Please select delivery service option"
		}
	},
	success: function(div) {
		div.hide();
	}
    });
});


//////////////////////////
var xmlHttp
function GetXmlHttpObject(){
	var xmlHttp=null;
	try{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e){
		// Internet Explorer
		try{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e){
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}
///////////////////////////

function changeDeliveryChrg(id)
{
	if(id != '')
	{
		$('#delCharHID').val($('#'+id).val());
		$('#delCharHTML').html($('#'+id).val());
	}else
	{
		$('#delCharHTML').html('0.00');
		$('#delCharHID').val('0.00');
	}
}

function state_value(){
	if (xmlHttp.readyState==4)
	{
		var response=xmlHttp.responseText;
		$('#prmoPriceHTML').html(response);
		$('#prmoPriceHID').val(response);

		var qty = $('#quantity').val();
		var totAmt = parseFloat($('#dealAmt').val());


		var purchasedQty = parseInt($('#purchasedQty').val());
		var totalQty = (purchasedQty + parseInt(qty));

		if($('#range1').val() == 'true'){
			if(totalQty >= parseInt($('#min1').val()))totAmt = parseFloat($('#price1').val());
			if($('#range2').val() == 'true'){
				if(totalQty >= parseInt($('#min2').val()))totAmt = parseFloat($('#price2').val());
				if($('#range3').val() == 'true'){
					if(totalQty >= parseInt($('#min3').val()))totAmt = parseFloat($('#price3').val());
					if($('#range4').val() == 'true'){
						if(totalQty >= parseInt($('#min4').val()))totAmt = parseFloat($('#price4').val());
						if($('#range5').val() == 'true'){
							if(totalQty >= parseInt($('#min5').val()))totAmt = parseFloat($('#price5').val());
						}
					}
				}
			}
		}
		$('#dealAmt').val(totAmt.toFixed(2));
		$('#dealAmtHTML').html(totAmt.toFixed(2));

		var diliveryChar = parseFloat($('#delCharHID').val());
		var totAmt = totAmt+diliveryChar;
		var totAmt = ((parseFloat(totAmt)*parseInt(qty))-parseFloat(response));

		$('#delQtyHTML').html(qty);
		$('#delTotCharHTML').html(parseFloat(diliveryChar)*parseFloat(qty));
		$('#delTotCharHID').val(parseFloat(diliveryChar)*parseFloat(qty));

		if(totAmt<=0)
		{
			totAmt = 0;
			$('#payInfo').hide();
			$('#noNeedToPayDiv').show();

			$('#totAmtNotZero_chk').attr('checked','');
			$('#ccfname').val('');
			$('#cclname').val('');
			$('#ccnumber').val('');
			$('#cccode').val('');
		}else{
			$('#payInfo').show();
			$('#noNeedToPayDiv').hide();

			$('#totAmtNotZero_chk').attr('checked','checked');
		}
		$('#totalAmtHTML').html(totAmt.toFixed(2));
		$('#totalAmt').val(totAmt.toFixed(2));
	}
}

function calcPrice(){
	var qty = $.trim($('#quantity').val());
	if(!qty.match('^(0|[1-9][0-9]*)$'))
	{
		qty = 1;
	}
	$('#quantity').valid();

	if($('#prmo_chk').attr('checked') == true)
	{
		$('#prmoCode').valid();
		
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null){
			alert ("Your browser does not support AJAX!");
			return;
		}
		var url = SITEROOT+"/modules/deal/ajax_get_promotion_code_amt.php";
		url=url+"?prmoCode="+$('#prmoCode').val()+"&curType="+$('#currencyType').val();
		xmlHttp.onreadystatechange=state_value;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}else{
		$('#prmoPriceHTML').html(0);
		$('#prmoPriceHID').val(0);

		var dealAmt = parseFloat($('#dealAmt').val());
		var purchasedQty = parseInt($('#purchasedQty').val());
		var totalQty = (purchasedQty + parseInt(qty));

		if($('#range1').val() == 'true'){
			if(totalQty >= parseInt($('#min1').val()))dealAmt = parseFloat($('#price1').val());
			if($('#range2').val() == 'true'){
				if(totalQty >= parseInt($('#min2').val()))dealAmt = parseFloat($('#price2').val());
				if($('#range3').val() == 'true'){
					if(totalQty >= parseInt($('#min3').val()))dealAmt = parseFloat($('#price3').val());
					if($('#range4').val() == 'true'){
						if(totalQty >= parseInt($('#min4').val()))dealAmt = parseFloat($('#price4').val());
						if($('#range5').val() == 'true'){
							if(totalQty >= parseInt($('#min5').val()))dealAmt = parseFloat($('#price5').val());
						}
					}
				}
			}
		}

		$('#dealAmt').val(dealAmt.toFixed(2));
		$('#dealAmtHTML').html(dealAmt.toFixed(2));
		var diliveryChar = parseFloat($('#delCharHID').val());
		dealAmt = dealAmt+diliveryChar;
		dealAmt = (parseFloat(dealAmt)*parseFloat(qty));

		$('#delQtyHTML').html(qty);
		$('#delTotCharHTML').html(parseFloat(diliveryChar)*parseFloat(qty));
		$('#delTotCharHID').val(parseFloat(diliveryChar)*parseFloat(qty));

		$('#totalAmtHTML').html(dealAmt.toFixed(2));
		$('#totalAmt').val(dealAmt.toFixed(2));

		if($('#totalAmt').val() <= 0)
		{
			$('#payInfo').hide();
			$('#noNeedToPayDiv').show();
		}else{
			$('#payInfo').show();
			$('#noNeedToPayDiv').hide();
			$('#totAmtNotZero_chk').attr('checked','checked');
		}
	}
}


