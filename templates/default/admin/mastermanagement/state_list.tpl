{include file=$header1}
<script language="JavaScript1.2">var thisFormName  = "frmAction";</script>
<script type="text/javascript" src="{$siteroot}/js/admin_check_uncheck_action.js"></script>
{include file=$header2}
<div align="center" id="msg">{$msg}</div>
<div class="holdthisTop">
	<h3 class="fl width20">&nbsp;&nbsp;States</h3>

<p align="right"><img src="{$siteimg}/icons/add.png" align="absmiddle" /> <a href="javascript: void(0);" onclick="javascript: tb_show('Add state', 'edit_state.php?placeValuesBeforeTB_=savedValues&TB_iframe=true&height=190&width=350&modal=false', tb_pathToImage);" class="thickbox">Add state</a></p>
<p>&nbsp;</p>

	<div class="fr">
  <form name="frmSearch" action="" method="get">
    <table width="100%" cellspacing="4" cellpadding="3">
      <tr>
        <td align="right"><table width="100%" align="right" cellpadding="0" cellspacing="0">
            <tr>
				<td width="6%">Country&nbsp;</td>
				<td width="39%"><select name="countries" id="countries" style="width:150px;">
				<option value="">Select country</option>
			{section name=i loop=$country}
			<option value="{$country[i].id}" {if $countries eq $country[i].id} selected="true" {/if} >{$country[i].country}</option>
			{/section}
	</select></td>
			<td width="10%">&nbsp;</td>
              <td width="45%" align="right"><label>
                <input name="search" type="text" id="search" value="{$smarty.get.search|stripslashes}" size="35" class="search" />
                </label></td>
              <td width="27%" align="left"><input type="submit" name="button" id="button" value="Search"
class="searchbutton" /></td>
            </tr>
          </table></td>
      </tr>
    </table>
  </form>
</div>
<br clear="all">
</div>
<div class="holdthisTop">
  <form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
    <table width="100%" cellspacing="2" cellpadding="6" class="listtable">
      <tr class="headbg">
        <td width="1%"><input type="checkbox" id="checkall" /></td>
        <td>State Name</td>
        <td width="10%">Action</td>
      </tr>
      {section name=i loop=$state}
      <tr class="grayback" id="tr_{$smarty.section.i.iteration}">
        <td><input type="checkbox" name="stateid[]" value="{$state[i].id}" onclick="javascript:uncheckMainCheckbox();" /></td>
        <td><img src="{$siteimg}/icons/{if $state[i].active  eq '0'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" /> {$state[i].state_name}</td>

		  <td><img src="{$siteimg}/icons/application_edit.png" align="absmiddle" /> <a href="javascript: void(0);" onclick="javascript: tb_show('Edit State', 'edit_state.php?stateid={$state[i].id}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=190&width=350&modal=false', tb_pathToImage);" class="thickbox"><strong>Edit</strong></a></td>
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
					  <option value="delete">Delete</option>
					  <option value="active">Active</option>
					  <option value="inactive">Inactive</option>
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