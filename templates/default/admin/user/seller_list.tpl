{include file=$header1}

{strip}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}
{literal}
<script type="text/javascript">
function sort_all(s_name,s_type)
{
    var str_url = SITEROOT+"/admin/user/seller_list.php?sortby="+s_name+"&sorttype="+s_type;

//     var srch=document.getElementById('searchuser').value;
// 
//     if(srch)
//         str_url = str_url+"&searchuser="+srch;
    var pg=document.getElementById('pg').value;
    if(pg)
        str_url = str_url+"&page="+pg;

    window.location=str_url;
}
</script>
{/literal}
{include file=$header2}


<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Merchants List</div>
<br />
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle} Merchant</h3>
	  </div>
          <div class="clr">&nbsp;</div>

     	  {if $msg}<div align="center" id="msg" class="success">{$msg}</div>{/if}

	  <div class="fl width50">
	     <img src="{$siteimg}/icons/add.png" align="absmiddle" class="thickbox" /><a href="add_seller.php">Add New Merchant</a>
          </div>
  	</div>

	<div class="fr">
	   <form name="frmSearch" action="" method="get">
<input type="hidden" id="pg" name="pg" value="{if $smarty.get.page}{$smarty.get.page}{else}1{/if}">
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
	<img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/user/seller_list.php?view=excel"><strong>Merchant Info</strong></a>
	</div>

    <div id="UserListDiv" name="UserListDiv">
      <form name="frmAction" id="frmAction" method="post" action="">
	<table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
	    <tr class="headbg">			
		<td width="1%" align="center"><input type="checkbox" id="checkall"/></td>
		
		<td width="30%" align="left"><a href="javascript:void(0)" onclick="sort_all('business_name',document.getElementById('sorttype_name').value);">Business Name</a><input type="hidden" name="sorttype_name" id="sorttype_name" value="{if $sorttype_name}{$sorttype_name}{else}ASC{/if}"/></td>


		<td width="20%" align="left"><a href="javascript:void(0)" onclick="sort_all('email',document.getElementById('sorttype_email').value);">Email</a>
			 <input type="hidden" name="sorttype_email" id="sorttype_email" value="{if $sorttype_email}{$sorttype_email}{else}ASC{/if}"/></td>



		<td width="20%" align="left">Contact Person</td>
		
		<td width="20%" align="left">Category</td>

		<td width="20%" align="left">Total Deal Offers</td>

		<td width="20%" align="left">Total Deal Accepted</td>

		
		<!--<td width="10%" align="left"><a href="javascript:void(0)" onclick="sort_all('city_name',document.getElementById('sorttype_city').value);">City</a><input type="hidden" name="sorttype_city" id="sorttype_city" value="{if $sorttype_city}{$sorttype_city}{else}ASC{/if}"/></td>-->



		<td width="10%" align="left"><a href="javascript:void(0)" onclick="sort_all('signup_date',document.getElementById('sorttype_signup').value);">Date of Registration</a>
		<input type="hidden" name="sorttype_signup" id="sorttype_signup" value="{if $sorttype_signup}{$sorttype_signup}{else}ASC{/if}"/></td>


		<td width="10%" align="left"><a href="javascript:void(0)" onclick="sort_all('last_login',document.getElementById('sorttype_logout').value);">Last Login</a>
			<input type="hidden" name="sorttype_logout" id="sorttype_logout" value="{if $sorttype_logout}{$sorttype_logout}{else}ASC{/if}"/></td>
               	<td width="20%" align="center">Action</td>


	    </tr>
		{section name=i loop=$users}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
		  <td rowspan="2" valign="top"><input type="checkbox" value="{$users[i].userid}" name="userid[]" id="userid"/></td>

		  <td valign="top" rowspan="2">
		  <img src="{$siteimg}/icons/{if $users[i].status  eq 'inactive'}award_star_silver_1.png
		  {else}award_star_silver_2.png{/if}" align="absmiddle" />{$users[i].business_name}<span style="font-weight:bold"> 
					{if $users[i].isverified eq 'yes'}(v){else}(n/v){/if}
                   </td>


		  <td valign="top" rowspan="2">{$users[i].email}</td>
		
		<td valign="top" rowspan="2">{$users[i].contact_person}</td>
	
		<td valign="top" rowspan="2">{$users[i].category}</td>

		<td valign="top" rowspan="2">{$users[i].dealcnt}</td>

		<td valign="top" rowspan="2">{$users[i].dealncnt}</td>

<!--		  <td valign="top" rowspan="2">{$users[i].city_name|ucfirst}</td>-->

		  <td valign="top" rowspan="2">{$users[i].signup_date|date_format:$smarty_date_format}</td>

		  <td valign="top" rowspan="2">{if $users[i].last_login}{$users[i].last_login|date_format:$smarty_date_format}{else}-----{/if}</td>
	    
                 	       
			<td rowspan="2" align="left"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
		      <a href="seller_view.php?userid={$users[i].userid}" title="Show Merchant Details" target="_blank">
		      <strong>View</strong></a>&nbsp;|
			<br>
		{if $users[i].isverified eq 'yes'}
			<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
			<a href="{$siteroot}/admin/user/edit-seller.php?userid={$users[i].userid}" title="Edit Merchant Details" target="_blank"> <strong>Edit</strong></a>&nbsp;|
		{else}
			<a href="{$siteroot}/admin/user/seller_list.php?userid={$users[i].userid}&act=verify" style="text-decoration: none;">
			<img align="absmiddle" src="{$siteroot}/templates/default/images/icons/icons/add.png"/><strong>Verify Email</strong></a>&nbsp;|
		{/if}
        
			<br>
 {if $users[i].payment_verification==1  &&  $users[i].verification==0}&nbsp;&nbsp;<a href="seller_list.php?userid={$users[i].userid}&verifyPayment=yes"><strong style="color:#9BBB2B">Accept</strong></a>
 &nbsp;&nbsp;

<a style="color:#9BBB2B" href="reject-popup.php?id={$users[i].userid}&amp;placeValuesBeforeTB_=savedValues&amp;TB_iframe=true&amp;height=350&amp;width=600&amp;modal=false" class="thickbox" title="Reject Merchant" linkindex="2" set="yes"><strong>Reject</strong></a>
{/if}
	{if $users[i].isDeleted eq '1'}
			<a style="color:red" href="remove-account.php?id={$users[i].userid}&amp;placeValuesBeforeTB_=savedValues&amp;TB_iframe=true&amp;height=400&amp;width=600&amp;modal=false" class="thickbox" title="Remove Account" linkindex="2" set="yes"><strong>Account Delete Request</strong></a>
		  	{/if}
			
			<img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/user/seller_list.php?view=excel&exel_id={$users[i].userid}"><strong>Merchant Info</strong></a>&nbsp;|
			<br>
 
		  </td>
		</tr>
		<tr>
			<td colspan="7" align="center"><b><!--Seller Unique URL :--> </b>
				
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
			<option value="verify">Verify</option>
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
