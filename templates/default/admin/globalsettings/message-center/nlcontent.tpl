{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/nlcontent.js"></script>


{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Message Content
</div>
<br />
<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} Message Content</h3>
        </div>
        <p align="right"><img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="edit_message.php?placeValuesBeforeTB_=savedValues&amp;TB_iframe=true&amp;height=450&amp;width=800&amp;modal=false" class="thickbox" title="Add Message Content">Add Message</a></p>
        <div class="clr">
        </div><br/>
        <div>
            {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        </div>
        <!--<div align="right">
            <a href="javascript:history.go(-1);">Back</a>
        </div>-->
    </div>
    <br>
    <div id="UserListDiv" name="UserListDiv">
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable" width="100%" border="0">   
                <tr class="headbg">
                    <td width="1%" align="center"><input type="checkbox" id="checkall" /></td>
                    <td width="30%" align="left"><!--<a href="javascript: void(0);" onclick="javascript: changeord('name');">-->Message  Name<!--</a>--></td>
                    <td width="30%" align="left"><!--<a href="javascript: void(0);" onclick="javascript: changeord('name');">-->Message Title<!--</a>--></td>
<!--                     <td width="15%" align="left">City</td> -->
<!--                     <td width="15%" align="left">Start date</td> -->
                    <td align="left" width="6%"><div style="width:80px;">Action</div></td>
                </tr>

                {section name=i loop=$faqst}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td align="center"><input type="checkbox" value="{$faqst[i].nl_id}" name="catid[]"/></td>
		
					<td valign="top">
						<img src="{$siteimg}/icons/{if $faqst[i].del_status  eq '0'}award_star_silver_1.png
						{else}award_star_silver_2.png{/if}"
						align="absmiddle" />
						<!--<a href="demo.php?userid={$categoryResult[i].id}" title="Edit Category Details">-->{$faqst[i].nl_name|ucfirst}<!--</a>-->
					</td>
				            <td valign="top">{$faqst[i].nl_title|ucfirst}</td>
<!--                     		<td valign="top"> {$faqst[i].city_name|ucfirst}</td> -->
<!--                     		<td valign="top"> {$faqst[i].startdate}</td> -->
								
								<td>
									<div>
									<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
										<a href="edit_message.php?nl_id={$faqst[i].nl_id}&amp;placeValuesBeforeTB_=savedValues&amp;TB_iframe=true&amp;height=450&amp;width=800&amp;modal=false" title="Edit Message Details" class="thickbox">
										<strong>Edit</strong>
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
                    <td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                    <td align="left">
				<select name="action" id="action">
				<option value="">--Action--</option>
				<option value="Active">Active</option>
				<option value="inactivate">Inactive</option>
				<option value="delete">Delete</option>
				</select>
				<input type="submit" name="submit" id="submit" value="Go"  /><div id="acterr" class="error"></div>
                    	</td>
                    	<td colspan="2" align="right">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
                </tr>
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}