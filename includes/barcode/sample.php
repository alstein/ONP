<? 
 define (__TRACE_ENABLED__, false);
 define (__DEBUG_ENABLED__, false);
								   
 require("barcode.php");		   
 require("i25object.php");
 require("c39object.php");
 require("c128aobject.php");
 require("c128bobject.php");
 require("c128cobject.php");
 						  
/* Default value */
if (!isset($output))  $output   = "png"; 
if (!isset($barcode)) $barcode  = $assign_barcode;
if (!isset($type))    $type     = "C128A";
if (!isset($width))   $width    = "180";
if (!isset($height))  $height   = "100";
if (!isset($xres))    $xres     = "2";
if (!isset($font))    $font     = "5";
$drawtext="on";

/*********************************/ 
		
if (isset($barcode) && strlen($barcode)>0) {    

  $style  = BCS_ALIGN_CENTER;					       
  $style |= ($output  == "png" ) ? BCS_IMAGE_PNG  : 0; 
  $style |= ($output  == "jpeg") ? BCS_IMAGE_JPEG : 0; 
  $style |= ($border  == "on"  ) ? BCS_BORDER 	  : 0; 
  $style |= ($drawtext== "on"  ) ? BCS_DRAW_TEXT  : 0; 
  $style |= ($stretchtext== "on" ) ? BCS_STRETCH_TEXT  : 0; 
  $style |= ($negative== "on"  ) ? BCS_REVERSE_COLOR  : 0; 

  switch ($type)
  {
    case "I25":
			  $obj = new I25Object(250, 120, $style, $barcode);
			  break;
    case "C39":
			  $obj = new C39Object(250, 120, $style, $barcode);
			  break;
    case "C128A":
			  $obj = new C128AObject(250, 120, $style, $barcode);
			  break;
    case "C128B":
			  $obj = new C128BObject(250, 120, $style, $barcode);
			  break;
    case "C128C":
                          $obj = new C128CObject(250, 120, $style, $barcode);
			  break;
	default:
			$obj = false;
  }
 /* if ($obj) {
     if ($obj->DrawObject($xres)) {
         echo "<table align='center'  cellspacing='2' cellpadding='7' ><tr><td><img src='image.php?code=".$barcode."&style=".$style."&type=".$type."&width=".$width."&height=".$height."&xres=".$xres."&font=".$font."'></td></tr></table>";
     } else echo "<table align='center'><tr><td><font color='#FF0000'>".($obj->GetError())."</font></td></tr></table>";
  }*/
}
?>
