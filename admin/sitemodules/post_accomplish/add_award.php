<?php
//include_once("../../../includes/common.lib.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.profile.php');
include_once('../../../includes/classes/class.security.php');
include_once('../../../includes/classes/class.general.php');
if(!$_SESSION['duAdmId'])
{
        header("location:".SITEROOT . "/admin/login/home.php");
		  exit();
}

if(isset($_POST['submit']))
{
	extract($_POST);

	if($new_award != '')
	{
		$field=array("award_title", "admin_award_title", "status");
		$value=array($new_award, $new_award, "Active");
		$newAwardId=$dbObj->cgi("tbl_awards",$field,$value,"");
	}
	if($event != "")
	{
		if($sdate == '') $sdate = date("Y-m-d H:i:s");
		$field=array("catid", "subcatid", "schoolid", "title", "admin_title", "added_date", "userid", "current", "start_date", "end_date", "status");
		$value=array($category, $subcategory, $school, $event, $event, date("Y-m-d H:i:s"), $_SESSION['duAdmId'], $curent, $sdate, $edate, "Active");
		$newEventId=$dbObj->cgi("tbl_events",$field,$value,"");
	}

	$teammates = @implode(",",$teammates);
	if($_GET['id']!="")
	{
		$res = $dbObj->cgs('tbl_accomplishment', "acc_id, userid", "common_flag", $_POST['common_flag'], "", "", "");
		while($row = @mysql_fetch_assoc($res)) {
		  $same_acc_id[] = $row['acc_id'];
		  $same_acc_user[] = $row['userid'];
		  if(!in_array($row['userid'], $_POST['user']))
		  $delid = $dbObj->gdel('tbl_accomplishment', 
			   array('userid', 'common_flag') , array($row['userid'], $_POST['common_flag']), "");
		}
		for($k=0; $k<sizeof($_POST['user']); $k++)
		{
		   if(in_array($_POST['user'][$k], $same_acc_user)) //update
		   {
			$set_field = array( 
					"catid", 
					"subcatid",
					"location",
					"event_name", 
					"award",
					"teammates", 
					"status", 
					"end_date");
			$set_values = array( 
					$category,
					$subcategory, 
					$school);

			if($newEventId != '') array_push($set_values, $newEventId);
			else array_push($set_values, $event_name);
			
			if($newAwardId != '') array_push($set_values, $newAwardId);
			else array_push($set_values, $award);

			array_push($set_values,
					$teammates, 
					'Active', 
					$edate);
		    $updtId = $dbObj->cupdt('tbl_accomplishment', $set_field , $set_values, 
		    	array('userid', 'common_flag') , array($_POST['user'][$k], $_POST['common_flag']) , "");
		    }
		    elseif(!in_array($_POST['user'][$k], $same_acc_user)) //insert new
		    {
			$set_field = array( "userid", 
					"catid", 
					"subcatid",
					"location",
					"event_name", 
					"award",
					"teammates", 
					"status", 
					"end_date", 
					"added_userid",
					"added_date",
					"common_flag");
			
				$set_values = array($_POST['user'][$k],
					$category,
					$subcategory, 
					$school);

			if($newEventId != '') array_push($set_values, $newEventId);
			else array_push($set_values, $event_name);

			if($newAwardId != '') array_push($set_values, $newAwardId);
			else array_push($set_values, $award);

			array_push($set_values,
					$teammates, 
					'Active', 
					$edate, 
					$added_userid,
					date("Y-m-d H:i:s"),
					$_POST['common_flag'] );

			$insertId = $dbObj->cgi('tbl_accomplishment', $set_field , $set_values, "");
		    }
		    else //delete
		    {
			$delid = $dbObj->gdel('tbl_accomplishment', 
			array('userid', 'common_flag') , array($_POST['user'][$k], $_POST['common_flag']), "");
		    }
		}//end for

		$_SESSION['msg']="Accomplishment Updated Successfully.";
	}
	else
	{
		$common_flag = time();
		for($k=0; $k<sizeof($_POST['user']); $k++)
		{
			$set_field = array( "userid", 
					"catid", 
					"subcatid",
					"location",
					"event_name", 
					"award",
					"teammates", 
					"status", 
					"current",
					"start_date", 
					"end_date", 
					"added_userid",
					"added_date", 
					"common_flag");
			$set_values = array( $_POST['user'][$k],
					$category,
					$subcategory, 
					$school);

			if($newEventId != '') array_push($set_values, $newEventId);
			else array_push($set_values, $event_name);
			
			array_push($set_values,
					$award, 
					$teammates, 
					'Active', 
					$curent,
					$sdate, 
					$edate, 
					$added_userid,
					date("Y-m-d H:i:s"), 
					$common_flag);
		$dbres = $dbObj->cgi('tbl_accomplishment', $set_field , $set_values, "");
		$_SESSION['msg']="Accomplishment Added Successfully.";
		}//end for
	}
	header("location:".SITEROOT."/admin/sitemodules/post_accomplish/award.php");
	exit();
} //end submit button

if($_GET['id']!="")
{
	$res = $dbObj->cgs('tbl_accomplishment', "*" ,"acc_id",$_GET['id'], "","", "");
	$accomp = @mysql_fetch_assoc($res);
	$smarty->assign("accomp",$accomp);

	//select childs having same accomplishment
	$same_acc_user = array();
	$res = $dbObj->cgs('tbl_accomplishment', "userid", "common_flag", $accomp['common_flag'], "", "", "");
	while($row = @mysql_fetch_assoc($res))
		$same_acc_user[] = $row['userid'];
	$smarty->assign("same_acc_user", $same_acc_user);

	$tbl = "tbl_student s LEFT JOIN users u ON s.userid=u.userid";
	$sf = "u.userid, u.first_name, u.last_name";
	$cd = "s.schoolid = '".$accomp['location']."'";
	$ob = "u.first_name";
	$gb = '';
	$ad = '';
	$l  = '';
	$prn= '';
	$result	= $dbObj-> gj($tbl, $sf , $cd, $ob, $gb, $ad,$l, $prn);
	while($row = @mysql_fetch_assoc($result))
	{
		$friend[] = $row; 
	}
	$smarty->assign("friend", $friend);

	if($accomp['teammates'] != "")
	{
		$rs = $dbObj->gj("users", "userid, first_name, last_name" , "userid IN (".$accomp['teammates'].")", "", "", "", "", "");
		while($rw = @mysql_fetch_assoc($rs))
		{
			$team[] = $rw;
		}
		$smarty->assign("team", $team);
	}

	$tbl = "tbl_events";
	$sf = "eventid, title";
	$cnd = "catid = '".$accomp['catid']."' AND subcatid = '".$accomp['subcatid']."' AND schoolid = '".$accomp['location']."' AND end_date = '".$accomp['end_date']."'";/*start_date ='".$accomp['start_date']."' AND */
	$ob = "title";
	$result	= $dbObj-> gj($tbl, $sf , $cnd, $ob, "", "", "", "");
	$num_rows = @mysql_num_rows($result);

	if($num_rows>0)
	{
		while($row = @mysql_fetch_assoc($result))
		{
			$event[] = $row;
		}
	}

	$smarty->assign("event", $event);
}
   
	# ----------- fetch users -----------
	$usersArr = array();
	$tbl1 = "users";
	$sf1 = " userid,first_name, last_name, thumbnail";
	//$cnd1 = "status='active' and role_id!=2";
	$cnd1 = "status='active' and password!=''";
	$dbres123 = $dbObj->gj($tbl1, $sf1, $cnd1, "userid", "first_name","", "", "");//exit();
	while($row= @mysql_fetch_assoc($dbres123))
	{
		$usersArr[] = $row;
	}
	//echo "<pre>";print_r($usersArr);echo "</pre>";
   $smarty->assign("usersArr", $usersArr);

	# ----------- end fetch users -----------

	# ----------- fetch student -----------
	$stud = $generalObj->getStudentList();
	$smarty->assign("stud", $stud);
	# ----------- end fetch student -----------

	# ----------- fetch category and subcategory -----------
	$category = $generalObj->getCategoryList();
	$smarty->assign("cat", $category);
	# ----------- fetch subcategory -----------
	$subcat = $generalObj->getSubcategory($accomp['catid']);
	$smarty->assign("subcat", $subcat);
	# ----------- END subcategory -----------

	# ----------- fetch school -----------
	//$school = $generalObj->getSchoolList();
	//$smarty->assign("school", $school);
	# ----------- END school -----------

// 	# ----------- fetch event -----------
// 	$event = $generalObj->getEventList();
// 	$smarty->assign("event", $event);
// 	# ----------- end fetch event --------

	# ----------- fetch award -----------
	$award = $generalObj->getAwardList();
	$smarty->assign("award",$award);
	# ----------- end fetch award-----------

if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);	
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}

$smarty->assign("inmenu","sitemodules");
$smarty->assign("leftadminmenu","post_acc");

$smarty->display(TEMPLATEDIR.'/admin/sitemodules/post_accomplish/add_award.tpl');
$dbObj->Close();
?>