<!--Dit is het login scherm, hier kan de bezoeker en de admin inloggen.-->
<div class="top-content">
    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><?php echo $title ?></h1>
                    <div class="description">
                        <p>
                            Log in om naar uw persoonlijke pagina te gaan en bekijk welke informatie er op u staat te wachten.
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
                    <!--De input gegevens worden verstuurd naar de index function in Login.php tenzij anders aangegeven.-->
                    <div class="form-bottom">
                        <form class="login-form" id="send" method="POST">
                            <div class="form-group">
                                <input type="text" name="username" required placeholder="Gebruikersnaam of emailadres..." class="form-control input-lg">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" required placeholder="Wachtwoord..." class="form-control input-lg">
                            </div>
                            <button type="submit" class="btn btn-danger btn-block btn-lg" id="login_button">Inloggen</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 social-login">
                    <h3></h3>
                    <div class="social-login-buttons">
                        <a class="btn btn-link-2" href="<?php echo site_url() ?>">
                            <i class="fa fa-home"></i> Home
                        </a>

                        <a class="btn btn-link-2" href="<?php echo site_url('vergeten') ?>">
                            <i class="fa fa-key"></i> Wachtwoord vergeten ?
                        </a>

                        <a class="btn btn-link-2" href="<?php echo site_url('register')?>">
                            <i class="fa fa-registered"></i> Registreren
                        </a>

                        <hr>

                        <a class="btn btn-link-2" href="#">
                            <i class="fa fa-facebook"></i> Facebook
                        </a>
                        <a class="btn btn-link-2" href="#">
                            <i class="fa fa-twitter"></i> Twitter
                        </a>
                        <a class="btn btn-link-2" href="#">
                            <i class="fa fa-google-plus"></i> Google Plus
                        </a>

                        <a class="btn btn-link-2" href="#">
                            <i class="fa fa-linkedin"></i> Linkedin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

