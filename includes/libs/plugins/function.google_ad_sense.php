<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {mailto} function plugin
 *
 * Type:     function<br>
 * Name:     getmessage<br>
 * Date:     May 21, 2002
 * Purpose:  to show session message.<br>
 * Input:<br>
 *         - nothing
 *
 * Examples:
 * 
 * {getmessage}
 * 
 * 
 * @version  1.2
 * @author   Yogesh Kadam [ k dot yogesh at .com]
 * @author   credits to Jason Sweat (added cc, bcc and subject functionality)
 * @param    array
 * @param    Smarty
 * @return   string
 */
function smarty_function_google_ad_sense($param)
{
   $rs = mysql_query("select * from mast_google_addsense where addsenseid=".$param['addid']);
   $row = @mysql_fetch_assoc($rs);
   $output = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td>".$row['adds']."</td></tr></table>";
   echo $output;
}
?>