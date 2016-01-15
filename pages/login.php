<?php require 'connection.php'; ?>
<?php
if(isset($_POST['Login'])) {
    $Username = $_POST['username'];
    $PW = $_POST['password'];

    $result = $link->query("SELECT * FROM users WHERE username='$Username'");
    $row = $result->fetch_array(MYSQLI_BOTH);
    //echo $row['Password'];
    if (password_verify($PW, $row['password'])) {
        session_start();
        $_SESSION["UserID"] = $row['userID'];
        $_SESSION["UserName"] = $row['fullname'];
        $_SESSION["TypeOfUser"]=$row["type_of_user"];
        $sql = $link->query("UPDATE loginbool SET loginstate=1") or die(mysqli_error($link));
        if($_SESSION["TypeOfUser"]=="customer")
            header('Location: customer.php');
        else
            header('Location: salon.php');
    }else{
        session_start();
        $_SESSION["LogInFail"]="Yes";
    }
}
?>
<?php include("header.php"); ?>
<div class="wrap">
    <?php
    if(isset($_SESSION["LogInFail"])){
        echo '<h3>Please try again</h3>';
    }
    ?>
    <div class="row">
        <div class="col-md-6 center">
            <img src="../images/table.png" style="width: 100%; height: 100%;"/>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-3 center" style="padding-top: 15%;">
        <form name="LoginForm" method="post">
            <input type="text" class="form-control" required="required" id="username" name="username" placeholder="Username"/><br/>
            <input type="password" class="form-control" required="true" id="password" name="password" placeholder="Password"/><br/>
            <input type="submit" class="btn btn-info btn-lg btn-coloured" value="Login" id="Login" name="Login"/>
        </form>
            <br><br>
            <span style="font-size: x-small; margin-right: 10px;">Don't have an account? </span><a href="register.php" class="btn btn-info">Sign Up</a>
        </div>
    </div>
</div>
<?php include("footer.php"); ?>