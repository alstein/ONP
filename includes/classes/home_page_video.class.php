<?php
class Home_Page_Video 
{

    function __construct()
    {

    } // end function
    
    function addNewHomePageVideo($array){
         global $dbObj;
         $isError = "no";
         $errMsg = "";
         $extvideo = strtolower(strrchr($_FILES['video']['name'], "."));
   if($_FILES['video']['name'])
      {
   
         if($_FILES['video']['size']<10000000)
            {
               if($extvideo == ".mp4"){
                  $uploaded_file = generalfileupload($_FILES['video'] , "../../uploads/home_page/video", 1);         
               }
               else{
                     
                     $errMsg .="<span class='error'>Please upload the video file with .mp4 extension </span>";
               }
            }
          else
            {
               $isError = "yes";
               $errMsg .="<span class='error'>Please upload the video file size upto 10MB only</span>";
            }
      }
         
      if($isError == "no")
         {
            $fields = array( "video_title" , "video_type" , "video_file" , "image" , "video" ,"sort_order", "added_date" , "is_active" );
            $values = array( $array["lang_id"] , $array["title"] , $array["description"] , $array["image"] , $uploaded_file ,$array["sort_order"], $array["added_date"] , $array["is_active"] );
            $prn = "1";
            $result = $dbObj ->cgi('home_page_videos' , $fields , $values , $prn);
            return $isError;   
         }else
         {
            $_SESSION['msg'] = $errMsg;
            return $isError;
         }
    } // end function 
    /**
    * function for update the records from database
    */
/**
    * function will update status: active/inactive
    * database value: 1-active and 0-inactive
    */
    function updateStatus($ids, $status){
        global $dbObj;        
        if(is_array($ids) && (sizeof($ids) > 0)){
            $ids = implode(",", $ids);
        }
        if(strlen($ids) > 0){
            $sql_update = "update home_page_videos set is_active='".$status."' where id in (".$ids.")";
            $dbObj->customqry($sql_update,'');
        }
        
    } // end function

   function delVideo($del_id){
      global $dbObj;
      $sql_del = "update home_page_videos set video='' where id=".$del_id;
      $dbObj->customqry($sql_del,'');
   }

    function deleteHomeVideo($ids){
    global $dbObj;
        if(is_array($ids) && (sizeof($ids) > 0)){

            $ids = implode(",", $ids);
        }
        if(strlen($ids) > 0){
   
   //delete map setting once main unit record is delete
//    $sql_del_mapSet = "delete from home_page_videos where unit_id in (".$ids.")";
//    $dbObj->customqry($sql_del_mapSet,'');

          $sql_update1 = "select * from home_page_videos where id in (".$ids.")";
         $result= @mysql_query($sql_update1);
         while($row = @mysql_fetch_assoc($result))
            {

               @unlink("../../uploads/home_page/image/".$row['image']);
               @unlink("../../uploads/home_page/image/small_image/".$row['image']);
               @unlink("../../uploads/home_page/image/949x442/".$row['image']);
               @unlink("../../uploads/home_page/video/".$row['video']);
              
            }

            $sql_update = "delete from home_page_videos where id in (".$ids.")";
            $dbObj->customqry($sql_update,'');
        }

    } // end function

     function updateHomePageVideo($array, $id){
      global $dbObj;
      $isError = "no";
      $errMsg = "";
      $res_dldet = $dbObj->cgs("home_page_videos","","id",$id,"","","");
      $row_dldet = @mysql_fetch_assoc($res_dldet);

      
   if($_FILES['video']['name'])
      {
         if($_FILES['video']['size']<10000000)
            {
               if($row_dldet['video'])
                  {
                     @unlink("../../uploads/home_page/video/".$row_dldet['video']);

                  }
                  $uploaded_file = generalfileupload($_FILES['video'] , "../../uploads/home_page/video", 1);
            }
         else
            {
                  $isError = "yes";
                  $errMsg .="<span class='error'>Please upload the video file size upto 10MB only</span>";
            } 
      }
      else
         {
   
            $uploaded_file = $row_dldet['video'];
         }

      if($_FILES['image']['name']){

            if($row_dldet['image']){
             @unlink("../../uploads/home_page/image/".$row_dldet['image']);
             @unlink("../../uploads/home_page/image/small_image/".$row_dldet['image']);
             @unlink("../../uploads/home_page/image/949x442/".$row_dldet['image']);
            }
               $uploaded_image=$array["image"];

      }else{
               $uploaded_image = $row_dldet['image'];
                
      }

      if($isError == "no")
         {  
            $fields = array( "lang_id" , "title" , "description" , "image" , "video" ,"sort_order", "added_date" , "is_active" );
            $values = array( $array["lang_id"] , $array["title"] , $array["description"] , $uploaded_image , $uploaded_file ,$array["sort_order"], $array["added_date"] , $array["is_active"] );
            $wf = array("id");
            $wv = array($id);
            $prn = 1;
            $result = $dbObj ->cupdt('home_page_videos' , $fields , $values , $wf , $wv , $prn);
            return $isError;
         }
      else
         {
   
            $_SESSION['msg'] = $errMsg;
            return $isError;
         }
    }//end funtion

     function getHomePageById($id){
         global $dbObj;
         $row = array(); 
         $fields = array( "id" , "lang_id" , "title" , "description" , "image" , "video" ,"sort_order", "added_date" , "is_active" );
         $wf = array( "id");
         $wv = array( $id);
         $ob = "id";
         $ot = 'asc';
         $prn = "";
         $result = $dbObj ->cgs('home_page_videos' , $fields , $wf , $wv , $ob , $ot , $prn);  
        
        if(is_resource($result)){
            $row = mysql_fetch_assoc($result);
        } // if
        
        return $row;
    } // end function 
   
} // end class

?>