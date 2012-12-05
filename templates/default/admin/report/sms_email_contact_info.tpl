{include file=$header1}
{include file=$header2}

    <div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/report/sms_email_report.php">
        SMS And Email Seller Report List</a> &gt;  <a href="{$siteroot}/admin/report/sms_email_deal_view.php?seller_id={$viewpay.seller_id}"> View SMS And Email Deal Report List</a> &gt; View SMS And Email Contact Information List
    </div>
        <br />
            <h3>View SMS And Email Contact Information Report List</h3>
    <div class="holdthisTop">
            <span style="float:right;"> 
                <h3>
                    <a href="{$siteroot}/admin/report/sms_email_deal_view.php?seller_id={$viewpay.seller_id}">Back</a>
                </h3> 
            </span>
         <table width="100%" cellpadding="2" cellspacing="2" border="0">
                    <tr>
                        <td>
                            <table width="100%" cellpadding="2" cellspacing="2" border="0" class="conttable">
                                <tr>
                                    <td colspan="2" align="left"><h2>Sms And Email Deal Information</h2></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="left">
                                        <p>------------------------------------------------------------------------------</p>
                                    </td>
                                </tr> 
                                <tr>
                                    <td width="15%" align="right"><strong>Deal name :</strong> </td>
                                    <td>{$viewpay.first_name|@ucfirst}&nbsp;{$viewpay.title|@ucfirst|html_entity_decode}</td></tr>
                                <tr>
                                    <td width="15%" align="right"><strong>Send Date :</strong></TD>
                                    <td>{$viewpay.send_date|date_format:$smarty_date_format} </td>
                                </tr>
                                <tr>
                                    <td width="15%" align="right"><strong>Send As:</strong> </td>
                                    <td>{if $viewpay.option eq 'BOTH'}Both{elseif $viewpay.option eq 'SMS'}SMS{elseif $viewpay.option eq 'EMAIL' } Email {else}-----{/if}</td>
                                </tr>
                                {if $viewpay.option eq 'BOTH' or $viewpay.option eq 'SMS'}
                                <tr>
                                    <td width="15%" align="right"><strong>SMS Count :</strong></TD>
                                    <td>{if $viewpay.option eq 'BOTH' or $viewpay.option eq 'SMS'}{$viewpay.smsCount}{else}0{/if} </td>
                                </tr>
                                {/if}
                                {if $viewpay.option eq 'BOTH' or $viewpay.option eq 'EMAIL'}
                                <tr>
                                    <td width="15%" align="right"><strong>Email Count :</strong></TD>
                                    <td>{if $viewpay.option eq 'BOTH' or $viewpay.option eq 'EMAIL'}{$viewpay.emailCount}{else}0{/if} </td>
                                </tr>
                                  {/if}
                                  {if $viewpay.option eq 'BOTH' or $viewpay.option eq 'SMS'}
                                <tr>
                                    <td width="15%" align="right"><strong>Cost Per SMS :</strong></TD>
                                    <td>{$viewpay.cost_per_sms} </td>
                                </tr>
                                  {/if}
                                   {if $viewpay.option eq 'BOTH' or $viewpay.option eq 'EMAIL'}
                                <tr>
                                    <td width="15%" align="right"><strong>Cost Per Email :</strong></TD>
                                    <td>{if $viewpay.option eq 'BOTH' or $viewpay.option eq 'EMAIL'}{$viewpay.emailCount}{else}0{/if} </td>
                                </tr>
                                {/if}
                                <tr>
                                    <td width="15%" align="right"><strong>Total Amount:</strong></TD>
                                    <td>{$viewpay.totalAmt} </td>
                                </tr>
                                 {if $viewpay.option eq 'BOTH' or $viewpay.option eq 'SMS'}
                                <tr>
                                    <td width="15%" align="right" valign="top"><strong>SMS Content:</strong></TD>
                                    <td>{$viewpay.smsContent} </td>
                                </tr>
                                  {/if}
                                {if $viewpay.option eq 'BOTH' or $viewpay.option eq 'EMAIL'}
                                <tr>
                                    <td width="15%" align="right" valign="top"><strong>Email Content:</strong></td>
                                    <td>{if $viewpay.option eq 'BOTH' or $viewpay.option eq 'EMAIL'}{$viewpay.emailContent|html_entity_decode}{else}0{/if} </td>
                                </tr>
                                {/if}
                                
                            </table>
                       </td>
                   </tr>
            </table>
    </div>
        <br> 
        <h3 class="fl"> Sms And Email Contact Information</h3> 
             <div class="holdthisTop"> 
                 <form name="frmAction" id="frmAction" method="post" action="">
                     <table width="100%" cellspacing="2" cellpadding="6" class="listtable">
                            <tr class="headbg">
                                <!--<td width="1%" align="left" valign="top"><input type="checkbox" id="checkall"/></td>-->
                                <td width="2%" align="left" valign="top"><strong>Sr.No.</strong></td>
                                <td width="25%" align="left" valign="top"><strong>Contact Number / Email</strong></td>
                            </tr>
                        {section name=i loop=$list}
                             <tr class="grayback"  id="tr_{$smarty.section.i.list}">
                                <td align="left" valign="top">{$smarty.section.i.iteration}</td>
                                <td align="left" valign="top">{if $list[i].contact_no}{$list[i].contact_no}{else}{$list[i].email_id}{/if} </td>
                            </tr>
                        {sectionelse}
                            <tr>
                                    <td colspan="2" class="error" align="center">No Records Found.</td>
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
                                    <td colspan="2" align="right">{$pgnation}</td>
                            </tr>
                    </table>
                </form>
            </div>
{include file=$footer}