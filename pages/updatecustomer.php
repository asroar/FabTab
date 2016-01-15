<?php require 'connection.php'; ?>
<?php
session_start();
if(!isset($_SESSION["UserID"])){
    header('Location: login.php');
}
$User = $_SESSION["UserID"];
$result = $link->query("SELECT * FROM users WHERE `userID`='$User'");
$row = $result->fetch_array(MYSQLI_BOTH);
$Name = $row["fullname"];
$Email = $row["email"];
$Username = $row["username"];
$Bio=$row["bio"];
$TypeOfUser=$row["type_of_user"];
$StorePassword = $row["password"];

if(isset($_POST['Update'])) {

    $Name = $_POST['name'];
    $Email = $_POST['email'];
    $Username = $_POST['username'];
    $Bio=$_POST['bio'];
    $TypeOfUser=$_POST['type'];
    if(!empty($_POST['password'])){
        $PW = $_POST['password'];
        $StorePassword = password_hash($PW, PASSWORD_BCRYPT, array('cost'=>10));
    }
    $sql = $link->query("UPDATE users SET fullname='{$Name}', username='{$Username}', email='{$Email}', password='{$StorePassword}', bio='{$Bio}', type_of_user='{$TypeOfUser}' WHERE userID=$User") or die(mysqli_error($link));
    echo 'Update Successful!';
    if($_SESSION["TypeOfUser"]=="customer")
        header('Location: customer.php');
    else
        header('Location: salon.php');
    // mysqli_close($link);
}
?>
<?php include("header.php"); ?>

<div class="wrap">
    <form action="" name="UpdateForm" method="post">
        <table class="less-left-margin">
            <tr>
                <td class="input-label">Name</td>
                <td><input type="text" class="form-control" id="name" name="name" value="<?php echo $Name;?>" pattern="[a-z A-Z]+" title="Only alphabets allowed" /></td>
            </tr>
            <tr>
                <td class="input-label">Username</td>
                <td><input type="text" class="form-control" id="username" name="username" value="<?php echo $Username;?>"/></td>
            </tr>
            <tr>
                <td class="input-label">Email</td>
                <td><input type="email" class="form-control" id="email" name="email" value="<?php echo $Email;?>"/></td>
            </tr>
            <tr>
                <td class="input-label">Password</td>
                <td><input type="password" class="form-control" id="password" name="password" placeholder="Password"/></td>
            </tr>
            <tr>
                <td class="input-label">Image</td>
                <td><input type="file" class="form-control" id="image" name="image" value="Upload Image"/></td>
            </tr>
            <tr>
                <td class="input-label">Bio</td>
                <td><textarea rows="5" class="form-control" id="bio" name="bio"><?php echo $Bio;?></textarea></td>
            </tr>
            <tr>
                <td class="input-label">Type</td>
                <td><input type="radio" id="type" name="type" value="customer" checked="true"/>Customer<input type="radio" id="type" name="type" value="salon" />Salon</td>
            </tr>
        </table>
        <div class="row center"><input type="submit" class="btn btn-info btn-lg" value="Save Changes" id="Update" name="Update"/></div>
    </form>
</div>