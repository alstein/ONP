<?php
ob_start();
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once("../../../includes/common.lib.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

$msobj= new message();

if(!$_SESSION['duAdmId'])
      header("location:".SITEROOT . "/admin/login/index.php");
	extract($_GET);

#----------Select Query for add--------#
$rs1 = $dbObj->cgs("tbl_ads", "*", "ad_id", $_GET['ad_id'], "", "", "");
$ad=@mysql_fetch_assoc($rs1);
$smarty->assign("ad", $ad);
if($_GET['ad_id'])
{
$s_date = explode(" ",$ad['start_date']);
$start_date = $s_date[0];

$e_date = explode(" ",$ad['end_date']);
$end_date = $e_date[0];

$smarty->assign("start_date", $start_date);
$smarty->assign("end_date", $end_date);
}
#--------End of select Query-------------#

#-------Update Query for Advertisement-----#
if($_POST['Submit'] == 'Update')
{
extract($_POST);	
extract($_GET);	

    $sf = array("ad_title","ad_desc","ad_align","ad_type","acc_rec","c_info","start_date","end_date");
    $sv = array($tittle,$desc,$align,$type1,$acc_rec,$c_info,$_POST['dob1'],$_POST['dob2']);
      if($type1 == "image")
	{	
	  if($ad['ad_embedded_code'])
	  $rs = $dbObj->cupdt('tbl_ads',"ad_embedded_code","","ad_id",$ad_id,"");//exit;
	  if($_FILES['image1']['name'])
	  {
	     $rsimg=$dbObj->cgs("tbl_ads","ad_image,width,height","ad_id",$ad_id,"","","");//exit;
	     while($press=mysql_fetch_assoc($rsimg))
	     {
	       $sizeimg[]=$press;
	              
	     }
	     
	  $image=generalfileupload($_FILES['image1'],'../../../uploads/ad',1);	
	  if($image <> '') 
	   {
	      list($width, $height)= getimagesize("../../../uploads/ad/".$image);
		$sf = array("width","height");
    		$sv = array($width,$height);	
		$rs = $dbObj->cupdt('tbl_ads',$sf,$sv,"ad_id",$ad_id,"");
	   }
	             
// 	  if($width != $sizeimg[0]['width'] && $height != $sizeimg[0]['height'])
// 	   {
// 		
// 	      @unlink("../../../uploads/ad/".$image);
// 	      $s=$msobj->showmessage(185);
// 	      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
// 		header("Location:" . $_SERVER['HTTP_REFERER']);
// 		exit; 
// 	   }
// 	  else if($width != $sizeimg[0]['width'] )
// 	  {
// 		
// 	      @unlink("../../../uploads/ad/".$image);
// 	      $s=$msobj->showmessage(185);
// 	      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
// 		header("Location:" . $_SERVER['HTTP_REFERER']);
// 		exit;
// 	  }
// 	  else if($height != $sizeimg[0]['height'])
// 	    {
// 		
// 	      @unlink("../../../uploads/ad/".$image);
// 	      $s=$msobj->showmessage(185);
// 	      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
// 		header("Location:" . $_SERVER['HTTP_REFERER']);
// 		exit; 
// 	    }

	    @unlink("../../../uploads/ad/".$ad['ad_image']);	
	    $image=generalfileupload($_FILES['image1'],'../../../uploads/ad',1);	
	    array_push($sf,"ad_image");
	    array_push($sv,$image);
	 }
	array_push($sf, "ad_link");
	array_push($sv, $link1);
      }
      else
      {	
	  if($ad['ad_image'])
	  {
	      $rs = $dbObj->cupdt('tbl_ads',"ad_image","","ad_id",$ad_id,"");
	      @unlink('../../uploads/ad/'.$del_image['ad_image']);	
	      //@unlink('../../uploads/ad/big'.substr($ad['ad_image'],5));
	  }
	  $embed = str_replace("&lt","<",$embed);
	  $embed = str_replace("&gt",">",$embed);
	  $embed= str_replace("&quot",'"',$embed);
  
	  array_push($sf,"ad_embedded_code");		
	  array_push($sv,$embed);
      }

	$rs = $dbObj->cupdt('tbl_ads',$sf,$sv,"ad_id",$ad_id,"");
	$s = $msobj->showmessage(186);
	$_SESSION['msg'] = "<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
 	header("Location:Ads.php");
        exit;
}

  if($_POST['Submit'] == 'Save')
  {
	extract($_POST);	
        extract($_FILES);
	if($_FILES['image1']['name'])
	{
	   $image=generalfileupload($_FILES['image1'],'../../../uploads/ad',1);
            if($image <> '') 
	     {
	        list($width, $height)= getimagesize("../../../uploads/ad/".$image);
	   }
          $sf = array("ad_title","ad_desc","ad_align","ad_link","ad_image","ad_type","acc_rec","c_info","width","height","start_date","end_date");
	  $sv = array($tittle,$desc,$align,$link1,$image,'image',$acc_rec,$c_info,$width,$height,$_POST['dob1'],$_POST['dob2']);			
	}
	else
	{
	    $sf = array("ad_title","ad_desc","ad_align","ad_embedded_code","ad_type","acc_rec","c_info","start_date","end_date");

	    $embed2 = str_replace("&lt","<",$embed);
	    $embed3 = str_replace("&gt",">",$embed2);
	    $embed4= str_replace("&quot",'"',$embed3);

	    $sv = array($tittle,$desc,$align,$embed4,'code',$acc_rec,$c_info,$_POST['dob1'],$_POST['dob2']);
// echo print_r($sv);
	}
  
	$res = $dbObj->cgi('tbl_ads', $sf, $sv, "");
	$s=$msobj->showmessage(187);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	header("Location:Ads.php");
        exit;
  }
#----------------------------------End of Insert Query---------------------------------#

$smarty->assign("ad_id", $_GET['ad_id']);
$smarty->assign("inmenu","gsetting");

if(isset($_SESSION['msg']))
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}

if($_GET['ad_id'])
  $smarty->display(TEMPLATEDIR . '/admin/modules/admanagement/Edit_Ad1.tpl');
else
  $smarty->display(TEMPLATEDIR . '/admin/modules/admanagement/add_Ad.tpl');

$dbObj->Close();
?>
