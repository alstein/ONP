<?
/**
* Project:     Tonto
* File:        class.statecountry.php
*
* @author Vasudha Gele <g dot vasudha at agiletechnosys dot com>
* @package Smarty
* @version 2.6.19
*/
Class supplierProfile extends DBTransact
{
	function getUserInfo($userid) 
	{
		$uinfo = $this->gj("tbl_users", "", "userid=".$userid, "", "", "", "", "");		
		while($row_info = @mysql_fetch_assoc($uinfo))
			$userinfo[] = $row_info;
		return $userinfo;
	}	
     
// // get featured service provider
// //Fetch latest supplier
// $feature_user = $dbObj->cgs("tbl_users","*",array("payment_status","type","status"),array("yes","supplier","Active"),"userid desc","limit 3","1");
// while($feture_row = @mysql_fetch_assoc($feature_user)){
// 	$featurearr[] = $feture_row;
// 	$service = $dbObj->cgs("category","*","cat_id",$urow['service_cate'],"","","");
// 	$rservice = @mysql_fetch_assoc($service);
// 	$allservice[] = $rservice['cat'];
// } 
	//get Featured Service Providers
 	function getserviceProvider()
	{
		$ob = "userid";

		$gb = "userid";
		
		$ad = 'desc';
		
		$l = 3;
		
		$prn = '';
		$cdn = "payment_status ='yes' and type ='supplier' and status ='Active'"; 
		$feature_user = $this ->gj('tbl_users',"*",$cdn , $ob , $gb , $ad , $l , $prn);
		while($feture_row = @mysql_fetch_assoc($feature_user))
			$featurearr[] = $feture_row; 
		return $featurearr;
	}

     //get previous question n answer

	function getanswer()
	{
			
		$result = $this ->gj("inbox" , "" , "1" , "" , "" , "" , 3 , ""); 
		while($result_row = @mysql_fetch_assoc($result))
			$faqarr[] = $result_row; 
		return $faqarr;
	}
	function getServiceInfo($userid)
	{
			
		$fields = array( "userid" , "address" , "service_details" , "service_experience" );

		$cdn = " userid ='$userid'";
		
		$ad = 'desc';
		
		$l = 1;
		
		$prn = '';  
		
		$serviceresult = $this->gj('service' , $fields , $cdn , 'id' , '' , $ad , $l , $prn);
		while($servi_row = @mysql_fetch_assoc($serviceresult))
			$servarr[] = $servi_row; 
		return $servarr;
	}
	function insertQuestion($question)
	{
			
		$fields = "question"; 

		$values = $question;
		
		$prn = 1;
		
		$result = $this ->cgi('inbox' , $fields , $values , $prn); 
	}			
}
?>