<?php
define('DB_SERVER', 'mysqlv103');
define('DB_USERNAME', 'messaget_db123');
define('DB_PASSWORD', 'Msgdb123');
define('DB_DATABASE', 'messaget_messag');
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());
mysql_query ("set character_set_results='utf8'");   
?>
