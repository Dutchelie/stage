<script>
    $(function () {
        $("form#form_search").submit(function (e) {
            ajax_form_search($(this));
            e.preventDefault();
        });
        input_reportrange('input[name="reportrange"]');
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
    <div class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading"> <h3 class="panel-title">Selectie</h3></div>
            <div class="panel-body">
                <form method="POST" id="form_search">
                    <div class="row">
                         <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Datum</label>
                                <input type="text" name="reportrange" class="form-control" />
                            </div> 
                        </div>
                        
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Gebruiker</label>
                                <input name="user_name" id="user_name" type="text" class="form-control" />
                            </div> 
                        </div>

                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Beschrijving</label>
                                <input name="search_description" id="search_description" type="text" class="form-control" />
                            </div> 
                        </div>

                       
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-lg-12">
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