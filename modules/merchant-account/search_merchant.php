<?php
include_once('../../include.php');

	if(!isset($_SESSION['csUserId']))
	{
		header("location:".SITEROOT); exit;
	}

$row_meta=$dbObj->getseodetails(19);
$smarty->assign("row_meta",$row_meta);


	$whose_profile="view_searches";
	$smarty->assign("whose_profile",$whose_profile);

$citysql = $dbObj->cgs("mast_city","*","status","Active","","","");
   while($cityres =mysql_fetch_array($citysql))
   {
      $citylst[]=$cityres;
   }
$smarty->assign("city",$citylst);

	$sql="select * from mast_deal_category where parent_id=0 order by category";
        $result = mysql_query($sql) or die('Error, query failed');
        $i = 0;
        while($row = mysql_fetch_array($result))
        {
                $tmp = array('id'=>$row['id'],
                 'category'=>$row['category']);
                $results[$i++] = $tmp;
        }
	$smarty->assign("category",$results);

	$cnd_searches = "  (u.fullname LIKE '%".$_GET['id2']."%' OR u.first_name LIKE '%".$_GET['id2']."%' OR u.last_name LIKE '%".$_GET['id2']."%' ) and u.usertypeid=2 ";
	$select_search = $dbObj->customqry("select u.*,mc.city_name from  tbl_users u left join mast_city mc on u.city=mc.city_id where $cnd_searches", "");
	$i=0;
	while($res_searches=@mysql_fetch_assoc($select_search))
	{
		$searches[]=$res_searches;
		$select_from_friend=$dbObj->customqry("select f.* from  tbl_friends f  where (f.userid='".$res_searches['userid']."' and f.friendid='".$_SESSION['csUserId']."') or (f.userid='".$_SESSION['csUserId']."' and f.friendid='".$res_searches['userid']."')", "");
		$res_from_friend=mysql_fetch_assoc($select_from_friend);
		$searches[$i]['verification']=$res_from_friend['verification'];
		$i++;
	}

	
$smarty->assign("searches",$searches);
$smarty->display(TEMPLATEDIR . '/modules/merchant-account/search_merchant.tpl');
$dbObj->Close();
?>