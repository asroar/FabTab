<?php require 'connection.php'; ?>
<?php
session_start();
$UserID = $_SESSION["UserID"];
/*displaying stored values*/
/*basic*/
$result = $link->query("SELECT * FROM users WHERE `userID`='$UserID'");
$row = $result->fetch_array(MYSQLI_BOTH);
$Name = $row["fullname"];
$Email = $row["email"];
$StorePassword=$row['password'];
/*$Username = $row["username"];*/
$Bio=$row["bio"];
$TypeOfUser=$row["type_of_user"];
$result = $link->query("SELECT * FROM salons WHERE userID='$UserID'");
$row = $result->fetch_array(MYSQLI_BOTH);
$SalonID = $row['salonID'];
$Location=$row['location'];
$FB=$row['facebook'];
$Instagram=$row['instagram'];
$Website=$row['website'];
$EventSection=$row['event_section'];
/*frequent services*/
$result = $link->query("SELECT * FROM `frequentservices` where salonID='$SalonID'");
$row = $result->fetch_array(MYSQLI_BOTH);
$Option_one=$row['option_one'];
$Option_two=$row['option_two'];
$Option_three=$row['option_three'];
$Option_four=$row['option_four'];
$Option_five=$row['option_five'];
/*events*/
$result = $link->query("SELECT * FROM `event` where `salonID`='$SalonID'");
for($n=0;$n<3;$n++){
    $row = $result->fetch_array(MYSQLI_BOTH);
    $EventName[$n]=$row['eventname'];
    $Duration[$n]=$row['duration'];
    $Date_input[$n]=$row['eventdate'];
    $StartTime_input[$n]=$row['starttime'];
    $EndTime_input[$n]=$row['endtime'];
    $Venue[$n]=$row['venue'];
    $Description[$n]=$row['description'];
    /*convert date time formats*/
    $Date[$n] = date('m/d/Y', strtotime($Date_input[$n]));
    $StartTimeFormat[$n] = date('g:i A', strtotime($StartTime_input[$n]));
    $EndTimeFormat[$n] = date('g:i A', strtotime($EndTime_input[$n]));
}


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
    $Location=$_POST['location'];
    $FB=$_POST['facebook'];
    $Instagram=$_POST['instagram'];
    $Website=$_POST['website'];
    $EventSection=$_POST['eventsection'];
    $Service=$_POST['service'];
    $Price= $_POST['price'];
    $Category= $_POST['category'];
    $Option_one=$_POST['option_one'];
    $Option_two=$_POST['option_two'];
    $Option_three=$_POST['option_three'];
    $Option_four=$_POST['option_four'];
    $Option_five=$_POST['option_five'];
    $EventName=$_POST['name'];
    $Duration=$_POST['duration'];
    $Date_input=$_POST['date'];
    $StartTime_input=$_POST['starttime'];
    $EndTime_input=$_POST['endtime'];
    $Venue=$_POST['venue'];
    $Description=$_POST['description'];
    $Testimonial=$_POST['testimonial'];
    $CustomerName=$_POST['customername'];
    $Description = str_replace("'", "", $Description);

    /*basic details*/
    $sql = $link->query("UPDATE users SET fullname='{$Name}', email='{$Email}', password='{$StorePassword}', bio='{$Bio}', type_of_user='{$TypeOfUser}' WHERE userID=$UserID") or die(mysqli_error($link));
    $sql = $link->query("UPDATE salons SET location='{$Location}', facebook='{$FB}', instagram='{$Instagram}', website='{$Website}', event_section='{$EventSection}' WHERE userID='$UserID'") or die(mysqli_error($link));

    /*services*/
    $result = $link->query("DELETE FROM salonservices WHERE salonID='$SalonID'");
    for($n=0;$n<count($Service);$n++)
        mysqli_query($link,"INSERT INTO salonservices(`salonID`, `category`, `service`, `price`) VALUES ('{$SalonID}','{$Category[$n]}','{$Service[$n]}', '{$Price[$n]}')") or die(mysqli_error($link));

    /*frequent services options*/
    mysqli_query($link,"UPDATE frequentservices SET `option_one`='{$Option_one}', `option_two`='{$Option_two}', `option_three`='{$Option_three}', `option_four`='{$Option_four}', `option_five`='{$Option_five}' WHERE salonID='$SalonID'") or die(mysqli_error($link));

    /*testimonials*/
    $result = $link->query("DELETE FROM testimonials WHERE salonID='$SalonID'");
    for($n=0;$n<count($Testimonial);$n++){
        if(!empty($Testimonial[$n]))
        mysqli_query($link,"INSERT INTO testimonials(`salonID`,  `testimonial`, `client`) VALUES ('{$SalonID}','{$Testimonial[$n]}','{$CustomerName[$n]}')") or die(mysqli_error($link));
    }

    /*events*/
    for($n=0;$n<3;$n++){
        /*convert date time formats*/
        $Date = date('Y-m-d', strtotime(str_replace('-', '/', $Date_input[$n])));
        $StartTimeFormat = date('H:i:s', strtotime($StartTime_input[$n]));
        $EndTimeFormat = date('H:i:s', strtotime($EndTime_input[$n]));
        mysqli_query($link,"UPDATE event SET `eventname`='{$EventName[$n]}', `eventdate`='{$Date}', `duration`='{$Duration[$n]}', `starttime`='{$StartTimeFormat}', `endtime`='{$EndTimeFormat}', `venue`='{$Venue[$n]}', `description`='{$Description[$n]}' WHERE salonID='$SalonID' ") or die(mysqli_error($link));
    }

    header('Location: salon.php');
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
                    <td class="input-label">Name</td>
                    <td><input type="text" class="form-control" id="name" name="name" value="<?php echo $Name;?>" pattern="[a-z A-Z]+" title="Only alphabets allowed" /></td>
                </tr>
                <tr>
                    <td class="input-label">Email</td>
                    <td><input type="email" class="form-control" id="email" name="email" value="<?php echo $Email;?>"/></td>
                </tr>
                <tr>
                    <td class="input-label">Password</td>
                    <td><input class="form-control" type="password" id="password" name="password" placeholder="Password"/></td>
                </tr>
                <tr>
                    <td class="input-label">Bio</td>
                    <td><textarea class="form-control" rows="5" id="bio" name="bio"><?php echo $Bio;?></textarea></td>
                </tr>
                <tr>
                    <td class="input-label">Type</td>
                    <td><input type="radio" id="type" name="type" value="customer" checked="<?php if($TypeOfUser=="customer")echo "checked";?>"/>Customer<input type="radio" id="type" name="type" value="salon" checked="<?php if($TypeOfUser=="salon")echo "checked";?>"/>Salon</td>
                </tr>
                <tr>
                    <td class="input-label">Location</td>
                    <td><input class="form-control" type="text" id="location" name="location" value="<?php echo $Location; ?>"</td>
                </tr>
                <tr>
                    <td class="input-label">Facebook</td>
                    <td><input class="form-control" type="text" id="facebook" name="facebook" value="<?php echo $FB; ?>"/></td>
                </tr>
                <tr>
                    <td class="input-label">Instagram</td>
                    <td><input class="form-control" type="text" id="instagram" name="instagram" value="<?php echo $Instagram; ?>"/></td>
                </tr>
                <tr>
                    <td class="input-label">Twitter</td>
                    <td><input class="form-control" type="text" id="website" name="website" value="<?php echo $Website; ?>"/></td>
                </tr>
            </table>
        </div>

        <div class="row servicesform center">
            <br/><br/>
            <h4 class="text-uppercase">Services</h4>
            <h5>You can update and add new details for as many services as you like.</h5>

            <table class="less-left-margin">
                <tr>
                    <td>
                        Category
                    </td>
                    <td>
                        Service
                    </td>
                    <td>
                        Price
                    </td>
                </tr>
                <?php
                $result = $link->query("SELECT * FROM `salonservices` where `salonID`='$SalonID'");
                while($row = $result->fetch_array(MYSQLI_BOTH)){
                    ?>
                    <tr>
                        <p>
                        <td>
                            <input type="text" class="form-control" name="category[]" value="<?php echo $row['category']; ?>">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="service[]" value="<?php echo $row['service']; ?>" pattern="[a-z A-Z]+" title="Only alphabets allowed" >
                        </td>
                        <td>
                            <input type="number" class="form-control" name="price[]" value="<?php echo $row['price']; ?>">
                        </td>
                        </p>
                    </tr>
                <?php } ?>
            </table>
            <br>
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
                    <td class="input-label">Option 1</td>
                    <td><input class="form-control" type="text" name="option_one" value="<?php echo $Option_one;?>"/></td>
                </tr>
                <tr>
                    <td class="input-label">Option 2</td>
                    <td><input class="form-control" type="text" name="option_two" value="<?php echo $Option_two;?>"/></td>
                </tr>
                <tr>
                    <td class="input-label">Option 3</td>
                    <td><input class="form-control" type="text" name="option_three" value="<?php echo $Option_three;?>"/></td>
                </tr>
                <tr>
                    <td class="input-label">Option 4</td>
                    <td><input class="form-control" type="text" name="option_four" value="<?php echo $Option_four;?>"/></td>
                </tr>
                <tr>
                    <td class="input-label">Option 5</td>
                    <td><input class="form-control" ="text" name="option_five" value="<?php echo $Option_five;?>"/></td>
                </tr>
            </table>
        </div>

        <div class="row center" class="eventsform">
            <br/><br/>
            <h4 class="text-uppercase">Events</h4>
            <h5>You can add details for three events or hide the events section completely.</h5>
            <small>
                <input type="radio" name="eventsection" required="true" checked="true" value="0" />Hide events section
                <input type="radio" name="eventsection" required="true" value="1" />Show events section
            </small>
            <br/>
            <?php for($n=0;$n<3;$n++){?>
            <div class="col-md-4">
                <table>
                    <tr>
                        <td class="input-label">Event Name</td>
                        <td><input type="text" class="form-control" name="name[]" value="<?php echo $EventName[$n];?>"/></td>
                    </tr>
                    <tr>
                        <td class="input-label">Duration <small>in hours</small></td>
                        <td><input type="number" class="form-control" name="duration[]" value="<?php echo $Duration[$n];?>"/></td>
                    </tr>
                    <tr>
                        <td class="input-label">Date</td>
                        <td><input type="date" class="form-control" name="date[]" value="<?php echo $Date[$n];?>"/></td>
                    </tr>
                    <tr>
                        <td class="input-label">Start Time</td>
                        <td><input type="time" class="form-control" name="starttime[]" value="<?php echo $StartTimeFormat[$n];?>"/></td>
                    </tr>
                    <tr>
                        <td class="input-label">End Time</td>
                        <td><input type="time" class="form-control" name="endtime[]" value="<?php echo $EndTimeFormat[$n];?>"/></td>
                    </tr>
                    <tr>
                        <td class="input-label">Venue</td>
                        <td><input type="text" class="form-control" name="venue[]" value="<?php echo $Venue[$n];?>"/></td>
                    </tr>
                    <tr>
                        <td class="input-label">Description</td>
                        <td><textarea rows="5" class="form-control" name="description[]"><?php echo $Description[$n];?></textarea></td>
                    </tr>
                </table>
            </div>
            <?php } ?>
        </div>

        <div class="row testimonialsform center">
            <br/><br/>
            <h4 class="text-uppercase">Customer Feedback</h4>
            <h5>You can update and add testimonials of as many customers as you like.</h5>
            <table>
            <?php
            $result = $link->query("SELECT * FROM `testimonials` where `salonID`='$SalonID'");
            while($row = $result->fetch_array(MYSQLI_BOTH)){
                if(!empty($row['testimonial'])){
            ?>
                <tr>
                    <td><textarea type="text" rows="5" class="form-control" name="testimonial[]" ><?php echo $row['testimonial']; ?></textarea></td>
                    <td class="small-input"><input type="text" class="form-control" name="customername[]" value="<?php echo $row['client']; ?>"/></td>
                </tr>
            <?php }}?>
            </table>

            <input type="button" class="btn btn-info" value="Add Testimonial" onClick="addRow('feedbackTable')" />
            <br/><br/>
            <table id="feedbackTable">
                <tr>
                    <td><textarea type="text" rows="5" class="form-control" name="testimonial[]" placeholder="Customer Feedback"></textarea></td>
                    <td class="small-input"><input type="text" class="form-control" name="customername[]" placeholder="Customer Name"/></td>
                </tr>
            </table>
        </div>

        <div class="row center">
            <br/>
        <input type="submit" class="btn btn-info btn-lg" value="Update" name="Update" />
        </div>
    </form>
</div>
<?php /*include("footer.php"); */?>

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