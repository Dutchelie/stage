<div class="panel panel-info" >
    <div class="panel-heading">
        <h3 class="panel-title">Resultaten - Totaal gevonden: <span class="totalcount"><?php echo $total ?></span></h3> 
    </div>
    <div class="panel-body">
        <div class="table-responsive">  
            <table class="table table-bordered table-hover">

                <thead>
                    <tr>
                        <th>Datum & Tijd</th>
                        <th>Gebruiker</th>
                        <th>Beschrijving</th>
                        <th>Path/url</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="itemContainer">
                    <?php foreach ($listdb as $value) : ?>
                        <tr id="<?php echo $value["log_id"]; ?>">  
                            <td><?php echo $value["date"] ?></td>
                            <td><?php echo $value["user_name"] ?></td>
                            <td><?php echo $value["description"] ?></td>
                            <td><?php echo $value["path"] ?></td>
                            <td>
                                <button onclick="handle_delete_box()" class="btn btn-danger btn-xs" data-search_data ="<?php echo $value["log_id"]; ?>" data-del_link="<?php echo $value["del_link"] ?>" data-toggle="modal" data-target="#Modal_delete" ><i class="fa fa-times"></i></button>
                            </td> 
                        </tr>
                    <?php endforeach; ?>   
                </tbody>
            </table>
        </div>
    </div>


    <div class="panel-footer">
        <?php echo $pagination; ?>
    </div>
</div>