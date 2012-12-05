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
              <h1 class=" form-title">Friends</h1>
				<ul class="reset friendlist" style="height:612px;">
		{section name=i  loop=$friend1}
		{if $smarty.get.id1 neq ''}
	<li><img src="{$siteroot}/uploads/user/{if $friend1[i].userid neq $smarty.get.id1}{if $friend1[i].facebook_userid neq ''}http://graph.facebook.com/{$friend1[i].facebook_userid}/picture?type=large{else}{$siteroot}/uploads/user/{if $friend1[i].photo1 eq ''}	profile_pic.png{else}{$friend1[i].photo1}{/if}{/if}{else}{if $friend1[i].facebook_userid1 neq ''}	http://graph.facebook.com/{$friend1[i].facebook_userid1}/picture?type=large{else}{$siteroot}/uploads/user/{if $friend1[i].photo2 eq '' }	profile_pic.png{else}{$friend1[i].photo2}{/if}{/if}{/if}" title="" alt="" width="100" height="100" />
		<a href="{$siteroot}/my-account/{if $friend1[i].userid neq $smarty.get.id1}{$friend1[i].userid}{else}{$friend1[i].friendid}{/if}/my_profile">{if $friend1[i].userid neq $smarty.get.id1}{$friend1[i].first_name} {$friend1[i].last_name}{else} {$friend1[i].first_name1} {$friend1[i].last_name1}{/if}</a>
		</li>
		{else}
	
		<li><img src="{$siteroot}/templates/default/images/btn_close.png" name="btn_close1_{$smarty.section.i.index}" id="btn_close1_{$smarty.section.i.index}"  style="background-color:Transparent;border:0px; margin-left: 92px;" onclick="deleteFriend(this,{if $friend1[i].userid neq $smarty.session.csUserId}'{$friend1[i].userid}'{else}'{$friend1[i].friendid}'{/if},'{$smarty.session.csUserId}')"  ><br><img src="{if $friend1[i].userid neq $smarty.session.csUserId}{if $friend1[i].facebook_userid neq ''}http://graph.facebook.com/{$friend1[i].facebook_userid}/picture?type=large{else}{$siteroot}/uploads/user/{if $friend1[i].photo1 eq ''}profile_pic.png{else}{$friend1[i].photo1}{/if}{/if}{else}{if $friend1[i].facebook_userid1 neq ''}http://graph.facebook.com/{$friend1[i].facebook_userid1}/picture?type=large{else}{$siteroot}/uploads/user/{if $friend1[i].photo2 eq '' }{$siteroot}profile_pic.png{else}{$friend1[i].photo2}{/if}{/if}{/if}" title="" alt="" width="100" height="100" />
		<a href="{$siteroot}/my-account/{if $friend1[i].userid neq $smarty.session.csUserId}{$friend1[i].userid}{else}{$friend1[i].friendid}{/if}/my_profile">{if $friend1[i].userid neq  $smarty.session.csUserId}{$friend1[i].first_name} {$friend1[i].last_name}{else} {$friend1[i].first_name1} {$friend1[i].last_name1}{/if}</a>
		</li>
		{/if}
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
          {include file=$myprofile_right_panel}
        <!-- Profile Right Section End -->
      </tr>
    </table>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
     {include file=$footer}