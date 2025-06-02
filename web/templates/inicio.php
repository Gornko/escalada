<?php ob_start() ?>

<div class="home-container">
    <!-- Logo -->
    <img src="../web/images/appimages/logo.png" alt="Logo de la App" class="home-logo">

    <!-- Descripción -->
    <p class="home-description">
        Nuestra aplicación está diseñada para que puedas guardar y organizar todas tus encadenes de escalada, 
        ya sean rutas deportivas, clásicas o de búlder.
        Con ella, podrás registrar cada intento, éxito o fallo, y mantener un historial completo de tus progresos. 
        Además, la app genera estadísticas personalizadas que te ayudarán a analizar tu rendimiento, 
        identificar patrones y planificar tus próximos desafíos. ¡Así podrás escalar mejor y seguir superándote en cada ruta!
    </p>

    <!-- Botones -->
    <div class="home-buttons">
        <a href="index.php?ctl=login" class="btn btn-login">Iniciar sesión</a>
        <a href="index.php?ctl=registro" class="btn btn-register">Registrarse</a>
    </div>
</div>

<?php
$contenido = ob_get_clean();
include 'layout.php';
?>