<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include("../../includes/classes/payment_report_grid.php");


if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");
	
	$eventc_obj=new Payment_Report_Grid();	
	
    if($_GET['sms_email_id']>0)
    {
        $sql = "SELECT td.title,tse.* from tbl_sms_email_header tse LEFT JOIN tbl_deal td  ON td.deal_unique_id=tse.deal_id
                WHERE tse.id=".$_GET['sms_email_id'];
        $result = $dbObj ->customqry($sql, '');
        $row = @mysql_fetch_assoc($result);
        $smarty->assign("viewpay", $row);
    }
//           echo "<pre>";
//           print_r($row);
//           exit;
 

if($_GET['sms_email_id']>0)
{
    /*------------Pagination Part-1------------*/

    if(!isset($_GET['page']))
        $page =1;
    else
        $page = $_GET['page'];
        $adsperpage=20;
        $StartRow = $adsperpage * ($page-1);
        $l= $StartRow.','.$adsperpage;

    /*-----------------------------------*/

	if($row['option']=="SMS")
	{
		$sql = "SELECT * from tbl_sms_details WHERE sms_email_id=".$_GET['sms_email_id']." limit ".$l;

		$rec=mysql_query($sql)or die(mysql_error());
		while($row1 = @mysql_fetch_assoc($rec))
		{
			$list[]=$row1;
		}
	}
	if($row['option']=="EMAIL")
	{
		$sql = "SELECT * from tbl_email_details WHERE sms_email_id=".$_GET['sms_email_id']." limit ".$l;

		$rec=mysql_query($sql)or die(mysql_error());
		while($row1 = @mysql_fetch_assoc($rec))
		{
			$list[]=$row1;
		}
	}
	if($row['option']=="BOTH")
	{
		//$sql = "SELECT * from tbl_sms_details WHERE sms_email_id=".$_GET['sms_email_id']." limit ".$l;
		$sql = "SELECT * from tbl_sms_details WHERE sms_email_id=".$_GET['sms_email_id'];
		$rec=mysql_query($sql)or die(mysql_error());
		while($row1 = @mysql_fetch_assoc($rec))
		{
			$listBOTH[]=$row1;
		}

		//$sql = "SELECT * from tbl_email_details WHERE sms_email_id=".$_GET['sms_email_id']." limit ".$l;
		$sql = "SELECT * from tbl_email_details WHERE sms_email_id=".$_GET['sms_email_id'];
		$rec=mysql_query($sql)or die(mysql_error());
		while($row1 = @mysql_fetch_assoc($rec))
		{
			$listBOTH[]=$row1;
		}
		$i= 0;
		foreach($listBOTH as $key=>$val)
		{
			if($key>=$StartRow && $i<$adsperpage)
			{
				$list[] = $val;
				$i++;
			}
		}
	}
	
     //echo "<pre>"; print_r($list); exit;
 /*------------Pagination Part2------------*/
  
	if($row['option']=="SMS")
	{
          $rs = "SELECT * from tbl_sms_details WHERE sms_email_id=".$_GET['sms_email_id'];

		$rec1=mysql_query($rs)or die(mysql_error());
		$nums = @mysql_num_rows($rec1);
	}
	if($row['option']=="EMAIL")
	{
		$rs = "SELECT * from tbl_email_details WHERE sms_email_id=".$_GET['sms_email_id'];

		$rec1=mysql_query($rs)or die(mysql_error());
		$nums = @mysql_num_rows($rec1);
	}
	if($row['option']=="BOTH")
	{
		$rs = "SELECT * from tbl_email_details WHERE sms_email_id=".$_GET['sms_email_id'];

		$rec1=mysql_query($rs)or die(mysql_error());
		while($row1 = @mysql_fetch_assoc($rec1))
		{
			$list1[]=$row1;
		}

		$rs = "SELECT * from tbl_sms_details WHERE sms_email_id=".$_GET['sms_email_id'];

		$rec1=mysql_query($rs)or die(mysql_error());
		while($row1 = @mysql_fetch_assoc($rec1))
		{
			$list1[]=$row1;
		}
		$nums = count($list1);
	}

        $show =20;
        $total_pages = ceil($nums / $adsperpage);
    if($total_pages > 1)
    {
        $showing   = !isset($_GET["page"]) ? 1 : $page;
        $firstlink = "sms_email_contact_info.php?&sms_email_id=".$_GET['sms_email_id'];
        $seperator = '&page=';
        $baselink  = $firstlink;

        $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
        $smarty -> assign("pgnation",$pgnation);
    }
    if(isset($_SESSION['msg']))
    {
        $smarty->assign("msg", $_SESSION['msg']);
        unset($_SESSION['msg']);
    }
//echo "<pre>"; print_r($list); exit;
}
    $smarty->assign("list", $list);
/*-----------------------------------*/ 
if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
	$smarty->assign("inmenu", "user");
	$smarty->display(TEMPLATEDIR . '/admin/report/sms_email_contact_info.tpl');
	$dbObj->Close();
?>