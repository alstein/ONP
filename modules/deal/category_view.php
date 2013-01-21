<?php

include_once('../../include.php');

$date = date("Y-m-d H:i:s");	

if(isset($_POST['cat']) && !empty($_POST['cat'])){
    $cat = $_POST['cat'];
}
else {
    header("location:".SITEROOT);
}

$res = $dbObj->customqry("SELECT d.deal_unique_id,d.deal_title,d.offer_price,d.deal_image,d.deal_end_date,d.max_deal_no,d.discount_in_per,u.business_name,u.first_name,u.last_name FROM tbl_deals d,tbl_users u WHERE d.merchant_id=u.userid AND u.deal_cat = ".$cat." ORDER BY d.deal_end_date ASC");
while ($row = mysql_fetch_array($res))
{
    $all_deals[]=$row;
}

$smarty->assign("all_deals",$all_deals);

$categories = array();
$res = $dbObj->customqry("SELECT id, category FROM mast_deal_category WHERE parent_id = 0 AND active = 1");
while($rows = mysql_fetch_assoc($res))
{
//    $all_categories[$rows['id']][] = $rows['category'];
    $subcats = array();
    $res1 = $dbObj->customqry("SELECT id, category FROM mast_deal_category WHERE parent_id = '".$rows['id']."' AND active = 1");
    while($rows1 = mysql_fetch_assoc($res1))
    {
        $subcats[] = $rows1; 
//        $all_categories[$rows['id']][] = $rows1['category'];
    }
    $rows['subcats'] = $subcats;
    $categories[] = $rows;
}

$smarty->assign("categories",$categories);

$res = $dbObj->customqry("SELECT category FROM mast_deal_category WHERE id = " . $cat);
while($rows = mysql_fetch_assoc($res))
{
    $category = $rows['category'];
}

$smarty->assign("category",$category);

//Category 
//$sql="select * from mast_deal_category where parent_id=0 and active=1 order by category";
//$result = mysql_query($sql) or die('Error, query failed');
//$i = 0;
//while($row = mysql_fetch_array($result))
//{
//    $tmp = array('id'=>$row['id'],
//     'category'=>$row['category']);
//    $results[$i++] = $tmp;
//}
//$count=mysql_num_rows($result);
//$smarty->assign("category",$results);

$smarty->display(TEMPLATEDIR.'/modules/deal/category_view.tpl');

$dbObj->Close();
?>
