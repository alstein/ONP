{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/faqcategorylist.js"></script>



{include file=$header2}
<div class="holdthisTop">
    <div>
        <div class="fl width50">
            <h3>{$sitetitle} Contactus subject </h3>
        </div>
        <p align="right"><img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="addsubject.php" class="thickbox">Add Contactus subject</a></p>
        <div class="clr">
        </div><br/>
        <div>
            {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        </div>
        <div align="right">
           <!-- <a href="javascript:history.go(-1);">Back</a>-->
        </div>
    </div>
    <br>
    <div id="UserListDiv" name="UserListDiv">
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable" width="100%" border="0">   
                <tr class="headbg">
                    <td width="2%" align="center"><input type="checkbox" id="checkall" style="display:none" /></td>
                    <td width="40%" align="left"><!--<a href="javascript: void(0);" onclick="javascript: changeord('name');">-->Subject<!--</a>--></td>
                    <td width="40%" align="left">Status (Active/Inactive)</td> 
                    <td align="left"><div style="width:80px;">Action</div></td>
                </tr>
                {section name=i loop=$categoryResult}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td><input type="checkbox" value="{$categoryResult[i].subid}" name="catid[]"/></td>
		
					<td valign="top">
						<img src="{$siteimg}/icons/{if $categoryResult[i].status  eq '0'}award_star_silver_1.png
						{else}award_star_silver_2.png{/if}"
						align="absmiddle" /><!--
						<a href="user_information.php?userid={$categoryResult[i].id}" title="Edit Category Details">-->{$categoryResult[i].subject}<!--</a>-->
					</td>
                    					<td valign="top"> {if $categoryResult[i].status eq '1'} Active {else} Inactive {/if}</td>
								
								<td>
									<div>
									<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
										<a href="addsubject.php?cid={$categoryResult[i].subid}" title="Edit subject">
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
                {if $categoryResult}
                <tr>
                    <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                    <td align="left" width="30px" colspan="3">
			
		<table border="0" width="20%">
			<tr>
			<td>
				<select name="action" id="action">
				<option value="">--Action--</option>
				<option value="Active">Active</option>
				<option value="Suspended">Inactivate</option>
				<option value="delete">Delete</option>
				</select>&nbsp;
				<input type="submit" name="submit" id="submit" value="Go"  /><div id="acterr" class="error"></div>
			</td>
			</tr>
		</table>

</td>
                    <!--<td align="right" colspan="3">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>-->
                </tr>
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}