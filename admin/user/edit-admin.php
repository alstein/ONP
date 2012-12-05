<?php ob_start();
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
include_once("../../upload.inc.php");
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");


if(isset($_POST['email'])){

   #-------Image upload start--------#
   $userid=$_GET['id'];
   $res = $dbObj->cgs("tbl_users","","userid",$userid,"","","");
	$row1 = @mysql_fetch_assoc($res);
	if($_FILES['pimage']['name'])
	{
      $picimage = time();
		if($row1['pic_image'])
		{ 
         @unlink("../../uploads/profile/original/".$row1['pic_image']);
         @unlink("../../uploads/profile/thumbnail/".$row1['pic_image']);
		}
		   //$image = generalfileupload($_FILES['pimage'],"../../uploads/profile","");

        // Defining Class
		$yukle = new upload;
		$yukle->set_max_size(1000000);
         	$yukle->set_directory("../../uploads/profile");
         	$yukle->set_tmp_name($_FILES['pimage']['tmp_name']);
         	$yukle->set_file_size($_FILES['pimage']['size']);
         	$yukle->set_file_type($_FILES['pimage']['type']);
		$yukle->set_file_name($_FILES['pimage']['name']);
		$yukle->start_copy();
		$yukle->resize(0,0);
		$image=$yukle->set_thumbnail_name($picimage);
		$yukle->set_thumbnail_name("thumbnail/".$picimage);
		$yukle->create_thumbnail();
		$yukle->set_thumbnail_size(63, 81);
		$yukle->set_thumbnail_name("original/".$picimage);
		$yukle->create_thumbnail();
		$yukle->set_thumbnail_size(0, 0);
		@unlink("../../uploads/profile/".$_FILES['pimage']['name']);
		$f=array("pic_image");
	      $v=array($image);

			$rs=$dbObj->cupdt('tbl_users', $f, $v, 'userid', $userid, '1');
			//$_SESSION['msg']="<span class='Success'><strong>Profile Photo Updated Successfully.</strong></span>";
	}
#-----End of image upload-------#
	
   $zipCode=$_POST['zipcode'];
	$city=$_POST['city'];

	if($_POST['zipcode'] != ""){
		$p=explode(" ",$_POST['zipcode']);
		if(strlen($p[0])>4){
			$zip=$p[0][0].$p[0][1].$p[0][2].$p[0][3];
			$rs=$dbObj->cgs("zipData", "*", "zipcode", $zip, "", "", "");
			$row=@mysql_fetch_assoc($rs);
			$city=$row['city'];
			if(!$city){
				$zip=$p[0][0].$p[0][1].$p[0][2];
				$rs=$dbObj->cgs("zipData", "*", "zipcode", $zip, "", "", "");
				$row=@mysql_fetch_assoc($rs);
				$city=$row['city'];
			}
		}else{
			$rs=$dbObj->cgs("zipData", "*", "zipcode",$p[0], "", "", "");
			$row=@mysql_fetch_assoc($rs);
			$city=$row['city'];
		}
	}
	if($_POST['zipcode'] == ""){
		$foundCity =$_POST['city'];
		$rs=$dbObj->cgs("zipData", "*", "city", $foundCity, "zipcode ASC", "", "");
		$row=@mysql_fetch_assoc($rs);
		$zip=$row['zipcode'];
	}
	extract($_POST);
	$flag = true;

	if($flag){

	$fullname = $first_name." ".$last_name;


	if($password!="")
	{
	  $fl = array("first_name","last_name","fullname","username",'password','email','usertypeid','postalcode','status',"access_level","profile_summary");
	  $vl = array($first_name,$last_name,$fullname,$username,md5($password),$email,1,$zipCode,$status,$level,$prosummary);
	}
        else
	{
	  $fl = array("first_name","last_name","fullname","username",'email','usertypeid', 'postalcode','status',"access_level","profile_summary");
	  $vl = array($first_name,$last_name,$fullname,$username,$email,1,$zipCode,$status,$level,$prosummary);
	}

	$tmp = $dbObj->cupdt('tbl_users',$fl,$vl,'userid',"{$_GET['id']}","");

	$_SESSION['msg']="<span class='success'>Admin updated successfully.</span>";

        header("Location:".SITEROOT."/admin/user/manage_admin.php");
        exit;
      }
}


#----------Get access level------------#
$m_id = $dbObj->gj("mast_levels","*","1","","","","","");
if($m_id !='n')
{
    while($modules = mysql_fetch_assoc($m_id))
	    $module_info[] =  $modules;
    $smarty->assign("level", $module_info);
}
#----------Get all Modules------------#

#----------Edit Admin------------#
$u_id = $dbObj->gj("tbl_users","*","userid='{$_GET['id']}'","","","","","");
if($u_id !='n')
{
    $rs_usr = mysql_fetch_assoc($u_id);
	$rs_usr =  $rs_usr;
    $smarty->assign("user", $rs_usr);
}
#----------Get all Modules------------#

if(isset($_SESSION['msg'])){ $smarty->assign("msg", $_SESSION['msg']); unset($_SESSION['msg']);}

$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/edit-admin.tpl');
$dbObj->Close();
?>
