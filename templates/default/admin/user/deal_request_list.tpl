{include file=$header1}

{strip}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}
{include file=$header2}


<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Sellers List</div>
<br />
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle} Sellers</h3>
	  </div>
          <div class="clr">&nbsp;</div>

     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}

	  <div class="fl width50">
	     <img src="{$siteimg}/icons/add.png" align="absmiddle" class="thickbox" /><a href="add_seller.php">Add New Seller</a>
          </div>
  	</div>

	<div class="fr">
	   <form name="frmSearch" action="" method="get">
		  <table width="50%" align="right" cellpadding="0" cellspacing="0" border="0">
		    <tr>
		      <td align="right">
			<label>
			    <input name="searchuser" type="text" id="searchuser" value="{$smarty.get.searchuser}" size="35" class="search"/> 
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
	<img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/user/seller_list.php?view=excel"><strong>Seller Info</strong></a>
	</div>

    <div id="UserListDiv" name="UserListDiv">
      <form name="frmAction" id="frmAction" method="post" action="">
	<table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
	    <tr class="headbg">			
		<td width="1%" align="center"><input type="checkbox" id="checkall"/></td>
		<td width="10%" align="left">A/C No &amp; Name</td>
		<td width="10%" align="left">Full Name</td>
		<td width="10%" align="left">Email</td>
		<!--<td width="4%" align="left">Membership</td>-->
		<td width="10%" align="left">City</td>
		<td width="5%" align="left">Postcode</td> 
		<td width="7%" align="left">Date of Registration</td>
		<td width="8%" align="left">Last Login</td>
                <!--<td width="4%" align="left">Paid</td>-->
                <td width="7%" align="left" valign="top">Package Name</td>
                <td width="5%" align="left" valign="top">Subscription Status</td>
                <td width="9%" align="left" valign="top">Added By</td>
		<td width="40%" align="center">Action</td>
	    </tr>
		{section name=i loop=$users}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
		  <td rowspan="2" valign="top"><input type="checkbox" value="{$users[i].userid}" name="userid[]"/></td>
		  <td rowspan="2" valign="top">#{$users[i].userid}<br>{$users[i].username}</td>
		  <!--<td valign="top">
                      <img src="{$siteimg}/icons/{if $users[i].status  eq 'inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />
                      <a href="seller_view.php?userid={$users[i].userid}" title="Show User Details">{$users[i].username}</a>
                   <br><span>
		  </td>-->
		  <td valign="top">
		  <img src="{$siteimg}/icons/{if $users[i].status  eq 'inactive'}award_star_silver_1.png
		  {else}award_star_silver_2.png{/if}" align="absmiddle" />{$users[i].first_name}&nbsp;{$users[i].last_name}
                   </td>
		  <td valign="top">{$users[i].email}</td>
		 <!-- <td valign="top" align="center">{$users[i].company_type}</td>-->
		  <td valign="top">{$users[i].city|ucfirst}</td>
		  <td valign="top">{$users[i].postalcode}</td>
		  <td valign="top">{$users[i].signup_date|date_format:$smarty_date_format}</td>
		  <td valign="top">{if $users[i].last_login}{$users[i].last_login|date_format:$smarty_date_format}{else}-----{/if}</td>
	          <!--<td valign="top" align="center">{ if $users[i].payment_verification==1}Yes{else}No{/if}</td>-->
                  <td valign="top" align="center">{if $users[i].pack_name}{$users[i].pack_name}{else}-----{/if}</td>
	          <td rowspan="2" valign="top">{if $users[i].subscribe_status eq 'Expired'}Deleted{else}{$users[i].subscribe_status}{/if}</td>
	          <td rowspan="2" align="left" valign="top">{if $users[i].ad_userid eq $users[i].userid}(self){else}
	                                              {$users[i].ad_name}<br/>
							({$users[i].userType}){/if}
                                 <!--<a href="{$siteroot}/admin/user/ad-user-info.php?userid={$deal[i].admin_userid}">( userType )</a>-->
			</td>
			<td rowspan="2" align="left"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
		      <a href="seller_view.php?userid={$users[i].userid}" title="Show Seller Details">
		      <strong>View</strong></a>&nbsp;|<!--<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
		      <a href="edit-seller.php?userid={$users[i].userid}" title="Edit User Details"><strong>Edit</strong></a>-->
		      
		     <!-- <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
		      <a href="edit-seller.php?userid={$users[i].userid}" title="Edit Seller Details"> <strong>Edit</strong></a>-->
			<br>
		{if $users[i].isverified eq 'yes'}
			<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
			<a href="edit-seller.php?userid={$users[i].userid}" title="Edit Seller Details"> <strong>Edit</strong></a>&nbsp;|
		{else}
			<a href="{$siteroot}/admin/user/seller_list.php?userid={$users[i].userid}&act=verify" style="text-decoration: none;">
			<img align="absmiddle" src="{$siteroot}/templates/default/images/icons/icons/add.png"/><strong>Verify Email</strong></a>&nbsp;|
		{/if}
                    <!--<br>
                     {*if $users[i].verification==0}&nbsp;&nbsp;<a href="seller_list.php?userid={$users[i].userid}&payment=yes"><strong style="color:#9BBB2B">Verify Direct</strong></a>{/if*}-->
			<br>
 {if $users[i].payment_verification==1  &&  $users[i].verification==0}&nbsp;&nbsp;<a href="seller_list.php?userid={$users[i].userid}&verifyPayment=yes"><strong style="color:#9BBB2B">Accept</strong></a>
 &nbsp;&nbsp;
<!-- 
<a href="seller_list.php?userid={$users[i].userid}&verifyPayment=reject"><strong style="color:#9BBB2B">Reject</strong></a> -->

<a style="color:#9BBB2B" href="reject-popup.php?id={$users[i].userid}&amp;placeValuesBeforeTB_=savedValues&amp;TB_iframe=true&amp;height=350&amp;width=600&amp;modal=false" class="thickbox" title="Reject Seller" linkindex="2" set="yes"><strong>Reject</strong></a>
{/if}
	{if $users[i].isDeleted eq '1'}
			<a style="color:red" href="remove-account.php?id={$users[i].userid}&amp;placeValuesBeforeTB_=savedValues&amp;TB_iframe=true&amp;height=400&amp;width=600&amp;modal=false" class="thickbox" title="Remove Account" linkindex="2" set="yes"><strong>Account Delete Request</strong></a>
		  	{/if}
			
			<img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/user/seller_list.php?view=excel&exel_id={$users[i].userid}"><strong>Seller Info</strong></a>&nbsp;|
			<br>
                     <!-- <a href="{$siteroot}/admin/user/manage_other_details.php?userid={$users[i].userid}" style="text-decoration: none; font-size:11px;"><strong>Manage Other Details</strong></a>-->

		  </td>
		</tr>
		<tr>
			<td colspan="7" align="center"><b><!--Seller Unique URL :--> </b>
				<!--<a style="color:blue" href="{$siteroot}/seller/{$users[i].username}/{$users[i].userid}" target="_blank">{$siteroot}/seller/{$users[i].username}/{$users[i].userid}</a>-->
			</td>
		</tr>
		{sectionelse}
		    <tr><td colspan="12" class="error" align="center">No Records Found.</td></tr>
		{/section}
		{if $users}
		<tr>
		    <td align="left"> <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
		    <td align="left" colspan="3">
			<select name="action" id="action">
			  <option value="">--Action--</option>
			  <option value="Active">Active</option>
			  <option value="inactivate">Inactive</option>
			  <option value="delete">Delete</option>
			</select>
			<input type="submit" name="submit" id="submit" value="Go"/>
		        <div id="acterr" class="error"></div>
		    </td>
		    <td align="right" colspan="9">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
		</tr>
		{/if}
	</table>
      </form>
  </div>
</div>
{include file=$footer}
