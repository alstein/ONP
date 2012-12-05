<?php
include_once('DBTransact.php');

Class Message extends DBTransact
{

      function showmessage($msgcode)
      {
	  $db=new DBTransact();
	  $rs = $db->cgs("mast_errmsg", "", "msgid", $msgcode, "", "", '');
	  $rn = @mysql_num_rows($rs);
	  if($rn)
	  {
		  extract($rw=@mysql_fetch_array($rs));
	  }
	  $msgarray['msgtext']=$msgtext;
	  $msgarray['msgtype']=$msgtype;
		// return($msgtext);
	  return($msgarray);
      }
      function showans($qid)
      {
	      $db=new DBTransact();
	      $rs = $db->cgs("pollans", "", "pollqusid", $qid, "", "", "");//EXIT;
	      while($row=@mysql_fetch_array($rs))
	    {
	      $rowS[]=$row;
	    }
	      return($rowS);
      }
      
       //Get all category name and id
	function getCategoryname($parentid)
	{	
			$query = "select * from mast_deal_category where id=".$parentid;
			$res = mysql_query($query);
			return @mysql_fetch_assoc($res);
		
	}
	function clean_url($text)
        {
            $text=strtolower($text);
            $code_entities_match = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','=');
            $code_entities_replace = array('-','-','','','','','','','','','','','','','','','','','','','','','','','','');
            $text = str_replace($code_entities_match, $code_entities_replace, $text);
            return $text;
        } 

/*function showmessage($msgcode)
{
    $db=new Database();
    $rs = $db->cgs("mast_errmsg", "", "msgid", $msgcode, $ob, $ot, 0);
    $rn = @mysql_num_rows($rs);
  if($rn)
   {
        extract($rw=@mysql_fetch_array($rs));
         echo "<table align='left' width='100%' border = '0' ><tr class= 'brd_yellow'>";
        switch($msgtype)  //according to messagetype image get selected
        {
         case "e":        $image = "wrong.gif";
                 break;
         case "s":        $image = "rite.gif";
                 break;
         case "a":        $image = "alert.gif";
                 break;
         default :        $image = "";         
        }// End of switch 
  }//End if
?>
          <td align="left" width="5%" ><!--<img src='<?php //echo SITEROOT; ?>/templates/<?php //echo TEMPLATEDIR; ?>/images/<? //$image?>' />--></td>
  
  <?
           echo"<td align = 'left' class='red_text'><b>".$msgtext."</b></td>";//This displays message
         echo"</tr></table>";
 }*/

}
$msobj= new message();
?>