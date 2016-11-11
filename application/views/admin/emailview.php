<html>
    <head>
        <link href="<?php echo asset_url("css/bootstrap.css") ?>" rel="stylesheet">
    </head>
    <body>
        <div class="row">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Hi <?php echo $h4 ?></h4>
                    </div>
                    <div class="modal-body">
                        This is your final step to complete your registration.
                        Please confirm you email address by clicking on the button below.
                    </div>
                    <div class="modal-footer">
                        <?php 
                            echo $encryptcode
                        ?>
                        
                        <a href="<?php echo site_url('wachtwoord/?hash='. $encryptcode)?>" class="btn btn-primary">Confirm Now</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
