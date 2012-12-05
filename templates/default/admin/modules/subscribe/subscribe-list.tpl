{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/faqlist.js"></script>
{/strip}
{include file=$header2}
<div class="holdthisTop">
    <div>
        <div>
            <h3>{$sitetitle} Subscriber List </h3>
        </div>

        <div class="clr">
        </div><br/>
        <div>
            {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        </div>

    </div>
    <br>
	<div class="fr">
	   <form name="frmSearch" action="" method="get">
		  <table width="50%" align="right" cellpadding="0" cellspacing="0" border="0">
		    <tr>
		      <td align="right">
			<label>
			    <input name="searchuser" type="text" id="searchuser" value="{$smarty.get.searchuser}" size="35" class="search"/> 
			</label>
		      </td>
		      <td width="20%" align="left">
			<input type="submit" name="button" id="button" value="Search" class="searchbutton" />
		    </td>
		  </tr>
	      </table>
	    </form>
      </div>

      <div class="clr">&nbsp;</div>
    <div id="UserListDiv" name="UserListDiv">
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable" width="100%" border="0">   
                <tr class="headbg">
                    <td width="2%" align="center"><input type="checkbox" id="checkall" /></td>
			<td width="25%" align="left" style="display:none;">Subscriber Name</td>
	   		<td align="left">Email</td>
	   		<td width="25%" align="left">City/Town</td>
		       <td width="20%" align="left">Mobile Number</td>
                    <td width="15%" align="left">Date</td>
                </tr>

                {section name=i loop=$subscriber}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td><input type="checkbox" value="{$subscriber[i].nid}" name="userid[]"/></td>
		
					<!--<td valign="top">
						<img src="{$siteimg}/icons/{if $faqst[i].del_status  eq '0'}award_star_silver_1.png
						{else}award_star_silver_2.png{/if}"
						align="absmiddle" />
						{$subscriber[i].name|ucfirst}
					</td>-->
				<td valign="top" style="display:none;">{$subscriber[i].name|ucfirst}</td>
				<td valign="top">{$subscriber[i].nemail}</td>
                    		<td valign="top"> {if $subscriber[i].city_name}{$subscriber[i].city_name}{else}-----{/if}</td>
                    		<td valign="top" align="left"> 
                    		{if $subscriber[i].contact_detail}{$subscriber[i].contact_detail}{else}-----{/if}</td>
				<td valign="top">{$subscriber[i].ndate|date_format:$smarty_date_format}</td>
                </tr>
                {sectionelse}
                <tr>
                    <td colspan="5" class="error" align="center">No Records Found.</td>
                </tr>
                {/section}
                {if $subscriber}
                <tr>
                    <td align="left" valign="top"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                    <td align="left" valign="top">

				<select name="action" id="action">
				<option value="">--Action--</option>
				<!--<option value="Active">Active</option>
				<option value="Suspended">Inactivate</option>-->
				<option value="delete">Delete</option>
				</select> 
				<input type="submit" name="submit" id="submit" value="Go"  /><div id="acterr" class="error"></div>
                    	</td>
			<td colspan="3" align="right">{if $pgnation}{$pgnation}{/if}</td>

                </tr>
			<!--<tr><td colspan="3" align="right">{$pgnation}</td></tr>-->
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}