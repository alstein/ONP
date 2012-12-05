<?php include_once("templates/".TEMPLATEDIR."/admin/commonfiles/header-start.php"); ?>
<link rel="stylesheet" href="<?php echo SITEROOT ?>/jquery/development-bundle/themes/base/jquery.ui.all.css">
<link href="<?php echo SITEROOT ?>/templates/<?php echo TEMPLATEDIR ?>/admin/css/adminleftmenu.css" rel="stylesheet" type="text/css" />
<script src="<?php echo SITEROOT ?>/ckeditor/ckeditor.js"></script>
<script src="<?php echo SITEROOT ?>/jquery/jquery.validate.js"></script>
<script src="<?php echo SITEROOT ?>/jquery/additional-methods.js"></script>
<script src="<?php echo SITEROOT ?>/templates/<?php echo TEMPLATEDIR?>/admin/seller/js/coupon_manage_validation.js"></script>
<script src="<?php echo SITEROOT; ?>/jquery/development-bundle/ui/jquery-ui-1.8.13.custom.js"></script>
<script src="<?php echo SITEROOT; ?>/jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="<?php echo SITEROOT; ?>/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
$(function() {
	var start_date = "<?php echo date('Y-m-d', strtotime($start_date));?>";
	var myDate=new Date(start_date);
	var curr_year = myDate.getFullYear();
	var curr_month = (myDate.getMonth());
	var curr_day = myDate.getDate();
	var start_date = $( "#st_date, #en_date" ).datetimepicker({
		defaultDate: "+1w",
		changeMonth: true,
		dateFormat: 'yy-mm-dd',
		buttonImage: "<?php echo SITEROOT; ?>/templates/<?php echo TEMPLATEDIR; ?>/admin/images/date.png",
		numberOfMonths: 1,
		minDate: new Date(curr_year, curr_month ,curr_day),
		onSelect: function( selectedDate ) {
			var option = this.id == "st_date" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			start_date.not( this ).datepicker( "option", option, date );
		}
	});
	var end_date = "<?php echo date('Y-m-d', strtotime($end_date));?>";
	var myDate=new Date(end_date);
	var curr_year = myDate.getFullYear();
	var curr_month = (myDate.getMonth());
	var curr_day = myDate.getDate();
	var voucher_start_date = $( "#voucher_start_date, #voucher_end_date" ).datetimepicker({
		defaultDate: "+1w",
		changeMonth: true,
		dateFormat: 'yy-mm-dd',
		buttonImage: "<?php echo SITEROOT; ?>/templates/<?php echo TEMPLATEDIR; ?>/admin/images/date.png",
		numberOfMonths: 1,
		minDate: new Date(curr_year, curr_month ,curr_day),
		onSelect: function( selectedDate ) {
			var option = this.id == "voucher_start_date" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			voucher_start_date.not( this ).datepicker( "option", option, date );
		}
	});
});
</script>
<?php include_once("templates/".TEMPLATEDIR."/admin/commonfiles/header-end.php"); ?>
<?php include_once("templates/".TEMPLATEDIR."/admin/commonfiles/navigation.php"); ?>
<!--Maincontent starts -->
<div id="maincont" class="ovfl-hidden">
	<div class="mainhead">
	  <h3 class="fl"><?php echo ($edit_id > 0 ? "Save Coupon " : "Add Coupon "); ?></h3>
	  <div class="fr">
		<input type="button" name="btnback" id="btnback" value=" Back " onClick="javascript:location.href='coupon_list.php';" />
	  </div>
	  <div class="clr"></div>
	</div>
<?php echo Message::getMessage(); ?>
	<form name="addnew_content_info" id="addnew_content_info" method="post" enctype="multipart/form-data">
	<input type="hidden" name="edit_id" id="edit_id" value="<?php echo ($edit_id > 0 ? $edit_id : ""); ?>" />
    <?php echo $T->protectForm(); ?>
	<div>
    	<div class="fl adminLeft">
            <?php include_once("templates/".TEMPLATEDIR.'/admin/commonfiles/network-navigation.php'); ?>
        </div>
    	<div class="fl adminRight">
    <table width="100%" border="0" class="" cellpadding="3" cellspacing="3">

<!--title 	description 	photo 	en_date 	st_date 	mec_id 	status -->
		<tr>
			<td valign="top"><label for="mec_id">Merchant:</label>
			&nbsp;<span class="error"></span></td>
			<td>
				<select name="mec_id" id="mec_id">
					<option value="">--- Select Merchant ---</option>
					<?php echo $combo->getAllMerchant('user_id', 'username', $mec_id, "is_user_active=1 AND fk_account_type_id=3 AND is_verified=1", 'ASC', "" )?>
				</select>
			</td>
		</tr>

		<tr>
			<td><label for="title">Title:</label>&nbsp;<span class="error">*</span></td>
			<td><input name="title" type="text" id="title" value="<?=$title?>" size="50" /></td>
			<td>&nbsp;</td>
		</tr>

		<tr>
			<td><label for="title">Image:</label>&nbsp;<span class="error">*</span></td>
			<td><input name="photo" type="file" id="photo" size="50" /><br>
			<img src="<?=SITEROOT?>/uploads/user/coupon/medium/<?=$photo?>"	

			</td>
			<td>&nbsp;</td>
		</tr>

		<tr>
			<td valign="top"><label for="description">Description:<span class="error">*</span></label></td>
			<td colspan="2" valign="top">
			<textarea cols="80" id="description" name="description" rows="10"><?=$description?></textarea>
			<div class="error" id="error_description"></div>
			</td>
      		</tr>

          	<tr>
			<td valign="top">Date Time:</td>
			<td>
				<table border="1" style="border-collapse:collapse;" cellpadding="10">
                		<tr>
					<td valign="top" class=""><label for="st_date">Start Date:</label>
					&nbsp;<span class="error">*</span></td>
					<td><input name="st_date" type="text" id="st_date" value="<?php echo $st_date; ?>" /></td>
               			</tr>
				<tr>
					<td valign="top" class=""><label for="en_date">End Date:</label>
					&nbsp;<span class="error">*</span></td>
					<td><input name="en_date" type="text" id="en_date" value="<?php echo $en_date;?>" /></td>
				</tr>
				
              			</table>
			</td>
          	</tr>



		<tr>
			<td valign="top"><label for="mec_id">Status :</label>
			&nbsp;<span class="error">*</span></td>
			<td>
				<select name="status" id="status">
					<option value="1"> ACTIVE </option>
					<option value="0"> INACTIVE </option>
					
				</select>
			</td>
		</tr>



		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="btnsubmit" id="btnsubmit" value=" Save Information " class="submitbutton" /></td>
			<td>&nbsp;</td>
		</tr>
	  </table>
      	</div>
        <div class="clr"></div>
    </div>
	</form>
	

</div>
<!--Maincontent ends  -->
<?php include_once("templates/".TEMPLATEDIR."/admin/commonfiles/footer.php"); ?>