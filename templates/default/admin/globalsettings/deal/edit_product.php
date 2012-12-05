<?php
session_start();
ob_start();
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/common.lib.php");
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("10", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

#----code for deleting images-------#

function remove_item_by_value($array, $val = '', $preserve_keys = true) {
	if (empty($array) || !is_array($array)) return false;
	if (!in_array($val, $array)) return $array;

	foreach($array as $key => $value) {
		if ($value == $val) unset($array[$key]);
	}

	return ($preserve_keys === true) ? $array : array_values($array);
}

  $deal_img = $dbObj->gj("tbl_deal","*","deal_unique_id = '{$_GET['id']}'","","","","","");
  $deal_row = @mysql_fetch_assoc($deal_img);	

if($_GET['delete']){
	 	$mImage1 = explode(",",$deal_row['small_image']);
		$mImage2= explode(",",$deal_row['medium_image']);
		$mImage3 = explode(",",$deal_row['big_image']);
	
		if(in_array($_GET['delete'],$mImage1)){
			$removeThis = $_GET['delete'];
			$newArray1 = remove_item_by_value($mImage1, $removeThis);
			$newArray2 = remove_item_by_value($mImage2, $removeThis);
			$newArray3 = remove_item_by_value($mImage3, $removeThis);
       
         @unlink("../../../uploads/product/thumb577X385/".$removeThis);
         @unlink("../../../uploads/product/thumb122X145/".$removeThis);
         @unlink("../../../uploads/product/thumb32X32/".$removeThis);
         @unlink("../../../uploads/".$removeThis);  
      

			$newImgArray1 = implode(",", $newArray1);
			$newImgArray2 = implode(",", $newArray2);
			$newImgArray3 = implode(",", $newArray3);

			$f = array("small_image","medium_image","big_image");
			$v = array($newImgArray1,$newImgArray2,$newImgArray3);

			$dbObj->cupdt("tbl_deal", $f, $v,"deal_unique_id",$_GET['id'],"");
			@header("Location:".SITEROOT."/admin/globalsettings/deal/edit_product.php?id=".$_GET['id']);
		}
	}


#--------------end------------------#

#----------ordering---------#

if($_GET['mode']){
		
		$mImage1 = explode(",",$deal_row['small_image']);
		$mImage2= explode(",",$deal_row['medium_image']);
		$mImage3 = explode(",",$deal_row['big_image']);

		function swap ($ary,$element1,$element2)
		{
		$temp= array();
		$temp=$ary[$element1];
		$ary[$element1]=$ary[$element2];
		$ary[$element2]=$temp;
		return $ary;
		}

		$mImage11= swap($mImage1,0,$_GET['order']);
		$mImage22= swap($mImage2,0,$_GET['order']);
		$mImage33= swap($mImage3,0,$_GET['order']);
		
			

		//echo "<pre>";print_r($myArray);
		$newImgArray1 = implode(",", $mImage11);
		$newImgArray2 = implode(",", $mImage22);
		$newImgArray3 = implode(",", $mImage33);

		$f = array("small_image","medium_image","big_image");
		$v = array($newImgArray1,$newImgArray2,$newImgArray3);

		$dbObj->cupdt("tbl_deal", $f, $v,"deal_unique_id",$_GET['id'],"");
		@header("Location:".SITEROOT."/admin/globalsettings/deal/edit_product.php?id=".$_GET['id']);
		
	}


#------end-----------#

$row3="";

if(isset($_POST['box']))
{
    ?><script language="javascript"> self.parent.tb_remove();</script><?php exit;
}

#--------------------Edit Deal----------------------#
if(isset($_POST['Submit']))
{
        $cat_rs = $dbObj->gj("mast_deal_category","id","category = '".$_POST['category']."'","","","","","");
        if($cat_rs == "n")
        {
            $field = array("userid"=>$_SESSION['csUserId'],"category"=>$_POST['category'],"date"=>date('Y-m-d'),"parent_id"=>0,"category_type"=>$_POST['deal_type'],"active"=>1);
            $cat_id = $dbObj->cgii("mast_deal_category",$field,"");
        }
        else
        {
            $cat = mysql_fetch_assoc($cat_rs);
            $cat_id = $cat['id'];
        }
    
        $subcat_rs = $dbObj->gj("mast_deal_category","id","category = '".$_POST['subcategory']."'","","","","","");
        if($cat_rs == "n")
        {
            $field = array("userid"=>$_SESSION['csUserId'],"category"=>$_POST['subcategory'],"date"=>date('Y-m-d'),"parent_id"=>$cat_id,"category_type"=>$_POST['deal_type'],"active"=>1);
            $subcat_id = $dbObj->cgii("mast_deal_category",$field,"");
        }
        else
        {
            $subcat = mysql_fetch_assoc($subcat_rs);
            $subcat_id = $subcat['id'];
        }
	$str     = $_POST['title1'];
		$order   = array("(",")",":","$","#","@","%","^","*","[","]","&","{","}","|","/","_","+","!","~","`","?","<",".",",",">","'");
		$replace = '';
		$url_title = str_replace($order, $replace, $str);
		$title2=str_replace(" ","-",$url_title);
		
		
		 $tit= array();
	
     		$is_title = $dbObj->gj("tbl_deal","url_title","deal_unique_id != '{$_GET['id']}' and url_title like '".$title2."%'","","","","","");

     		while($title_row = @mysql_fetch_assoc($is_title))
     		{
         		$tit[] =$title_row;
			if($title_row['url_title']==$title2)
          		{
          			$title2.="-";
          		}
     		}

//echo "<pre>"; print_r($_POST); echo "</pre>"; exit;

//featured
if($_POST['3']== "")
{
$featured=0;
}
else
{
$featured=1;
}

//news letter subscription
if($_POST['10']== "")
{
$news_subscribe=0;
}
else
{
$news_subscribe=1;
}

if($_POST['4']!= "" || $_POST['5']!= "")
		{
		       $page_featured='yes';
		}
		else
		{
		       $page_featured='no';
		}

	$field_array = array(
	    "deal_cat"=>$cat_id,
	    "deal_subcat"=>$subcat_id,
            "title"=>$_POST['title1'],
	    "url_title"=>$title2,
	    "description"=>$_POST['description'],
	    "highlight"=>$_POST['highlight'],
	    "fineprint"=>$_POST['fineprint'],
	    "sub_delivery_cost"=>trim($_POST['delivery_cost']),
	    "payment_method"=>$_POST['payment_type'],
	    "vedio_link"=>trim($_POST['videolink']),
	    "groupbuy_price"=>$_POST['price'],
	    "orignal_price"=>$_POST['originalprice'],
	    "quantity"=>trim($_POST['quantity']),
	    "min_buyer"=>$_POST['min_buyer'],
	    "max_buyer"=>$_POST['max_buyer'],
	    "start_date"=>$_POST['dob1']." ".$_POST['start_hour'].":".$_POST['start_min'].":00",
	    "end_date"=>$_POST['dob2']." ".$_POST['end_hour'].":".$_POST['end_min'].":00",
            "comments"=>$_POST['comments'],
            "deal_type"=>$_POST['deal_type'],
            "show_deal_tag"=>$_POST['show_deal_tag'],
            "deal_tag"=>$_POST['deal_tag'],
            "featured"=>$featured,
           "featured_page"=>$page_featured,
	    "news_subscribe"=>$news_subscribe,
        "deal_ending"=>$_POST['endingsoon'],
        "validfrom"=>$_POST['validfrom'],
       "validto"=>$_POST['validto']
        
       

	);

        //echo "<pre>"; print_r($field_array); echo "</pre>"; exit;

        if($_POST['option_selected'] != "")
        {
            $field_array = array_merge($field_array,array("final_value"=>$_POST['final_value']));
            $field_array = array_merge($field_array,array("listing_value"=>$_POST['listing']));
            $field_array = array_merge($field_array,array("option_selected"=>$_POST['option_selected']));
	}

        if($_POST['website'] != "")
        {
            $field_array = array_merge($field_array,array("option_website"=>$_POST['website']));
        }
        if($_POST['shop_addr'] != "")
        {
            $field_array = array_merge($field_array,array("shop_location"=>$_POST['shop_addr']));
        }

        #--------------Set deal images---------------#
	extract($_FILES);
        //echo "<pre>"; print_r($_FILES); echo "</pre>";

	#---code for image upload start---#	
	if($_SESSION['selectedimage'] !='')
	{
		if($deal_row['small_image'] !='')
		{

			  $small_picture = $deal_row['small_image'].",".$_SESSION['selectedimage'];
            		  $medium_picture =$deal_row['medium_image'].",".$_SESSION['selectedimage'];
            		  $big_picture = $deal_row['big_image'].",".$_SESSION['selectedimage'];
			
		}
		else
		{
			  $small_picture =$_SESSION['selectedimage'];
            		  $medium_picture =$_SESSION['selectedimage'];
            		  $big_picture =$_SESSION['selectedimage'];	
		}
	}
	else		
	{
	
			  $small_picture = $deal_row['small_image'];
            		  $medium_picture= $deal_row['medium_image'];
            		  $big_picture =$deal_row['big_image'];	
	}
	
	    $field_array = array_merge($field_array,array("small_image"=>$small_picture));
            $field_array = array_merge($field_array,array("medium_image"=>$medium_picture));
            $field_array = array_merge($field_array,array("big_image"=>$big_picture));

	#---code for image upload end ---#


/*
        if($_SESSION['selectedimage'])
        {
            $small_picture = $_SESSION['selectedimage']; 
            $medium_picture = $_SESSION['selectedimage']; 
            $big_picture = $_SESSION['selectedimage'];
    
            $field_array = array_merge($field_array,array("small_image"=>$small_picture));
            $field_array = array_merge($field_array,array("medium_image"=>$medium_picture));
            $field_array = array_merge($field_array,array("big_image"=>$big_picture));
        }*/
        //echo "<pre>"; print_r($field_array); echo "</pre>"; exit;
        
	$dbObj->cupdtii('tbl_deal',$field_array,"deal_unique_id = '{$_GET['id']}'","");

	$s=$msobj->showmessage(150);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
        
	header("Location:".SITEROOT."/admin/globalsettings/deal/manage_deal.php");
	exit;
}
#------------------End update deal----------#
$_SESSION['selectedimage']="";

if($_GET['id'])
{
	$res1 = $dbObj->cgs("tbl_deal d LEFT JOIN mast_deal_category as c ON d.deal_cat = c.id LEFT JOIN mast_deal_category as s ON d.deal_subcat = s.id ","d.*,c.category as category,s.category as sub_category","deal_unique_id",$_GET['id'],"","","");
	
	if($res1 != 'n')
	{
            $row3 = @mysql_fetch_assoc($res1);
            $s_date = explode(" ",$row3['start_date']);
            $start_date = $s_date[0];
            $s_arr = explode(":",$s_date[1]);
            $s_hr = $s_arr[0];
            $s_min = $s_arr[1];
            $e_date = explode(" ",$row3['end_date']);
            $end_date = $e_date[0];
            $e_arr = explode(":",$e_date[1]);
            $e_hr = $e_arr[0];
            $e_min = $e_arr[1];

            $from_date = explode(" ",$row3['validfrom']);
            $end_validfrom = $from_date[0];

            $to_date = explode(" ",$row3['validto']);
            $end_dateto = $to_date[0];


            $smarty->assign("fromdates",$end_validfrom);
            $smarty->assign("todates",$end_dateto);



            $smarty->assign("start_date",$start_date);
            $smarty->assign("end_date",$end_date);
            $smarty->assign("s_hr",$s_hr);
            $smarty->assign("s_min",$s_min);
            $smarty->assign("e_hr",$e_hr);
            $smarty->assign("e_min",$e_min);
            
            include_once '../../../ckeditor/ckeditor.php' ;
            require_once '../../../ckfinder/ckfinder.php' ;
            $initialValue = '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' ;
            $ckeditor = new CKEditor( ) ;
            $ckeditor->basePath	= '../../../ckeditor/' ;
            CKFinder::SetupCKEditor($ckeditor, '../../' ) ;
            $config['toolbar'] = array(
            array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike' ),
            array( 'NumberedList','BulletedList','-','Image','Format','FontSize','TextColor','BGColor'));
            $initialValue = stripslashes(html_entity_decode($row3['description']));
            $editorcontent= $ckeditor->editor("description", $initialValue, $config);
            //print_r($editorcontent);
            $smarty->assign("oFCKeditor", $editorcontent);
            $initialValue1 = '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' ;
            $initialValue1 = stripslashes(html_entity_decode($row3['highlight']));
            $editorcontent1= $ckeditor->editor("highlight", $initialValue1, $config);
            //print_r($editorcontent);
            $smarty->assign("oFCKeditor1", $editorcontent1);

            $initialValue1 = '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' ;
            $initialValue2 = stripslashes(html_entity_decode($row3['fineprint']));
            $editorcontent2= $ckeditor->editor("fineprint", $initialValue2, $config);
            //print_r($editorcontent);
            $smarty->assign("oFCKeditor2", $editorcontent2);

            if( $row3['small_image'])
                $s_img = explode(",",$row3['small_image']);
            $smarty->assign("deal_img",$s_img);
            $smarty->assign("deal_img_cnt",count($s_img));

            $smarty->assign("deal_info",$row3);

            
            #----------Get seller type option-----------------#
           
            $sto=$dbObj->customqry("select * from tbl_sellertype_option where sell_id != 11","");
            
            while($row1=@mysql_fetch_array($sto))
            {
                $selleroption1[]=$row1;
            }
            //echo "<pre>"; print_r($selleroption1); echo "</pre>";
            $smarty->assign("selleroption",$selleroption1);
           
            #----------Get seller type option-----------------#

            //-------------------get payment getway type----------------------------//
            $payment_rs = $dbObj->gj("tbl_billing_info","*","user_id='".$row3['seller_id']."'","","","","","");
            
            while($row = @mysql_fetch_assoc($payment_rs))
            {
                $payment[] = $row;
            }
            $smarty->assign("payment",$payment);

             //make selected option array
            $opt = explode(",",$row3['option_selected']);
            $smarty->assign("opt",$opt);

            //make selected payment option
            $pay = explode(",",$row3['payment_method']);
            $smarty->assign("pay",$pay);
            //-------------------end get payment getway type----------------------------//
	}

	$days = range(2,30);
	$smarty->assign("days",$days);
	$hours = range(0,23);
	$smarty->assign("hours",$hours);


#--------------Get Time--------------------#
	$i = 0;
	$hr = array();	
	for($hh = 0; $hh <=23; $hh++) 
	{
		if($hh<10)
			$hh = "0$hh"; 
		else
			$hh = $hh;
		$hr[$i] = $hh;
		$i++;
	}
	$rev_hr = array_reverse($hr);
	$smarty->assign("rev_hr",$rev_hr);
	$smarty->assign("hr",$hr);
        $smarty->assign("delivery_hrs",$hr);

	$i = 0;
	$min = array();	
	for($mm = 0; $mm <=59; $mm++) 
	{
		if($mm<10)
			$mm = "0$mm"; 
		else
			$mm = $mm;
		$min[$i] = $mm;
		$i++;
	}
	$rev_min = array_reverse($min);
	$smarty->assign("rev_min",$rev_min);
	$smarty->assign("min",$min);
        $smarty->assign("delivery_mins",$min);

        $days = range(2,30);
	$smarty->assign("days",$days);
	$hours = range(0,23);
	$smarty->assign("hours",$hours);

#---------------End Time-------------------#

    #--------------Get seller type--------------#
    $rs1=mysql_query("select * from tbl_seller_type where Active=1");
    while($row1=@mysql_fetch_array($rs1))
    {
    $seller1[]=$row1;
    }
    $smarty->assign("seller1",$seller1);
    #--------------Get seller type--------------#
    
    #-----------------Get city--------------------#
    $_re1 = $dbObj->cgs("mast_city","",array("status"),array("Active"),"city_name","DESC","");
    $num = @mysql_num_rows($_re1);
    $_arr = array();
    while($_row2 = @mysql_fetch_assoc($_re1))
    {
            $_arr2[] = $_row2;
    }
    $smarty->assign("city",$_arr2);
    #-----------------Get city--------------------#
    
    #---------get category--------------------#
    $selectCategory = $dbObj->gj("mast_deal_category as c", "c.*" , "1", "", "", "",  "", "");
    while($row=@mysql_fetch_array($selectCategory))
    {
        $dealcategory[]=$row;
    }
    $smarty->assign("dealcategory",$dealcategory);
    #---------get category--------------------#
    
    #---------get seller type --------------------#
    if($row3['seller_id']==1)
	{
	$seltype_rs = $dbObj->gj("tbl_deal", "company_type", "deal_unique_id = '".$_GET['id']."'", "", "", "",  "", "");
	}
	else
	{
	 $seltype_rs = $dbObj->gj("tbl_users", "company_type", "userid = '".$row3['seller_id']."'", "", "", "",  "", "");
	}
    $seltype=@mysql_fetch_array($seltype_rs);
    
    $smarty->assign("seller_type",$seltype['company_type']);
    #---------get seller type --------------------#

}
#------------Display Message----------------#
if($_SESSION['msg'])
{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg']=NULL;
	unset($_SESSION['msg']);
}
#--------------------------------------------#

$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/edit_product.tpl');
$dbObj->Close();
?>
