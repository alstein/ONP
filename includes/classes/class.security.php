<?php
Class Security extends DBTransact
{
    	public function __construct()
    	{
        	$this->p = new Profile;
    	}

	function getEduClass($userid)
	{
		$tbl = "tbl_student";
		$sf = "schoolid, gradeid, classid";
		$cnd = "userid = '".$userid."' AND current= '1'";
		$row= $this->gj($tbl, $sf, $cnd , "", "", "", "", "");
		if(is_resource($row))
		{
			$i = 0;
			while($rec = mysql_fetch_assoc($row))
			{
				$class[$i] = $rec['classid'];
				$grade[$i] = $rec['gradeid'];
				$school[$i] = $rec['schoolid'];
				$i += 1;
			}
		}
		return array($school, $grade, $class);
	}

	function isLinktoProfile($profile_userid,$userid="")
	{
		$authority = 'yes';
		
		$privacy_setting = $this->p->getPrivacySetting($profile_userid);
		$sess_edu = $this->getEduClass($userid);
		$pro_edu = $this->getEduClass($profile_userid);
		if($_SESSION['csRoleId'] == '2')
		{
			if($privacy_setting['view_other_school'] == 1)
			{
				if(!@in_array($_SESSION['csUserId'], $pro_edu[0]))
				{
					$authority = 'no';
				}
			}
		}
		else
		{
			$school_arr = $sess_edu[0];
			$grade_arr = $sess_edu[1];
			$class_arr = $sess_edu[2];
			//$allow = 'yes';
			// fetch plus minus one grade level
			$child_pm_gr=array();
			for($i=0; $i<sizeof($pro_edu[1]); $i++)
			{
				$plus = $pro_edu[1][$i]+1;
				$min = $pro_edu[1][$i]-1;
				$res = $this->gj("tbl_grade", "*","gradeid IN (".$plus.",".$min.",".$pro_edu[1][$i].")", "gradeid","","ASC","","");
				while($rec = @mysql_fetch_assoc($res))
				{
					$child_pm_gr[] = $rec['gradeid'];
				}
			}
			$child_pm_gr = @array_unique($child_pm_gr);
			if($privacy_setting['share_school'] == 1)
			{
				if($school_arr !="") 
				{
					foreach($school_arr as $k=>$v)
					{
						if(!@in_array($v, $pro_edu[0]))
						{
							$authority = 'no';
						}
					}
				}
				else 
				{
					$authority = 'no';
				}
			}
			elseif($privacy_setting['share_pm_grade'] == 1)
			{
				if($school_arr !="") 
				{
					foreach($school_arr as $k=>$v)
					{
						if(!@in_array($grade_arr[$k],$child_pm_gr))
						{
							$authority = 'no';
						}
					}
				}
				else 
				{
					$authority = 'no';
				}
			}
			elseif($privacy_setting['share_grade'] == 1)
			{
				if($school_arr !="") 
				{
					foreach($school_arr as $k=>$v)
				  	{
						if(!@in_array($grade_arr[$k],$pro_edu[1]))
						{
							$authority = 'no';
						}
				  	}
				}
				else 
				{
					$authority = 'no';
				}
			}
			elseif($privacy_setting['share_class'] == 1)
			{
				if($school_arr !="") 
				{
					foreach($school_arr as $k=>$v)
					{
						if(!@in_array($class_arr[$k],$pro_edu[2]))
						{
							$authority = 'no';
						}
					}
				}
				else 
				{
					$authority = 'no';
				}
			}
			else
			{
				$authority = 'no';
			}
		}
		return $authority;
	}

}
$secObj = new Security();
?>