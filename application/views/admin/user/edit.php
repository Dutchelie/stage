<script>
    $(function () {
        crop_user_image(1 / 1);

        $('input[name="birthday"]').daterangepicker({
            showDropdowns: true,
            singleDatePicker: true
        });

        $("form#send").submit(function (e) {
            ajax_form_search($(this));
            e.preventDefault();
        });
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home') ?>">Home</a></li>
            <li><a href="<?php echo site_url('admin/user') ?>">Gebruiker overzicht</a></li>
            <li class='active'><?php echo $title ?></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs">
            <li id="tab_profile" class="active"><a href="#profile" data-toggle="tab"><i class="fa fa-fw fa-user"></i> Persoonsgegevens</a></li>
            <li id="tab_logindata"><a href="#logindata" data-toggle="tab"><i class="fa fa-fw fa-sign-in"></i> Inlogdata</a></li>
        </ul>
        <form id="send" method="POST">
            <div class="tab-content">
                <div id="logindata" class="tab-pane">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Laatst bezoekdata</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="text-caption">Tijd: <?php echo $rsdb["date"] ?></div>
                                    <div class="text-caption">IP: <?php echo $rsdb["ip_address"] ?></div>
                                    <div class="text-caption">Browser: <?php echo $rsdb["browser"] ?></div>
                                    <div class="text-caption">Besturing systeem: <?php echo $rsdb["platform"] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="profile" class="tab-pane active">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel">

                                <div class="panel-body">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input id="user_pic" type="hidden" class="form-control"  name="pic" value="<?php echo $rsdb["pic"] ?>" >
                                            <img id="user_pic" data-target="#modal_user_pic" data-toggle="modal" src="<?php echo site_url($rsdb["pic"]) ?>" class="img-responsive img-circle" onerror="this.src='http://placehold.it/100x100'" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Gebruikersnaam</label>
                                            <input type="text" name="username" class="form-control" id="username" value="<?php echo $rsdb["username"] ?>" placeholder="Gebruikersnaam">
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Wachtwoord* </label>

                                            <input type="password" class="form-control" placeholder="*********" name="password">


                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Status*</label>
                                            <?php echo $radio_active_status ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-info">
                                <div class="panel-heading"><h3 class="panel-title">Persoonsgegevens</h3></div>
                                <div class="panel-body">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Voornaam*</label>
                                            <input type="text" required maxlength="20" name="firstname" class="form-control" id="firstname" value="<?php echo $rsdb["firstname"] ?>" placeholder="Voornaam">
                                        </div>
                                    </div>

                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label>Voorvoegsel</label>
                                            <input type="text" name="prefix" maxlength="10" class="form-control" id="prefix" value="<?php echo $rsdb["prefix"] ?>" placeholder="Voorvoegsel">
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Achternaam*</label>
                                            <input type="text" required maxlength="55" name="lastname" class="form-control" id="lastname" value="<?php echo $rsdb["lastname"] ?>" placeholder="Achternaam">
                                        </div>
                                    </div>

                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label>Geslacht</label>
                                            <?php echo $select_gender ?>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Geboortedatum</label>
                                            <input type="text" required name="birthday" id="birthday" pattern="\d{2}-\d{2}-\d{4}" class="form-control" value="<?php echo $rsdb["birthday"]; ?>" placeholder="dag-maand-jaar" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-info">
                                <div class="panel-heading"><h3 class="panel-title">Contactgegevens</h3></div>
                                <div class="panel-body">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Postcode*</label>
                                            <input type="text" required name="zipcode"  maxlength="6" class="form-control" id="zipcode" value="<?php echo $rsdb["zipcode"] ?>" placeholder="0000AZ">

                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Huisnummer*</label>
                                            <input type="text" required name="housenr" pattern="[0-9]{1,5}" maxlength="5" class="form-control" id="housenr" value="<?php echo $rsdb["housenr"] ?>" placeholder="18">
                                        </div>
                                    </div>

                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label>Aanduiding</label>
                                            <input type="text" name="housenr_addition"  maxlength="2" class="form-control" id="housenr_addition" value="<?php echo $rsdb["housenr_addition"] ?>" >

                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Vast nummer</label>
                                            <input type="text" maxlength="10" name="phone" pattern="[0-9]{10}" class="form-control" id="phone" value="<?php echo $rsdb["phone"] ?>" placeholder="Vast telefoonnummer">
                                        </div>
                                    </div>


                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Mobiel*</label>
                                            <input type="text" maxlength="10" pattern="[0-9]{10}" required name="cellphone" class="form-control" id="cellphone" value="<?php echo $rsdb["cellphone"] ?>" placeholder="06">
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Emailadres*</label>
                                            <input type="email" required name="emailaddress" id="emailaddress" class="form-control" value="<?php echo $rsdb["emailaddress"] ?>" placeholder="Emailadres" />

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="hidden" name="user_id" value="<?php echo $rsdb["user_id"]; ?>" />
                                <input type="hidden" name="group_id" value="<?php echo $group_id ?>" />
                                <button type="submit" class="btn btn-default">Verzenden</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
