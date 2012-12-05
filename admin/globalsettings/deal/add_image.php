<?php
include_once("../../../includes/common.lib.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

$msobj= new message();
if(!$_SESSION['duAdmId'])
{
        header("location:".SITEROOT . "/admin/login/_welcome.php");
}

extract($_POST);
extract($_GET);

$product_id=$_GET[id];
$image_id=$_GET[image_id];

if($image_id!="")
{
$cd = "image_id = '".$image_id."'";
$dbres = $dbObj->gj('tbl_product_image', "*" , $cd, "", "","", "", "");	
	while($row_results = @mysql_fetch_assoc($dbres))
	$row_result1[]=$row_results;
	$smarty->assign("image", $row_result1);
}

/*fetch blog content*/
if(isset($_POST['submit']))
{	
                      if($_FILES['photo']['name']!="")
                      {
		        $photos = generalfileupload($_FILES['photo'],"../../../uploads","1");
                        if($image_id!="")
                        {
				////// unlink the previous images asociated with  the deal //////////////////
				if($product_id!="" and $image_id!="")
				{
				
         			$sel= $dbObj->customqry("SELECT * FROM `tbl_product_image` WHERE `image_id` IN (".$image_id.")","");
				$munrs=mysql_num_rows($sel);
				if($munrs>0)
				{
					while($rest=mysql_fetch_assoc($sel))
					{
						$img="../../../uploads/".$rest['product_image'];
						$imgcrop="../../../uploads/product/thumbnail/".$rest['thumbnail'];
						if($rest['product_image']!="")
						unlink($img);
				
						if($rest['thumbnail']!="")
						unlink($imgcrop);
					}
				}
				
				}
                                 ///////////////////////entry remove from database //////////////////////////

                          $fields=array("product_image");
                          $vals    =array($photos);
                          $wf=array("image_id");
                          $wval=array($image_id);
                          $dbObj->cupdt('tbl_product_image',$fields,$vals,$wf,$wval,"");
			  $_SESSION['image_id']=$image_id;
			  $_SESSION['img_path']=$photos;
			  $_SESSION['product_id']=$product_id;

                        $_SESSION['msg']="<span class='success'>Image saved successfully.</span>";
			header("location:".SITEROOT."/admin/sitemodules/deal/cropImage.php");
         		exit;
			}else
                        {
				$fields = array('product_id','product_image');
				$values = array($product_id,$photos);
				$dbres = $dbObj->cgi('tbl_product_image', $fields , $values , "");
				$insid=mysql_insert_id();
				$_SESSION['image_id']=$insid;
				$_SESSION['product_id']=$product_id;
				$_SESSION['img_path']=$photos;
                        $_SESSION['msg']="<span class='success'>Image saved successfully.</span>";
			header("location:".SITEROOT."/admin/sitemodules/deal/cropImage.php");
         		exit;
                        }
	      		
                     }
                     else
			{


                               if($image_id!="")
				{

                               ////// the images asociated with the bannner //////////////////
                               $sel= $dbObj->customqry("SELECT * FROM tbl_product_image WHERE  image_id IN (".$image_id.")","");
                               $munrs=mysql_num_rows($sel);
				if($munrs>0)
				{
					while($rest=mysql_fetch_assoc($sel))
					{
					    $photos=$rest['product_image'];
					}
				}
				$_SESSION['image_id']=$image_id;
				$_SESSION['img_path']=$photos;
                                $_SESSION['product_id']=$product_id;

				$_SESSION['msg']="<span class='success'>Image saved successfully.</span>";
			        header("location:".SITEROOT."/admin/sitemodules/deal/cropImage.php");
         		        exit;
				}else
				{
				$_SESSION['msg']="<span class='success'>Image updated successfully.</span>";
				header("location:".SITEROOT."/admin/sitemodules/deal/view_product_images.php?id=$product_id&act=view");
				exit;
				}
				
			}
                   
}




$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/deal/add_image.tpl');

$dbObj->Close();
?>