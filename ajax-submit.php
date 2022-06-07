<?php session_start();

// Include the IconCaptcha classes.
require('./src/captcha-session.class.php');
require('./src/captcha.class.php');

use IconCaptcha\IconCaptcha;

// If the form has been submitted, validate the captcha.
if(!empty($_POST)) {
    if(IconCaptcha::validateSubmission($_POST)) {
        $_SESSION["logined"] = "success";
        echo '<b>Captcha:</b> The form has been submitted!';
        echo '<script>window.location.href="zozo.php"</script>';
    } else {
        echo '<b>Captcha: </b>' . IconCaptcha::getErrorMessage();
    }
} else {
    echo '<b>Captcha:</b> No data posted!';
}
