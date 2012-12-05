<?php
class Cms_pages {

    function __construct(){
    
    } // end function

   function getCmsPageById($pageid){
      global $dbObj;
      $row = array();
      $fields = array( "*" );
      $wf = array( "pageid");
      $wv = array( $pageid);
      $ob = "pageid";
      $ot = "";
      $prn = "";
      $result = $dbObj ->cgs('tbl_pages' , $fields , $wf , $wv , $ob , $ot , $prn); 
      if(is_resource($result)){
         $row = mysql_fetch_assoc($result);
            
      } // if
     
      return $row;
   } // end function  

   function getLightboxCmsContById($recid){
      global $dbObj;
      $row = array();
      $fields = array( "*" );
      $wf = array( "id" , "status" );
      $wv = array( $recid , "1" );
      $ob = "id";
      $ot = "";
      $prn = "";
      $result = $dbObj ->cgs('tbl_lightbox_page' , $fields , $wf , $wv , $ob , $ot , $prn); 
      if(is_resource($result)){
         $row = mysql_fetch_assoc($result);
            
      } // if
     
      return $row;
   } // end function

} // end class

?>