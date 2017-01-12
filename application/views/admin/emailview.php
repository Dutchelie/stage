<html>
    <head>
        <link href="<?php echo asset_url("css/bootstrap.css") ?>" rel="stylesheet">
    </head>
    <body>
        <div class="row">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Hi <?php echo $h4 ?>.</h4>
                    </div>
                    <div class="modal-body">
                        Dit is de laatste stap voor het maken van uw account.
                    </div>
                    <div class="modal-footer">
                        <?php 
                            $this->session->userdata("encryptcode");
                        ?>
                        
                        <a href="<?php echo site_url('wachtwoord/?hash='. $this->session->userdata("encryptcode"))?>" class="btn btn-primary">Confirm Now</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
