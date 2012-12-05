<?php
include_once("../../include.php");

$err_img="";
if(isset($_POST['Save']))
{
	if($_FILES['upload1']['name']!='')
	{
		if (($_FILES["upload1"]["type"] == "image/gif") || ($_FILES["upload1"]["type"] == "image/jpeg") || ($_FILES["upload1"]["type"] == "image/pjpeg") || ($_FILES["upload1"]["type"] == "image/png") )
		{
			$err_img = "";
			$photos = generalfileupload($_FILES['upload1'],"../../uploads/merchant_photos","");
			if($photos !='')
			{
				$_SESSION['imag']=$photos;
				header("Location:".SITEROOT."/admin/user/cropimage-admin.php");
			}
		}else
		{
			$err_img="Please select image with valid format";
		}
	}else
	{
		$err_img="Please select image";
	}
}

if(isset($_POST['SaveImg']))
{
	print_r($_POST);
	die();
}
////////START Fetching Deal Category Images////////

// $res_dealCatImg = $dbObj->customqry("SELECT * from tbl_deal_category_images WHERE status=1 AND id!=0 AND deal_cat_id=","");
// 
// while($row_dealCatImg = @mysql_fetch_assoc($res_dealCatImg))
// {
// 	$dealCatImages[] = $row_dealCatImg;
// }

/////////END Fetching Deal Category Images/////////
$dbObj->Close();
?>

<form action="" name="frmEdit" id="frmEdit" method="POST" enctype="multipart/form-data">
	<table cellpadding="6" cellspacing="2" width="100%" class="" border="0">
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="right" valign="top"><font color="red">*</font> Image: </td>
			<td>
				<input type="file" name="upload1" id="upload1" value="" onkeypress="blur();"/>
				<br><font color="#999999" size="2">Please upload only .jpg,.gif,.png file.</font>
				<br/><span style='color:red; font-size: 12px;'><?php echo $err_img;?></span>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td><td><input type="submit" name="Save" value="Upload" /></td>
		</tr>
	</table>
</form>

<form action="" name="frmEdit" id="frmEdit" method="POST" enctype="multipart/form-data">
	<table cellpadding="6" cellspacing="2" width="100%" class="" border="1">
		<!--<tr>
			<td align="center">Image suggetions based on Deal category which you have choosed</td>
		</tr>-->
		<!--<tr>
			<td>
				<?php foreach($dealCatImages as $key=>$val){ ?>
				<div style="float:left; padding:20px;">
					<input type="checkbox" id="<?php echo $val['id']; ?>" name="<?php echo $val['id']; ?>" style="vertical-align:text-top;"/>
					<img id="" name="" alt="Image" height="100" width="100" src="<?php echo SITEROOT; if($val['img_name'] == ''){ ?>/templates/default/images/img4.png<?php }else{ ?>/uploads/subcat_image/<?php echo $val['img_name']; }?>"/>
				</div>
				<?php } ?>
			</td>
		</tr>-->
		<!--<tr>
			<td align="center"><input type="submit" name="SaveImg" value="Save" /></td>
		</tr>-->
	</table>
</form>