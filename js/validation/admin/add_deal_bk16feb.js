$(document).ready(function(){
jQuery.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	},"Only A-Z, a-z & _ is allowed without space");
	
	$.validator.addMethod("noSpecialChars", function(value, element) {
	      return /^[a-zA-Z\_]+$/i.test(value);
	},"Only A-Z, a-z & _ is allowed without space");
	
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

$.validator.addMethod("check_price", function( value, element, param ) {
		var val_a = $("#price").val();
		//return this.optional(element) || (value >= val_a);
		var resVal = eval(value - val_a);
		return (resVal >= 0);
	},"Please enter Original price must be greater than Usortd price.");

$.validator.addMethod("check_buyers_qty", function( value, element, param ) {
		var val_a = $("#min_buyer").val();
		//return this.optional(element) || (value >= val_a);
		var resVal = eval(value - val_a);
		return (resVal >= 0);
	},"Please enter Maximum Number Of Buyers must be greater than Minimum Buyers Required.");

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

	$("#frm").validate({
		errorElement:'div',
		rules: {
		      deal_currency:{
			     	required: true
				
		      },
			title1:{
			        required: true,
				noSpace:true,
			        noSpecialChars:true,
				minlength:2,
				maxlength:50
		      },
			subtitle:{
			      required: true,
				minlength:2,
				maxlength:30
		      },
			slogan:{
			      required: true,
			      valid_editor:true
		      },
			deal_from_seller_name:{
				required: true
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
			price:{
				required:true,
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
			required: true,
 				numeric : true,
				numGreatZeroNotForGroupType : true,
				maxlength:3
			},
			max_buyer:{
				required: true,
				numeric : true,
				numGreatZeroNotForGroupType : true,
				check_buyers_qty:true,
				maxlength:3
			}
			
		},
		messages: {
		      deal_currency:{
			      required: "Please select deal currency"
				
		      },
			 title1:{
			      required: "Please enter title",
				minlength: $.format("Enter minimum {0} characters"),
				maxlength:$.format("Enter maximum {0} characters")
		      },
			subtitle:{
			      required: "Please enter subtitle",
				minlength: $.format("Enter minimum {0} characters"),
				maxlength:$.format("Enter maximum {0} characters")
		      },
			slogan:{
			      required: "Please enter slogan"
		      },
		      deal_from_seller_name:{
			      required: "Please select seller name"
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
			}
			
		}
	});
	
	
});