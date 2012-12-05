{include file=$header_start}
{strip}

<!-- <script src="http://connect.facebook.net/en_US/all.js"></script> -->
<link rel="stylesheet" href="{$siteroot}/lightbox1/css/screen.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{$siteroot}/lightbox1/css/lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="{$sitejs}/jquery.timeago.js"></script>
<script type="text/javascript" src="{$siteroot}/php_ajax_image_upload/scripts/ajaxupload.js"></script>



{/strip}
{literal}
<script type="text/javascript">

    jQuery(document).ready(function()
    {

// 		 jQuery("#txt_thinking1").keyup(function()
//         {
// 		//alert("in");
// //                 var box=$(this).val();
// // 		alert(e.keyCode);
// //                if(e && e.keyCode == 13)
// // 		{
// // 		alert("ok");
// // 		}
//         });
		var moduleid = '{/literal}{$smarty.get.id2}{literal}';
	    jQuery('#show_thread').html("<img src='"+SITEROOT+"/templates/default/images/site/coming_soon/loadingAnimation.gif' alt='loading' />");
		var txt_friend=$('#txt_friend').val();
		if(txt_friend=='friend')
		{
			viewFriends();
		}
		else
		{
	
// 			viewDealsAsUsual();
viewRightNowDeal();
		}

//        var facebook={/literal}'{$facebookshare}'{literal};
//        if(facebook==1){
//             FB.init({
//                     appId  : '468889599797776',
//                     status : true, // check login status
//                     cookie : true, // enable cookies to allow the server to access the session
//                     xfbml  : true,
//                     oauth  : true // parse XFBML
//                   });
// 
//                  var obj = {
//                           method: 'feed',
//                           link: 'http://offersnpals.com/',
//                           picture: 'http://www.offersnpals.com/templates/default/images/logopdf.jpg',
//                           name: 'Offersnpals',
//                           caption: "Made a deal",
//                           description: "I just bought an offer at offersnpals"  
//                     };
// 
//                    function callback(response) {
//                         if(response){
//                          window.close();
//                         }
//                     }
// 
//                  FB.ui(obj, callback);
//         }
// 

    });



	function viewReview(obj)
	{

		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'merchant_review'},function(data){
			jQuery(".profile-middel").html(data);
			$('#div_share').hide();
		});
	}  
	function add_photo()
	{
	// document.getElementById("div_share_photo").style.display='block';
		$('#div_share_photo').show();
	}
	function add_text()
	{
		$('#div_share_photo').hide();
	}	
</script>
<script type="text/javascript">
    function setImage(file) {
        if(document.all)
            document.getElementById('prevImage').src = file.value;
        else
            document.getElementById('prevImage').src = file.files.item(0).getAsDataURL();
        if(document.getElementById('prevImage').src.length > 0) 
            document.getElementById('prevImage').style.display = 'block';
    }
</script>


<script>

</script>



<!--<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"> </script>-->
{/literal}
<!--<body class="inner_body">-->
<!-- main continer of the page -->
<!--<div id="wrapper">-->
<!-- header container starts here-->
    {include file=$profile_header2}
  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">
      <tr>
        <!-- Profile Left Section Start -->
    
  {include file=$profile_left}
        <!-- Profile Left Section End -->
        <!-- Profile Middle Section Start -->
        <td width="580" valign="top"><!-- Profile Comment Section Start -->
          <div class="maincont-inner-mid fl">
            <div class="result">
             
			 <div id="show_thread" class="profile-middel"> </div>
              
            </div>
            <div class="clr" style="height:20px"></div>
          </div>
          <!-- Profile Comment Section End --></td>
        <!-- Profile Middle Section End -->
        <!-- Profile Right Section Start -->
          {include file=$profile_right}
        <!-- Profile Right Section End -->
      </tr>
    </table>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
  {include file=$footer}