<?php require 'connection.php'; ?>
<?php
$PostID=$_GET['id'];
$result = $link->query("SELECT * FROM blog_posts WHERE postID='$PostID'");
$row = $result->fetch_array(MYSQLI_BOTH);
$CategoryID=$row["catID"];
$AuthorID=$row["authorID"];
$result = $link->query("SELECT catTitle FROM blog_cats WHERE catID='$CategoryID'");
$tuple = $result->fetch_array(MYSQLI_BOTH);
$Category = $tuple["catTitle"];
$result = $link->query("SELECT fullname FROM users WHERE userID='$AuthorID'");
$tuple = $result->fetch_array(MYSQLI_BOTH);
$Author = $tuple["fullname"];
?>
<?php include("header.php"); ?>

    <div class="wrap">
        <br>
        <!--sidebar starts-->
        <div class="col-md-2">
            <ul class='blog-sidebar'>
                <li>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=http://localhost/FabTabLoginSystem/pages/viewpost.php?id=<?php echo $PostID; ?>" target="_blank"><img src="../images/facebook.png" class="blogsocial"/></a>
                    <a href="https://twitter.com/share?url=http://localhost/FabTabLoginSystem/pages/viewpost.php?id=<?php echo $PostID; ?>" target="_blank"><img src="../images/twitter.png" class="blogsocial"/></a>
                </li>
                <h5> Recent Posts </h5>
                <?php
                $query = $link->query('SELECT postID, postTitle, postDate FROM blog_posts ORDER BY postDate DESC');
                for($n=0;$n<3;$n++){
                    $rowquery = $query->fetch_array(MYSQLI_BOTH); ?>
                    <li><a href="viewpost.php?id=<?php echo $rowquery['postID']?>" ><?php echo $rowquery['postTitle']?></a><br>
                        <span><?php echo date('jS M Y', strtotime($rowquery['postDate']));?></span></li>
                <?php } ?>
                <br>
                <h5> Categories </h5>
                <?php
                $sql = $link->query("SELECT * FROM `blog_cats`");
                while($rowcats = $sql->fetch_array(MYSQLI_BOTH)){?>
                    <li><a href="viewcategory.php?id=<?php echo $rowcats['catID'];?>"><img src="<?php echo $rowcats['catIcon'];?>" class="blog-icons"/> <?php echo $rowcats['catTitle'];?></li>
                <?php }?>
                <br>
                <a href="addpost.php" class="btn btn-info btn-lg">Add Post</a><br><br>
                <a href="blog.php"><img src="../images/left.png" style="width: 20px; height: 20px;"/>Back to blog</a>
            </ul>
        </div> <!--sidebar ends -->

    <!--blog content starts -->
    <div class='col-md-10 content'>
        <h1><?php echo $row['postTitle'];?></h1>

        <p><?php echo $row['postCont'];?></p>
        <br>
        <h5><?php echo $Author;?></h5>
        <h5><?php echo 'Category: '.$Category;?></h5>
        <p>Posted on <?php echo date('jS M Y', strtotime($row['postDate'])); ?></p>
    </div>
    </div>

<a href="#top" id="top-icon"><img src="../images/goup.png"/></a>