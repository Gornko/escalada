<?php ob_start() ?>

<!-- VISTA ERROR GENERICA-->

<div class="home-container">
    <!-- Logo -->
     <a href="index.php"><img src="../web/images/appimages/logo.png" alt="Logo de la App" class="home-logo"></a>
    

    <div class="login-container">
    <h2>ERROR</h2>
    <br>
    
</div>


</div>


<?php
$contenido = ob_get_clean();
include __DIR__ . '/layout.php';

?>