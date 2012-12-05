{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript">
{literal}
$(document).ready(function(){
	$("#checkall").click(function(){
		var checked_status = this.checked;
		$("input[@type=checkbox]").each(function(){
			this.checked = checked_status;
			change(this);	
		});
 	});
	$("input[@type=checkbox]").click(function(){
		change(this);
 	});
	function change(chk){
		var $tr = $(chk).parent().parent();
		if($tr.attr('id')){
			if($tr.attr('class')=='selectedrow' && !chk.checked)
				$tr.removeClass('selectedrow').addClass('grayback');
			else
				$tr.removeClass('grayback').addClass('selectedrow');
		}
	}
	var flag = false;
	$("#frmAction").submit(function(){
		if($("#action").attr('value')==''){
			$("#acterr").text("Please Select Action.").show().fadeOut(3000);
			return false;
		}
		$("input[@type=checkbox]").each(function(){
			var $tr = $(this).parent().parent();
			if($tr.attr('id')){
				if(this.checked == true)
					flag = true;
			}
			
		});
		if (flag == false){
			$("#acterr").text("Please Select Checkbox.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action'))
			return true;
		else
			return false;
   });
    $("#msg").fadeOut(5000);
});
</script>
<script type="text/javascript">
	function changeit(val)
	{
		location.href=SITEROOT+"admin/user/bussiness_list.php?categoryid="+val;
		return false;
	}
function activeSuspend(bid,valu)
{
		if(confirm('Are you sure to perform "'+valu+'" action'))
		{
			location.href=SITEROOT+"admin/user/bussiness_list.php?business_id="+bid+"&approve="+valu+"&act=approve";	
			return true;
		}
		else
		{
			return false;
		}
		
		return false;
}
</script>
<script type="text/javascript">//searchUser({$smarty.get.page});</script>
{/literal}
{literal}
<script type="text/javascript">
function getCity(val){
	//alert(val);
        ajax.sendrequest("GET", SITEROOT+"/admin/user/get_city.php", {val:val}, '', 'replace');
}
</script>
{/literal}
{include file=$header2}
<div class="holdthisTop">
	<div>
    	<div class="fl width30"><h3>{$sitetitle} Bussiness List</h3></div>
		<form name="frm" method="GET">
	<table width="90%" align="left" border="0" align="center">
	<tr>
		<td width="5%" align="right">State :</td>
		<td width="10%">
			<select name="state" onchange="javascript: getCity(this.value);" >
				<option value="">Select value</option>
					{section loop=$state name=i}
					<option value="{$state[i].id}" {if $state[i].id eq $state1} selected="selected" {/if}>
						{$state[i].state_name}
					</option>
					{/section}
			</select>	
		</td>
	
		<td width="3%" align="right">City :</td>
		<td width="10%">
	<!--{$city1}-->
		<div id="replace"><select name="city" id="city" ><option value="">Select value</option><option value="{$city1}" {if  $city1 neq ''} selected="selected" {/if}>{$city1}</option></select>	
		</div>
		</td>	
	</tr>
	<tr>
		<td width="5%" align="right">zipcode :</td>
		<td width="10%" align="left"><label>
				<input name="search_zipcode" type="text" id="search" value="{$search_zip}" size="12" /></label>
		</td>
	
		<td width="3%" align="right">Business Id :</td>
		<td width="10%">
				<input name="business_code" type="text" id="business_code" value="{$business_code}" size="13" />	
		</div>
		</td>	
	</tr>
	<tr>
	{* <!--<td width="5%" align="right">zipcode :</td>
		<td width="10%" align="left"><label>
				<input name="search_zipcode" type="text" id="search" value="{$search_zip}" size="12" /></label>
		</td>--> *}
		<td width="10%"  align="right">Bussiness Category:
		</td><TD>
				<select name="categoryid" id="categoryid" ><!--onchange="javascript: changeit(this.value);"-->
				<option value="">All</option>
				{section name=i loop=$BCategory}
			<option value="{$BCategory[i].categoryid}" {if $smarty.get.categoryid eq $BCategory[i].categoryid} selected="selected" {/if} >{$BCategory[i].category}</option>
				{/section}
				</select>
			</td>
	
		<td width="3%" align="right">Bussiness&nbsp;Name&nbsp;:</td>
		<td width="10%">	
		 <label>
                <!--<form name="frmSubmit" method="post" action="">--><input name="searchuser" type="text" id="searchuser" value="{$searchuser}" size="13" />
		
					<input type="hidden" id="sorttype" value="" />
					<input type="hidden" id="sortord" value="" />
		<!--<input type="submit" name="button" id="button" value="Submit" class="searchbutton" onclick="searchUser();" />-->
            </label>
		</td>	
	</tr>
	
	<tr>
	<td colspan="4" width="5%" align="center"><input type="submit" name="submit1" value="Serach"></td>	
	</tr>
	<!--<td width="5%">TO</td>
	<td width="20%">
        {if $edate}
	<script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD', '{$edate}');</script>
	{else}
	<script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD');</script>
        {/if}
	</td>-->
	<table>
	<tr>
	
    </tr>
  </table>
</form>

   	<div class="clr">
	</div>
     	{if $msg} 
    	<div align="center">
       {$msg} 
    	</div>
     	{/if} 
  	</div>
	<br>
<table width="100%" border="0" ><TR><TD align="right"><A href="javascript:history.go(-1);">go Back</A></TD></TR></table>

 <form name="frmAction" id="frmAction" method="post" action="">
<div style="overflow:auto; width:100%; height: 100%;"> 
	<table width="100%" cellspacing="2" cellpadding="3" class="listtable" >
	<tr class="headbg">
	<td width="2%"><input type="checkbox" id="checkall" /></td>					
	<td width="10%"><a href="bussiness_list.php?sortord={if $ord=='asc'}desc{else}asc{/if}&sorttype=name&categoryid={$smarty.get.categoryid}&searchuser={$searchuser}" >Bussiness Name </a></td>
	<td width="5%"><a href="bussiness_list.php?sortord={if $ord=='asc'}desc{else}asc{/if}&sorttype=code&categoryid={$smarty.get.categoryid}&searchuser={$searchuser}" >Business Id </a></td>

	<td width="8%"><a href="bussiness_list.php?sortord={if $ord=='asc'}desc{else}asc{/if}&sorttype=approvedt&categoryid={$smarty.get.categoryid}&searchuser={$searchuser}" >Business Approval Date </a></td>
	<td width="8%"><a href="bussiness_list.php?sortord={if $ord=='asc'}desc{else}asc{/if}&sorttype=category&categoryid={$smarty.get.categoryid}&searchuser={$searchuser}" >Business Category</a></td>
	<td width="10%"><a href="bussiness_list.php?sortord={if $ord=='asc'}desc{else}asc{/if}&sorttype=address&categoryid={$smarty.get.categoryid}&searchuser={$searchuser}" >Address</a></td>

	<td width="5%"><a href="bussiness_list.php?sortord={if $ord=='asc'}desc{else}asc{/if}&sorttype=city&categoryid={$smarty.get.categoryid}&searchuser={$searchuser}" >City</a></td>
	<td width="5%"><a href="bussiness_list.php?sortord={if $ord=='asc'}desc{else}asc{/if}&sorttype=state&categoryid={$smarty.get.categoryid}&searchuser={$searchuser}" >State</a></td>
	<td width="6%"><a href="bussiness_list.php?sortord={if $ord=='asc'}desc{else}asc{/if}&sorttype=zipcode&categoryid={$smarty.get.categoryid}&searchuser={$searchuser}" >Zip Code</a></td>
	<!--<td width="6%"><a href="bussiness_list.php?sortord={if $ord=='asc'}desc{else}asc{/if}&sorttype=zipcode&categoryid={$smarty.get.categoryid}&searchuser={$searchuser}" >Contact&nbsp;&nbsp;No</a></td>-->
	<td width="10%">Contct Info</td>
	<td width="5%"><a href="bussiness_list.php?sortord={if $ord=='asc'}desc{else}asc{/if}&sorttype=offer&categoryid={$smarty.get.categoryid}&searchuser={$searchuser}" >Offers</a></td>
	<td width="5%"><a href="bussiness_list.php?sortord={if $ord=='asc'}desc{else}asc{/if}&sorttype=generated&categoryid={$smarty.get.categoryid}&searchuser={$searchuser}" >Total $ Generated</a></td>
	<td width="10%">Business Information Fields</td>
	<td width="3%"><a href="bussiness_list.php?sortord={if $ord=='asc'}desc{else}asc{/if}&sorttype=approve&categoryid={$smarty.get.categoryid}&searchuser={$searchuser}" >Status (Active / Suspended)</a></td>
<td width="8%"><a href="bussiness_list.php?sortord={if $ord=='asc'}desc{else}asc{/if}&sorttype=comment&categoryid={$smarty.get.categoryid}&searchuser={$searchuser}" >Comment</a></td>
	<td width="3%" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
  			{section name=i loop=$users}
  			<tr class="grayback" id="chk{$smarty.section.i.iteration}">
    				<td><input type="checkbox" value="{$users[i].business_id}" name="userid[]"/></td>
    				<td valign="top"><img src="{$siteimg}/icons/{if $users[i].categoryid  eq
				'5'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />
    				{$users[i].name}</td>
                                <td valign="top">{$users[i].business_code}</td>
                                <td valign="top">{$users[i].date_of_approval|@date_format:"%Y-%m-%d"}</td>
    				<td valign="top">{$users[i].category}</td>
<td valign="top">{$users[i].add1}</td>
  <!-- {$users[i].userid} <td valign="top"><a href="user_information.php?userid=" title="Show User Details">{$users[i].email}</a></td>-->
<td valign="top">{$users[i].city}</td>
<td valign="top">{$users[i].state}</td>
<td valign="top">{$users[i].zip}</td>
<!--<td valign="top">{$users[i].phone}</td>-->
<td valign="top"><strong>First name: </strong> {$users[i].first_name}<br/><strong>Last name: </strong> {$users[i].last_name}<br/><strong>Position: </strong> {$users[i].position}<br/><strong>Email: </strong>{$users[i].email}<br/><strong>Telephone: </strong>{$users[i].contactno}</td>


<td valign="top"><a href="javascript: void(0);" onclick="javascript: location.href='{$siteroot}/admin/sitemodules/deal/manage_offer.php?bus_id={$users[i].business_id}'; return false;">{$users[i].totalOffers}</a></td>
<td valign="top"><a href="javascript: void(0);"><A href="{$siteroot}/admin/sitemodules/gift/manage_gift_card.php?merchent_id={$users[i].business_id}">{$users[i].totalGenerated}</a></td>
<td valign="top"><strong>Business name: </strong>{$users[i].name}<br/><strong>Website: </strong>{$users[i].website}<br/><strong>Telephone: </strong> {$users[i].phone}</td>
<td valign="top">{if $users[i].approve==1 }Active{else}Suspended{/if}</td>
<td valign="top">{$users[i].comment|@substr:0:40}</td>
				<td align="left">
					<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />	
						<a href="bussiness_view.php?business_id={$users[i].business_id}" title="Show User Details"><u>View</u></a>
						<br/>  |
					<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
						<a href="bussiness_information.php?business_id={$users[i].business_id}" title="Edit User Details">
							<u>Edit</u></a><br/> |
					<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
						{if $users[i].approve==1 }
							<a href="javascript:void(0);" onclick="javascript: activeSuspend({$users[i].business_id},'Suspend');">
								Suspend
								<input type="hidden" id="action2" value="suspend" />
							</a>
						{else}
							<a href="javascript:void(0);" onclick="javascript: activeSuspend({$users[i].business_id},'Active');">
								Active
								<input type="hidden" id="action2" value="Active" />
							</a>
						{/if}
				</td>
  			</tr>
  			{sectionelse}
    			<tr>
      				<td colspan="6" class="error" align="center">No Records Found.</td>
   			</tr>
  			{/section}
  			{if $users}
  			<tr>
				<td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
				<td align="left"><select name="action" id="action">
					<option value="">--Action--</option>
					<option value="approve">Active</option>
					<option value="block">Suspend</option>
					<option value="delete">Delete</option>
					</select>
      				<input type="submit" name="submit" id="submit" value="Go" />
				<span id="acterr" class="error"></span></td>
      				<td align="right" colspan="4">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
			</tr>
			{/if}
		</table>
</div>
</form>
{include file=$footer}