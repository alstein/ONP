{include file=$header_start}
{literal}
<script language="JavaScript" type="text/javascript">
function deleteFan(obj,val,id)
{

 window.location=SITEROOT+"/modules/friend/ajax_delete_merchantsfan.php?delid="+val+"&ses_id="+id;	
	
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
      {include file=$merchantprofile_left_panel}

        <!-- Profile Left Section End -->
        <!-- Profile Middle Section Start -->
        <td width="560" valign="top"><!-- Profile Comment Section Start -->
          <div class="maincont-inner-mid fl">
            <div class="edit-profile-form">
              <h1 class=" form-title">Merchant's Fan</h1>
				<ul class="reset friendlist"  style="height:612px;">
					{section name=k  loop=$merchants_fan1}
					<li><img src="{$siteroot}/templates/default/images/btn_close.png" name="btn_close1_{$smarty.section.i.index}" id="btn_close1_{$smarty.section.i.index}"  style="background-color:Transparent;border:0px; margin-left: 92px;" onclick="deleteFan(this,{$merchants_fan1[k].fan_id},'{$smarty.session.csUserId}')"  ><br>
					<img src="{if $merchants_fan1[k].facebook_userid neq ''}http://graph.facebook.com/{$merchants_fan1[k].facebook_userid}/picture?type=large{else}{if $merchants_fan1[k].photo1 neq '' }{$siteroot}/uploads/user/{$merchants_fan1[k].photo1}{else}{$siteroot}/templates/default/images/profile_pic.png {/if}{/if}" title="" alt="" width="100" height="100" />
					<a href="{$siteroot}/my-account/{$merchants_fan1[k].fan_id}/my_profile">{$merchants_fan1[k].first_name} {$merchants_fan1[k].last_name}</a>
					</li>
					{sectionelse}
						<div class="error" align="center">No Record Found</div>
					{/section}
						
				</ul>
				
            </div>
<div align="center">{$pgnation}</div>
            <div class="clr" style="height:30px"></div>
          </div>
          <!-- Profile Comment Section End --></td>
        <!-- Profile Middle Section End -->
        <!-- Profile Right Section Start -->
          {include file=$merchant_home_right}
        <!-- Profile Right Section End -->
      </tr>
    </table>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
     {include file=$footer}