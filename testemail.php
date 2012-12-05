<?php
// The message
$message = "Line 1\nLine 2\nLine 3";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70);

// Send
mail('varunume@yahoo.com', 'My Subject', $message);
//mail('testing2012.testing2012@gmail.com', 'My Subject', $message);
?>
