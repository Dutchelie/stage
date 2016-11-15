<script type="text/javascript">

//    $(function () {
//        $("#password")            
////            .on("password.popover", -> $(this).css(maxWidth: "500px"))
//            .popover({
//            title: 'Wachtwoord Voorwaarden', 
//            content: "  Minimaal 5 kleine letters, \n\
//                        1 Hoofdletter, \n\
//                        1 Cijfer, \n\
//                        1 speciaal teken."
//            //templateCss: '<div style="width: 500px; background-color: red;"></div>'
//        });
//        //$("popover").css("background-color", "red");
//    });

    $(function () {
        $("#form").submit(function (event) {
            $("#submitForm").attr("disabled", true);
            event.preventDefault();
            var form = $("#form").serialize();
            var site_url = "<?php echo site_url("login/"); ?>";
//            var pw = $("#password").val();
//            var repeatpw = $("#repeatpassword").val();
            console.log(form);
            $.ajax({
                //url: "<?php //echo site_url('Wachtwoord/equal_password')   ?>",
                type: 'POST',
                dataType: 'json',
                data: form
            })
                    .done(function (json) {
                        console.log(json);
                        $('#title').html("Melding :");
                        $('#result').html(json.response);
                        $('#popup').modal('show');
                        if (json.response === "Wachtwoord gemaakt.")
                            location.href = site_url;
                    })
                    .fail(function (error) {
                        $('#title').html("Melding :");
                        $('#result').html("error:" + error);
                        $('#popup').modal('show');
                    })
                    .always(function () {
                        $("#submitForm").attr("disabled", false);
                    });
        });
    });
</script>
<div class="top-content">
    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><?php echo $title ?></h1>
                    <div class="description">
                        <p>
                            Maak een wachtwoord aan zodat uw account veilig is.
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
                    <!--De input gegevens worden verstuurd naar de index function in Register.php tenzij anders aangegeven.-->
                    <div class="form-bottom">
                        <!--                        action="http://localhost/musemaps.nl/wachtwoord/"-->
                        <form class="register-form" name="form" id="form" method="POST">
                            <div class="form-group">
                                <p>Wachtwoord Voorwaarden:</p>
                                <p>5 kleine letters</p>
                                <p>1 hoofdletter</p>
                                <p>1 cijfer</p>
                                <p>1 speciaal teken</p>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" required placeholder="password..." class="form-control input-lg">
                            </div>
                            <div class="checkbox">
                                <label><input id="showhide" type="checkbox" value="">Wachtwoord laten zien.</label>
                            </div>    
                            <div class="form-group">
                                <input type="password" name="repeatpassword" id="repeatpassword" required placeholder="herhaal password..." class="form-control input-lg">
                            </div>
                            <?php echo add_csrf_token(); ?>
                            <button type="submit" class="btn btn-danger btn-block btn-lg" id="submit">Registreer Wachtwoord</button>
                        </form>
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
