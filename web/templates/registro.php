<?php ob_start() ?>

<div class="home-container">
    <!-- Logo -->
     <a href="index.php"><img src="../web/images/appimages/logo.png" alt="Logo de la App" class="home-logo"></a>
    

    <div class="register-container">
    <h2>Registro</h2>
    <br>
    <form action="index.php?ctl=registro" method="post" class="register-form">
        <label for="username">Nombre de usuario</label>
        <input type="text" id="username" name="username" required placeholder="Elige un nombre de usuario">
        <br>

        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required placeholder="Tu correo electrónico">
        <br>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required placeholder="Crea una contraseña">
        <br>

        <label for="confirm_password">Confirmar contraseña</label>
        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Repite la contraseña">
        <br><br>

        <button type="submit" class="btn btn-register">Registrarse</button>
    </form>
</div>


</div>




<?php 
$contenido = ob_get_clean();
include __DIR__ . '/layout.php';
?>
