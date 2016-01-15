<?php require 'connection.php'; ?>
<?php
session_start();
$To=$_GET['id'];
$result = $link->query("SELECT fullname FROM users WHERE userID='$To'");
$row = $result->fetch_array(MYSQLI_BOTH);
$ToName = $row["fullname"];
if(isset($_POST["Reply"])) {
    if(isset($_SESSION["UserID"])) {
        $senderID = $_SESSION["UserID"];
        $receiverID = $To;
        $message = $_POST["message"];
        $message = str_replace("'", "", $message);
        $senderName = $_SESSION['UserName'];
        mysqli_query($link, "INSERT INTO `inbox`(`senderID`, `receiverID`, `message`, `senderName`) VALUES ('{$senderID}','{$receiverID}','{$message}', '{$senderName}')") or die(mysqli_error($link));
        header('Location: inbox.php');
    }
    else echo 'Please login to send message';
}
?>
<?php include("header.php"); ?>

<div class="wrap">
    <br>
    <div class="row center">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form method ="post">
        <input class="form-control disabled" placeholder="To: <?php echo $ToName;?>"/>
        Your Message:
        <textarea class="form-control" rows="10" cols="30" type="text" name="message"></textarea><br>
            <br/><br/>
            <div class="col-md-3"></div>
            <div class="col-md-3 center">
                <input type="submit" class="btn btn-info btn-lg btn-coloured" value="Reply" id="Reply" name="Reply"/>
            </div>
            <div class="col-md-3 center">
            <input type="reset" class="btn btn-info btn-lg" value="Reset" name="Reset"/>
                </div>
        </form>
        </div>
    </div>
    <div class="col-md-2"></div>
    </div>
</div>
