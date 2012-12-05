{include file=$header1}
<script language="JavaScript1.2">var thisFormName  = "frmAction";</script>
<script type="text/javascript" src="{$siteroot}/js/admin_check_uncheck_action.js"></script>
{include file=$header2}

<div class="holdthisTop">
	<h3 class="fl width20">&nbsp;&nbsp;Manage Advertisement</h3>
<p>&nbsp;</p>
<p align="right"><img src="{$siteimg}/icons/add.png" align="absmiddle"/>
<a href="edit_banner.php?banner_id={$b}">Add New</a></p>
            <p>&nbsp;</p>
 <div align="right">
        <a href="javascript:history.go(-1);">Back</a>
    </div><br>
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
        <td width="1%"><!--<input type="checkbox" id="checkall" />--></td>
        <td width="20%">Advertisement Location <!--&nbsp;
				<a href="{$siteroot}/admin/modules/banner/banner.php?banner_id={$smarty.get.banner_id}&orderby=location_name asc"><img src="{$siteroot}/templates/default/images/up.gif" alt="ASC" width="10" height="10" title="ASC" /></a>
				<a href="{$siteroot}/admin/modules/banner/banner.php?banner_id={$smarty.get.banner_id}&orderby=location_name desc"><img src="{$siteroot}/templates/default/images/down.gif" alt="DESC" width="10" height="10" title="DESC"  /></a>--></td>
        <td width="30%">Start Date&nbsp;/&nbsp;Expired Date <!--&nbsp;
				<a href="{$siteroot}/admin/modules/banner/banner.php?banner_id={$smarty.get.banner_id}&orderby=start_date asc"><img src="{$siteroot}/templates/default/images/up.gif" alt="ASC" width="10" height="10" title="ASC" /></a>
				<a href="{$siteroot}/admin/modules/banner/banner.php?banner_id={$smarty.get.banner_id}&orderby=start_date desc"><img src="{$siteroot}/templates/default/images/down.gif" alt="DESC" width="10" height="10" title="DESC"  /></a>--></td>
		<td>Banner</td>
		
        <td width="10%">Action</td>
      </tr>
      {section name=i loop=$banner}
      <tr class="grayback" id="tr_{$smarty.section.i.iteration}">
        <td><input type="checkbox" name="id[]" value="{$banner[i].id}" /></td>
          <td><img src="{$siteimg}/icons/{if $banner[i].status  eq '0'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />{$banner[i].location_name}</td>
          <td>{$banner[i].start_date}&nbsp;/&nbsp;{$banner[i].expired_date}</td>
	<td ><img src="{$siteroot}/uploads/banner/thumbnail/{$banner[i].product_image}" height="100" width="100"></td>

          <td><img src="{$siteroot}/templates/{$templatedir}/images/icons/application_edit.png" align="absmiddle" /> <a href="{$siteroot}/admin/modules/banner/
		edit_banner.php?id={$banner[i].id}&banner_id={$banner[i].banner_id}" class="admintxt">Edit</a></td>

      </tr>
      {sectionelse}
      <tr>
        <td colspan="4" class="error" align="center">No Records Found.</td>
      </tr>
      {/section}
      <tr>
        <td colspan="4">
			  <div class="fl width50">
				  <img src="{$siteroot}/templates/default/images/{$AdminFolderName}/arrow_ltr.gif" />
				  <select name="action" id="action">
					  <option value="">--Action--</option>
					  <option value="active">Active</option>
					  <option value="inactive">Inactive</option>
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