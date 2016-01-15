<?php
require 'connection.php';
$loginsql = $link->query("SELECT * FROM loginbool");
$loginrow = $loginsql->fetch_array(MYSQLI_BOTH);
$state = $loginrow["loginstate"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>FabTab</title>
    <meta name="description" content="FabTab is the project of SE-303 and SE-018.">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="../js/jquery-2.1.4.js" type="text/javascript"></script>
    <script src="../js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="../js/typed.js" type="text/javascript"></script>
    <script src="../js/owl.carousel.js" type="text/javascript"></script>
    <script src="../js/script.js" type="text/javascript"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script> <!-- 16 KB -->
    <script src="http://maps.googleapis.com/maps/api/js"></script>
</head>

<link rel="stylesheet" href="../css/bootstrap.css" type="text/css"/>
<link rel="stylesheet" href="../css/owl.carousel.css" type="text/css"/>
<link rel="stylesheet" href="../css/style.css" type="text/css"/>
<!--<link rel="stylesheet" href="../css/newstyle.css" type="text/css"/>-->


<body>
<!--Navigation!-->
<div id="site-head">
    <div id="logo">
        <a href="index.php"><img src="../images/logo.png" alt="Logo"></a>
    </div>
    <div id="search">
        <form class="navbar-form navbar-left" method="get" action="search.php" ">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search" name="keyword">
            </div>
            <button type="submit" class="btn btn-default" name="Search"></button>
        </form>
    </div>
</div>
<nav id="menu">
    <a href="#" class="menu-link" ></a>
    <ul>
        <br/><br/><br/>
        <li><a href="index.php"><img class="nav-icon" src="../images/home.png"/> Home</a></li>
        <?php if($state==0) { ?>
        <li><a href="login.php"><img class="nav-icon" src="../images/login.png"/>Sign In</a></li>
        <li><a href="register.php"><img class="nav-icon" src="../images/square_add.png"/>Sign Up</a></li>
        <?php } ?>
        <li><a href="search.php"><img class="nav-icon" src="../images/magnifying_glass.png"/>Search</a></li>
        <li><a href="events.php"><img class="nav-icon" src="../images/tags.png"/>Events</a></li>
        <li><a href="blog.php"><img class="nav-icon" src="../images/blog.png"/>Blog</a></li>
        <li><a href="forum.php"><img class="nav-icon" src="../images/speech_3.png"/>Forum</a></li>
        <br/><br/><br/>
        <li><a href="about.php" class="small text-capitalize"><img class="nav-icon" src="../images/aboutt.png"/>About</a></li>
        <li><a href="contact.php" class="small text-capitalize"><img class="nav-icon" src="../images/bell.png"/>Contact</a></li>
        <?php if($state==1) { ?>
        <li><a href="profile.php" class="small text-capitalize"><img class="nav-icon" src="../images/user.png"/>Profile</a></li>
        <li><a href="logout.php" class="small text-capitalize"><img class="nav-icon" src="../images/logout2.png"/>Log Out</a></li>
        <?php } ?>
    </ul>
</nav>


