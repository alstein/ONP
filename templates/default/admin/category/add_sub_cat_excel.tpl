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
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/category/category_list.php">Main Categories</a> &gt; <a href="{$siteroot}/admin/category/subcat.php?cat_id={$smarty.get.cat_id}">Sub Categories List</a> &gt; Import Deal  Subcategory</div><br />

<div class="holdthisTop">
    <div>
		<table cellpadding="6" cellspacing="2">{$categoryHirarchy}</table><br>
        <div class="fl width50">
            <h3>{$sitetitle} {if $smarty.get.cid}Edit{else}Add{/if} Deal Category (using .csv/.xls)</h3>
        </div>
        <div class="clr">&nbsp;</div>
         {if $msg}<div align="center" id="msg">{$msg}<br/></div>{/if}

    </div><br/>

    <div id="UserListDiv" name="UserListDiv" >
      <form name="frm" action="" id="frm"  method="post" enctype="multipart/form-data">
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
            <tr>
                <td colspan="2" align="right"><a href="{$siteroot}/admin/category/subcat.php?cat_id={$smarty.get.cat_id}">Back</a></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Excel File:</td>
                <td align="left" width="60%"><input name="category_file" type="file" id="category_file"  size="15" class="textbox"/><br />Upload .xls / .csv file with maximum 25000 rows only</td>
            </tr>
            <tr><td colspan="2" align="right">&nbsp;</td></tr>
			{*<!-- <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Category type:</td>
                <td align="left" width="60%">
                    <input name="category_type" type="radio" id="category_type" value="product" checked="true"/>Product
                    <input name="category_type" type="radio" id="category_type" value="service" {if $result.category_type eq 'service'}checked="true"{/if}/>Service
                </td>
            </tr>
            <tr><td colspan="2" align="right">&nbsp;</td></tr>
			-->*}
            <tr>
                <td></td>
                <td align="left"><input type="Submit" name="Submit" value="{if $smarty.get.cid}Update{else}Add{/if}" /></td>
            </tr>
	  </table>
      </form>
    </div>

	<div class="fl"><h3>Import file .csv/.xls format</h3></div>
	<div class="fr"><h3><a href="{$siteroot}/admin/category/add_cat_excel.php?view=test_excel">Download Sample .csv file</a></h3></div>

	<table border="1" width="100%" style="margin-top:10px;">
		<tr><td width="20%"><b>Category Name</b></td><td></td><td></td><td></td><td></td></tr>
		<tr><td>Antiques</td><td></td><td></td><td></td><td></td></tr>
		<tr><td>Art</td><td></td><td></td><td></td><td></td></tr>
		<tr><td>Baby</td><td></td><td></td><td></td><td></td></tr>
		<tr><td>Books, Comics & Magazines</td><td></td><td></td><td></td><td></td></tr>
	</table>
</div>
{include file=$footer}