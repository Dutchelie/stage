<html>
    <head>
        <link href="<?php echo asset_url("css/bootstrap.css") ?>" rel="stylesheet">
    </head>
    <body>
        <div class="row">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Hi. <?php //echo $h4 ?></h4>
                    </div>
                    <div class="modal-body">
                        Klik op de link hieronder om uw nieuwe wachtwoord te maken.
                    </div>
                    <div class="modal-footer">
                        <?php 
                            //echo $encryptcode
                        ?>
                        <a href="<?php echo site_url('herstel/?hash='. $encryptcode)?>" class="btn btn-primary">Confirm Now</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
