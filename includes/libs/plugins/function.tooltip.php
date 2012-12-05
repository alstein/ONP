<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {tooltip} function plugin
 *
 * Type:     function<br>
 * Name:     tooltip<br>
 * Input:<br>
             - label_id       (required) 
 *           * Purpose:  Prints the list of <option> tags generated from
 *           the passed parameters
 * @link http://smarty.php.net/manual/en/language.function.html.options.php {html_image}
 *      (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com>
 * @param array
 * @param Smarty
 * @return string
 * @uses smarty_function_escape_special_chars()
 */
function smarty_function_tooltip($tooltip, &$smarty)
{
    if($tooltip['label_id']!="")
    {
       $query = "select tooltip_id,description from tbl_tooltip where tooltip_id='".$tooltip['label_id']."'";
        $run = @mysql_query($query);
        $row_tool = @mysql_fetch_assoc($run);
    }
    return $row_tool['description'];
}

/* vim: set expandtab: */

?>
