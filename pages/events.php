<?php require 'connection.php'; ?>
<?php
session_start();
$result = $link->query("SELECT * FROM event ORDER BY eventdate DESC");
if(isset($_POST["filtertime"])){
        $ByTime = $_POST["filterbytime"];
        /*if($ByTime=="nextweek"){
        $result = $link->query("SELECT * FROM event WHERE eventdate BETWEEN DAY(CURRENT_DATE) AND DAY(CURRENT_DATE+7) ORDER BY eventdate DESC");
        }
        else*/ if($ByTime=="nextmonth"){
        $result = $link->query("SELECT * FROM event WHERE MONTH(eventdate) BETWEEN MONTH(CURRENT_DATE ) AND (MONTH(CURRENT_DATE)+1) ORDER BY eventdate DESC");
        }
        else{
        $result = $link->query("SELECT * FROM event WHERE MONTH(eventdate)=$ByTime ORDER BY eventdate DESC");
        }
}
if(isset($_POST["filterloc"])) {
    $ByLoc = $_POST["filterbyloc"];
    $result = $link->query("SELECT * FROM event WHERE venue LIKE '%" . $ByLoc . "%' ORDER BY eventdate DESC");
}
?>
<?php include("header.php"); ?>

    <div class="wrap">
        <div class="col-md-9">

    <?php while($row = $result->fetch_array(MYSQLI_BOTH)){
        $Date_input=$row['eventdate'];
        $Date= date('m/d/Y', strtotime($Date_input));
        $EventID=$row['eventID'];
        ?>
        <div class="row event-detail">
                <h3 class="highlight"><?php echo $row['eventname'];?></h3>
                <h5><img src="../images/pin.png"/><?php echo $Date;?></h5>
                <h5><img src="../images/confirmed.png"/><?php echo $row['venue'];?></h5>
                <a href="<?php echo 'eventdetail.php?id='.$EventID;?>">See more</a>
        </div>
    <?php }?>
        </div>

        <div class="col-md-3">
            <ul class='blog-sidebar event-sidebar'>
                <form method="post">
                    <h5>Filter By Time:</h5>
                    <select name="filterbytime" class="input-style">
                        <!--<option value="nextweek">Next Week</option>-->
                        <option value="nextmonth">Next Month</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <br><br>
                    <input type="submit" class="btn btn-info btn-lg" value="Filter By Time" name="filtertime"/>
                </form>
                <form method="post">
                    <h5>Filter By Location:</h5>
                    <select name="filterbyloc">
                        <option value="gulshan">Gulshan-e-Iqbal</option>
                        <option value="jauhar">Gulistan-e-Jauhar</option>
                        <option value="defence">Defence</option>
                        <option value="nazimabad">Nazimabad</option>
                        <option value="bahadurabad">Bahadurabad</option>
                        <option value="road">Tariq Road</option>
                    </select>
                    <br><br>
                    <input type="submit" class="btn btn-info btn-lg" value="Filter By Location" name="filterloc"/>
                </form>
            </ul>
        </div> <!--sidebar ends -->
    </div>
