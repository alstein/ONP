{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/faqlist.js"></script>



{include file=$header2}
<div class="holdthisTop">
    <div>
        <div class="fl width50">
            <h3>{$sitetitle} Business </h3>
        </div>
        <p align="right"><img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="addbusiness.php" class="thickbox">Add Business</a></p>
        <div class="clr">
        </div><br/>
        <div>
            {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        </div>
<!--        <div align="right">
            <a href="javascript:history.go(-1);">Back</a>
        </div>
bcname 	image 	city 	state 	website 	email 	contact_name 	phone 	comments 	active 	postdate -->


    </div>
    <br>
    <div id="UserListDiv" name="UserListDiv">
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable" width="100%" border="0">   
                <tr class="headbg">
                    <td width="2%" align="center"><input type="checkbox" id="checkall" style="display:none" /></td>
                    <td width="25%" align="left">Buseness</td>
                    <td width="20%" align="left">Contact name</td>
                    <td width="10%" align="left">Phone</td>
                    <td width="15%" align="left">Website</td>
                    <td width="15%" align="left">Emailid</td>
                    <td align="left" width="15"><div style="width:80px;">Action</div></td>
                </tr>
                {section name=i loop=$faqst}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td><input type="checkbox" value="{$faqst[i].bcid}" name="catid[]"/></td>
		
					<td valign="top">
						<img src="{$siteimg}/icons/{if $faqst[i].active  eq '0'}award_star_silver_1.png
						{else}award_star_silver_2.png{/if}"
						align="absmiddle" />
						{$faqst[i].bcname}
					</td>
				<td valign="top">{$faqst[i].contact_name}</td>
                    		<td valign="top"> {$faqst[i].phone}</td>
                    		<td valign="top"> {$faqst[i].website}</td>
                    		<td valign="top"> {$faqst[i].email}</td>
								
								<td>
									<div>
									<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
										<a href="addbusiness.php?cid={$faqst[i].bcid}" title="Edit business Details">
										<strong>Edit</strong></a>&nbsp;/&nbsp;<a href="view.php?cid={$faqst[i].bcid}" title="View business Details"><img align="absmiddle" src="{$siteroot}/templates/default/images/icons/film.png"/>
										View</a>
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
                    <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                    <td align="left" width="30px" colspan="3">
			
		<!--<table border="0" width="20%">
			<tr>
			<td>-->
				<select name="action" id="action">
				<option value="">--Action--</option>
				<option value="Active">Active</option>
				<option value="Suspended">Inactivate</option>
				<option value="delete">Delete</option>
				</select>
&nbsp;
				<input type="submit" name="submit" id="submit" value="Go"  /><div id="acterr" class="error"></div>
                    	</td>
                    	<td colspan="4" align="right">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
                    <!--<td align="right" colspan="3"></td>-->
                </tr>
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}