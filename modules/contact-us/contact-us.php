<?php

include_once('../../include.php');
include_once('../../includes/classes/cms_pages.class.php');
$cms = new Cms_pages();

include_once('../../includes/classes/contact_us.class.php');
$contactus=new Contact_Us();

$row_meta=$dbObj->getseodetails(29);
$smarty->assign("row_meta",$row_meta);


include_once('../../includes/class.message.php');
$msobj= new message();

	$select=$dbObj->customqry("select * from tbl_company_contact where id=1","");
	$fetch_select=@mysql_fetch_assoc($select);
	$phone=$fetch_select['phone'];
	$fax=$fetch_select['fax'];
	$general_enquiry=$fetch_select['general_enquiry'];
	$sales_enquiry=$fetch_select['sales_enquiry'];
	$smarty->assign("phone",$phone);
	$smarty->assign("fax",$fax);
	$smarty->assign("general_enquiry",$general_enquiry);
	$smarty->assign("sales_enquiry",$sales_enquiry);

	$sql=$dbObj->customqry("SELECT * FROM tbl_footer_logos WHERE type='followus' order by sort_no","");
	while($fetch_sql=@mysql_fetch_assoc($sql))
	{
		
	$follow_us[]=$fetch_sql;
	}
	$smarty->assign("follow_us",$follow_us);

    $name = $_POST["name"];
    $email=$_POST["email"];
    $message=$_POST["message"];

    $arrVar =array("name"=>$name,"email"=>$email,"message"=>$message);


    if($_POST['email']!="")
    {
        $ContacusResult = $contactus->addNewContac($arrVar);
        $s=$msobj->showmessage(2);
        $_SESSION['msg_succ']="Details has been send successfully.";
        header("Location:".$_SERVER['HTTP_REFERER']);
        exit;
    }

    if(isset($_SESSION['msg']))
    {
        $smarty->assign("msg", $_SESSION['msg']);
        unset($_SESSION['msg']);
    }

    if(isset($_SESSION['msg_succ']))
    {
        $smarty->assign("msg_succ", $_SESSION['msg_succ']);
        unset($_SESSION['msg_succ']);
    }

//Get content of the page as per id
$rs = $cms->getCmsPageById(2);
$title =$rs["title"];
$description =$rs["description"];

$smarty->assign("title",$title);
$smarty->assign("description",$description);

//Get meta tags of the page as per id


$smarty->assign("pgName","content");
$smarty->display(TEMPLATEDIR . '/modules/contact-us/contact-us.tpl');
$dbObj->Close();
?>