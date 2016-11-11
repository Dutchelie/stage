<div class="top-content">
    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><?php echo $title ?></h1>
                    <div class="description">
                        <p>
                            Maak uw nieuwe password.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3><?php echo $h3 ?></h3>
                            <p><?php echo $p ?></p>
                        </div>
                        <div class="form-top-right" id="icon_lock_status">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                    <!--Hier word de Code die de user heeft gekregen gebruikt om het account te activeren.-->
                    <div class="form-bottom">
                        <form class="register-form" id="send" method="POST">
                            <div class="form-group">
                                <input type="text" name="emailaddress" required placeholder="uwemailaddress@voorbeeld.com..." class="form-control input-lg">
                            </div>
                            <div class="form-group">
                                <input type="password" name="newpassword" required placeholder="Old Password..." class="form-control input-lg">
                            </div>
                            <div class="form-group">
                                <input type="password" name="repeatpassword" required placeholder="New Password..." class="form-control input-lg">
                            </div>
                            <button type="submit" class="btn btn-danger btn-block btn-lg" id="login_button">Verbeter Password.</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>