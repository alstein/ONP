<?php

class rating extends DBTransact
{

  function addRating($rating, $whomid, $type_id)
  {
    // Initialize rating value by 0.
    $total_rating = 0;
    $user_id = $_SESSION[csUserId];

    // Check if the user has already added rating or not.
    $number_of_added_ratings = $this->isRatingAdded($user_id, $whomid, $type_id);

    if($number_of_added_ratings < 1)
    {
      // Add rating.
      $date = date("Y-m-d H:i:s");
      $field_value = array("typeid" , "whomid" , "rating" , "userid" , "rating_date");
      $field_name = array($type_id , $whomid , $rating , $user_id, $date);
      $add_status = $this->cgi("tbl_rating", $field_value, $field_name, "","","");

      // Get tht avarage rating.
      $total_rating = $this->getRating($whomid, $type_id);
    }
    return $total_rating;
  }

	function getRating($moduleid, $itemid)
	{
		extract($_GET);
		$rs = $this->cgs("tbl_rating", "avg(rating)", array("moduleid", "itemid"), array($moduleid, $itemid), "", "", "");
		$row=@mysql_fetch_array($rs);
		$rating=$row[0];
		
		return $rating;
	}
	
	function getMyRating($moduleid, $itemid)
	{
	extract($_GET);
	$rs = $this->cgs("tbl_rating", "rating", array("moduleid", "itemid",'userid'), array($moduleid, $itemid,$_SESSION['csUserId']), "", "", "");
	    $row=@mysql_fetch_array($rs);
	    $rating=$row[0];
	    
	    return $rating;
	}

  function isRatingAdded($rating_added_by_user_id, $rating_for_id, $rating_type)
  {
    $where_field = array ("userid" , "whomid", "typeid");
    $where_value = array ($rating_added_by_user_id, $rating_for_id, $rating_type);
    $result = $this->cgs("tbl_rating", "", $where_field, $where_value, "", "", "");

    if($result)
    {
      	$rating_count = @mysql_num_rows($result);
    }

    return $rating_count;
  }
  
  #---------Delete Comments By Item-----------------#
	function delRatingsByItem($itemid, $moduleid)
	{
		$rs=$this->gdel('tbl_rating', array('itemid', 'moduleid'), array($itemid, $moduleid), '');
		return true;
	}
}
?>