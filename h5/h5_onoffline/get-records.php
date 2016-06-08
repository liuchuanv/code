<?php
// Set default timezone 
date_default_timezone_set('UTC'); 

$db = new mysqli('localhost', 'root', 'root', 'test');
$db->query("set names utf8");
$userList = null;
  
// Select all data from file db messages table
$result = $db->query('SELECT * FROM h5_user');

while ($row= $result->fetch_object()) {
    $userList['records'][] = $row;
}
$db->close();
print json_encode($userList);