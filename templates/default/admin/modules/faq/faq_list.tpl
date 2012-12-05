{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/faqlist.js"></script>

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; FAQ List
</div>
<br />


<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} FAQ </h3>
        </div><br/>
        <p align="right"><img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_faq.php">Add FAQ</a></p>
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
                    <td width="2%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
                    <td width="30%" align="left">Question</td>
                    <td width="30%" align="left">Answer</td>
                    <td width="15%" align="left">Category</td>
                    <td width="15%" align="left">Date</td>
                    <td align="left" width="6%">Action</td>
                </tr>

                {section name=i loop=$faqst}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td valign="top"><input type="checkbox" value="{$faqst[i].faqid}" name="catid[]" id="catid"/></td>
		
					<td valign="top">
						<img src="{$siteimg}/icons/{if $faqst[i].del_status  eq '0'}award_star_silver_1.png
						{else}award_star_silver_2.png{/if}"
						align="absmiddle" />
						{$faqst[i].faqquestion|ucfirst}
					</td>
				<td valign="top">{$faqst[i].faqanswer}</td>
                    		<td valign="top"> {$faqst[i].faq_cat}</td>
                    		<td valign="top"> {$faqst[i].addeddt|date_format:$smarty_date_format}</td>


								<td valign="top">
									<div>
									<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
										<a href="edit-faq.php?cid={$faqst[i].faqid}" title="Edit Categoty Details">
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
                    	{if $showpgnation eq "yes"}<td colspan="4" align="right">{$pagenation}</td>{/if}

                </tr>
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}