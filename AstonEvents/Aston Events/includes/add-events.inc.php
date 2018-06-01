<?php
session_start();

if (isset($_POST['submit'])) {
    include_once 'dbh.php';
    // stops sql injection
    $eventn      = mysqli_real_escape_string($conn, $_POST['eventname']); /*input into text, incase code is written into input box */
    $eventtype   = mysqli_real_escape_string($conn, $_POST['types']); /*input into text, incase code is written into input box */
    $datentime   = mysqli_real_escape_string($conn, $_POST['dayntime']); /*input into text, incase code is written into input box */
    $unameCheck  = mysqli_real_escape_string($conn, $_POST['uname']); /*input into text, incase code is written into input box */
    $uid         = mysqli_real_escape_string($conn, $_SESSION['u_id']); /*input into text, incase code is written into input box */
    $description = mysqli_real_escape_string($conn, $_POST['description']); /*input into text, incase code is written into input box */
    $address1    = mysqli_real_escape_string($conn, $_POST['address1']); /*input into text, incase code is written into input box */
    $address2    = mysqli_real_escape_string($conn, $_POST['address2']); /*input into text, incase code is written into input box */
    $city        = mysqli_real_escape_string($conn, $_POST['city']); /*input into text, incase code is written into input box */
    $postcode    = mysqli_real_escape_string($conn, $_POST['postcode']); /*input into text, incase code is written into input box */
    $imagetype   = addslashes($_FILES['eventImg']['type']); /*adds slashes to stop code being injected into table */
    $image       = addslashes($_FILES['eventImg']['tmp_name']); /*adds slashes to stop code being injected into table */
    $imagesize   = addslashes($_FILES['eventImg']['size']); /*adds slashes to stop code being injected into table */
    $image       = file_get_contents($image);
    $image       = base64_encode($image);
    $maxsize     = 2097152;
    $acceptable  = array(
          'image/jpeg',
          'image/jpg',
          'image/png'
    );

    /* error handlers*/
    // check for empty fields
    if (empty($eventn) || empty($eventtype) || empty($datentime) || empty($unameCheck) || empty($description) || empty($address1) || empty($address2) || empty($city) || empty($postcode) || empty($image)) {
        $msg = "One or more fields have been left empty.";
        $msgEncoded = base64_encode($msg);
        header("Location: ../add-events.php?event=$msgEncoded");
        exit();
    } else {
        // checks whether or not the event organisor input = account name
        if ($_SESSION['u_uid'] !== $unameCheck) {
            $msg = "Event organisor does not match username of account";
            $msgEncoded = base64_encode($msg);
            header("Location: ../add-events.php?event=$msgEncoded");
            exit();
        } else {
            // checks if input characters are valid for UK postcode
            if (!preg_match('#^(GIR ?0AA|[A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]([0-9ABEHMNPRV-Y])?)|[0-9][A-HJKPS-UW]) ?[0-9][ABD-HJLNP-UW-Z]{2})$#', $postcode)) {
                $msg = "Please enter valid UK post code in format A12 3BC.";
                $msgEncoded = base64_encode($msg);
                header("Location: ../add-events.php?event=$msgEncoded");
                exit();
            } else {
                // checks if file size is below 2mb
                if (($imagesize >= $maxsize) || ($imagesize == 0)) {
                    $msg = "File size is above 2mb , please try again.";
                    $msgEncoded = base64_encode($msg);
                    header("Location: ../add-events.php?event=$msgEncoded");
                    exit();
                } else {
                    // checks file type of file being uploaded
                    if ((!in_array($imagetype, $acceptable)) && (!empty($imagetype))) {
                        $msg = "File type of image must be JPG , PNG or JPEG";
                        $msgEncoded = base64_encode($msg);
                        header("Location: ../add-events.php?event=$msgEncoded");
                        exit();
                    } else {
                        // insert event into the table
                        $sql = "INSERT INTO events (event_type,event_name,event_date,event_description,user_uname,event_address1,event_address2,event_city,event_postcode,event_likes,event_image)
                              VALUES ('$eventtype','$eventn','$datentime','$description','$uid','$address1','$address2','$city','$postcode','0','$image')";
                        if ($insert = mysqli_query($conn, $sql)){
                        	$msg = "You have successfully added your event!";
                       	    $msgEncoded = base64_encode($msg);
                        	header("Location: ../add-events.php?eventS=$msgEncoded");
                        exit();
                       	} else {
   						 echo 'MySQL Error: ' . mysqli_error($conn); // this will tell you whats wrong
						}

                        
                    }
                }
            }
        }
    }
} else {
    header("Location: ../add-events.php");
    exit();
}
