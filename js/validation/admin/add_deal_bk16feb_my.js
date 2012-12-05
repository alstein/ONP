
$(document).ready(function(){


	$.validator.addMethod("email", function(value, element) {
		var rege = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if($('#seller_support_email').val().length > 0)
		{
			return rege.test($('#seller_support_email').val());
		}else
		{
			return true;
		}
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

	$.validator.addMethod("check_price", function( value, element, param ) {
		var val_a = $("#price").val();
		//return this.optional(element) || (value >= val_a);
		var resVal = eval(value - val_a);
		return (resVal >= 0);
	},"Please enter Original price must be greater than Usortd price.");



// 	$.validator.addMethod("check_maxmin", function( value, element, param )
// 	{
// 		var dealmaintype = document.getElementById("dealmaintype").value;
// // 		if(dealmaintype == '3')
// 		if(is_groupbuy(dealmaintype) == 'true')
// 		{
// 			return true;
// 		}else{
// 			var val_a = $("#min_buyer").val();
// 			//return this.optional(element) || (value >= val_a);
// 			var resVal = eval(value - val_a);
// 			return (resVal >= 0);
// 		}
// 	},"Please enter Maximum Number of Buyers must be greater than Minimum Buyers Required.");
// 	
// 	$.validator.addMethod("check_minmax_for_groupbuy_2", function( value, element, param )
// 	{
// 		var dealmaintype = document.getElementById("dealmaintype").value;
// 		var chk = document.getElementById("chk_2").checked;
// // 		if(dealmaintype == '3' && chk == true)
// 		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
// 		{
// 			var val_a = $("#max_buyer_1").val();
// 			//return this.optional(element) || (value >= val_a);
// 			var resVal = eval(value - val_a);
// 			return (resVal > 0);
// 		}else{
// 			return true;
// 		}
// 	},"Please enter Minimum Number of Buyers must be less than Maximum Buyers Required of above range.");

// 	$.validator.addMethod("check_minmax_for_groupbuy_3", function( value, element, param )
// 	{
// 		var dealmaintype = document.getElementById("dealmaintype").value;
// 		var chk = document.getElementById("chk_3").checked;
// // 		if(dealmaintype == '3' && chk == true)
// 		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
// 		{
// 			var val_a = $("#max_buyer_2").val();
// 			//return this.optional(element) || (value >= val_a);
// 			var resVal = eval(value - val_a);
// 			return (resVal > 0);
// 		}else{
// 			return true;
// 		}
// 	},"Please enter Minimum Number of Buyers must be less than Maximum Buyers Required of above range.");

/*	$.validator.addMethod("check_minmax_for_groupbuy_4", function( value, element, param )
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
		var chk = document.getElementById("chk_4").checked;
// 		if(dealmaintype == '3' && chk == true)
		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
		{
			var val_a = $("#max_buyer_3").val();
			//return this.optional(element) || (value >= val_a);
			var resVal = eval(value - val_a);
			return (resVal > 0);
		}else{
			return true;
		}
	},"Please enter Minimum Number of Buyers must be less than Maximum Buyers Required of above range.");
*/
// 	$.validator.addMethod("check_minmax_for_groupbuy_5", function( value, element, param )
// 	{
// 		var dealmaintype = document.getElementById("dealmaintype").value;
// 		var chk = document.getElementById("chk_5").checked;
// // 		if(dealmaintype == '3' && chk == true)
// 		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
// 		{
// 			var val_a = $("#max_buyer_4").val();
// 			//return this.optional(element) || (value >= val_a);
// 			var resVal = eval(value - val_a);
// 			return (resVal > 0);
// 		}else{
// 			return true;
// 		}
// 	},"Please enter Minimum Number of Buyers must be less than Maximum Buyers Required of above range.");
/*
	$.validator.addMethod("check_maxmin_for_groupbuy_1", function( value, element, param )
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
		var chk = document.getElementById("chk_1").checked;
// 		if(dealmaintype == '3' && chk == true)
		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
		{
			var val_a = $("#min_buyer_1").val();
			//return this.optional(element) || (value >= val_a);
			var resVal = eval(value - val_a);
			return (resVal >= 0);
		}else{
			return true;
		}
	},"Please enter Maximum Number of Buyers must be greater than Minimum Buyers Required.");*/

// 	$.validator.addMethod("check_maxmin_for_groupbuy_2", function( value, element, param )
// 	{
// 		var dealmaintype = document.getElementById("dealmaintype").value;
// 		var chk = document.getElementById("chk_2").checked;
// // 		if(dealmaintype == '3' && chk == true)
// 		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
// 		{
// 			var val_a = $("#min_buyer_2").val();
// 			//return this.optional(element) || (value >= val_a);
// 			var resVal = eval(value - val_a);
// 			return (resVal >= 0);
// 		}else{
// 			return true;
// 		}
// 	},"Please enter Maximum Number of Buyers must be greater than Minimum Buyers Required.");

// 	$.validator.addMethod("check_maxmin_for_groupbuy_3", function( value, element, param )
// 	{
// 		var dealmaintype = document.getElementById("dealmaintype").value;
// 		var chk = document.getElementById("chk_3").checked;
// // 		if(dealmaintype == '3' && chk == true)
// 		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
// 		{
// 			var val_a = $("#min_buyer_3").val();
// 			//return this.optional(element) || (value >= val_a);
// 			var resVal = eval(value - val_a);
// 			return (resVal >= 0);
// 		}else{
// 			return true;
// 		}
// 	},"Please enter Maximum Number of Buyers must be greater than Minimum Buyers Required.");

// 	$.validator.addMethod("check_maxmin_for_groupbuy_4", function( value, element, param )
// 	{
// 		var dealmaintype = document.getElementById("dealmaintype").value;
// 		var chk = document.getElementById("chk_4").checked;
// // 		if(dealmaintype == '3' && chk == true)
// 		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
// 		{
// 			var val_a = $("#min_buyer_4").val();
// 			//return this.optional(element) || (value >= val_a);
// 			var resVal = eval(value - val_a);
// 			return (resVal >= 0);
// 		}else{
// 			return true;
// 		}
// 	},"Please enter Maximum Number of Buyers must be greater than Minimum Buyers Required.");

// 	$.validator.addMethod("check_maxmin_for_groupbuy_5", function( value, element, param )
// 	{
// 		var dealmaintype = document.getElementById("dealmaintype").value;
// 		var chk = document.getElementById("chk_5").checked;
// // 		if(dealmaintype == '3' && chk == true)
// 		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
// 		{
// 			var val_a = $("#min_buyer_5").val();
// 			//return this.optional(element) || (value >= val_a);
// 			var resVal = eval(value - val_a);
// 			return (resVal >= 0);
// 		}else{
// 			return true;
// 		}
// 	},"Please enter Maximum Number of Buyers must be greater than Minimum Buyers Required.");

// 	$.validator.addMethod("check_with_original_price", function( value, element, param )
// 	{
// 		var dealmaintype = document.getElementById("dealmaintype").value;
// // 		if(dealmaintype == '3')
// 		if(is_groupbuy(dealmaintype) == 'true')
// 		{
// 			var val_a = $("#originalprice").val();
// 			//return this.optional(element) || (value >= val_a);
// 			var resVal = eval(val_a - value);
// 			return (resVal >= 0);
// 		}else{
// 			return true;
// 		}
// 	},"Value should be less than or equal to original price.");


	$.validator.addMethod("numdotOnly", function(value, element){
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

// 	$.validator.addMethod("numdotOnlyNotForGroupType", function(value, element)
// 	{
// 		var dealmaintype = document.getElementById("dealmaintype").value;
// // 		if(dealmaintype != '3')
// 		if(is_groupbuy(dealmaintype) != 'true')
// 		{
// 			var temp;
// 			temp = true;
// 			str = /[^0-9.]/;
// 			temp = !str.test(value);
// 
// 			if(temp)
// 			{
// 				var prodDiscprice = value;
// 				var totDotInprodDiscprice = 0;
// 				var noFirstDotInprodDiscprice = 'no';
// 				for(var i=0; i<prodDiscprice.length;i++)
// 				{
// 					if(prodDiscprice[0] == '.')
// 					{
// 						noFirstDotInprodDiscprice = 'yes';
// 					}
// 				
// 					if(prodDiscprice[i] == '.')
// 					{
// 						totDotInprodDiscprice++;
// 					}
// 				}
// 				if(totDotInprodDiscprice > 1 || noFirstDotInprodDiscprice == 'yes'){
// 					temp = false;
// 				}else{
// 					temp = true;
// 				}
// 			}
// 			return temp;
// 		}else{
// 			return true;
// 		}
// 	}, "Only numbers and .(decimal) is allowed.");

// $.validator.addMethod("numdotOnlyForGroupType", function(value, element)
// 	{
// 		var dealmaintype = document.getElementById("dealmaintype").value;
// // 		if(dealmaintype == '3')
// 		if(is_groupbuy(dealmaintype) == 'true')
// 		{
// 			var temp;
// 			temp = true;
// 			str = /[^0-9.]/;
// 			temp = !str.test(value);
// 
// 			if(temp)
// 			{
// 				var prodDiscprice = value;
// 				var totDotInprodDiscprice = 0;
// 				var noFirstDotInprodDiscprice = 'no';
// 				for(var i=0; i<prodDiscprice.length;i++)
// 				{
// 					if(prodDiscprice[0] == '.')
// 					{
// 						noFirstDotInprodDiscprice = 'yes';
// 					}
// 				
// 					if(prodDiscprice[i] == '.')
// 					{
// 						totDotInprodDiscprice++;
// 					}
// 				}
// 				if(totDotInprodDiscprice > 1 || noFirstDotInprodDiscprice == 'yes'){
// 					temp = false;
// 				}else{
// 					temp = true;
// 				}
// 			}
// 			return temp;
// 		}else{
// 			return true;
// 		}
// 	}, "Only numbers and .(decimal) is allowed.");

	$.validator.addMethod("numGreatZero", function(value, element)
	{
			var temp;
			temp = true;
			temp = !(value<=0);
			return temp;
         }, "Please enter value must be greater than zero(0)");

// 	$.validator.addMethod("numGreatZeroNotForGroupType", function(value, element)
// 	{
// 			var dealmaintype = document.getElementById("dealmaintype").value;
// // 			if(dealmaintype != '3')
// 			if(is_groupbuy(dealmaintype) != 'true')
// 			{
// 				var temp;
// 				temp = true;
// 				temp = !(value<=0);
// 				return temp;
// 			}else{
// 				return true;
// 			}
//          }, "Please enter value must be greater than zero(0)");
// 

// 	$.validator.addMethod("numGreatZeroForGroupBuy_1", function(value, element)
// 	{
// 			var dealmaintype = document.getElementById("dealmaintype").value;
// 			var chk = document.getElementById("chk_1").checked;
// // 			if(dealmaintype == '3' && chk == true)
// 			if(is_groupbuy(dealmaintype) == 'true' && chk == true)
// 			{
// 				var temp;
// 				temp = true;
// 				temp = !(value<=0);
// 				return temp;
// 			}else{
// 				return true;
// 			}
// 	}, "Please enter value must be greater than zero(0)");

// 	$.validator.addMethod("numGreatZeroForGroupBuy_2", function(value, element)
// 	{
// 			var dealmaintype = document.getElementById("dealmaintype").value;
// 			var chk = document.getElementById("chk_2").checked;
// // 			if(dealmaintype == '3' && chk == true)
// 			if(is_groupbuy(dealmaintype) == 'true' && chk == true)
// 			{
// 				var temp;
// 				temp = true;
// 				temp = !(value<=0);
// 				return temp;
// 			}else{
// 				return true;
// 			}
// 	}, "Please enter value must be greater than zero(0)");

// 	$.validator.addMethod("numGreatZeroForGroupBuy_3", function(value, element)
// 	{
// 			var dealmaintype = document.getElementById("dealmaintype").value;
// 			var chk = document.getElementById("chk_3").checked;
// // 			if(dealmaintype == '3' && chk == true)
// 			if(is_groupbuy(dealmaintype) == 'true' && chk == true)
// 			{
// 				var temp;
// 				temp = true;
// 				temp = !(value<=0);
// 				return temp;
// 			}else{
// 				return true;
// 			}
// 	}, "Please enter value must be greater than zero(0)");

// 	$.validator.addMethod("numGreatZeroForGroupBuy_4", function(value, element)
// 	{
// 			var dealmaintype = document.getElementById("dealmaintype").value;
// 			var chk = document.getElementById("chk_4").checked;
// // 			if(dealmaintype == '3' && chk == true)
// 			if(is_groupbuy(dealmaintype) == 'true' && chk == true)
// 			{
// 				var temp;
// 				temp = true;
// 				temp = !(value<=0);
// 				return temp;
// 			}else{
// 				return true;
// 			}
// 	}, "Please enter value must be greater than zero(0)");

/*	$.validator.addMethod("numGreatZeroForGroupBuy_5", function(value, element)
	{
			var dealmaintype = document.getElementById("dealmaintype").value;
			var chk = document.getElementById("chk_5").checked;
// 			if(dealmaintype == '3' && chk == true)
			if(is_groupbuy(dealmaintype) == 'true' && chk == true)
			{
				var temp;
				temp = true;
				temp = !(value<=0);
				return temp;
			}else{
				return true;
			}
	}, "Please enter value must be greater than zero(0)");
*/
// 	jQuery.validator.addMethod("numeric", function(value, element)
// 	{
// 		var dealmaintype = document.getElementById("dealmaintype").value;
// // 		if(dealmaintype == '3')
// 		if(is_groupbuy(dealmaintype) == 'true')
// 		{
// 			return true;
// 		}else{
// 			return this.optional(element) || /^[0-9]+$/i.test(value);
// 		}
// 	}, "please insert numbers only");

// 	jQuery.validator.addMethod("numericForGroupBuy", function(value, element)
// 	{
// 		var dealmaintype = document.getElementById("dealmaintype").value;
// // 		if(dealmaintype == '3')
// 		if(is_groupbuy(dealmaintype) == 'true')
// 		{
// 			return this.optional(element) || /^[0-9]+$/i.test(value);
// 		}else{
// 			return true;
// 		}
// 	}, "please insert numbers only");

// 	jQuery.validator.addMethod("url", function(value, element)
// 	{
// 		var urldata = value;
// 		if(urldata == '')
// 			return true;
//  		var urlregex = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\..)");
// 
// 		return urlregex.test(urldata);
// 	}, "please enter valide url");


/*	jQuery.validator.addMethod("decimalchk", function(value, element)
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
// 		if(dealmaintype == '3')
		if(is_groupbuy(dealmaintype) != 'true')
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
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}, "Please enter valid deal usortd price");*/
	
	$.validator.addMethod("postcodes", function(value, element){
                var temp;
                temp = true;
                str = /[^a-zA-Z0-9 ]/;
                temp = !str.test(value);
                return temp;
         }, "Only 0 to 9, a to z, A to Z and space is allowed.");

// 	jQuery.validator.addMethod("decimalchkforGroupBuy", function(value, element)
// 	{
// 		var dealmaintype = document.getElementById("dealmaintype").value;
// // 		if(dealmaintype == '3')
// 		if(is_groupbuy(dealmaintype) == 'true')
// 		{
// 			var prodDiscprice = value;
// 			var totDotInprodDiscprice = 0;
// 			var noFirstDotInprodDiscprice = 'no';
// 			for(var i=0; i<prodDiscprice.length;i++)
// 			{
// 				if(prodDiscprice[0] == '.')
// 				{
// 					noFirstDotInprodDiscprice = 'yes';
// 				}
// 			
// 				if(prodDiscprice[i] == '.')
// 				{
// 					totDotInprodDiscprice++;
// 				}
// 			}
// 			if(totDotInprodDiscprice > 1 || noFirstDotInprodDiscprice == 'yes'){
// 				return false;
// 			}else{
// 				return true;
// 			}
// 		}else{
// 			return true;
// 		}
// 	}, "Please enter valid deal usortd price");


	$("#frm").validate({
	
		errorElement:'div',
		rules: {
/*			dealmaintype:{
				required: true
			},*/
// 			subcategory: {
// 				required: true
// 			},
// 			subsubcategory: {
// 				required: true
// 			},
// 			subsubsubcategory: {
// 				required: true
// 			},
/*
			dealcity: {
				required: function(){
							var is_national = document.getElementById("is_national");
							if(is_national.checked == true)
							{
								return false;
							}else{
								return true;
							}
						}
			},
			dealstate: {
				required: function(){
							var is_national = document.getElementById("is_national");
							if(is_national.checked == true)
							{
								return false;
							}else{
								return true;
							}
						}
			},
*/
			title1:{
				//required: true,
				//maxlength:255
				valid_editor: true
			},
			subtitle:{
				//required: true,
				//maxlength:255
				valid_editor: true
			},
			deal_from_seller_name:{
				//required: true
			},
			deal_from_seller_name_other:{
				required:  function(){
							var dlFromSellName = document.getElementById("deal_from_seller_name").value;
							if(dlFromSellName == "" || dlFromSellName == "other_seller")
							{
								return true;
							}else{
								return false;
							}
						},
				maxlength:function(){
							var dlFromSellName = document.getElementById("deal_from_seller_name").value;
							if(dlFromSellName == "" || dlFromSellName == "other_seller")
							{
								return 255;
							}else{
								return 255;
							}
						}
			},
			zipcode:{
				required: true,
				postcodes: true,
				minlength:6,
				maxlength:8
			},
			description:{
				//required: true,
				valid_editor: true
			},
			highlight:{
				//required: true,
				valid_editor: true
			},
			fineprint:{
				//required: true,
				valid_editor: true
			},
			qr_code_link:{
			         url:true
			 
			},
			qr_code_image:{
			 accept: "jpg|png|gif"
			},
////////////START Js Validation for Delivery Options//////////////
/*		delivery_charges_pound_1:
                            {
						required: "#delivery_service_option_chk_1:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
/*		delivery_charges_euro_1:
                            {
						required: "#delivery_service_option_chk_1:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
/*		delivery_charges_dollar_1:
                            {
						required: "#delivery_service_option_chk_1:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
////////////////
/*		delivery_charges_pound_2:
                            {
						required: "#delivery_service_option_chk_2:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
/*		delivery_charges_euro_2:
                            {
						required: "#delivery_service_option_chk_2:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
/*		delivery_charges_dollar_2:
                            {
						required: "#delivery_service_option_chk_2:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
////////////////
/*		delivery_charges_pound_3:
                            {
						required: "#delivery_service_option_chk_3:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
/*		delivery_charges_euro_3:
                            {
						required: "#delivery_service_option_chk_3:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
/*		delivery_charges_dollar_3:
                            {
						required: "#delivery_service_option_chk_3:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
////////////////
/*		delivery_charges_pound_4:
                            {
						required: "#delivery_service_option_chk_4:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
/*		delivery_charges_euro_4:
                            {
						required: "#delivery_service_option_chk_4:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
/*		delivery_charges_dollar_4:
                            {
						required: "#delivery_service_option_chk_4:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
////////////////
/*		delivery_charges_pound_5:
                            {
						required: "#delivery_service_option_chk_5:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
/*		delivery_charges_euro_5:
                            {
						required: "#delivery_service_option_chk_5:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
/*		delivery_charges_dollar_5:
                            {
						required: "#delivery_service_option_chk_5:checked",
						numdotOnly: true,
						maxlength: 4
                            },*/
/*		delivery_service_options:
					   {
						required: function(element) {
									var temp = false;
									if($('#delivery_service_option_chk_1').attr('checked') == false && $('#delivery_service_option_chk_2').attr('checked') == false && $('#delivery_service_option_chk_3').attr('checked') == false && $('#delivery_service_option_chk_4').attr('checked') == false && $('#delivery_service_option_chk_5').attr('checked') == false ){
										temp = true;
									}
									return temp;
								}
					   },*/
/////////////END Js Validation for Delivery Options///////////////
			seller_support_email:{
				email: true
			},
			trackURL:{
// 				required: true,
				//url:true,
				maxlength:255
			},
			delivered_tracking_url_code:{
// 				required: true,
				//url:true,
				maxlength:255
			},
			otherproductURL:{
// 				required: true,
				url:true,
				maxlength:100
			},
			retailerwebURL:{
// 				required: true,
				url:true,
				maxlength:100
			},
			retailer_website_affiliate_link:{
// 				required: "Please enter retailer website affiliate link",
				maxlength:255
			},
			price:{
				required: true,
				//numdotOnlyNotForGroupType : true,
				//numGreatZeroNotForGroupType : true,
				maxlength:7
			},
			originalprice:{
				required: true,
				numdotOnly : true,
				check_price:true,
				numGreatZero : true,
				maxlength:7
			},
/*			min_buyer_1:{
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							var chk = document.getElementById("chk_1").checked;
// 							if(dealmaintype == '3' && chk == true)
							if(is_groupbuy(dealmaintype) == 'true' && chk == true)
							{
               					return true;
            					}else{
               					return false;
            					}
						},
				//numericForGroupBuy : true,
				//numGreatZeroForGroupBuy_1 : true,
				maxlength:8
			},*/
/*			min_buyer_2:{
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							var chk = document.getElementById("chk_2").checked;
// 							if(dealmaintype == '3' && chk == true)
							if(is_groupbuy(dealmaintype) == 'true' && chk == true)
							{
               					return true;
            					}else{
               					return false;
            					}
						},
				//numericForGroupBuy : true,
				//numGreatZeroForGroupBuy_2 : true,
				maxlength:8,
				//check_minmax_for_groupbuy_2 : true
			},*/
/*			min_buyer_3:{
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							var chk = document.getElementById("chk_3").checked;
// 							if(dealmaintype == '3' && chk == true)
							if(is_groupbuy(dealmaintype) == 'true' && chk == true)
							{
               					return true;
            					}else{
               					return false;
            					}
						},
				//numericForGroupBuy : true,
				//numGreatZeroForGroupBuy_3 : true,
				maxlength:8,
				//check_minmax_for_groupbuy_3 : true
			},*/
/*			min_buyer_4:{
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							var chk = document.getElementById("chk_4").checked;
// 							if(dealmaintype == '3' && chk == true)
							if(is_groupbuy(dealmaintype) == 'true' && chk == true)
							{
               					return true;
            					}else{
               					return false;
            					}
						},
				//numericForGroupBuy : true,
				//numGreatZeroForGroupBuy_4 : true,
				maxlength:8,
				//check_minmax_for_groupbuy_4 : true
			},*/
/*			min_buyer_5:{
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							var chk = document.getElementById("chk_5").checked;
// 							if(dealmaintype == '3' && chk == true)
							if(is_groupbuy(dealmaintype) == 'true' && chk == true)
							{
               					return true;
            					}else{
               					return false;
            					}
						},
				//numericForGroupBuy : true,
				//numGreatZeroForGroupBuy_5 : true,
				maxlength:8,
				//check_minmax_for_groupbuy_5 : true
			},*/
/*			max_buyer_1:{
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							var chk = document.getElementById("chk_1").checked;
// 							if(dealmaintype == '3' && chk == true)
							if(is_groupbuy(dealmaintype) == 'true' && chk == true)
							{
               					return true;
            					}else{
               					return false;
            					}
						},
				//numericForGroupBuy : true,
				//numGreatZeroForGroupBuy_1 : true,
				maxlength:8,
				//check_maxmin_for_groupbuy_1 : true
			},*/
/*			max_buyer_2:{
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							var chk = document.getElementById("chk_2").checked;
// 							if(dealmaintype == '3' && chk == true)
							if(is_groupbuy(dealmaintype) == 'true' && chk == true)
							{
               					return true;
            					}else{
               					return false;
            					}
						},
				//numericForGroupBuy : true,
				//numGreatZeroForGroupBuy_2 : true,
				maxlength:8,
// 				check_maxmin_for_groupbuy_2 : function(){
//             					var dealmaintype = document.getElementById("dealmaintype").value;
// 							//if(dealmaintype == '3')
// 							if(is_groupbuy(dealmaintype) == 'true')
// 							{
//                					return true;
//             					}else{
//                					return false;
//             					}
// 						}
			},*/
// 			max_buyer_3:{
// 				required: function(){
//             					var dealmaintype = document.getElementById("dealmaintype").value;
// 							var chk = document.getElementById("chk_3").checked;
// // 							if(dealmaintype == '3' && chk == true)
// 							if(is_groupbuy(dealmaintype) == 'true' && chk == true)
// 							{
//                					return true;
//             					}else{
//                					return false;
//             					}
// 						},
// 				//numericForGroupBuy : true,
// 				//numGreatZeroForGroupBuy_3 : true,
// 				maxlength:8,
// // 				check_maxmin_for_groupbuy_3 : function(){
// //             					var dealmaintype = document.getElementById("dealmaintype").value;
// // 							//if(dealmaintype == '3')
// // 							if(is_groupbuy(dealmaintype) == 'true')
// // 							{
// //                					return true;
// //             					}else{
// //                					return false;
// //             					}
// // 						}
// 			},
// 			max_buyer_4:{
// 				required: function(){
//             					var dealmaintype = document.getElementById("dealmaintype").value;
// 							var chk = document.getElementById("chk_4").checked;
// // 							if(dealmaintype == '3' && chk == true)
// 							if(is_groupbuy(dealmaintype) == 'true' && chk == true)
// 							{
//                					return true;
//             					}else{
//                					return false;
//             					}
// 						},
// 				//numericForGroupBuy : true,
// 				//numGreatZeroForGroupBuy_4 : true,
// 				maxlength:8,
// // 				check_maxmin_for_groupbuy_4 : function(){
// //             					var dealmaintype = document.getElementById("dealmaintype").value;
// // 							//if(dealmaintype == '3')
// // 							if(is_groupbuy(dealmaintype) == 'true')
// // 							{
// //                					return true;
// //             					}else{
// //                					return false;
// //             					}
// // 						}
// 			},
/*			max_buyer_5:{
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							var chk = document.getElementById("chk_5").checked;
							//if(dealmaintype == '3' && chk == true)
							if(is_groupbuy(dealmaintype) == 'true' && chk == true)
							{
               					return true;
            					}else{
               					return false;
            					}
						},
				//numericForGroupBuy : true,
				//numGreatZeroForGroupBuy_5 : true,
				maxlength:8,
// 				check_maxmin_for_groupbuy_5 : function(){
//             					var dealmaintype = document.getElementById("dealmaintype").value;
//             					//if(dealmaintype == '3')
// 							if(is_groupbuy(dealmaintype) == 'true')
// 							{
//                					return true;
//             					}else{
//                					return false;
//             					}
// 						}
			},*/
			seller_account_no:{
				required: true,
				//numeric : true
			}
		},
		messages: {
/*                        dealmaintype:{
                                required: "Please select main deal type"
                        },*/
// 			subcategory:{
// 				required: "Please select sub category"
// 			},
// 			subsubcategory:{
// 				required: "Please select sub sub category"
// 			},
// 			subsubsubcategory:{
// 				required: "Please select sub sub sub category"
// 			},
/*
			dealcity:{
				required: "Please select Deal city"
			},
			dealstate:{
				required: "Please select Deal city"
			},
*/
			title1:{
				//required: "Please enter title",
            			//maxlength:$.format("Enter maximum {0} characters")
				valid_editor: "Please enter title"
			},
			subtitle:{
				//required: "Please enter sub title",
            			//maxlength:$.format("Enter maximum {0} characters")
				valid_editor: "Please enter sub title"
			},
			deal_from_seller_name:{
				//required: "Please select seller name"
			},
			deal_from_seller_name_other:{
				required: "Please enter seller name",
            			maxlength:$.format("Enter maximum {0} characters")
			},
			zipcode:{
				required: "Please enter seller post code",
				postcodes: "Please enter valid post code/zip code",
				minlength: $.format("Enter minimum {0} characters"),
				maxlength:$.format("Enter maximum {0} characters")
			},
			description:{
				//required: "Please enter description.",
				valid_editor: "Please enter key features."
			},
               highlight:{
				//required: "Please enter highlight.",
				valid_editor: "Please enter highlight."
			},
               fineprint:{
				//required: "Please enter fineprint.",
				valid_editor: "Please enter fineprint."
			},
			qr_code_link:{
			         url:"Please provide valid url format"
			 
			},
			qr_code_image:{
			         accept: "Please provide .jpg,.gif,.png file format"
			},
////////////START Js Validation for Delivery Options//////////////
/*		delivery_charges_pound_1:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },*/
/*		delivery_charges_euro_1:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },*/
/*		delivery_charges_dollar_1:
                            {
						required: "Please enter amount.",
						numdotOnly: "Please enter numbers only.",
						maxlength: jQuery.format("Enter at most {0} numbers")
                            },*/
////////////////
/*		delivery_charges_pound_2:
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
					   },*/
/////////////END Js Validation for Delivery Options///////////////
			seller_support_email:{
				email: "Please enter valid seller support email"
			},
			trackURL:{
// 				required: "Please enter track URL",
				//url: "Please enter valid URL",
				maxlength:$.format("Enter maximum {0} characters")
			},
			delivered_tracking_url_code:{
// 				required: "Please enter delivered tracking URL code",
				//url: "Please enter valid URL",
				maxlength:$.format("Enter maximum {0} characters")
			},
			otherproductURL:{
// 				required: "Please enter other product/services URL",
				url: "Please enter valid URL",
				maxlength:$.format("Enter maximum {0} characters")
			},
			retailerwebURL:{
// 				required: "Please enter other retailer website URL",
				url: "Please enter valid URL",
				maxlength:$.format("Enter maximum {0} characters")
			},
			retailer_website_affiliate_link:{
// 				required: "Please enter retailer website affiliate link",
				maxlength:$.format("Enter maximum {0} characters")
			},
			price:{
				required: "Please enter usortd buy price",
				maxlength:$.format("Enter maximum {0} digits")
			},
			originalprice:{
				required:"Please enter original price",
				maxlength:$.format("Enter maximum {0} digits")
			},
			min_buyer:{
				required:"Please enter minimum buyers ",
				number: "Please enter numbers only.",
				maxlength:$.format("Enter maximum {0} digits")
			},
			max_buyer:{
				required:"Please enter maximum buyers ",
				number: "Please enter numbers only.",
				maxlength:$.format("Enter maximum {0} digits")
			},
/*			max_buyer_1:{
				required:"Please enter maximum buyers ",
				maxlength:$.format("Enter maximum {0} digits")
			},*/
/*			max_buyer_2:{
				required:"Please enter maximum buyers ",
				maxlength:$.format("Enter maximum {0} digits")
			},*/
/*			max_buyer_3:{
				required:"Please enter maximum buyers ",
				maxlength:$.format("Enter maximum {0} digits")
			},*/
			max_buyer_4:{
				required:"Please enter maximum buyers ",
				maxlength:$.format("Enter maximum {0} digits")
			},
			seller_account_no:{
				required: "Please enter seller account number",
				//numeric : "Please enter valid account number (only numeric)"
			}
		}
	});


});

function is_groupbuy(dealType)
{
	var groupbuyids = $('#price_option').val().split(",");
	var flag = 'false';
	for(x=0; x<groupbuyids.length; x++)
	{
		if(dealType == groupbuyids[x])
			flag = 'true';
	}
	return flag;
}

function setCurrency(objVal)
{
	var currType = "&#163;"; //def pound
	if(objVal == "dollar")
	{
		currType = "$"
	}else
	{
		if(objVal == "euro")
		{
			currType = "&#8364;" // def euro
		}
	}

	$('#span_dlcurr_ubuyprice').html(currType);
	$('#span_dlcurr_actprice').html(currType);
	$('#span_dlcurr_ubuyprice1').html(currType);
	$('#span_dlcurr_actprice1').html(currType);

	$('#span_dlcurr_delcharges').html(currType);

	getSellerPredifinedData($("#deal_from_seller_name").val());
}



////////////START js code for Delivery Options//////////////


$(document).ready(function()
{
});

/////////////END js code for Delivery Options///////////////