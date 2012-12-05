<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty limit_text modifier plugin
 *
 * Type:     modifier<br>
 * Name:     limit_text<br>
 * Purpose:  get limited text with completing last word
 * @link http://smarty.php.net/manual/en/language.modifier.string.format.php
 *          limit_text (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param string
 * @return string
 */

function smarty_modifier_limit_text($string, $limit)
{
  // figure out the total length of the string
  if( strlen($string)>$limit )
  {
    # cut the text
    $string = substr( $string,0,$limit );
    # lose any incomplete word at the end
    $string = substr( $string,0,-(strlen(strrchr($string,' '))) );
  }

  // return the processed string
  return $string;
}
/* vim: set expandtab: */

?>