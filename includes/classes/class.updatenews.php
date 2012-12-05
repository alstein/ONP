<?php	
include_once("../../../includes/common.lib.php");
class news extends DBTransact
{

	

	function updatenews()
	{	
 		extract($_POST);
		//print_r($_FILES);
		//*******************Resize and Uoload Photo**************************//
		if($_FILES['image'])

		{
		
			$photo = uploadandresize($_FILES['image'], "../../../uploads/news/big", "../../../uploads/news/", 80, 60);
		
		
		//*******************End Of Upload************************************//
		
		if($photo['thumbnail'])
		{	
			//@unlink("../../../uploads/news/big/".$oldimage);
			//@unlink("../../../uploads/news/".$oldimage);			
			

			$f= array("photo", "postedDate","status");
			$v = array( $photo['thumbnail'],date('Y-m-d H:i:s'),$status);
		}
		else	
		{
			$f= array("photo","postedDate","status");
			$v = array( $oldimage,date('Y-m-d H:i:s'),$status);
	
		}

		$id = $this->cupdt("tbl_news", $f, $v, "newsId", $newsId, "");
}
		//****************Update News Description Table*************************//
		
			$f=array("title","description");
			$v = array($title1,$description);
			$l_id = '1';
// 			$wf= array("newsId","language_id");
// 			$wv=array($newsId,$l_id);
			//**********Update for English**********//
			
			$rsup = $this->cupdt("tbl_news_description", $f,$v, 'newsId', $newsId, "");


		//*******************END***************************************************//
	//exit;	
	return $id;
		
	}

	function updatenewswithoutphoto()
	{	
 		extract($_POST);
		//print_r($_FILES);
		//*******************Resize and Uoload Photo**************************//
					
			

			$f= array("photo", "postedDate","status");
			$v = array( "",date('Y-m-d H:i:s'),$status);
		

		$id = $this->cupdt("tbl_news", $f, $v, "newsId", $newsId, "");

		//****************Update News Description Table*************************//
		
			$f=array("title","description");
			$v = array($title1,$description);
			$l_id = '1';
// 			$wf= array("newsId","language_id");
// 			$wv=array($newsId,$l_id);
			//**********Update for English**********//
			
			$rsup = $this->cupdt("tbl_news_description", $f,$v, 'newsId', $newsId, "");


		//*******************END***************************************************//
	//exit;	
	return $id;
		
	}

}
?>
