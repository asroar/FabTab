<?php require 'connection.php'; ?>
<?php
session_start();
if(isset($_POST['Detail']) && isset($_SESSION["UserID"])) {
    $UserID = $_SESSION["UserID"];
    $Question=$_POST['question'];
    $Question = str_replace("'", "", $Question);
    $Topic=$_POST['topic'];

    /*getting topicID from forum table*/
    $result = $link->query("SELECT forumID FROM `forum` WHERE forum_name='$Topic'");
    $row = $result->fetch_array(MYSQLI_BOTH);
    $TopicID=$row['forumID'];

    /*inserting new question*/
    mysqli_query($link,"INSERT INTO `forumquestion`(`topicID`, `authorID`, `question`) VALUES ('{$TopicID}','{$UserID}','{$Question}')") or die(mysqli_error($link));

    /*directing to login page*/
    header('Location: forum.php');
}
if(!isset($_SESSION["UserID"])){
    echo 'Please login to post';
}
?>
<?php include("header.php"); ?>

<div class="wrap">
    <form action="" name="SalonForm" method="post">

        <div class="row center basicform">
            <br/>
            <h4 class="text-uppercase">Create Topic</h4>
            <div class="col-md-2"></div>
            <div class="col-md-8">
                Your Question:
                <textarea class="form-control" rows="10" cols="30" type="text" name="question"></textarea><br>
                Category:
                    <select class="form-control"  name="topic">
                        <?php
                        $result = $link->query("SELECT * FROM `forum`");
                        while($row = $result->fetch_array(MYSQLI_BOTH)){?>
                            <option value="<?php echo $row['forum_name'];?>"><?php echo $row['forum_name'];?></option>
                        <?php }?>
                    </select>
            </div>
            <div class="col-md-2"></div>
        </div>


        <div class="row center">
            <br/><br/>
            <input type="submit" class="btn btn-info btn-lg btn-coloured" value="Submit Question" id="Detail" name="Detail"/><br/><br/>
            <input type="reset" class="btn btn-info" value="Reset" name="Reset"/>
        </div>
    </form>
</div>

</body>
</html>

<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });
</script>

