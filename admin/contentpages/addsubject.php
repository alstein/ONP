<?
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
    header("location:".SITEROOT . "/admin/login/index.php");
}

$cid = $_GET["cid"];
 if($_POST["submit"])
 {
	extract($_POST);
 

		if($cid != "")
		{
			$sqlcat = $dbObj->customqry("SELECT * FROM contactus_subject WHERE subid !=".$cid." and subject = '".$faqcname."'","");//exit;
			$chkcat=mysql_num_rows($sqlcat); 
			//echo $chkcat;exit; 
			if($chkcat != "")
			{
			$s=$msobj->showmessage(125);
			$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			header("location:".$_SERVER['HTTP_REFERER']);
			exit;
			}

			$fl = array("subject");
			$vl = array($faqcname);
			$rs = $dbObj->cupdt("contactus_subject", $fl, $vl, "subid", $cid, "");
				$s=$msobj->showmessage(108);
				$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		}
		else
		{
			$sqlcat = $dbObj->customqry("SELECT * FROM contactus_subject WHERE subject = '".$faqcname."'","");//exit;
			$chkcat=mysql_num_rows($sqlcat); 
			//echo $chkcat;exit; 
			if($chkcat != "")
			{
			$s=$msobj->showmessage(125);
			$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			header("location:".$_SERVER['HTTP_REFERER']);
			exit;
			}

			$fl = array("subject","adddate");
			$vl = array($faqcname,date("Y-m-d"));
			$rs = $dbObj->cgi('contactus_subject',$fl,$vl,'');//exit;
			//$_SESSION['msg'] = "Category added.";
				$s=$msobj->showmessage(107);
				$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		}
		
			header("location:".SITEROOT."/admin/contentpages/subjectlist.php");
		
}

if($cid)
	{
		$selectCategory = $dbObj->customqry("SELECT * FROM contactus_subject WHERE subid=".$cid,"");
      		$row=@mysql_fetch_array($selectCategory);
		$smarty->assign("row",$row);
	}

if($_SESSION['msg'])
{
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
}


$smarty->display(TEMPLATEDIR . '/admin/contentpages/addsubject.tpl');

$dbObj->Close();
?>