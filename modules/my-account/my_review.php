<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}

$row_meta=$dbObj->getseodetails(14);
$smarty->assign("row_meta",$row_meta);


if($_GET['adel_id']!=""){
	$dbObj->customqry("delete from tbl_activity where msg_id=".$_GET['adel_id'],"");
	header("location:".SITEROOT."/my-account/my_review/");
}

$config['date'] = '%I:%M %p';
$config['time'] = '%H:%M:%S';
$smarty->assign('config',$config);

$whose_profile="my_review";
$smarty->assign("whose_profile",$whose_profile);
	if($_GET['id1']!="" )
	{
	$user=$_GET['id1'];
	}
	else
	{
	$user=$_SESSION['csUserId'];
	}
	

			$select_activity=$dbObj->customqry("select r.*,u.first_name,u.last_name,u.photo,u.business_name from tbl_rating r left join tbl_users u on r.merchant_id  =u.userid  where r.user_id ='".$user."'  order by rating_id  DESC ","");
		
			$i=0;
				while($res_select_activity=@mysql_fetch_assoc($select_activity))
				{
					$activity[]=$res_select_activity;
	
					$com=$dbObj->customqry("select a.*,u.userid,u.business_name,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid where a.review_id=".$res_select_activity['rating_id'],"");
					$sub_num=@mysql_num_rows($com);
					$activity[$i]['subcumcnt']=$sub_num;	
					$j=0;
					while($row=mysql_fetch_assoc($com)){
						$activity[$i]['sub'][]=$row;
						$activity[$i]['sub'][$j]['timestamp']=getunfiddenhours($row['timestamp']);;
					$j++;
					}
				$i++;
				}

			$count=@mysql_num_rows($select_activity);
			$smarty->assign("count",$count);
			$smarty->assign("user_activity",$activity);

// 			$smarty->assign("user",$user);

//echo "<pre>";print_r($activity);echo "</pre>";
if($_GET['review_id']){
	$dbObj->customqry("delete from tbl_rating where rating_id=".$_GET['review_id'],"");
	header("location:".SITEROOT."/my-account/my_review/");
}
$smarty->display(TEMPLATEDIR . '/modules/my-account/my_review.tpl');
$dbObj->Close();


function getunfiddenhours($feedtime)

    {

           
               

             $datetime   = explode(" ",$feedtime);


             $date       = explode("-",$datetime[0]);

             $time       = explode(":",$datetime[1]);

            

             $dd     = $date[2];

             $mm     = $date[1];

             $yy     = $date[0];

             $h      = $time[0];

             $m      = $time[1];

             $s      = $time[2]; 

         $diff  = round((time()-@mktime($h,$m,$s,$mm,$dd,$yy))/60);

              

             if($diff<=0)

             {

                $result = "about 1 min ago";

             }

             elseif($diff > 60)

             {

                  $diff       = round($diff/60);


			if($diff > 24)
			{
				$diff   = round($diff/24);

					 


						if($diff==1)
						{
						
						$result = "about 1 day ago"; 

						}
						elseif($diff>=2 && $diff<=360)
						{
						 	$res = strtotime($feedtime);

							$result=date("M d , Y H:i",$res);
						}
						else
						{
						
											  $res = strtotime($feedtime);

											  $result=date("M d , Y",$res); 

						}
			}
			else
			{
				$result     = "about ".$diff." hrs ago";

			}
                 // $result     = $diff." hrs";

                  
          }
	else
	{
	 $result  ="about ".$diff." min ago";

	}
         


              return($result);

    }

?>