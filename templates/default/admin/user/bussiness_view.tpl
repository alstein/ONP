{include file=$header1}
  <!--Header End here -->
{include file=$header2}
<!--<div class="breadcrumb">
  <a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/user/bussiness_list.php"> Business List</a> &gt; Business Details
</div>-->
<div class="clr">&nbsp;</div> 
<div class="holdthisTop">	
<table width="100%" border="0" ><TR><TD align="right"><A href="javascript:history.go(-1);">Back&nbsp;&nbsp;&nbsp;</A></TD></TR></table>
  <table width="97%" border="0" align="center" class="conttableDkBg conttable"> 
    <tr>
        <td>
	
        <form action="" method="POST" name="bus_form" id="bus_form">
	
        <input type="hidden" name="busid" id="busid" value="{$smarty.get.business_id}">
        <table width="70%" align="center" border="0">
            <tr><td colspan="2" align="right"><span align="right"> <a href="bussiness_information.php?business_id={$row.business_id}" title="Show Bussiness Details"><strong>Edit </strong></a>| <a href="../sitemodules/deal/manage_offer.php?bus_id={$row.business_id}"><strong>User Offers</strong></a></span></td></tr>
            <tr><td colspan="2"><h2>Business Information</h2></td></tr>
            <tr><td colspan="2" height="5"></td></tr>
            <tr>
                <td valign="top" width="30%"><strong>Business Name:</strong></td>
                <td align="left"  width="70%">{$row.name}</td>
            </tr>	
	    <tr>
                <td valign="top" width="30%"><strong>Date Of Approval:</strong></td>
                <td align="left"  width="70%">{$row.date_of_approval|date_format}</td>
            </tr>
            <tr>
                <td   valign="top"><strong>Webside URL:</strong></td>
                <td align="left" >{$row.website}</td>
            </tr>
            <tr>
                <td   valign="top"><strong>Category:</strong></td>
                <td align="left" >{$row.category}</td>
            </tr>
            <tr>
                <td   valign="top"><strong>Telephone No:</strong></td>
                <td align="left" >{$row.area_code}-{$row.phone}</td>
            </tr>
            <tr>
                <td   valign="top"><strong>Address:</strong></td>
                <td align="left" >{$row.address}</td>
            </tr>
            <tr>
                <td   valign="top"><strong>City:</strong></td>
                <td align="left" >{$row.city}</td>
            </tr>
            <tr>
                <td   valign="top"><strong>State:</strong></td>
                <td align="left" >{$row.state}</td>
            </tr>
            <tr>
                <td   valign="top"><strong>Zip Code:</strong></td>
                <td align="left" >{$row.zip}</td>
            </tr>
            <tr>
                <td  valign="top"><strong>Bussiness Picture:</strong></td>
                <td><img src="{$siteroot}/uploads/bussiness_photo/thumbnail/{$row.bussiness_picture}"  class="BrdGrey1"  width="200px" height="200px"/></td>
            </tr>
            <tr>
                <td valign="top"><strong>Bussiness Logo:</strong></td>
                <td><img src="{$siteroot}/uploads/bussiness_photo/logo/thumbnail/{$row.logo}"  class="BrdGrey1" /></td>
            </tr>
            <tr><td colspan="2" height="20">&nbsp;</td></tr>
            <tr><td colspan="2" align="left"> <h2>Contact Information</h2> </td></tr>
            <tr><td colspan="2" height="5"></td></tr>
            <tr>
                <td   valign="top"><strong>First Name:</strong></td>
                <td align="left" >{$row.first_name}</td>
            </tr>	
            <tr>
                <td   valign="top"><strong>Last Name:</strong></td>
                <td align="left" >{$row.last_name}</td>
            </tr>
            <!----><tr>
                <td   valign="top"><strong>Title / Position:</strong></td>
                <td align="left" >{$row.position}</td>
            </tr>
            <tr>
                <td   valign="top"><strong>Email Address:</strong></td>
                <td align="left" >{$row.email}</td>
            </tr>
           <!-- --><tr>
                <td  valign="top"><strong>Telephone Number:</strong></td>
                <td align="left" >{$row.contactno}</td>
            </tr>
 				<tr><td colspan="2"><h2>School Donation Percentage</h2></td></tr>
				<tr>
					<td valign="top" ></td>
					<td align="left" >{$row.school_donation_percentage}{if $row.school_donation_percentage!=0}% {/if}</td>
				</tr>
				<tr><td colspan="2"><h2>Fine Prints</h2></td></tr>
				<tr>
					<td  valign="top" ></td>
					<td align="left" >{$row.fine_prints}</td>
				</tr>				
				<tr><td colspan="2"><strong>Additional items or restrictions that apply to your offer </strong> </td></tr>
				<tr>
					<td align="right" valign="top" ></td>
					<td align="left" >{$row.items_resctriction}</td>
				</tr>
            <tr><td colspan="2" height="10"></td></tr>	
            <tr>
                <td align="center"> 
		{ if $row.approve!="1" }
			<input type="submit" name="approve"  value="Approve" id="approve" >
		{/if}</td>
                <td align="center">&nbsp;</td>
            </tr>
            <tr><td colspan="2" height="20"></td></tr>
        </table>
        </form>
	</td>
	</tr>
  </table>
<br>

</div>
{include file=$footer}