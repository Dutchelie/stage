<script>
    $(function () {
        $("form#form_search").submit(function (e) {
            ajax_form_search($("form#form_search"));
            e.preventDefault();
        });
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home') ?>">Home</a></li>
            <li class='active'><?php echo $title ?></li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div>Beheerder</div>
                        <div>Kan alles</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo $add_link_admin ?>">
                <div class="panel-footer">
                    <span class="pull-left">Nieuwe beheerder</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div>Gebruiker</div>
                        <div>Musikant,band studio</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo $add_link_user ?>">
                <div class="panel-footer">
                    <span class="pull-left">Nieuwe gebruiker</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    

</div>



<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading"> <h3 class="panel-title">Selectie</h3></div>
            <div class="panel-body">
                <form method="POST" id="form_search">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Voornaam</label>
                                <input name="search_firstname" id="search_firstname" type="text" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Achternaam</label>
                                <input name="search_lastname" id="search_lastname" type="text" class="form-control"/>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Email</label>
                                <input name="search_email" id="search_email" type="email" class="form-control" />
                            </div> 
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Gebruikergroep</label>
                                <?php echo $select_group ?>
                            </div> 
                        </div>
                    </div>
                    <div class="row"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <input name="do_ajax" id="do_ajax" type="hidden" value="1"/>
                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                            <button type="button" class="btn btn-default reset"><i class="fa fa-refresh"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="panel-footer"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12" id="ajax_search_content">
        <?php echo $result; ?>
    </div>
</div>
