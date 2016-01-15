<?php require 'connection.php'; ?>
<?php
session_start();
if(isset($_SESSION["UserID"])){
    $UserID = $_SESSION["UserID"];
    $result = $link->query("SELECT * FROM users WHERE userID='$UserID'");
    $row = $result->fetch_array(MYSQLI_BOTH);
    $Name = $row["fullname"];
    $Bio=$row["bio"];

    /*joining with salons table*/
    $result = $link->query("SELECT * FROM salons WHERE userID='$UserID'");
    $row = $result->fetch_array(MYSQLI_BOTH);
    $SalonID = $row['salonID'];
    $Location=$row['location'];
    $FB=$row['facebook'];
    $Instagram=$row['instagram'];
    $Website=$row['website'];
    $EventSection=$row['event_section'];

    /*joining with frequent services for booking form*/
    $result = $link->query("SELECT * FROM `frequentservices` where `salonID`='$SalonID'");
    $row = $result->fetch_array(MYSQLI_BOTH);
    $Option_one=$row['option_one'];
    $Option_two=$row['option_two'];
    $Option_three=$row['option_three'];
    $Option_four=$row['option_four'];
    $Option_five=$row['option_five'];

    /*joining with events table*/
    $result = $link->query("SELECT * FROM `event` where `salonID`='$SalonID'");
    for($n=0;$n<3;$n++){
    $row = $result->fetch_array(MYSQLI_BOTH);
    $EventName[$n]=$row['eventname'];
    $Duration[$n]=$row['duration'];
    $Date[$n]=$row['eventdate'];
    $Venue[$n]=$row['venue'];}

    $address = urlencode($Location);
    $coordinates = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=true');
    $coordinates = json_decode($coordinates);
/*
    echo 'Latitude:' . $coordinates->results[0]->geometry->location->lat;
    echo 'Longitude:' . $coordinates->results[0]->geometry->location->lng;*/

    $lat = $coordinates->results[0]->geometry->location->lat;
    $lng = $coordinates->results[0]->geometry->location->lng;

}
else{
    header('Location: login.php');
}
?>
<?php include("header.php"); ?>

    <div class="wrap">

        <div class="row salon-tab" id="timeline">
            <br/><br/><br/><br/>
            <h2><?php echo $Name;?></h2>
            <h5><?php echo $Bio;?></h5>
            <div id="salon-nav" class="row">
                <!--<div class="col-md-1 icon"><a href="#gallery" class="icon-link"><img src="../images/gallery.png"/><br/>Gallery</a></div>-->
                <div class="col-md-1 icon"><a href="bookings.php" class="icon-link"><img src="../images/booking.png"/><br/>Booking</a></div>
                <div class="col-md-1 icon"><a href="inbox.php" class="icon-link"><img src="../images/message.png"/><br/>Inbox</a></div>
                <div class="col-md-1 icon"><a href="#services" class="icon-link"><img src="../images/services.png"/><br/>Services</a></div>
                <?php if($EventSection==1){?>
                <div class="col-md-1 icon"><a href="#events" class="icon-link"><img src="../images/map.png"/><br/>Events</a></div>
                <?php }?>
                <div class="col-md-1 icon"><a href="#review" class="icon-link"><img src="../images/heart.png"/><br/>Feedback</a></div>
                <div class="col-md-1 icon"><a href="#location" class="icon-link"><img src="../images/pin.png"/><br/>Location</a></div>
                <div class="col-md-1 icon"><a href="#aboutus" class="icon-link"><img src="../images/about.png"/><br/>About Us</a></div>
                <div class="col-md-1 icon"><a href="#contactus" class="icon-link"><img src="../images/contact.png"/><br/>Contact Us</a></div>
                <div class="col-md-1 icon"><a href="updatesalondetails.php" class="icon-link"><img src="../images/edit.png"/><br/>Edit Profile</a></div>
                <div class="col-md-1 icon"><a href="logout.php" class="icon-link"><img src="../images/logout.png"/><br/>Log Out</a></div>
            </div>
        </div>

        <!--<a name="gallery"></a>
        <div class="fotorama" data-height="400" data-nav="thumbs">
            <img src="../images/1.jpg">
            <img src="../images/2.jpg">
            <img src="../images/3.jpg">
            <img src="../images/4.jpg">
            <img src="../images/1.jpg">
            <img src="../images/2.jpg">
            <img src="../images/3.jpg">
            <img src="../images/4.jpg">
            <img src="../images/1.jpg">
            <img src="../images/2.jpg">
            <img src="../images/3.jpg">
            <img src="../images/4.jpg">
            <img src="../images/1.jpg">
            <img src="../images/2.jpg">
            <img src="../images/3.jpg">
            <img src="../images/4.jpg">
            <img src="../images/4.jpg">
        </div>-->

        <a name="aboutus"></a>
        <div class="row salon-tab center mini-tab">
            <br/><br/><span class="element lead"></span>
        </div>

        <a name="services"></a>
        <div class="row salon-tab">
            <br><br>
            <div id="tab_links" class="center">
                <a href="#one">Skin & Nails</a>
                <a href="#two">Hair</a>
                <a href="#three">Makeup</a>
                <a href="#four">Miscellaneous</a>
            </div>

            <div class="col-md-2"></div>
            <section id="tab_desc" class="col-md-8">
                <div id="one"><table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Services</th>
                            <th>Rates</th>
                        </tr>
                        </thead>
                        <?php
                        $result = $link->query("SELECT * FROM `salonservices` where `salonID`='$SalonID' AND `category`='skin and nails'");
                        while($row = $result->fetch_array(MYSQLI_BOTH)){
                            ?>
                            <tr>
                                <td><?php echo $row['service'];?></td>
                                <td><?php echo $row['price'];?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>

                <div id="two"><table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Services</th>
                            <th>Rates</th>
                        </tr>
                        </thead>
                        <?php
                        $result = $link->query("SELECT * FROM `salonservices` where `salonID`='$SalonID' AND `category`='hair'");
                        while($row = $result->fetch_array(MYSQLI_BOTH)){
                            ?>
                            <tr>
                                <td><?php echo $row['service'];?></td>
                                <td><?php echo $row['price'];?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>

                <div id="three"><table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Services</th>
                            <th>Rates</th>
                        </tr>
                        </thead>
                        <?php
                        $result = $link->query("SELECT * FROM `salonservices` where `salonID`='$SalonID' AND `category`='makeup'");
                        while($row = $result->fetch_array(MYSQLI_BOTH)){
                            ?>
                            <tr>
                                <td><?php echo $row['service'];?></td>
                                <td><?php echo $row['price'];?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>

                <div id="four"><table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Services</th>
                            <th>Rates</th>
                        </tr>
                        </thead>
                        <?php
                        $result = $link->query("SELECT * FROM `salonservices` where `salonID`='$SalonID' AND `category`='miscellaneous'");
                        while($row = $result->fetch_array(MYSQLI_BOTH)){
                            ?>
                            <tr>
                                <td><?php echo $row['service'];?></td>
                                <td><?php echo $row['price'];?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </section>
        </div>

        <a name="write"></a>
        <div class="row salon-tab medium-tab">
            <form name="MessageForm" action="" method="POST">
            <div class="col-md-6 center">
                <br><br>
                <h2>We would love to<br>hear from you!</h2><br>
                <input type="submit" class="btn btn-info btn-lg" value="Send Message" name="sendmessage"/>
            </div>
                <div class="col-md-6 right">
                    <div class="form-group">
                        <br><br>
                        <textarea class="form-control" rows="8" name="comment" placeholder="Your Message"></textarea><br>
                    </div>
            </div>
            </form>
        </div>

        <a name="booking"></a>
        <div class="row salon-tab large-tab">
            <div class="col-md-6">
                <form name="BookingForm" action="" method="POST">
                    <div class="form-group">
                        <br>
                        <input type="text" class="form-control" id="name" placeholder="Name"><br>
                        <input type="email" class="form-control" id="email" placeholder="Email"><br>
                        <input type="number" class="form-control" id="number" placeholder="Contact Number"><br>
                        <div class="input-append date" id="datepicker" data-date="today" data-date-format="dd-mm-yyyy">
                            <input class="form-control" type="text" placeholder="Date" />
                            <span class="add-on"><i class="icon-calendar"></i></span>
                        </div>
                        <br/>
                        <label class="checkbox-inline"><input type="checkbox" value="<?php echo $Option_one;?>"><?php echo $Option_one;?></label>
                        <label class="checkbox-inline"><input type="checkbox" value="<?php echo $Option_two;?>"><?php echo $Option_two;?></label>
                        <label class="checkbox-inline"><input type="checkbox" value="<?php echo $Option_three;?>"><?php echo $Option_three;?></label>
                        <label class="checkbox-inline"><input type="checkbox" value="<?php echo $Option_four;?>"><?php echo $Option_four;?></label>
                        <label class="checkbox-inline"><input type="checkbox" value="<?php echo $Option_five;?>"><?php echo $Option_five;?></label>
                        <br/><br/>
                        <select id="category" name="category[]" class="form-control">
                            <?php
                            $result = $link->query("SELECT * FROM `salonservices` where `salonID`='$SalonID'");
                            while($row = $result->fetch_array(MYSQLI_BOTH)){?>
                            <option value="<?php echo $row['service'];?>"><?php echo $row['service'];?></option>
                            <?php }?>
                        </select>
                        <br><input type="text" class="form-control" id="service" placeholder="Other Service"><br>
                        <!--<button type="submit" class="btn btn-info" title="">Make Booking</button>-->
                    </div>

            </div>
            <div class="col-md-6 right center">
                <br><br>
                <h2>We would love to serve you.<br>Open 6 days a week!</h2>
                <h3>Timings:</h3>
                <br>
                <input type="submit" class="btn btn-info btn-lg" value="Make Booking"/>
            </div>
            </form>
        </div>

        <?php if($EventSection==1){?>
        <a name="events"></a>
        <div class="row salon-tab large-tab" >
            <div class="col-md-4">
                <div class="event-image"><img src="../images/1.jpg"/></div>
                <div class="event-desc center"><h3><?php echo $EventName[0];?></h3><h4><?php echo $Date[0];?></h4><h4><?php echo $Venue[0];?></h4><h5><?php echo $Duration[0];?>hours</h5></div>
            </div>
            <div class="col-md-4">
                <div class="event-image"><img src="../images/2.jpg"/></div>
                <div class="event-desc center"><h3><?php echo $EventName[1];?></h3><h4><?php echo $Date[1];?></h4><h4><?php echo $Venue[1];?></h4><h5><?php echo $Duration[1];?>hours</h5></div>
            </div>
            <div class="col-md-4">
                <div class="event-image"><img src="../images/3.jpg"/></div>
                <div class="event-desc center"><h3><?php echo $EventName[2];?></h3><h4><?php echo $Date[2];?></h4><h4><?php echo $Venue[2];?></h4><h5><?php echo $Duration[2];?>hours</h5></div>
            </div>
        </div>
        <?php }?>


        <a name="review"></a>
        <div class="row salon-tab center">
            <br>
            <h2>Our Happy Customers</h2>
            <br>
            <div id="slideshow" class="center">
                <?php
                $result = $link->query("SELECT * FROM `testimonials` where `salonID`='$SalonID'");
                while($row = $result->fetch_array(MYSQLI_BOTH)){?>
                    <div>
                        <p><?php echo $row['testimonial'];?><br>- <?php echo $row['client'];?></p>
                    </div>
                <?php }?>
            </div>
        </div>

        <a name="location"></a>
        <div class="row center"><br/><h3><?php echo $Location;?></h3></div>
        <div class="row salon-tab"  id="googleMap">
        </div>

        <a name="contactus"></a>
        <div class="row salon-tab center small-tab">
            <br><h3>We would love to<br>connect with you!</h3><br>
            <div id="contact-icons" class="center">
                <a href="<?php echo $FB;?>" target="_blank"><img src="../images/facebook.png"/></a>
                <a href="<?php echo $Instagram;?>" target="_blank"><img src="../images/instagram.png"/></a>
                <a href="<?php echo $Website;?>" target="_blank"><img src="../images/twitter.png"/></a>
            </div>
        </div>
    </div>

    <a href="#top" id="top-icon"><img src="../images/goup.png"/></a>


</body>
</html>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en"></script>
<script>
    function initialize() {

        var mapOptions = {
            zoom: 15,
            center: new google.maps.LatLng('<?php echo $lat ?>', '<?php echo $lng ?>')
        };

        var map = new google.maps.Map(document.getElementById('googleMap'),
            mapOptions);

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng('<?php echo $lat ?>', '<?php echo $lng ?>'),
            map: map,
            title: '<?php echo $Name; ?>'
        });

    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>