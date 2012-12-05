<?
	/*
	+--------------------------------------------------------------------------------------+
	
		File Name : file.php
		Class Name : file
		Class Description : filehanding.
	#	Author	:	MR - AP 
		Creation Date : 
		Updatetiion Date : 
	
	+--------------------------------------------------------------------------------------+
	*/

	class file{
		var $filename;
		var $fp;
		var $filemode;
		var $filedata;
		var $field_array = "";
		
		function file($filename = "",$mode = "r"){
			$this->filename = $filename;
			$this->filemode = $mode;
		}// end of the function

		function read(){
			if(!$this->fp && !is_dir($this->filename))
			{
				$this->fp = fopen($this->filename,$this->filemode);
			}

			if(!$this->fp)
			{
				$this->filedata = "Cannot get files [ "  . $this->filename . " ] ";
			}
			else
			{
				$this->filedata = fread($this->fp,filesize($this->filename));
			}
		}

		function display() { return $this->filedata; }



		function __getVariable()
		{
			preg_match_all("|\[\[(.*)\]\]|U",$this->filedata,$out,PREG_PATTERN_ORDER);
			return $out[1];
		}

		function __Variable($variable)
		{
			preg_match_all("|\[\[(.*)\]\]|U",$this->filedata,$out,PREG_PATTERN_ORDER);

			$variable = explode(",",$variable);
			for($count = 0;$count < sizeof($variable);$count++)
			{
				if(!in_array($variable[$count],$out[1]))
				{
					return trim($variable[$count]);
				}
			}
			return "";
		}

		function write($stmt)
		{
			if(!$this->fp)
			{
				$this->fp = fopen($this->filename,"w+");
			}

			if(!$this->fp)
			{
				trigger_error("Error while hadnling the file " .$this->filename,E_USER_ERROR);
			}
			else
			{
				if(!fwrite($this->fp,$stmt))
				{
					return 0;
				}
				else
				{
					return 1;
				}
			}
		}

	} //end of the function

?>