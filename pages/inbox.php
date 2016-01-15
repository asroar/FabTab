<?php require 'connection.php'; ?>
<?php
session_start();
if(isset($_SESSION["UserID"])){
    $UserID = $_SESSION["UserID"];
}
else{
    header('Location: login.php');
}
?>
<?php include("header.php"); ?>

    <div class="wrap">
        <div class="row">
              <?php
              $result = $link->query("SELECT * FROM inbox WHERE receiverID='$UserID'");
                while($row = $result->fetch_array(MYSQLI_BOTH)){
                    $Message = $row["message"];
                    $SenderID = $row['senderID'];
                    $sql = $link->query("SELECT * FROM users WHERE userID='$SenderID'");
                    $sqlrow = $sql->fetch_array(MYSQLI_BOTH)
              ?>
                        <div class="col-md-6 msg-container center">
                            <h2>&quot;</h2>
                            <p><?php echo $Message;?></p>
                            <h5>From: <a href="<?php
                                if($sqlrow["type_of_user"]=="customer")
                                    echo 'viewcustomer.php?id='.$SenderID;
                                else
                                    echo 'viewsalon.php?id='.$SenderID;?>" target="_blank"><?php echo $row['senderName']; ?></a></h5>
                            <br><a href="reply.php?id=<?php echo $row['senderID'];?>" class="btn white-btn-info">Reply</a>
                        </div>
                    <?php } ?>
        </div>
    </div>
