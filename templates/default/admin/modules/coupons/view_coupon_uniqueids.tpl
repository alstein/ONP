
{include file=$header1}
{include file=$header2}

    <div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;
     <a href="{$siteroot}/admin/modules/coupons/generate_coupons_list.php">
        Promotional Code List</a> &gt; View Promotional Code Information
    </div>
        <br />
            <h3>View Promotional Code List</h3>
    <div class="holdthisTop">
            <span style="float:right;"> 
                <h3>
                    <a href="{$siteroot}/admin/modules/coupons/generate_coupons_list.php">Back</a>
                </h3> 
            </span>
         <table width="100%" cellpadding="2" cellspacing="2" border="0">
                    <tr>
                        <td>
                            <table width="100%" cellpadding="2" cellspacing="2" border="0" class="conttable">
                                <tr>
                                    <td colspan="2" align="left"><h2> View Promotional Code Information </h2></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="left">
                                        <p>------------------------------------------------------------------------------</p>
                                    </td>
                                </tr> 
                                <tr> 
                                    <td width="20%" align="right" valign="top"><strong>Amount as Promotional Code</strong>:</td> 
                                     <td align="left" width="40%">&nbsp;</td>
                                    </tr>
                                <tr>
                                    <td width="20%" align="right"><strong> Pound (&#163;):</strong> </td>
                                    <td>{$coupondet.credit_amount_pound}</td>
                                </tr>
                                <tr>
                                    <td width="20%" align="right"><strong> Euro (&#8364;):</strong> </td>
                                    <td>{$coupondet.credit_amount_euro}</td>
                                </tr>
                                <tr>
                                    <td width="20%" align="right"><strong> Dollar ($):</strong> </td>
                                    <td>{$coupondet.credit_amount_dollar}</td>
                                </tr>
                                <tr>
                                    <td width="20%" align="right"><strong>Number of Promotional Code :</strong> </TD>
                                    <td>{$coupondet.no_of_coupons} </td>
                                </tr>
                                
                                <tr>
                                    <td width="15%" align="right"><strong>Expiration Date :</strong> </td>
                                    <td>{$coupondet.expire_date|date_format:$smarty_date_format} </td>
                                </tr>
                            </table>
                       </td>
                   </tr>
            </table>
    </div>
        <br> 
        <h3 class="fl">Unique Promotional Code Information</h3> 
             <div class="holdthisTop"> 
               
                 <form name="frmAction" id="frmAction" method="post" action="">
                     <table width="100%" cellspacing="2" cellpadding="6" class="listtable">
                                <tr>
                                    <td align="right" colspan="3">
                                         <img src="{$siteimg}/icons/excel.gif" align="top"> <a href="{$siteroot}/admin/modules/coupons/export_coupon_uniqueids.php?view=excel&coupon_id={$smarty.get.coupon_id}">Download Excel</a>
                                    </td>
                                </tr>
                                <tr class='headbg' align="center">
                                    <td width="1%" align="center">Sr.No</td>
                                    <td width="*%" align="left">Unique Promotional Code</td>
                                    <td width="15%" align="left">Used/Not Used</td>
	                       </tr> 
                        {section name=i loop=$uniquecoupondet }
                                <tr class="grayback" id="tr_{$uniquecoupondet[i].uniqueid}"> 
                                            <td align="center">{$smarty.section.i.iteration}</td>
                                            <td align="left">{$uniquecoupondet[i].coupon_unique_id}</td> 
                                            <td align="left">{if $uniquecoupondet[i].used eq 1} Used {else} Not Used {/if}</td>
                                </tr>
                        {sectionelse}
                                <tr>
                                        <td colspan="3" class="error" align="center">No Records Found.</td>
                                </tr>
                        {/section}
                                <tr>{if $uniquecoupondet}
                                        <!--<td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                                        <td align="left"><select name="action" id="action">
                                            <option value="">--Action--</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                        <input type="submit" name="submit" id="submit" value="Go" />
                                        <span id="acterr" class="error"></span></td>-->
                                        <td colspan="3" align="right">  {if $showpgnation eq "yes"}{$pgnation}{/if}</td>
                                        {/if}
                                </tr>
                    </table>
                </form>
            </div>
    

{include file=$footer}