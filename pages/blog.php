<?php require 'connection.php'; ?>
<?php include("header.php"); ?>

    <div class="wrap">
        <br>
        <div class="col-md-2"></div>
        <!--post preview starts-->
        <div class='col-md-7 post-preview'>
                <?php
                    $stmt = $link->query('SELECT postID, postTitle, postDesc, postDate, post_imagepath FROM blog_posts ORDER BY postID DESC');
                    while($row = $stmt->fetch_array(MYSQLI_BOTH)){ ?>
            <div class="col-md-9 blogpost">
                <a href="viewpost.php?id=<?php echo $row['postID']?>" ><h3><?php echo $row['postTitle']?></h3></a>
                <h5><small><?php echo date('jS M Y H:i:s', strtotime($row['postDate']));?></small></h5>
                <p><small><?php echo $row['postDesc']?></small>
                </p>
                <div class="thumbnail">
                    <img src="<?php echo $row['post_imagepath']?>" alt="...">
                </div>
                <div class="center">
                    <a href="viewpost.php?id=<?php echo $row['postID']?>" class="blogbutton" role="button">Read More</a>
                </div>
                <br>
            </div><?php } ?>
        </div>
        <!--sidebar starts-->
        <div class="col-md-3">
            <ul class='blog-sidebar'>
                <li>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=http://localhost/FabTabLoginSystem/pages/blog.php" target="_blank"><img src="../images/facebook.png" class="blogsocial"/></a>
                    <a href="https://twitter.com/share?url=http://localhost/FabTabLoginSystem/pages/blog.php" target="_blank"><img src="../images/twitter.png" class="blogsocial"/></a>
                </li>
                <h5> Categories </h5>
                <?php
                $sql = $link->query("SELECT * FROM `blog_cats`");
                while($rowcats = $sql->fetch_array(MYSQLI_BOTH)){
                    ?>
                    <li><a href="viewcategory.php?id=<?php echo $rowcats['catID'];?>"><img src="<?php echo $rowcats['catIcon'];?>" class="blog-icons"/> <?php echo $rowcats['catTitle'];?></li>
                <?php }?>
                <br>
                <a href="addpost.php" class="btn btn-info btn-lg" id="btn-fix">Add Post</a>
                <h5> Recent Posts </h5>
                <?php
                $query = $link->query('SELECT postID, postTitle, postDate FROM blog_posts ORDER BY postDate DESC');
                for($n=0;$n<3;$n++){
                    $rowquery = $query->fetch_array(MYSQLI_BOTH); ?>
                    <li><a href="viewpost.php?id=<?php echo $rowquery['postID']?>" ><?php echo $rowquery['postTitle']?></a><br>
                        <span><?php echo date('jS M Y', strtotime($rowquery['postDate']));?></span></li>
                <?php } ?>


            </ul>
        </div> <!--sidebar ends -->
    </div>

<a href="#top" id="top-icon"><img src="../images/goup.png"/></a>