<?php 
include_once("../../../include.php");
include_once("../../../includes/paging_search.php");
 

$rs=$dbObj->cgs("tbl_deal","seller_id,title,howitwork,notes","deal_unique_id",$_GET['dealid'],"","","");
$row=@mysql_fetch_assoc($rs);

$smarty->assign("record",$row);

if(isset($_POST['save']))
{
             extract($_POST);
             $getemail=$_POST['emailadd'];
             $dealids=$_POST['hiddendealid']; 
             $field_array = array(
        "notes"=>$notes,
                      ); 

               $selectF="email_add";
					$tablename="tbl_deal";
					$conition="deal_unique_id='$dealids'";
					$res=$dbObj->cupdtii($tablename, $field_array, $conition, "");
				      $_SESSION['msg']="Record Updated succsessfully";      
                     
             ?>
             <script type="text/javascript">window.setTimeout('parent.location.reload();', 1000);</script>
         <?php  
              
           

}
$smarty->assign("hidealid",$_GET['dealid']);
if(isset($_SESSION['msg']))
{
  $smarty->assign("msg",$_SESSION['msg']);
  unset($_SESSION['msg']);
}

$smarty->assign("dealid",$_GET['dealid']);
$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/notes.tpl');

	$dbObj->Close();
?>
