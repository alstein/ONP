<?php

/**
 * Credit Card Validation Solution, PHP Edition,
 * Usage Example.
 *
 * @package    CreditCardValidationSolution
 * @author     Daniel Convissor <danielc@analysisandsolutions.com>
 * @copyright  The Analysis and Solutions Company, 2002-2006
 * @version    $Name: rel-5-14 $ $Id: ccvs_example.php,v 1.16 2006/03/18 17:31:31 danielc Exp $
 * @link       http://www.analysisandsolutions.com/software/ccvs/ccvs.htm
 */

/**
 * Require the main file.
 */
require './ccvs.inc';
$Form = new CreditCardValidationSolution;

?>
<html>
 <head>
  <title>Credit Card Validation Solution:&trade; PHP Edition Test</title>
 </head>
 <body>
<?php

if (empty($_POST['Number'])) {
    $Form->CCVSNumber = '4002417016240182';
    $Month = '';
    $Year  = '';
} else {
    /*
     * Put the names of the card types you accept in here.
     * To handle all card types, skip this step and put ''
     * in the Accepted argument.
     */
    $Accepted = array('Visa', 'JCB');

    $Month = $_POST['Month'];
    $Year  = $_POST['Year'];

    if ( !$Form->validateCreditCard($_POST['Number'], 'en',
                                    $Accepted, 'Y', $Month, $Year) ) {
        echo "  <p>PROBLEM: $Form->CCVSError</p>";
    } else {
        echo "  <p>That $Form->CCVSType number seems good";
        echo "  and expires in $Form->CCVSExpiration.";
        echo "  <br />The left digits are $Form->CCVSNumberLeft";
        echo "  and the right digits are $Form->CCVSNumberRight.</p>";
    }
}

?>

  <form method="post">
   Number: <input type="text" name="Number" size="21" maxlen="21"
       value="<?php echo $Form->CCVSNumber; ?>" />
   Month: <input type="text" name="Month" size="2" maxlength="2"
       value="<?php echo $Month; ?>" />
   Year: <input type="text" name="Year" size="4" maxlength="4"
       value="<?php echo $Year; ?>" />
   <input type="submit" name="Submit" value="Test" />
  </form>
 </body>
</html>
