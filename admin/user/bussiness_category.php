<?
include_once("../../includes/paging.php");
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

$msobj= new message();

#--------Action-----------#
if($_GET['act']=="approve" and $_GET['approve']!="" and $_GET['business_id']!="")
{		$bus_id=$_GET['business_id'];
		if($_GET['approve']=='Suspend')
		{
				$temp = $dbObj->customqry("update tbl_bussiness_category set status='Inactive' where categoryid in(".$bus_id.")", "");
				if($cnt > 1){
						$s=$msobj->showmessage(22);
						$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
				}
				else{
						$s=$msobj->showmessage(22);
						$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
				}
		}
		elseif($_GET['approve']=='Active')
		{
				$temp = $dbObj->customqry("update tbl_bussiness_category set status='Active' where categoryid in(".$bus_id.")", "");
				if($cnt > 1)
				{
						$s=$msobj->showmessage(21);
						$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		
				}
				else{
						$s=$msobj->showmessage(21);
						$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
				
				}
		}

}

if(isset($_POST['action'])){
	extract($_POST);
	$cnt = count($categoryid);
	$categoryid = @implode(",",$categoryid);
	
	if($action == "Delete"){
		$temp = $dbObj->customqry("delete from tbl_bussiness_category where categoryid in (".$categoryid.")","");
							$s=$msobj->showmessage(20);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		//$_SESSION['succMsg']="<span class='success'>Page(s) Deleted Successfully.</span>";
	}elseif($action=='Active'){
		$temp = $dbObj->customqry("update tbl_bussiness_category set status='Active' where categoryid in(".$categoryid.")", "");
		if($cnt > 1){
        				$s=$msobj->showmessage(21);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

		}else{
							$s=$msobj->showmessage(21);
				$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		
		}
	}elseif($action=='Suspend'){
		$temp = $dbObj->customqry("update tbl_bussiness_category set status='Inactive' where categoryid in(".$categoryid.")", "");
		if($cnt > 1){
				$s=$msobj->showmessage(22);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
      }else{
        				$s=$msobj->showmessage(22);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
      }
	}
	header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
}
#---------END-----------#

$rs = $dbObj->cgs("tbl_bussiness_category", "", "", "", "", "", "");
while($row = mysql_fetch_assoc($rs))
{
 	$type[] = $row;
}
$smarty->assign("type",$type);

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","user");
$smarty->display(TEMPLATEDIR.'/admin/user/business_category.tpl');

$dbObj->Close();
?>