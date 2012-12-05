<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/classes/class.mymessage.php');
include_once('../../../includes/class.message.php');



if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("35", $arr_modules_permit)) )
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

$umsgObj= new Mymessage();

#----------------Get User Messages----------------#
if($_GET['id'])
{
    #----------------Get Messages----------------#
    $msg_info = $umsgObj->getMessageById($_GET['id'],$_SESSION['duAdmId']);
    $smarty->assign("user_msg_info", $msg_info);
    #---------------End Get Messages-------------#

    #------------Update Read staus Messages--------#
    if($_GET['type'] == 'inbox')
    {
        $tmp = $umsgObj->markReadMessageById($_GET['id'],"Inbox");
    }
//     if($msg_info['msg_in']=="Sent" &&  ($msg_info['revever_name']!= $msg_info['from_name']) )
//     {
//         $tmp = $umsgObj->markReadMessageById($_GET['id'],"Sent");
//     }
//     else/*($msg_info['msg_in']=="Inbox")*/
//     {
//         $tmp = $umsgObj->markReadMessageById($_GET['id'],"Inbox");
//     }
    #------------Update Read staus Messages--------#
}
#---------------End User Messages-------------#


$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/modules/admin-message/view-user-message.tpl');

$dbObj->Close();
?>