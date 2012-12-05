{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/faqlist.js"></script>

{include file=$header2}
<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} Deal Bring Back </h3>
        </div><br/>
        <p align="right"><!--<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="addTooltip.php">Add ToolTip</a>--></p>
        <div class="clr">
        </div>
        <div>
            {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        </div>

    </div>
    <div id="UserListDiv" name="UserListDiv">
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable" width="100%" border="0">   
                <tr class="headbg">
                    <td width="2%" align="center" valign="top"></td>
                    <td width="45%" align="left">Deal Name</td>
                    <td width="15%" align="center">Votes</td>
                   
                   <!-- <td width="15%" align="left">Date</td>-->
                    <td align="left" width="6%">Action</td>
                </tr>

                {section name=i loop=$faqst}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td valign="top"></td>
		
					<td valign="top">
						<img src="{$siteimg}/icons/{if $faqst[i].status  eq 'Inactive'}award_star_silver_1.png
						{else}award_star_silver_2.png{/if}"
						align="absmiddle" />
						{$faqst[i].title}
					</td><td align="center">
				<a valign="top" align="center"><a href="emaillist.php?dealid={$faqst[i].deal_unique_id}">
<img src="{$siteroot}/templates/default/images/icons/film.png">View
({$faqst[i].total})</a></td>
                    		
								
								<td valign="top">
									<div>
									<!--<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />-->
										<a href="{$siteroot}/admin/globalsettings/deal/reset_product.php?id={$faqst[i].deal_unique_id}" title="Reset Deal">
										<strong>Get Back</strong>
										</a>
									</div>
								</td>
                </tr>
                {sectionelse}
                <tr>
                    <td colspan="6" class="error" align="center">No Records Found.</td>
                </tr>
                {/section}
                {if $faqst}
                <tr>
                    <td align="left"><!--<img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />--></td>
                    <td align="left">

				<!--<select name="action" id="action">
				<option value="">Action</option>
				<option value="Active">Active</option>
				<option value="Suspended">Inactivate</option>
				<option value="delete">Delete</option>
				</select>
				<input type="submit" name="submit" id="submit" value="Go"  /><div id="acterr" class="error"></div>-->
                    	</td>
                    	{if $showpgnation eq "yes"}<td colspan="4" align="right">{$pagenation}</td>{/if}

                </tr>
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}