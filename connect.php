<?php
$currency = 'RON'; //Currency Character or code

//MySql 
$db_username 	= 'root';
$db_password 	= '';
$db_name 		= 'shop';
$db_host 		= 'localhost';



//connection to MySql						
$mysqli = new mysqli($db_host, $db_username, $db_password,$db_name);						
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
?>
