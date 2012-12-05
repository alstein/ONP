{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>

<script language="JavaScript1.2">var thisFormName  = "frmAction";</script>
<script type="text/javascript" src="{$siteroot}/js/admin_check_uncheck_action.js"></script>

{include file=$header2}
    <div class="breadcrumb">
        <a href="{$siteroot}/admin/index.php">Home</a> &gt; Promotional Code List
    </div>
    <br />
    <div align="center" id="msg">{$msg}</div>
    <div class="holdthisTop">
	    <h3 class="fl width20" style="width:24%;">&nbsp;Generate Promotional Code List</h3>
            <p align="right"><img src="{$siteimg}/icons/add.png" align="absmiddle"/>
                <a href="edit_generate_coupons.php">Add New Promotional Code</a>
            </p>
            <p>&nbsp;</p>
            <br clear="all">
    </div>
<div class="holdthisTop">
  <form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
    <table width="100%" cellspacing="2" cellpadding="6" class="listtable">
        <tr class="headbg">
                <td width="1%" rowspan="2" valign="top"><input type="checkbox" id="checkall" /></td>
                <td width="30%" align="center" colspan="3">Amount as Promotional Code</td>
                <td width="20%" rowspan="2" valign="top">Number of Promotional Code</td>
                <td width="10%" rowspan="2" valign="top">Expiration Date</td>
                <td align="left" width="10%" rowspan="2" valign="top">Action</td>
        </tr>
        <tr class="headbg">
                <td>Pound (&#163;)</td>
                <td>Euro (&#8364;)</td>
                <td>Dollar ($)</td>
        </tr> 

      {section name=i loop=$coupondet}
             <tr class="grayback" id="tr_{$smarty.section.i.iteration}">
                <td><input type="checkbox" name="coupon_id[]" value="{$coupondet[i].coupon_id}"
                     onclick="javascript:uncheckMainCheckbox();" />
                </td>
                <td>{$coupondet[i].credit_amount_pound}</td>
                <td>{$coupondet[i].credit_amount_euro}</td>
                <td>{$coupondet[i].credit_amount_dollar}</td>
                <td>{$coupondet[i].no_of_coupons}</td>
                <td>{$coupondet[i].expire_date|date_format:$smarty_date_format}</td>
                <!-- <td>{*if $coupondet[i].restrictions eq 'all_user'}All Users{else}New Users{/if*}</td>-->
                <td><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /> <a href="{$siteroot}/admin/modules/coupons/view_coupon_uniqueids.php?coupon_id={$coupondet[i].coupon_id}" class="admintxt"><strong>View</strong></a>&nbsp;</td>
             </tr>
      {sectionelse}
             <tr>
                <td colspan="6" class="error" align="center">No Records Found.</td>
            </tr>
      {/section}
            <tr>
                 <td colspan="6">
			    <div class="fl width50">
				  <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif" />
				  <select name="action" id="action">
					  <option value="">--Action--</option>
					  <option value="delete">Delete</option>
				  </select>
				  <input type="submit" name="submit" id="submit" value="Go" />
          		          <span id="acterr" class="error"></span>
			    </div>
			  <div class="ar fr width50">
				  {$pgnation}
			  </div>
			  <div class="clr"></div>
                </td>
            </tr>
    </table>
  </form>
</div>
{include file=$footer}