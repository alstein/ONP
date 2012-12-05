// jQuery(document).ready(function() 
// {
// 
//    var page_url_city = SITEROOT+ "/modules/my-account/ajaxget_category.php";	
// 	var page_url_state = SITEROOT+ "/modules/common/auto_state.php";	
//
//     if(document.getElementById('deal_type1').checked == true)
//     {
//         var dtype = "service";
//     }
//     else
//     {
//         var dtype = "product";
//     }
//    alert(document.getElementById('deal_type').value);
// 
// 
// 	$("#category").autocomplete(page_url_city+"?type="+dtype, 
// 
// 	{
// 	width: 250,
// 	minChars:1,
// 	selectFirst: false
// 	});	
// 
// 	$("#category").result(function (event, data, formatted){
// 	$("#categoryid").val(data[1]);
// 	});
// 
// 	
// 	end autocomplete
// });

// function getCat()
// {
// 
//     var page_url_city = SITEROOT+ "/modules/my-account/ajaxget_category.php";	
// 	//var page_url_state = SITEROOT+ "/modules/common/auto_state.php";	
//     
//     if(document.getElementById('deal_type1').checked == true)
//     {
//         var dtype = "service";
//     }
//     else
//     {
//         var dtype = "product";
//     }
//    // alert(document.getElementById('deal_type').value);
// 
// 
// 	$("#category").autocomplete(page_url_city+"?type="+dtype, 
// 
// 	{
// 	width: 250,
// 	minChars:1,
// 	selectFirst: false
// 	});	
// 
// 	$("#category").result(function (event, data, formatted){
// 	$("#categoryid").val(data[1]);
// 	});
// 
// 	
// 	//end autocomplete
// }

jQuery(function(){

    jQuery("#category").jSuggest({
            url: SITEROOT+ "/modules/my-account/ajaxget_category.php",
            type: "GET",
            data: "searchQuery",
            autoChange: true
    });
    $('#mg').fadeOut(5000);
});


jQuery(function(){

    jQuery("#subcategory").jSuggest({
            url: SITEROOT+ "/modules/my-account/ajaxget_category.php",
            type: "GET",
            data: "searchSubCat",
            autoChange: true
    });
    $('#mg').fadeOut(5000);
});