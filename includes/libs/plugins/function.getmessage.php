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
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @author   credits to Jason Sweat (added cc, bcc and subject functionality)
 * @param    array
 * @param    Smarty
 * @return   string
 */
function smarty_function_getmessage()
{
    $msg = $_SESSION['msg'];
	echo $msg;
}

/* vim: set expandtab: */

?>
