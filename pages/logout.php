<?php require 'connection.php'; ?>
<?php
session_start();
unset($_SESSION["UserID"]);
session_destroy();
$sql = $link->query("UPDATE loginbool SET loginstate=0") or die(mysqli_error($link));
header('Location: index.php');
?>