{include file=$header1}
<script language="JavaScript1.2">var thisFormName  = "frmAction";</script>
<script type="text/javascript" src="{$siteroot}/js/admin_check_uncheck_action.js"></script>
<script type="text/javascript" src="{$siteroot}/js/get_country_state_city.js"></script>
{include file=$header2}

<div align="center" id="msg">{$msg}</div>
<div class="holdthisTop">
      <h3 class="fl width20">&nbsp;&nbsp;City</h3>

<div align="right"><img src="{$siteimg}/icons/add.png" align="absmiddle"/>&nbsp;<a href="edit_city.php">Add city</a></div>

      <div class="fr">
  <form name="frmSearch" action="" method="get">
    <table width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table width="50%" cellpadding="0" cellspacing="0">
            <tr>
               <td></td>
               <td><select name="countries" class="selectbox" id="countries" style="width:180px;"
                        onchange="javascript: getState(this.value,'{$siteroot}');">
                   <option value="">Select Country</option>
                      {section name=i loop=$country}
                   <option value="{$country[i].id}" {if $countries eq $country[i].id} selected="true"
                           {/if} >{$country[i].country}</option>
                      {/section}
                   </select> </td> &nbsp; &nbsp;

                   <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                   <td id="city_div"><select name="states" class="selectbox" id="states"
                       style="width:180px;">
                   <option value="">Select State</option>
                      {section name=i loop=$state_con}
                   <option value="{$state_con[i].id}" {if $states eq $state_con[i].id} selected="true"
                           {/if} >{$state_con[i].state_name}</option>
                      {sectionelse}
                   <option value="">Select State</option>
                      {/section}
                   </select>
               </td>
               <td width="10%">&nbsp;&nbsp;&nbsp;</td>
               <td width="45%" align="right"><label>
                   <input name="search" type="text" id="search" value="{$smarty.get.search|stripslashes}"
                          size="25" class="search" />
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
        <td width="20%">City Name</td>
		  <td width="18%">Landing Page Image</td>
		  <td width="15%">Landing Page color</td>
		  <td width="18%">Inner Page Image</td>
		  <td width="15%">Inner Page color</td>
        <td width="13%">Action</td>
      </tr>
      {section name=i loop=$city}
      <tr class="grayback" id="tr_{$smarty.section.i.iteration}">
        <td><input type="checkbox" name="city_id[]" value="{$city[i].city_id}" onclick="javascript:uncheckMainCheckbox();" /></td>

			<td>
				<img src="{$siteimg}/icons/{if $city[i].active  eq '0'} award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />
				{$city[i].city_name}
			</td>

			<td>
				{if $city[i].landing_page_image}
					<img src="{$siteroot}/uploads/city/{$city[i].landing_page_image}" width="60" height="40" >
				{else}
					No Image
				{/if}
			</td>

			<td>{if $city[i].landing_page_color}{$city[i].landing_page_color}&nbsp;:{/if}
			{if $city[i].landing_page_color}<DIV style="width:50px;background-color:{$city[i].landing_page_color}; border-style:solid;border-width:1px;">&nbsp;</DIV>{/if}</td>

			<td>
				{if $city[i].city_image}
					<img src="{$siteroot}/uploads/city/{$city[i].city_image}" width="60" height="40" >
				{else}
					No Image
				{/if}
			</td>

			<td>{if $city[i].color}{$city[i].color}&nbsp;:{/if}
				{if $city[i].color}<DIV style="width:50px;background-color:{$city[i].color}; border-style:solid;border-width:1px;">&nbsp;</DIV>{/if}</td>

			<td>
				<img src="{$siteimg}/icons/application_edit.png" align="absmiddle" />
					<a href="edit_city.php?cityid={$city[i].city_id}" ><strong>Edit</strong></a>
					&nbsp; | &nbsp;
					{if $city[i].default_city == 0}
				<a name="action" href="city_list.php?cityid={$city[i].city_id}">Default</a>
					{else}
						<span><strong>Default</strong></span>
               {/if}
			</td>
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