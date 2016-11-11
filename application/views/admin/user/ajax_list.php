<div class="panel panel-info" >
    <div class="panel-heading">
        <h3 class="panel-title">Resultaten - Totaal gevonden: <span class="totalcount"><?php echo $total ?></span></h3> 
    </div>
    <div class="panel-body">
        <div class="row">
            <?php foreach ($listdb as $value) : ?>
                <div class="col-md-3" id="<?php echo $value["user_id"]; ?>">
                    <div class="thumbnail">
                        <div class="caption">
                            <h4><?php echo $value["firstname"]; ?>  <?php echo $value["lastname"]; ?></h4>
                            <p>Email: <?php echo $value["emailaddress"]; ?></p>
                            <p>Mobiel: <?php echo $value["cellphone"]; ?></p>
                            <p>Woonplaats: <?php echo $value["city"]; ?></p>
                            <p>
                                <button onclick="ajax_search_filter(this, 'group_id')" class="btn btn-info btn-xs" data-search_data="<?php echo $value["group_id"]; ?>"><?php echo $value["group_name"] ?></button>
                                <a href="<?php echo $value["edit_link"] ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>
                                <button onclick="handle_delete_box()" class="btn btn-danger btn-xs" data-search_data ="<?php echo $value["user_id"]; ?>" data-del_link="<?php echo $value["del_link"] ?>" data-toggle="modal" data-target="#Modal_delete" ><i class="fa fa-times"></i></button>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>   
        </div>
    </div>


    <div class="panel-footer">
        <?php echo $pagination; ?>
    </div>
</div>
