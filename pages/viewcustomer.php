<?php require 'connection.php'; ?>
<?php
session_start();
$_SESSION["ViewID"]=$_GET['id'];
$ViewID=$_GET['id'];
$LoginUserID = 0;

if($ViewID==$_SESSION["UserID"]){
    header('Location: customer.php');
}

if(isset($_SESSION["ViewID"])){
    $UserID = $ViewID;
    $result = $link->query("SELECT * FROM users WHERE userID='$UserID'");
    $row = $result->fetch_array(MYSQLI_BOTH);
    $Name = $row["fullname"];
    $Image =$row["image_path"];
    $favourite="no";
    if(isset($_SESSION["UserID"])) {
        $LoginUserID = $_SESSION["UserID"];
        $result = $link->query("SELECT DISTINCT favID FROM `favourites` WHERE userID='$LoginUserID'");
        while($row = $result->fetch_array(MYSQLI_BOTH)){
            if($ViewID==$row['favID'])
                $favourite="yes";
        }
    }
}
else{
    header('Location: search.php');
}
if(isset($_POST["wallpost"])){
    if(isset($_SESSION["UserID"])) {
        $message = $_POST['postmessage'];
        $senderID = $_SESSION["UserID"];
        $receiverID = $ViewID;
        $senderName = $_SESSION['UserName'];
        $message = str_replace("'", "", $message);
        mysqli_query($link, "INSERT INTO `messages`(`senderID`, `receiverID`, `message`, `senderName`) VALUES ('{$senderID}','{$receiverID}','{$message}', '{$senderName}')") or die(mysqli_error($link));
    }
    else echo 'Please login to post';
}
?>
<?php include("header.php"); ?>

    <div class="wrap">
        <div class="row" id="profile">
            <div class="col-md-6 center" id="left-profile">
                <img src="<?php echo $Image;?>" class="img-circle profile-picture"/><br>
                <h3><?php echo $Name; ?></h3><br>

                <div class="row profile-links-container">
                    <div class="col-md-6 profile">
                        <?php if($favourite=="no") {?>
                        <a href="<?php
                        if(isset($_SESSION["UserID"])) {
                            $LoginUserID = $_SESSION["UserID"];
                            $result = $link->query("INSERT INTO `favourites`(`userID`, `favID`) VALUES ('{$LoginUserID}','{$ViewID}')");
                        } ?>" class="profile-links"><img src="../images/user_add.png"/><br/>Add to Circles</a>
                        <?php } else if($favourite=="yes"){ ?>
                            <a href="#" class="profile-links"><img src="../images/star.png"/><br/>In Favourite List</a>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 profile">
                        <a href="reply.php?id=<?php echo $ViewID;?>" class="profile-links"><img src="../images/mail.png"/><br/>Message</a></div>
                </div>
            </div>
            <div class="col-md-6" id="right-profile">
                <div class="row center">
                    <h4>Favourites</h4>
                    <div class="owl-carousel">
                        <?php
                            $result = $link->query("SELECT DISTINCT favID FROM `favourites` where `userID`='$ViewID'");
                            while($row = $result->fetch_array(MYSQLI_BOTH)){
                                $FavID = $row['favID'];
                                $sql = $link->query("SELECT fullname, image_path FROM users WHERE userID='$FavID'");
                                $sqlrow = $sql->fetch_array(MYSQLI_BOTH);
                                $FavName = $sqlrow["fullname"];
                                $Image = $sqlrow["image_path"];
                                ?>
                                <div class="item"><a href="<?php echo 'viewcustomer.php?id='.$FavID;?>"><img src="<?php echo $Image;?>" class="favourite-image"/><?php echo $FavName;?></a></div>
                            <?php }?>
                       <!-- <div class="item"><img src="../images/2.jpg"/>Alice</div>
                        <div class="item"><img src="../images/1.jpg"/>Mary</div>
                        <div class="item"><img src="../images/2.jpg"/>Alice</div>
                        <div class="item"><img src="../images/1.jpg"/>Mary</div>
                        <div class="item"><img src="../images/2.jpg"/>Alice</div>
                        <div class="item"><img src="../images/1.jpg"/>Mary</div>
                        <div class="item"><img src="../images/2.jpg"/>Alice</div>
                        <div class="item"><img src="../images/1.jpg"/>Mary</div>-->
                    </div>
                </div>

                <div class="row" id="wall-post">
                    <form name="PostForm" method="POST">
                        <textarea class="form-control" rows="3" name="postmessage" placeholder="Write your message"></textarea><br>
                        <input type="submit" class="btn btn-info" name="wallpost" value="Post"/>
                    </form><br>
                </div>

                <div class="row">
                    <table class="table">
                        <?php
                        $result = $link->query("SELECT * FROM `messages` where `receiverID`='$ViewID'");
                        while($row = $result->fetch_array(MYSQLI_BOTH)){
                            ?>
                            <tr class="recent-posts">
                                <td><h5><?php echo $row['message']; ?><small>- <a href="viewcustomer.php?id=<?php echo $row['senderID'];?>"><?php echo $row['senderName']; ?></a></small></h5></td>
                            </tr>
                        <?php }  ?>
                    </table>
                </div>

            </div>
        </div>
    </div>

<?php include("footer.php"); ?>