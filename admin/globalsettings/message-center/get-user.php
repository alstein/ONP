<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

if($_GET['city_name'] !="")
{
if($_GET['city_name']=='all')
{
$res_user = $dbObj->gj("tbl_users","first_name,last_name,email","usertypeid ='3' OR usertypeid ='2' and isverified='yes'","","userid","","","");
}
else
{
$res_user = $dbObj->gj("tbl_users","first_name,last_name,email","city='{$_GET['city_name']}' and isverified='yes' and usertypeid !='1'","","userid","","","");
}
$i=0;		
		
		echo "<table cellspacing='1' cellpadding='1'  width='100%' border='0'>";
		echo "<tr><td width='20%' height='25' align='left' class='fade_back' colspan='2'><span style='color:red'>*</span> Subcriber List</td></tr>";
		
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
		
		echo "</table>";
		

}
?>