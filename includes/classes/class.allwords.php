<?php
class Allwords extends DBTransact
{

    var $lbl_Info = array();

    function $res($page,$lang)
    {
	$res = $this->gj("tbl_lang_words","*","page",$page,"","","1");
	if($res != 'n')
	{
            $i =0;
	    while($row= @mysql_fetch_assoc($res))
            {
                $lbl_Info[''
            }

	    return $card_Info;
	}
    }
   
}
$wordObj = new Allwords();
?>