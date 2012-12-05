<?php
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
include_once('../../../include.php');

$msobj= new message();
$smarty->assign("msobj",$msobj);

if(!$_SESSION['duAdmId'])
	{
		header("location:".SITEROOT . "/admin/login/_welcome.php");
	}

// if(!$_SESSION['duAdmId'])
// 	header("location:". SITEROOT . "/admin/login/index.php");

#--------Action-----------#
if(isset($_POST['action']))
{
	extract($_POST);
if($id!='')
{

	$id = implode(", ", $id);
	
	if($action == "delete")
	{
		$temp = $dbObj->customqry("delete from tbl_affiliate where id in (".$id.")","");
      //$s=$msobj->showmessage(295);
	   //$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		$_SESSION['msg']="<span class='success'>Deleted successfully.</span>";
	}
	elseif($action=='active')
	{
		
		$temp = $dbObj->customqry("update tbl_affiliate set status='Active' where id in(".$id.")", "");
		
// 		$rs1 = $dbObj->customqry("select * from tbl_affiliate where status='Active' and id in(".$id.") group by id","");
// 		
// 		$nums1 = @mysql_num_rows($rs1);
// 			if($nums1 >0)
// 			{ 
// 				$sub_emails=array();
// 				
// 				$i=0;
// 			
// 				while($res=mysql_fetch_assoc($rs1))
// 				{
// 		
// 		
// 					$sub_emails[$i]=$res['email'];
// 					$emailid =$sub_emails[$i];	
// // 					for($k=0;$k<count($sub_emails);$k++)
// // 					{
// // 						echo $emailid=$sub_emails[$k];
// // 					}
// 					$password = createRandomPassword(6);
// 					$user = $dbObj->customqry("update tbl_affiliate set password ='".$password."' where email= '{$res['email']}'", "");
// 						$myFile = '../../../email/affilites1.html';  // HTML Template
// 					$image='<img src='.SITEROOT.'/templates/'.TEMPLATEDIR.'/images/logo.png border=none />';
// 					$content = file_get_contents($myFile);
// 					$subject ="Affilite regitration successfully";
// 					$sum = "";
// 				if ($content !== false){
// 							// replace the content in HTML
// 						$sum = str_replace("[[siteroot]]",SITEROOT,$content);
// 						$sum1 = str_replace("[[default]]",TEMPLATEDIR,$sum);
// 						$sum2 = str_replace("[[message]]",$_sum5,$sum1);
// 						$sum3 = str_replace("[[sitename]]",SITETITLE,$sum2);
// 						$sum4 = str_replace("[[name]]",$res['first_name'],$sum3);
// 						$sum5 = str_replace("[[image]]",$image,$sum4);
// 						$sum6 = str_replace("[[password]]",$password,$sum5);
// 						$sum7 = str_replace("[[email]]",$res['email'],$sum6);
// 						//$sum3 = str_replace("[[logo]]",$rowwall['email_thumbnail'],$sum2);
// 						
// 					} else {
// 							echo "error";
// 					// an error happened
// 					}
// 
// 				
// 				//echo $sum7;
// 				$from = SITE_EMAIL;
// 				$flag=mail($emailid,$subject,$sum7,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
// 					$i=$i+1;
// 				
// 				}
// 			}


		

      //$s=$msobj->showmessage(296);
	   //$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		$_SESSION['msg']="<span class='success'>Activated successfully.</span>";
		
	}
	elseif($action=='inactive')
	{
	
		$temp = $dbObj->customqry("update tbl_affiliate set status='Inactive' where id in(".$id.")", "");
      //$s=$msobj->showmessage(297);
	   //$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		$_SESSION['msg']="<span class='success'>Inactivated successfully.</span>";
	}
	
	header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
}
}
#---------END-------------#


/*-----------------------Pagination Part1--------------------*/
extract($_GET);
//$page=isset($_GET['page']);
$page= $_GET['page'];
if(!isset($_GET['page']))
    $page =1;
else
$page = $page;
$newsperpage =25;                            
$StartRow = $newsperpage * ($page-1);            
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/

$sf = "f.*";
$tbl = "tbl_affiliate as f";
$cnd = "f.first_name like '%".$_GET['search']."%'";

$rs = $dbObj->gj($tbl, $sf , $cnd, "", "", "", $l, "");
while($row = @mysql_fetch_assoc($rs))
	$arr[] = $row;
	
$smarty->assign("aff",$arr);

/*-----------------------Pagination Part2--------------------*/
$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");  
$nums =@mysql_num_rows($rs);
$smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
    $smarty -> assign("showpgnation","yes");
$showing   = !isset($_GET["page"]) ? 1 : $page;
$firstlink = basename($_SERVER['PHP_SELF']) . "?search=".$_GET['search'];
$seperator = '&page=';
$baselink  = $firstlink; 
$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
$smarty -> assign("pagenation",$pagenation);
/*-----------------------End Part2--------------------*/

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

//$smarty->assign("norecord",$s['msgtext']);
// echo hi;

$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/affilite/manage_affilite.tpl');

$dbObj->Close();
?>