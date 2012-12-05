<?php
include_once("mail_func.php");
Class Photos extends DBTransact 
{
	function addPhotos($albumid,$userid,$filearr)
 	{
		$total_size="";
		for($s=0;$s<=5;$s++)
		{
			$total_size = $total_size + $filearr["image$s"]['size'];
		}

	 	if($total_size > 7000000)
     		{
         		 $_SESSION['msg']="<span class='error'>File size exceeding 6 MB.</span>";
       		 	@header("Location:".SITEROOT."/photos/".$_SESSION["csUserId"]."/view/".$albumid."/add_photos/");
		 	   exit;
	 	}

		for($z=1;$z<=5;$z++)
		{	
		if($filearr["image$z"]["name"]!="")
		{
			$image = newgeneralfileupload($filearr["image$z"], "../../uploads/album/photo/", true);
			$original['name'] = $image;
			$original['tmp_name'] = "../../uploads/album/photo/".$image;

			



			$size = getimagesize($_FILES["image$z"]['tmp_name']);
			$tmp_name = $_FILES["image$z"]['tmp_name'];
			$imagesize=$size[0]*$size[1];
		
			$image_ratio_display=img_aspect_ratio(600,400,$size);
			$img_display = uploadandresize($_FILES["image$z"],'../../uploads/album/photo','../../uploads/album/photo/600X600/',$image_ratio_display['finalwidth'],$image_ratio_display['finalheight']);

			// for resize details
			$path = "../../uploads/album/photo/thumbnail/";
			$width_array  = array(145);
			$height = 145;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

			$path = "../../uploads/album/photo/bigimage/";
			$width_array  = array(400);
			$height = 250;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

			$path = "../../uploads/album/photo/132X101/";
			$width_array  = array(132);
			$height = 101;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop
		
			$path = "../../uploads/album/photo/400X300/";
			$width_array  = array(300);
			$height = 400;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

			$path = "../../uploads/album/photo/180X158/";
			$width_array  = array(180);
			$height = 158;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

			$path = "../../uploads/album/photo/600X600/";
			$width_array  = array(720); 	//600
			$height = 470;		//387
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

			$sf_arr=array("user_id","album_id","thumbnail","added_date");
			$sv_arr=array($_SESSION["csUserId"],$albumid,$image,date("Y-m-d H:i:s"));
			$insert_details=$this->cgi("tbl_albumphotos",$sf_arr,$sv_arr,"");
		

		}
	    }

		
		//comment
		$comment =  "uploaded new photos to album ";
// 		$f=array("moduleid","itemid","userid","comment","date_added");
// 		$v=array('7',$insert_details,$_SESSION['csUserId'],$comment,date("Y-m-d h:i:s"));
// 		$id=$this->cgi("tbl_comments",$f,$v,"");
	}
	function fetchAlbumDetails($albumid)
	{
		$get_albumdetails=$this->cgs("tbl_album","*",array("album_id"),array($albumid),"","","");
		$fetch_details=@mysql_fetch_assoc($get_albumdetails);
		return $fetch_details;
	}

	function deleteAlbum($albumid)
	{
//       $del_comm=$this->customqry("delete from tbl_comments where itemid='".$albumid."' and moduleid = 6 and userid ='".$_SESSION['csUserId']."'",""); 

		$getphotodetails=$this->cgs("tbl_albumphotos","photo_id,thumbnail","album_id",$albumid,"","","");	
		while($fetch_photodetails=@mysql_fetch_assoc($getphotodetails))
		{
			$photo_todel[]=$fetch_photodetails["photo_id"];
			$photo_unlink[]= $fetch_photodetails["thumbnail"];
		}
		
		for($i=0;$i<count($photo_unlink);$i++)
		{
			@unlink('../../uploads/album/'.$photo_unlink[$i]);
			@unlink('../../uploads/album/thumbnail/'.$photo_unlink[$i]);
			@unlink('../../uploads/album/180X158/'.$photo_unlink[$i]);
			@unlink('../../uploads/album/400X300/'.$photo_unlink[$i]);
		}

/*
 @unlink('../../uploads/album/photo/'.$photo_unlink['thumbnail']);
         @unlink('../../uploads/album/photo/180X158/'.$photo_unlink['thumbnail']);
         @unlink('../../uploads/album/photo/400X300/'.$photo_unlink['thumbnail']);
         @unlink('../../uploads/album/photo/600X600/'.$photo_unlink['thumbnail']);
         @unlink('../../uploads/album/photo/132X101/'.$photo_unlink['thumbnail']);
         @unlink('../../uploads/album/photo/bigimage/'.$photo_unlink['thumbnail']);
         @unlink('../../uploads/album/photo/90X90/'.$photo_unlink['thumbnail']);
*/

       $del_pics=$this->customqry("select * from tbl_albumphotos where album_id='".$albumid."'","");
       while($pics = @mysql_fetch_assoc($del_pics))
      {
         $picdels[] = $pics;
         @unlink('../../uploads/album/photo/'.$pics['thumbnail']);
         @unlink('../../uploads/album/photo/180X158/'.$pics['thumbnail']);
         @unlink('../../uploads/album/photo/400X300/'.$pics['thumbnail']);
         @unlink('../../uploads/album/photo/600X600/'.$pics['thumbnail']);
         @unlink('../../uploads/album/photo/132X101/'.$pics['thumbnail']);
         @unlink('../../uploads/album/photo/bigimage/'.$pics['thumbnail']);
         @unlink('../../uploads/album/photo/90X90/'.$pics['thumbnail']);
      }

      $del_comm=$this->customqry("delete from tbl_albumphotos where album_id='".$albumid."'",""); 

		$del_qry=$this->customqry("delete from `tbl_album` where album_id ='".$albumid."'","");
	}

	function displayUserAlbums($puid,$pageid="",$privacy="")
	{
   		 include_once('../../includes/classes/class.profile.php');
      		 $profObj=new Profile();

		//Fetch User Albums
		if(!isset($pageid))
		{
			$page =1;
		}
		else
		{
			$page=$pageid;
			$page = $page;
		}
		
		$adsperpage =20;
		$StartRow = $adsperpage * ($page-1);
		$l =  $StartRow.','.$adsperpage;
		
		$getphotodetails=$this->cgs("tbl_album","*",array("user_id","pageid","privacy","status"),array($puid,0,$privacy,"Active"),"user_id","DESC limit $l","");
		$profile_obj = new Profile();
		$c=0;
		while($fetch_photodetails=@mysql_fetch_assoc($getphotodetails))
		{
			if($fetch_photodetails["privacy"]=="private" && $puid!=$fetch_photodetails['user_id'])
			{
				$checkfriendsdetails=$profile_obj->checkfriends($puid,$fetch_photodetails['user_id']);
				if($checkfriendsdetails["id"]!="")
				{	
					$photodetails[$c]=$fetch_photodetails;
					$getphoto_cnt=$this->customqry("select thumbnail  from tbl_albumphotos where album_id=".$fetch_photodetails["album_id"]." and status='Active' ","");
					/*$fetch_photocnt=@mysql_fetch_assoc($getphoto_cnt);
					$photodetails[$c]["photocnt"]=$fetch_photocnt["pc"];*/
				
				$photocount=@mysql_num_rows($getphoto_cnt);
				$i=0;

				while($fetch_photocnt1=@mysql_fetch_assoc($getphoto_cnt))
				{
				$fetch_photocnt[$i]=$fetch_photocnt1;$i++;}
				
	
				for($j=0;$j<count($fetch_photocnt);$j++)
				{

					$arr[$j]=$fetch_photocnt[$j]['thumbnail'];
				}
// 				echo "<pre>";				
// 				print_r($arr);
// 				$strphoto=implode(",",$arr);
				$photodetails[$c]["photoids"]=$strphoto;
				$photodetails[$c]["photoids"]=$arr;
				$photodetails[$c]["photocnt"]=$photocount;
				if($photocount>=3)
				{
					$photodetails[$c]["maxph"]=3;
				}
				else
				{
					$photodetails[$c]["maxph"]=1;
				}
				$photodetails[$c]["photocnt"]=$photocount; $profObj->calPhotoAlbumRating($fetch_photodetails['album_id'],"1",$puid);
					$c++;
				}// check for frie
			}
			else
			{	
				$photodetails[$c]=$fetch_photodetails;
				$getphoto_cnt=$this->customqry("select thumbnail  from tbl_albumphotos where album_id=".$fetch_photodetails["album_id"]." and status='Active' ","");
				$photocount=@mysql_num_rows($getphoto_cnt);
				$i=0;

				if($photocount > 0)
				{
					while($fetch_photocnt1=@mysql_fetch_assoc($getphoto_cnt))
					{
					$fetch_photocnt[$i]=$fetch_photocnt1;
						$i++;
					}
					//echo "count:".$photocount;
					for($j=0;$j<$photocount;$j++)
						{
		
							$arr[$j]=$fetch_photocnt[$j]['thumbnail'];
						}
				}
// 				echo "<pre>";				
// 				print_r($arr);
			        $strphoto=implode(",",$arr);
				$photodetails[$c]["photoids"]=$strphoto;
				$photodetails[$c]["photoids"]=$arr;
				$photodetails[$c]["photocnt"]=$photocount;
				if($photocount>=3)
				{
					$photodetails[$c]["maxph"]=3;
				}
				else
				{
					$photodetails[$c]["maxph"]=1;
				}
       				$photodetails[$c]["rating"] = $profObj->calPhotoAlbumRating($fetch_photodetails['album_id'],"1",$puid);
				$c++;	
			}		
		}
		/*----------Pagination Part-2--------------*/
		$rs=$this->cgs("tbl_album","*",array("user_id","pageid","privacy"),array($puid,0,$privacy),"user_id","DESC","");
		$nums = @mysql_num_rows($rs);
		$show =5;
		$total_pages = ceil($nums / $adsperpage);
		
		if($total_pages > 1)
		{
			//$showing   = !isset($_GET["id1"]) ? 1 : $id1;
			$showing   = $page;
			$firstlink = SITEROOT."/".$_SESSION['csUserName']."/".$privacy."/albumphotos/";
			$seperator = '?page=';
			$baselink  = $firstlink;
			$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
			//print_r($pgnation);
		}
		/*-----------------------------------*/ 
			//$smarty -> assign("pgnation",$pgnation);
			//$smarty->assign("photodetails",$photodetails);
			$photodetail[0] = $photodetails;
 			$photodetail[1]['pgnation'] = $pgnation;
 			$photodetail[1]['nums'] = $nums;
			//echo "<pre>";
			//print_r($photodetails);exit;
			return $photodetail;
	}
	



	function displayUserAlbums2($puid,$pageid="",$privacy="")
	{
   		 include_once('../../includes/classes/class.profile.php');
      		 $profObj=new Profile();



//Fetch User Albums
		if(!isset($pageid))
		{
			$page =1;
		}
		else
		{
			$page=$pageid;
			$page = $page;
		}
		
		$adsperpage =4;
		$StartRow = $adsperpage * ($page-1);
		$l =  $StartRow.','.$adsperpage;
		
		$getphotodetails=$this->cgs("tbl_album a left join tbl_users u on a.user_id=u.userid","a.*,u.username",array("a.user_id","a.pageid","a.status"),array($puid,0,"Active"),"a.user_id","DESC","");
		$profile_obj = new Profile();
		$c=0;
		
		//find album count 
		$getablcnt=$this->cgs("tbl_album a left join tbl_users u on a.user_id=u.userid","a.*,u.username",array("a.user_id","a.pageid","a.privacy","a.status"),array($puid,0,$privacy,"Active"),"a.user_id","","");
		$setablcnt = @mysql_num_rows($getablcnt);
		

		while($fetch_photodetails=@mysql_fetch_assoc($getphotodetails))
		{
				$photodetails[$c]=$fetch_photodetails;
				$getphoto_cnt=$this->customqry("select thumbnail  from tbl_albumphotos where album_id=".$fetch_photodetails["album_id"]." and status='Active' ","");
				$photocount=@mysql_num_rows($getphoto_cnt);
				$i=0;

				$aflag =  $fetch_photodetails["album_id"];
			        while($fetch_photocnt1=@mysql_fetch_assoc($getphoto_cnt))
				{
				    $fetch_photocnt[$c][$i]=$fetch_photocnt1['thumbnail'];
				    $i++;
                                }

				//echo "==>".$c;	
				//if($c==$setablcnt-1)
					$arr[$c] = $fetch_photocnt[$c];
				
				// 	echo "<pre>";
				// 	print_r($arr[$c]);
				
			        $strphoto=@implode(",",$arr);
				$photodetails[$c]["photoids"]=$strphoto;
				$photodetails[$c]["photoids"]=$arr[$c];
				$photodetails[$c]["photocnt"]=$photocount;
				if($photocount>=3)
				{
					$photodetails[$c]["maxph"]=3;
				}
				else
				{
					$photodetails[$c]["maxph"]=1;
				}
       				//$photodetails[$c]["rating"] = $profObj->calPhotoAlbumRating($fetch_photodetails['album_id'],"1",$puid);
				$c++;	
		}
		/*----------Pagination Part-2--------------*/
		//$rs=$this->cgs("tbl_album","*",array("user_id","pageid","privacy","status"),array($puid,0,$privacy,"Active"),"user_id","DESC","1");
		$rs=$this->cgs("tbl_album","*",array("user_id","pageid","status"),array($puid,0,"Active"),"user_id","DESC","");	
		$nums = @mysql_num_rows($rs);
		$show =2;
		$total_pages = ceil($nums / $adsperpage);
		
		if($total_pages > 1)
		{
			//$showing   = !isset($_GET["id1"]) ? 1 : $id1;
			$showing   = $page;
			$firstlink =SITEROOT."/photos/album";
			$seperator = '?page=';
			$baselink  = $firstlink;
			$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
			//print_r($pgnation);
		}
		/*-----------------------------------*/ 
			//$smarty -> assign("pgnation",$pgnation);
			//$smarty->assign("photodetails",$photodetails);
			$photodetail[0] = $photodetails;
 			$photodetail[1]['pgnation'] = $pgnation;
			
 			$photodetail[1]['nums'] = $nums;

			//echo "<pre>";
			//print_r($photodetails);exit;
			return $photodetail;

	}



	function createAlbum($albumid,$filearr,$postdata)
	{

		$desc = $postdata["description"];
		$albname = $postdata["album_name"];
		$previmage = $postdata["previmage"];
		$privacy = $postdata["privacy"];
		if($albumid!="")
		{
		if($filearr["image"]["name"]!="")
		{
			$image = newgeneralfileupload($filearr["image"], "../../uploads/album/", true);
			$original['name'] = $image;
			$original['tmp_name'] = "../../uploads/album/".$image;
			
			// for resize details
			$path = "../../uploads/album/thumbnail/";
			$width_array  = array(132);
			$height = 101;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

			// for resize details
			$path = "../../uploads/album/180X158/";
			$width_array  = array(180);
			$height = 158;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

			// for resize details
			$path = "../../uploads/album/400X300/";
			$width_array  = array(400);
			$height = 300;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop
		}
		else
		{
			$image=$previmage;
 	//$image="132184608412.jpg";
		}
		$ablurl = $this->createUrlText($_POST['album_name'],"tbl_album");
		$sf_albumarray=array("album_title","album_description","thumbnail","privacy","url_title");
		$sv_albumarray=array($albname,$desc,$image,$privacy,$ablurl);
		$update_details=$this->cupdt("tbl_album",$sf_albumarray,$sv_albumarray,"album_id",$albumid,"");
		$msg[0]="Album Updated Successfully!";
		//$msg[1]= $albumid;		
	}
	else
	{	
		if($filearr["image1"]["name"]!="")
		{
			$image = newgeneralfileupload($filearr["image1"], "../../uploads/album/", true);
			$original['name'] = $image;
			$original['tmp_name'] = "../../uploads/album/".$image;

			//for wall


			
			// for resize details
			$path = "../../uploads/album/thumbnail/";
			$width_array  = array(132);
			$height = 101;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop

			// for resize details
			$path = "../../uploads/album/180X158/";
			$width_array  = array(180);
			$height = 158;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop
			
			// for resize details
			$path = "../../uploads/album/400X300/";
			$width_array  = array(400);
			$height = 300;
			$path_array = array($path);
			resize_multiple_images_new($original, $width_array, $path_array, $height); // image crop
		}


			//fetch album name from photos
			$photos=$this->cgs("tbl_albumphotos","min(photo_id)",array("album_id","user_id"),array("0",$_SESSION['csUserId']),"photo_id","","");
			$pid = @mysql_fetch_assoc($photos);
			$pid = $pid['min(photo_id)'];
		
			$pic=$this->cgs("tbl_albumphotos",'thumbnail',array("photo_id"),array($pid),"photo_id","","");
			$image = @mysql_fetch_assoc($pic);
			$image = $image['thumbnail'];

		   $ablurl = $this->createUrlText($_POST['album_name'],"tbl_album");
		   $sf_albumarray=array("user_id","album_title","album_description","thumbnail","privacy","added_date","url_title");
		   $sv_albumarray=array($_SESSION["csUserId"],$albname,$desc,$image,$privacy,date("Y-m-d H:i:s"),$ablurl);
		   $insert_details=$this->cgi("tbl_album",$sf_albumarray,$sv_albumarray,"");
		   $msg[0]="Album added Successfully!";		
		   $msg[1]=$insert_details;
        





		$comment =  " created a new photo album ";
// 		$f=array("moduleid","itemid","userid","comment","date_added");
// 		$v=array('14',$insert_details,$_SESSION['csUserId'],$comment,date("Y-m-d h:i:s"));
// 		$id=$this->cgi("tbl_comments",$f,$v,"");

		}
		
	return $msg;
	}

	function setprofpic($userid,$pid)
	{
		include_once('../../includes/common.lib.php');
		$cndn = "user_id=".$userid." and photo_id=".$pid;
		$ans = $this->gj("tbl_albumphotos","*",$cndn,"","","","","1");
		if(is_resource($ans))
		{
			$arrans =@mysql_fetch_assoc($ans);
		}
		
				$original['name'] = $arrans['thumbnail'];	
				$original['tmp_name'] = "../../uploads/album/photo/600X600/".$arrans['thumbnail'];

				// for resize details
				$path = "../../uploads/user_photo/55X55/";
				$width_array  = array(55);
				$height = 55;
				$path_array = array($path);
				resize_multiple_images_news($original, $width_array, $path_array, $height);
		
				$path = "../../uploads/user_photo/90X93/";
				$width_array  = array(90);
				$height = 93;
				$path_array = array($path);
				resize_multiple_images_news($original, $width_array, $path_array, $height); // image crop
		
		
				$path = "../../uploads/user_photo/189X148/";
				$width_array  = array(189);
				$height = 148;
				$path_array = array($path);
				resize_multiple_images_news($original, $width_array, $path_array, $height); // image crop
		
				$path = "../../uploads/user_photo/28X29/";
				$width_array  = array(28);
				$height = 29;
				$path_array = array($path);
				resize_multiple_images_news($original, $width_array, $path_array, $height); // image crop
		
		
				$path = "../../uploads/user_photo/30X31/";
				$width_array  = array(30);
				$height = 31;
				$path_array = array($path);
				resize_multiple_images_news($original, $width_array, $path_array, $height); // image crop
		
				$path = "../../uploads/user_photo/155X157/";
				$width_array  = array(155);
				$height = 157;
				$path_array = array($path);
				resize_multiple_images_news($original, $width_array, $path_array, $height); // image crop
		
				$path = "../../uploads/user_photo/thumbnail/";
				$width_array  = array(212);
				$height = 212;
				$path_array = array($path);
				resize_multiple_images_news($original, $width_array, $path_array, $height); // image crop


				$arr_sf = array("status");
				$arr_sv = array("inactive"); 
				$update_profilephoto=$this->cupdt("tbl_profile_images",$arr_sf,$arr_sv,"userid",$_SESSION['csUserId'],""); 

		
				$sf_albumarray =array("userid","thumb_image");
				$sv_albumarray =array($userid,$original['name']); 
				$insert_details=$this->cgi("tbl_profile_images",$sf_albumarray,$sv_albumarray,"");

				$sf = array("profilephoto","thumbnail");
				$sv = array($pid,$original['name']); 
				$update_profilephoto=$this->cupdt("tbl_users",$sf,$sv,"userid",$_SESSION['csUserId'],""); 

				$comment =  " has changed his profile picture ";
// 				$f=array("moduleid","itemid","userid","comment","date_added");
// 				$v=array('12',$userid,$_SESSION['csUserId'],$comment,date("Y-m-d h:i:s"));
// 				$id=$this->cgi("tbl_comments",$f,$v,"");
	}

	function setAlbumCover($userid,$pid)
	{
		include_once('../../includes/common.lib.php');
		$cndn = "user_id=".$userid." and photo_id=".$pid;
		$ans = $this->gj("tbl_albumphotos","*",$cndn,"","","","","1");
		if(is_resource($ans))
		{
			$arrans =@mysql_fetch_assoc($ans);
		}
		
		$original['name'] = $arrans['thumbnail'];	
		$original['tmp_name'] = "../../uploads/album/photo/600X600/".$arrans['thumbnail'];


		// for resize details
		$path = "../../uploads/album/thumbnail/";
		$width_array  = array(132);
		$height = 101;
		$path_array = array($path);
		resize_multiple_images_news($original, $width_array, $path_array, $height); // image crop

		// for resize details
		$path = "../../uploads/album/180X158/";
		$width_array  = array(180);
		$height = 158;
		$path_array = array($path);
		resize_multiple_images_news($original, $width_array, $path_array, $height); // image crop

		// for resize details
		$path = "../../uploads/album/400X300/";
		$width_array  = array(400);
		$height = 300;
		$path_array = array($path);
		resize_multiple_images_news($original, $width_array, $path_array, $height); // image crop
	
		$update_ablphoto=$this->cupdt("tbl_album","thumbnail",$original['name'],"album_id",$arrans['album_id'],""); 

		$sf = array("ablcover");
		$sv = array($pid); 
		$update_profilephoto=$this->cupdt("tbl_users",$sf,$sv,"userid",$_SESSION['csUserId'],""); 

		//delete previous album photo
		if($update_ablphoto=="1")
		{
			@unlink('../../uploads/album/'.$arrans['thumbnail']);
			@unlink('../../uploads/album/thumbnail'.$arrans['thumbnail']);
			@unlink('../../uploads/album/180X158'.$arrans['thumbnail']);
			@unlink('../../uploads/album/400X300'.$arrans['thumbnail']);
		}
				
	}

	function unsetprofpic($userid,$pid)
	{
		// $sf_albumarray =array("userid","thumb_image");
		// $sv_albumarray =array($userid,""); 
		// $insert_details=$this->cgi("tbl_profile_images",$sf_albumarray,$sv_albumarray,"");

		$sf = array("profilephoto","thumbnail");
		$sv = array("",""); 
		$update_profilephoto=$this->cupdt("tbl_users",$sf,$sv,"userid",$_SESSION['csUserId'],""); 
	}	

		function unsetAlbumCover($userid,$pid)
		{
			$cndn = "user_id=".$userid." and photo_id=".$pid;
			$ans = $this->gj("tbl_albumphotos","*",$cndn,"","","","","");
			if(is_resource($ans))
			{
				$arrans =@mysql_fetch_assoc($ans);
			}
		
			$update_ablphoto=$this->cupdt("tbl_album","thumbnail","","album_id",$arrans['album_id'],""); 
			$sf = array("ablcover");
			$sv = array(""); 
			$update_profilephoto=$this->cupdt("tbl_users",$sf,$sv,"userid",$_SESSION['csUserId'],""); 
	
			if($update_ablphoto=="1")
			{
				@unlink('../../uploads/album/'.$arrans['thumbnail']);
				@unlink('../../uploads/album/thumbnail'.$arrans['thumbnail']);
				@unlink('../../uploads/album/180X158'.$arrans['thumbnail']);
				@unlink('../../uploads/album/400X300'.$arrans['thumbnail']);
			}
		}

		function rotatephoto($rotatedegree,$photoid)
		{
				$degree=0;
				//$photo_path=$this->getInfo("photos","photo_path","photo_id",$photoid);

				$cndn = "photo_id=".$photoid;
				$ans = $this->gj("tbl_albumphotos","*",$cndn,"","","","","");
				if(is_resource($ans))
				{
					$arrans =@mysql_fetch_assoc($ans);
				}
				$photo_path = $arrans['thumbnail'];

				if($rotatedegree=='nclk')
				{
					$degree=270;
				}
				else if($rotatedegree=='ncountclk')
				{
					$degree=90;
				}
				else if($rotatedegree=='halfclk')
				{
					$degree=180;
				}
				
				$photo1="../../uploads/album/photo/".$photo_path;
				$this->getimageforrotate($degree,$photo1);
				$photo2="../../uploads/album/photo/thumbnail/".$photo_path;
				$this->getimageforrotate($degree,$photo2);
				$photo3="../../uploads/album/photo/bigimage/".$photo_path;
				$this->getimageforrotate($degree,$photo3);
				$photo4="../../uploads/album/photo/132X101/".$photo_path;
				$this->getimageforrotate($degree,$photo4);
				$photo5="../../uploads/album/photo/400X300/".$photo_path;
				$this->getimageforrotate($degree,$photo5);
				$photo6="../../uploads/album/photo/180X158/".$photo_path;
				$this->getimageforrotate($degree,$photo6);
				$photo7="../../uploads/album/photo/600X600/".$photo_path;
				$this->getimageforrotate($degree,$photo7);        
		}

		function getimageforrotate($degree,$photo)
		{
			$imageinfo=getimagesize($photo);
			switch($imageinfo['mime'])
			{
			case "image/jpg":
			case "image/jpeg":
			case "image/pjpeg": //for IE
				$src_img=imagecreatefromjpeg($photo);
					break;
			case "image/gif":
				$src_img = imagecreatefromgif($photo);
					break;
			case "image/png":
				case "image/x-png": //for IE
				$src_img = imagecreatefrompng($photo);
					break;
				
				}
				$rotate = imagerotate($src_img, $degree, 0);

			switch($imageinfo['mime'])
			{
				//create the image according to the content type
				case "image/jpg":
				case "image/jpeg":
				case "image/pjpeg": //for IE
					imagejpeg($rotate,$photo);
						break;
				case "image/gif":
					imagegif($rotate,$photo);
						break;
				case "image/png":
					case "image/x-png": //for IE
				imagepng($rotate,$photo);
						break;
			}
		}

		//fetch userid from username
		function fetchAlbumId($url)
		{
			$res=$this->cgs("tbl_album","album_id","url_title",$url,"","","");
			if(is_resource($res))
				$row=@mysql_fetch_row($res);
			return $row[0];
		}
}
$photoObj = new Photos();