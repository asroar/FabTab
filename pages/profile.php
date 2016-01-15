<?php
require 'connection.php';
session_start();
if(isset($_SESSION["UserID"])){
    $UserID = $_SESSION["UserID"];
    $result = $link->query("SELECT * FROM users WHERE userID='$UserID'");
    $row = $result->fetch_array(MYSQLI_BOTH);
    $_SESSION["TypeOfUser"]=$row["type_of_user"];
    if($_SESSION["TypeOfUser"]=="customer")
        header('Location: customer.php');
    else
        header('Location: salon.php');
}
else{
    header('Location: login.php');
}
?>