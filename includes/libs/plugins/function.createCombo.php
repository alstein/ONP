<?

	//	$tablename	$id		$name		$selected_id=0		$order_by="*"		$where="+"		$selectFields="*"


	function smarty_function_createCombo($params, &$smarty){
		if (empty($params['tablename']) && empty($params['id']) && empty($params['name'])) {
			$smarty->_trigger_fatal_error("[plugin] parameter 'file' cannot be empty");
			return;
		}

		echo $params['selected_id']		= 	($params['selected_id']?$params['selected_id']:0);
		$params['order_by'] 		= 	($params['order_by']?$params['order_by']:"*");
		$params['where']			=	($params['where']?$params['where']:"+");
		$params['selectFields'] 	= 	($params['selectFields']?$params['selectFields']:"*");

		$dis = split(",",$params['name']);

		if($params['order_by'] == "*" and $params['where'] == "+")	{		$wh = " 1";		}
		if($params['order_by'] != "*" and $params['where'] == "+")	{		$wh = " 1 ".$params['order_by'];		}
		if($params['order_by'] == "*" and $params['where'] != "+")	{		$wh = $params['where'];		}
		if($params['order_by'] != "*" and $params['where'] != "+")	{		$wh = $params['where']." ".$params['order_by'];		}

		$query = "select ".$params['selectFields']." from ".$params['tablename']." where ".$wh;
		$result = mysql_query($query);

		while($row=mysql_fetch_array($result)){
			if(strlen(trim($params['selected_id'])) > 0 && $params['selected_id'] <> "0"){
				if(trim($row[$params['id']]) == trim($params['selected_id'])){
					$mm = "selected='selected'";
				}else{
					$mm = " ";
				}
			}
			$mr.= "<option value='".$row[$params['id']]."' ".$mm.">";
			if(sizeof($dis) == 1){
				$mr.=$row[$dis[0]];
			}else{
				for($i=0;$i<sizeof($dis);$i++){
					$mr.=$row[$dis[$i]]." ";
				}
			}
			$mr.="</option>";
		}



		return $mr;
	}




?>