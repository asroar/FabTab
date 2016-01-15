<?php require 'connection.php'; ?>
<?php
session_start();
$Search="";
if(isset($_GET["keyword"])){
    $Search="name";
    if(preg_match("/[A-Za-z]+/", $_GET['keyword'])){
        $keyword=$_GET['keyword'];
    }
    $result = $link->query("SELECT * FROM users WHERE fullname LIKE '%".$keyword."%' OR username LIKE '%".$keyword."%'");
}

if(isset($_POST["ByLocation"])){
    $Search="loc";
    $Location = $_POST["location"];
    $result = $link->query("SELECT * FROM salons WHERE location LIKE '%".$Location."%'");
}

if(isset($_POST["ByService"])){
    $Search="services";
    $Service = $_POST["service"];
    if(preg_match("/[A-Za-z]+/", $_POST['service'])){
        $Service = $_POST["service"];
    }
    $result = $link->query("SELECT * FROM salonservices WHERE service LIKE '%".$Service."%'");
}

?>
<?php include("header.php"); ?>
    <div class="wrap">
        <br><div class="col-md-9">
        <?php
        if($Search=="name"){
            while($row = $result->fetch_array(MYSQLI_BOTH)){
        ?>
        <br>
        <div class="row search-results">
            <!--<div class="col-md-2"><img src="../images/1.jpg" class="img-rounded img-responsive"/></div>-->
            <div class="col-md-10">
                <h3><a href="<?php
                    $_SESSION["ViewID"]=$row['userID'];
                    if($row["type_of_user"]=="customer")
                        echo 'viewcustomer.php?id='.$row['userID'];
                    else
                        echo 'viewsalon.php?id='.$row['userID'];?>" class="text-uppercase">
                        <?php echo $row['fullname'];?></a></h3>
                <h5><?php echo $row['bio'];?></h5>
            </div>
        </div>
        <?php }}
        else if($Search=="loc"){
            while($row = $result->fetch_array(MYSQLI_BOTH)){
            ?>
                    <br>
                    <div class="row search-results">
                        <!--<div class="col-md-2"><img src="../images/1.jpg" class="img-rounded img-responsive"/></div>-->
                        <div class="col-md-10">
                            <h3><a href="<?php
                                $_SESSION["ViewID"]=$row['userID'];
                                $UserID=$row['userID'];
                                $locsql = $link->query("SELECT * FROM users WHERE userID=$UserID");
                                $locresult = $locsql->fetch_array(MYSQLI_BOTH);
                                if($locresult["type_of_user"]=="customer")
                                    echo 'viewcustomer.php?id='.$UserID;
                                else
                                    echo 'viewsalon.php?id='.$UserID;?>" class="text-uppercase">
                                    <?php echo $locresult['fullname'];?></a></h3>
                            <h5>    <?php $UserID=$row['userID'];
                                    $sql = $link->query("SELECT * FROM salons WHERE userID=$UserID");
                                    $output = $sql->fetch_array(MYSQLI_BOTH);
                                    echo $output['location'];?></h5>
                        </div>
                    </div>
                <?php }  }
            else if($Search=="services"){
                while($rrow = $result->fetch_array(MYSQLI_BOTH)){
                    $SalonID=$rrow["salonID"];
                    $sql = $link->query("SELECT * FROM users, salons WHERE salonID=$SalonID AND users.userID=salons.userID");
                    while($row = $sql->fetch_array(MYSQLI_BOTH)){
                    ?>
                    <br>
                    <div class="row search-results">
                        <!--<div class="col-md-2"><img src="../images/1.jpg" class="img-rounded img-responsive"/></div>-->
                        <div class="col-md-10">
                            <h3><a href="<?php
                                $UserID=$row['userID'];
                                $locsql = $link->query("SELECT * FROM users WHERE userID=$UserID");
                                $locresult = $locsql->fetch_array(MYSQLI_BOTH);
                                if($locresult["type_of_user"]=="customer")
                                    echo 'viewcustomer.php?id='.$UserID;
                                else
                                    echo 'viewsalon.php?id='.$UserID;?>" class="text-uppercase">
                                    <?php echo $locresult['fullname'];?></a></h3>
                            <h5>    <?php $UserID=$row['userID'];
                                echo $rrow['service'];?></h5>
                        </div>
                    </div>
                <?php }  }}?>



        </div>

        <div class="col-md-3 center">
                <form method="post">
                    <br><br><select class="form-control" name="location" placeholder="Search by Location">
                        <option>Search by Location</option>
                        <option name="location" value="gulshan">Gulshan-e-Iqbal</option>
                        <option name="location" value="gulistan">Gulistan-e-Jauhar</option>
                        <option name="location" value="defence">Defence</option>
                        <option name="location" value="zamzama">Zamzama</option>
                        <option name="location" value="nazimabad">Nazimabad</option>
                        <option name="location" value="karachi">Karachi</option>
                        <option name="location" value="lahore">Lahore</option>
                    </select><br>
                    <input type="submit" class="btn btn-info" name="ByLocation" value="Filter By Location"/><br><br>
                </form>
            <form method="post">
            <input type="text" class="form-control" name="service" placeholder="Search by Service"/><br>
            <input type="submit" class="btn btn-info" name="ByService" value="Filter By Service"/>
            </form>
        </div>

    </div>


