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
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action'))
			return true;
		else
			return false;
    });
	$("#msg").fadeOut(5000);
});
</script>

<script type="text/javascript">
function redirect_deal(url,deal_id)
{
//   alert("url: "+url+" DEal id: "+deal_id);
     window.location = url+"/admin/sitemodules/deal/manage_report.php?prod_deal_id="+deal_id;
}
</script>
{/literal}

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Other Settings </div>
<br />
<table cellpadding="6" cellspacing="2" align="center" width="100%" border="0">
  <tr>
    <td colspan="2"><h3>Manage Report</h3></td> 
  </tr>
  <tr>
    <td align="left"></td>
    <td align="right">

      Deal Title: <select name="prod_title" id="prod_title" onchange="javascript: redirect_deal('{$siteroot}',this.value);" style="width=250;">
          <option value="">--Select--</option>
          {section name=t loop=$deal_title_arr}
          <option value="{$deal_title_arr[t].product_id}">{$deal_title_arr[t].product_name|@ucfirst}</option>
          {/section}
      </option>

  </td>
  </tr>
  <tr>
    <td  colspan="2">
      <div align="center" class="success" >{$msg}</div>
       {if $smarty.get.prod_deal_id !=""}
      <div align="left"><strong>Deal:</strong> <strong class="success">{$deal_arr[0].product_name|@ucfirst}</strong></div>

      <div align="right" class="success" style="padding-bottom:5px;">
   
      <img src="{$siteimg}/icons/pdf.jpg" align="top"> <a href="{$siteroot}/admin/sitemodules/deal/download_report.php?view=pdf&prod_deal_id={$smarty.get.prod_deal_id}&deal_title={$deal_arr[0].product_name|@ucfirst}">Download Pdf</a>
      </div>
       {/if}

      <form name="frmAction" id="frmAction" method="post" action="">
        <table cellpadding="6" cellspacing="2" align="center" width="100%" border="0" class="listtable">
          <tr class='headbg' align="center">
            <td width="1%" align="center"><input type="checkbox" id="checkall" /></td>
            <td width="18%" align="left">Name</td>
            <td width="25%" align="left">Email</td>
            <td width="12%" align="left">Barcode Id</td>
            <td width="7%" align="left">Price</td>
            <td width="7%" align="left">Payment</td>
            <td width="8%" align="left">Date</td>
<!--            <td width="8%" align="left">Close Date</td>-->
          </tr>
          {section name=i loop=$deal_arr}
          <tr class="grayback" id="tr_{$gift[i].id}">
            <td align="center"><input type="checkbox" name="giftid[]" value="{$deal_arr[i].id}" /></td>
            <td align="left">{$deal_arr[i].from_username}</td>
            <td align="left">{$deal_arr[i].email}</td>
            <td align="left">{$deal_arr[i].barcode_id}</td>
            <td align="left">{$deal_arr[i].product_disc_price}</td>
            <td align="left">{$deal_arr[i].payment_done}</td>
            <td align="left">{$deal_arr[i].order_date|date_format}</a></td>
<!--             <td align="left">{$deal_arr[i].order_date|date_format}</a></td> -->
          </tr>
          {sectionelse}
          <tr align="center" class="trbgprj02">
            <td colspan="6" class="success" align="center"><b>No record found here</b></td>
          </tr>
          {/section}
          <tr>
            <td align="right"><!--<img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
            <td align="left" colspan="1"><select name="action" id="action">
                <option value="">--Action--</option>
                <option value="delete">Delete</option>
                
              </select>
              <input type="submit"  value="Go" class="button1" />&nbsp;
            <span id="acterr" class="error"></span>-->
            </td> 
            {if $showpgnation eq 'yes' }
            <td colspan="5" align="right">{$pagenation}</td>
            {/if}
          </tr>
        </table>
      </form></td>
  </tr>
</table>
{include file=$footer}