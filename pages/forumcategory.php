<?php require 'connection.php'; ?>
<?php
$id=$_GET['id'];
?>
<?php include("header.php"); ?>

<div class="wrap">
    <div class="row">
        <div id="left-forum" class="col-md-9">
            <br/>
            <h4 class="text-uppercase">Forum</h4>
            <div class="border-top">
                <div class="row forum-container bold-text">
                    <div class="col-md-8">Topic</div>
                    <div class="col-md-1">Views</div>
                    <div class="col-md-1">Reply</div>
                    <div class="col-md-2">Posted On</div>
                </div>
                <?php
                $result = $link->query("SELECT LEFT(question, 70) AS excerpt, questionID, questiontime, views FROM `forumquestion`  WHERE topicID='$id' ORDER BY `views` DESC ");
                while($row = $result->fetch_array(MYSQLI_BOTH)){
                    $QuestionID=$row['questionID'];
                    $Date_input=$row['questiontime'];
                    $Date= date('m/d/Y', strtotime($Date_input));
                    $sql = $link->query("SELECT COUNT(questionID) FROM `forumanswer` WHERE questionID='$QuestionID'");
                    $sqlrow = $sql->fetch_array(MYSQLI_BOTH);
                    ?>
                    <div class="row forum-container">
                        <div class="col-md-8 bold-text"><a href="viewtopic.php?id=<?php echo $QuestionID;?>"><?php echo $row['excerpt'];?>...</a></div>
                        <div class="col-md-1"><?php echo $row['views'];?></div>
                        <div class="col-md-1"> <?php echo $sqlrow['COUNT(questionID)'];?></div>
                        <div class="col-md-2"><?php echo $Date;?></div>
                    </div>
                <?php }?>
            </div>
            <br/><br/>
            <a href="createtopic.php" class="btn btn-info btn-lg">Create new topic</a>
        </div>
        <div id="right-forum" class="col-md-3">
            <h5 class="bold-text">Categories</h5>
            <?php
            $result = $link->query("SELECT * FROM `forum`");
            while($row = $result->fetch_array(MYSQLI_BOTH)){?>
                <div><a href="forumcategory.php?id=<?php echo $row['forumID'];?>"><img src="<?php echo $row['forum_icons'];?>" class="blog-icons"/><?php echo $row['forum_name'];?></a></div>
            <?php } ?>
        </div>

    </div>
</div>

</body>
</html>

