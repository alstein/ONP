<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.mymessage.php');
include_once('../../../includes/paging.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("34", $arr_modules_permit)) )
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

$umsgObj= new Mymessage();

if(isset($_POST['submit']))
{
	if($_POST['action'] == "" || !isset($_POST['action']))
        {
		$s=$msobj->showmessage(4);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	if(count($_POST['mesgid']) == 0 || (!isset($_POST['mesgid'])))
        {	
		$s=$msobj->showmessage(5);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}

	extract($_POST);
	$mesgid = implode(", ", $mesgid);	
	if($action == "delete")
	{
		$id = $dbObj->customqry("delete from tbl_message where id in (".$mesgid.")","");
		$s=$msobj->showmessage(123);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}

#----------------Get Messages----------------#
// $msg_info="";
// if(isset($_GET['uname']))
//       $msg_info = $umsgObj->getAdminSideMessages($_GET['uname']);
// else
//     $msg_info = $umsgObj->getAdminSideMessages('');


#----------------------------------------------------------------------#
  $dealArray = "";

	    #------------Pagination Part-1-----------#
	    if(!isset($_GET['page']))
		$page =1;
	    else
		$page = $_GET['page'];

	    $adsperpage = 15;
	    $StartRow = $adsperpage * ($page-1);
	    $l =  ($StartRow).','.$adsperpage;
	    #--------------------------------------#

            $cnd ="is_question='Yes'";

            if($uname !='')
            {
		$cnd1 = "username  = '{$uname}'";
		$tbl= "tbl_users";
		$sf="userid";
		$rs_userid = $this->gj($tbl,$sf,$cnd1, "", "", "", "", "");
		if( $rs_userid !='n')
		    $rs_name = @mysql_fetch_assoc($rs_userid);

		$cnd = "user_id= '{$rs_name['userid']}'";
            }

	    $tbl = "tbl_message m";
	    $sf = "m.*";
	    $rs1 = $dbObj->gj($tbl,$sf,$cnd, "m.id", "", "DESC", $l, "");

	    if($rs1 != "n")
	    {
		$i=0;
		while($row = @mysql_fetch_assoc($rs1))
		{
		  
					 		
			$dealArray['records'][$i] = $row;
			$tmp_nm = $mymsg->getUserName($row['user_id']);
	
			$dealArray['records'][$i]['user_name'] = $tmp_nm['username'];
			$tmp_nm = $mymsg->getUserName($row['from_id']);
			$dealArray['records'][$i]['from_name']=  $tmp_nm['username'];
			$i++;
			
		}
	    }

	    /*----------Pagination Part-2--------------*/
	    $rs2 = $dbObj->gj($tbl,$sf,$cnd, "m.id", "", "DESC", "", "");
	    $nums = @mysql_num_rows($rs2);
	    $show = 30;		
	    $total_pages = ceil($nums / $adsperpage);
	    if($total_pages > 1)
		    $dealArray['showpaging']='yes';
	    $showing   = !($_GET['page'])? 1 : $_GET['page'];

            if($uname != '')
            {
	         $firstlink = "member-message.php?uname={$uname}";
	         $seperator = '&page=';
            }  
            else
            {

	         $firstlink = "member-message.php";
	         $seperator = '?page=';
            }

	    $baselink  = $firstlink; 

	    $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink,$seperator, $nums);
	    $dealArray['pgnation'] =$pgnation;

	    /*-----------------------------------*/
	    //return $dealArray;
#----------------------------------------------------------------------#

$smarty->assign("msg_info", $dealArray['records']);
$smarty->assign("showpaging", $dealArray['showpaging']);
$smarty->assign("pagenation", $dealArray['pgnation']);
#---------------End Get Messages-------------#


#---------------Get all username-------------#
$user_list = $umsgObj->getAllUserName();
$smarty->assign("user_list", $user_list);
#---------------Get all username-------------#

#----------et messgae into session-----------#
if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}
#---------------End Set messgae--------------#

$smarty->assign("inmenu","sitemodules");

$smarty->display(TEMPLATEDIR . '/admin/modules/member-message/member-message.tpl');

$dbObj->Close();
?>