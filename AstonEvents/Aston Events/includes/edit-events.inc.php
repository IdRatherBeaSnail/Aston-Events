<?php
session_start();

 if (isset($_POST['submit'])) {
     include_once 'dbh.php';
     // defining variables and stopping sql injection
     $newName         = mysqli_real_escape_string($conn, $_POST['newEventName']);
     $id  	          = mysqli_real_escape_string($conn, $_POST['eventId']);
     $newType  	      = mysqli_real_escape_string($conn, $_POST['newTypes']);
     $newDate         = mysqli_real_escape_string($conn, $_POST['newDaynTime']);
     $newUnameCheck   = mysqli_real_escape_string($conn, $_POST['uname']);
     $newDescription  = mysqli_real_escape_string($conn, $_POST['newDescription']);
     $newAddress1     = mysqli_real_escape_string($conn, $_POST['newAddress1']);
     $newAddress2  	  = mysqli_real_escape_string($conn, $_POST['newAddress2']);
     $newPostcode     = mysqli_real_escape_string($conn, $_POST['newPostcode']);
     $newCity  	      = mysqli_real_escape_string($conn, $_POST['newCity']);
     // add slashes to stop sql injection
     $newImage        = addslashes($_FILES['newEventImg']['tmp_name']);   // temp name of the file
     $imageSize       = addslashes($_FILES['newEventImg']['size']);  // size of file uploaded
     $imageType       = addslashes($_FILES['newEventImg']['type']);  // type of file uploaded
     $newImage        = file_get_contents($newImage);   // retrieve contents of image
     $newImage        = base64_encode($newImage);   // encode image upload
     $maxsize         = 2097152;        // max size of file uploade
     $acceptable      = array(         // array of acceptable image types
           'image/jpeg',
           'image/jpg',
           'image/png'
     );

     /* error handlers*/
     // check for empty fields
     if (empty($newName) || empty($newType) || empty($newDate) || empty($newUnameCheck) || empty($newDescription) || empty($newAddress1) || empty($newAddress2) || empty($newCity) || empty($newPostcode) || empty($newImage)) {
         $msg = "You left one or more fields empty please try again.";
         $msgEncoded = base64_encode($msg);
         header("Location: ../your-events.php?event=$msgEncoded");
         exit();
     } else {
         // checks whether or not the event organisor input = account name
         if ($_SESSION['u_uid'] !== $newUnameCheck) {
             $msg = "Event organisor does not match username of account";
             $msgEncoded = base64_encode($msg);
             header("Location: ../your-events.php?event=$msgEncoded");
             exit();
         } else {
             // checks if input characters are valid for UK postcode
             if (!preg_match('#^(GIR ?0AA|[A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]([0-9ABEHMNPRV-Y])?)|[0-9][A-HJKPS-UW]) ?[0-9][ABD-HJLNP-UW-Z]{2})$#', $newPostcode)) {
                 $msg = "You did not enter a valid UK post code (in format A12 3BC) please try again.";
                 $msgEncoded = base64_encode($msg);
                 header("Location: ../your-events.php?event=$msgEncoded");
                 exit();
             } else {
                 // checks if file size is 2mb
                 if (($imageSize >= $maxsize) || ($imageSize == 0)) {
                     $msg = "File size is above 2mb , please try again.";
                     $msgEncoded = base64_encode($msg);
                     header("Location: ../your-events.php?event=$msgEncoded");
                     exit();
                 } else {
                     // checks the type of file uplaoded and if it matches values defined
                     if ((!in_array($imageType, $acceptable)) && (!empty($imageType))) {
                         $msg = "File type of image must be JPG , PNG or JPEG";
                         $msgEncoded = base64_encode($msg);
                         header("Location: ../your-events.php?event=$msgEncoded");
                         exit();
                     } else {
                         // update database if successful
                         $sql  = ("UPDATE events SET 							 			event_type='$newType',event_name='$newName',event_date='$newDate',event_description='$newDescription',event_address1='$newAddress1',event_address2='$newAddress2',event_city='$newCity',event_postcode='$newPostcode',event_image='$newImage' WHERE event_id='$id'");
                         $res	 = mysqli_query($conn, $sql);
                         $msg  = "You have successfully updated your event!";
                         $msgEncoded = base64_encode($msg);
                         header("Location: ../your-events.php?eventS=$msgEncoded");
                         exit();
                     }
                 }
             }
         }
     }
 } else {
     header("Location: ../your-events.php");
     exit();
 }
