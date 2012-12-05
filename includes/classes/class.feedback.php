<?php
class Feedback extends DBTransact
{
	function getUserName($id)
	{
	    $u_name="";

            if($id !="")
            {
		$cnd = "userid = '{$id}'";
		$tbl= "tbl_users";
		$sf="first_name,last_name,username";
		$rs_user = $this->gj($tbl,$sf,$cnd, "", "", "", "", "");

		if( $rs_user !='n')
		{
		    while($rs_name = @mysql_fetch_assoc($rs_user))
		    {
			$u_name['fullname']=$rs_name['first_name']." ".$rs_name['last_name'];
			$u_name['username']=$rs_name['username'];
                    }
		}
	    }
	    return $u_name;
        }

	function getDealName($id)
	{
	    $u_name="";

            if($id !="")
            {
		$cnd = "deal_unique_id = '{$id}'";
		$tbl= "tbl_deal";
		$sf="title";
		$rs_user = $this->gj($tbl,$sf,$cnd, "", "", "", "", "");

		if( $rs_user !='n')
		    while($rs_name = @mysql_fetch_assoc($rs_user))
		    $u_name=$rs_name['title'];

	    }
	    return $u_name;
        }

	function getAllUserName()
	{
	    $u_name=array();

// 	    $cnd = "isverified  = 'yes'";
	    $cnd = "1";
	    $tbl= "tbl_users";
	    $sf="first_name,last_name,username";
	    $rs_user = $this->gj($tbl,$sf,$cnd, "username", "", "", "", "");
  
	    if( $rs_user !='n')
	    {
		while($rs_name = @mysql_fetch_assoc($rs_user))
		{
		    $u_name[]['fullname']=$rs_name['first_name']." ".$rs_name['last_name'];
		    $u_name[]['username']=$rs_name['username'];
		}
	    }
	    return $u_name;
        }

	function getAdminSideFeedback($uname)
	{
	    $feedArray = "";

	    #------------Pagination Part-1-----------#
	    if(!isset($_GET['page']))
		$page =1;
	    else
		$page = $_GET['page'];

	    $adsperpage = 10;
	    $StartRow = $adsperpage * ($page-1);
	    $l =  ($StartRow).','.$adsperpage;
	    #--------------------------------------#

            $cnd ="1";

            if($uname !='')
            {
		$cnd1 = "username  = '{$uname}'";
		$tbl= "tbl_users";
		$sf="userid";
		$rs_userid = $this->gj($tbl,$sf,$cnd1, "", "", "", "", "");
		if( $rs_userid !='n')
		    $rs_name = @mysql_fetch_assoc($rs_userid);

		$cnd = "seller_id= '{$rs_name['userid']}'";
            }

	    $tbl = "tbl_feedback_review f";
	    $sf = "f.id,f.deal_id,f.seller_id,f.review,f.total,f.posted_date";
	    $rs1 = $this->gj($tbl,$sf,$cnd, "id", "", "DESC", $l, "");

	    if($rs1 != "n")
	    {
		$i=0;
		while($row = @mysql_fetch_assoc($rs1))
		{
		    $feedArray['records'][$i] = $row;
		    $tmp_nm = $this->getUserName($row['seller_id']);
                    $feedArray['records'][$i]['user_name'] = $tmp_nm['username'];
		    $feedArray['records'][$i]['deal_name'] = $this->getDealName($row['deal_id']);
		    $i++;
		}
	    }

	    /*----------Pagination Part-2--------------*/
	    $rs2 = $this->gj($tbl,$sf,$cnd, "id", "", "DESC", "", "");
	    $nums = @mysql_num_rows($rs2);
	    $show = 30;		
	    $total_pages = ceil($nums / $adsperpage);
	    if($total_pages > 1)
		    $feedArray['showpaging']='yes';
	    $showing   = !($_GET['page'])? 1 : $_GET['page'];

            if($uname != '')
            {
	         $firstlink = "feedback.php?uname={$uname}";
	         $seperator = '&page=';
            }  
            else
            {

	         $firstlink = "feedback.php";
	         $seperator = '?page=';
            }

	    $baselink  = $firstlink; 

	    $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink,$seperator, $nums);
	    $feedArray['pgnation'] =$pgnation;

	    /*-----------------------------------*/
	    return $feedArray;
	}

        function getFeedbackById($id)
        {
            $feedArray = "";

	    $cnd = "id = '{$id}'";
	    $tbl= "tbl_feedback_review";
	    $sf="*";
	    $rs1 = $this->gj($tbl,$sf,$cnd, "", "", "", "", "");
	    if($rs1 != "n")
	    {
		while($row = @mysql_fetch_assoc($rs1))
		{
		    $feedArray = $row;
		    $tmp_nm = $this->getUserName($row['seller_id']);
                    $feedArray['user_name'] = $tmp_nm['username'];
		    $feedArray['deal_name'] = $this->getDealName($row['deal_id']);
		}
	    }
	    return $feedArray;
        }

}
?>