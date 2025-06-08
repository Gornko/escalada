<?php ob_start(); ?>

<!-- VISTA ESTADISTIAS, MUESTRA CARTEL DE EN CONSTRUCCION-->

<div class="tablaContainer">
    <h2 class="title-table">Sección en construcción</h2>
    <p style="font-size: 1.2rem; color: #555; margin-top: 20px;">
        Esta sección está actualmente en desarrollo. ¡Vuelve pronto!
    </p>
    <img src="../web/images/appimages/under_construction.png" alt="En construcción" style="margin-top: 30px; width: 150px;">
</div>

<?php
$contenido = ob_get_clean();
include __DIR__ . '/layout.php';
?>
