<?
class General extends DBTransact
{
	function getInfo($table_name='',$wantedfield='',$wherefield='',$fieldValue='')
	{	
		$user = $this->cgs($table_name,$wantedfield,$wherefield, $fieldValue, "", "", "");
		if($user != 'n')
		{
			
			$rowsuse = mysql_fetch_assoc($user);
		  	$value = $rowsuse[$wantedfield];
			if($rowsuse[$wantedfield] == "")
			{  $value = "NA"; }
		}
		else
		{ $value = "----" ;}
		return $value; 
	}
	function getAlbumId($album_url)
	{
/*		$tbl = "tbl_album a LEFT JOIN tbl_accomplishment c ON a.acc_id = c.acc_id";
		$sf = "a.*, c.subcatid";*/
		$tbl = "tbl_album a";
		$sf = "a.*";
		$cnd = "a.status='Active' AND a.url_title = '".$album_url."'";// AND c.status = 'Active'
		$rs = $this->gj($tbl, $sf , $cnd, "", "", "", "", "");
		$album = @mysql_fetch_assoc($rs);
		return $album;
	}
/*	function get_cities()
	{	
		$sql_city = $this->cgs("mast_city","","", "", "", "", "");
		if($sql_city != 'n')
		{ 
			while($fetch_city = mysql_fetch_assoc($sql_city))
			{
				$cities[] = $fetch_city;			
			}
		}	
		return $cities; 
	}    */
	function get_records($table, $orderByField="", $orderType="")
	{	
		$sql_records = $this->cgs($table,"","", "", $orderByField, $orderType, "");
		if($sql_records != 'n')
		{ 
			while($fetch_records = mysql_fetch_assoc($sql_records))
			{
				$records[] = $fetch_records;			
			}
		}	
		return $records; 
	}    
	function get_conditional_records($table,$wherefield='',$fieldValue='')
	{	
		$sql_records = $this->cgs($table,"",$wherefield, $fieldValue, "", "", "");
		if($sql_records != 'n')
		{ 
			while($fetch_records = mysql_fetch_assoc($sql_records))
			{
				$records[] = $fetch_records;			
			}
		}	
		return $records; 
	}

	function getCategories($admin=false)
	{
		if($admin==true)
			$cnd .= "c.status='Active' and parentid =0";
// 		if($admin==true)
// 			$cnd .= "parentid =0";

		$rs = $this->gj("help_cat as c", "", $cnd, "", "", "", "", "");
		while($row = @mysql_fetch_assoc($rs))
			$categories[] = $row;
		return $categories;
	}
	function getSubCategory($categoryid='', $admin= false)
	{
			$cnd ="c.parentid !=0";
		if($categoryid !='')
			$cnd .= " AND c.parentid=".$categoryid;
			
		if($admin==false)
			$cnd .= " AND c.status='Active'";

		$rs = $this->gj("help_cat as c", "", $cnd, "", "", "", "", "");
		while($row = @mysql_fetch_assoc($rs))
			$subcategories[] = $row;
		return $subcategories;
	}
	
	function getAllcategories($file, $getpage='', $search='', $categoryid='',$admin)
	{
	     #------------Pagination Part-1------------
		if(!isset($getpage))
 			$page =1;
 		else
 			$page = $getpage;
 		$adsperpage = 12;
 		$StartRow = $adsperpage * ($page-1);
 		$l =  $StartRow.','.$adsperpage;
 		$startingnumber = ($StartRow+1);	
 		$endingnumber = ($StartRow+$adsperpage);
		#-----------------------------------

		if($admin==false)
			$cnd = " AND f.status='Active'";

			//$cd = "c.category LIKE '%".$search."%'";


		if($search!='')
		{
			
			$cd="(help_cat LIKE '".addslashes(trim($_GET['search'])) ."%')";
			if($categoryid!='')
			{
				$cd.=" AND help_cat_id=".$categoryid;
			}
		}
		else
			$cd="1";

		$tbl = "help_cat as c";
		$sf  = "c.*";

		$rs=$this->gj($tbl, $sf, $cd, "", "", "", $l,"");

		if($rs!="n")
		{
			while($row = mysql_fetch_assoc($rs))
			{
				$categories[]=$row;
			}
		}
		$categoriesArray = $categories;
		/*----------Pagination Part-2--------------*/
 		$rsj = $this->gj($tbl, $sf, $cd, "", "", "", "",false);
 		$nums = @mysql_num_rows($rsj);
 		$show = 5;
 		$total_pages = ceil($nums / $adsperpage);
 		if($total_pages > 1)
 			$categoriesArray['showpaging']='yes';
 		$showing   = !($getpage)? 1 : $getpage;
 		if($search)
 			$firstlink = $file . "?search=" . $search;
 		else
 			$firstlink = $file."?";
 		$seperator = '&page=';
 		$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums,'',$startingnumber,$endingnumber);
 		$categoriesArray['paging']=$pgnation;
// 		/*-----------------------------------*/
 
		return $categoriesArray;
	}

	function getState($countryid)
	{
		extract($_POST);	
		$wantedfield="stateid,countryid,states";
		$wherefield="countryid";
		$fieldValue= $countryid;
		$result = $this->cgs("mast_state",$wantedfield,$wherefield, $fieldValue, "", "", "");
	//	$state = @mysql_fetch_assoc($result);

		while($rows = @mysql_fetch_assoc($result))
		{
			$state[] = $rows;
		}
		return	$state;	
	}


	function getCity($stateid)
	{
		extract($_POST);	
		$wantedfield="mast_id,parent_id,mastname";
		$wherefield="parent_id";
		$fieldValue= $stateid;
		$result = $this->cgs("mast_city",$wantedfield,$wherefield, $fieldValue, "", "", "");
		//$city = @mysql_fetch_assoc($result);

		while($rows = @mysql_fetch_assoc($result))
		{
			$city[] = $rows;
		}

		return	$city;	
	}


	function get_prayer_meditation_type($table)
	{	
		$sql_records = $this->cgs($table,"","", "", "", "", "");
		if($sql_records != 'n')
		{ 
			while($fetch_records = mysql_fetch_assoc($sql_records))
			{
				$records[] = $fetch_records;			
			}
		}	
		return $records; 
	}  
	
	function get_comunity($table,$userid)
	{	
		$cnd="group_owner_id=".$userid;
		
		$sql_records = $this->gj($table, "", $cnd, "", "", "", "", "");
		if($sql_records != 'n')
		{ 
			while($fetch_records = mysql_fetch_assoc($sql_records))
			{
				$records[] = $fetch_records;			
			}
		}	
		return $records; 
	} 


	function country()
	{
        //$fetch_country=$this->get_records("mast_country");
        $siteroot = SITEROOT;
		$str ='<select style="width: 60%;" class="txt" name="country" id="country" onchange="javascript: get_states(this.value,\''.$siteroot.'\');">'."<option value='' >Select</option>";
		
		/***************Fetch state list***********************/
			
			$rs = $this->cgs("mast_country","*","","","country","ASC","");
			$num_rows=@mysql_num_rows($rs);
			if($num_rows>0)
			{
				while($row = @mysql_fetch_assoc($rs))
				{
					$st[] = $row;
				}
			}
		
		
			if($st != "")
			{
				for($i=0;$i<count($st);$i++)
				{   
				    if($_GET["id2"]==$st[$i]['countryid']){ $selected ="selected";}
				    else { $selected = "";}	
					$str = $str."<option value='".$st[$i]['countryid']."' $selected >".$st[$i]['country']."</option>";				
				}
				$str = $str.'</select>';			
				$St =  $str;
				echo $St;
			
		} 	   
		else
		{
				//$str = $str."<option value=''>Select</option>";			
				$str = $str.'</select>';
				echo $str;
		} 
	}


function country1()
	{
	
	//$fetch_country=$this->get_records("mast_country");
	$siteroot = SITEROOT;
		$str ='<select style="width: 60%;" class="txt" name="country" id="country2" onchange="javascript: get_state1(this.value,\''.$siteroot.'\');">'."<option value='' >Select</option>";
		
		/***************Fetch state list***********************/
			
			$rs = $this->cgs("mast_country","*","","","country","ASC","");
			$num_rows=@mysql_num_rows($rs);
			if($num_rows>0)
			{
				while($row = @mysql_fetch_assoc($rs))
				{
					$st[] = $row;
				}
			}
		
		
			if($st != "")
			{
				for($i=0;$i<count($st);$i++)
				{   if($_POST["country"]==$st[$i]['countryid']){ $selected ="selected";}
				    else { $selected = "";}	
					$str = $str."<option value='".$st[$i]['countryid']."' $selected >".$st[$i]['country']."</option>";				
				}
				$str = $str.'</select>';			
				$St =  $str;
				echo $St;
			
		} 	   
		else
		{
				//$str = $str."<option value=''>Select</option>";			
				$str = $str.'</select>';
				echo $str;
		} 
	}

# ------------ code to show church name ---------------------------------#

function church_name()
	{
			
	$siteroot = SITEROOT;
		$str ='<select style="width: 60%;" class="txt" name="church_name" id="church_name">'."<option value='' >Select</option>";
		
		/***************Fetch state list***********************/
			
			$rs = $this->cgs("tbl_church","*","","","","","");
			$num_rows=@mysql_num_rows($rs);
			if($num_rows>0)
			{
				while($row = @mysql_fetch_assoc($rs))
				{
					$ch[] = $row;
				}
			}
		
		
			if($ch != "")
			{
				for($i=0;$i<count($ch);$i++)
				{    if($_POST["church_name"]==$ch[$i]['church_id']){ $selected ="selected";}
				    else { $selected = "";}
					$str = $str."<option value='".$ch[$i]['church_id']."' $selected >".$ch[$i]['church_name']."</option>";				
				}
				$str = $str.'</select>';			
				$St =  $str;
				echo $St;
			
		} 	   
		else
		{
				//$str = $str."<option value=''>Select</option>";			
				$str = $str.'</select>';
				echo $str;
		} 
	}


	

	
		function search()
		{
		$tbl = "tbl_search";
		$search_status = $this -> gj($tbl, '*' , "1", "", "","", "", "");
		$search =@mysql_fetch_assoc($search_status);
		 $search1=$search['status'];
		
		return($search1);
		}

}

?>
