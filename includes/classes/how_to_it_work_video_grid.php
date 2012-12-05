<?php
class How_It_Work_Video {

    function __construct(){
    
    } // end function

    function getSearchVideo(){
      global $dbObj;
     // $lang_id = (($_SESSION['lan_id']=="")?$_SESSION['defaultlanid']:$_SESSION['lan_id']);     
      
//       $qry="SELECT hv.id,hv.video,hv.added_date,hv.is_active,l.id as language_id,l.language
//       FROM how_it_work_video hv
//       LEFT JOIN language l ON hv.lang_id=l.id
//       WHERE l.id=".$lang_id;
       $qry="SELECT * FROM tbl_videos";
      $prn = "";        
        return $rs=$dbObj -> customqry($qry, '');
    }//end function

   function updateVideo($array, $id){
      global $dbObj;
      $isError = "no";
      $errMsg = "";

      $res_dldet = $dbObj->cgs("how_it_work_video","","id",$id,"","","");
      $row_dldet = @mysql_fetch_assoc($res_dldet);

   $extvideo = strtolower(strrchr($_FILES['video']['name'], "."));

   if($_FILES['video']['name'])
      {

         if($_FILES['video']['size']<10000000)
            {

               if($row_dldet['video'])
                  {
                     @unlink("../../uploads/how_it_work_video/".$row_dldet['video']);

                  }

                  $uploaded = generalfileupload($_FILES['video'] , "../../uploads/how_it_work_video", 1);

            }
         else
            {
                  $isError = "yes";
                  $errMsg .="<span class='error'>Please upload the video file size upto 10MB only</span>";
            } 
      }
      else
         {
// print_r($_FILES['file']['name']);exit;
            $uploaded = $row_dldet['video'];

         }

   if($isError == "no")
      {        

         $fields = array(  "video" , "added_date","is_active" );
         $values = array(  $uploaded , $array["added_date"], $array["is_active"] );
         $wf = array( "id" );
         $wv = array( $id );
         $prn = "";
         //return $result = $dbObj ->cupdt('lesson' , $fields , $values , $wf , $wv , $prn);
         $result = $dbObj ->cupdt('how_it_work_video' , $fields , $values , $wf , $wv , $prn);
         return $isError;

      }
   else
      {

         $_SESSION['msg'] = $errMsg;
         return $isError;
      }
    }//end funtion

      function getVideoById($id){
         global $dbObj;
         $fields = array( "id" , "lang_id" , "video" , "added_date","is_active" );
         $wf = array( "id");
         $wv = array( $id);
         $ob = "id";
         $ot = 'asc';
         $prn = "";
         $result = $dbObj ->cgs('how_it_work_video' , $fields , $wf , $wv , $ob , $ot , $prn); 
        
        if(is_resource($result)){
            $row = mysql_fetch_assoc($result);
        } // if
        
        return $row;
    } // end function 

         function getUnitVideoById($lang_id){
         global $dbObj;
         $fields = array( "id" , "lang_id" , "video" , "added_date","is_active" );
         $wf = array( "lang_id","is_active");
         $wv = array( $lang_id,1);
         $ob = "id";
         $ot = 'asc';
         $prn = "";
         $result = $dbObj ->cgs('how_it_work_video' , $fields , $wf , $wv , $ob , $ot , $prn); 
        
        if(is_resource($result)){
            $row = mysql_fetch_assoc($result);
        } // if
        
        return $row;
    } // end function 

       function updateStatus($ids, $status){
        global $dbObj;        
        if(is_array($ids) && (sizeof($ids) > 0)){
            $ids = implode(",", $ids);
        }
        if(strlen($ids) > 0){
            $sql_update = "update how_it_work_video set is_active='".$status."' where id in (".$ids.")";
            $dbObj->customqry($sql_update,'');
        }
        
    } // end function

} // end class



?>