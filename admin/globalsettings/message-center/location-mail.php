<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#-------------Check For access------------#
if(!(in_array("46", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#-----------End Check For access----------#


#----------Send Newsletter----------------#
if(isset($_POST['submit']))
{
	extract($_POST);

        if(!$_POST['deal_name'])
        {
	    $_SESSION['msg']="<span class='error'>Please select at least one deal</span>";
	    header("location:".$_SERVER['HTTP_REFERER']);
	    exit;
        }

        if(!$_POST['user_list'])
        {
	    $_SESSION['msg']="<span class='error'>Please select at least one email address</span>";
	    header("location:".$_SERVER['HTTP_REFERER']);
	    exit;
        }


	$subject = $subject;

	for($j=0;  $j < count($user_list); $j++)
	{
            if($user_list[$j] > 0)
            {

	    $cnd_ = "nid = ".$user_list[$j];

	    $res_user = $dbObj->gj("tbl_newsletter","nemail,city",$cnd_,"","","","","");//exit;
	    $row_user = @mysql_fetch_assoc($res_user);

	 #--fetching email content--#
                $mail_rs= $dbObj->cgs("mast_emails","*",array("emailid"),array(19),"","","");
                $mail = @mysql_fetch_assoc($mail_rs);    
                $mail_content=stripslashes(html_entity_decode($mail['message']));


	    #Get Deal Info
	    $name=@implode("','",$deal_name);

	    $cnd_deal1="deal_unique_id IN('{$name}')";	
	    $res_deal1 = $dbObj->gj("tbl_deal","*",$cnd_deal1,"","deal_unique_id","","","");
	    $i=0;
	    $msgs="";

	    while($_req_deal1 = @mysql_fetch_assoc($res_deal1))
	    {	
		    $image=@explode(",",$_req_deal1['medium_image']);	
		    $linkurl11 = SITEROOT ."/deal/".$_req_deal1['url_title']; //exit;
		    $msgs .='<div class="griddeal fl" align="center" style="border-bottom:1px solid #87B400;padding-top:20px;">
				    <div class="griddealbg fl">
				    <div class="ovfl-hidden fl">
					    <div class="imgsec fl">
					    <table cellpadding="0" cellspacing="0" border="0" width="100%">
					    <tr class="fl">
					      <td valign="top" align="center"><span><a target="_blank" href='.$linkurl11.'><img src='.SITEROOT.'/uploads/product/thumb122X145/'.$image[0].' alt="img" /></a><span></td>
					    </tr>
					  </table>
					</div>
					<div class="fr proddessec">
					<a class="fl"></a> <span class="txt">&pound; '.$_req_deal1['groupbuy_price'].'</span>
					<div class="clr">&nbsp;</div>
							    <p class="userclr"><a href='.$linkurl11.'>'.$_req_deal1['title'].'</a></p>
    
					    <p>Deal Ending<br><strong>'.date("d-M-Y",strtotime($_req_deal1['end_date'])).'</strong></p>
					</div>
				    </div>
				   
				</div>
			</div>';
		  $i++;
		}


	    $email_message = file_get_contents(SITEROOT."/email/email_template.html");
            $u_email=base64_encode($row_user['nemail']);		 
	    $unsubscribe="<a style='font-size:9px;' href='".SITEROOT."/unsubscribe.php?id=".$u_email." ' target='_blank'>Unsubscribe to newsletter service</a>" ; 		
	    $image='<img src='.SITEROOT.'/templates/'.TEMPLATEDIR.'/images/logo.png border=none />';
	    $email_message = str_replace("[SITEROOT]", SITEROOT, $email_message);
	    $email_message = str_replace("[[EMAIL_HEADING]]",$mail_content,$email_message);
	    $email_message  = str_replace("[[CONTENT]]",nl2br($_POST['editor2']),$email_message);
	    $email_message  = str_replace("[[img]]",$image,$email_message);
	    $email_message  = str_replace("[[msgs]]",$msgs,$email_message);
	    $email_message  = str_replace("[unsubscribe]",$unsubscribe,$email_message);	
	    $from ="GroupBuyIt.co.uk <noreply@groupbuyit.co.uk>";

	     $sendmail = @mail($row_user['nemail'],$subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
            }
	    $_SESSION['msg']="<span class='success'>Newsletter sent successfully </span>";
	}

	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}


#-------------Get active Deals---------------#
$date=date("Y-m-d H:i:s",strtotime("+3 hours"));

$cnd_deal="admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and end_date >= '$date'";	
$res_deal = $dbObj->gj("tbl_deal","*",$cnd_deal,"","","","","");
if($res_deal !='n')
{
    while($_req_deal = @mysql_fetch_assoc($res_deal))
    {
	    $_arr1_deal[] = $_req_deal;
    }
    $smarty->assign("deal",$_arr1_deal);
}
#------------End active Deals---------------#

#---------------Get City--------------------#
$res11 = $dbObj->gj("tbl_newsletter as c","city, count(nid) as to_sub","city!=''","c.city","c.city","","","");
if($res11 !='n')
{
    while($_req = @mysql_fetch_assoc($res11))
    {
	    if($_req['city'] != '')
	    {
		    $_arr1[] = $_req;
	    }
    }
    $smarty->assign("city_arr",$_arr1);
}
#---------------End get City---------------#

include_once '../../../ckeditor/ckeditor.php' ;
require_once '../../../ckfinder/ckfinder.php' ;
$initialValue = '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' ;
$ckeditor = new CKEditor( ) ;
$ckeditor->basePath	= '../../../ckeditor/' ;
CKFinder::SetupCKEditor($ckeditor, '../../../' ) ;
$config['toolbar'] = array(
array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike' ),
array( 'NumberedList','BulletedList','-','Image','Format','FontSize','TextColor','BGColor'));
$initialValue = stripslashes(html_entity_decode($frow['nl_pagecontent']));
$editorcontent= $ckeditor->editor("editor2", $initialValue, $config);
$smarty->assign("oFCKeditor", $editorcontent);

if($_SESSION['msg'])
{	
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->display(TEMPLATEDIR.'/admin/globalsettings/message-center/location-mail.tpl');
$dbObj->close();	
?>
