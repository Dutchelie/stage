<script type="text/javascript">

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
                type: 'POST',
                dataType: 'json',
                data: form
            })
                    .done(function (json) {
                       console.log(json);
                       $('#title').html("Melding :");
                       $('#result').html(json.response);
                       $('#popup').modal('show');
                       if (json.response === "Er is een mail naar u toegestuurd.") location.href = site_url;
                    }) 
                    .fail(function (error) {
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
                    <div class="form-bottom">
                        <form class="register-form" name="form" id="form" method="POST">
                            <div class="form-group">
                                <input type="text" name="emailaddress" required placeholder="uwemailaddress@voorbeeld.com..." class="form-control input-lg">
                            </div>
<!--                            <div class="form-group">
                                <input type="password" name="oldpassword" required placeholder="current Password..." class="form-control input-lg">
                            </div>
                            <div class="form-group">
                                <input type="password" name="newpassword" required placeholder="New Password..." class="form-control input-lg">
                            </div>-->
                            <button type="submit" id="submitForm" class="btn btn-danger btn-block btn-lg" id="login_button">Verbeter Password.</button>
                            <?php echo add_csrf_token();?>
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