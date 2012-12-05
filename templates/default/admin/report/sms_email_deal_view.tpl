{include file=$header1}
{include file=$header2}

    <div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/report/sms_email_report.php">
        SMS And Email Seller Report List</a> &gt; View SMS And Email Deal Report List
    </div>
        <br />
            <h3>View SMS And Email Deal Report List</h3>
    <div class="holdthisTop">
            <span style="float:right;"> 
                <h3>
                    <a href="{$siteroot}/admin/report/sms_email_report.php">Back</a>
                </h3> 
            </span>
         <table width="100%" cellpadding="2" cellspacing="2" border="0">
                    <tr>
                        <td>
                            <table width="100%" cellpadding="2" cellspacing="2" border="0" class="conttable">
                                <tr>
                                    <td colspan="2" align="left"><h2>Seller Information</h2></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="left">
                                        <p>------------------------------------------------------------------------------</p>
                                    </td>
                                </tr> 
                                <tr>
                                    <td width="15%" align="right"><strong>Seller Name :</strong> </td>
                                    <td>{$viewpay.first_name|@ucfirst}&nbsp;{$viewpay.last_name|@ucfirst}</td></tr>
                                <tr>
                                    <td width="15%" align="right"><strong>Email :</strong></TD>
                                    <td>{$viewpay.email} </td>
                                </tr>
                                <tr>
                                    <td width="15%" align="right"><strong>City:</strong> </td>
                                    <td>{if $viewpay.city}{$viewpay.city}{else}-----{/if} </td>
                                </tr>
                                 
                            </table>
                       </td>
                   </tr>
            </table>
    </div>
        <br> 
        <h3 class="fl">Detail Deal Sms And Email Report</h3> 
             <div class="holdthisTop"> 
                 <form name="frmAction" id="frmAction" method="post" action="">
                     <table width="100%" cellspacing="2" cellpadding="6" class="listtable">
                            <tr class="headbg">
                                <!--<td width="1%" align="left" valign="top"><input type="checkbox" id="checkall"/></td>-->
                                <td width="2%" align="left" valign="top"><strong>Sr.No.</strong></td>
                                <td width="25%" align="left" valign="top"><strong>Deal name</strong></td>
                                <td width="10%" align="left" valign="top"><strong>Send Date</strong></td>
                                 <td width="10%" align="left" valign="top"><strong>Send As</strong></td>
                                <td width="10%" align="left" valign="top"><strong>SMS Count</strong></td>
                                <td width="10%" align="left" valign="top"><strong>Email Count</strong></td>
                                <td width="12%" align="left" valign="top"><strong>Cost Per Email</strong></td>
                                <td width="10%" align="left" valign="top"><strong>Cost Per SMS</strong></td>
                                <td width="40%" align="left" valign="top">Total Amount</td>
                               <!-- <td width="28%" align="left" valign="top">SMS Content</td>
                                <td width="28%" align="left" valign="top">Email Content</td>-->
                                <td width="28%" align="left" valign="top">Action</td>
                            </tr>
                        {section name=i loop=$list}
                            <tr class="grayback"  id="tr_{$smarty.section.i.list}">
                                <td align="left" valign="top">{$smarty.section.i.iteration}</td>
                                <td align="left" valign="top">{$list[i].title|@ucfirst|html_entity_decode} </td>
                                 <td align="left" valign="top">{$list[i].send_date|date_format:$smarty_date_format}</td>
                                  <td align="left" valign="top">{if $list[i].option eq 'BOTH'}Both
                                  {elseif $list[i].option eq 'SMS'}SMS
                                  {elseif $list[i].option eq 'EMAIL' } Email {else}-----{/if}</td>
                                 <td align="left" valign="top">{if $list[i].option eq 'BOTH' or $list[i].option eq 'SMS'}{$list[i].smsCount}{else}0{/if}</td>
                                 <td align="left" valign="top">{if $list[i].option eq 'BOTH' or $list[i].option eq 'EMAIL'}{$list[i].emailCount}{else}0{/if}</td>
                                <td align="left" valign="top">{$list[i].cost_per_email}</td>
                                <td align="left" valign="top">{$list[i].cost_per_sms}</td>
                                <td align="left" valign="top">{if $list[i].totalAmt neq ''}{$list[i].totalAmt}{/if}</td>
                                <!--<td align="left" valign="top">{$list[i].smsContent}</td>
                                <td align="left" valign="top">{$list[i].emailContent}</td>-->
                                <td align="left" valign="top">
                                <a href="sms_email_contact_info.php?sms_email_id={$list[i].id}" title="View">View</a></td>
                             </tr>
                            </tr>
                        {sectionelse}
                            <tr>
                                    <td colspan="10" class="error" align="center">No Records Found.</td>
                            </tr>
                        {/section}
                            <tr>
                                    <!--<td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                                    <td align="left"><select name="action" id="action">
                                        <option value="">--Action--</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                    <input type="submit" name="submit" id="submit" value="Go" />
                                    <span id="acterr" class="error"></span></td>-->
                                    <td colspan="11" align="right">{$pgnation}</td>
                            </tr>
                    </table>
                </form>
            </div>
{include file=$footer}