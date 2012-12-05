{include file=$header1}

<!--<link href="{$siteroot}/templates/{$templatedir}/css/facebox/facebox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$siteroot}/js/facebox/facebox.js"></script>-->

 <link rel="stylesheet" href="{$siteroot}/templates/{$templatedir}/css/thickbox.css" type="text/css" media="screen"/>
<!--{literal}
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
{/literal}-->
{include file=$header2}
<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Site modules &gt; FAQs list </div>
<br />-->
<table cellpadding="6" cellspacing="2" align="center" width="100%" border="0">
  <tr>
    <td colspan="2"><h3>{$totalavailable.first_name|ucfirst} Credits</h3></td>
  </tr>

 <tr><TD><h4>Total credits earns: ${$sum}</h4></TD></tr>
	<h4><TD><h4>Total used: ${$used}</h4></TD><td align=center><h4>{if $totalavailable.credit}<a href="javascript: void(0);" onclick="javascript: tb_show('Pay Credit','{$siteroot}/admin/sitemodules/affilite/paycredit.php?id={$totalavailable.id} &placeValuesBeforeTB_=savedValues&TB_iframe=true&height=100&width=300&modal=false', tb_pathToImage);" class="thickbox" title="Pay credits" class="frmtxt">Pay Credit </a>{/if}</tr>
	<tr><TD><h4>Total available: ${$totalavailable.credit}</h4></TD></tr><br>
 <!-- <tr>
    
    <td align="right"><form name="form1" method="get" id="form1" action="">
        <input name="search" type="text" id="search" value="{$smarty.get.search}" size="35" class="search"/><input type="submit" value="Search" class="searchbutton" />
    </form></td>
  </tr>-->
  <tr>
    <td  colspan="2">
      <div align="center" class="success">{$msg}</div>
      <form name="frmAction" id="frmAction" method="post" action="">
        <table cellpadding="6" cellspacing="2" align="center" width="100%" border="0" class="listtable">
          <tr class='headbg' align="center">
            <!--<td width="1%" align="center"><input type="checkbox" id="checkall" /></td>-->
           <!-- <td width="20%" align="left">Category</td>-->
            <td width="35%" align="left" valign="top">Title</td>
        <td width="25%" align="left" valign="top">Hits</td>

            <td width="20%" align="left" valign="top">Credits</td>
	    <td align=left width=20% valign=top>Total Credits</td>	
          </tr>
          {section name=i loop=$title}
          <tr class="grayback" id="tr_{$aff[i].faqid}">
           <!-- <td align="center" width="1%"><input type="checkbox" name="id[]" value="{$aff[i].id}" /></td>-->
            <!--<td align="left" width="20%"> <img src="{$siteroot}/templates/{$templatedir}/images/icons/{if $aff[i].status eq 'Inactive'}award_star_silver_1.png {else}award_star_silver_2.png{/if}" align="absmiddle" />  {$aff[i].f_cat|capitalize}</td>-->
              <td align="left" valign="top" >{if $title[i] eq ''}No Title {else}{$title[i]}{/if}</td>
		<td align="left" valign="top" style="padding-left:5px;">{$hits[i]}</td>
            <td align="left" valign="top">${$credit}</td>
		<td align="left" valign="top">${$totalcredit[i]}</td>	
           </tr>
          {sectionelse}
          <tr><td colspan="4"><strong>No credits.</strong></td></tr>
          {/section}
          <tr>
            <!--<td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
            <td align="left" colspan="1"><select name="action" id="action">
                <option value="" selected="selected">--Action--</option>
                <option value="delete" >Delete</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select></td>-->
              <td colspan=2><input type="submit" name="back"  value="Back" class="button1"  />&nbsp;
            <span id="acterr" class="error"></span></td> 
            {if $showpgnation eq 'yes' }
            <td colspan="2" align="right">{$pagenation}</td>
            {/if}
          </tr>
        </table>
      </form></tr>
  </tr>
</table>
{include file=$footer}