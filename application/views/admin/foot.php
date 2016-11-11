<div class="row">
    <div class="col-lg-12">
        <p><strong>Bloemendaal Consultancy</strong> &copy; Copyright <?php echo date('Y') ?></p>
    </div> 
</div>
</div>
</div>

<div class="modal fade" id="modal_user_pic" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Afbeelding</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="image-cropper">
                            <img src="<?php echo asset_url("img/0.jpg") ?>" class="img-responsive">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="img-preview img-preview-sm img-circle"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <span class="btn btn-primary btn-file">
                    Andere afbeelding <input type="file" accept="image/jpeg,image/png"  name="file" id="pic">
                </span>
                <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
                <button type="button" class="btn btn-success save" data-dismiss="modal">Opslaan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal waiting-->
<div class="modal fade" id="Modal_waiting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal info -->
<div class="modal fade" id="Modal_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">...</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Gezien</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal delete-->
<div class="modal fade" id="Modal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Bevestig uw keuze</h4>
            </div>
            <div class="modal-body">
                Weet u zeker dat u deze wilt verwijderen?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Nee</button>
                <button type="button" class="btn btn-primary del_link" >Ja</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal logout-->
<div class="modal fade" id="Modal_logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Bevestig uw keuze</h4>
            </div>
            <div class="modal-body">
                Weet u zeker uitloggen?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Nee</button>
                <a href="<?php echo site_url('login/logout') ?>" class="btn btn-primary" role="button">Ja</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>