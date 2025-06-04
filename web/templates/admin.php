<?php ob_start() ?>



<div class="home-container">
    <!-- Logo -->
     
    

    <div class="login-container">
    <h2>Holi</h2>
    <br>
    
</div>


</div>


<?php
$contenido = ob_get_clean();
include __DIR__ . '/layout.php';

?>