{include file=$header_seller1}
<script type="text/javascript">
{literal}
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
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action'))
			return true;
		else
			return false;
    });
	$("#msg").fadeOut(5000);
});
{/literal}
</script>
{literal}
<script type="text/javascript">
function sort_all(s_name,s_type)
{
    var str_url = SITEROOT+"/admin/seller/login-log.php?sortby="+s_name+"&sorttype="+s_type;

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
{include file=$header_seller2}
<!--<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Seller Login List</div><br/>-->
<section id="maincont" class="ovfl-hidden">

	<section class="grybg">
    <div class="pagehead">
			<div class="grpcol">
				<ul class="reset ovfl-hidden tab1">
					<li><a href="{$siteroot}/admin/seller/my-profile-view.php">My Account</a> </li>
					<li><a href="{$siteroot}/admin/seller/deal/add_product.php">Deal Management</a> </li>
					<li><a href="{$siteroot}/admin/seller/rating/raviews_rating_deals_list.php">Masters</a> </li>
					<li><a href="{$siteroot}/admin/seller/login-log.php" class="active">Tools</a> </li>
				</ul>
               <div class="SubNav">
               <a href="{$siteroot}/admin/seller/login-log.php" class="active">Seller Login Log</a>
               </div>
			
           
			</div>
		</div>
        
    <div class="innerdesc">
    {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
    
    <div class="holdthisTop"> 
    <!--<div><img src="{$siteimg}/icons/excel.gif" align="top"> <a href="{$siteroot}/admin/seller/login-log.php?view=excel"><strong>Export Report </strong></a></div>-->
    <form name="frmAction" id="frmAction" method="post" action="">
    <input type="hidden" id="pg" name="pg" value="{if $smarty.get.page}{$smarty.get.page}{else}1{/if}">
    <table width="100%" cellspacing="2" cellpadding="6" class="listtable">
      <tr class="headbg">
        <td width="1%" align="left" valign="top"><input type="checkbox" id="checkall"  /></td>
        <td width="20%" align="left" valign="top"><a href="javascript:void(0)" onclick="sort_all('first_name',document.getElementById('sorttype_name').value);"><strong>Name</strong></a>
        <input type="hidden" name="sorttype_name" id="sorttype_name" value="{if $sorttype_name}{$sorttype_name}{else}ASC{/if}"/></td>
        <td width="25%" align="left" valign="top"><a href="javascript:void(0)" onclick="sort_all('email',document.getElementById('sorttype_email').value);"><strong>Email Address</strong></a>
        <input type="hidden" name="sorttype_email" id="sorttype_email" value="{if $sorttype_email}{$sorttype_email}{else}ASC{/if}"/></td>
        <td width="20%" align="left" valign="top"><a href="javascript:void(0)" onclick="sort_all('signup_date',document.getElementById('sorttype_signup').value);"><strong>Last Login</strong></a>
        <input type="hidden" name="sorttype_signup" id="sorttype_signup" value="{if $sorttype_signup}{$sorttype_signup}{else}ASC{/if}"/></td>
        <td width="19%" align="left" valign="top"><a href="javascript:void(0)" onclick="sort_all('signout_date',document.getElementById('sorttype_signout').value);"><strong>Logout</strong></a>
        <input type="hidden" name="sorttype_signout" id="sorttype_signout" value="{if $sorttype_signout}{$sorttype_signout}{else}ASC{/if}"/></td>
        <td width="15%" align="left" valign="top"><a href="javascript:void(0)" onclick="sort_all('ip_address',document.getElementById('sorttype_ipaddress').value);"><strong>IP Address</strong></a>
        <input type="hidden" name="sorttype_ipaddress" id="sorttype_ipaddress" value="{if $sorttype_ipaddress}{$sorttype_ipaddress}{else}ASC{/if}"/></td>
      </tr>
      {section name=i loop=$users}
      <tr class="grayback"  id="tr_{$users[i].id}">
        <td align="left" valign="top"><input name="log[]" id="log[]" value="{$users[i].id}" type="checkbox" />
        </td>
        <td align="left" valign="top">{$users[i].username}</td>
        <td align="left" valign="top">{$users[i].email}</td>
        <td align="left" valign="top">{$users[i].login_date|date_format:$smarty_date_format}  {$users[i].login_date|date_format:"%I:%M %p"}</td>
        <td align="left" valign="top">{if $users[i].logout_date eq '0000-00-00 00:00:00'}0000-00-00 00:00:00{else}
        {$users[i].logout_date|date_format:$smarty_date_format}  {$users[i].logout_date|date_format:" %I:%M %p"}{/if}</td>
        <td align="left" valign="top">{$users[i].ipaddress}&nbsp;</td>
      </tr>
      {sectionelse}
      <tr>
        <td colspan="10" class="error" align="center">No Records Found.</td>
      </tr>
      {/section}
      <tr>
            <td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
            <td align="left"><select name="action" id="action">
                <option value="">--Action--</option>
                <option value="delete">Delete</option>
              </select>
              <input type="submit" name="submit" id="submit" value="Go" />
              <span id="acterr" class="error"></span></td>
            <td colspan="4" align="right">{$pagenation}</td>
          </tr>
    </table>
    </form>
    </div>
    </div>
</section>
</section>
{include file=$footer_seller}