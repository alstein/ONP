{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<!--<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>-->
<script type="text/javascript" src="{$siteroot}/js/validation/admin/msglist.js"></script>
{include file=$header2}

<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} Display Message </h3>
        </div>
        <div class="clr">&nbsp;</div>

        {if $msg}<br/><div align="center" id="msg">{$msg}<br/></div>{/if}

        <div class="clr">&nbsp;</div>
        <p align="right" style="padding:5px;"><img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_msg.php?cid={$categoryResult[i].msgid}&amp;placeValuesBeforeTB_=savedValues&amp;TB_iframe=true&amp;height=350&amp;width=800&amp;modal=false"" class="thickbox" title="Add Error Message">Add Message</a></p>
    </div>

    <div id="UserListDiv" name="UserListDiv">
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="1" cellpadding="15" class="listtable" width="100%" border="0">
                <tr class="headbg">
                    <td width="2%" align="center"><input type="checkbox" id="checkall"/></td>
                    <td align="left">Message</td>
                    <td width="20%" align="left">Message Type</td> 
                    <td width="20%" >Status</td> 
                    <td width="20%">Action</td>
                </tr>
                {section name=i loop=$categoryResult}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td><input type="checkbox" value="{$categoryResult[i].msgid}" name="catid[]"/></td>
		    <td valign="top">
		    {if $categoryResult[i].del_status eq 1}
		      <img src="{$siteimg}/icons/award_star_silver_2.png" align="absmiddle" />
		    {else}
		      <img src="{$siteimg}/icons/award_star_silver_1.png" align="absmiddle" />
		    {/if}
                      {$categoryResult[i].msgtext|ucfirst}
                    </td>
		    <td valign="top" align="left"> {$categoryResult[i].msgtype|ucfirst}</td>
		    <td valign="top" align="left"> {if $categoryResult[i].del_status eq 0}Inactive{else}Active{/if}</td>
		    <td align="left" valign="top">
		      <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
		      <a href="add_msg.php?cid={$categoryResult[i].msgid}&amp;placeValuesBeforeTB_=savedValues&amp;TB_iframe=true&amp;height=350&amp;width=800&amp;modal=false""  title="Edit Error Message"  class="thickbox"><strong>Edit</strong> </a>
		    </td>
                </tr>
                {sectionelse}
                <tr>
                    <td colspan="6" class="error" align="center">No record(s) found</td>
                </tr>
                {/section}
		
                {if $categoryResult}
                <tr>
 
		    <td align="left" valign="top"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
		    <td valign="top">
		      <select name="action" id="action">
		      <option value="">--Action--</option>
		      <option value="Active">Active</option>
		      <option value="Suspended">Inactive</option>
		      <option value="delete">Delete</option>
		      </select>&nbsp;
		      <input type="submit" name="submit" id="submit" value="Go"  /><div id="acterr" class="error"></div>
		    </td>
		    <td valign="top" align="right" colspan="3">{$pgnation}</td>
			   
                </tr>
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}