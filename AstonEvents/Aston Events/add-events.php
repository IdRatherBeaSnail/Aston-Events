<?php
  include_once("header.php");    // include header.php
  // if user hasn't logged in, can not access this page and will redirected
  if (!isset($_SESSION['u_id'])) {
      header("Location: index.php");
      die();
  }
 ?>
<!DOCTYPE html>
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

      <!-- js scripts -->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/menumaker.js"></script>
      <script src="js/jquery.sticky.js"></script>
      <script src="js/sticky-header.js"></script>
  </head>
  <body>
    <!-- page header with image -->
        <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="page-caption">
                            <h2 class="page-title">Add Event</h2>
                            <div class="page-breadcrumb">
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Add Event</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- box on the side with information and social media links to current aston events website -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="widget widget-contact">
                          <h3 class="widget-title">Now That You're an Event Organiser</h3>
                              <strong>Start uploading your Events !</strong>
                              <br> Find your way to "your events"
                              <br> and begin adding the events
                              <br> you desire.
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
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
  <!-- PHP error messages if something went wrong-->
<?php if (isset($_GET['event'])) {
     $msg = base64_decode($_GET['event']);
     if ($msg!="") {
         echo "<p style='color:blue; border:2px red solid; padding-left:10px;'>$msg</p>";
     }
 } elseif (isset($_GET['eventS'])) {    // success message/notification
     $msg = base64_decode($_GET['eventS']);
     if ($msg!="") {
         echo "<p style='color:blue; border:2px green solid; padding-left:10px;'>$msg</p>";
     }
 } ?>
  <!--Form to enter information relating to adding an event -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>Event Form</h1>
                <p> Fill out the form below to add your event</p>
                <!-- includes add-event.inc.php on submit and uses method post to send information.-->
                <form action="includes/add-events.inc.php" method ="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" for="eventname">Name of Event</label>
                        <!--client side validation for text input for event name, field is required and min length 1 letter and max 64. Charcters can only be letters and numbers-->
                            <input type = "text" name = "eventname" placeholder="Event name" class="form-control" pattern = "[A-Za-z0-9 ]{1,64}" title = "Field includes invalid characters. Only letters allowed." required/>
                        </div>

                        <div class="col-md-6">
                            <label class="control-label" for="eventtype">Event Category</label>
                            <!--Drop down box for selection of event category -->
                            <select name="types" class="form-control">
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
                        <!--setting of the date and time of event-->
                            <input type="datetime-local" name="dayntime" class="form-control" required/>
                        </div>

      									<div class="col-md-6">
                                <label class="control-label" for="username">Event Organiser</label>
                                <!--Name of event organiser which can not be changed and is also the username of the account posting the event -->
                                <input type = "text" name = "uname" class="form-control" value="<?php echo $_SESSION["u_uid"]?>" readonly>
                          </div>

                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group">
                                  <label class="control-label" for="description">Description</label>
                                  <!-- Text area to enter event description-->
                                  <textarea class="form-control" id="textarea" name="description" rows="6" placeholder="Information about event"></textarea>
                              </div>
                          </div>

                        <div class="col-md-6">
                            <label class="control-label" for="address1">Address1</label>
                            <!--event address information -->
                            <input type = "text" name = "address1" placeholder="101 example road" class="form-control" required />
                        </div>

                        <div class="col-md-6">
                            <label class="control-label" for="address2">Address2</label>
                            <input type = "text" name = "address2" placeholder="Edgbaston" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="city">City</label>
                            <input type = "text" name = "city" placeholder="London" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="postcode">Post Code</label>
                        <!--client side validation for postcode, field is required and must match pattern -->
                              <input type = "text" name = "postcode" placeholder="X10 9UL" class="form-control" pattern="([A-Za-z0-9 ]){7}" title="Enter a valid UK post code in format X10 9UL" required/>
                        </div>
                        <div class="col-md-6"><label>Select an image: </label>
                          <!-- input for the image of event-->
                          <input type="file" name="eventImg" accept="image/*" required/>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <br />
                                <button type = "submit" name ="submit" class="btn btn-default">Add event</button>
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
