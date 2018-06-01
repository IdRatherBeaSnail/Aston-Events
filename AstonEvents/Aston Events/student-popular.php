<!DOCTYPE html>
<?php
include_once("header.php");
include_once('includes/dbh.php');

// set value of cookie based on like button and event id
if (isset($_GET['like'])) {
    $id = $_GET['like'];
    setcookie("Like", $_COOKIE['Like'] = $id, time()+60*60*24*5, "/");
    $sqll = ("UPDATE events SET event_likes= event_likes+1 WHERE event_id='$id'");
    $ress = mysqli_query($conn, $sqll);
	header("Location: student-popular.php");
}

?>
<html lang="en">

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
                        <h2 class="page-title">Most Popular</h2>
                        <div class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li><a href="index.php">Home</a></li>
                                <li class="active">Events</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
              <?php
              // pagination for events
              $start = 0;
              $limit = 6;
              if (isset($_GET['page'])) {
                  $pageId=$_GET['page'];
                  $start = ($pageId-1)*$limit;
              } else {
                  $pageId = 1;
              }

              // select relevant event data and order by most likes where the date of event is greater than now()
              $res = mysqli_query($conn, "SELECT events.event_id,events.event_type,events.event_name,events.event_date,events.event_description,events.event_address1,events.event_address2,events.event_city,events.event_postcode,events.event_likes,events.event_image,users.user_uname,users.user_email FROM events INNER JOIN users ON events.user_uname = users.user_id WHERE events.event_date >= NOW() ORDER BY events.event_likes DESC LIMIT $start,$limit");

              $pagesQuery = mysqli_query($conn, "SELECT * FROM events WHERE events.event_date >= NOW()");
              $total = mysqli_num_rows($pagesQuery);
              $pages = ceil($total/$limit);
              // while still rows in $res
              while ($row=mysqli_fetch_array($res)) {
                  $time = strtotime($row['event_date']);
                  $timeFormat = date("d/m/y g:i A", $time);
                  echo '
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="post-block">
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="post-img">
                                  <img src="data:image;base64,'.$row['event_image'].'" class="img-responsive" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="post-content">
                                    <h2 class="title" target="_blank">'.ucfirst($row['event_name']).'</h2>
                                    <p class="meta">
                                        <span class="golden"> Event Date: '.$timeFormat.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        <span class="golden"> Likes : '.$row['event_likes'].'</span>
                                        <br/>
                                        <span class="golden">Event Category : '.ucfirst($row['event_type']).'</span>
                                        <br/>
                                        <span class="golden">Organiser : '.ucfirst($row['user_uname']).'</span>
                                        <br />
                                        <a class="golden" href="mailto:'.ucfirst($row['user_email']).'">Contact : '.ucfirst($row['user_email']).'</a>
                                        <br />
                                        <span class = "golden"> Address of event :'.$row['event_address1'].', '.$row['event_address2'].', '.$row['event_city'].', '.$row['event_postcode'].'</span>
                                    </p>
                                    <p><strong><u>Event Description</u></strong> <br />'.$row['event_description'].'</p> ';
                  // change like button based on if cookie has been set and value of cookie
                  if (isset($_COOKIE['Like']) && $_COOKIE['Like'] == $row['event_id']) {
                      echo '<a href="student-popular.php" class="btn btn-primary btn-xs">Liked</a>';
                  } else {
                      echo '<a href="student-popular.php?like='.$row['event_id'].'" class="btn btn-default" name = "like">Like</a>
                                  ';
                  }
                  echo '</div>
                            </div>
                        </div>
                    </div>
                </div>';
              }
              ?>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="st-pagination">
                    <ul class="pagination">
                      <?php
                      // pagination navigation
                      if ($pageId > 1) {
                          ?>
                          <li><a href="?page=<?php echo($pageId-1) ; ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                      <?php
                      } ?>
                      <?php  for ($x=1;$x<=$pages;$x++) {
                          ?>
                          <li><a href="?page=<?php echo $x; ?>"><?php echo $x; ?></a></li>
                          <?php
                      } ?>
                          <?php  if ($pageId != $pages) {
                          ?>
                                <li><a href="?page=<?php echo($pageId+1); ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                          <?php
                      } ?>
                </ul>
              </div>
          </div>
        </div>
    </div>
</body>

</html>
