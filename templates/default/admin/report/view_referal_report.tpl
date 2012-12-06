{include file=$header1}
{include file=$header2}

    <div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/report/referal_report.php">
        Manage Referal Report</a> &gt;  Manage Referal  Details
    </div>
        <br />
            <h3> Manage Referal Details</h3>
    <div class="holdthisTop">
            <span style="float:right;"> 
                <h3>
                    <a href="{$siteroot}/admin/report/referal_report.php">Back</a>
                </h3> 
            </span>
         <table width="100%" cellpadding="2" cellspacing="2" border="0">
                    <tr>
                        <td>
                            <table width="100%" cellpadding="2" cellspacing="2" border="0" class="conttable">
                                <tr>
                                    <td colspan="2" align="left"><h2>Referal Information</h2></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="left">
                                        <p>------------------------------------------------------------------------------</p>
                                    </td>
                                </tr> 
                                <tr>
                                    <td width="15%" align="right"><strong>User Name :</strong> </td>
                                    <td>{$viewpay.first_name}&nbsp;{$viewpay.last_name}</td>
                                </tr>
                                 <tr>
                                    <td width="15%" align="right"><strong> Email :</strong></TD>
                                    <td>{$viewpay.email} </td>
                                </tr>
                                <tr>
                                    <td width="15%" align="right"><strong>Total Affiliate Amount :</strong> </td>
                                    <td>{$viewpay.totAmt}</td>
                                </tr>
                            </table>
                       </td>
                   </tr>
            </table>
    </div>
        <br> 
       <h3 class="fl">Referal Details</h3> 
             <div class="holdthisTop"> 
                 <form name="frmAction" id="frmAction" method="post" action="">
                     <table width="100%" cellspacing="2" cellpadding="6" class="listtable">
                            <tr class="headbg">
                                <!--<td width="1%" align="left" valign="top"><input type="checkbox" id="checkall"/></td>-->
                                <td width="2%" align="left" valign="top"><strong>Sr.No.</strong></td>
                                <td width="25%" align="left" valign="top"><strong>Name</strong></td>
                                <td width="25%" align="left" valign="top"><strong>Email</strong></td>
                                <td width="25%" align="left" valign="top"><strong>Affiliate Amount</strong></td>
                                <td width="12%" align="left" valign="top"><strong>Date</strong></td>
                            </tr>
                        {section name=i loop=$list}
                            <tr class="grayback"  id="tr_{$smarty.section.i.list}">
                                <!--<td align="left" valign="top"><input name="log[]" id="log[]" value="{$list[i].id}" type="checkbox" /> </td>-->
                               <td align="left" valign="top">{$smarty.section.i.iteration}</td>
                                <td align="left" valign="top">{$list[i].to_name|@ucfirst}</td>
                                 <td align="left" valign="top">{$list[i].to_email}</td>
                                 <td align="left" valign="top">{$list[i].affiliate_amt}</td>
                                <td align="left" valign="top">{$list[i].date|date_format:$smarty_date_format}</td>
                            </tr>
                        {sectionelse}
                            <tr>
                                    <td colspan="5" class="error" align="center">No Records Found.</td>
                            </tr>
                        {/section}
                        {if $list}
                            <tr>
                                    <!--<td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                                    <td align="left"><select name="action" id="action">
                                        <option value="">--Action--</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                    <input type="submit" name="submit" id="submit" value="Go" />
                                    <span id="acterr" class="error"></span></td>-->
                                    <td colspan="5" align="right">{if $showpgnation eq "yes"}{$pgnation}{/if}</td>
                            </tr>
                        {/if}
                    </table>
                </form>
            </div>
    

{include file=$footer}