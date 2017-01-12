<html>
    <head>
        <link href="<?php echo asset_url("css/bootstrap.css") ?>" rel="stylesheet">
    </head>
    <body>
        <div class="row">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Hi <?php echo $name["firstname"] ?>.</h4>
                    </div>
                    <div class="modal-body">
                        Bedankt dat u een account heeft gemaakt bij onze website!
                    </div>
                    <div class="modal-footer">
                        Klik op de button hieronder om nu in te loggen.
                        <a href="<?php echo site_url("login/"); ?>" role="button"  id="home" class="btn btn-danger btn-block btn-lg">Home</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>