<?php
/* INCLUDE REQUIRED FILES */
define('PREFIX', '../../../');
include_once("../../../includes.php");
include_once(PREFIX."includes/grid.class.php");
include_once(PREFIX."includes/classes/input.class.php");
include_once(PREFIX."includes/classes/ps_pagination.php");

define(TABLENAME1,'messages me,outbox ob');

	$grid1 = new Grid();
	$input = new input();
	$m_ids = array();


	$select = "SQL_CALC_FOUND_ROWS *";
	$order_by = "";//"ob.ID ASC";
	$limit='';
	$where="ob.MID=me.MID and ob.FROM_ID=".$_SESSION['usrS_user_id']; 
	//$where="1";
	$gby = "ob.MID ";
	$grid1->select($select)->from(TABLENAME1)->where($where)->orderby($order_by)->limit();//->groupby($gby)
	$grid1->query();
	$grid1->SQL;


	

	/* GENERATE PAGINATION */
	$pager1 = new PS_Pagination($grid1);
	$pager1->paginate();


$filename = basename($_SERVER['PHP_SELF']);
include_once(ABSPATH."/templates/".TEMPLATEDIR."/modules/message/ajax/".$filename);
?>