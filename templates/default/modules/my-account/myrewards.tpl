{include file=$header_start}
{literal}
<script type="text/javascript">
    jQuery(document).ready(function()
    {
		var moduleid = '{/literal}{$smarty.get.id2}{literal}';
	    jQuery('#show_thread').html("<img src='"+SITEROOT+"/templates/default/images/site/coming_soon/loadingAnimation.gif' alt='loading' />");
		viewReview();
    });
	
	
	
	function viewReview(obj)
	{

		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'review'},function(data)
		{

			jQuery("#show_thread").html(data);
		});
//     		jQuery(obj).css('color','#FFFFFF');
// 		jQuery('#reviewlink').css('color','#000000');
	}  
	
	
</script>
<script>


function dele(val)
	{       var f_id=val;
		//alert(f_id);
		document.forms["profile"].fid.value = f_id;
		document.forms["profile"].act.value = "delete";

		if(confirm("Really you like to delete this contact ?"))
		{
			document.forms["profile"].submit();
		}
		//return false;
	}
	function appr(val1)
	{  
		
		 var f_id1=val1;
		document.forms["profile"].fid1.value = f_id1;
		document.forms["profile"].act.value = "update";
		
		if(confirm("Would you like to approve this request?"))
		{
			document.forms["profile"].submit();
		}
	}
	function func4(val2)
	{ //alert("ghdf");
		//alert(val2);
		var ascq=val2;
		window.location = SITEROOT +"/modules/friends/friend-request.php?sid="+ascq;
	}
</script>
{/literal}
<!-- main continer of the page -->
<div id="wrapper">
  <!-- Header starts -->
  {include file=$profile_header2}
  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">
      <tr>
        <!-- Profile Left Section Start -->
        {include file=$profile_left}
        <form name="profile" id="profile" method="POST">
          <input type="hidden" name="act" value="" id="act">
          <input type="hidden" name="fid" id="fid" value="">
          <input type="hidden" name="fid1" value="">
        </form>
        <!-- Profile Left Section End -->
        <!-- Profile Middle Section Start -->
        <td width="560" valign="top"><!-- Profile Comment Section Start -->
          <div class="maincont-inner-mid fl">
            <!-- <div id="show_thread" class="profile-middel"> </div>-->
            <div class="edit-profile-form">

              <h1 class=" form-title" class="fl">My Reward Points</h1> 

              <table width="500" border="0" cellspacing="0" cellpadding="0" class="point-tbl">
                <tr>
                  <th scope="col" width="30" height="35">Rewards through buying deals </th>
                  <th scope="col" width="30" height="35">Rewards through writing reviews</th>
                  <th scope="col" width="30" height="35">Rewards lost on transactions</th>
                  <th scope="col" width="30" height="35">Total Rewards </th>
                </tr>
                <tr>
                  <td align="center" width="30" height="30">{$rewardpointsbuydeal}</td>
                  <td align="center" width="30" height="30">{$rewardpointsforreview}</td>
                  <td align="center" width="30" height="30">{$lostrewards}</td>
                  <td align="center" width="30" height="30">{$rewardpointstotal}</td>
                </tr>
                <tr>
                  <td align="center" width="30" height="30">{$rewardpointsbuydeal}</td>
                  <td align="center" width="30" height="30">{$rewardpointsforreview}</td>
                  <td align="center" width="30" height="30">{$lostrewards}</td>
                  <td align="center" width="30" height="30">{$rewardpointstotal}</td>
                </tr>
              </table>
            </div>
            <div class="clr" style="height:30px"></div>
          </div>
          <!-- Profile Comment Section End --></td>
        <!-- Profile Middle Section End -->
        <!-- Profile Right Section Start -->
        {include file=$myprofile_right_panel}
        <!-- Profile Right Section End -->
      </tr>
    </table>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
{include file=$footer}