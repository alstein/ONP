<?php
/********************************************************************************
*	Filename: database.php
*	Purpose: All the generic database related functions and global object functions are located in this
*   file. The main pages call the global database functions and depending on the parameters passed,
*	queries are generated dynamically and results are returned to the processing script.
*	Author: Chetan Kelkar k[dot]chetan[at][dot]com
*	Creation Date: 3/27/2006
*	Last Modified: 3/27/2006
***********************************************************************************/

include_once("SiteConfig.php");


function ServerTime(){
	global $application;
	if($application == "local")
		return  mktime(date("H",time())+5,date("i",time())+30,date("s",time()),date("m",time()),date("d",time()),date("Y",time()));
	else
		return  mktime(date("H",time())+12,date("i",time())+30,date("s",time()),date("m",time()),date("d",time()),date("Y",time()));

}

Class DBTransact {

	var $row_cnt = 0;

	function Connect()
	{
		mysql_connect(HST, USR, PWD) OR die("Failed Connecting To Mysql");
		mysql_select_db(DBN) OR die("Failed Connecting To Database");
		//include_once("../libs/Smarty.Class.php");

	}

	function Close()
	{
		mysql_close() OR die("Failed To Close Connection.");
	}

	/*************************************************************************
	*	Table of Contents: Global Database functions 01/04/2008
	*	Author(s) : Yogesh Kadam<k.yogesh@.com>
	*	to write your custom query.
	***************************************************************************/

	function customqry($qry, $prn)
	{
		$rs=@mysql_query($qry);
		if($prn)
			echo $qry;
		return $rs;
	}

	/**************************************************************************************
	*	Table of Contents: Global Database functions 5/4/2006
	*	Author(s) : Chetan Kelkar <k.chetan@.com> | Nilesh Gaikwad<g.nilesh@.com
	*	1. globalselect($tblname, $wherefields, $wherevalues, $orderbyfield, $ad)
	*	Select records from table.
	***************************************************************************************/

	function cgs($tbl, $sf, $wf, $wv, $ob, $ot, $prn)
	{

		$sql = "SELECT ";
		if(is_array($sf))
		{
			$fields = implode(",", $sf);
		}
		else
		{
			if($sf)
			$fields = $sf;
			else
			$fields = "*";
		}
		if(is_array($wf)){
			$cntwf = sizeof($wf);
			if($cntwf > 0){
				for($j=0; $j<$cntwf; $j++){
					if(is_numeric($wv[$j]))
					$condition.= " " . $wf[$j] ."=". mysql_real_escape_string($wv[$j]). " ";
					else
					$condition.= " " . $wf[$j] ."='". mysql_real_escape_string($wv[$j]). "' ";

					if($j<$cntwf-1)
					$condition .= " and ";
				}
			}
		}
		else
		{
			if($wf)
			$condition = " $wf = '$wv' ";
			else
			$condition ="1";
		}


		$query = $sql.''.$fields." FROM ".$tbl." WHERE ".$condition;
		if($ob)
		{
			$query.=" ORDER BY ".$ob;
		}

		if($ot)
		{
			$query.=" ".$ot;
		}
		if($prn)
		{
			echo $query;
		}

		$result = @mysql_query($query) or die(mysql_error());
		$num = mysql_num_rows($result);
		if($num<1)
		{
			$retval = "n";
		}
		else
		{
			$retval = $result;
		}

		return $retval;
	}
/*****************************************************************************************************************
*	Table of Contents: Global Database functions 5/4/2006
*	Author(s) : Chetan Kelkar <k.chetan@.com> | Nilesh Gaikwad<g.nilesh@.com
*	1. globalchkexist($tblname,$wherefield,$wherevalue);
*	Check wheather the particular value exist in the table or not.
*****************************************************************************************************************/
	function globalchkexist($tblname, $wherefields, $wherevalues, $prn)
	{
		$query.=" SELECT * FROM  ".$tblname ;
		if(is_array($wherefields))
		{
			if(sizeof($wherefields) > 0)
			{
				for($j=0; $j<sizeof($wherefields); $j++)
				{
					if(strstr($wherevalues[$j],".") && !strstr($wherevalues[$j],"@"))
					$condition.= " $wherefields[$j] = $wherevalues[$j] ";
					else
					$condition.= " $wherefields[$j] = '$wherevalues[$j]' ";

					if($j<sizeof($wherefields)-1)
					$condition .= " and ";
				}
			}
		}
		else
		{
			if($wherefields)
			$condition = " $wherefields = '$wherevalues' ";
			else
			$condition ="1";
		}

		/*if($wherefield)
		{
			$condition.=" $wherefield = '$wherevalue' ";
		}
		else
		{
			$condition ="1";
		}*/

		 $query.=" WHERE $condition ";
		//echo "<br>asa".$query;
		//die;

		if($prn==1)
		{
			echo $query;exit;
		}
		$result = @mysql_query($query) or die(mysql_error());

		//return (@mysql_num_rows($result) > 0)?true:false;
		$mm = @mysql_num_rows($result);
		if($mm=="")
	{
			$a =0;
		}
		else if($mm==0)
		{
			$a = 0;
		}
		else
		{
			$a = $mm;
		}
		return $a;

	}

	/**********************************************************************************
	*	Table of Contents: Global Database functions 5/4/2006
	*	Author(s) : Chetan Kelkar <k.chetan@.com> | Nilesh Gaikwad<g.nilesh@.com
	*	1. globalinsert($tblname, $fields,$values);
	*	Insert record into the table.
	*****************************************************************************************/
	function cgi($tbl, $fl, $vl, $prn)
	{

	$tblname = $tbl;
	$fields = $fl;
	$values = $vl;

		$sql.= "INSERT INTO ".$tblname." ";

		$fieldnames.="(";
		if(is_array($fields))
		{
			for($i=0; $i<sizeof($fields); $i++)
			{
				$fieldnames.= $fields[$i];
				if($i<sizeof($fields)-1)
				$fieldnames.= ", ";
			}
			$fieldnames.= ") ";

			$value.= " VALUES (";
			if(sizeof($values) > 0)
			{
				for($i=0; $i<sizeof($values); $i++)
				{
					
					//$value.= "'".$values[$i]."'";
					$value.= "'".$this->sanitize($values[$i])."'";
					if($i<sizeof($values)-1)
					$value.= ", ";
				}
			}
			$value.= ")";
		}
		else
		{
			$fieldnames .= $fields.')';
			$value = " VALUES "."('".$values."')";
		}
		 $query = $sql.$fieldnames.$value;
		if($prn)
		{
			echo $query;
		}

		$result = @mysql_query($query) or die(mysql_error());
		return mysql_insert_id();
	}

	function cgii($tbl, $flvl, $prn){
		$tblname = $tbl;
		$fields = array_keys($flvl);
		$values = array_values($flvl);

		$sql.= "INSERT INTO ".$tblname." ";

		$fieldnames.="(";
		if(is_array($fields))
		{
			for($i=0; $i<sizeof($fields); $i++)
			{
				$fieldnames.= $fields[$i];
				if($i<sizeof($fields)-1)
				$fieldnames.= ", ";
			}
			$fieldnames.= ") ";

			$value.= " VALUES (";
			if(sizeof($values) > 0)
			{
				for($i=0; $i<sizeof($values); $i++)
				{
					//$value.= "'". $this->quotes_to_entities($values[$i])."'";
					$value.= "'".$this->sanitize($values[$i])."'";
					if($i<sizeof($values)-1)
					$value.= ", ";
				}
			}
			$value.= ")";
		}
		else
		{
			$fieldnames .= $fields.')';
			$value = " VALUES "."('".$values."')";
		}
		 $query = $sql.$fieldnames.$value;
		if($prn)
		{
			echo $query;
		}

		$result = @mysql_query($query) or die(mysql_error());
		return mysql_insert_id();
	}

	/******************************************************************
	*	Table of Contents: Global Database functions 5/4/2006
	*	Author(s) : Chetan Kelkar <k.chetan@.com> | Nilesh Gaikwad<g.nilesh@.com
	*	1. globaldelete($tblname,$wherefield,$wherevalue);
	*	Delete particular record from the table.
	**********************************************************************/
	function gdel($tbl, $wf, $wv, $prn)
	{

		$query.=" DELETE FROM  ".$tbl ;
		if(is_array($wf))
		{
			if(sizeof($wf) > 0)
			{
				for($j=0; $j<sizeof($wf); $j++)
				{

					$condition.=" $wf[$j] = '$wv[$j]'";
					if($j<sizeof($wf)-1)

					$condition.=" and";

				}
			}
		}
		else
		{
			$condition = "$wf = '$wv'";
		}
		$query.=" WHERE $condition ";
		if($prn)
		{
			echo $query;
			exit;
		}
		$result = @mysql_query($query) or die(mysql_error());
		return $result;
	}

	/***********************************************************************************
	*	Table of Contents: Global Database functions 5/4/2006
	*	Author(s) : Chetan Kelkar <k.chetan@.com> | Nilesh Gaikwad<g.nilesh@.com
	*	1. cupdt($tblname,$setfield,$setvalue,$wherefields,$wherevalues);
	*	Update record in the table.
	*******************************************************************************************/

	function cupdtii($tablename,$field_values_array,$condition,$prn=""){
		$fields = array_keys($field_values_array);
		$values = array_values($field_values_array);

		$query.= "UPDATE ".$tablename." SET ";
		$del = "";

		foreach($field_values_array as $key=>$value){
			$update_vars.=$del.$key." = '".$this->sanitize($value)."' ";
			$del = ",";
		}
		$query.= $update_vars;
		$query.= " where ".$condition;
		if($prn==1){
			echo $query;
		}
		$result = @mysql_query($query) or die(mysql_error());
	}

	function cupdt($tbl, $sf, $sv, $wf, $wv, $prn)
	{
		$query.=" UPDATE ".$tbl." SET " ;

		/* Here updating fields and values are composed */

		if(is_array($sf))
		{
			if(sizeof($sf) > 0)
			{
				for($j=0; $j<sizeof($sf); $j++)
				{
					//$update_vars.= " $sf[$j] = '$sv[$j]' ";
					$update_vars.= " $sf[$j] ='".$this->sanitize($sv[$j])."' ";
					if($j<sizeof($sf)-1)
					$update_vars .= ", ";
				}
			}
		}
		else
		{
			$update_vars.= " $sf = '$sv' ";
		}

		$query.= $update_vars;

		/*Here condition is created*/

		if(is_array($wf))
		{
			if(sizeof($wf) > 0)
			{
				for($k=0; $k<sizeof($wf); $k++)
				{
					$condition.= " $wf[$k] = '$wv[$k]' ";

					if($k<sizeof($wf)-1)
					$condition .= " and ";
				}
			}
		}
		else
		{
			if($wf)
				$condition = $wf." = '$wv' ";
			else
				$condition="1";
		}
		$query.= " WHERE $condition ";
		if($prn==1)
		{
			echo $query;
		}
		$result = @mysql_query($query) or die(mysql_error());
		return $result;
	}


	/*********************************************************************************
	* Function : Creating for complex join query by passing directly condition string
	*
	* Validation Type: PHP Server Side
	* globaljoinquery($tblname, $selectfields , $condition, $orderbyfield, $groupby, $ad, $limit)
	* Author: Nilesh Gaiwkad 5/18/2006
	*********************************************************************************/

	function gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn)
	{
		if(is_array($sf))
		{
			$fields = implode(",", $sf);
		}
		else
		{
			if($sf)
			$fields = $sf;
			else
			$fields = "*";
		}

		$query.=" SELECT ".$fields." FROM  ".$tbl ;

		$query.=" WHERE $cd ";

		if($gb)
		$query.=" group by ".$gb;

		if($ob)
		$query.=" order by ".$ob." ".$ad;



		if($l)
		$query.=" limit ".$l;
		if($prn!="")
		{
 		echo $query;
		}
		$result = @mysql_query($query) or die(mysql_error());
		$num = @mysql_num_rows($result);
		if($num<1)
		{
			$result = 'n';
		}
		return $result;
	}

	/*****************************************************************************************************************
	*	Table of Contents: Global Database functions 5/4/2006
	*	Author(s) : Chetan Kelkar <k.chetan@.com> | Nilesh Gaikwad<g.nilesh@.com
	*	1. globaldropdown($tblname, $valfield, $showfield, $orderbyfield, $condition, $selvalue)
	*
	*****************************************************************************************************************/
	function cddSmarty($tbl, $valfield, $showfield, $ob, $cdn, $selvalue, $prn)
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

				$opt	.= "<option value='".$row[$valfield]."' ".$selected.">".$row[$showfield]."</option>\n";

			}
			return $opt;
		}
	}

	function quotes_to_entities($str)
	{
		return htmlspecialchars($str);
		//return str_replace(array("\'","\"","'",'"','<', '>'), array("&#39;","&quot;","&#39;","&quot;","&lt;","&gt;"), $str);
	}

	/*
	######################################################################################################
	function name:-is_login
	description:check whether user login or not
	Author:swapna ambekar
	date:25-11-2008
	#######################################################################################################*/


		function not_login()
		{
			if(!$_SESSION['csUserId'])
			{
				header("Location:".SITEROOT."/modules/login");
			}
		}

		/******************Function to get subcategory ids**********************/
		function getsubcatid($catid,$cat_tree,$max_level=0,$catstr)
         {

	       $sql = "SELECT * FROM tbl_questions_category WHERE status='1' and parent_id='".$catid."' ORDER BY category_name ASC";
	       $run_qry = @mysql_query($sql);
	       $nums = @mysql_num_rows($run_qry);

	      if($nums)
	      {
	 	    while($catids = @mysql_fetch_array($run_qry))
		     {
		      $max_level=$max_level+ 1;
		      if($catstr=="")
		       {
		         $catstr=$catids['id'];
		       }else
		       {
		        $catstr=$catstr.",".$catids['id'];
		       }
		       $catstr=$this->getsubcatid($catids['id'], $cat_tree, $max_level,$catstr);
		     }
	  }
	  return $catstr;
 }

	function sanitize($data)
	{
		// remove whitespaces (not a must though)
		$data = @trim($data);

		// apply stripslashes if magic_quotes_gpc is enabled
		if(get_magic_quotes_gpc())
		{
			$data = stripcslashes($data);
		}

		// a mySQL connection is required before using this function
		$data = mysql_real_escape_string($data);
		$data = $this->quotes_to_entities($data);
		return $data;
	}

	function common_ajax_paging($sql, $do_paging, $size, $ajax_params)
	{
		if($do_paging)
		{
			$res 		= $this->customqry($sql, 0);
			$numrows 	= @mysql_num_rows($res);
			$l		= page_limit($size);
			$output['paging']= dispay_paging($size, $numrows, $ajax_params,$l);
			//print_r($res);
		}
		else
			$l=$size;
		if($l)
		 $sql.= " limit ".$l;
		$output['res'] = $this->customqry($sql, 0 );
		return $output;
	}
	
	// get News Alerts
 
	function news($usertype,$module)
	{
		$sql = "SELECT * FROM tbl_news WHERE start_date<='".date("Y-m-d")."' and  end_date>='".date("Y-m-d")."' and user_type=".$usertype."  ORDER BY news_id DESC";
		$run_qry = @mysql_query($sql);
		$nums = @mysql_num_rows($run_qry);
		while($news=@mysql_fetch_array($run_qry))
		{
				$m=explode(",",$news['module']);
				if(@in_array($module,$m))
				$news_array[]=$news;
		}
		return $news_array; 
	}

	//Function to check for valid browser agent

	function is_valid_browser()
	{
			$arr = $this->browser_info();
			if($arr['name'] == 'msie' && $arr['version'] < 7)
			{
				$_SESSION['is_valid_browser'] = 0;
			}
			else
				$_SESSION['is_valid_browser'] = 1;
			return   $_SESSION['is_valid_browser'];
	}
	
	//Function get browser information
	function browser_info($agent=null)
	{
		  $known = array('msie', 'firefox', 'safari', 'webkit', 'opera', 'netscape', 'konqueror', 'gecko');
  
		  $agent = strtolower($agent ? $agent : $_SERVER['HTTP_USER_AGENT']);
  
		  $pattern = '#(?<browser>' . join('|', $known) .
  
		  ')[/ ]+(?<version>[0-9]+(?:\.[0-9]+)?)#';

		  if (!preg_match_all($pattern, $agent, $matches)) return array();

		  // Since some UAs have more than one phrase (e.g Firefox has a Gecko phrase,
		  // Opera 7,8 have a MSIE phrase), use the last one found (the right-most one
		  // in the UA).  That's usually the most correct.
  
		  $i = count($matches['browser'])-1;

		  //return array($matches['browser'][$i] => $matches['version'][$i]);
  
		  $arr['name'] = $matches['browser'][$i];
		  $arr['version'] = $matches['version'][$i];

		  return $arr;
	}

	//Get SEO tag details as per ID
	function meta_SEO($keyid="")
	{
	$sql="select * from mast_seo where id=".$keyid;
	$run_query=@mysql_query($sql);
	return $fetch_meta=@mysql_fetch_assoc($run_query);
	}

	//////////////////////////////////////Get Multiple Deal cities///////////////////////
        //START Get multiple cities as per product id
	function getDealMultiCities($dealId)
	{
		$res_prodcities = $this->cgs("tbl_deal_city","","deal_id",$dealId,"","","");
		$product_cities_num_rows = @mysql_num_rows($res_prodcities);
		$product_cities = "";
		$c_arr=1;
		while($row_prodcities=@mysql_fetch_array($res_prodcities))
		{
		$res_citydet = $this->cgs("mast_city","","city_id",$row_prodcities['city_id'],"","","");
		$row_citydet = @mysql_fetch_assoc($res_citydet);
		$product_cities .= $row_citydet['city_name'];
		if($product_cities_num_rows != $c_arr )
		{
		$product_cities .= "<strong>,</strong><br />";
		}
		$c_arr++;
		}
		return $product_cities;
	}

	function getDealMultiCitiesForExcel($dealId)
	{
		$res_prodcities = $this->cgs("tbl_deal_city","","deal_id",$dealId,"","","");
		$product_cities_num_rows = @mysql_num_rows($res_prodcities);
		$product_cities = "";
		$c_arr=1;
		while($row_prodcities=@mysql_fetch_array($res_prodcities))
		{
		$res_citydet = $this->cgs("mast_city","","city_id",$row_prodcities['city_id'],"","","");
		$row_citydet = @mysql_fetch_assoc($res_citydet);
		$product_cities .= $row_citydet['city_name'];
		if($product_cities_num_rows != $c_arr )
		{
		$product_cities .= "  ";
		}
		$c_arr++;
		}
		return $product_cities;
	}
        //END Get multiple cities as per product id

	 function createUrlText($url_title,$tbl)   {
      
      $order   = array("(",")",":",";","$","#","@","%","^","*","[","]","&","{","}","|","/","_","+","!","~","`","?","<",".",",",">","'");
      $replace = '';
      $url_title = str_replace($order, $replace, $url_title);
      $url_title = trim(strtolower(str_replace(" ","-",$url_title)),"-");
      $res=$this->cgs($tbl,"url_title","url_title",$url_title,"","",""); 
      if(is_resource($res))      
         $url_title=$url_title.time();
      
      return $url_title;
   }

	function getseodetails($id){
		$seo_rs=$this->cgs("mast_seo", "*", "id", $id, "", "", "");
		//$seo_rs=$this -> customqry("select * from mast_seo where id=$id","");
		$row_meta=mysql_fetch_assoc($seo_rs);
		return $row_meta;
	}

	

}
$dbObj = new DBTransact();
$dbObj->Connect();
?>
