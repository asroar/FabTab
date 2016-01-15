<?php require 'connection.php'; ?>
<?php
session_start();
if(isset($_POST["setstatus"])) {
    $BookingID = $_POST["bookid"];
    $status =  $_POST["bookstatus"];
    mysqli_query($link, "UPDATE booking SET `status`='{$status}' WHERE bookingID='$BookingID'") or die(mysqli_error($link));
}
if(isset($_SESSION["UserID"])){
    $UserID = $_SESSION["UserID"];
}
else{
    header('Location: login.php');
}
?>
<?php include("header.php"); ?>
<div class="sidebar col-md-3">
    <br><br><br><br><br><br><br><br>
    <iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23ffffff&amp;src=18pb66mtteh2f9vpmr993ff4fk%40group.calendar.google.com&amp;color=%23B1365F&amp;ctz=Asia%2FKarachi" style=" border-width:0 " width="100%" height="300" frameborder="0" scrolling="no"></iframe>
</div>
    <div class="wrap">
        <div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-5"></div>
                <div class="col-md-2 center text-uppercase bold-text">
                    <br>Current Status
                </div>
                <div class="col-md-2"></div>
            </div><br>
            <?php
            $result = $link->query("SELECT * FROM booking WHERE salonID='$UserID'");
            while($row = $result->fetch_array(MYSQLI_BOTH)){
                $Status = $row['status'];
                $Date = $row['bookingdate'];
                $BookingDate= date('m/d/Y', strtotime($Date));
                ?>
                <div class="row event-container">
                    <div class="col-md-3"></div>
                    <div class="col-md-5 event-detail">
                        <h4 class="bold-text">Customer Name: <?php echo $row['customername'];?></h4>
                        <h4>Booking Date: <?php echo $BookingDate;?></h4>
                        <h5>Services: <?php echo $row["services"];?></h5>
                        <h5>Contact No: <?php echo $row['contact'];?></h5>
                    </div>
                    <div class="col-md-2 center">
                        <?php
                        if($Status=="cancelled") echo'<img src="../images/cancelled.png" class="booking-icons"/>';
                        else if($Status=="confirmed") echo'<img src="../images/confirmed.png" class="booking-icons"/>';
                        else if($Status=="not confirmed") echo'<img src="../images/notconfirmed.png" class="booking-icons"/>';
                        else if($Status=="done") echo'<img src="../images/done.png" class="booking-icons"/>';
                        ?>
                        <h5 class="text-capitalize"><?php echo $Status;?></h5>
                    </div>
                    <div class="col-md-2 center change-status">
                        <form method="post">
                            <input type="radio" name="bookstatus" value="cancelled"/>Cancelled
                            <input type="radio" name="bookstatus" value="confirmed"/>Confirmed<br>
                            <input type="radio" name="bookstatus" value="not confirmed"/>Not Confirmed
                            <input type="radio" name="bookstatus" value="done"/>Done
                            <input class="hidden" type="text" name="bookid" value="<?php echo $row['bookingID'];?>"/><br>
                            <input class="btn btn-info" type="submit" name="setstatus" value="Change Status"/>
                        </form>
                    </div>
                </div><br><br>
            <?php } ?>
        </div>
    </div>
