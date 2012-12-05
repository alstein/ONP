<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');
include_once('../../../include.php');

if($_GET['city_name'] !="")
{

$rs=$dbObj->cgs("zipData", "*", "city", $_GET['city_name'], "zipcode ASC", "", "");
$row=@mysql_fetch_assoc($rs);
//$row['zipcode'];

if($_GET['radius'] !="")
  {
        $radius = $_GET['radius'];
} else
  {
        $radius = 15;
        
}           


$db = new db_sql;
$zipLoc = new zipLocator;
if($row['zipcode'] != "")
{
$zipArray = $zipLoc->inradius_zip($row['zipcode'],$radius);
$cityArray = $zipLoc->inradius($row['zipcode'],$radius);
}
else
{
$p=explode(" ",$_GET['city_name']);
$zipArray = $zipLoc->inradius_zip($p[0],$radius);
$cityArray = $zipLoc->inradius($p[0],$radius);
}

// $cityArray = $zipLoc->inradius($row['zipcode'],$radius);
// echo "<pre>"; print_r($zipArray);



if($zipArray != "n")
{
$zips = @implode("','",@array_unique($zipArray));
$zips="'".$zips."'";
//$cnd_array="postalcode in (".$zips.") and isverified='yes' and usertypeid !='1'";
}

if($cityArray != "n")
{
$cities = @implode("','",@array_unique($cityArray));
$cities="'".$cities."'";
//$cnd_array="city in (".$cities.") and isverified='yes' and usertypeid !='1'";
}

        if($zipArray=="n" && $cityArray=="n" )
        {
        $cnd_array=1;
        }
	else
	{
	$cnd_array="(city in (".$cities.") or postalcode in (".$zips.") ) and isverified='yes' and usertypeid !='1'";
	}


// $res_user = $dbObj->gj("tbl_users","first_name,last_name,email","city='{$_GET['city_name']}' and isverified='yes' and usertypeid !='1'","","userid","","","");
if($cnd_array==1 )
{
$res_user="n";
}
else
{
$res_user = $dbObj->gj("tbl_users","first_name,last_name,email",$cnd_array,"","","","","");
}
$i=0;		
		
		echo "<table cellspacing='1' cellpadding='1'  width='100%' border='0'>";
		echo "<tr><td width='20%' height='25' align='left' class='fade_back' colspan='2'><span style='color:red'>*</span> Subcriber List</td></tr>";
		
                if($res_user != "n")
                {
		while($exe = @mysql_fetch_assoc($res_user))
		      { 
		?>
			 
			<tr>
			<td width="1%">	
			<input type="checkbox" name="user_list[]" id="user_list" value="<?=$exe['email']?>"  checked="checked">
			</td>
                        <td><?=$exe['first_name'];?>&nbsp;<?=$exe['last_name'];?></td>
			</tr>
				
		<?
		$i++;
		      }
                }
                else
                {

                ?>
			 
			<tr>
			
                        <td colspan="2" style="color:red">Subscribers not found.</td>
			</tr>
				
		<?

                }
                echo "<tr><td colspan='2'>&nbsp;</td></tr>";
		echo "</table>";
		

}
?>
