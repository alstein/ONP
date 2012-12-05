<?php
include_once('DBTransact.php');

Class User extends DBTransact
{

	function deletefan($userid)
	{
		$db=new DBTransact();
		$id_delete_fan = $this->customqry("delete from tbl_fan where 	userid in (".$userid.") or fan_id in (".$userid.")","");
	}

	function deletefriend($userid)
	{
		$db=new DBTransact();
		$id_delete_friends = $this->customqry("delete from tbl_friends where userid in (".$userid.") or friendid in (".$userid.")","");
	}
            
	function deletecheer($userid)
	{	
		 $db=new DBTransact();
	     $id_delete_friends = $this->customqry("delete from tbl_cheers where userid  in (".$userid.") ","");
	}
	function deleteactivity($userid)
        {
             $db=new DBTransact();
	     $id_delete_friends = $this->customqry("delete from tbl_activity where uid  in (".$userid.") or fid in(".$userid.")  ","");
        } 
	function deletephoto($userid)
        {
		  $db=new DBTransact();
		$sel_profile_photo=$this->customqry("select * from tbl_users where user_id in (".$userid.")","");
		while($fetch_profile_photo=@mysql_fetch_assoc($sel_profile_photo))
		{
			@unlink('../../uploads/user/'.$fetch_profile_photo['photo']);
			
		}
		$sel= $this->customqry("select * from tbl_albumphotos where user_id in (".$userid.")","");
		while($fetch_sel=@mysql_fetch_assoc($sel))
		{
			@unlink('../../uploads/album/photo/'.$fetch_sel['thumbnail']);
			@unlink('../../uploads/album/photo/180X158/'.$fetch_sel['thumbnail']);
			@unlink('../../uploads/album/photo/400X300/'.$fetch_sel['thumbnail']);
			@unlink('../../uploads/album/photo/600X600/'.$fetch_sel['thumbnail']);
			@unlink('../../uploads/album/photo/132X101/'.$fetch_sel['thumbnail']);
			@unlink('../../uploads/album/photo/bigimage/'.$fetch_sel['thumbnail']);
			@unlink('../../uploads/album/photo/90X90/'.$fetch_sel['thumbnail']);
		}
		
		$del_photos=$this->customqry("delete from tbl_albumphotos where user_id in (".$userid.")",""); 
		$del_album=$this->customqry("delete from tbl_album where user_id in (".$userid.")",""); 
		
	}
	function deletereview($userid)
        {
             $db=new DBTransact();
	     $id_delete_review = $this->customqry("delete from tbl_rating where merchant_id  in (".$userid.") or user_id in(".$userid.") ","");
        } 
	function deletecoupons($userid)
	{
             $db=new DBTransact();
	     $id_delete_deal_payment = $this->customqry("delete from tbl_deal_payment where user_id 	  in (".$userid.") ","");
	     $id_delete_deal_payment_unique = $this->customqry("delete from tbl_deal_payment_unique where user_id in (".$userid.") ","");
        } 
	function deletedeal($userid)
	{
             $db=new DBTransact();
		$sel_deal=$this->customqry("select * from tbl_deals where merchant_id in (".$userid.")","");
		while($fetch_deal=@mysql_fetch_assoc($sel_deal))
		{
		@unlink('../../uploads/deal/'.$fetch_deal['deal_image']);
		}
	     $id_delete_deal = $this->customqry("delete from tbl_deals where merchant_id  in (".$userid.") ","");
	  
        } 

	function del_request_by_mer($userid){
 			//$db=new DBTransact();
			$id_delete_deal = $this->customqry("delete from tbl_merchant_deal_request where merchant_id=".$userid,"");
	}

	function deletemessages($userid){
		$geti=$this->customqry("select distinct MID from inbox where TO_ID in (".$userid.") or FROM_ID in (".$userid.")","");
		while($getirow=@mysql_fetch_assoc($geti)){
				$marri[]=$getirow['MID'];
		}

		//$imarr=implode(",",$marr)

		$geto=$this->customqry("select distinct MID from outbox where TO_ID in (".$userid.") or FROM_ID in (".$userid.")","");
		while($getorow=@mysql_fetch_assoc($geto)){
				$marro[]=$getorow['MID'];
		}

		$io=@array_merge($marri,$marro);

		$uniqueio=@array_unique($io);

		$ioiarr=@implode(",",$uniqueio);


		$this->customqry("delete from inbox where TO_ID in (".$userid.") or FROM_ID in (".$userid.")","");

		$this->customqry("delete from outbox where TO_ID in (".$userid.") or FROM_ID in (".$userid.")","");

		$this->customqry("delete from messages where MID in (".$ioiarr.")","");
	}

	function deleteofferdeal($userid){
			$this->customqry("delete from tbl_offer_deal where user_id 	in (".$userid.") or merchant_id in (".$userid.")","");
	}

}
$userobj= new user();
?>