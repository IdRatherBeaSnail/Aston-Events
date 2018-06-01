<!DOCTYPE html>
<?php
include_once("header.php");
include_once("includes/dbh.php");
// redirect none logged in users
   if (!isset($_SESSION['u_id'])) {
       header("Location: ../index.php");
       die();
   }
// gets information from database if edit has been clicked and is in the url
   if (isset($_GET['edit'])) {
       $id = $_GET['edit'];
       $query = ("SELECT events.event_id,events.event_type,events.event_name,DATE_FORMAT(events.event_date, '%Y-%m-%dT%H:%i') AS custom_date,events.event_description,events.event_address1,events.event_address2,events.event_city,events.event_postcode,events.event_likes,events.event_image,users.user_uname FROM events INNER JOIN users ON events.user_uname = users.user_id WHERE event_id='$id'");
       $res = mysqli_query($conn, $query);
       $row= mysqli_fetch_array($res);
   }
 ?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Aston Events</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i%7cMontserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- Style -->
    <link href="css/style.css" rel="stylesheet">

      <!-- js scripts-->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/menumaker.js"></script>
      <script src="js/jquery.sticky.js"></script>
      <script src="js/sticky-header.js"></script>
  </head>
  <body>
    <!-- Header with image -->
        <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="page-caption">
                            <h2 class="page-title">Edit Your Event</h2>
                            <div class="page-breadcrumb">
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Edit Event</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
              <!--PHP error message if an error occured -->
              <?php
              if (isset($_GET['event'])) {
                  $msg = base64_decode($_GET['event']);
                  if ($msg!="") {
                      echo "<p style='color:blue; border:2px red solid; padding-left:10px;'>$msg</p>";
                  }
              } ?>

              <!-- Box on the left with information-->
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="widget widget-contact">
                            <h3 class="widget-title">Become an Event Organiser</h3>
                                <strong>How?</strong>
                                <br> Fill out sign up form
                                <br> Login to website
                                <br> Start adding your events!
                        </div>
                        <div class="widget widget-social">
                            <div class="social-circle">
                                <a href="http://www.aston.ac.uk/news/events/" target="_blank" class="#"><i class="fa fa-facebook"></i></a>
                                <a href="http://www.aston.ac.uk/news/events/" target="_blank" class="#"><i class="fa fa-google-plus"></i></a>
                                <a href="http://www.aston.ac.uk/news/events/" target="_blank" class="#"><i class="fa fa-twitter"></i></a>
                                <a href="http://www.aston.ac.uk/news/events/" target="_blank" class="#"><i class="fa fa-youtube-play"></i></a>
                            </div>
                        </div>
                    </div>
    <!-- Formatting for form -->
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>EDIT EVENT DETAILS</h1>
                <p> Fill out the form below to alter your event details</p>
                <!-- Form to edit event details-->
                <form action="includes/edit-events.inc.php" method ="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" for="eventname">Name of Event</label>
                        <!--client side validation for text input for event name, field is required and min length 1 letter and max 64. Charcters can only be letters and numbers it is pre-filled with database data relating to the specific event-->
                            <input type = "text" name = "newEventName" placeholder="Event name" class="form-control" value="<?php echo $row[2];?>" pattern = "[A-Za-z0-9 ]{1,64}" title = "Field includes invalid characters. Only letters allowed." required/>
                            <input type = "hidden" name = "eventId"  value="<?php echo $row[0]?>">
                        </div>

                        <div class="col-md-6">
                            <label class="control-label" for="eventtype">Event Category</label>
                        <!--drop down selection of category is automatically set to the information stored in datasbase-->
                            <select name="newTypes" class="form-control"  required>
                              <option value="<?php echo ucfirst($row[1]); ?>"><?php echo ucfirst($row[1]); ?></option>
                              <option value="sports">Sports</option>
                              <option value="culture">Culture</option>
                              <option value="art">Art</option>
                              <option value="music">Music</option>
                              <option value="nature">Nature</option>
                              <option value="history">History</option>
                              <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="control-label" for="datetime">Date and Time</label>
                        <!--client side validation for date and time input , pre-filled with database information-->
                            <input type="datetime-local" name="newDaynTime" class="form-control" value="<?php echo $row['custom_date']; ?>" required/>
                        </div>

      									<div class="col-md-6">
                                <label class="control-label" for="username">Event Organiser</label>
                                <!-- Organiser of event (username of account)-->
                                <input type = "text" name = "uname" class="form-control" value="<?php echo $_SESSION["u_uid"]?>" readonly>
                          </div>

                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group">
                                  <label class="control-label" for="description">Description</label>
                                  <!-- Description of event pre-filled from information in database-->
                                  <textarea class="form-control" id="textarea" name="newDescription" rows="6" placeholder="Information about event"><?php echo $row[4]; ?></textarea>
                              </div>
                          </div>
                          <!--Address of the event -->
                        <div class="col-md-6">
                            <label class="control-label" for="address1">Address1</label>
                            <input type = "text" name = "newAddress1" placeholder="101 example road" value="<?php echo $row[5]; ?>" class="form-control" required />
                        </div>

                        <div class="col-md-6">
                            <label class="control-label" for="address2">Address2</label>
                            <input type = "text" name = "newAddress2" placeholder="Edgbaston" value="<?php echo $row[6]; ?>" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="city">City</label>
                            <input type = "text" name = "newCity" placeholder="London" value="<?php echo $row[7]; ?>" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="postcode">Post Code</label>
                        <!--client side validation for password, field is required and must match pattern, must contain 1 uppercase letter, 1 lowercase letter, 1 number and atleast 8 characters minium -->
                              <input type = "text" name = "newPostcode" placeholder="X109UL" class="form-control" value="<?php echo $row[8]; ?>" pattern="([A-Za-z0-9 ]){7}" title="Enter a valid UK post code" required/>
                        </div>
                        <div class="col-md-6"><label>Select an image: </label>
                          <!--event image -->
                          <input type="file" name="newEventImg" accept="image/*"  required/>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <br />
                                <button type = "submit" name ="submit" class="btn btn-default">Edit Event</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
  </div>
  </div>
  </body>
</html>
