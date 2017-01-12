<div class="top-content">
    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><?php echo $title ?></h1>
                    <div class="description">
                        <p>
                            <?php //echo $p ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3><?php echo $h3 ?></h3>
                            <p><?php //echo $p ?></p>
                        </div>
                        <div class="form-top-right" id="icon_lock_status">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form class="register-form" name="form" id="form">
                            <a href="<?php echo site_url("login/"); ?>" role="button"  id="home" class="btn btn-danger btn-block btn-lg">Home</a>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>