{include file=$header1}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/user/users_list.php"> Consumer List</a>
 &gt; Consumer Information</div>
 <br/>

<h3>{if $smarty.get.userid eq 1}Admin{else}Consumer{/if} information</h3>

<div class="holdthisTop">
      <span style="float:right;"> <h3> {if $smarty.get.userid eq 1}<a href="{$siteroot}/admin/user/manage_admin.php">Back{else}<a href="{$siteroot}/admin/user/users_list.php">Back {/if}</a><!--| <a href="{$siteroot}/admin/user/user_information.php?userid={$smarty.get.userid}">Edit</a>--></h3> </span>
      {if $smarty.get.userid eq 1}
      <table width="100%" cellpadding="5" cellspacing="5" class="conttableDkBg conttable">
		 
          <tr><td width="25%" align="right"><strong>First Name: </strong></td><td  align="left"> {$user.first_name|@ucfirst} </td></tr>
          <tr><td width="25%" align="right"><strong>Last Name: </strong></td><td  align="left"> {$user.last_name|@ucfirst} </td></tr>
          <tr><td align="right"><strong>Registered Date: </strong></td><td align="left">{$user.signup_date|date_format:$smarty_date_format}</td></tr>
          <tr><td align="right"><strong>Email Address:</strong> </td><TD  align="left">{$user.email}</td> </tr>
          <tr> <td   valign="top" align="right"><strong>City:</strong></td><td align="left" >{$user.city}</td></tr>
           </table> 
      {else}
      <table width="100%" cellpadding="2" cellspacing="2" border="0" class="conttableDkBg conttable">
      <tr>
	<td valign="top"><img src="{if $user.photo neq ''}{$siteroot}/uploads/user/{$user.photo}{else}{$siteroot}/templates/default/images/profile_pic.png{/if}" height="125px" width="100px" align="top"></td>
      <td>
        <table width="100%" cellpadding="5" cellspacing="5" border="0">
        <tr><td  align="right" ><strong>Member Type:</strong> </td><TD  align="left"> {if $user.usertypeid eq 2}Consumer{/if}</td></tr>

		 {if $user.usertypeid eq 2}
		 <tr><td width="25%" align="right"><strong>Gender: </strong></td><td  align="left"> {$user.gender|@ucfirst} </td></tr>
		{/if}

          <tr><td width="25%" align="right"><strong>Username: </strong></td><TD  align="left"> {$user.username}</td></tr>
          <tr><td width="25%" align="right"><strong>Full Name:</strong> </td><td  align="left"> {$user.first_name|@ucfirst}&nbsp;{$user.last_name|@ucfirst}</td></tr>

 {if $user.usertypeid eq 2}
			<tr><td width="25%" align="right"><strong>Relationship status: </strong></td><TD  align="left"> {$user.rel_status}</td></tr>
			<tr><td width="25%" align="right"><strong>Birthdate: </strong></td><TD  align="left"> {$bd}{*$user.birthdate*}</td></tr>
			<!--<tr><td width="25%" align="right"><strong>Category Preferance: </strong></td><TD  align="left"> {$user.category_preferance}</td></tr>-->
  {/if}

          <tr><td align="right"><strong>Email Address: </strong></td><TD  align="left">{$user.email}</td> </tr>
          <!--<tr><td width="25%" align="right"  valign="top"><strong>Address: </strong></td><TD  align="left"> {$user.address1}<br/>{$user.address2}</td></tr>-->
	 <!-- <tr><td align="right"><strong>Country: </strong></td><TD  align="left">{if $user.country}{$user.country|ucfirst}{else}-----{/if}</td> </tr>-->
	  <!--<tr><td align="right"><strong>County State:</strong></td><TD  align="left">{if $user.state_name}{$user.state_name|ucfirst}{else}-----{/if}</td> </tr>-->
          <tr><td align="right"><strong>City Town: </strong></td><TD  align="left">{if $user.city_name|ucfirst}{$user.city_name|ucfirst}{else}-----{/if}</td> </tr>
 
 {if $user.usertypeid eq 2}

			<!--<tr><td width="25%" align="right"><strong>Category Preferance: </strong></td><TD  align="left"> {$user.category_preferance}</td></tr>-->
			<!--<tr><td width="25%" align="right"><strong>Intrested In: </strong></td><TD  align="left"> {$user.intrested_in}</td></tr>-->

			{if $user.college neq ''}
			<tr><td width="25%" align="right"><strong>College: </strong></td><TD  align="left"> {$user.college}</td></tr>
			{/if}

			{if $user.movies neq ''}
			<tr><td width="25%" align="right"><strong>Movies: </strong></td><TD  align="left"> {$user.movies}</td></tr>
			{/if}

			{if $user.music neq ''}
			<tr><td width="25%" align="right"><strong>Music: </strong></td><TD  align="left"> {$user.music}</td></tr>
			{/if}


			{if $user.books neq ''}
			<tr><td width="25%" align="right"><strong>Books: </strong></td><TD  align="left"> {$user.books}</td></tr>
			{/if}

			{if $user.tv neq ''}
			<tr><td width="25%" align="right"><strong>TV: </strong></td><TD  align="left"> {$user.tv}</td></tr>
			{/if}

			{if $user.activities neq ''}
			<tr><td width="25%" align="right"><strong>Activities: </strong></td><TD  align="left"> {$user.activities}</td></tr>
			{/if}


{/if}



         
         <!--<tr><td align="right"><strong>Contact No: </strong></td><TD  align="left">{if $user.contact_detail}{$user.contact_detail}{else}-----{/if}</td> </tr>-->
          
          <tr><td align="right"><strong>Registered Date:</strong> </td> <td align="left">{$user.signup_date|date_format:$smarty_date_format}</td></tr>
<!--          <tr><td align="right"><strong>IP Address:</strong> </td> <td align="left">{$user.ip}</td></tr>
          <tr><td align="right"><strong>Last Login:</strong> </td> <td align="left">{$user.last_login|date_format:$smarty_date_format} </td></tr>-->
         
        </table>
      </td>
      <td width="250" align="left" valign="top">
      <table>
      <tr><td height="25"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="seller_photo_list.php?userid={$smarty.get.userid}" title="Show Seller Details">
		     		 <strong>View Photo Album</strong></a></td></tr>
<tr><td height="25"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="{$siteroot}/admin/friend/friend_list.php?userid={$smarty.get.userid}" title="Show Seller Details">
		     		 <strong>View {$user.first_name|@ucfirst}'s Friends</strong></a></td></tr>
<tr><td height="25"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="{$siteroot}/admin/friend/fan.php?userid={$smarty.get.userid}" title="Show Seller Details">
		     		 <strong>View {$user.first_name|@ucfirst} Fan Of</strong></a></td></tr>
<tr><td height="25"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="view_voucher.php?userid={$smarty.get.userid}" title="Show Seller Details">
		     		 <strong>View Coupons</strong></a></td></tr>
<tr><td height="25"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="view_review_consumer.php?userid={$smarty.get.userid}" title="Show Seller Details">
		     		 <strong>View Review</strong></a></td></tr>
<tr><td height="25"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="view_deal_bought_consumer.php?userid={$smarty.get.userid}" title="Show Seller Details">
		     		 <strong>View Deal Bought By
{$user.first_name|@ucfirst}</strong></a></td></tr>
<tr><td height="25"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />  <a href="view_deal_offered_consumer.php?userid={$smarty.get.userid}" title="Show Seller Details">
		     		 <strong>View Deal Offered By
{$user.first_name|@ucfirst} </strong></a></td></tr>
      </table>
      
      </td>
      </tr>

      </table> 
      {/if}
  </div>
{include file=$footer}
