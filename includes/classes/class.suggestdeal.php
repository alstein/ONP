<?php
class Suggestdeal extends DBTransact
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
                        if($rs_name['username'] == 'agile')
			   $u_name['username']='GBI';
                        else
			   $u_name['username']=$rs_name['username'];
                    }
		}
	    }
	    return $u_name;
        }

	function getAllSuggestDeal()
	{
	    $dealArray = "";

	    #------------Pagination Part-1-----------#
	    if(!isset($_GET['page']))
		$page =1;
	    else
		$page = $_GET['page'];

	    $adsperpage = 15;
	    $StartRow = $adsperpage * ($page-1);
	    $l =  ($StartRow).','.$adsperpage;
	    #--------------------------------------#
            if($_GET['button']=='Search')
            {
            $cnd ="product_name LIKE '%{$_GET['searchuser']}%'";
            }
            else
            {
            $cnd ="1";
            }

	    $tbl = "tbl_suggest_deal";
	    $sf = "product_name,id,user_id,comment,posted_date,status";
	    $rs1 = $this->gj($tbl,$sf,$cnd, "id","", "DESC", $l, "");

	    if($rs1 != "n")
	    {
		$i=0;
		while($row = @mysql_fetch_assoc($rs1))
		{
		    $dealArray['records'][$i] = $row;
		    $tmp_nm = $this->getUserName($row['user_id']);
                    $dealArray['records'][$i]['user_name'] = $tmp_nm['username'];
                    $deal_like=$this->gj("tbl_suggest_deal","count(id) as product_name","product_name like '%".$row['product_name']."%'","","","","","");
                    $row_like = @mysql_fetch_assoc($deal_like);
                    $dealArray['records'][$i]['title1'] = $row_like['product_name'];
		    $i++;
		}
	    }

	    /*----------Pagination Part-2--------------*/
	    $rs2 = $this->gj($tbl,$sf,$cnd, "id", "", "DESC", "", "");
	    $nums = @mysql_num_rows($rs2);
	    $show = 30;		
	    $total_pages = ceil($nums / $adsperpage);
	    if($total_pages > 1)
		    $dealArray['showpaging']='yes';
	    $showing   = !($_GET['page'])? 1 : $_GET['page'];


	    $firstlink = "suggest-deal.php";
	    $seperator = '?page=';
	    $baselink  = $firstlink; 

	    $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink,$seperator, $nums);
	    $dealArray['pgnation'] =$pgnation;

	//echo "<pre>"; print_r($dealArray);exit;	   
	 /*-----------------------------------*/
	    return $dealArray;
		
	}

	function getSuggestDealById($id)
	{
	    $cnd = "id = '{$id}'";
	    $tbl= "tbl_suggest_deal";
	    $sf="*";
	    $rs_msg = $this->gj($tbl,$sf,$cnd, "", "", "", "", "");
	    if( $rs_msg !='n')
	    {
		while($rs_msg = @mysql_fetch_assoc($rs_msg))
                {
		    $msg_i=$rs_msg;
                    $tmp_nm = $this->getUserName($rs_msg['user_id']);
                    $msg_i['user_name']= $tmp_nm['username'];
                }
		return $msg_i;
	    }
        }
}
?>
