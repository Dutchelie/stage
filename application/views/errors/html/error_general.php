<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $heading ?></title>
        <?php var_dump('test');?>
        <link href="<?php echo asset_url("css/bootstrap.css") ?>" rel="stylesheet">
        <?php var_dump('test');?>
        <script src="<?php echo asset_url("js/jquery/jquery.js") ?>"></script>
        <script src="<?php echo asset_url("js/bootstrap.js") ?>"></script>
        <style type="text/css">
            .center {text-align: center; margin-left: auto; margin-right: auto; margin-bottom: auto; margin-top: auto;}
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="hero-unit center">
                        <h1><?php echo $message; ?></h1>
                        <br />
                        <p>De door u opgevraagde pagina kon niet worden gevonden, neem dan contact op met uw webmaster of probeer het opnieuw</p>
                       <a onclick="history.back(-1)" class="btn btn-large btn-info"><i class="icon-home icon-white"></i> Terug</a>
                        <a href="<?php echo site_url() ?>" class="btn btn-large btn-info"><i class="icon-home icon-white"></i> Home</a>
                    </div>
                 
                </div>
            </div>
        </div>
    </body>
</html>