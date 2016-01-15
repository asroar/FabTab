<?php require 'connection.php'; ?>
<?php
if(isset($_POST['Detail'])) {
    session_start();
    $UserID = $_SESSION["UserID"];
    /*storing user's input in variables*/
    $Location=$_POST['location'];
    $FB=$_POST['facebook'];
    $Instagram=$_POST['instagram'];
    $Website=$_POST['website'];
    /*$Option=$_POST['option'];*/
    $Option_one=$_POST['option_one'];
    $Option_two=$_POST['option_two'];
    $Option_three=$_POST['option_three'];
    $Option_four=$_POST['option_four'];
    $Option_five=$_POST['option_five'];
    $Service=$_POST['service'];
    $Price= $_POST['price'];
    $Category= $_POST['category'];
    $EventName=$_POST['name'];
    $Duration=$_POST['duration'];
    $Date_input=$_POST['date'];
    $StartTime_input=$_POST['starttime'];
    $EndTime_input=$_POST['endtime'];
    $Venue=$_POST['venue'];
    $Description=$_POST['description'];
    $Testimonial=$_POST['testimonial'];
    $CustomerName=$_POST['customername'];

    /*inserting into main salons table*/
    mysqli_query($link,"INSERT INTO salons(`userID`, `location`, `facebook`, `instagram`, `website`) VALUES ('{$UserID}','{$Location}','{$FB}', '{$Instagram}','{$Website}')") or die(mysqli_error($link));

    /*accessing automatically generated salonID*/
    $result = $link->query("SELECT salonID FROM salons WHERE userID='$UserID'");
    $row = $result->fetch_array(MYSQLI_BOTH);
    $SalonID = $row['salonID'];

    /*inserting frequently asked services*/
    mysqli_query($link,"INSERT INTO frequentservices(`salonID`, `option_one`, `option_two`, `option_three`, `option_four`, `option_five`) VALUES ('{$SalonID}','{$Option_one}','{$Option_two}', '{$Option_three}', '{$Option_four}', '{$Option_five}')") or die(mysqli_error($link));

    /*inserting all services provided by salon*/
    for($n=0;$n<count($Service);$n++)
    mysqli_query($link,"INSERT INTO salonservices(`salonID`, `category`, `service`, `price`) VALUES ('{$SalonID}','{$Category[$n]}','{$Service[$n]}', '{$Price[$n]}')") or die(mysqli_error($link));

    /*inserting events*/
    for($n=0;$n<3;$n++){
        /*convert date time formats*/
        $Date = date('Y-m-d', strtotime(str_replace('-', '/', $Date_input[$n])));
        $StartTimeFormat = date('H:i:s', strtotime($StartTime_input[$n]));
        $EndTimeFormat = date('H:i:s', strtotime($EndTime_input[$n]));
        mysqli_query($link,"INSERT INTO event(`salonID`,`eventname`, `eventdate`, `duration`, `starttime`, `endtime`, `venue`, `description`) VALUES ('{$SalonID}','{$EventName[$n]}','{$Date}','{$Duration[$n]}', '{$StartTimeFormat}', '{$EndTimeFormat}', '{$Venue[$n]}', '{$Description[$n]}')") or die(mysqli_error($link));
    }

    /*inserting all testimonials*/
    for($n=0;$n<count($Testimonial);$n++)
        mysqli_query($link,"INSERT INTO testimonials(`salonID`,  `testimonial`, `client`) VALUES ('{$SalonID}','{$Testimonial[$n]}','{$CustomerName[$n]}')") or die(mysqli_error($link));

    /*directing to login page*/
    header('Location: login.php');
}
?>
<?php include("header.php"); ?>

<div class="wrap">
    <form action="" name="SalonForm" method="post">

        <div class="center basicform">
            <br/>
            <h4 class="text-uppercase">Basic details</h4>
        <table class="left-margin">
            <tr>
                <td><input class="form-control" type="text" id="location" name="location" placeholder="Location"/></td>
            </tr>
            <tr>
                <td><input class="form-control" type="text" id="facebook" name="facebook" placeholder="Facebook Link"/></td>
            </tr>
            <tr>
                <td><input class="form-control" type="text" id="instagram" name="instagram" placeholder="Instagram Link"/></td>
            </tr>
            <tr>
                <td><input class="form-control" type="text" id="website" name="website" placeholder="Website URL"/></td>
            </tr>
        </table>
        </div>

        <div class="row servicesform center">
            <br/><br/>
            <h4 class="text-uppercase">Services</h4>
            <h5>You can add details for as many services as you like.</h5>
            <input type="button" class="btn btn-info" value="Add Service" onClick="addRow('dataTable')" />
            <br/><br/>
            <table id="dataTable">
                    <tr>
                        <td><select class="form-control" id="category" name="category[]">
                                <option value="hair">Hair</option>
                                <option value="skin and nails">Skin & Nails</option>
                                <option value="makeup">Makeup</option>
                                <option value="miscellaneous">Others</option>
                            </select></td>

                        <td><input type="text" class="form-control" id="service" name="service[]" placeholder="Service Name"/></td>
                        <td><input type="text" class="form-control" id="price" name="price[]" placeholder="Service Price"/></td>
                    </tr>
            </table>
        </div>

        <div class="row center optionsform">
            <br/><br/>
            <h4 class="text-uppercase">frequently asked services</h4>
            <h5>These five options will appear on the booking form on your website.</h5>
            <table class="left-margin">
                <tr>
                    <td><input class="form-control" type="text" name="option_one" placeholder="Option 1"/></td>
                </tr>
                <tr>
                    <td><input class="form-control" type="text" name="option_two" placeholder="Option 2"/></td>
                </tr>
                <tr>
                    <td><input class="form-control" type="text" name="option_three" placeholder="Option 3"/></td>
                </tr>
                <tr>
                    <td><input class="form-control" type="text" name="option_four" placeholder="Option 4"/></td>
                </tr>
                <tr>
                    <td><input class="form-control" ="text" name="option_five" placeholder="Option 5"/></td>
                </tr>
            </table>
        </div>

        <div class="row testimonialsform center">
            <br/><br/>
            <h4 class="text-uppercase">Customer Feedback</h4>
            <h5>You can add testimonials of as many customers as you like.</h5>
            <input type="button" class="btn btn-info" value="Add Testimonial" onClick="addRow('feedbackTable')" />
            <br/><br/>
            <table id="feedbackTable">
                <tr>
                    <td><textarea type="text" rows="5" class="form-control" name="testimonial[]" placeholder="Customer Feedback"></textarea></td>
                    <td class="small-input"><input type="text" class="form-control" name="customername[]" placeholder="Customer Name"/></td>
                </tr>
            </table>
        </div>

        <div class="row center" class="eventsform">
            <br/><br/>
            <h4 class="text-uppercase">Events</h4>
            <h5>You can add details for three events or hide the events section completely.</h5>
            <small>
            <input type="radio" name="eventsection" required="true" value="hide" />Hide events section
            <input type="radio" name="eventsection" required="true" value="show" />Show events section
            </small>
            <br/>
            <div class="col-md-4">
                <table>
                    <tr>
                        <td><input type="text" class="form-control" name="name[]" placeholder="Event Name"/></td>
                    </tr>
                    <tr>
                        <td><input type="number" class="form-control" name="duration[]" placeholder="Duration in hours"/></td>
                    </tr>
                    <tr>
                        <td><input type="date" class="form-control" name="date[]" placeholder="Date"/></td>
                    </tr>
                    <tr>
                        <td>Start Time</td>
                        <td><input type="time" class="form-control" name="starttime[]" placeholder="Start Time"/></td>
                    </tr>
                    <tr>
                        <td>End Time</td>
                        <td><input type="time" class="form-control" name="endtime[]" placeholder="End Time"/></td>
                    </tr>
                    <tr>
                        <td><input type="text" class="form-control" name="venue[]" placeholder="Venue"/></td><br/>
                    </tr>
                    <tr>
                        <td><textarea rows="5" class="form-control" name="description[]" placeholder="Description"></textarea></td>
                    </tr>

                </table>
            </div>

            <div class="col-md-4">
                <table>
                    <tr>
                        <td><input type="text" class="form-control" name="name[]" placeholder="Event Name"/></td>
                    </tr>
                    <tr>
                        <td><input type="number" class="form-control" name="duration[]" placeholder="Duration in hours"/></td>
                    </tr>
                    <tr>
                        <td><input type="date" class="form-control" name="date[]" placeholder="Date"/></td>
                    </tr>
                    <tr>
                        <td>Start Time</td>
                        <td><input type="time" class="form-control" name="starttime[]" placeholder="Start Time"/></td>
                    </tr>
                    <tr>
                        <td>End Time</td>
                        <td><input type="time" class="form-control" name="endtime[]" placeholder="End Time"/></td>
                    </tr>
                    <tr>
                        <td><input type="text" class="form-control" name="venue[]" placeholder="Venue"/></td><br/>
                    </tr>
                    <tr>
                        <td><textarea rows="5" class="form-control" name="description[]" placeholder="Description"></textarea></td>
                    </tr>

                </table>
            </div>

            <div class="col-md-4">
                <table>
                    <tr>
                        <td><input type="text" class="form-control" name="name[]" placeholder="Event Name"/></td>
                    </tr>
                    <tr>
                        <td><input type="number" class="form-control" name="duration[]" placeholder="Duration in hours"/></td>
                    </tr>
                    <tr>
                        <td><input type="date" class="form-control" name="date[]" placeholder="Date"/></td>
                    </tr>
                    <tr>
                        <td>Start Time</td>
                        <td><input type="time" class="form-control" name="starttime[]" placeholder="Start Time"/></td>
                    </tr>
                    <tr>
                        <td>End Time</td>
                        <td><input type="time" class="form-control" name="endtime[]" placeholder="End Time"/></td>
                    </tr>
                    <tr>
                        <td><input type="text" class="form-control" name="venue[]" placeholder="Venue"/></td><br/>
                    </tr>
                    <tr>
                        <td><textarea rows="5" class="form-control" name="description[]" placeholder="Description"></textarea></td>
                    </tr>

                </table>
            </div>
        </div>

        <div class="row center">
            <br/><br/>
            <input type="submit" class="btn btn-info" value="Submit Details" id="Detail" name="Detail"/>
        </div>
    </form>
</div>

</body>
</html>

<script>
    function addRow(tableID) {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);
        var colCount = table.rows[0].cells.length;
        for(var i=0; i<colCount; i++) {
            var newcell = row.insertCell(i);
            newcell.innerHTML = table.rows[0].cells[i].innerHTML;
        }

    }
</script>