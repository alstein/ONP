<?php
class Mymessage extends DBTransact
{
	function getMessageCount($uid,$s_type)
	{
              $cnd = " user_id ='{$uid}' and  is_RDelete = 'No' and is_RRead = 'No' and is_SDelete = 'No'";

              if($s_type != '')
                    $cnd .= " and user_type = '{$s_type}'";

	      $rs1 = $this->gj("tbl_message m","m.id",$cnd,"m.id","","", "", "");
	      if( $rs1 !='n')
                  return @mysql_num_rows($rs1);
              else
		  return 0;
	}
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
	function getAllMessages($uid,$type,$s_type,$star)
	{
	      #--------Pagination1-------------------------#
		$getpage=$_GET['page'];
		if(!isset($getpage))
		    $page =1;
		    else
		$page = $getpage;
		$adsperpage =10;
		$StartRow = $adsperpage * ($page-1);
		$l =  $StartRow.','.$adsperpage;
		#----------------------------------------#

              if($type == 'all')
	         $cnd = " user_id ='{$uid}' and is_RDelete = 'No'";
              else
	         $cnd = " user_id ='{$uid}' and  is_RDelete = 'No' and is_RRead = '{$type}'";

              if($s_type >=1)
                  $cnd .= " and user_type = '{$s_type}'";

              if($star =='Yes')
                  $cnd.=" and is_R_Stared='Yes'";

	      $tbl = "tbl_message m INNER JOIN tbl_users u ON m.from_id = u.userid";
	      $sf = "m.*,u.first_name,u.last_name,u.username as user_name";

	      $rs1 = $this->gj($tbl,$sf,$cnd,"m.id","","DESC", $l, "");

	      if( $rs1 !='n')
	      {
		  $i = 0;
		  while($row = @mysql_fetch_assoc($rs1))
		  {
		      $msg_info1['records'][$i]=$row;
                      if($row['first_name']== 'Admin')
                      {
		        $msg_info1['records'][$i]['first_name']='GBI';
		        $msg_info1['records'][$i]['last_name']= '';
		        $msg_info1['records'][$i]['user_name']='GBI';
                      }
                      else
		          $msg_info1['records'][$i]=$row;
		      $i++;
		  }
	      }

	      #------------Pagination2-----------------#   
	      $rs22 = $this->gj($tbl,$sf,$cnd,"m.id","","DESC", "", "");
	      $nums = @mysql_num_rows($rs22);
	      $show = 10;
	      $total_pages = ceil($nums / $adsperpage);
	      if($total_pages > 1)
		  $msg_info1['showpaging']="yes";
		  
	      $showing = !($getpage)? 1 : $getpage;

	      $firstlink = "?";	
	      $seperator = 'page=';
	      $baselink  = $firstlink; 

	      $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);

	      $msg_info1['paging'] =$pgnation['navi'];
	      $msg_info1['max'] =$pgnation['max'];

              return $msg_info1;
	}
	function getSentMessages($uid,$type,$star)
	{

	      #--------Pagination1-------------------------#
		$getpage=$_GET['page'];
		if(!isset($getpage))
		    $page =1;
		    else
		$page = $getpage;
		$adsperpage =10;
		$StartRow = $adsperpage * ($page-1);
		$l =  $StartRow.','.$adsperpage;
		#----------------------------------------#

	      $cnd = "from_id ='{$uid}' and is_SDelete = 'No' ";

              if($type != 'all')
	         $cnd .= " and is_SRead = '{$type}'";

              if($star =='Yes')
                  $cnd .= "  and is_S_Stared='Yes'";

	      $tbl = "tbl_message m LEFT JOIN tbl_users u ON m.user_id = u.userid";
	      $sf = "m.*,u.first_name,u.last_name";

	      $rs11 = $this->gj($tbl,$sf,$cnd,"m.id","","DESC", $l, "");
              $msg_info1 = "";
	      if( $rs11 !='n')
	      {
		  $i = 0;
		  while($row = @mysql_fetch_assoc($rs11))
		  {
		      $msg_info1['records'][$i]=$row;
                      if($row['first_name']== 'Admin')
                      {
		        $msg_info1['records'][$i]['first_name']='GBI';
		        $msg_info1['records'][$i]['last_name']= '';
                      }
                      else
		          $msg_info1['records'][$i]=$row;
		      $i++;
		  }
	      }

	      #------------Pagination2-----------------#   
	      $rs22 = $this->gj($tbl,$sf,$cnd,"m.id","","DESC", "", "");
	      $nums = @mysql_num_rows($rs22);
	      $show = 10;
	      $total_pages = ceil($nums / $adsperpage);
	      if($total_pages > 1)
		  $msg_info1['showpaging']="yes";
		  
	      $showing = !($getpage)? 1 : $getpage;

	      $firstlink = "?";	
	      $seperator = 'page=';
	      $baselink  = $firstlink; 

	      $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);

	      $msg_info1['paging'] =$pgnation['navi'];
	      $msg_info1['max'] =$pgnation['max'];
	      return $msg_info1;

	}
	function getMessageById($id,$uid)
	{

            $msg_i = "";

            #1.check for inbox
	    $cnd = "id = '{$id}' and m.from_id = '{$uid}'";
	    $tbl= "tbl_message m INNER JOIN tbl_users u ON m.user_id = u.userid";
	    $sf="m.*,u.first_name,u.last_name";
	    $rs_msg = $this->gj($tbl,$sf,$cnd, "", "", "", "", "");
	    if( $rs_msg !='n')
	    {
		while($rs_msg = @mysql_fetch_assoc($rs_msg))
                {
		    $msg_i=$rs_msg;

		    $tmp_nm = $this->getUserName($rs_msg['user_id']);
                    $msg_i['revever_name'] = $tmp_nm['username'];
                    $tmp_nm1 = $this->getUserName($rs_msg['from_id']);
                    $msg_i['from_name']=  $tmp_nm1['username'];
                }
                $msg_i['msg_in']="Sent";

		return $msg_i;
	    }
	    else #2.sent
            {
		$cnd = "id = '{$id}' and m.user_id = '{$uid}'";
		$tbl= "tbl_message m INNER JOIN tbl_users u ON m.from_id = u.userid";
		$sf="m.*,u.first_name,u.last_name";
		$rs_msg = $this->gj($tbl,$sf,$cnd, "", "", "", "", "");
		if( $rs_msg !='n')
		{
		    while($rs_msg = @mysql_fetch_assoc($rs_msg))
		    {
			$msg_i=$rs_msg;

			$tmp_nm = $this->getUserName($rs_msg['user_id']);
			$msg_i['revever_name'] = $tmp_nm['username'];
			$tmp_nm1 = $this->getUserName($rs_msg['from_id']);
			$msg_i['from_name']=  $tmp_nm1['username'];
		    }

                    $msg_i['msg_in']="Inbox";
		    return $msg_i;
		}
            }
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

	function getAdminSideMessages($uname)
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

            $cnd ="1";

            if($uname !='')
            {
		$cnd1 = "username  = '{$uname}'";
		$tbl= "tbl_users";
		$sf="userid";
		$rs_userid = $this->gj($tbl,$sf,$cnd1, "", "", "", "", "");
		if( $rs_userid !='n')
		    $rs_name = @mysql_fetch_assoc($rs_userid);

		$cnd = "user_id= '{$rs_name['userid']}'";
            }

	    $tbl = "tbl_message m";
	    $sf = "m.id,m.user_id,m.from_id,m.subject,m.message,m.posted_date";
	    $rs1 = $this->gj($tbl,$sf,$cnd, "m.id", "", "DESC", $l, "");

	    if($rs1 != "n")
	    {
		$i=0;
		while($row = @mysql_fetch_assoc($rs1))
		{
		    $dealArray['records'][$i] = $row;
		    $tmp_nm = $this->getUserName($row['user_id']);

                    $dealArray['records'][$i]['user_name'] = $tmp_nm['username'];
                    $tmp_nm = $this->getUserName($row['from_id']);
                    $dealArray['records'][$i]['from_name']=  $tmp_nm['username'];
		    $i++;
		}
	    }

	    /*----------Pagination Part-2--------------*/
	    $rs2 = $this->gj($tbl,$sf,$cnd, "m.id", "", "DESC", "", "");
	    $nums = @mysql_num_rows($rs2);
	    $show = 10;		
	    $total_pages = ceil($nums / $adsperpage);
	    if($total_pages > 1)
		    $dealArray['showpaging']='yes';
	    $showing   = !($_GET['page'])? 1 : $_GET['page'];

            if($uname != '')
            {
	         $firstlink = "user-message.php?uname={$uname}";
	         $seperator = '&page=';
            }  
            else
            {

	         $firstlink = "user-message.php";
	         $seperator = '?page=';
            }

	    $baselink  = $firstlink; 

	    $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink,$seperator, $nums);
	    $dealArray['pgnation'] =$pgnation;

	    /*-----------------------------------*/
	    return $dealArray;
	}

	function getAdminMessageById($id)
	{
	    $cnd = "id = '{$id}'";
	    $tbl= "tbl_message";
	    $sf="*";
	    $rs_msg = $this->gj($tbl,$sf,$cnd, "", "", "", "", "");
	    if( $rs_msg !='n')
	    {
		while($rs_msg = @mysql_fetch_assoc($rs_msg))
                {
		    $msg_i=$rs_msg;
                    $tmp_nm = $this->getUserName($rs_msg['user_id']);
                    $msg_i['user_name']= $tmp_nm['username'];
                    $tmp_nm = $this->getUserName($rs_msg['from_id']);
                    $msg_i['from_name']=$tmp_nm['username'];

                }
		return $msg_i;
	    }
        }
	function deleteMessageById($id,$type)
	{
            $del_msg ="";

            if($type == "Inbox")  //recevier
	       $del_msg = $this->customqry("update tbl_message set is_RDelete = 'Yes' where id in ({$id})", "");

            if($type == "Sent")  //sender
	       $del_msg = $this->customqry("update tbl_message set is_SDelete = 'Yes' where id in ({$id})", "");

            return $del_msg;
        }
	function markReadMessageById($id,$type)
	{
            $cnd = "id ='{$id}'";
            $del_msg ="";

            if($type == "Inbox")  //recevier
            {
		  $rs_Readmsg = $this->gj("tbl_message","is_RRead",$cnd, "", "", "", "", "");
		  if( $rs_Readmsg !='n')
		  {
		      $rw_isRead = mysql_fetch_assoc($rs_Readmsg);

		      if($rw_isRead['is_RRead'] == 'No')
			  $del_msg = $this->customqry("update tbl_message set is_RRead='Yes' where {$cnd}", "");
		  }
            }
            else if($type == "Sent")   //sender
            {
		  $rs_Readmsg = $this->gj("tbl_message","is_SRead",$cnd, "", "", "", "", "");
		  if( $rs_Readmsg !='n')
		  {
		      $rw_isRead = mysql_fetch_assoc($rs_Readmsg);

		      if($rw_isRead['is_SRead'] == 'No')
			  $del_msg = $this->customqry("update tbl_message set is_SRead='Yes' where {$cnd}", "");
		  }
            }
            return $del_msg;
        }
	function markStarById($id,$type,$mark)
	{
            $cnd = "id ='{$id}'";

            $del_msg ="";

            if($type == "Inbox")  //recevier
            {
		if($mark == 0)
		    $del_msg = $this->customqry("update tbl_message set is_R_Stared='No' where {$cnd}", "");
		else
		    $del_msg = $this->customqry("update tbl_message set is_R_Stared='Yes' where {$cnd}", "");
            }
            else if($type == "Sent")   //sender
            {
		if($mark == 0)
		    $del_msg = $this->customqry("update tbl_message set is_S_Stared='No' where {$cnd}", "");
		else
		    $del_msg = $this->customqry("update tbl_message set is_S_Stared='Yes' where {$cnd}", "");
            }
            return $del_msg;
        }
	function getAdminMessages($uid,$type)
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

	    $tbl = "tbl_message as m INNER JOIN tbl_users as u ON u.userid= m.from_id";
	    $sf = "m.id,m.user_id,m.from_id,m.subject,m.message,m.posted_date,m.is_RRead,m.is_SRead";

            $cnd = " u.userid= m.from_id ";
	    $ob = "m.id "; $ot="DESC";
            if($type == 'Inbox')
            {
	       $cnd .= " and  m.user_id ='{$uid}' and m.is_RDelete = 'No'";
            }
            elseif($type == 'Sent')
            {
	       $cnd .= " and m.from_id ='{$uid}' and m.is_SDelete = 'No' ";
            }
            else
            {
                $cnd .= " and (m.user_id = '{$uid}' OR m.from_id= '{$uid}')";
	    }

	    $rs1 = $this->gj($tbl,$sf,$cnd, $ob, "", $ot, $l, "");

	    if($rs1 != "n")
	    {
		$i=0;
		while($row = @mysql_fetch_assoc($rs1))
		{
		    $dealArray['records'][$i] = $row;
		    $tmp_nm = $this->getUserName($row['user_id']);
                    $dealArray['records'][$i]['user_name'] = $tmp_nm['username'];
                    $tmp_nm1 = $this->getUserName($row['from_id']);
                    $dealArray['records'][$i]['from_name']=  $tmp_nm1['username'];
		    $i++;
		}
	    }

	    /*----------Pagination Part-2--------------*/
	    $rs2 = $this->gj($tbl,$sf,$cnd, "", "", "DESC", "", "");
	    $nums = @mysql_num_rows($rs2);
	    $show = 30;		
	    $total_pages = ceil($nums / $adsperpage);
	    if($total_pages > 1)
		    $dealArray['showpaging']='yes';
	    $showing   = !($_GET['page'])? 1 : $_GET['page'];

	    $firstlink = "admin-message.php";

            if($type !="")
            {
                $firstlink .="?mtype={$type}";
		$seperator = '&page=';
	    }
            else
	       $seperator = '?page=';

	    $baselink  = $firstlink; 

	    $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink,$seperator, $nums);
	    $dealArray['paging'] =$pgnation;

	    /*-----------------------------------*/
	    return $dealArray;
	}

}
$mymsg = new Mymessage();
?>
