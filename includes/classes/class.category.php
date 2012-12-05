<?php

class Sports_Model extends DBTransact {
	public $category = "";
	public function Sports_Model(){
		parent::Model();
	}//end Sports_Model

	#-----------------------------------------
	// Sports oprations from admin site
	#-----------------------------------------

	public function sportsOperations($data,$action='',$edit_id=0){
		switch($action){
			case 'addnew':
					//	insert new record
					if(is_array($data)){
						$this->db->query($this->db->insert_string("category",$data));
						return $this->db->insert_id();
					}
					break;
			case 'update':
					//	update existing record
					if(is_array($data)){
						$this->db->query($this->db->update_string("category",$data,array('id' => $edit_id)));
						return 1;
					}
					break;
			case 'delete':
						$this->db->query("delete from category where id in (".$data['id'].")");
						return "Sports Category(s) deleted successfully.";
					break;
			case 'active':
						$this->db->query("update category set active='1' where id in (".$data['id'].")");
						return "Sports Category(s) actived successfully.";
					break;
			case 'inactive':
						$this->db->query("update category set active='0' where id in (".$data['id'].")");
						return "Sports Category(s) inactived successfully.";
					break;
		}
	}//end SportsOperations

	#-----------------------------------------
	// Count all Sports records
	#-----------------------------------------
	public function countSportsRecords($search = '-'){
		if($search != "-")
			return $this->db->query("select count(id) as rowcount from category where cat like '%".$search."%'")->row()->rowcount;
		else
			return $this->db->query("select count(id) as rowcount from category")->row()->rowcount;
	}//end countSportsRecords

	#-----------------------------------------
	// Get Sports records list
	#-----------------------------------------

	public function getSportsRecords($num=0, $offset=0,$search = ''){
		if($offset > 0){
			if($search != "-"){
				return $this->db->query("SELECT * from category where sports like '%".$search."%' order by sports asc limit ".$num .",".$offset);
			}else{
				return $this->db->query("SELECT * from category where 1 order by sports asc limit ".$num .",".$offset);
			}
		}else{
			return $this->db->query("SELECT * from category where 1 order by sports asc");
		}
	}//end getSportsRecords

	#-----------------------------------------
	// get Sports record by id
	#-----------------------------------------

	public function getSportsById($id=0){
		if($id > 0){
			$query = $this->db->query("select * from category where id=".$id);
			$row = array();
			if($query->num_rows() > 0){
				$row = $query->row();
			}
			return $row;
		}
	}//end getSportsById

	#-----------------------------------------
	// get Sports name by id
	#-----------------------------------------

	public function getSportsNameById($id=0){
		if($id > 0){
			$query = $this->db->query("select sports from category where id=".$id);
			$row = "";
			if($query->num_rows() > 0){
				$rw = $query->row();
				$row = $rw->sports;
			}
			return $row;
		}
	}//end getSportsNameById

	public function getSportsByParentid($parent_id=0){

			return $this->db->query("select * from category where parent_id=".$parent_id);

	}//end getSportsByParentid


	public function getSportsTree($maincategory, $level,$mr){
		$category = "";
		$query = $this->db->query("select * from category where parent_id=".$maincategory);
		$i=0;
		foreach ($query->result() as $db){
			if($db->parent_id == 0)	{	$mr = $db->id;	}
			$check_db = $this->db->query("select * from category where parent_id=".$db->id);
			
			if($level == 0){
				$category.="<li><span class='folder'>".$db->sports."&nbsp;&nbsp;<a href='".$this->config->item('base_url')."sports/sportsaddmodify/".$db->id."' class='LinkBlue'>Edit</a> | <a href='".$this->config->item('base_url')."sports/admin/".$db->id."' class='LinkBlue' onclick=\"javascript:return confirm('Are you sure want to delete?');\">Delete</a></span>";
				
				//check child is exits or not
				if($check_db->num_rows() > 0)	{	$category.="<ul>";	}
				if($check_db->num_rows() < 1)	{	$category.="</li>";	}
			}else{
				$category.="<li><span class='file'>".$db->sports."&nbsp;&nbsp;<a href='".$this->config->item('base_url')."sports/sportsaddmodify/".$db->id."' class='LinkBlue'>Edit</a> | <a href='".$this->config->item('base_url')."sports/admin/".$db->id."' class='LinkBlue' onclick=\"javascript:return confirm('Are you sure want to delete?');\">Delete</a></span>";

				if($check_db->num_rows() > 0)	{	$category.="<ul>";	}
			}
		
			$x_data = $this->getSportsTree($db->id,$level + 1,$mr);
			$category.= $x_data;
	
			if($i == $query->num_rows()-1)	{			$category.="</ul>";	}

			if($db->parent_id == 0)	{	$category.="</li>";	}
			$i++;
		}
		return $category;
	}

	function categoryCombo($tablename,$parentid,$id,$name,$maincategory, $level,$selected_id = 0){
		$query = $this->db->query("select * from ".$tablename." where ".$parentid."=".$maincategory);
		
		$category = "";

		$max_data = "";
		
		for($i = 0; $i< $level; $i++){
			$max_data = $max_data." ....... ";
		}

		$i=0;
		$sele = "";
		foreach ($query->result() as $db){
			if($selected_id > 0){
				if($selected_id == $db->{$id}){
						$sele = "selected='selected'";
				}else{
						$sele = " ";
				}
			}
			
			if($level == 0){
				$category.="<option value='".$db->{$id}."'".$sele.">".$db->{$name}."</option>";
			}else{
				$category.="<option value='".$db->{$id}."'".$sele.">".$max_data.$db->{$name}."</option>";
			}
			$x_data = $this->categoryCombo($tablename,$parentid,$id,$name,$db->{$id},$level + 1,$selected_id);
			$category.= $x_data;
			$i++;
		}
		return $category;
	}

}//end class Sports_Model

?>