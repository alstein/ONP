{include file=$header_start}
{literal}
<script language="JavaScript" type="text/javascript">
function deleteFan(obj,val,id)
{

 window.location=SITEROOT+"/modules/friend/ajax_delete_fan.php?delid="+val+"&ses_id="+id;	
	
}
function show_button(id1)
{
 console.log("id1 values is =>"+id1);
jQuery("#btn_close1_"+id1).show();

// alert("btn_close1_"+id1);
// 
// document.getElementById("btn_close1_"+id1).style.display="block";
}
function show_button1(id1)
{
 console.log("id1 values is =>"+id1);
jQuery("#btn_close1_"+id1).hide();
// alert("btn_close1_"+id1);
// document.getElementById("btn_close1_"+id1).style.display="none";
}
</script>
{/literal}
<!-- main continer of the page -->

  <!-- Header starts -->
   {include file=$profile_header2}
  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">
      <tr>
        <!-- Profile Left Section Start -->
      {include file=$myprofile_left_panel}

        <!-- Profile Left Section End -->
        <!-- Profile Middle Section Start -->
        <td width="560" valign="top"><!-- Profile Comment Section Start -->
          <div class="maincont-inner-mid fl">
            <div class="edit-profile-form">
              <h1 class=" form-title">Favorite Places</h1>
				<ul class="reset friendlist" >
					{section name=j  loop=$fan }
				<li ><div style="height:10px;"> <img  src="{$siteroot}/templates/default/images/btn_close.png" name="btn_close1_{$smarty.section.j.index}" id="btn_close1_{$smarty.section.j.index}"  style="background-color:Transparent;border:0px; margin-left: 92px;display: none;" onclick="deleteFan(this,{$fan[j].userid},'{$smarty.session.csUserId}')"  ></div><br><img src="{$siteroot}/uploads/user/{if $fan[j].photo1 neq  ''}{$fan[j].photo1}{else}profile_pic.png{/if}" title="" alt="" width="100" height="100"  onmouseover="javascript:show_button('{$smarty.section.j.index}');" onmouseout="javascript:show_button1('{$smarty.section.j.index}');" /><a href="{$siteroot}/merchant-account/{$fan[j].userid}/merchant_profile"> <span style="float:left;">{$fan[j].business_name|truncate:20}</span></a></li>
			
					{sectionelse}
					<div class="error" align="center">No Record Found</div>
				{/section}
		
		</ul>
             
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