{include file=$header1}

{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
{/strip}

{literal}
<script type="text/javascript">
$(document).ready(function(){
	$("#frm").validate({
		errorElement:'div',
		rules: {
			category_file:{
				required: true,
				accept : "csv|xls|xlsx|org"
			}
		},
		messages: {
			category_file:{
				required: "Please upload file.",
				accept: "Please upload valid file format"
			}
		}
	});
});
</script>
{/literal}

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;  
<a href="{$siteroot}/admin/country/country_list.php">Country List</a> &gt;  
<a href="{$siteroot}/admin/state/state_list.php?contryid={$country.countryid}">County/State</a> &gt; Import County/State</div>
<br />


<div class="holdthisTop">
    <div>
		<div class="fl width50">
			<h3>{$sitetitle} Import County/State (using .csv/.xls)</h3><br>
			<h3>Country Name: {$country.country|ucfirst}</h3>
		</div>
		<div style="clear:both"></div><br>

		<div class="clr">&nbsp;</div>
		{if $msg}<div align="center" id="msg">{$msg}<br/></div>{/if}

    </div><br/>

    <div id="UserListDiv" name="UserListDiv" >
      <form name="frm" action="" id="frm"  method="post" enctype="multipart/form-data">
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
            <tr>
                <td colspan="2" align="right"><a href="{$siteroot}/admin/state/state_list.php?contryid={$country.countryid}">Back</a></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Excel File:</td>
                <td align="left" width="60%"><input name="category_file" type="file" id="category_file"  size="15" class="textbox"/><br />Upload .xls / .csv file with maximum 25000 rows only</td>
            </tr>
            <tr><td colspan="2" align="right">&nbsp;</td></tr>
            <tr>
                <td></td>
                <td align="left"><input type="Submit" name="Submit" value="Add" /></td>
            </tr>
	  </table>
      </form>
    </div>

	<div class="fl"><h3>Import file .csv/.xls format</h3></div>
	<div class="fr"><h3><a href="{$siteroot}/admin/state/add_excel.php?view=test_excel">Download Sample .csv file</a></h3></div>

	<table border="1" width="100%" style="margin-top:10px;">
		<tr><th width="20%">County/State Name</th><th></th><th></th><th></th><th></th></tr>
		<tr><td>Avon</td><td></td><td></td><td></td><td></td></tr>
		<tr><td>Bedfordshire</td><td></td><td></td><td></td><td></td></tr>
		<tr><td>Belfast</td><td></td><td></td><td></td><td></td></tr>
		<tr><td>Berkshire</td><td></td><td></td><td></td><td></td></tr>
	</table>
</div>
{include file=$footer}