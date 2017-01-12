<script>
//    document.getElementById("button").value="inloggen";
//    $(function toggleText (button) {
//        var el = document.getElementById(button);
//        if (el.textContent === "inloggen") {
//            el.textContent = "logout";
//        } else {
//            el.textContent = "inloggen";
//        }
//    });
</script>
<!--Dit is de aller eerste page die je ziet,
Deze page ziet elke bezoeker eerst als ze op de website komen.-->
<div class="container">

    <div class="row">
        <div class="col-lg-12">
            Home!!!voor iedereen
            <!--Knop zodat je kan gaan inloggen.-->
            <a href="<?php echo site_url("login/") ?>" name="button" id="button" class="btn btn-primary" role="button">inloggen</a>
<!--            <a href="<?php //echo site_url('login/logout') ?>" name="logout" id="logout" class="btn btn-primary" role="button">Log Out</a>
        --></div>
    </div><!--/.row-->    
</div><!--/.container-->
