<?php require 'connection.php'; ?>
<?php
session_start();
if(!isset($_SESSION["UserID"])){
    echo 'Please login to post';
}
if(isset($_POST['submit']) && isset($_SESSION["UserID"])) {
    extract($_POST);
    //very basic validation
    if($postTitle ==''){
        $error[] = 'Please enter the title.';
    }
    if($postCont ==''){
        $error[] = 'Please enter the content.';
    }
    $AuthorID = $_SESSION["UserID"];
    $CatID=$_POST["category"];
    $Title=$_POST['postTitle'];
    $Desc=$_POST['postDesc'];
    $Content=$_POST['postCont'];
    $file_path = "../images/blog/";
    $file_path = $file_path . basename( $_FILES['uploaded_file']['name']);
    echo $file_path;
    $Content = str_replace("'", "", $Content);

    /*inserting*/
/*if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path))*/
    mysqli_query($link,"INSERT INTO blog_posts (postTitle,postDesc,postCont,catID,authorID) VALUES ('{$Title}','{$Desc}','{$Content}','{$CatID}','{$AuthorID}')") or die(mysqli_error($link));

    /*directing to login page*/
    header('Location: blog.php');
}
?>
<?php include("header.php"); ?>
<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: ".editor",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });
</script>

<div class="wrap">
    <form method='post'>
        <input type='text' class="form-control" name='postTitle' placeholder="Title" value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'><br>
        <input type='text' class="form-control" name='postDesc' placeholder="Description" value='<?php if(isset($error)){ echo $_POST['postDesc'];}?>'><br>
        <select class="form-control"  name="category">
            <option>Category</option>
            <?php
            $result = $link->query("SELECT * FROM `blog_cats`");
            while($row = $result->fetch_array(MYSQLI_BOTH)){?>
                <option value="<?php echo $row['catID'];?>"><?php echo $row['catTitle'];?></option>
            <?php }?>
        </select>
        <label>Content</label><br />
        <textarea name='postCont' cols='60' rows='10' class="editor"><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea>
        <!--<br>
        <div class="fileUpload btn btn-info btn-upload">
            <span>Upload Main Image</span>
            <input type="file" class="upload" name="uploaded_file" />
        </div>-->
        <br><br>
        <input type='submit' class="btn btn-info btn-lg btn-coloured" name='submit' value='Submit'>
    </form>
</div>

</body>
</html>

