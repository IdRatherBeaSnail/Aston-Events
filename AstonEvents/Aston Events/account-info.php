<?php
include_once("header.php");
include_once("includes/dbh.php");
// if user is not logged in they can not access this page. Redirect to index.php
   if (!isset($_SESSION['u_id'])) {
       header("Location: ../index.php");
       die();
   }
 // access user information based on ID in database to display previous email on page
       $id  = $_SESSION['u_id'];
       $query = ("SELECT user_email FROM users WHERE user_id='$id'");
       $res = mysqli_query($conn, $query);
       $row= mysqli_fetch_array($res);
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

      <!--  js scripts -->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/menumaker.js"></script>
      <script src="js/jquery.sticky.js"></script>
      <script src="js/sticky-header.js"></script>
  </head>
  <body>
    <!-- Page header with image -->
        <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="page-caption">
                            <h2 class="page-title">Edit Account</h2>
                            <div class="page-breadcrumb">
                                <ol class="breadcrumb">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Edit Details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container">
<!--PHP error/success messages based on issue or lack of -->
<?php if (isset($_GET['error'])) {
     $msg = base64_decode($_GET['error']);
     if ($msg!="") {
         echo "<p style='color:blue; border:2px red solid; padding-left:10px;'>$msg</p>";
     }
 } // if no errors and editing account info was success echo message
 elseif (isset($_GET['success'])) {
     $msg = base64_decode($_GET['success']);
     if ($msg!="") {
         echo "<p style='color:blue; border:2px green solid; padding-left:10px;'>$msg</p>";
     }
 } ?>
  <!-- Information box on the left with social media links which direct to current aston events -->
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
      <!-- Form to enter new account details -->
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
             <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <h1>EDIT ACCOUNT DETAILS</h1>
                      <p> Fill out the form below to alter your account details</p>
              <!--Calls edit-accounts.inc.php -->
                      <form action="includes/edit-account.inc.php" method ="POST">
                   <div class="row">
                      <div class="col-md-6">
                        <label class="control-label" for="currentEmail">Current Email</label>
                        <!--pre0fill input field with current email and make it readonly so no changes can be made to it-->
                        <input type = "email" name = "email"  class="form-control" value="<?php echo $row[0];?>"  readonly/>
                      </div>

                      <div class="col-md-6">
                        <label class="control-label" for="newEmail">New Email</label>
                        <!--client side validation for email input , must contain @ symbol. Also ending of email needs to match pattern-->
                        <input type = "email" name = "newEmail" placeholder="example@gmail.com" class="form-control" pattern=".+(\.com|\.co.uk|\.org|\.ac\.uk|\.edu)" title="Email must end in either .com,.co.uk,.org,.ac.uk,.edu" />
                      </div>

                      <div class="col-md-6">
                        <label class="control-label" for="newPassword">New Password</label>
                        <!--client side validation for password,  must match pattern, must contain 1 uppercase letter, 1 lowercase letter, 1 number and atleast 8 characters minium -->
                        <input type = "password" name = "newPwd" placeholder="Password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" />
                      </div>
                      <div class="col-md-6">
                        <label class="control-label" for="confirmPassword">Comfirm new Password</label>
                        <!--client side validation for password,  must match pattern, must contain 1 uppercase letter, 1 lowercase letter, 1 number and atleast 8 characters minium -->
                        <input type = "password" name = "confirmPwd" placeholder="Password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" />
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                            <br />
                            <button type = "submit" name ="submit" class="btn btn-default">Save Changes</button>
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
