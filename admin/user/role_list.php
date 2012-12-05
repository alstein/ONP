<?
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{	
header("location:".SITEROOT . "/admin/login/index.php");
exit;
}

$dellevel_id=$_REQUEST['del_levelid'];

if($dellevel_id!="")
{
 $resdel=$dbObj->customqry("delete from mast_levels where levelid='$dellevel_id'","");
}

if(isset($_POST['submit']))
{
$id = @implode(",", $level_id);

if($action == "delete")
   {
		$id = $dbObj->customqry("delete from mast_levels where levelid in (".$id.")","");
		//$id = $dbObj->customqry("delete mast_levels where levelid = $dellevel_id  in (".$id.")","1");
		$s=$msobj->showmessage(8);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	//header("location:".$_SERVER['HTTP_REFERER']);
	//exit;
}


/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))    $page =1;	else
    $page = $page;
$newsperpage =50;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/

$rs=$dbObj->customqry("select * from mast_levels limit ".$l,"");
$module_array=array();
$modulename="";



$smarty->assign("SESSIONUSERID",$_SESSION['duAdmId']);	
if($rs != 'n')
{
	$i=0;

	while($row=@mysql_fetch_assoc($rs))
       {
		$data[]=$row;
		$data[$i]['levelid'] = $row['levelid'];
                $data[$i]['name']    = $row['name'];
                $data[$i]['modules'] = $row['modules'];	
                array_push($module_array,$data[$i]['modules']);
                $i++;
	}
	


for($i=0;$i<count($module_array);$i++)
{
     $rs1=$dbObj->customqry("select * from mast_admin_modules where id IN($module_array[$i])","");
  while($res=@mysql_fetch_array($rs1))
  {

     $modulename.=$res[modulename].",";
  }
     $data[$i]['modules']=rtrim($modulename,",");
     $modulename="";
}

if(isset($data))
	$smarty->assign("data", $data);

}

/*-----------------------Pagination Part2--------------------*/
$rs=$dbObj->customqry("select * from mast_levels","");
$nums =@mysql_num_rows($rs);
$smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1){
	$smarty->assign("showpgnation","yes");

	$showing   = !isset($_GET["page"]) ? 1 : $page;
  	$firstlink = "role_list.php";
//  if($_GET['usertypeid'])	  $seperator = '&page=';
 // else
        $seperator = '?page=';
	$baselink  = $firstlink;
	$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator);	
	$smarty -> assign("pagenation",$pagenation);
}

if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}

$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/role_list.tpl');
$dbObj->Close();

?>