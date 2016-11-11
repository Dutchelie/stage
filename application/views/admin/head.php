<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title><?php echo $title ?></title>
        <link rel="shortcut icon" href="<?php echo asset_url("img/ico/favicon.ico") ?>">
        <link href="<?php echo asset_url("css/bootstrap.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/font-awesome.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/daterangepicker/daterangepicker.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/select/select.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/select/select2.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/checkbox_radio/checkbox_radio.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/checkbox_radio/switch.min.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/metisMenu/metisMenu.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/datatables/dataTables.bootstrap.min.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/timeline/timeline.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/cropper/cropper.min.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/fullcalendar/fullcalendar.min.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/slider/bootstrap-slider.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/roll_icon/roll_icon.css") ?>" rel="stylesheet">
        <link href="<?php echo asset_url("css/admin.css") ?>" rel="stylesheet">

        <script src="<?php echo asset_url("js/jquery/jquery-3.1.0.min.js") ?>"></script>
        <script src="<?php echo asset_url("js/jquery/jquery-ui.min_sortable.js") ?>"></script>
        <script src="<?php echo asset_url("js/daterangepicker/moment.js") ?>"></script>
        <script src="<?php echo asset_url("js/bootstrap.min.js") ?>"></script>
        <script src="<?php echo asset_url("js/mask/jquery.mask.min.js") ?>"></script>
        <script src="<?php echo asset_url("js/daterangepicker/daterangepicker.js") ?>"></script>
        <script src="<?php echo asset_url("js/select/select.js") ?>"></script>
        <script src="<?php echo asset_url("js/select/select2.js") ?>"></script>
        <script src="<?php echo asset_url("js/metisMenu/metisMenu.js") ?>"></script>
        <script src="<?php echo asset_url("js/checkbox_radio/switch.min.js") ?>"></script>
        <script src="<?php echo asset_url("js/datatables/jquery.dataTables.min.js") ?>"></script>
        <script src="<?php echo asset_url("js/datatables/dataTables.bootstrap.min.js") ?>"></script>
        <script src="<?php echo asset_url("js/highcharts/highcharts.js") ?>"></script> 
        <script src="<?php echo asset_url("ckeditor/ckeditor.js") ?>"></script>
        <script src="<?php echo asset_url("ckfinder/ckfinder.js") ?>"></script>
        <script src="<?php echo asset_url("js/countdown/jquery.countdown.js") ?>"></script>
        <script src="<?php echo asset_url("js/cropper/cropper.min.js") ?>"></script>
        <script src="<?php echo asset_url("js/slider/bootstrap-slider.min.js") ?>"></script> 
        <script src="<?php echo asset_url("js/function.js") ?>"></script>
        <script src="<?php echo asset_url("js/admin.js") ?>"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdY8R5lQPdDO_ffF9WADgbYVsYmpfv3Vw"></script>
        <script src="<?php echo asset_url("js/googlemap.js") ?>"></script>
        <script src="<?php echo asset_url("js/daterangepicker/moment.min.js") ?>"></script>
    </head>

    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url('admin/home') ?>"><?php echo $title ?></a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope fa-fw"></i> (<span id="show_total_new">99</span>) <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            
                                <li>
                                    <a href="#">
                                        <div>
                                            <strong>Dennis</strong>
                                            <span class="pull-right text-muted">
                                                <em>10-10-2016</em>
                                            </span>
                                        </div>
                                        <div>Uitnodiging</div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                         

                            <li>
                                <a class="text-center" href="#">
                                    <strong>Meer bericht</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="<?php echo site_url('admin/user/profile') ?>"><i class="fa fa-user fa-fw"></i> Profiel</a></li>
                            <li><a href="<?php echo site_url("home") ?>"><i class="fa fa-home fa-fw"></i> Home</a></li>
                            <li class="divider"></li>
                            <li><a href="#" data-toggle="modal" data-target="#Modal_logout"><i class="fa fa-sign-out fa-fw"></i> Uitloggen</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li><a href="<?php echo site_url('admin/home') ?>"><i class="fa fa-fw fa-dashboard"></i> Beheerder portal</a></li>
                            <li>
                                <a href="#"><i class="fa fa-fw fa-user"></i> Account<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="<?php echo site_url('admin/user') ?>">Overzicht</a></li>
                                    <li><a href="<?php echo site_url('admin/user/profile') ?>">Profiel</a></li>
                                </ul>
                            </li>
                           
                            <li>
                                <a href="#"><i class="fa fa-fw fa-cogs"></i> Onderhoud<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="<?php echo site_url('admin/applog') ?>">Applog</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div id="page-wrapper">



