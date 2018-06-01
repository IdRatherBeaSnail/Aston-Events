<?php include_once("header.php"); ?>
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
  <!-- header of page with image-->
      <div class="page-header">
          <div class="container">
              <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="page-caption">
                          <h2 class="page-title">Sign up</h2>
                          <div class="page-breadcrumb">
                              <ol class="breadcrumb">
                                  <li><a href="index.php">Home</a></li>
                                  <li class="active">Sign up</li>
                              </ol>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- side box with information on becoming organiser-->
      <div class="content">
          <div class="container">
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
  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <!-- gets information from url matching msg and if it is not null prints the message out onto screen after decoding -->
  <?php
  if (isset($_GET['signup'])) {
      $msg = base64_decode($_GET['signup']);
      if ($msg!="") {
          echo "<p style='color:blue; border:2px red solid; padding-left:10px;'>$msg</p>";
      }
  } elseif (isset($_GET['signupS'])) {
      $msg = base64_decode($_GET['signupS']);
      if ($msg!="") {
          echo "<p style='color:blue; border:2px green solid; padding-left:10px;'>$msg</p>";
      }
  } ?>
  <!-- signup form -->
      <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <h1>Registration Form</h1>
              <p> Please complete the form below to register as an event organiser</p>
              <form action="includes/signup.inc.php" method ="POST">
                  <div class="row">
                      <div class="col-md-6">
                          <label class="control-label" for="firstname">First name</label>
                      <!--client side validation for text input for first name, field is required and min length 1 letter and max 32. Charcters can only be letters-->
                          <input type = "text" name = "first" placeholder="Firstname"  class="form-control" pattern = "[A-Za-z]{1,32}" title = "Field includes invalid characters. Only letters allowed." required />
                      </div>
                      <div class="col-md-6">
                          <label class="control-label" for="lastname">Last name</label>
                      <!--client side validation for text input for surname name, field is required and min length 1 letter and max 32. Charcters can only be letters-->
                          <input type = "text" name = "last" placeholder="Lastname" class="form-control" pattern = "[A-Za-z]{1,32}" title = "Field includes invalid characters. Only letters allowed." />
                      </div>
                      <div class="col-md-6">
                          <label class="control-label" for="email">Email</label>
                      <!--client side validation for email input , field is required and must contain @ symbol. Also ending of email needs to match pattern-->
                            <input type = "email" name = "email" placeholder="example@gmail.com" class="form-control" pattern=".+(\.com|\.co.uk|\.org|\.ac\.uk|\.edu)" title="Email must end in either .com,.co.uk,.org,.ac.uk,.edu"required/>
                      </div>
                      <div class="col-md-6">
                          <label class="control-label" for="username">Username</label>
                          <input type = "text" name = "uid" placeholder="Username" class="form-control" required minlength="3" maxlength="16"/>
                      </div>
                      <div class="col-md-6">
                          <label class="control-label" for="password">Password</label>
                      <!--client side validation for password, field is required and must match pattern, must contain 1 uppercase letter, 1 lowercase letter, 1 number and atleast 8 characters minium -->
                            <input type = "password" name = "pwd" placeholder="Password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required/>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <button type = "submit" name ="submit" class="btn btn-default">Sign up</button>
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
