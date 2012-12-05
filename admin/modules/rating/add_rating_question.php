<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/common.lib.php");
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");
	
        $rating_quetion=$_POST['rating_quetion'];
        $cdate=date("y/m/d : H:i:s", time()); 
       // echo $cdate;
//---------Add rating question ------------
   if($_POST["Save"])
    {
           
           // $sqlquestion="INSERT INTO rating_question(rating_question,added_date) VALUES ('$rating_quetion','$cdate') ";
           // $row=mysql_query($sqlquestion)or die(mysql_error());
                 $field = array("rating_question"=>$rating_quetion,"added_date"=>$cdate); 
                 $dbObj->cgii("rating_question",$field,"","");
            $s=$msobj->showmessage(234);
            $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>"; 
             header("location:". SITEROOT . "/admin/modules/rating/rating_question_list.php");
             exit;
    }
    //------update  rating question-------------
 if($_POST["Update"])
    {
                 $id=$_GET['edit_id'];
                 $field = array("rating_question"=>$_POST['rating_quetion']); 
                 $dbObj->cupdtii("rating_question",$field,"id=".$id,"");
                 $s=$msobj->showmessage(233);
                 $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
                 header("location:". SITEROOT . "/admin/modules/rating/rating_question_list.php");
                 exit;
    }
    //----Get the updated id here and display record to add_rating_question.tpl file-----
   if($_GET['edit_id'])
      {
        $id=$_GET['edit_id'];
	$sql="select * from rating_question where id='$id'";
	$querow=mysql_query($sql)or die(mysql_error());
	$r=mysql_fetch_array($querow);
        $id=$r['id'];
        $rating_question=$r['rating_question'];
  
         $smarty->assign('id', $id);
         $smarty->assign('rating_question', $rating_question);
      }
  
if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
	$smarty->display(TEMPLATEDIR . '/admin/modules/rating/add_rating_question.tpl');
	$dbObj->Close();
?>