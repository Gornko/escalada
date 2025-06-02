<?php ob_start() ?>

<div class="home-container">
    <!-- Logo -->
    <img src="../web/images/appimages/logo.png" alt="Logo de la App" class="home-logo">

    <!-- Descripción -->
    <p class="home-description">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. 
        Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet.
    </p>

    <!-- Botones -->
    <div class="home-buttons">
        <a href="/login" class="btn btn-login">Iniciar sesión</a>
        <a href="/register" class="btn btn-register">Registrarse</a>
    </div>
</div>

<?php 
$contenido= ob_get_clean();
include 'layout.php';
?>