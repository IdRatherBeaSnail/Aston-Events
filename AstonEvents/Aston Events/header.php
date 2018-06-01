<?php
session_start();
?>
<!-- actually header/nav bar on all pages -->
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<header>
	  <div class="header">
			<div class="container">
				<div class="row">
          <div class ="nav-login">

						<?php
                     

              // if user is logged in show logout button
              if (isset($_SESSION['u_id'])) {
                  echo '
												<form  action="includes/logout.php" method="POST">
												<span class = "goldenU"> Username : '.ucfirst($_SESSION["u_uid"]).'</span>
													<button class = "logout" type = "submit" name = "submit">Logout</button>
												</form>
												';
              } else { // if user is not logged in show log in form
                  echo '<form action = "includes/login.php" method ="POST">
									         <input type = "text" name ="uid" placeholder ="Username/e-mail" required/>
									         <input type = "password" name ="pwd" placeholder ="password" required/>
							             <button type = "submit" name = "submit">Login</button>
							          </form>
							          <a href="signup.php">Sign up</a>';
              }?>
          </div>
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<a href="index.php"><img src="images/logo.png" alt=""></a>
					</div>
					<div class="col-lg-8 col-md-4 col-sm-12 col-xs-12">
						<div class="navigation">
							<div id="navigation">
								<ul>
									<li class="active"><a href="index.php" title="Home">Home</a></li>
									<li class="has-sub"><a href="student-events.php" title="Events ">Events</a>
										<ul>
											<li><a href="student-events.php" title="Events">Upcoming Events</a></li>
											<li><a href="student-expired.php" title="Missed Events">Events You Missed</a></li>
											<li><a href="student-popular.php" title="Most Popular">Most Popular</a></li>
											<li><a href="student-category.php" title="Categotry">Order by Category</a></li>
										</ul>
									</li>
									<?php
                                    // if user is loged in show them organiser options
                      if (isset($_SESSION['u_id'])) {
                          echo '<li class="has-sub"><a href="your-events.php" title="Your Events">Your Events</a>
															<ul>
																<li><a href="add-events.php" title="Add Events">Add Event</a></li>
																<li><a href="your-events.php" title="Your Events ">View Your Events</a></li>
													 		</ul>
												 </li>
												 <li class="active"><a href="account-info.php" title="Account">Account</a></li>';
                      }
                        ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</header>
