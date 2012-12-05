<?php 
include_once("../../../include.php");


// CROP IMAGE
if($_POST['crop_photo'])
{
      //  ini_set('memory_limit', '40M');
	if($_POST['x'])
	{
		extract($_POST);
		
		$jpeg_quality = 90;
		$target_file = $_SESSION['imag'];
		$target_file=str_replace(" ","_",$target_file);
		$src = '../../../uploads/'.$_SESSION['imag'];		
		$functions = array('image/png' => 'ImageCreateFromPng','image/jpeg' => 'ImageCreateFromJpeg', 'image/gif'=> 'ImageCreateFromGif');	
		 $size = getimagesize($src);

		// Check if mime type is listed above
		if (!$function = $functions[$size['mime']]) 
		{
			trigger_error("MIME Type unsupported: {$size['mime']}",E_USER_WARNING);
			exit;
		}
			$img_r = $function($src);
			$targ_w = 588;
			$targ_h = 288;
			$dst_r = ImageCreateTrueColor($targ_w, $targ_h);

			imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
			@imagejpeg($dst_r, "../../../uploads/product/thumb588X288/".$target_file, $jpeg_quality);
			imagedestroy($dst_r);
	
			$img_r = $function($src);
			$targ_w = 76;
			$targ_h = 64;
			$dst_r = ImageCreateTrueColor($targ_w, $targ_h);

			imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
			@imagejpeg($dst_r, "../../../uploads/product/thumb76X64/".$target_file, $jpeg_quality);
			imagedestroy($dst_r);

			$img_r = $function($src);
			$targ_w = 332;
			$targ_h = 290;
			$dst_r = ImageCreateTrueColor($targ_w, $targ_h);

			imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
			@imagejpeg($dst_r, "../../../uploads/product/thumb332X290/".$target_file, $jpeg_quality);
			imagedestroy($dst_r);	
//	  		 $dbObj->cupdt("tbl_users", array('thumbnail','bigcrop'), array($target_file,$target_file), "userid", $_SESSION['csUserId'], 0); 
		
			$_SESSION['image']= $target_file;
			//$_SESSION['msg']="<span color='red'>Image croped .</span>";
			if($_SESSION['selectedimage'])
// 			$_SESSION['selectedimage']=$_SESSION['selectedimage'].",".$target_file;
			$_SESSION['selectedimage']=$target_file;
			else
			$_SESSION['selectedimage']=$target_file;
			
			$t=explode(",",$_SESSION['selectedimage']);
			foreach($t as $key => $val)
			{
				if($now)
				$now=$now."<br>".$val;
				else
				$now=$val;
			}
			
        ?>
        <script src="<?php echo SITEJS ?>/jquery-1.4.min.js" type="text/javascript" charset="utf-8"></script>
        <form action="<?php echo SITEROOT ?>/admin/globalsettings/deal/add_product.php" method="POST" name="frm" id="frm">
            <input type="hidden" name="box" id="box" value="box" />
            <b>Image uploaded Successfully!<!--<br /> If you want to add more image <a  href="uploadmain-admin.php">click here</a> else--> <a onclick="javascript: document.frm.submit();" href="javascript:void(0)" id="c" >continue</a>.
        </form>
	<script language="JavaScript" type="text/javascript">
	function closena(){
                alert("sdf");
		$("#TB_window").remove();
		$("#TB_overlay").remove();
	
		
	}
			window.parent.document.getElementById("morefile").innerHTML="<?=$now;?>";
        </script>

        <?php	
		exit;	
	}
}
 $_SESSION['image']= $target_file;

//    $smarty->display(TEMPLATEDIR . '/modules/my-account/add-deal.tpl');
    $dbObj->Close();
?>
<script src= "<?=SITEROOT;?>/js/jquery-1.2.6.pack.js"></script>
<script src="<?=SITEROOT;?>/js/jquery.Jcrop.js"></script>
<script type="text/javascript" language="javascript"> 
$(function(){

   $('#cropbox').Jcrop({
		boxWidth: 577, boxHeight: 385,

      aspectRatio: 1.49, 
      onSelect: updateCoords
   });
});

function updateCoords(c)
{
   $('#x').val(c.x);
   $('#y').val(c.y);
   $('#w').val(c.w);
   $('#h').val(c.h);
};

function checkCoords()
{
	if (parseInt($('#w').val())) return true;
	alert('Please select a crop region then press submit.');
	return false;
};

</script>

<table width="100%" cellpadding="2" cellspacing="2" border="0">
<div align="center"><?=$msg_success;?></div> 
	<tr>
		<td>
		<FORM action="" method="post" id="frmCrop" name="frmCrop" onsubmit="return checkCoords();" enctype="multipart/form-data" >
			
			
		<div style="overflow:auto;width:600px;height:400px">
			<img src="<?=SITEROOT;?>/uploads/<?=$_SESSION['imag'];?>" id="cropbox">
		</div>
			<br>
			<span style="font-family:sans-serif,arial,helvetica;font-size:13px;color:#000000">Drag the required part for image croping</span>
			<br><br>
			<input type="hidden" name="original_image" value="<?=$image;?>"><input type="hidden" id="x" name="x" /><input type="hidden" id="y" name="y" /><input type="hidden" id="w" name="w"  /><input type="hidden" id="h" name="h"  />
			<input  type="submit" name="crop_photo" class="button" value="save"/>
		</FORM>
		</td>
	</tr>
</table>
