<?php ob_start() ?>

<!-- VISTA LOGIN, SOLO SI NO HAY SESION NIVEL 1 O +, LOGUEA Y MANDA A HOME-->

<div class="home-container">
    <!-- Logo -->
     <a href="index.php"><img src="../web/images/appimages/logo.png" alt="Logo de la App" class="home-logo"></a>

     <div class="avisos">
        <?php if (isset($params['mensaje'])) : ?>
            <b><span style="color: rgba(200, 119, 119, 1);"><?php echo $params['mensaje'] ?></span></b>
        <?php endif; ?>

        

    </div>
    

    <div class="login-container">
    <h2>Iniciar sesión</h2>
    <br>
    <form action="index.php?ctl=login" method="post" class="login-form">
        <label for="username">Usuario</label>
        <input type="text" id="username" name="username">
        <br>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password">
        <br><br>

        <button type="submit" class="btn btn-login" name="bLogin">Entrar</button>
    </form>
</div>


</div>


<?php
$contenido = ob_get_clean();
include __DIR__ . '/layout.php';

?>