<?php require 'connection.php'; ?>
<?php

if(isset($_POST['Register'])) {
    session_start();
    $Name = $_POST['name'];
    $Email = $_POST['email'];
    $Username = $_POST['username'];
    $Bio=$_POST['bio'];
    $TypeOfUser=$_POST['type'];
    $file_path = "../images/users/";
    $file_path = $file_path . basename( $_FILES['uploaded_file']['name']);
    /*echo $file_path;*/
    $PW = $_POST['password'];
    $StorePassword = password_hash($PW, PASSWORD_BCRYPT, array('cost'=>10));
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
        mysqli_query($link, "INSERT INTO users(`fullname`, `username`, `email`, `password`, `bio`, `type_of_user`, `image_path`) VALUES ('{$Name}', '{$Username}','{$Email}','{$StorePassword}','{$Bio}','{$TypeOfUser}','{$file_path}')") or die(mysqli_error($link));
        $result = $link->query("SELECT * FROM users WHERE username='$Username'");
        $row = $result->fetch_array(MYSQLI_BOTH);
        $_SESSION["UserID"] = $row['userID'];
        if($TypeOfUser=='salon')
            header('Location: salondetails.php');
        else
            header('Location: login.php');
    }
    else echo 'failed';

}
?>
<?php include("header.php"); ?>
<div class="wrap">
    <div class="row">
        <div class="col-md-3">
            <img src="../images/objects_one.png" style="width: 100%; height: 100%;"/>
        </div>
        <div class="col-md-6">
        <form action="" name="RegisterForm" method="post" enctype="multipart/form-data">
            <br>
            <input type="text" class="form-control" required="required" id="name" name="name" placeholder="Name"/>
            <input type="text" class="form-control" required="required" id="username" name="username" placeholder="Username"/>
            <input type="text" class="form-control" required="true" id="email" name="email" placeholder="Email"/>
            <input type="password" class="form-control" required="true" id="password" name="password" placeholder="Password"/>
            <textarea class="form-control" rows="5" id="bio" name="bio" placeholder="Your Bio"></textarea>
            <div class="center">
            <div class="fileUpload btn btn-info btn-upload">
                <span>Upload Image</span>
                <input type="file" class="upload" name="uploaded_file" />
            </div>
                <br>
                Type:<br/><input type="radio" required="true" id="type" name="type" value="customer"/>Customer<input type="radio" required="true" id="type" name="type" value="salon"/>Salon<br/><br/>
            </div>
            <input type="submit" class="btn btn-info btn-coloured btn-lg" value="Join The Club" id="Register" name="Register"/>
        </form>
        </div>
        <div class="col-md-3">
            <img src="../images/objects_two.png" style="width: 100%; height: 100%;"/>
        </div>
    </div>
</div>
<?php include("footer.php"); ?>