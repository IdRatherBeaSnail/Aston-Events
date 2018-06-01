<?php

if (isset($_POST['submit'])) {
    include_once 'dbh.php';
    // stops sql injection
    $first = mysqli_real_escape_string($conn, $_POST['first']); /*input into text, incase code is written into input box */
    $last = mysqli_real_escape_string($conn, $_POST['last']); /*input into text, incase code is written into input box */
    $email = mysqli_real_escape_string($conn, $_POST['email']); /*input into text, incase code is written into input box */
    $uid = mysqli_real_escape_string($conn, $_POST['uid']); /*input into text, incase code is written into input box */
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']); /*input into text, incase code is written into input box */

    /* error handlers*/
    // check for empty fields
    if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd)) {
        header("Location: ../signup.php?signup=empty");
        exit();
    } else {
        // checks if input characters are valid for first and last name
        if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
            header("Location: ../signup.php?signup=invalid");
            exit();
        } else {
            // checks if the email is invalid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../signup.php?signup=email");
                exit();
            } else {
                // checks if username or email  already exists
                $sqlName = "SELECT * FROM users WHERE user_uname = '$uid' ";
                $sqlEmail = "SELECT * FROM users WHERE user_email = '$email' ";
                $resultName = mysqli_query($conn, $sqlName);
                $resultEmail = mysqli_query($conn, $sqlEmail);
                $resultCheckName = mysqli_num_rows($resultName);
                $resultCheckEmail = mysqli_num_rows($resultEmail);
                // user check
                if ($resultCheckName > 0) {
                    $msg = "This username already exists, please choose another";
                    // encodes message so it cant be seen in url
                    $msgEncoded = base64_encode($msg);
                    header("Location: ../signup.php?signup=$msgEncoded");
                    exit();
                // email check
                } elseif ($resultCheckEmail > 0) {
                    $msg = "Email already taken, please use a different Email";
                    $msgEncoded = base64_encode($msg);
                    header("Location: ../signup.php?signup=$msgEncoded");
                    exit();
                } else {
                    // hash Password
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                    // insert user into the database
                    $sql = "INSERT INTO users (user_fname , user_sname , user_uname , user_email , user_pwd) VALUES ('$first','$last','$uid','$email','$hashedPwd');";
                    mysqli_query($conn, $sql);
                    $msg = "You have successfully made an account! Login now!";
                    $msgEncoded = base64_encode($msg);
                    header("Location: ../signup.php?signupS=$msgEncoded");
                    exit();
                }
            }
        }
    }
} else {
    header("Location: ../signup.php");
    exit();
}
