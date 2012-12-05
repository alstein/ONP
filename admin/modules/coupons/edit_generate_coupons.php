<?php
include_once("../../../include.php");
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');


if(!$_SESSION['duAdmId'])
	header("location:". SITEROOT . "/admin/login/index.php");

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}

   // Generate a random character string
   function randUniqueCoupId($length = 10, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789')
   {
      // Length of character list
      $chars_length = (strlen($chars) - 1);
   
      // Start our string
      $string = $chars{rand(0, $chars_length)};
      
      // Generate random string
      for ($i = 1; $i < $length; $i = strlen($string))
      {
         // Grab a random character from our list
         $r = $chars{rand(0, $chars_length)};
         
         // Make sure the same two characters don't appear next to each other
         if ($r != $string{$i - 1}) $string .=  $r;
      }
      
      // Return the string
      //## return $string;
      //Before direct return to coupon unqiue value need to check if it's already exist into DB.
      //Chk generated coupon unique coupon code is not allready exist
      $query = "select * from tbl_coupon_master_uniqueids where coupon_unique_id = '".strtoupper($string)."'";
      $rs = mysql_query($query);
      $num = @mysql_num_rows($rs);
      if($num < 1)
      {
         return strtoupper($string);
      }else
      {
         randUniqueCoupId();
      }
} 

	if(strlen(trim($_POST['submit'])) > 0){
		$f_array = array("credit_amount_pound"	=> trim($_POST['credit_amount_pound']),
		                      "credit_amount_euro"	=> trim($_POST['credit_amount_euro']),
		                      "credit_amount_dollar"	=> trim($_POST['credit_amount_dollar']),
					"no_of_coupons"		=> trim($_POST['no_of_coupons']),
					"expire_date"		=> $_POST['expire_date']);

			$insertedCoupId = $dbObj->cgii("tbl_coupon_master",$f_array,"");

         if($insertedCoupId > 0)
         {
            for($l = 0;$l < $_POST['no_of_coupons'];$l++)
            {
               //$uniquecouponid = rand(1, 9999999999);
               $uniquecouponid = randUniqueCoupId();
               $ins_array = array(
                              "coupon_id"=>$insertedCoupId,
                              "coupon_unique_id"=>$uniquecouponid,
                              "used"=>0
                           );
               $dbObj->cgii("tbl_coupon_master_uniqueids",$ins_array,"");
            }
         }

			$_SESSION['msg']="<span class='success'>Promotional code added successfully.</span>";
		        header("location:".SITEROOT."/admin/modules/coupons/generate_coupons_list.php");
	}

	$smarty->display(TEMPLATEDIR . '/admin/modules/coupons/edit_generate_coupons.tpl');

	$dbObj->Close();

?>
