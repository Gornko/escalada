<?php ob_start() ?>



<div class="home-container">
    <!-- Logo -->
     <a href="index.php"><img src="../web/images/appimages/logo.png" alt="Logo de la App" class="home-logo"></a>
    

    <div class="login-container">
    <h2>Iniciar sesión</h2>
    <br>
    <form action="/login" method="post" class="login-form">
        <label for="username">Usuario</label>
        <input type="text" id="username" name="username">
        <br>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password">
        <br><br>

        <button type="submit" class="btn btn-login">Entrar</button>
    </form>
</div>


</div>


<?php
$contenido = ob_get_clean();
include __DIR__ . '/layout.php';

?>