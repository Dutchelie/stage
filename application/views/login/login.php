<script>
    $(function () {
        $("#form").submit(function (event) {
            //$("#submitForm").attr("disabled", true);
            event.preventDefault();
            var form = $("#form").serialize();
            //var home_url = "<?php echo site_url(); ?>";
            var user_url = "<?php echo site_url("user/home/"); ?>";
            var admin_url = "<?php echo site_url("admin/home/"); ?>";

            console.log(form);
            $.ajax({
                //url: "<?php //echo site_url('Wachtwoord/equal_password')                ?>",
                type: 'POST',
                dataType: 'json',
                data: form
            })
                    .done(function (json) {
                        console.log(json);
                        $('#title').html("Melding :");
                        $('#result').html(json.response);
                        $('#popup').modal('show');
//                        if (json.response === "fout") {
//                            location.href = home_url;
//                        }
                        if (json.response === "User is ingelogd!") {
                            location.href = user_url;
                        }
                        if (json.response === "Admin is ingelogd!") {
                            location.href = admin_url;
                        }    
                        if (json.response === "Wacht 5 minuten voordat u weer kan inloggen.") {
                            $("#submitForm").attr("disabled", true);
                            var sec = 300;
                            $('#test').append("<p>Wanneer deze tekst weg is en de timer op 0 komt dan kunt u weer inloggen. <span>"+sec+"</span> seconde(n) over.</p>");
                            var timer = setInterval(function(){
                            $('#test span').text(sec--);
                            if (sec === -1) {
                            $('#test').fadeOut('fast');
                            $("#submitForm").attr("disabled", false);
                            clearInterval(timer);
                            }
                            }, 1000);
                        } 
                    })
                    .fail(function (error) {
                        $('#title').html("Melding :");
                        $('#result').html("error:" + error);
                        $('#popup').modal('show');
                    }); 
        });
    });
</script>
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
                        <form class="login-form" naam="form" id="form" method="POST">
                            <div class="form-group">
                                <input type="text" name="username" required placeholder="Gebruikersnaam of emailadres..." class="form-control input-lg">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" required placeholder="Wachtwoord..." class="form-control input-lg">
                            </div>
                            <?php add_csrf_token() ?>
                            <button type="submit" name="submitForm" id="submitForm" class="btn btn-danger btn-block btn-lg">Inloggen</button>
                        </form>
                        <div id="test"></div>
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

                        <a class="btn btn-link-2" href="<?php echo site_url('register') ?>">
                            <i class="fa fa-registered"></i> Registreren
                        </a>

                        <hr>

                        <a class="btn btn-link-2" href="#">
                            <i class="fa fa-facebook"></i> Facebook
                        </a>
                        <a class="btn btn-link-2" href="<?php echo site_url('twitter') ?>">
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
<div class="modal fade" id="popup" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="title" style="color: red">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="result" style="color: red">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

