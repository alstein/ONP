<?php
class Combo {
     
	function __construct(){
			
	} // end function
	
	function getComboCities($valuefield='city_id', $showfield='city_name', $ob='ASC', $cdn=1, $selvalue, $prn ){
		global $dbObj;
      		return $dbObj->cddSmarty('mast_city', $valuefield, $showfield, $ob, $cdn, $selvalue, $prn);
	}

	function getComboCitiesName($valuefield='city_name', $showfield='city_name', $ob='ASC', $cdn=1, $selvalue, $prn ){
		global $dbObj;
      		return $dbObj->cddSmarty('mast_city', $valuefield, $showfield, $ob, $cdn, $selvalue, $prn);
	}
	
	function getComboCountry($valuefield='countryid', $showfield='country', $ob='ASC', $cdn=1, $selvalue, $prn ){
		global $dbObj;
      		return $dbObj->cddSmarty('mast_country', $valuefield, $showfield, $ob, $cdn, $selvalue, $prn);
	}
	
	function getComboDealCat($valuefield='cate_id', $showfield='category_name', $ob='ASC', $cdn=1, $selvalue, $prn ){
		global $dbObj;
      		return $dbObj->cddSmarty('tbl_deal_category', $valuefield, $showfield, $ob, $cdn, $selvalue, $prn);
	}

	function getComboMastDealCat($valuefield='id', $showfield='category', $ob='ASC', $cdn=1, $selvalue, $prn ){
		global $dbObj;
      		return $dbObj->cddSmarty('mast_deal_category', $valuefield, $showfield, $ob, $cdn, $selvalue, $prn);
	}

	function getComboMastAffilDealCat($valuefield='id', $showfield='category', $ob='ASC', $cdn=1, $selvalue, $prn ){
		global $dbObj;
      		return $this->cddSmartyModifiedForAffiliateDeal('mast_deal_category_affiliate', $valuefield, $showfield, $ob, $cdn, $selvalue, $prn);
	}
	
	function getComboDealType($valuefield='typeid', $showfield='dealtype', $ob='ASC', $cdn=1, $selvalue, $prn ){
		global $dbObj;
      		return $dbObj->cddSmarty('tbl_dealtype', $valuefield, $showfield, $ob, $cdn, $selvalue, $prn);
	}

	function cddSmartyModifiedForAffiliateDeal($tbl, $valfield, $showfield, $ob, $cdn, $selvalue, $prn)
	{
		//echo "hello";
		$query.=" SELECT ".$showfield.", ".$valfield." FROM  ".$tbl ;
		$query.=" WHERE $cdn ORDER BY ".$ob;
		if($prn)
		{
			echo $query;
		}
		$opt	='';
		$result = @mysql_query($query) or die(mysql_error());
		$num = mysql_num_rows($result);
		if($num<1)
		{
			return "n";
		}
		else
		{
			for($k=0; $k<mysql_num_rows($result); $k++)
			{
				$row=mysql_fetch_array($result);

				if($selvalue == $row[$valfield])
				$selected = " selected";
				else
				$selected = "";

				$opt	.= "<option value='AF".$row[$valfield]."' ".$selected.">".$row[$showfield]."</option>\n";

			}
			return $opt;
		}
	}

} // end class
$combo = new Combo();
?>