<?php require 'connection.php'; ?>
<?php
$id=$_GET['id'];
/*getting question*/
$result = $link->query("SELECT * FROM `forumquestion` WHERE questionID='$id'");
$row = $result->fetch_array(MYSQLI_BOTH);
$Question = $row['question'];
$TopicID = $row['topicID'];
$Views = $row['views'];
$Views++;
mysqli_query($link,"UPDATE forumquestion SET `views`='{$Views}' WHERE questionID='$id'") or die(mysqli_error($link));
/*getting category*/
$result = $link->query("SELECT * FROM `forum` WHERE forumID='$TopicID'");
$row = $result->fetch_array(MYSQLI_BOTH);
$Category=$row['forum_name'];
session_start();
if(isset($_POST['Answer']) && isset($_SESSION["UserID"])) {
    $UserID = $_SESSION["UserID"];
    $Answer=$_POST['answer'];

    /*inserting new question*/
    mysqli_query($link,"INSERT INTO `forumanswer`(`questionID`, `authorID`, `answer`) VALUES ('{$id}','{$UserID}','{$Answer}')") or die(mysqli_error($link));

}
if(!isset($_SESSION["UserID"])){
    echo 'Please login to post answer';
}
?>
<?php include("header.php"); ?>

<div class="wrap">
    <div class="row">
        <div class="col-md-10 question-box">
        <p class="special-text"><span class="large-letter">Q.</span><?php echo $Question;?></p><br/>
        Category: <?php echo $Category;?>
        </div>
        <div class="right col-md-2">
            <a href="forum.php"><img src="../images/left.png" style="width: 20px; height: 20px;"/> Back to forum</a>
        </div>
    </div>

    <?php
    $result = $link->query("SELECT * FROM `forumanswer` WHERE questionID='$id'");
    while($row = $result->fetch_array(MYSQLI_BOTH)){
        $authorID=$row['authorID'];
        $sql = $link->query("SELECT `fullname` FROM `users` WHERE userID='$authorID'");
        $sqlrow = $sql->fetch_array(MYSQLI_BOTH);
        $Author=$sqlrow['fullname'];
        ?>
    <div class="row answer-box">
        <p class="normal-text"><?php echo $row['answer'];?></p><br/>
        By: <a href="viewcustomer.php?id=<?php echo $authorID;?>"><?php echo $Author;?></a>
    </div>
    <?php }?>

    <form action="" name="SalonForm" method="post">
        <div class="row answer-box">
            <div class="col-md-8">
                <textarea rows="10" cols="80" name="answer">Your Answer</textarea><br/>
            </div>
            <div class="col-md-4 right" style="padding: 5% 0;">
                <input type="submit" class="btn btn-info btn-lg" value="Submit Answer" id="Answer" name="Answer"/><br/><br/>
            </div>
        </div>
    </form>
</div>

</body>
</html>
