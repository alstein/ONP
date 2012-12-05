<?php
include_once('../../../includes/SiteSetting.php');

if($_GET['sid'])
{

//     $sellertype=mysql_query("select * from tbl_seller_type where sell_id = '{$_GET['sid']}'");
// 
//     $result=@mysql_fetch_array($sellertype);
// 
//     $seller_id =explode(",",$result['seller_type_option_id']);

    echo "<table id='rep_s'>";

    $l = "1,10";
        //$rs_price=$dbObj->cgs("tbl_sellertype_option","*","","","",$l,""); 
	 $rs_price = $dbObj->gj("tbl_sellertype_option","*","sell_id != 11","","","",$l,"");
        while($row=@mysql_fetch_assoc($rs_price))
        {
            if(($_GET['sid'] == 1) and ($row['seller1'] != "NA"))
            {
                if($row['seller1'] == "Free")
                {
                    echo "<tr><td><input type='checkbox' name='".$row['sell_id']."' id='".$row['sell_id']."' onclick='javascript: addit(".$row['sell_id'].",0);'>".utf8_encode($row['sell_type_name']) ."-". $row['seller1']."</td></tr>";
                }
                else
                {
                    echo "<tr><td><input type='checkbox' name='".$row['sell_id']."' id='".$row['sell_id']."' onclick='javascript: addit(".$row['sell_id'].",".$row['seller1'].");'>".utf8_encode($row['sell_type_name']) ."-". $row['seller1']."</td></tr>";
                }
            }
            elseif(($_GET['sid'] == 2)  and ($row['seller2'] != "NA"))
            {
                if($row['seller2'] == "Free")
                {
                    echo "<tr><td><input type='checkbox' name='".$row['sell_id']."' id='".$row['sell_id']."' onclick='javascript: addit(".$row['sell_id'].",0);'>".utf8_encode($row['sell_type_name']) ."-". $row['seller2']."</td></tr>";
                }
                else
                {
                    echo "<tr><td><input type='checkbox' name='".$row['sell_id']."' id='".$row['sell_id']."' onclick='javascript: addit(".$row['sell_id'].",".$row['seller2'].");'>".utf8_encode($row['sell_type_name'])."-".$row['seller2'] ."</td></tr>";
                }
            }
            elseif(($_GET['sid'] == 3)  and ($row['seller3'] != "NA"))
            {
                if($row['seller3'] == "Free")
                {
                    echo "<tr><td><input type='checkbox' name='".$row['sell_id']."' id='".$row['sell_id']."' onclick='javascript: addit(".$row['sell_id'].",0);'>".utf8_encode($row['sell_type_name']) ."-". $row['seller3']."</td></tr>";
                }
                else
                {
                    echo "<tr><td><input type='checkbox' name='".$row['sell_id']."' id='".$row['sell_id']."' onclick='javascript: addit(".$row['sell_id'].",".$row['seller3'].");'>".utf8_encode($row['sell_type_name']) ."-". $row['seller3']."</td></tr>";
                }
            }
            elseif(($_GET['sid'] == 4)  and ($row['seller4'] != "NA"))
            {
                if($row['seller4'] == "Free")
                {
                    echo "<tr><td><input type='checkbox' name='".$row['sell_id']."' id='".$row['sell_id']."' onclick='javascript: addit(".$row['sell_id'].",0);'>".utf8_encode($row['sell_type_name']) ."-". $row['seller4']."</td></tr>";
                }
                else
                {
                    echo "<tr><td><input type='checkbox' name='".$row['sell_id']."' id='".$row['sell_id']."' onclick='javascript: addit(".$row['sell_id'].",".$row['seller4'].");'>".utf8_encode($row['sell_type_name']) ."-". $row['seller4']."</td></tr>";
                }
            }
            elseif(($_GET['sid'] == 5)  and ($row['seller5'] != "NA"))
            {
                if($row['seller5'] == "Free")
                {
                    echo "<tr><td><input type='checkbox' name='".$row['sell_id']."' id='".$row['sell_id']."' onclick='javascript: addit(".$row['sell_id'].",0);'>".utf8_encode($row['sell_type_name']) ."-". $row['seller5']."</td></tr>";
                }
                else
                {
                    echo "<tr><td><input type='checkbox' name='".$row['sell_id']."' id='".$row['sell_id']."' onclick='javascript: addit(".$row['sell_id'].",".$row['seller5'].");'>".utf8_encode($row['sell_type_name']) ."-". $row['seller5']."</td></tr>";
                }
            }
        }

    echo "</table>";
}
?>
