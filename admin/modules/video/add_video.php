<?php
set_time_limit(1000000);
ini_set("memory_limit","1524M");
ini_set( 'post_max_size', '10240K' );
ini_set( 'upload_max_filesize', '10240K' );

include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/common.lib.php");
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();
//echo  ini_get('upload_max_filesize');
if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

    $videotitle=$_POST['videotitle'];
    $videotype= $_POST['videotype'];
    $video= $_POST['video'];
    $videolink= $_POST['videolink'];
    $status= $_POST['status'];
    $cdate=date("Y-m-d");
//---------Add video ------------
   if($_POST["Save"])
    {
                $isError = "no";
		$errMsg = "";
                if($_FILES['video']['name'])
		{
		
                        if($_FILES['video']['size']<10000000) //10 mb 10485760
			{
                            $video = generalfileupload($_FILES['video'],"../../../uploads/video","");
                        }else
                        {
                                $isError = "yes";
				$errMsg .="<span class='error'>Please upload the video file size upto 10MB only</span>";
                        }
                 }
                 if($isError == "no")
		 {		
                            $sqlvideo="INSERT INTO tbl_videos(video_title,video_type,video_file,video_link,date_added,status) VALUES ('$videotitle','$videotype','$video','$videolink','$cdate','$status') ";
                            $row=mysql_query($sqlvideo)or die(mysql_error());
                            $s=$msobj->showmessage(204);
                            $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>"; 
                            header("location:". SITEROOT . "/admin/modules/video/video_list.php");
                            exit;
                 }else
		 {
			$_SESSION['msg'] = $errMsg;
			header("location:". SITEROOT . "/admin/modules/video/add_video.php");
                        exit;
		 }
    }
    //------update  video-------------
     if($_POST["Update"])
    {
                $id=$_GET['edit_id'];
                 if ($_FILES["video"]["error"]== 4)
                {
                        $field = array("video_title"=>$_POST['videotitle'],
                                        "video_type"=>$_POST['videotype'],
                                        "video_link"=>$_POST['videolink'],
                                        "date_added"=>$_cdate,
                                        "status"=>$_POST['status']); 
                        $dbObj->cupdtii("tbl_videos",$field,"id=".$id,"");
                        $s=$msobj->showmessage(205);
                        $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
                        header("location:". SITEROOT . "/admin/modules/video/video_list.php");exit;
                }else
                {
                        $isError = "no";
                        $errMsg = "";
                        if($_FILES['video']['name'])
                        {
                                if($_FILES['video']['size']<10000000) //10 mb
                                {
                                    if($_POST['old_video'])
                                    {
                                    //echo SITEROOT."/uploads/video/".$_POST['old_video'];
                                     @unlink(SITEROOT."/uploads/video/".$_POST['old_video']);
                                    }
                                    $video = generalfileupload($_FILES['video'],"../../../uploads/video","");
                                }else
                                {
                                        $isError = "yes";
                                        $errMsg .="<span class='error'>Please upload the video file size upto 10MB only</span>";
                                }
                        }
                        //$video = generalfileupload($_FILES['video'],"../../../uploads/video","");
                        if($isError == "no")
                        {
                            $field = array("video_title"=>$_POST['videotitle'],
                                        "video_type"=>$_POST['videotype'],
                                        "video_file"=>$video,
                                        "video_link"=>$_POST['videolink'],
                                        "date_added"=>$_cdate,
                                        "status"=>$_POST['status']); 
                            $dbObj->cupdtii("tbl_videos",$field,"id=".$id,"");
                            $s=$msobj->showmessage(205);
                            $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
                            header("location:". SITEROOT . "/admin/modules/video/video_list.php");exit;
                        }
                        else
                        {
                                $_SESSION['msg'] = $errMsg;
                                header("location:". SITEROOT . "/admin/modules/video/add_video.php?edit_id=".$id);
                                exit;
                        }
                }
    }
    //----Get the updated id here and display record to add_video.tpl file-----
   if($_GET['edit_id'])
      {
        $id=$_GET['edit_id'];
	$sql="select * from tbl_videos where id='$id'";
	$productrow=mysql_query($sql)or die(mysql_error());
	$results = array();
        $i=0;
       while ($r=mysql_fetch_array($productrow))
       {
                $id=$r['id'];
                $video_title=$r['video_title'];
                $video_type=$r['video_type'];
                $video_file=$r['video_file'];
                $video_link=$r['video_link'];
                $status=$r['status'];
        }
  
        $smarty->assign('id', $id);
         $smarty->assign('video_title', $video_title);
          $smarty->assign('video_type', $video_type);
           $smarty->assign('video_file', $video_file);
            $smarty->assign('video_link', $video_link);
             $smarty->assign('status', $status);
      }
  
if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
	$smarty->display(TEMPLATEDIR . '/admin/modules/video/add_video.tpl');
	$dbObj->Close();
?>