<?php
class users extends DBTransact
{

    var $usrs_Info = array();
    var $creditcardInfo = array();
    var $city_Info = array();
    var $con_Info = array();
    var $card_Info = array();
    var $sett_Info = array();
    var $fulfill_Info = array();

    function getUsersInfoById($id)
    {
        $cnd = "userid = {$id}";

        $tbl = "tbl_users u LEFT JOIN mast_country c ON u.countryid = c.countryid LEFT JOIN mast_usertype ut ON u.usertypeid = ut.typeid ";
        $sf="u.*, c.country,ut.usertype";

        $rs_usr = $this->gj($tbl,$sf,$cnd,"","","","","");
        if($rs_usr != 'n')
        {
            while($row_usr = @mysql_fetch_assoc($rs_usr))
            {
                $usr_Info = $row_usr;
            }
            return $usr_Info;
        }
    }
    function getCreditCardInfo($id)
    {
        $cnd_card = " (cc.userid = {$id} )";

        $tbl_card = "tbl_credit_card cc LEFT JOIN tbl_users u ON cc.userid = u.userid";
        $sf_card = "cc.*";

        $rs_card = $this->gj($tbl_card,$sf_card,$cnd_card,"id","card_number","DESC","","");
        if($rs_card != 'n')
        {
            while($row_card = @mysql_fetch_assoc($rs_card))
                $creditcardInfo[] = $row_card;
            return $creditcardInfo;
        }
    }
    function getCreditCardById($id)
    {
        $cnd = "id='$id'";
        $rs = $this->gj("tbl_credit_card","*",$cnd,"","","","","");
        if($rs!="n")
        {
            $card = mysql_fetch_assoc($rs);
        }
        return $card;
    }
    function getAllcity()
    {
	$res2 = $this->cgs("mast_city","city_id,city_name",array("con_id","active"),array(223,1),"city_name","","");
	if($res2 != 'n')
	{
	    while($row2 = @mysql_fetch_assoc($res2))
		  $city_Info[] = $row2;
	}
	return $city_Info;
    }


    function getAllcountry()
    {
	$res_con = $this->gj("mast_country","","countryid = 223 and status = 'Active'","country","country","","","");
	if($res_con != 'n')
	{
	    while($row_con = @mysql_fetch_assoc($res_con))
	    {
	      $con_Info = $row_con;
	    }
        }
	return $con_Info;
    }
    function checkCard($usr_id,$cardno)
    {
	$res_card = $this->cgs("tbl_credit_card","id,card_expire_month,card_expire_year",array("userid","card_number"),array($usr_id,$cardno),"","","");
	if($res_card != 'n')
	{
	    while($row_card = @mysql_fetch_assoc($res_card))
		  $card_Info = $row_card;
	    return $card_Info;
	}
    }
    function removeCard($id)
    {
	$rs_id = $this->gdel("tbl_credit_card","id",$id,"1");
        return $rs_id;

    }
}
$userObj = new users();
?>