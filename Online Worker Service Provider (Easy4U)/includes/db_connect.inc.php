<?php

$dbServerName = "localhost";
$dbUserName = "root";
$dbPassword = "";
$dbName = "easyforyou";

$conn = mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName);
if(mysqli_connect_errno()){
	echo "Error: ".mysqli_connect_err();
}
?>