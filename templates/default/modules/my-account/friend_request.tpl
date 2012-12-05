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
           

              <h1 class=" form-title" style="margin-left:15px">Friend Requests</h1>
				<ul class="reset frd-request">
				 {section name=i  loop=$contacts }
                  <li>
                    <div class="gall-img fl"> <a href="javascript:void(0);" class="fl"> <img src="{if $contacts[i].facebook_userid neq  ''}http://graph.facebook.com/{$contacts[i].facebook_userid}/picture?type=large{else}{$siteroot}/uploads/user/{$contacts[i].photo}{/if}" width="121" height="120" alt="" title=""  /> </a>
					   
				
				 </div>
                 
                 <div class="fl gall-cont">
                <div> <a href="javascript:void(0);" class="gall-name" style="font-size:13px;margin-left:10px;font-weight:bold;">{$contacts[i].first_name} {$contacts[i].last_name}</a>
                
                <div class="clr"></div>
                </div>
                 
                 	 <div class="fl" style="margin:10px 0 0 10px">
						<input type="button" name="addasfriend" id="addasfriend" value="Approve"  onclick="appr({$contacts[i].id}); "   style="width:75px" class="submit-btn"/>
					</div>
					<div class="fl" style="margin:10px 0 0 10px">
						<input style="width:100px" class="submit-btn"  type="button" name="addasfriend" id="addasfriend" value="Disapprove"   onclick="return dele({$contacts[i].id})" />
				    </div>
                    
                    <div class="clr"></div>
                 </div>
                 
					
						
	 <div class="clr"></div>
				</li>
                  {sectionelse}
					<p class="record-txt">No Record Found.</p>
				{/section}
                  
                  
                </ul>
             
           
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