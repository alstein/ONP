$(document).ready(function()
{

jQuery.validator.addMethod("url_double_dot", function(value, element) {
			for(var i=0; i<value.length; i++)
			{
				if(value[i] == '.' && value[(parseInt(i)+1)] == '.')
					return false;
			}
			return true;
		},"Please enter valid URL");

jQuery.validator.addMethod("emailchk", function(value, element) {
			var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			return rege.test($('#email').val());
	},"Please enter valid email address");
	
	$.validator.addMethod("valid_editor", function(value, element) {
               	var editorcontent = CKEDITOR.instances[element.name].getData().replace(/<[^>]*>/gi, '');
		if (editorcontent.length)
		{
			return true;
		}else
		{
			return false;
		}
     }, "Please enter description");


// $.validator.addMethod("valid_editor", function(value, element){
//                var oEditor = FCKeditorAPI.GetInstance(element.name);
//                var fieldvalue = oEditor.GetXHTML(true);
//                if(fieldvalue=="")
//                { 
//                   return false;
//                } else { 
//                   return true;
//                }
//          }, "Please enter editor decription"); 


//  $.validator.addMethod("numdotOnly", function(value, element) {
//  
//          str =$.trim(value);
//          return /^[-+]?[0-9]+(\.[0-9]+)?$/.test(str);
//      }, "Only numbers and .(decimal) is allowed.");

// jQuery.validator.addMethod("numdotOnly", function(value, element){
//                 var temp;
//                 temp = true;
//                 str = /[^0-9.]/;
//                 temp = !str.test(value);
//                 return temp;
//          }, "Only numbers and .(decimal) is allowed.");
// 

$.validator.addMethod("numdotOnly", function(value, element){
		var chk1 = $("#delivery_service_option_chk_1").val();
		var chk2 = $("#delivery_service_option_chk_2").val();
		var chk3 = $("#delivery_service_option_chk_3").val();
		var chk4 = $("#delivery_service_option_chk_4").val();
		var chk5 = $("#delivery_service_option_chk_5").val();
		if(element.name == "delivery_charges_pound_1" || element.name == "delivery_charges_euro_1" || element.name == "delivery_charges_dollar_1"){
			if(chk1 != "on")
				return true;
		}
		if(element.name == "delivery_charges_pound_2" || element.name == "delivery_charges_euro_2" || element.name == "delivery_charges_dollar_2"){
			if(chk2 != "on")
				return true;
		}
		if(element.name == "delivery_charges_pound_3" || element.name == "delivery_charges_euro_3" || element.name == "delivery_charges_dollar_3"){
			if(chk3 != "on")
				return true;
		}
		if(element.name == "delivery_charges_pound_4" || element.name == "delivery_charges_euro_4" || element.name == "delivery_charges_dollar_4"){
			if(chk4 != "on")
				return true;
		}
		if(element.name == "delivery_charges_pound_5" || element.name == "delivery_charges_euro_5" || element.name == "delivery_charges_dollar_5"){
			if(chk5 != "on")
				return true;
		}

		var temp;
		temp = true;
		str = /[^0-9.]/;
		temp = !str.test(value);
		
		if(temp)
		{
			var prodDiscprice = value;
			var totDotInprodDiscprice = 0;
			var noFirstDotInprodDiscprice = 'no';
			for(var i=0; i<prodDiscprice.length;i++)
			{
				if(prodDiscprice[0] == '.')
				{
					noFirstDotInprodDiscprice = 'yes';
				}
			
				if(prodDiscprice[i] == '.')
				{
					totDotInprodDiscprice++;
				}
			}
			if(totDotInprodDiscprice > 1 || noFirstDotInprodDiscprice == 'yes'){
				temp = false;
			}else{
				temp = true;
			}
		}
		return temp;
	}, "Only numbers and .(decimal) is allowed.");
	
$("#home_form").validate({
        errorElement:'div',
        rules: {
		delivery_charges_pound:
                            {
                            	required: true,
                            	numdotOnly: true,
                            	maxlength: 4
                            },
		delivery_charges_euro:
                            {
                            	required: true,
                            	numdotOnly: true,
                            	maxlength: 4
                            },
		delivery_charges_dollar:
                            {
                            	required: true,
                            	numdotOnly: true,
                            	maxlength: 4
                            },
////////////START Js Validation for Delivery Options//////////////
		delivery_charges_pound_1:
                            {
						required: "#delivery_service_option_chk_1:checked",
						numdotOnly: true,
						maxlength: 4
                            },
		delivery_charges_euro_1:
                            {
						required: "#delivery_service_option_chk_1:checked",
						numdotOnly: true,
						maxlength: 4
                            },
		delivery_charges_dollar_1:
                            {
						required: "#delivery_service_option_chk_1:checked",
						numdotOnly: true,
						maxlength: 4
                            },
////////////////
		delivery_charges_pound_2:
                            {
						required: "#delivery_service_option_chk_2:checked",
						numdotOnly: true,
						maxlength: 4
                            },
		delivery_charges_euro_2:
                            {
						required: "#delivery_service_option_chk_2:checked",
						numdotOnly: true,
						maxlength: 4
                            },
		delivery_charges_dollar_2:
                            {
						required: "#delivery_service_option_chk_2:checked",
						numdotOnly: true,
						maxlength: 4
                            },
////////////////
		delivery_charges_pound_3:
                            {
						required: "#delivery_service_option_chk_3:checked",
						numdotOnly: true,
						maxlength: 4
                            },
		delivery_charges_euro_3:
                            {
						required: "#delivery_service_option_chk_3:checked",
						numdotOnly: true,
						maxlength: 4
                            },
		delivery_charges_dollar_3:
                            {
						required: "#delivery_service_option_chk_3:checked",
						numdotOnly: true,
						maxlength: 4
                            },
////////////////
		delivery_charges_pound_4:
                            {
						required: "#delivery_service_option_chk_4:checked",
						numdotOnly: true,
						maxlength: 4
                            },
		delivery_charges_euro_4:
                            {
						required: "#delivery_service_option_chk_4:checked",
						numdotOnly: true,
						maxlength: 4
                            },
		delivery_charges_dollar_4:
                            {
						required: "#delivery_service_option_chk_4:checked",
						numdotOnly: true,
						maxlength: 4
                            },
////////////////
		delivery_charges_pound_5:
                            {
						required: "#delivery_service_option_chk_5:checked",
						numdotOnly: true,
						maxlength: 4
                            },
		delivery_charges_euro_5:
                            {
						required: "#delivery_service_option_chk_5:checked",
						numdotOnly: true,
						maxlength: 4
                            },
		delivery_charges_dollar_5:
                            {
						required: "#delivery_service_option_chk_5:checked",
						numdotOnly: true,
						maxlength: 4
                            },
		delivery_service_options:
					   {
						required: function(element) {
									var temp = false;
									if($('#delivery_service_option_chk_1').attr('checked') == false && $('#delivery_service_option_chk_2').attr('checked') == false && $('#delivery_service_option_chk_3').attr('checked') == false && $('#delivery_service_option_chk_4').attr('checked') == false && $('#delivery_service_option_chk_5').attr('checked') == false ){
										temp = true;
									}
									return temp;
								}
					   },
/////////////END Js Validation for Delivery Options///////////////
                    seller_support_email:
                            {
                            	required: true,
                            	email: true,
                            	emailchk:true
                            },
                    tracking_URL:
                            {
                            	required: true,
                            	url_double_dot: true,
				url:true
                            },
        delivered_tracking_URL:
                            {
                            	required: true,
                            	url_double_dot: true,
				url:true
                            },
			affiliate_URL:
                            {
						required: true,
						url_double_dot: true,
						url:true
                            },
                affiliate_code:
                            {
						required: true
                            },
                description:
                            {
					valid_editor: true
                            }
                },
                     messages:
                        {
        delivery_charges_pound:
                            {
                                required: "Please enter delivery charges amount value for pound.",
                                numdotOnly: "Please enter numbers only",
                                maxlength: jQuery.format("Enter at most {0} numbers")
				
                            },
        delivery_charges_euro:
                            {
                                required: "Please enter delivery charges amount value for euro.",
                                numdotOnly: "Please enter numbers only",
                                maxlength: jQuery.format("Enter at most {0} numbers")
				
                            },
            delivery_charges_dollar:
                            {
                                required: "Please enter delivery charges amount value for dollar.",
                                numdotOnly: "Please enter numbers only",
                                maxlength: jQuery.format("Enter at most {0} numbers")
				
                            },
////////////START Js Validation for Delivery Options//////////////
		delivery_charges_pound_1:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
		delivery_charges_euro_1:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
		delivery_charges_dollar_1:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
////////////////
		delivery_charges_pound_2:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
		delivery_charges_euro_2:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
		delivery_charges_dollar_2:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
////////////////
		delivery_charges_pound_3:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
		delivery_charges_euro_3:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
		delivery_charges_dollar_3:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
////////////////
		delivery_charges_pound_4:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
		delivery_charges_euro_4:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
		delivery_charges_dollar_4:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
////////////////
		delivery_charges_pound_5:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
		delivery_charges_euro_5:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
		delivery_charges_dollar_5:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },
		delivery_service_options:
					   {
						required: "Please select at least one delivery option."
					   },
/////////////END Js Validation for Delivery Options///////////////
                    seller_support_email:
                            {
                                required: "Please enter seller support email.",
                                email: "Please enter correct email address",
                                emailchk:"Please enter correct email address"
                            },
                    tracking_URL:
                            {
                                required: "Please enter tracking URL.",
                                url:"Please enter correct format website URL."
				
                            },
                    delivered_tracking_URL:
                            {
                                required: "Please enter delivered tracking URL.",
                                url:"Please enter correct format website URL."
                            },
                    description:
                            {
					valid_editor: "Please enter refund policy."
                            }
                        }
                });
			$("#msg").fadeOut(5000);

});



////////////START js code for Delivery Options//////////////

function disabled(chkNo,pram)
{
	$('#delivery_charges_pound_'+chkNo).attr('disabled',pram);
	$('#delivery_charges_euro_'+chkNo).attr('disabled',pram);
	$('#delivery_charges_dollar_'+chkNo).attr('disabled',pram);

	if(pram)
		$('#tr_'+chkNo).css('background-color', '#EBECE4');
	else
		$('#tr_'+chkNo).css('background-color', 'white');
}

function setCurAmt(chkNo,amt)
{
	$('#delivery_charges_pound_'+chkNo).val(amt);
	$('#delivery_charges_euro_'+chkNo).val(amt);
	$('#delivery_charges_dollar_'+chkNo).val(amt);
}

function onChkChange(chkNo)
{
	if(chkNo == '1')
	{
		if($('#delivery_service_option_chk_'+chkNo).attr('checked') == true)
		{
			disabled("2",true);
			disabled("3",true);
			disabled("4",true);
			disabled("5",true);

			$('#delivery_service_option_chk_2').attr('checked',false);
			$('#delivery_service_option_chk_3').attr('checked',false);
			$('#delivery_service_option_chk_4').attr('checked',false);
			$('#delivery_service_option_chk_5').attr('checked',false);

			$('#delivery_service_option_chk_2').attr('disabled',true);
			$('#delivery_service_option_chk_3').attr('disabled',true);
			$('#delivery_service_option_chk_4').attr('disabled',true);
			$('#delivery_service_option_chk_5').attr('disabled',true);

			setCurAmt("2","0");
			setCurAmt("3","0");
			setCurAmt("4","0");
			setCurAmt("5","0");
		}else
		{
			$('#delivery_service_option_chk_2').attr('disabled',false);
			$('#delivery_service_option_chk_3').attr('disabled',false);
			$('#delivery_service_option_chk_4').attr('disabled',false);
			$('#delivery_service_option_chk_5').attr('disabled',false);
		}
	}

	if($('#delivery_service_option_chk_'+chkNo).attr('checked') == true)
	{
		disabled(chkNo,false);
	}else
	{
		setCurAmt(chkNo,"0");
		disabled(chkNo,true);
	}
	$("#home_form").valid();
}

$(document).ready(function()
{
	onChkChange('1');
	onChkChange('2');
	onChkChange('3');
	onChkChange('4');
	onChkChange('5');
});

/////////////END js code for Delivery Options///////////////
