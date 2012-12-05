{include file=$header1}
<!--<link rel="stylesheet" href="{$siteroot}/templates/{$templatedir}/css/thickbox.css" type="text/css" media="screen" />-->
<!--<script type="text/javascript" src="{$siteroot}/js/thick_js/thickbox.js"></script>-->
<script type="text/javascript" src="{$siteroot}/js/validation/admin/forumcategories.js"></script>

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Discussion Categories</div>
<div align="center" id="msg">{$msg}</div>
<div class="holdthisTop">
  <h3 class="fl">&nbsp;&nbsp; Discussion Categories</h3><br/>
  <!--  <form name="frmSearch" action="" method="get">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tr>
        <td>-->
	    <span class="fr"><img src="{$siteroot}/templates/{$templatedir}/images/icons/add.png" align="absmiddle"> <a href=" {$siteroot}/admin/modules/discussion/edit_category.php">Add Discussion Category</a></span></td>
   <!--   </tr>
    </table>
  </form>-->
</div>
<div class="holdthisTop">
  <form name="frmAction" id="frmAction" method="post" action="">
    <table cellpadding="6" cellspacing="2" align="center" width="100%" border="0" class="listtable">
      <tr class='headbg' align="center" valign="top">
        <td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
        <td align="left" valign="top">Discussion Category

					<!--<a href="{$siteroot}/admin/modules/discussion/categories.php?orderby=category asc"><img src="{$siteroot}/templates/default/images/up.gif" alt="ASC" width="10" height="10" title="ASC" /></a>
					<a href="{$siteroot}/admin/modules/discussion/categories.php?orderby=category desc"><img src="{$siteroot}/templates/default/images/down.gif" alt="DESC" width="10" height="10" title="DESC"  /></a>-->
			</td>
        <!--<td width="24%" align="center" valign="top">No. of Forums</td>-->
        <td width="13%" align="left" valign="top">Action</td>
      </tr>
      {section name=i loop=$categories}
      <tr class="grayback" id="tr_{$categories[i].categoryid}">
        <td align="center" valign="top"><input type="checkbox" name="categoryid[]" value="{$categories[i].categoryid}" />
        </td>
        <td align="left" valign="top"><img src="{$siteroot}/templates/{$templatedir}/images/icons/{if $categories[i].status  eq 'Inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle"/> {$categories[i].category}</td>
        <!--<td align="center" valign="top">{$categories[i].forums}</td>-->
        <td align="left" valign="top"><img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" /> <a href="{$siteroot}/admin/modules/discussion/edit_category.php?categoryid={$categories[i].categoryid}" >Edit</a>&nbsp;|&nbsp;Order
<input type="text" size="2" name="{$categories[i].categoryid}" id="{$categories[i].categoryid}" value="{$categories[i].sizeorder}" /></td>
      </tr>
      {sectionelse}
      <tr class="grayback">
        <td colspan="4" align="center" class="error">No Records Found</td>
      </tr>
      {/section}
      <tr>
        <td align="left" valign="top"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif" /></td>
        <td align="left"><select name="action" id="action">
            <option value="">--Action--</option>
            <option value="active">Active</option>
            <option value="inactive">Inactivate</option>
            <option value="delete">Delete</option>

          </select>
          <input type="submit" name="submit" id="add" value="Go" class="ButtonBg" />
          <span id="acterr" class="error"></span><div class="ar fr width50">
               {$pgnation}
            </div>
            <div class="clr"></div></td>
        <td  align="left">
<input type="submit" name="submit1"  value="Update" /></td>
        <!--<td colspan="2" align="right"></td>-->
      </tr>
    </table>
  </form>
</div>
{include file=$footer}