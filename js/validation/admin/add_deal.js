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
	},"Please enter Original price must be greater than buy price.");

$.validator.addMethod("check_maxmin", function( value, element, param ) {
		var val_a = $("#min_buyer").val();
		//return this.optional(element) || (value >= val_a);
		var resVal = eval(value - val_a);
		return (resVal >= 0);
	},"Please enter Maximum Number Of Buyers must be greater than Minimum Buyers Required.");

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



	$.validator.addMethod("ACnumdotOnly", function(value, element){
			var temp;
			temp = true;
			str = /[^0-9]/;
			temp = !str.test(value);
			return temp;
	}, "Only numbers is allowed.");




	$.validator.addMethod("numGreatZero", function(value, element)
	{
			var temp;
			temp = true;
			temp = !(value<=0);
			return temp;
         }, "Please enter value must be greater than zero(0)");

	
	$.validator.addMethod("postcodes", function(value, element){
                var temp;
                temp = true;
                str = /[^a-zA-Z0-9 ]/;
                temp = !str.test(value);
                return temp;
         }, "Only 0 to 9, a to z, A to Z and space is allowed.");



	$("#frm").validate({
	
		errorElement:'div',
		rules: {
			dealcountry: {
				required: true
			},
			title1:{
				required: true
			},
			subtitle:{
				valid_editor: true
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
				valid_editor: true
			},
			whybuy:{
				valid_editor: true
			},
			seller_account_no:{
				ACnumdotOnly : true
			},
			highlight:{
				valid_editor: true
			},
			fineprint:{
				//required: true,
				valid_editor: true
			},
/////////////END Js Validation for Delivery Options///////////////
			seller_support_email:{
				email: true
			},
			trackURL:{
// 				required: true,
				url:true,
				maxlength:255
			},
			delivered_tracking_url_code:{
// 				required: true,
				url:true,
				maxlength:255
			},
			otherproductURL:{
// 				required: true,
				url:true,
				maxlength:100
			},
			price:{
				required: true,
				numdotOnly : true,
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
				number : true,
				maxlength:10
			},
			max_buyer:{
				required: true,
				number : true,
				maxlength:10,
				check_maxmin:true
			},
			seller_account_no:{
				required: true,
				number : true,
				numGreatZero : true
			}
		},
		messages: {
			dealcountry:{
				required: "Please select Deal city"
			},
			title1:{
				required: "Please enter title"
			},
			subtitle:{
				valid_editor: "Please enter sub title"
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
				valid_editor: "Please enter description."
			},
			whybuy:{
				//required: "Please enter description.",
				valid_editor: "Please enter why buy."
			},

               highlight:{
				//required: "Please enter highlight.",
				valid_editor: "Please enter highlight."
			},
               fineprint:{
				//required: "Please enter fineprint.",
				valid_editor: "Please enter fineprint."
			},
/////////////END Js Validation for Delivery Options///////////////
			seller_support_email:{
				email: "Please enter valid seller support email"
			},
			trackURL:{
// 				required: "Please enter track URL",
				url: "Please enter valid URL",
				maxlength:$.format("Enter maximum {0} characters")
			},
			delivered_tracking_url_code:{
// 				required: "Please enter delivered tracking URL code",
				url: "Please enter valid URL",
				maxlength:$.format("Enter maximum {0} characters")
			},
			otherproductURL:{
// 				required: "Please enter other product/services URL",
				url: "Please enter valid URL",
				maxlength:$.format("Enter maximum {0} characters")
			},
			price:{
				required: "Please enter buy price",
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
			seller_account_no:{
				required: "Please enter seller account number"
				//numeric : "Please enter valid account number (only numeric)"
			}
		}
	});




    $("#frm").submit(function()
	{

            var StartDate1 = new Date($('#dob1_Year_ID').val(), $('#dob1_Month_ID').val(), $('#dob1_Day_ID').val(), $('#start_hour').val(), $('#start_min').val());
                var EndDate1 = new Date($('#dob2_Year_ID').val(), $('#dob2_Month_ID').val(), $('#dob2_Day_ID').val(), $('#end_hour').val(), $('#end_min').val());

                 var dealValidDate = new Date($('#validfrom_Year_ID').val(), $('#validfrom_Month_ID').val(), $('#validfrom_Day_ID').val());
                 var dealValidToDate = new Date($('#validto_Year_ID').val(), $('#validto_Month_ID').val(), $('#validto_Day_ID').val());


                 var redeemFromDate = new Date($('#redeemfrom_Year_ID').val(), $('#redeemfrom_Month_ID').val(), $('#redeemfrom_Day_ID').val());
                 var redeemToDate = new Date($('#redeemto_Year_ID').val(), $('#redeemto_Month_ID').val(), $('#redeemto_Day_ID').val());

			 if(StartDate1 > EndDate1)
			 {	
				     var error = 'yes';
					 $('#tr1').show();
                     $('#error_EndDate1').show();
                     $('#error_EndDate1').html("End Date/Time should be greater than or equal to Start Date/Time");
			 } else{
					 $('#tr1').hide();
                     $('#error_EndDate1').hide();
                     $('#error_EndDate1').html('');

			}




                if (dealValidDate > dealValidToDate) {
                    //alert('Please Enter the correctDate, End Date should be greater than or equal to Start Date');
                    //docFrm.dob2_Year_ID.focus();
                    //return false;
                     var error = 'yes';
					 $('#tr4').show();
                     $('#error_toEndDate').show();
                     $('#error_toEndDate').html("Valid To Date should be greater than or equal to Valid From Date");

                }else
                {
					 $('#tr4').hide();	
                     $('#error_toEndDate').hide();
                     $('#error_toEndDate').html('');
                }




                if (redeemFromDate > redeemToDate) { 
                    //alert('Please Enter the correctDate, End Date should be greater than or equal to Start Date');
                    //docFrm.dob2_Year_ID.focus();
                    //return false;
                     var error = 'yes';
					 $('#tr3').show();
                     $('#error_RedeemFromDate1').show();
                     $('#error_RedeemFromDate1').html("Redeem To Date should be greater than or equal to Redeem From Date");

                }else
                {
					 $('#tr3').hide();
                     $('#error_RedeemFromDate1').hide();
                     $('#error_RedeemFromDate1').html('');
                }


			if(error=='yes')	
				return false;
			else
				return true;
    });















});


function fillCities(Obj,id1)
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
	url=url+"?stid="+val+"&id1="+id1;
	 document.getElementById('txt_id1').value=id1;
	xmlHttp.onreadystatechange=cities_value;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function cities_value(){
	if (xmlHttp.readyState==4){
		var val1= document.getElementById('txt_id1').value;
		var response=xmlHttp.responseText;
		document.getElementById('city_'+val1).innerHTML=response;
	}
}






function fillStates(Obj,id)
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
// alert(val);
// alert(id);
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url = SITEROOT+"/admin/globalsettings/deal/show_states.php";
	url=url+"?cnid="+val+"&id="+id;
	document.getElementById('txt_id').value=id;
	xmlHttp.onreadystatechange=states_value;
// alert(states_value);
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

}
function states_value(){

var val= document.getElementById('txt_id').value;

    if (xmlHttp.readyState==4){
      var response=xmlHttp.responseText;
      document.getElementById('state_'+val).innerHTML=response;

	}
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

	setTimeout(function() {
		stateObj = document.getElementById('dealstate');
		unselectAllState(stateObj);
	},500);
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