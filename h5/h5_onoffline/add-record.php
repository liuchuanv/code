<?php 
// Set default timezone 
date_default_timezone_set('UTC'); 

$db = new mysqli('localhost', 'root', 'root', 'test');
$db->query("set names utf8");

$userList = null;
  
// Select all data from file db messages table
$result = $db->query('SELECT * FROM h5_user');
  
if (!empty($_POST['uname']) && !empty($_POST['email'])) {
    $sql = "INSERT INTO h5_user (uname, email) VALUES (?,?)";
    $stmt = $db->prepare($sql);
	$stmt->bind_param('ss', $_POST['uname'],$_POST['email']);
    $stmt->execute();
	$stmt -> close ();

}
$db->close();