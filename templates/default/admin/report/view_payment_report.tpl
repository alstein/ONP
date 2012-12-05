{include file=$header1}
{include file=$header2}

    <div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/report/payment_report.php">
        Payment Report</a> &gt; View Payment Report
    </div>
        <br />
            <h3>View Payment Report List</h3>
    <div class="holdthisTop">
            <span style="float:right;"> 
                <h3>
                    <a href="{$siteroot}/admin/report/payment_report.php">Back</a>
                </h3> 
            </span>
         <table width="100%" cellpadding="2" cellspacing="2" border="0">
                    <tr>
                        <td>
                            <table width="100%" cellpadding="2" cellspacing="2" border="0" class="conttable">
                                <tr>
                                    <td colspan="2" align="left"><h2>User Information</h2></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="left">
                                        <p>------------------------------------------------------------------------------</p>
                                    </td>
                                </tr> 
                                <tr>
                                    <td width="15%" align="right"><strong>User Name :</strong> </td>
                                    <td>{$viewpay.first_name|@ucfirst}&nbsp;{$viewpay.last_name|@ucfirst}</td></tr>
                                <tr>
                                    <td width="15%" align="right"><strong>Subscription Date :</strong></TD>
                                    <td>{$viewpay.signup_date|date_format:"%d-%m-%Y"} </td>
                                </tr>
                                <tr>
                                    <td width="15%" align="right"><strong>Expiration Date :</strong> </td>
                                    <td>{if $viewpay.last_expiration_date}{$viewpay.last_expiration_date|date_format:"%d-%m-%Y"}{else}-----{/if} </td>
                                </tr>
                                 <tr>
                                    <td width="20%" align="right"><strong>Current Subscription Status :</strong> </td>
                                    <td>{if $viewpay.subscribe_status eq 'Expired'}Deleted{else}{$viewpay.subscribe_status}{/if} </td>
                                </tr>
                                <tr>
                                    <td width="15%" align="right"><strong>Total Payment :</strong> </td>
                                    <td>{if $viewpay.totalpay neq ''}${$viewpay.totalpay}{/if} </td>
                                </tr>  
                            </table>
                       </td>
                   </tr>
            </table>
    </div>
        <br> 
        <h3 class="fl">Detail Payment Report</h3> 
             <div class="holdthisTop"> 
                 <form name="frmAction" id="frmAction" method="post" action="">
                     <table width="100%" cellspacing="2" cellpadding="6" class="listtable">
                            <tr class="headbg">
                                <!--<td width="1%" align="left" valign="top"><input type="checkbox" id="checkall"/></td>-->
                                <td width="2%" align="left" valign="top"><strong>Sr.No.</strong></td>
                                <td width="25%" align="left" valign="top"><strong>Billign Address</strong></td>
                                <td width="10%" align="left" valign="top"><strong>Package Name</strong></td>
                                <td width="15%" align="left" valign="top"><strong>Type of Package<br>No. # deals per month</strong></td>
                                <td width="10%" align="left" valign="top"><strong>Duration</strong></td>
                                <td width="12%" align="left" valign="top"><strong>Pay Date</strong></td>
                                <td width="17%" align="left" valign="top"><strong>Next Payment Due Date</strong></td>
                                <td width="28%" align="left" valign="top">Pay Price</td>
                            </tr>
                        {section name=i loop=$pay_list}
                            <tr class="grayback"  id="tr_{$smarty.section.i.list}">
                                <!--<td align="left" valign="top"><input name="log[]" id="log[]" value="{$list[i].id}" type="checkbox" /> </td>-->
                                <td align="left" valign="top">{$smarty.section.i.iteration}</td>
                                <td align="left" valign="top">
                                    <div style="height:25px;">
                                                            {$pay_list[i].payer_first_name|@ucfirst}&nbsp;{$pay_list[i].payer_last_name|@ucfirst}
                                    </div>
                                    <div style="height:25px;">{$pay_list[i].payer_address_city}, {$pay_list[i].payer_address_state}, {$pay_list[i].payer_address_country}, {$pay_list[i].payer_address_zip}
                                    </div>
                                </td>
                                 <td align="left" valign="top">{$pay_list[i].subs_pack_name}</td>
                                 <td align="left" valign="top">{$pay_list[i].subs_pack_allow_deals_per_month}</td>
                                 <td align="left" valign="top">{$pay_list[i].subs_pack_duration}</td>
                                <td align="left" valign="top">{$pay_list[i].subscription_date|date_format:"%d-%m-%Y"}</td>
                                <td align="left" valign="top">{$pay_list[i].expiration_date|date_format:"%d-%m-%Y"}</td>
                                <td align="left" valign="top">{if $pay_list[i].totalpay neq ''}${$pay_list[i].totalpay}{/if}</td>
                            </tr>
                        {sectionelse}
                            <tr>
                                    <td colspan="8" class="error" align="center">No Records Found.</td>
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
                                    <td colspan="8" align="right">{$pgnation}</td>
                            </tr>
                    </table>
                </form>
            </div>
    

{include file=$footer}