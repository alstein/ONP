<?php

/**
 * 
 * Reports class file.
 * 
 * This file is intended to be used to Validate values.
 * It defines Validation class by extending Functions, a class providing globally
 * available functionalities needed in newframework.
 * * Version history:
 * 1.0
 *  Created By: Jaikumar Murjani
 *  Created Date: 17 Jan 2009
 */

/**
 * Name: Validation
 *
 * descriptioniption: This class extends Functions of the framework and implements the view method.
 * 
 * @access public
 * @package Controllers
 */

class Validation{

	/**
	 *  Description: Constructor.
	 *  Date & Time: 17th-01-2009 & 18:19
	 *  return void
	 */
	function Validation(){}

	/**
	 *  Description: Email Validation function.
	 *  Date & Time: 17th-01-2009 & 18:24
	 *  return bool
	 */
	function validateEmail($email){
	
		$pattern_email = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z]{2,6})*(\.[a-z]{2,3})$";
		//$pattern_email = "^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$";
	
		if(($email === "") || (empty($email)) || (strlen($email) === 0)){
	
			return(false);
		} else if(eregi($pattern_email, $email)){
	
			return(true);
		}
	
		return(false);
	}

	/**
	 *  Description: Name Validation function.
	 *  Date & Time: 18th-01-2009 & 10:25
	 *  return bool
	 */
	function validateName($val, $full = FALSE, $min = "", $max = "", $middle_min = 1, $middle_max = 25){

		$pattern_name = "";
		$name = trim($val);

		if($full === FALSE){

			if((is_int($min)) && (is_int($max)) && ($min < $max)){

				$pattern_name = "^[a-z][a-z0-9\_\-\.]{" . ($min - 1) . "," . ($max - 1) . "}$";
			} else{

				$pattern_name = "^[a-z][a-z0-9\_\-\.]*$";
			}
		} else if($full === TRUE){

			$temp = explode(" ", $name);

			if((is_int($min)) && (is_int($max)) && ($min < $max)){

				if((strlen($name) < $min) || (strlen($name) > $max)){

					return(FALSE);
				}
			}

			if(count($temp) === 2){

				$name = $temp[0] . " " . $temp[1];
				$pattern_name = '^([a-z]{1}[a-z0-9\_\-\.]*[[:space:]][a-z]{1}[a-z0-9\_\-\.]*)$';

			} else if(count($temp) === 3){

				$name = $temp[0] . " " . $temp[1] . " " . $temp[2];
				$pattern_name = '^([a-z]{1}[a-z0-9\_\-\\.]*[[:space:]][a-z\\.][a-z0-9\_\-\.]*[[:space:]][a-z][a-z0-9\_\-\.]*)$';
			} else{

				return(FALSE);
			}
		}

		if((!empty($pattern_name)) && (eregi($pattern_name, $name))){

			return(TRUE);
		}

		return(FALSE);
	}

	/**
	 *  Description: Login Name Validation function.
	 *  Date & Time: 24th-01-2009 & 12:30
	 *  @access public
	 *  @return bool
	 */
	function validateLoginName($val, $min = 0, $max = 0){

		if(($min >= 0) && ($max > 0) && ($min < $max)){

			if((strlen($val) < $min) || (strlen($val) > $max)){

				return(FALSE);
			}
		}

		$login_name_pattern = "^[a-z0-9\_]+$";

		if(eregi($login_name_pattern, $val)){

			return(TRUE);
		} else{

			return(FALSE);
		}
	}

	/**
	 *  Description: State characters Validation function.
	 *  Date & Time: 24th-01-2009 & 12:40
	 *  @access public
	 *  @return bool
	 */
	function validateState($val, $min = 0, $max = 0){

		if(($min >= 0) && ($max > 0) && ($min < $max)){

			if((strlen($val) < $min) || (strlen($val) > $max)){

				return(FALSE);
			}
		}

		$state = "^[a-z][a-z[[:space:]]]+[a-z]$";

		if(eregi($state, $val)){

			return(TRUE);
		} else{

			return(FALSE);
		}
	}

	/**
	 *  Description: Amount Validation.
	 *  Date & Time: 27th-01-2009 & 17:26
	 *  @access public
	 *  @return bool
	 */
	function validateAmount($value, $integer = 3, $decimal = 2){

		$amount_pattern = "^[0-9][0-9]{0," . ($integer - 1) . "}(([0-9]{0," . ($decimal + 1) . "}$)|(\\.[0-9]{0," . $decimal . "}$))";

		if(eregi($amount_pattern, $value)){

			return(TRUE);
		} else{

			return(FALSE);
		}
	}

	/**
	 *  Description: Google Merchant Id Validation. This function checks whether the specified value is
	 *  of the required syntax, it contains the required characters or not.
	 *  Date & Time: 29th-01-2009 & 11:51
	 *  @access public
	 *  @return bool
	 */
	function validateGoogleMerchantId($value, $min = 3, $max = 15){

		$id_pattern = "^[0-9][0-9]{" . $min . "," . $max . "}$";

		if(eregi($id_pattern, $value)){

			return(TRUE);
		} else{

			return(FALSE);
		}
	}

	/**
	 *  Description: Amount Validation. This function checks whether the specified value is
	 *  of the required syntax, it contains the required characters or not.
	 *  Date & Time: 27th-01-2009 & 17:26
	 *  @access public
	 *  @return bool
	 */
	function validateGoogleMerchantKey($value, $min = 3, $max = 20){

		$amount_pattern = '^[a-z0-9][a-z0-9\-\_]{' . $min . ',' . $max . '}$';

		if(eregi($amount_pattern, $value)){

			return(TRUE);
		} else{

			return(FALSE);
		}
	}
}
?>