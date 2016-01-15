<?php require 'connection.php'; ?>
<?php
session_start();
if(isset($_SESSION["UserID"])){
    $UserID = $_SESSION["UserID"];
    $result = $link->query("SELECT * FROM users WHERE userID='$UserID'");
    $row = $result->fetch_array(MYSQLI_BOTH);
    $Name = $row["fullname"];
    /*$n=0;
    $result = $link->query("SELECT * FROM `favourites` where `userID`='$UserID'");
    while($row = $result->fetch_array(MYSQLI_BOTH)){
        $FID[$n] = $row['favID'];
        $n++;
    }*/
}
else{
    header('Location: login.php');
}
?>
<?php include("header.php"); ?>

<div class="wrap">
    <div class="row" id="profile">
        <div class="col-md-6 center" id="left-profile">
            <img src="<?php echo $row["image_path"]?>" class="img-circle profile-picture"/><br>
            <h3><?php echo $Name; ?></h3><br>
            <div class="row profile-links-container">
                <div class="col-md-4 profile"><a href="updatecustomer.php" class="profile-links"><img src="../images/write.png"/><br/>Edit Profile</a></div>
                <div class="col-md-4 profile"><a href="inbox.php" class="profile-links"><img src="../images/mail.png"/><br/>Inbox</a></div>
                <div class="col-md-4 profile"><a href="logout.php" class="profile-links"><img src="../images/logout.png"/><br/>Logout</a></div>
            </div>
        </div>
        <div class="col-md-6" id="right-profile">
            <div class="row center">
                <h4>Favourites</h4>
                <div class="owl-carousel">
                    <?php
                    if(isset($_SESSION["UserID"])){
                    $UserID = $_SESSION["UserID"];
                    $result = $link->query("SELECT DISTINCT favID FROM `favourites` where `userID`='$UserID'");
                    while($row = $result->fetch_array(MYSQLI_BOTH)){
                        $FavID = $row['favID'];
                        $sql = $link->query("SELECT fullname, image_path FROM users WHERE userID='$FavID'");
                        $sqlrow = $sql->fetch_array(MYSQLI_BOTH);
                        $FavName = $sqlrow["fullname"];
                        ?>
                        <div class="item"><a href="<?php echo 'viewcustomer.php?id='.$FavID;?>"><img src="<?php echo $sqlrow["image_path"]?>" class="favourite-image"/><?php echo $FavName;?></a></div>
                    <?php } }?>
                </div>
            </div>


            <div class="row center">
                <br><h4>Wall Posts</h4>
                <table class="table">
                    <?php
                        $UserID = $_SESSION["UserID"];
                        $result = $link->query("SELECT * FROM `messages` where `receiverID`='$UserID'");
                        while($row = $result->fetch_array(MYSQLI_BOTH)){
                    ?>
                    <tr class="recent-posts">
                        <td><h5><?php echo $row['message']; ?>
                                <small>- <a href="viewcustomer.php?id=<?php echo $row['senderID'];?>"><?php echo $row['senderName']; ?></a></small>
                            </h5></td>
                    </tr>
                        <?php }  ?>
                </table>
            </div>

        </div>
    </div>
</div>

<?php include("footer.php"); ?>