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
			$("#acterr").text("Please select action.").show().fadeOut(3000);
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
			$("#acterr").text("Please select checkbox.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action'))
			return true;
		else
			return false;
    });

    $("#msg").fadeOut(5000);
});

{/literal}
</script>
{include file=$header2}

<div>
<div class="breadcrumb" align="left" style="float:left;"><a href="{$siteroot}/admin/index.php">Home</a>  &gt; Bad Word </div>
</div>

<div class="holdthisTop">
  <form name="frmSearch" action="" method="get">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tr>
		<TD width="20%"><div align="left"><img src="{$siteroot}/templates/default/images/icons/add.png" align="absmiddle" /> <a href=" {$siteroot}/admin/sitemodules/badword/addbadword.php">Add Word</a></div></TD>
        <td><table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
		<td width="50%">{if $msg}<div align="center"><span id="msg" class="success">{$msg}</span></div>{/if} </td>			
              <td width="40%" align="right"><label>
                <input name="search" type="text" id="search" value="{$smarty.get.search|stripslashes}" size="29" class="search" />
                </label></td>
              <td width="10%" align="right"><input type="submit" name="button" id="button" value="Submit" class="searchbutton" /></td>
            </tr>
          </table></td>
      </tr>
    </table>
  </form>
</div>
<br />


<table cellpadding="6" cellspacing="2" align="center" width="100%" border="0">

  <tr>
    <td  colspan="2"><form name="frmAction" id="frmAction" method="post" action="">
        <table cellpadding="6" cellspacing="2" align="center" width="100%" border="0" class="listtable">
          <tr class='headbg'>
         <td width="1%" align="center"><input type="checkbox" id="checkall" /></td>

            <td width="35%" align="left" valign="top">Word</td>
		<td width="35%" align="left" valign="top">Replacement</td>
		<!--<td width="35%" align="left" valign="top">Banner</td>-->
	           <td width="30%" align="left" valign="top">Action</td>
          </tr>
         {section name=i loop=$user}
		<tr class="grayback" id="tr_{$user[i].id}">
			 <td><input type="checkbox" value="{$user[i].id}" name="id[]"/></td>
                         <td align="left" width="10%" valign="top">
                              {if $user[i].status eq 'Inactive'}
                                <img height="10px" width="10px" src="http://192.168.0.58/demo/templates/default/images/icons/award_star_silver_1.png"  align="absmiddle"/>
                               {else}
                                <img  height="10px" width="10px" src="http://192.168.0.58/demo/templates/default/images/icons/award_star_silver_2.png" align="absmiddle" />
                              {/if}&nbsp;&nbsp;
			
				{$user[i].bad_word}
			 </td>
			
			<td align="left" valign="top">
				{$user[i].rep_word}
			</td>
			<td align="left" valign="top">
				
				
					
				<img src="{$siteroot}/templates/{$templatedir}/images/icons/application_edit.png" align="absmiddle" /> 
					<a href="editbadword.php?id={$user[i].id}" class="admintxt">
						<strong>
							Edit
						</strong>
					</a> 
				</td>
		</tr>
		{sectionelse}
		<tr>
			<td colspan="3" class="error" align="center">
				<strong>No Records Found.</strong>
			</td>
		</tr>
		{/section}
{if $user}
		<tr>
                    <td align="right">
                     <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
                    </td>
                    <td colspan="3" align="left">
                            <select name="action" id="action">
                              <option value="">--Action--</option>
                              <option value="Active">Active</option>
                              <option value="Inactive">Inactive</option>	
                              <option value="Delete">Delete</option>
                            </select>
                            <input type="submit" name="submit" id="submit" value="Go" class="button1" /><div class="buttonEnding1"></div>
                           
                    </td>
                   <!-- <td align="right" colspan="4">{if $showpgnation eq "yes"}{$pagination}{/if}
                   </td>-->
 
              </tr>
<tr><TD></TD>
 <td ><span id="acterr" class="error" ></span>
                   </td><td align="right" colspan="4">{$pgnation}
                   </td>
            </tr>
{/if}
</table>
</form>
{include file=$footer}