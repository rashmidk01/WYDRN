<?php

/**
 * Sends an email to the user with a link to view the form to reset their password.
 * @version    PHP 8.0.12 
 * @since      June 2022
 * @author     AtharvaShah
 */

session_start();
if (empty($_SESSION)) {
    header("Location: login.php");
}
require "header.php";
require "connection.php";
require "functions.php";



$user_data = check_login($con);
$usermail = $user_data['email'];
$username = $user_data['user_name'];


if (check_verified_status($username) == 0) {
    if (mailer_verify_email($usermail)) {
        echo "<p class='alert alert-success w-25 text-center'>Email sent!</p>";
    } else {
        $email_error = "<center><div class='alert alert-danger w-25 text-center' style='position: absolute;
                                    top: 50px; left: 570px;' role='alert'>
                                      Could not send the email!
                                    </div></center>";
        echo $email_error;
    }
} else {
    echo "<br><p class='alert alert-danger w-25 text-center'>User is already Verified.</p>";
}

if (isset($_GET['link'])) {
    $user_data = check_login($con);
    $username = $user_data['user_name'];
    // echo $username;
    // echo $_GET['link'];

    if ($_GET['link'] == md5($user_data['user_name'])) {
        $sql = "UPDATE users SET `verified` = '1' WHERE user_name='$username'";
        if (mysqli_query($con, $sql)) {
            echo ("<p class='alert alert-success w-25 text-center'>
            Account Verified. 
            <a href='profile.php'>Click here</a> to visit your profile.
            </p>");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    } else {
        echo ("Invalid Link. Your account remains unverified.");
    }

}
mysqli_close($con);
