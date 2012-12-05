{include file=$header1}

{strip}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}
{include file=$header2}


<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Offer Deal Eligibility Request List</div>
<br />
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle} Offer Deal Eligibility Request </h3>
	  </div>
          <div class="clr">&nbsp;</div>

     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}

	  <div class="fl width50">
	     
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
	
	</div>

    <div id="UserListDiv" name="UserListDiv">
      <form name="frmAction" id="frmAction" method="post" action="">
	<table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
	    <tr class="headbg">			
		<!--<td width="1%" align="center"><input type="checkbox" id="checkall"/></td>-->
		<td width="15%" align="left">A/C No &amp; Name</td>
		<td width="15%" align="left">Full Name</td>
		<td width="10%" align="left">Email</td>
		<!--<td width="4%" align="left">Membership</td>-->
		<td width="10%" align="left">City</td>
		<td width="7%" align="left">Date of Registration</td>
		<td width="17%" align="left">Offer Request Status</td>
		<td width="20%" align="center">Action</td>
	    </tr>
		{section name=i loop=$users}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
	<!--	  <td rowspan="2" valign="top"><input type="checkbox" value="{$users[i].userid}" name="userid[]"/></td>-->
		  <td rowspan="2" valign="top">#{$users[i].userid}<br>{$users[i].username}</td>
		  <!--<td valign="top">
                      <img src="{$siteimg}/icons/{if $users[i].status  eq 'inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />
                      <a href="seller_view.php?userid={$users[i].userid}" title="Show User Details">{$users[i].username}</a>
                   <br><span>
		  </td>-->
		  <td valign="top" rowspan="2">
		  {$users[i].first_name}&nbsp;{$users[i].last_name}
                   </td>
		  <td valign="top" rowspan="2">{$users[i].email}</td>
		 <!-- <td valign="top" align="center">{$users[i].company_type}</td>-->
		  <td valign="top" rowspan="2">{$users[i].city|ucfirst}</td>
		   <td valign="top" rowspan="2">{$users[i].signup_date|date_format:$smarty_date_format}</td>
		 <td valign="top" rowspan="2">{if $users[i].offer_deal eq 'no'}  Request Pending {else}  Request Approved {/if}</td>
		<td rowspan="2" align="left">{if $users[i].offer_deal eq 'no'}
<a href="{$siteroot}/admin/user/offer_deal_request.php?id={$users[i].userid}&status=yes" style="text-decoration:none;"><strong>Approve Offer Request</strong></a>{else}<strong>Approved</strong>{/if}
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
		    <td align="left"></td>
		    <td align="left" colspan="3">
			
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
