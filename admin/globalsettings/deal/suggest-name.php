<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once('../../../includes/SiteSetting.php');

$str=explode("=",$_GET['searchQuery']);

foreach($str as $key=>$val)
{
  $str1=$val;
}

$str1_len=strlen($str1);

$rest = substr(ltrim($val), 0, $str1_len); 

#----seller user list ------------#



$slt_frnd ="u.first_name,u.last_name,u.email,u.userid";
$tbl1 = "tbl_users as u";
$cnd_frnd = "u.userid !={$_SESSION['duAdmId']} and u.isverified = 'yes' and  ( u.fullname like '{$rest}%' or u.first_name like '{$rest}%')";

$res=$dbObj->gj($tbl1, $slt_frnd, $cnd_frnd,"", "", "","", "");
$i=0;
while($res1=@mysql_fetch_array($res))
{
	  
	  $keyword[$i]['email'] = $res1['email'];	
	  $keyword[$i]['first'] = $res1['first_name'];
	  $keyword[$i]['last'] = $res1['last_name'];
	  $_SESSION['UserId']=	$res1['userid'];	
	  $i++;
}




?>
<ul>
<?php
if(is_array($keyword))
{
    foreach($keyword as $key=>$val)
    {
    ?>
	  <li onclick="window.location.href='<?php echo SITEROOT;?>/admin/globalsettings/deal/add-new.php'"><?php echo $val['first']." ".$val['last']." (".$val['email'].")";?><br/></li>    <?php
    }
 }?>
</ul>