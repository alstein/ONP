<?php 
include_once("../../../include.php");

$err_img="";
if(isset($_POST['Save']))
{
      if($_FILES['upload1']['name']!='')
      {
	if (($_FILES["upload1"]["type"] == "image/gif") || ($_FILES["upload1"]["type"] == "image/jpeg") || ($_FILES["upload1"]["type"] == "image/pjpeg") || ($_FILES["upload1"]["type"] == "image/png") )
	{
		$err_img = "";
		$photos = generalfileupload($_FILES['upload1'],"../../../uploads","");
		if($photos !='')
		{
		$_SESSION['imag']=$photos;	
		header("Location:".SITEROOT."/admin/seller/deal/cropimage-admin.php");
			
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

$dbObj->Close();
?>

<form action="" name="frmEdit" id="frmEdit" method="POST" enctype="multipart/form-data">
    <table cellpadding="6" cellspacing="2" width="100%" class="" border="0">
	<tr>
	    <td colspan="2">&nbsp;</td>
	</tr>
	<tr>
	    <td align="right" valign="top"><font color="red">*</font> Image: </td>
	    <td><input type="file" name="upload1" id="upload1" value="" onkeypress="blur();"/>
		<br><font color="#999999" size="2">Please upload only .jpg,.gif,.png file.</font>
		<br/><span style='color:red; font-size: 12px;'><?php echo $err_img;?></span>
	    </td>
	</tr>
	<tr>
            <td>&nbsp;</td><td><input type="submit" name="Save" value="Upload" /></td>
        </tr>
    </table>
</form>