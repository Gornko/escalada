<?php ob_start() ?>

<!-- VISTA REGISTRO, PERMITE REGISTRAR NUEVO USUARIO EN LA BD-->

<div class="home-container">
    <!-- Logo -->
    <a href="index.php"><img src="../web/images/appimages/logo.png" alt="Logo de la App" class="home-logo"></a>

    <div class="avisos">
        <?php if (isset($params['mensaje'])) : ?>
            <b><span style="color: rgba(200, 119, 119, 1);"><?php echo $params['mensaje'] ?></span></b>
        <?php endif; ?>

        <br>
        <?php foreach ($errores as $error) { ?>
            <b><span style="color: rgba(200, 119, 119, 1);"><?php echo $error . "<br>"; ?></span></b>
        <?php } ?>

    </div>

    <h2>Registro</h2>
    <br>

    <div class="register-container">

        <br>
        <form action="index.php?ctl=registro" method="post" class="register-form" enctype="multipart/form-data">
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
            <br>

            <label for="foto">Imagen de perfil</label>
            <input type="file" id="foto" name="foto"  >
            <br>

            <br>
            <button type="submit" class="btn btn-register" name="bRegistro">Registrarse</button>
        </form>
    </div>


</div>




<?php
$contenido = ob_get_clean();
include __DIR__ . '/layout.php';
?>