
$(document).ready(function(){

//         $.validator.addMethod("checkSeller", function(sellertype, element) {
//             var dealId = $('#dealId').val();
//             if( !(dealId) && sellertype == '')
//                 return false;
//             else 
//               return true;
//         });

        /*$.validator.addMethod("checkImage", function(dealimage, element) {
            var dealId = $('#dealId').val();

            if(dealId =='' && dealimage == '')
                return false;
            else
              return true;
        });*/
        /*
          $.validator.addMethod("valid_editor", function(value, element){
               var oEditor = FCKeditorAPI.GetInstance(element.name);
               var fieldvalue = oEditor.GetXHTML(true);
               if(fieldvalue=="") {
                  return false;
               } else {
                  return true;
               }
         }, "Please enter editor decription");

        jQuery("#frmPage").validate({
                errorElement:'div',
                rules: {
                        title: {
                                required: true,
//             lettersonly:true,
            maxlength:50
                        },
                        description: {
                                valid_editor: true
                        }
                },

        */

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

	$.validator.addMethod("check_maxmin", function( value, element, param )
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
// 		if(dealmaintype == '3')
		if(is_groupbuy(dealmaintype) == 'true')
		{
			return true;
		}else{
			var val_a = $("#min_buyer").val();
			//return this.optional(element) || (value >= val_a);
			var resVal = eval(value - val_a);
			return (resVal >= 0);
		}
	},"Please enter Maximum Number of Buyers must be greater than Minimum Buyers Required.");
	
	$.validator.addMethod("check_minmax_for_groupbuy_2", function( value, element, param )
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
		var chk = document.getElementById("chk_2").checked;
// 		if(dealmaintype == '3' && chk == true)
		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
		{
			var val_a = $("#max_buyer_1").val();
			//return this.optional(element) || (value >= val_a);
			var resVal = eval(value - val_a);
			return (resVal > 0);
		}else{
			return true;
		}
	},"Please enter Minimum Number of Buyers must be less than Maximum Buyers Required of above range.");

	$.validator.addMethod("check_minmax_for_groupbuy_3", function( value, element, param )
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
		var chk = document.getElementById("chk_3").checked;
// 		if(dealmaintype == '3' && chk == true)
		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
		{
			var val_a = $("#max_buyer_2").val();
			//return this.optional(element) || (value >= val_a);
			var resVal = eval(value - val_a);
			return (resVal > 0);
		}else{
			return true;
		}
	},"Please enter Minimum Number of Buyers must be less than Maximum Buyers Required of above range.");

	$.validator.addMethod("check_minmax_for_groupbuy_4", function( value, element, param )
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

	$.validator.addMethod("check_minmax_for_groupbuy_5", function( value, element, param )
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
		var chk = document.getElementById("chk_5").checked;
// 		if(dealmaintype == '3' && chk == true)
		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
		{
			var val_a = $("#max_buyer_4").val();
			//return this.optional(element) || (value >= val_a);
			var resVal = eval(value - val_a);
			return (resVal > 0);
		}else{
			return true;
		}
	},"Please enter Minimum Number of Buyers must be less than Maximum Buyers Required of above range.");

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
	},"Please enter Maximum Number of Buyers must be greater than Minimum Buyers Required.");

	$.validator.addMethod("check_maxmin_for_groupbuy_2", function( value, element, param )
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
		var chk = document.getElementById("chk_2").checked;
// 		if(dealmaintype == '3' && chk == true)
		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
		{
			var val_a = $("#min_buyer_2").val();
			//return this.optional(element) || (value >= val_a);
			var resVal = eval(value - val_a);
			return (resVal >= 0);
		}else{
			return true;
		}
	},"Please enter Maximum Number of Buyers must be greater than Minimum Buyers Required.");

	$.validator.addMethod("check_maxmin_for_groupbuy_3", function( value, element, param )
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
		var chk = document.getElementById("chk_3").checked;
// 		if(dealmaintype == '3' && chk == true)
		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
		{
			var val_a = $("#min_buyer_3").val();
			//return this.optional(element) || (value >= val_a);
			var resVal = eval(value - val_a);
			return (resVal >= 0);
		}else{
			return true;
		}
	},"Please enter Maximum Number of Buyers must be greater than Minimum Buyers Required.");

	$.validator.addMethod("check_maxmin_for_groupbuy_4", function( value, element, param )
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
		var chk = document.getElementById("chk_4").checked;
// 		if(dealmaintype == '3' && chk == true)
		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
		{
			var val_a = $("#min_buyer_4").val();
			//return this.optional(element) || (value >= val_a);
			var resVal = eval(value - val_a);
			return (resVal >= 0);
		}else{
			return true;
		}
	},"Please enter Maximum Number of Buyers must be greater than Minimum Buyers Required.");

	$.validator.addMethod("check_maxmin_for_groupbuy_5", function( value, element, param )
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
		var chk = document.getElementById("chk_5").checked;
// 		if(dealmaintype == '3' && chk == true)
		if(is_groupbuy(dealmaintype) == 'true' && chk == true)
		{
			var val_a = $("#min_buyer_5").val();
			//return this.optional(element) || (value >= val_a);
			var resVal = eval(value - val_a);
			return (resVal >= 0);
		}else{
			return true;
		}
	},"Please enter Maximum Number of Buyers must be greater than Minimum Buyers Required.");

	$.validator.addMethod("check_with_original_price", function( value, element, param )
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
// 		if(dealmaintype == '3')
		if(is_groupbuy(dealmaintype) == 'true')
		{
			var val_a = $("#originalprice").val();
			//return this.optional(element) || (value >= val_a);
			var resVal = eval(val_a - value);
			return (resVal >= 0);
		}else{
			return true;
		}
	},"Value should be less than or equal to original price.");


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

	$.validator.addMethod("numdotOnlyNotForGroupType", function(value, element)
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
// 		if(dealmaintype != '3')
		if(is_groupbuy(dealmaintype) != 'true')
		{
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
		}else{
			return true;
		}
	}, "Only numbers and .(decimal) is allowed.");

$.validator.addMethod("numdotOnlyForGroupType", function(value, element)
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
// 		if(dealmaintype == '3')
		if(is_groupbuy(dealmaintype) == 'true')
		{
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
		}else{
			return true;
		}
	}, "Only numbers and .(decimal) is allowed.");

	$.validator.addMethod("numGreatZero", function(value, element)
	{
			var temp;
			temp = true;
			temp = !(value<=0);
			return temp;
         }, "Please enter value must be greater than zero(0)");

	$.validator.addMethod("numGreatZeroNotForGroupType", function(value, element)
	{
			var dealmaintype = document.getElementById("dealmaintype").value;
// 			if(dealmaintype != '3')
			if(is_groupbuy(dealmaintype) != 'true')
			{
				var temp;
				temp = true;
				temp = !(value<=0);
				return temp;
			}else{
				return true;
			}
         }, "Please enter value must be greater than zero(0)");


	$.validator.addMethod("numGreatZeroForGroupBuy_1", function(value, element)
	{
			var dealmaintype = document.getElementById("dealmaintype").value;
			var chk = document.getElementById("chk_1").checked;
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

	$.validator.addMethod("numGreatZeroForGroupBuy_2", function(value, element)
	{
			var dealmaintype = document.getElementById("dealmaintype").value;
			var chk = document.getElementById("chk_2").checked;
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

	$.validator.addMethod("numGreatZeroForGroupBuy_3", function(value, element)
	{
			var dealmaintype = document.getElementById("dealmaintype").value;
			var chk = document.getElementById("chk_3").checked;
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

	$.validator.addMethod("numGreatZeroForGroupBuy_4", function(value, element)
	{
			var dealmaintype = document.getElementById("dealmaintype").value;
			var chk = document.getElementById("chk_4").checked;
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

	$.validator.addMethod("numGreatZeroForGroupBuy_5", function(value, element)
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

	jQuery.validator.addMethod("numeric", function(value, element)
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
// 		if(dealmaintype == '3')
		if(is_groupbuy(dealmaintype) == 'true')
		{
			return true;
		}else{
			return this.optional(element) || /^[0-9]+$/i.test(value);
		}
	}, "please insert numbers only");

	jQuery.validator.addMethod("numericForGroupBuy", function(value, element)
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
// 		if(dealmaintype == '3')
		if(is_groupbuy(dealmaintype) == 'true')
		{
			return this.optional(element) || /^[0-9]+$/i.test(value);
		}else{
			return true;
		}
	}, "please insert numbers only");

// 	jQuery.validator.addMethod("url", function(value, element)
// 	{
// 		var urldata = value;
// 		if(urldata == '')
// 			return true;
//  		var urlregex = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\..)");
// 
// 		return urlregex.test(urldata);
// 	}, "please enter valide url");


	jQuery.validator.addMethod("decimalchk", function(value, element)
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
	}, "Please enter valid deal usortd price");
	
	$.validator.addMethod("postcodes", function(value, element){
                var temp;
                temp = true;
                str = /[^a-zA-Z0-9 ]/;
                temp = !str.test(value);
                return temp;
         }, "Only 0 to 9, a to z, A to Z and space is allowed.");

	jQuery.validator.addMethod("decimalchkforGroupBuy", function(value, element)
	{
		var dealmaintype = document.getElementById("dealmaintype").value;
// 		if(dealmaintype == '3')
		if(is_groupbuy(dealmaintype) == 'true')
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
	}, "Please enter valid deal usortd price");


	$("#frm").validate({
	
		errorElement:'div',
		rules: {
			dealmaintype:{
				required: true
			},
			maincategory:{
				required: true
			},
			subcategory: {
				required: true
			},
			subsubcategory: {
				required: true
			},
			subsubsubcategory: {
				required: true
			},
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
			dealcountry: {
				required: true
			},
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
								return ;
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
			qr_code_image:{
// 				required: true,
				//maxlength:1000
			},
			sub_delivery_cost:{
				required: true,
				numdotOnly : true,
				maxlength:6
			},
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
			videolink:{
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
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							//if(dealmaintype == '3')
							if(is_groupbuy(dealmaintype) == 'true')
							{
               					return false;
            					}else{
               					return true;
            					}
						},
				numdotOnlyNotForGroupType : true,
				numGreatZeroNotForGroupType : true,
				maxlength:7
			},
			originalprice:{
				required: true,
				numdotOnly : true,
				check_price:true,
				numGreatZero : true,
				maxlength:7
			},
			min_buyer:{
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
            					//if(dealmaintype == '3')
							if(is_groupbuy(dealmaintype) == 'true')
							{
               					return false;
            					}else{
               					return true;
            					}
						},
				numeric : true,
				numGreatZeroNotForGroupType : true,
				maxlength:3
			},
			max_buyer:{
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
            					//if(dealmaintype == '3')
							if(is_groupbuy(dealmaintype) == 'true')
							{
               					return false;
            					}else{
               					return true;
            					}
						},
				numeric : true,
				numGreatZeroNotForGroupType : true,
				maxlength:3,
				check_maxmin : true
			},
			min_buyer_1:{
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
				numericForGroupBuy : true,
				numGreatZeroForGroupBuy_1 : true,
				maxlength:8
			},
			min_buyer_2:{
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
				numericForGroupBuy : true,
				numGreatZeroForGroupBuy_2 : true,
				maxlength:8,
				check_minmax_for_groupbuy_2 : true
			},
			min_buyer_3:{
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
				numericForGroupBuy : true,
				numGreatZeroForGroupBuy_3 : true,
				maxlength:8,
				check_minmax_for_groupbuy_3 : true
			},
			min_buyer_4:{
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
				numericForGroupBuy : true,
				numGreatZeroForGroupBuy_4 : true,
				maxlength:8,
				check_minmax_for_groupbuy_4 : true
			},
			min_buyer_5:{
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
				numericForGroupBuy : true,
				numGreatZeroForGroupBuy_5 : true,
				maxlength:8,
				check_minmax_for_groupbuy_5 : true
			},
			max_buyer_1:{
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
				numericForGroupBuy : true,
				numGreatZeroForGroupBuy_1 : true,
				maxlength:8,
				check_maxmin_for_groupbuy_1 : true
			},
			max_buyer_2:{
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
				numericForGroupBuy : true,
				numGreatZeroForGroupBuy_2 : true,
				maxlength:8,
				check_maxmin_for_groupbuy_2 : function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							//if(dealmaintype == '3')
							if(is_groupbuy(dealmaintype) == 'true')
							{
               					return true;
            					}else{
               					return false;
            					}
						}
			},
			max_buyer_3:{
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
				numericForGroupBuy : true,
				numGreatZeroForGroupBuy_3 : true,
				maxlength:8,
				check_maxmin_for_groupbuy_3 : function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							//if(dealmaintype == '3')
							if(is_groupbuy(dealmaintype) == 'true')
							{
               					return true;
            					}else{
               					return false;
            					}
						}
			},
			max_buyer_4:{
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
				numericForGroupBuy : true,
				numGreatZeroForGroupBuy_4 : true,
				maxlength:8,
				check_maxmin_for_groupbuy_4 : function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							//if(dealmaintype == '3')
							if(is_groupbuy(dealmaintype) == 'true')
							{
               					return true;
            					}else{
               					return false;
            					}
						}
			},
			max_buyer_5:{
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
				numericForGroupBuy : true,
				numGreatZeroForGroupBuy_5 : true,
				maxlength:8,
				check_maxmin_for_groupbuy_5 : function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
            					//if(dealmaintype == '3')
							if(is_groupbuy(dealmaintype) == 'true')
							{
               					return true;
            					}else{
               					return false;
            					}
						}
			},
			groupbuy_price_1:{
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							var chk = document.getElementById("chk_1").checked;
							//if(dealmaintype == '3' && chk == true)
							if(is_groupbuy(dealmaintype) == 'true' && chk == true)
							{
               					return true;
            					}else{
               					return false;
            					}
						},
				numdotOnlyForGroupType : true,
				numGreatZeroForGroupBuy_1 : true,
				maxlength:7,
				check_with_original_price : true
			},
			groupbuy_price_2:{
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							var chk = document.getElementById("chk_2").checked;
							//if(dealmaintype == '3' && chk == true)
							if(is_groupbuy(dealmaintype) == 'true' && chk == true)
							{
               					return true;
            					}else{
               					return false;
            					}
						},
				numdotOnlyForGroupType : true,
				numGreatZeroForGroupBuy_2 : true,
				maxlength:7,
				check_with_original_price : true
			},
			groupbuy_price_3:{
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							var chk = document.getElementById("chk_3").checked;
							//if(dealmaintype == '3' && chk == true)
							if(is_groupbuy(dealmaintype) == 'true' && chk == true)
							{
               					return true;
            					}else{
               					return false;
            					}
						},
				numdotOnlyForGroupType : true,
				numGreatZeroForGroupBuy_3 : true,
				maxlength:7,
				check_with_original_price : true
			},
			groupbuy_price_4:{
				required: function(){
            					var dealmaintype = document.getElementById("dealmaintype").value;
							var chk = document.getElementById("chk_4").checked;
							//if(dealmaintype == '3' && chk == true)
							if(is_groupbuy(dealmaintype) == 'true' && chk == true)
							{
               					return true;
            					}else{
               					return false;
            					}
						},
				numdotOnlyForGroupType : true,
				numGreatZeroForGroupBuy_4 : true,
				maxlength:7,
				check_with_original_price : true
			},
			groupbuy_price_5:{
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
				numdotOnlyForGroupType : true,
				numGreatZeroForGroupBuy_5 : true,
				maxlength:7,
				check_with_original_price : true
			},
			seller_account_no:{
				required: true,
				numeric : true
			}
		},
		messages: {
                        dealmaintype:{
                                required: "Please select main deal type"
                        },
			maincategory:{
				required: "Please select deal category"
			},
			subcategory:{
				required: "Please select sub category"
			},
			subsubcategory:{
				required: "Please select sub sub category"
			},
			subsubsubcategory:{
				required: "Please select sub sub sub category"
			},
			dealcity:{
				required: "Please select Deal city"
			},
			dealstate:{
				required: "Please select Deal city"
			},
			dealcountry:{
				required: "Please select Deal city"
			},
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
			qr_code_image:{
// 				required: "Please enter qr code",
				//maxlength:$.format("Enter maximum {0} digits")
			},
			sub_delivery_cost:{
				required: "Please enter delivery charges",
				numdotOnly : "Please enter valid delivery charges",
				maxlength:$.format("Enter maximum {0} digits")
			},
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
			videolink:{
// 				required: "Please enter video URL",
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
			max_buyer_1:{
				required:"Please enter maximum buyers ",
				maxlength:$.format("Enter maximum {0} digits")
			},
			max_buyer_2:{
				required:"Please enter maximum buyers ",
				maxlength:$.format("Enter maximum {0} digits")
			},
			max_buyer_3:{
				required:"Please enter maximum buyers ",
				maxlength:$.format("Enter maximum {0} digits")
			},
			max_buyer_4:{
				required:"Please enter maximum buyers ",
				maxlength:$.format("Enter maximum {0} digits")
			},
			groupbuy_price_1:{
				required: "Please enter usortd buy price",
				maxlength:$.format("Enter maximum {0} digits")
			},
			groupbuy_price_2:{
				required: "Please enter usortd buy price",
				maxlength:$.format("Enter maximum {0} digits")
			},
			groupbuy_price_3:{
				required: "Please enter usortd buy price",
				maxlength:$.format("Enter maximum {0} digits")
			},
			groupbuy_price_4:{
				required: "Please enter usortd buy price",
				maxlength:$.format("Enter maximum {0} digits")
			},
			groupbuy_price_5:{
				required: "Please enter usortd buy price",
				maxlength:$.format("Enter maximum {0} digits")
			},
			seller_account_no:{
				required: "Please enter seller account number",
				numeric : "Please enter valid account number (only numeric)"
			}
		}
	});


     $("#frm").submit(function()
	{

            /*d1=$('#dob1').val();
            s1=$('#start_hour').val();
            m1=$('#start_min').val();
    
            d2=$('#dob2').val();
            s2=$('#end_hour').val();
            m2=$('#end_min').val();
        
            var syear = d1.substring(0,4);
            var smonth = d1.substring(5,7);
            var sday = d1.substring(8,10);

            var eyear = d2.substring(0,4);
            var emonth = d2.substring(5,7);
            var eday = d2.substring(8,10);
            
            var sd = new Date(syear,(smonth-1),sday);
            var ed = new Date(eyear,(emonth-1),eday);
            var cd = new Date();

            if(sd.getTime() > ed.getTime())
            {
                $('#err_date').show();
                $('#err_date').addClass('error');
                $('#err_date').html("Start date should be less than end date.");
                return false;
            }
            else if(cd.getTime() > ed.getTime())
            {
                $('#err_date').show();
                $('#err_date').addClass('error');
                $('#err_date').html("End date should be greater than current date.");
                return false;
            }
            else
            {
                $('#err_date').hide();
                $('#err_date').removeClass('error');
                $('#err_date').html("");
                return true;
            }
//             if(d1 == d2)
//             {
//                 if(s1 > s2 )
//                 {
//                     $('#err_date').show();
//                     $('#err_date').addClass('error');
//                     $('#err_date').html("Start date should be less than end date.");
//                     return false;
//                 }
//                 else if(m1 > m2 && s1== s2 )
//                 {
//                     $('#err_date').show();
//                     $('#err_date').addClass('error');
//                     $('#err_date').html("Start date should be less than end date.");
//                     return false;
//                 }
//                 else if(m1 == m2 && s1== s2 )
//                 {
//                     $('#err_date').show();
//                     $('#err_date').addClass('error');
//                     $('#err_date').html("Start date and end date should not be same.");
//                     return false;
//                 }
//             }*/

		var docFrm=document.frm;
                var dealStartDate = new Date($('#dob1_Year_ID').val(), $('#dob1_Month_ID').val(), $('#dob1_Day_ID').val(), $('#start_hour').val(), $('#start_min').val());
                var dealEndDate = new Date($('#dob2_Year_ID').val(), $('#dob2_Month_ID').val(), $('#dob2_Day_ID').val(), $('#end_hour').val(), $('#end_min').val());
                
                 var dealValidDate = new Date($('#validfrom_Year_ID').val(), $('#validfrom_Month_ID').val(), $('#validfrom_Day_ID').val());
                 var dealValidToDate = new Date($('#validto_Year_ID').val(), $('#validto_Month_ID').val(), $('#validto_Day_ID').val());

                var error = 'no';

		$('#error_dealStartDate').hide();
                $('#error_dealEndDate').hide();
                $('#error_usortprice').hide();
                $('#error_originalprice').hide();
                 $('#error_toEndDate').hide();

		$('#error_dealStartDate').html();
                $('#error_dealEndDate').html('');
                $('#error_usortprice').html();
                $('#error_originalprice').html();
                $('#error_toEndDate').html('');
                
                if (dealStartDate > dealEndDate) {
                    //alert('Please Enter the correctDate, End Date should be greater than or equal to Start Date');
                    //docFrm.dob2_Year_ID.focus();
                    //return false;
                     var error = 'yes';
                     $('#error_dealEndDate').show();
                     $('#error_dealEndDate').html("End Date/Time should be greater than or equal to Start Date/Time");

                }else
                {
                     $('#error_dealEndDate').hide();
                     $('#error_dealEndDate').html('');
                }
                
                if (dealValidDate > dealValidToDate) {
                    //alert('Please Enter the correctDate, End Date should be greater than or equal to Start Date');
                    //docFrm.dob2_Year_ID.focus();
                    //return false;
                     var error = 'yes';
                     $('#error_toEndDate').show();
                     $('#error_toEndDate').html("Valid To Date should be greater than or equal to Valid From Date");

                }else
                {
                     $('#error_toEndDate').hide();
                     $('#error_toEndDate').html('');
                }

		//check if .(decimal) point is not more than one time in value and . not at first position
                //Product Discount price
//                 var prodDiscprice = $('#price').val();
//                 var totDotInprodDiscprice = 0;
//                 var noFirstDotInprodDiscprice = 'no';
//                 for(var i=0; i<prodDiscprice.length;i++)
//                 {
//                   if(prodDiscprice[0] == '.')
//                   {
//                      noFirstDotInprodDiscprice = 'yes';
//                   }
// 
//                   if(prodDiscprice[i] == '.')
//                   {
//                      totDotInprodDiscprice++;
//                   }
//                 }
// 
//                 if(totDotInprodDiscprice > 1 || noFirstDotInprodDiscprice == 'yes')
//                 {
//                      var error = 'yes';
//                      $('#error_usortprice').show();
//                      $('#error_usortprice').html("Please enter valid deal usortd price");
//                 }else
//                 {
//                      $('#error_usortprice').hide();
//                      $('#error_usortprice').html('');
//                 }


                //deal price
//                 var prodActprice = $('#originalprice').val();
//                 var totDotInprodActprice = 0;
//                 var noFirstDotInprodActprice = 'no';
//                 for(var i=0; i<prodActprice.length;i++)
//                 {
//                   if(prodActprice[0] == '.')
//                   {
//                      noFirstDotInprodActprice = 'yes';
//                   }
//                   if(prodActprice[i] == '.')
//                   {
//                      totDotInprodActprice++;
//                   }
//                 }
// 
//                 if(totDotInprodActprice > 1 || noFirstDotInprodActprice == 'yes')
//                 {
//                      var error = 'yes';
//                      $('#error_originalprice').show();
//                      $('#error_originalprice').html("Please enter valid deal original price");
//                 }else
//                 {
//                      $('#error_originalprice').hide();
//                      $('#error_originalprice').html('');
// 			}

               //Start Code
               //function code for only multi select city list box
               var isValid = true;
               var form = this;
               //isValid = isValid && validateMultipleSelect($('select[name^=cities]', form));
               isValid = isValid && (($('#dealcity').val())?true:false);
               if(!isValid)
               {
			var is_national = document.getElementById("is_national");
			if(is_national.checked == false)
			{
				var error = 'yes';
				$('#cityerror').show();
				$('#cityerror').html("Please select deal city (or cities).");
			}
               }else{
                  $('#cityerror').hide();
                  $('#cityerror').html('');
               }
               //End Code

			//Start Code
               //function code for only multi select state list box
               var isValid = true;
               var form = this;
               //isValid = isValid && validateMultipleSelect($('select[name^=cities]', form));
               isValid = isValid && (($('#dealstate').val())?true:false);
               if(!isValid)
               {
			var is_national = document.getElementById("is_national");
			if(is_national.checked == false)
			{
				var error = 'yes';
				$('#stateerror').show();
				$('#stateerror').html("Please select deal state (or states).");
			}
               }else{
                  $('#stateerror').hide();
                  $('#stateerror').html('');
               }
               //End Code

			//Start Code
               //function code for only multi select state list box
               var isValid = true;
               var form = this;
               //isValid = isValid && validateMultipleSelect($('select[name^=cities]', form));
               isValid = isValid && (($('#dealcountry').val())?true:false);
               if(!isValid)
               {
                  var error = 'yes';
                  $('#countryerror').show();
                  $('#countryerror').html("Please select deal country (or countries).");
               }else{
                  $('#countryerror').hide();
                  $('#countryerror').html('');
               }
               //End Code

		if(error == 'yes')
                {
                     return false;
                }

            	return true;
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

function showHidePrices(dealType)
{
	//if(dealType == 3)
	if(is_groupbuy(dealType) == 'true')
	{
		$('#usortdPrice').hide();
		$('#price').val('');
		$('#cusSaving').hide();
		$('#minBuy').hide();
		$('#maxBuy').hide();
		$('#groupBuyData').show();
	}else
	{
		$('#usortdPrice').show();
		$('#cusSaving').show();
		$('#minBuy').show();
		$('#maxBuy').show();
		$('#groupBuyData').hide();
	}
}

function fill5column(orgPrice)
{
	$('#org_price1').html(orgPrice);
	$('#org_price2').html(orgPrice);
	$('#org_price3').html(orgPrice);
	$('#org_price4').html(orgPrice);
	$('#org_price5').html(orgPrice);

	$('#org_price_1').val(orgPrice);
	$('#org_price_2').val(orgPrice);
	$('#org_price_3').val(orgPrice);
	$('#org_price_4').val(orgPrice);
	$('#org_price_5').val(orgPrice);
}

function fillMin(maxBuyerValue,minHtmlId,minHiddenId)
{
	//$('#'+minHtmlId).html(parseInt(maxBuyerValue)+1);
	$('#'+minHiddenId).val(parseInt(maxBuyerValue)+1);
}

//START Code FOR
//function for select and unselect values of list box.
function selectAllCountry(Obj)
{
	listbox_selectall('dealcountry', true); //select all the options
	fillStates(Obj);
}

function unselectAllCountry(Obj)
{
	listbox_selectall('dealcountry', false); //deselect all the options
	fillStates(Obj);
}

function selectAllState(Obj)
{
	listbox_selectall('dealstate', true); //select all the options
	fillCities(Obj);
}

function unselectAllState(Obj)
{
	listbox_selectall('dealstate', false); //deselect all the options
	fillCities(Obj);
}

function selectAllCity()
{
	listbox_selectall('dealcity', true); //select all the options
}

function unselectAllCity()
{
	listbox_selectall('dealcity', false); //deselect all the options
}

function listbox_selectall(listID, isSelect) 
{
	var listbox = document.getElementById(listID);
	for(var count=0; count < listbox.options.length; count++)
	{
		listbox.options[count].selected = isSelect;
	}
}
//End Code FOR


function fillStates(Obj)
{
	var val = "";
	for(x=0;x<Obj.length;x++)
	{
		if(Obj[x].selected)
		{
			val = val+","+Obj[x].value;
		}
	}
	val = val.substr(1);

	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url = SITEROOT+"/admin/globalsettings/deal/show_states.php";
	url=url+"?cnid="+val;
	xmlHttp.onreadystatechange=states_value;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

}
function states_value(){
    if (xmlHttp.readyState==4){
      var response=xmlHttp.responseText;
		document.getElementById('dealstate').innerHTML=response;
	}
}

function fillCities(Obj)
{
	var val = "";
	for(x=0;x<Obj.length;x++)
	{
		if(Obj[x].selected)
		{
			val = val+","+Obj[x].value;
		}
	}
	val = val.substr(1);

	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url = SITEROOT+"/admin/globalsettings/deal/show_cities.php";
	url=url+"?stid="+val;
	xmlHttp.onreadystatechange=cities_value;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function cities_value(){
	if (xmlHttp.readyState==4){
		var response=xmlHttp.responseText;
		document.getElementById('dealcity').innerHTML=response;
	}
}


function showHideStateCity(obj)
{
	if(obj == false)
	{
		$("#div_stateDD_hideshow").show();
		$("#div_cityDD_hideshow").show();
	}else
	{
		$("#div_stateDD_hideshow").hide();
		$("#div_cityDD_hideshow").hide();
	}
}


function checkSellerDet(obj)
{
	if(obj.value == "")
	{
		$("#div_other_sellername").show();
		$("#seller_account_no").val($("#seller_account_no_other").val());
	}else if(obj.value == "other_seller")
	{
		$("#div_other_sellername").show();
		$("#seller_account_no").val($("#seller_account_no_other").val());
	}else if((obj.value != "other_seller") && (obj.value != ""))
	{
		$("#div_other_sellername").hide();
		$("#seller_account_no").val(obj.value);
	}
	
	getSellerPredifinedData(obj.value);
}

//get seller added predifined data using jquery ajax json method like like delivery_charges, refund_policy, seller_support_email, tracking_url_code, //delivered_tracking_url_code
function getSellerPredifinedData(userId)
{
	if(userId > 0 && userId != "other_seller")
	{
		var selCurrency = $('#deal_currency').val();
		$.post(SITEROOT+'/admin/globalsettings/deal/ajax_get_seller_data.php',{flag:'getSellData',userId:userId,selCurrency:selCurrency},function(data){
	
			$("#sub_delivery_cost").val(data.retSellerDeliveryCharges);
			$("#seller_support_email").val(data.retSellerSupportEmail);
			$("#trackURL").val(data.retSellerTrackingUrlCode);
			$("#delivered_tracking_url_code").val(data.retSellerDeliveredTrackingUrlCode);
			// Set the editor data.
			CKEDITOR.instances.refund_policy.setData(data.retSellerRefundPolicy);
		}
			,'json');
	}else
	{
			$("#sub_delivery_cost").val('');
			$("#seller_support_email").val('');
			$("#trackURL").val('');
			$("#delivered_tracking_url_code").val('');
			// Set the editor data.
			CKEDITOR.instances.refund_policy.setData('');
	}
	return false;
}