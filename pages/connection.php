<?php
/**
 * Created by PhpStorm.
 * User: Nashwa
 * Date: 8/6/2015
 * Time: 4:10 PM
*/
/*$host = "localhost"; // Host name
$username = "root"; // Mysql username
$password = ""; // Mysql password
$db_name = "fabtab"; // Database name

$link = mysqli_connect($host, $username, $password, $db_name);*/
$link = mysqli_connect("localhost","root","","fabtab");
if (!$link) {
    die('Could not connect to MySQL: ' . mysqli_error($link));
}
/*echo 'Connection OK';*/
?>