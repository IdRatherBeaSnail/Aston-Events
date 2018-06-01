<?php
// begins session
session_start();
//checks if submit has been pressed
if (isset($_POST['submit'])) {
    // database connection
    include_once 'dbh.php';

    // stops sql injection
    $email = mysqli_real_escape_string($conn, $_POST['newEmail']); /*input into text, incase code is written into input box */
    $newPass = mysqli_real_escape_string($conn, $_POST['newPwd']); /*input into text, incase code is written into input box */
    $confirmPass = mysqli_real_escape_string($conn, $_POST['confirmPwd']); /*input into text, incase code is written into input box */
    $id = $_SESSION['u_id'];

    /* error handlers*/
    // checks if the email is invalid and field is not empty
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Please enter a valid email";
        $msgEncoded = base64_encode($msg);
        header("Location: ../account-info.php?error=$msgEncoded");
        exit();
    } else {
        // checks if email already exists
        $sqlEmail = "SELECT * FROM users WHERE user_email = '$email' ";
        $resultEmail = mysqli_query($conn, $sqlEmail);
        $resultCheckEmail = mysqli_num_rows($resultEmail);
        // email check
        if ($resultCheckEmail > 0) {
            $msg = "Email already taken, please use a different Email";
            $msgEncoded = base64_encode($msg);
            header("Location: ../account-info.php?error=$msgEncoded");
            exit();
        } else {
            // check if new passwords match each other
            if ($newPass != $confirmPass) {
                $msg = "Passwords do not match!";
                $msgEncoded = base64_encode($msg);
                header("Location: ../account-info.php?error=$msgEncoded");
                exit();
            }
            // checking which fields were filled and which need to be updated
            else {
                if ($newPass == "" && $email != "") {
                    // insert update into the database
                    $sql = "UPDATE users SET user_email = '$email' WHERE user_id='$id'";
                    mysqli_query($conn, $sql);
                    $msg = "You have successfully updated your Email address!";
                    $msgEncoded = base64_encode($msg);
                    header("Location: ../account-info.php?success=$msgEncoded");
                    exit();
                } elseif ($newPass != "" && $email == "") {
                    $hashedPwd = password_hash($newPass, PASSWORD_DEFAULT);
                    // insert update into the database
                    $sql = "UPDATE users SET user_pwd = '$hashedPwd' WHERE user_id='$id'";
                    mysqli_query($conn, $sql);
                    $msg = "You have successfully updated your password!";
                    $msgEncoded = base64_encode($msg);
                    header("Location: ../account-info.php?success=$msgEncoded");
                    exit();
                } elseif ($newPass == "" && $email == "") {
                    // if nothing is entered redirect to the same page
                    header("Location: ../account-info.php");
                    exit();
                } else {
                    $hashedPwd = password_hash($newPass, PASSWORD_DEFAULT);
                    // insert update into the database
                    $sql = "UPDATE users SET user_pwd = '$hashedPwd', user_email = '$email' WHERE user_id='$id'";
                    mysqli_query($conn, $sql);
                    $msg = "You have successfully updated your account information!";
                    $msgEncoded = base64_encode($msg);
                    header("Location: ../account-info.php?success=$msgEncoded");
                    exit();
                }
            }
        }
    }
} // else if all fails redirect to sign up page
else {
    header("Location: ../signup.php");
    exit();
}
