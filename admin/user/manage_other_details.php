<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
$msobj= new message();

   if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");

 if($_POST["Update"])
    {
		$id=$_POST['userid'];
		extract($_POST);

		//////////START Inserting Records in tbl_delivery_service_charges////////////
		$res_delivery_service_chr = $dbObj->customqry("SELECT * FROM tbl_delivery_service_charges WHERE set_for = 'user' AND user_id = ".$id,"");

		$opt1 = 1;$opt2 = 1;$opt3 = 1;$opt4 = 1;$opt5 = 1;
		while($row_delivery_service_chr = @mysql_fetch_assoc($res_delivery_service_chr))
		{
			$j = 1;
			while($j<=5)
			{
				if($row_delivery_service_chr['delivery_service_option'] == "opt".$j)
				{
					if($j == 1)$opt1 = 0;if($j == 2)$opt2 = 0;if($j == 3)$opt3 = 0;if($j == 4)$opt4 = 0;if($j == 5)$opt5 = 0;
					$field_del_ser_chr = array(
										"delivery_service_option"=>$_POST['delivery_service_option_'.$j],
										"delivery_charges_pound"=>$_POST['delivery_charges_pound_'.$j],
										"delivery_charges_euro"=>$_POST['delivery_charges_euro_'.$j],
										"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_'.$j],
										"delivery_service_option"=>"opt".$j,
										"is_selected"=>($_POST['delivery_service_option_chk_'.$j] == 'on'?'yes':'no')
										);

					$dbObj->cupdtii("tbl_delivery_service_charges",$field_del_ser_chr,"id=".$row_delivery_service_chr['id'],"");
				}
				$j++;

			} //End Inner While
		} //End Outer While

		if($opt1)
		{
			$field_del_ser_chr = array(
								"user_id"=>$id,
								"delivery_service_option"=>$_POST['delivery_service_option_1'],
								"delivery_charges_pound"=>$_POST['delivery_charges_pound_1'],
								"delivery_charges_euro"=>$_POST['delivery_charges_euro_1'],
								"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_1'],
								"delivery_service_option"=>"opt1",
								"is_selected"=>($_POST['delivery_service_option_chk_1'] == 'on'?'yes':'no')
								);

			$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
		}
		if($opt2)
		{
			$field_del_ser_chr = array(
								"user_id"=>$id,
								"delivery_service_option"=>$_POST['delivery_service_option_2'],
								"delivery_charges_pound"=>$_POST['delivery_charges_pound_2'],
								"delivery_charges_euro"=>$_POST['delivery_charges_euro_2'],
								"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_2'],
								"delivery_service_option"=>"opt2",
								"is_selected"=>($_POST['delivery_service_option_chk_2'] == 'on'?'yes':'no')
								);

			$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
		}
		if($opt3)
		{
			$field_del_ser_chr = array(
								"user_id"=>$id,
								"delivery_service_option"=>$_POST['delivery_service_option_3'],
								"delivery_charges_pound"=>$_POST['delivery_charges_pound_3'],
								"delivery_charges_euro"=>$_POST['delivery_charges_euro_3'],
								"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_3'],
								"delivery_service_option"=>"opt3",
								"is_selected"=>($_POST['delivery_service_option_chk_3'] == 'on'?'yes':'no')
								);

			$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
		}
		if($opt4)
		{
			$field_del_ser_chr = array(
								"user_id"=>$id,
								"delivery_service_option"=>$_POST['delivery_service_option_4'],
								"delivery_charges_pound"=>$_POST['delivery_charges_pound_4'],
								"delivery_charges_euro"=>$_POST['delivery_charges_euro_4'],
								"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_4'],
								"delivery_service_option"=>"opt4",
								"is_selected"=>($_POST['delivery_service_option_chk_4'] == 'on'?'yes':'no')
								);

			$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
		}
		if($opt5)
		{
			$field_del_ser_chr = array(
								"user_id"=>$id,
								"delivery_service_option"=>$_POST['delivery_service_option_5'],
								"delivery_charges_pound"=>$_POST['delivery_charges_pound_5'],
								"delivery_charges_euro"=>$_POST['delivery_charges_euro_5'],
								"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_5'],
								"delivery_service_option"=>"opt5",
								"is_selected"=>($_POST['delivery_service_option_chk_5'] == 'on'?'yes':'no')
								);

			$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
		}
		///////////END Inserting Records in tbl_delivery_service_charges/////////////

		$description_decode = html_entity_decode($description);
		$field = array("delivery_charges_pound"=>$_POST['delivery_charges_pound'],
					"delivery_charges_euro"=>$_POST['delivery_charges_euro'],
					"delivery_charges_dollar"=>$_POST['delivery_charges_dollar'],
					"refund_policy"=>$description_decode,
					"seller_support_email"=>$_POST['seller_support_email'],
					"tracking_url_code"=>$_POST['tracking_URL'],
					"delivered_tracking_url_code"=>$_POST['delivered_tracking_URL'],
					"affiliate_link"=>$_POST['affiliate_URL'],
					"affiliate_code"=>$_POST['affiliate_code']
				);
		$dbObj->cupdtii("tbl_users",$field,"userid=".$id,"");
		//$s=$msobj->showmessage(243);
		$_SESSION['msg']="<span class='success'>Manage Other Details updated successfully</span>";
		header("location:". SITEROOT . "/admin/user/seller_list.php");exit;
    }

    //----Get the updated id here and display record to manage_lightbox_page_edit.tpl file-----

   if($_GET['userid'])
      {
               $id=$_GET['userid'];
	       $sql="select userid,delivery_charges_pound,delivery_charges_euro,delivery_charges_dollar,refund_policy,seller_support_email,tracking_url_code,delivered_tracking_url_code,affiliate_link,affiliate_code from tbl_users where userid='$id'";
	      
	      $sqlrow=mysql_query($sql)or die(mysql_error());
	      $results = array(); 
              $r=mysql_fetch_array($sqlrow);
                 $userid=$r['userid'];
                 $delivery_charges_pound=$r['delivery_charges_pound'];
                 $delivery_charges_euro=$r['delivery_charges_euro'];
                 $delivery_charges_dollar=$r['delivery_charges_dollar'];
                 $seller_support_email=$r['seller_support_email'];
                 $tracking_url_code=$r['tracking_url_code'];
                 $refund_policy=$r['refund_policy'];
                 $delivered_tracking_url_code=$r['delivered_tracking_url_code'];
                 $affiliate_url=$r['affiliate_link'];
                 $affiliate_code=$r['affiliate_code'];
        ////Old FCK editor code start /////        
//         include_once '../../ckeditor/ckeditor.php' ;
//         require_once '../../ckfinder/ckfinder.php' ;
// 	include("../../editor/fckeditor.php");
// 	$oFCKeditor = new FCKeditor('description') ;
// 	$oFCKeditor->BasePath = '../../editor/';
// 	$oFCKeditor->Value = html_entity_decode($r['refund_policy']);
// 	$oFCKeditor->Width  = '100%';
// 	$oFCKeditor->Height = '400';
// 	$smarty->register_object("oFCKeditor", $oFCKeditor);
	 ////Old FCK editor code end /////
	include_once '../../ckeditor/ckeditor.php' ;
        require_once '../../ckfinder/ckfinder.php' ;
        $ckeditor = new CKEditor('description') ; //
        $ckeditor->basePath	= '../../ckeditor/' ;
        CKFinder::SetupCKEditor($ckeditor, '../../' ) ;
        $initialValue = html_entity_decode($r['refund_policy']); //
        $editorcontentTitle= $ckeditor->editor("description", $initialValue, $config); //
        $smarty->assign("oFCKeditorDesc", $editorcontentTitle);
	
        $smarty->assign('userid', $userid);
        $smarty->assign('delivery_charges_pound',$delivery_charges_pound);
        $smarty->assign('delivery_charges_euro',$delivery_charges_euro);
        $smarty->assign('delivery_charges_dollar',$delivery_charges_dollar);
        $smarty->assign('seller_support_email', $seller_support_email);
        $smarty->assign('tracking_url_code', $tracking_url_code);
        $smarty->assign('delivered_tracking_url_code', $delivered_tracking_url_code);
        $smarty->assign('affiliate_url', $affiliate_url);
        $smarty->assign('affiliate_code', $affiliate_code);
      }

	////////////////////////START to fetching delivery charges label//////////////////////////////////
	$res_delivery_chr = $dbObj->customqry("SELECT * FROM sitesetting WHERE id IN(52,53,54,55,56)","");
	while($row_delivery_chr = @mysql_fetch_assoc($res_delivery_chr))
		$data_delivery_chr[] = $row_delivery_chr;

	$smarty->assign("data_delivery_chr", $data_delivery_chr);

	$res_delivery_service_chr = $dbObj->customqry("SELECT * FROM tbl_delivery_service_charges WHERE set_for = 'user' AND user_id = ".$id,"");
	while($row_delivery_service_chr = @mysql_fetch_assoc($res_delivery_service_chr))
		$data_delivery_service_chr[] = $row_delivery_service_chr;

	$smarty->assign("data_delivery_service_chr", $data_delivery_service_chr);
	/////////////////////////END to fetching delivery charges label///////////////////////////////////

	if(isset($_SESSION['msg']))
	{
		$smarty->assign("msg", $_SESSION['msg']);
		unset($_SESSION['msg']);
	}
	$smarty->display(TEMPLATEDIR . '/admin/user/manage_other_details.tpl');

	$dbObj->Close();
?>