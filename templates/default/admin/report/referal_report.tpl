{include file=$header1}
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage Referal Report</div><br/>
<h3>Manage Referal Report</h3>

 {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
 
    <div class="holdthisTop">
    </div>
        <div class="holdthisTop"> 
            <form name="frmAction" id="frmAction" method="post" action="">
                <table width="100%" cellspacing="2" cellpadding="6" class="listtable">
                    <tr class="headbg">
                        <td width="5%" align="left" valign="top"><strong>Sr.No.</strong></td>
                        <td width="15%" align="left" valign="top"><strong>User Name</strong></td>
                        <td width="15%" align="left" valign="top"><strong>User Email</strong></td>
                        <td width="15%" align="left" valign="top"><strong>Total Affiliate Amount</strong></td>
                        <td width="5%" align="left" valign="top">Action</td>
                    </tr>
            {section name=i loop=$list}
                <tr class="grayback"  id="tr_{$smarty.section.i.list}">
                     <td align="left" valign="top">{$smarty.section.i.iteration}</td>
                     <td align="left" valign="top">{$list[i].first_name}&nbsp;{$list[i].last_name}</td>
                     <td align="left" valign="top">{$list[i].email}</td>
                     <td align="left" valign="top">{$list[i].totAmt}</td>
                    <td><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /> 
                    <a href="view_referal_report.php?user_id={$list[i].userid}" title="View">View</a></td>
                </tr>
            {sectionelse}
                <tr>
                    <td colspan="6" class="error" align="center">No Records Found.</td>
                </tr>
            {/section}
            {if $list}
                    <tr>
                        <td colspan="6" align="right">{if $showpgnation eq "yes"}{$pgnation}{/if}</td>
                    </tr>
            {/if}
                </table>
            </form>
        </div>
{include file=$footer} 

