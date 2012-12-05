<?php
include_once('../../../includes/SiteSetting.php');

if($_GET['city_name'] !="")
{
        $res_user = $dbObj->gj("tbl_newsletter","nid,nemail","city='{$_GET['city_name']}'","","nid","","","");

        $i=0;		
		
	echo "<table cellspacing='0' cellpadding='5' border='1'  width='100%' id='{$_GET['divid']}'>";
	echo "<tr><td align='left'  colspan='2'><strong> Subcriber of {$_GET['city_name']}</strong></td></tr>";
	
	while($exe = @mysql_fetch_assoc($res_user))
	{ 
	?>
		<tr>
		    <td width="1%" valign="top">	
		    <input type="checkbox" name="user_list[]" id="user_list" value="<?=$exe['nid']?>"  checked="true">
		</td>
		<td valign="top"><?=$exe['nemail'];?></td>
		</tr>	
	<?
	$i++;
	}	
	echo "</table>";
}
?>