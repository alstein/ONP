<?
/**
* Project:     Tonto
* File:        class.statecountry.php
*
* @author Vasudha Gele <g dot vasudha at agiletechnosys dot com>
* @package Smarty
* @version 2.6.19
*/


Class StateCountry extends DBTransact
{
	function getCountryList()
	{
		$rs = $this->customqry("SELECT * FROM mast_country", "");
		while($row = @mysql_fetch_assoc($rs))
			$countries[] = $row;
		return $countries;
	}
	function getCountry($con_id) 
	{
		$con = $this->gj("mast_country", "", "countryid=".$con_id, "", "", "", "", "");		
		$con_row = @mysql_fetch_assoc($con);
		return $con_row;		
	}
	function getState($state_id)
	{
		$state = $this->gj("mast_state", "", "state_id=".$state_id, "", "", "", "", "");		
		$state_row = @mysql_fetch_assoc($state);
		return $state_row;		
	}
	function getCity($cityid)
	{
		$city = $this->gj("mast_city", "", "city_id=".$cityid, "", "", "", "", "");
		$city_row = @mysql_fetch_assoc($city);
		return $city_row;		
	}
	function getCat($catid)
	{
		$cat = $this->gj("category", "", "cat_id=".$catid, "", "", "", "", "");
		$cat_row = @mysql_fetch_assoc($cat);
		return $cat_row;		
	}
	
}
?>