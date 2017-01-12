<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title ?></title>
        <link rel="shortcut icon" href="<?php echo asset_url("img/ico/favicon.ico") ?>">
        
        <link href="<?php echo asset_url("css/bootstrap.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/font-awesome.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/login.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/daterangepicker/daterangepicker.css") ?>" rel="stylesheet">
        
        <script src="<?php echo asset_url("js/jquery/jquery.js") ?>"></script>
        <script src="<?php echo asset_url("js/daterangepicker/moment.min.js") ?>"></script>
        
        <script src="<?php echo asset_url("js/bootstrap.js") ?>"></script>
        <script src="<?php echo asset_url("js/backstretch/jquery.backstretch.min.js") ?>"></script>
        <script src="<?php echo asset_url("js/daterangepicker/daterangepicker.js") ?>"></script>
        <script src="<?php echo asset_url("js/countdown/jquery.countdown.js") ?>"></script>
        <script src='https://www.google.com/recaptcha/api.js?hl=nl'></script>
      
    </head>
    <body>
        <script>
            $(function () {
                $.backstretch([
                    "<?php echo asset_url("img/backgrounds/1.jpg") ?>",
                     "<?php echo asset_url("img/backgrounds/2.jpg") ?>",
                      "<?php echo asset_url("img/backgrounds/3.jpg") ?>"
                ], {duration: 3000, fade: 750});
            });
        </script>