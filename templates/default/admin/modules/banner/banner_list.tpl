{include file=$header1}
<script language="JavaScript1.2">var thisFormName  = "frmAction";</script>
<script type="text/javascript" src="{$siteroot}/js/admin_check_uncheck_action.js"></script>
{include file=$header2}

<div class="holdthisTop">
	<h3 class="fl width20">&nbsp;&nbsp; Advertisement</h3>
<p>&nbsp;</p>
<p align="right"><img src="{$siteimg}/icons/add.png" align="absmiddle"/>
<a href="edit_bannerlist.php">Add New</a></p>
            <p>&nbsp;</p>
<div align="center" id="msg">{$msg}</div>
	<div class="fr width60">
  <form name="frmSearch" action="" method="get">
    <table width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right"><table width="35%" align="right" cellpadding="0" cellspacing="0">
		
          </table></td>
      </tr>
    </table>
  </form>
</div>
<br clear="all">
</div>
<div class="holdthisTop">
  <form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
    <table width="100%" cellspacing="2" cellpadding="6" class="listtable" border="0">
      <tr class="headbg">
        <td width="1%"><input type="checkbox" id="checkall" /></td>

        <td>Name</td>
		
        <td align="center" width="20%">Action</td>
      </tr>
      {section name=i loop=$banner}
      <tr class="grayback" id="tr_{$smarty.section.i.iteration}">
        <td><input type="checkbox" name="banner_id[]" value="{$banner[i].banner_id}" /></td>
        <td><img src="{$siteimg}/icons/{if $banner[i].active  eq '0'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />{$banner[i].name}</td>
          <td align="center"><img src="{$siteroot}/templates/{$templatedir}/images/icons/application_edit.png" align="absmiddle" /> <a href="{$siteroot}/admin/modules/banner/edit_bannerlist.php?banner_id={$banner[i].banner_id}" class="admintxt">Edit</a>&nbsp;&nbsp;|&nbsp;<a href="{$siteroot}/admin/modules/banner/banner.php?banner_id={$banner[i].banner_id}" class="admintxt">Add New&nbsp;/&nbsp;View</a></td></td>

      </tr>
      {sectionelse}
      <tr>
        <td colspan="4" class="error" align="center">No Records Found.</td>
      </tr>
      {/section}
      <tr>
        <td colspan="4">
			  <div class="fl width50">
				  <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif" />
				  <select name="action" id="action">
					  <option value="">--Action--</option>
					  <option value="active">Active</option>
					  <option value="inactive">Inactivate</option>
					  <option value="delete">Delete</option>
				  </select>
				  <input type="submit" name="submit" id="submit" value="Go" />
          		<span id="acterr" class="error"></span>
			  </div>
			  <div class="ar fr width50">
				  {$pgnation}
			  </div>
			  <div class="clr"></div>
				</td>
      </tr>
    </table>
  </form>
</div>
{include file=$footer}