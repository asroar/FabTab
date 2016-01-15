<?php require 'connection.php'; ?>
<?php
session_start();
$EventID=$_GET['id'];
$result = $link->query("SELECT * FROM `event` WHERE eventID='$EventID'");
$row = $result->fetch_array(MYSQLI_BOTH);
$Image = $row['image'];
$EventName=$row['eventname'];
$Duration=$row['duration'];
$Date_input=$row['eventdate'];
$StartTime_input=$row['starttime'];
$EndTime_input=$row['endtime'];
$Venue=$row['venue'];
$Description=$row['description'];
/*convert date time formats*/
$Date= date('m/d/Y', strtotime($Date_input));
$StartTimeFormat= date('g:i A', strtotime($StartTime_input));
$EndTimeFormat= date('g:i A', strtotime($EndTime_input));
?>
<?php include("header.php"); ?>

    <div class="wrap">
        <div class="row" id="event-profile-container">
            <div class="col-md-6" id="event-profile">
                <img class="event-detail-image" src="<?php echo $Image;?>"/>
            </div>
            <div class="col-md-6 center" id="right-profile">
                <h3><?php echo $EventName;?></h3>
                <h4><?php echo $Date;?></h4>
                <h4><?php echo $Duration;?> hours</h4>
                <h4><?php echo $StartTimeFormat;?> - <?php echo $EndTimeFormat;?></h4>
                <h4><?php echo $Venue;?></h4>
                <h4><?php echo $Description;?></h4>
                <h4 class="text-uppercase btn btn-info btn-lg">Contact: 12345678 to book your seat.</h4>
                <br/><br/><br/>
                <div class="row center share-fb">
                    <h4 class="text-uppercase">Share Event With Your Friends</h4>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=http://localhost/FabTabLoginSystem/pages/eventdetail.php?id=<?php echo $EventID; ?>" target="_blank"><img src="../images/social-facebook.png"/></a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=http://localhost/FabTabLoginSystem/pages/eventdetail.php?id=<?php echo $EventID; ?>" target="_blank"><img src="../images/social-twitter.png"/></a>
                </div>
            </div>
        </div>
    </div>

<?php include("footer.php"); ?>