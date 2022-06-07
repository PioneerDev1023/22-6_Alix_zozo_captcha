<?php session_start();

    // Include the IconCaptcha classes.
    require('./src/captcha-session.class.php');
    require('./src/captcha.class.php');

    use IconCaptcha\IconCaptcha;

    // Take a look at the README file to see every available option.
    IconCaptcha::options([
        'iconPath' => dirname(__FILE__) . './assets/icons/', // required
        //'themes' => [
        //    'black' => [
        //        'icons' => 'light', // Which icon type should be used: light or dark.
        //        'color' => [20, 20, 20], // Array contains the icon separator border color, as RGB.
        //    ]
        //],
        'messages' => [
            'wrong_icon' => 'You\'ve selected the wrong image.',
            'no_selection' => 'No image has been selected.',
            'empty_form' => 'You\'ve not submitted any form.',
            'invalid_id' => 'The captcha ID was invalid.',
            'form_token' => 'The form token was invalid.'
        ],
        'image' => [
            'amount' => [ // min & max can be 5 - 8
                'min' => 5,
                'max' => 8
            ],
            'rotate' => true,
            'flip' => [
                'horizontally' => true,
                'vertically' => true,
            ],
            'border' => true
        ],
        'attempts' => [
            'amount' => 3,
            'timeout' => 60 // seconds.
        ],
        'token' => true
    ]);

    // If the form has been submitted, validate the captcha.
    if(!empty($_POST)) {
        if(IconCaptcha::validateSubmission($_POST)) {
            $captchaMessage = 'The form has been submitted!';
        } else {
            $captchaMessage = IconCaptcha::getErrorMessage();
        }
    }
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Skatteetaten</title>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=10" />
        <meta name="author" content="Fabian Wennink © <?= date('Y') ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./assets/favicon.ico" rel="shortcut icon" type="image/x-icon" />

        <!-- Country dropdown -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css"> -->
        <link rel="stylesheet" href="./assets/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/xcode.min.css" />
        <link rel="stylesheet" href="./assets/css/bootstrap-select-country.min.css" />

        <!-- JUST FOR THE DEMO PAGE -->
        <link href="./assets/demo.css" rel="stylesheet" type="text/css">
        <script src="./assets/demo.js" type="text/javascript"></script>
        <link href="//fonts.googleapis.com/css?family=Poppins:400,700" rel="stylesheet">

        <!-- Include IconCaptcha stylesheet - REQUIRED -->
        <link href="./assets/css/icon-captcha.min.css" rel="stylesheet" type="text/css">
        <style>
            .bootstrap-select {
                width: unset!important;
            }
            /* .iconcaptcha-modal__footer {
                display:none!important;
            } */
        </style>
    </head>
    <body>
        <div class="container">

            <div class="logo-text">
                <a rel="noopener">
                    <span>Wel</span>come
                </a>
            </div>

            <div class="section">

                <!-- Captcha message placeholder -->
                <p class="message" style="font-size:16px; color: yellow;"></p>

                <!-- The IconCaptcha holder should ALWAYS be placed WITHIN the <form> element -->
                <form action="ajax-submit.php" method="post">

                    <div id="error" style="font-size:16px;margin:auto;width:400px;"></div>

                    <select class="selectpicker countrypicker" id="countryselector" data-flag="true"></select>

                    <!-- Additional security token to prevent CSRF. Optional but highly recommended - disable via IconCaptcha options. -->
                    <input type="hidden" name="_iconcaptcha-token" value="<?= IconCaptcha::token() ?>"/>

                    <!-- The IconCaptcha will be rendered in this element - REQUIRED -->
                    <div class="iconcaptcha-holder" data-theme="light"></div>

                    <!-- Submit button to test your IconCaptcha input -->
                    <input type="submit" value="Submit" class="btn" >
                </form>

            </div>

            <div class="copyright">
                <p>Copyright &copy; <?= date('Y'); ?> Alix Karol - All rights reserved</p>
            </div>
        </div>

        <a href="https://github.com/fabianwennink/IconCaptcha-Plugin-jQuery-PHP/" target="_blank" rel="noopener">
            <div class="corner-ribbon top-left">Skatteetaten</div>
        </a>

        <!-- Country dropdown -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
        <script src="./assets/js/bootstrap-select-country.min.js"></script>

        <!-- Buy Me A Coffee widget - JUST FOR THE DEMO PAGE -->

        <!-- Include IconCaptcha script - REQUIRED -->
        <script src="./assets/js/icon-captcha.min.js" type="text/javascript"></script>

        <!-- Include jQuery Library -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <!-- Include IconCaptcha script - REQUIRED -->
        <script src="./assets/js/icon-captcha.min.js" type="text/javascript"></script>

        <!-- Initialize the IconCaptcha - REQUIRED -->
        <script type="text/javascript">
            $(document).ready(function() {
                $('.iconcaptcha-holder').iconCaptcha({
                    general: {
                        validationPath: './src/captcha-request.php',
                        fontFamily: 'Poppins',
                        credits: 'show',
                    },
                    security: {
                        clickDelay: 500,
                        hoverDetection: true,
                        enableInitialMessage: true,
                        initializeDelay: 500,
                        selectionResetDelay: 3000,
                        loadingAnimationDelay: 1000,
                        invalidateTime: 1000 * 60 * 2,
                    },
                    messages: {
                        initialization: {
                            verify: 'Verify that you are human.',
                            loading: 'Loading challenge...',
                        },
                        header: 'Select the image displayed the <u>least</u> amount of times',
                        correct: 'Verification complete.',
                        incorrect: {
                            title: 'Uh oh.',
                            subtitle: "You've selected the wrong image."
                        },
                        timeout: {
                            title: 'Please wait 60 sec.',
                            subtitle: 'You made too many incorrect selections.'
                        }
                    }
                })
                // .bind('init', function(e) { // You can bind to custom events, in case you want to execute custom code.
                //     console.log('Event: Captcha initialized', e.detail.captchaId);
                // }).bind('selected', function(e) {
                //     console.log('Event: Icon selected', e.detail.captchaId);
                // }).bind('refreshed', function(e) {
                //     console.log('Event: Captcha refreshed', e.detail.captchaId);
                // }).bind('invalidated', function(e) {
                //     console.log('Event: Invalidated', e.detail.captchaId);
                // }).bind('success', function(e) {
                //     console.log('Event: Correct input', e.detail.captchaId);
                // }).bind('error', function(e) {
                //     console.log('Event: Wrong input', e.detail.captchaId);
                // });
            });
        </script>

        <!--
            Script to submit the form(s) with Ajax.

            NOTE: If you want to use FormData instead of .serialize(), make sure to
            include the inputs 'ic-hf-se', 'ic-hf-id' and 'ic-hf-hp' into your FormData object.
            Take a look at the commented code down below.
        -->
        <script type="text/javascript">
            $(document).ready(function() {
                $('form').submit(function(e) {
                    e.preventDefault();

                    var countryName = $('#countryselector').find(":selected").text();
                    if(countryName != 'United Kingdom'&&countryName != 'United States of America'&&countryName != 'France') {
                        console.log(countryName);
                        $("#error").fadeIn(2000, function(){
                            $("#error").html('<div class="alert alert-danger">Sorry. Your country denied to access !</div>');           
                        });
                        $("#error").fadeOut(3000, function(){
                            $("#error").html('');           
                        });
                        exit();
                    }

                    // Get the form element.
                    const form = $(this);

                    // Perform the AJAX call.
                    $.ajax({
                        type: 'POST',
                        url: form.attr('action'),
                        data: form.serialize()
                    }).done(function (data) {
                        $('.message').html(data);
                    }).fail(function () {
                        console.log('Error: Failed to submit form.')
                    });

                    // // FormData example:
                    //
                    // // Get the form element.
                    // const form = $(this);
                    //
                    // // Build the FormData object.
                    // const formData = new FormData();
                    // formData.append('ic-hf-se', form.find('input[name="ic-hf-se"]').val());
                    // formData.append('ic-hf-id', form.find('input[name="ic-hf-id"]').val());
                    // formData.append('ic-hf-hp', form.find('input[name="ic-hf-hp"]').val());
                    //
                    // // Perform the AJAX call.
                    // $.ajax({
                    //     type: 'POST',
                    //     url: form.attr('action'),
                    //     data: formData,
                    //     processData: false,
                    //     contentType: false
                    // }).done(function (data) {
                    //     $('.message').html(data);
                    // }).fail(function () {
                    //     console.log('Error: Failed to submit form.')
                    // });
                });
            });
        </script>
    </body>
</html>
