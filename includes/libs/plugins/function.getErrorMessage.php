<?

	/*		written by MR - 27-07-2010			*/

	function smarty_function_getErrorMessage($params, &$smarty){
		if (empty($params['emid'])) {
			$smarty->_trigger_fatal_error("[plugin] parameter 'file' cannot be empty");
			return;
		}

		if($params['emid'] > 0){
			$rs = $dbObj->cgs("mast_error_messages", "emessage", "emid",$params['emid'], "", "", "");
			$row = mysql_fetch_object($rs);
			return $row->emessage;
		}	
	}


?>