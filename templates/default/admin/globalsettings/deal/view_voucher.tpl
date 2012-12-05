{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}
{literal}
<script type="text/javascript">
// function openPDF(val)
// {
// 		window.open(SITEROOT+'/admin/globalsettings/deal/voucher_pdf.php?id='+val,'PrintDocument','scrollbars=yes, resizable=yes, copyhistory=yes, width=800, height=600, left=300, top=250');
// 		window.location.reload();
// }
function openPDF(val)
{
      window.open(SITEROOT+'/admin/user/deal_pdf.php?id='+val,'PrintDocument','scrollbars=yes, resizable=yes, copyhistory=yes, width=800, height=600, left=300, top=250');
      window.location.reload();
}
</script>
{/literal}
{include file=$header2}


<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; View Voucher</br>
<span class="fr"><a href="view_product.php?id1={$smarty.get.deal_id}&type={$smarty.get.type}&act={$smarty.get.act}"><strong>Back</strong></a></span>
</div>
<br />
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle} Merchant Vouchers</h3>
	  </div>
          <div class="clr">&nbsp;</div>

     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}

	  <!--<div class="fr width50">
	     <a href="merchantmyvouchers.php">Back</a>
          </div>-->
  	</div>

	<div class="fr">
	   <form name="frmSearch" action="" method="get">
		  <table width="50%" align="right" cellpadding="0" cellspacing="0" border="0">
		    <tr>
		      <td align="right">
			<label>
			    <input name="searchuser" type="text" id="searchuser" value="{$smarty.get.searchuser}" size="35" class="search"/> 
				<input name="deal_id" type="hidden" id="deal_id" value="{$smarty.get.deal_id}" size="35" class="search"/> 
				<input name="pay_id" type="hidden" id="pay_id" value="{$smarty.get.pay_id}" size="35" class="search"/> 
			</label>
		      </td>
		      <td width="20%" align="left">
			<input type="submit" name="button" id="button" value="Search" class="searchbutton" />
		    </td>
		  </tr>
	      </table>
	    </form>
      </div>

      <div class="clr">&nbsp;
	<!--<img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/user/seller_list.php?view=excel"><strong>Merchant Info</strong></a>-->
	</div>

    <div id="UserListDiv" name="UserListDiv">
      <form name="frmAction" id="frmAction" method="post" action="">
	<table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
	    <tr class="headbg">			
		
		<td width="20%" align="left">Voucher No.</td>
		<td width="30%" align="left">Name Of Buyer</td>
		<td width="20%" align="left">Voucher Code</td>
		<td width="30%" align="center">Voucher</td>
	    </tr>
		{section name=i loop=$view_voucher}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
		  <td valign="top">
                      Voucher no.{$view_voucher[i].uniqueid} 
		  </td>
 		<td valign="top">{$view_voucher[i].fullname}</td>
		<td valign="top">{$view_voucher[i].coupon_id}</td>
		<td> <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
<!-- href="javascript:openPDF({$view_voucher[i].uniqueid});" -->
		<a href="javascript:void(0);" onclick="javscript:openPDF({$view_voucher[i].uniqueid})" ><strong>View Voucher</strong></a>
		</td>
		</tr>
		{sectionelse}
		    <tr><td colspan="4" class="error" align="center">No Records Found.</td></tr>
		{/section}			
		{if $view_voucher}
		<tr>
<!-- 		    <td align="left"> <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td> -->
		    <!--<td align="left" colspan="3">
			<select name="action" id="action">
			  <option value="">Action</option>
			  <option value="Active">Active</option>
			  <option value="inactivate">Inactive</option>
			  <option value="delete">Delete</option>
			</select>
			<input type="submit" name="submit" id="submit" value="Go"  />
		        <div id="acterr" class="error"></div>
		    </td>-->
		    <td align="right" colspan="3">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
		</tr>
		{/if}
	</table>
      </form>
  </div>
</div>
{include file=$footer}
