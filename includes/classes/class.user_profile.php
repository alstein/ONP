<?php
/*-----------------------------------------------------*/
/* This function is for User detail on site*/
/*-----------------------------------------------------*/
class UserProfile extends DBTransact
{
	function GetProfileDetailById($userid)
	{
		

		$tbl = "tbl_users u LEFT JOIN mast_country c ON u.countryid = c.countryid";
		$sf = "u.*,c.country";
		$cd = "u.userid =".$userid;

		$rs = $this->gj($tbl,$sf,$cd,"","","","","");
		if($rs!="n")
		{
			$frch = mysql_fetch_assoc($rs);
		}
	return $frch; 
	}

	function getUserContacts($uid)
	{
			$rs = $this->cgs("tbl_user_IM_contact", "", "user_id", $uid, "", "", "");

			if($rs!= 'n')
			{
				while($row = mysql_fetch_assoc($rs))
				{
					$contact[] = $row;
				}
					return $contact;
			}
			else
			{return false;}
	}
	
}


?>