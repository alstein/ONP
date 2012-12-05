<?php
class Content extends DBTransact
{
        function getCaptcha()
        {
		$captchaTextSize = 7;
		do {
			// Generate a random string and encrypt it with md5
			$md5Hash = md5( microtime( ) * mktime( ) );
			// Remove any hard to distinguish characters from our hash
			preg_replace( '([1aeilou0])', "", $md5Hash );
		}
		while( strlen( $md5Hash ) < $captchaTextSize );
		// we need only 7 characters for this captcha
		$key = substr( $md5Hash, 0, $captchaTextSize );
		return $key = strtoupper($key);
        }
        function getContactSubject()
        {
	      $rs = $this->cgs("contactus_subject", "*", "status", "1", "", "", "");
              $contactussub ="";

	      if($rs != 'n')
              {
		  while($row = mysql_fetch_assoc($rs))
		  {
		    $contactussub[] = $row;
		  }
	      }
              return $contactussub;
        }
        function getFAQ()
        {
		$query = "select * from faq_cat where del_status='1' order by faq_cat_id ASC";
		$rs = mysql_query($query);
		$array_FAQ = array();
		if($rs)
                {
			$i=0;
			while($row = mysql_fetch_assoc($rs))
			{
			      $array_FAQ[$i]['c_id'] = $row['faq_cat_id'];
			      $array_FAQ[$i]['name'] = str_replace("Faq","FAQ",$row['faq_cat']);
	
			      $_query = "select * from tbl_faqs where faq_cat_id = ".$row['faq_cat_id']." and del_status='1' order by faqid ASC";
			      $_rs = mysql_query($_query);
			      $_num = @mysql_num_rows($_rs);
			      if($_num > 0)
			      {
				  $j=0;
				  while($_row = mysql_fetch_assoc($_rs)){
				    $array_FAQ[$i]['ques'][$j]['qid'] = $_row['faqid'];
				    $array_FAQ[$i]['ques'][$j]['question'] = $_row['faqquestion'];
				    $array_FAQ[$i][$j]['ans'][0]['answer'] = $_row['faqanswer'];
				    $j++;
				  }
			      }
			      $i++;
			  }
		}
                return $array_FAQ;
        }

}
?>