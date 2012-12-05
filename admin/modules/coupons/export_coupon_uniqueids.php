<?php
include_once("../../../include.php");

$coupon_id = ($_GET['coupon_id']?$_GET['coupon_id']:0);

$query = "select * from tbl_coupon_master where coupon_id = '".$coupon_id."'";

$coupondet_res = mysql_query($query);
$coupondet_row = mysql_fetch_assoc($coupondet_res);

			$sStr = "";
			$__lineBreker = "\n";
			$sStr = "Promotional Code Information".$__lineBreker;
			$sStr .="$__lineBreker";
			$sStr .="$__lineBreker";
			$sStr .= 'Amount as Promotional Code';
			$sStr .="$__lineBreker";
			$sStr .= 'Pound (£), '.$coupondet_row['credit_amount_pound'].'';
			$sStr .="$__lineBreker";
			$sStr .= 'Euro (€), '.$coupondet_row['credit_amount_euro'].'';
			$sStr .="$__lineBreker";
			$sStr .= 'Dollar ($), '.$coupondet_row['credit_amount_dollar'].'';
			$sStr .="$__lineBreker";
			$sStr .= 'Number of Promotional Code,'.$coupondet_row['no_of_coupons'].'';
			$sStr .="$__lineBreker";
			$sStr .= 'Expiration Date,'.date("Y-m-d",strtotime($coupondet_row['expire_date'])).'';
			$sStr .="$__lineBreker";
			//$sStr .= 'Restrictions,'.(($coupondet_row['restrictions']=='all_user')?'All Users':'New Users').'';
			$sStr .="$__lineBreker";
			
			$rs_coupUnq_query = "select * from tbl_coupon_master_uniqueids where coupon_id = '".$coupon_id."' order by uniqueid";

			$rs = mysql_query($rs_coupUnq_query);

			$sStr .="$__lineBreker";
			$sStr .="Sr. No.,Unique Promotional Code,Used/Not Used";
			$sStr .="$__lineBreker";
			$sStr .="$__lineBreker";
                        $i=1;
			while($row = @mysql_fetch_assoc($rs)){
				$sStr .=$i.",".$row['coupon_unique_id'].",".(($row['used']=='1')?'Used':'Not Used')."";

				$sStr .="$__lineBreker";
				$i++;
			}



		$newFileName = '../file.csv'; //file name that you want to createmy
		$fpWrite = @fopen($newFileName, "w"); // open file as writable

		echo $sStr;
		
		@fwrite($fpWrite, $sStr); //now write to csv file
		@fclose($fpWrite);//close file
		$dir      = SITEROOT."/";
		$file="file.csv";
		
		header("Content-type: application/force-download");
		header('Content-Disposition: inline; filename="' . $dir.$file . '"');
		header("Content-Transfer-Encoding: Binary");
		//header("Content-length: ".filesize($dir.$file));
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . $file . '"');
		//readfile("$dir$file");

?>