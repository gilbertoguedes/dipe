<?php

define("DB_HOST", 		'localhost');				
define("DB_USER", 		'root');		
define("DB_PASSWORD",	'');		
define("DB_NAME",		'dipepsa');

$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql = "SELECT * FROM payment_gateway WHERE id=1";
$result = $con->query($sql);


/**
 *  ARRAY OF ALL YOUR CRYPTOBOX PRIVATE KEYS
 *  Place values from your gourl.io signup page
 *  array("your_privatekey_for_box1", "your_privatekey_for_box2 (otional), etc...");
 */

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$cryptobox_private_keys = array($row['private_key']);

    }
} else {
    echo "0 results";

}

define("CRYPTOBOX_PRIVATE_KEYS", implode("^", $cryptobox_private_keys));
unset($cryptobox_private_keys); 

?>