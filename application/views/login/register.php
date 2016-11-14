<script type="text/javascript">
    $(function () {
        $('input[name="birthday"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "locale": {
                format: "DD-MM-YYYY",
                daysOfWeek: ["Zo", "Ma", "Di", "Wo", "Do", "Vr", "Za"],
                monthNames: ["Jan", "Feb", "Maa", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
            }
        });
        
        $("#form").submit(function (event) {
            $("#submitForm").attr("disabled", true);
            event.preventDefault();
            var form = $("#form").serialize();
            var site_url = "<?php echo site_url("login"); ?>";
            console.log(form);
            $.ajax({
                url: "<?php echo site_url('Register/check_input') ?>",
                type: 'POST',
                dataType: 'json',
                data: form
            })
                    .done(function (json) {
                        console.log(json);
                        $('#title').html("Melding :");
                        $('#result').html(json.response);
                        $('#popup').modal('show'); 
                        grecaptcha.reset(); 
                        if (json.response === "Er is een mail naar u toegestuurd.") location.href = site_url;
                    }) 
                    .fail(function (error) {
                        console.log(error);
                        $('#title').html("Melding :");
                        $('#result').html("error:" +error);
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
                            Maak een account aan zodat u in kan loggen.
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
<!--                        action="http://localhost/musemaps.nl/register/captcha_check"-->
                        <form class="register-form"name="form" id="form" method="POST">
                            <div class="form-group">
                                <input type="text" name="firstname" id="firstname" required placeholder="Voornaam..." class="form-control input-lg">
                            </div>
                            <div class="form-group">
                                <input type="text" name="lastname" id="lastname" required placeholder="Achternaam..." class="form-control input-lg">
                            </div>
                            <div class="form-group">
                                <input type="text" name="emailaddress" id="emailaddress" required placeholder="voorbeeld@gmail.com..." class="form-control input-lg">
                            </div>
                            <div class="form-group">
                                <label for="birthday">Geboortedatum:</label>
                                <input type="text" class="form-control" name="birthday" required id="birthday" value="01-01-2000" data-toggle="popover" /><br>
                            </div>
                            <div class="checkbox">
                                <label><input name="terms" id="terms" type="checkbox" required>Algemene Voorwaarden.</label>
                            </div>
                            <div class="g-recaptcha" data-sitekey="6Lfp_AoUAAAAACLL26T91aoh7S6_-86DjlO4DLQ9"></div>
                            
                            <?php //echo add_csrf_token();?>
                            <button type="submit" id="submitForm" class="btn btn-danger btn-block btn-lg">Registreren</button>
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
