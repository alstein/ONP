<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/common.lib.php");
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();
set_time_limit(500000);
ini_set("memory_limit","1000M");

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

    $imagetitle=$_POST['imagetitle'];
    $image= $_POST['image'];
    $type= "payment";
    $status= $_POST['status'];
//     $cdate=date("d/m/y : H:i:s", time()); 
//---------Add video ------------
   if($_POST["Save"])
    {
           $sql="SELECT MAX(sort_no) 'maxsort' FROM tbl_footer_logos WHERE type='payment'";
           $sortmax= mysql_query($sql)or die(mysql_error());
           $maxsort=@mysql_fetch_assoc($sortmax);
           $max= $maxsort['maxsort']+1;
       
           $image = generalfileupload($_FILES['image'],"../../../uploads/logos","");
            $sqlvideo="INSERT INTO tbl_footer_logos(title,logo_image,sort_no,status,type) VALUES('$imagetitle','$image','$max','$status','$type')";
            $row=mysql_query($sqlvideo)or die(mysql_error());
            $s=$msobj->showmessage(220);
            $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>"; 
             header("location:". SITEROOT . "/admin/modules/logos/payment_logo_list.php");
             exit;

    }
    //------update  video-------------
 if($_POST["Update"])
    {   
                 $id=$_GET['edit_id'];
                 if ($_FILES["image"]["error"]== 4)
                {
                 $field = array("title"=>$_POST['imagetitle'],
                                "status"=>$_POST['status']); 
             $dbObj->cupdtii("tbl_footer_logos",$field,"id=".$id,"");
             $s=$msobj->showmessage(221);
	     $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
             header("location:". SITEROOT . "/admin/modules/logos/payment_logo_list.php");exit;
                
                }else
                {
                 $image = generalfileupload($_FILES['image'],"../../../uploads/logos","");
                 $field = array("title"=>$_POST['imagetitle'],
                            "logo_image"=>$image,
                            "status"=>$_POST['status']); 
             $dbObj->cupdtii("tbl_footer_logos",$field,"id=".$id,"");
             $s=$msobj->showmessage(221);
	     $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
             header("location:". SITEROOT . "/admin/modules/logos/payment_logo_list.php");exit;
             }
    }
    //----Get the updated id here and display record to add_video.tpl file-----
   if($_GET['edit_id'])
      {
        $id=$_GET['edit_id'];
	$sql="select * from tbl_footer_logos where id='$id'";
	$productrow=mysql_query($sql)or die(mysql_error());
	$results = array();
        $i=0;
       while ($r=mysql_fetch_array($productrow))
       {
                 $id=$r['id'];
                 $image_title=$r['title'];
                 $image_logo=$r['logo_image'];
                 $status=$r['status'];
        }
  
           $smarty->assign('id', $id);
           $smarty->assign('image_title', $image_title);
           $smarty->assign('image_logo', $image_logo);
           $smarty->assign('status', $status);
      }
  
if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
	$smarty->display(TEMPLATEDIR . '/admin/modules/logos/add_paymentlogo.tpl');
	$dbObj->Close();
?>