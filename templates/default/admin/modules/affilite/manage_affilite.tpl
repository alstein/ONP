{include file=$header1}
{literal}
<script type="text/javascript">
$(document).ready(function()
{
	$("#checkall").click(function()
 	{
		var checked_status = this.checked;
		$("input[@type=checkbox]").each(function()
		{
			this.checked = checked_status;
			change(this);	
		});
 	});
	$("input[@type=checkbox]").click(function()
 	{
		change(this);
 	});
	function change(chk)
	{
		var $tr = $(chk).parent().parent();
		if($tr.attr('id'))
		{
			if($tr.attr('class')=='selectedrow' && !chk.checked)
				$tr.removeClass('selectedrow').addClass('grayback');
			else
				$tr.removeClass('grayback').addClass('selectedrow');
		}
	}
	var flag = false;
	$("#frmAction").submit(function(){
		
		if($("#action").attr('value')=='')
		{
			$("#acterr").text("Please Select Action.").show().fadeOut(3000);
			return false;
		}
		$("input[@type=checkbox]").each(function()
		{
			var $tr = $(this).parent().parent();
			if($tr.attr('id'))
				if(this.checked == true)
					flag = true;
		});
		
		if (flag == false) {
			$("#acterr").text("Please Select Checkbox.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action ?'))
			return true;
		else
			return false;
    });
	$("#msg").fadeOut(5000);
});
</script>
{/literal}
{include file=$header2}
<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Site modules &gt; FAQs list </div>
<br />-->
<table cellpadding="6" cellspacing="2" align="center" width="100%" border="0">
  <tr>
    <td colspan="2"><h3>Manage Affiliate list</h3></td>
  </tr>
  <tr>
    
    <td align="right"><form name="form1" method="get" id="form1" action="">
        <input name="search" type="text" id="search" value="{$smarty.get.search}" size="35" class="search"/><input type="submit" value="Search" class="searchbutton" />
    </form></td>
  </tr>
  <tr>
    <td  colspan="2">
      <div align="center" class="success">{$msg}</div>
      <form name="frmAction" id="frmAction" method="post" action="">
        <table cellpadding="6" cellspacing="2" align="center" width="100%" border="0" class="listtable">
          <tr class='headbg' align="center">
            <td width="1%" align="center"><input type="checkbox" id="checkall" /></td>
           <!-- <td width="20%" align="left">Category</td>-->
            <td width="20%" align="left">First Name</td>
            <td width="15%" align="left">Last Name</td>
				<td width="20%" align="left">Email Address</td>
				<td width="20%" align="left">Web</td>
				<td width="20%" align="left">Company Name</td>
				<td width="20%" align="left">Company Address</td>
				<td width="20%" align="left">Company Contact</td>
				<td width="20%" align="left">Status</td>
          </tr>
          {section name=i loop=$aff}
          <tr class="grayback" id="tr_{$aff[i].faqid}">
            <td align="center" width="1%"><input type="checkbox" name="id[]" value="{$aff[i].id}" /></td>
            <!--<td align="left" width="20%"> <img src="{$siteroot}/templates/{$templatedir}/images/icons/{if $aff[i].status eq 'Inactive'}award_star_silver_1.png {else}award_star_silver_2.png{/if}" align="absmiddle" />  {$aff[i].f_cat|capitalize}</td>-->
            <td align="left"><img src="{$siteroot}/templates/{$templatedir}/images/icons/{if $aff[i].status eq 'Inactive'}award_star_silver_1.png {else}award_star_silver_2.png{/if}" align="absmiddle" /> <a href="credit.php?id={$aff[i].id}">{$aff[i].first_name}</a></td>
            <td align="left" width="34">{$aff[i].last_name}</td>
				 <td align="left" width="34">{$aff[i].email}</td>
				 <td align="left" width="34">{$aff[i].web}</td>
				<td align="left" width="34">{$aff[i].co_name}</td>
				<td align="left" width="34">{$aff[i].co_address}</td>
				<td align="left" width="34">{$aff[i].co_contact}</td>
				 <td align="left" width="34">{$aff[i].status}</td>	
           </tr>
          {sectionelse}
          <tr align="center" class="trbgprj02">
            <td colspan="4" class="success" align="center"><b>{$norecord}<!--Faqs not found .--></b></td>
          </tr>
          {/section}
          <tr>
            <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
            <td align="left" colspan="1"><select name="action" id="action">
                <option value="" selected="selected">--Action--</option>
                <option value="delete" >Delete</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select></td>
              <td colspan=2><input type="submit"  value="Go" class="button1" />&nbsp;
            <span id="acterr" class="error"></span></td> 
            {if $showpgnation eq 'yes' }
            <td colspan="4" align="right">{$pagenation}</td>
            {/if}
          </tr>
        </table>
      </form></tr>
  </tr>
</table>
{include file=$footer}