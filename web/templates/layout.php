<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo Config::$vista_css; ?>">



    <title>Document</title>
</head>

<body>
    <header>
        <!-- Generar dinamicamente el menu y la info de usuariosi esta logueado-->
        <?php if (isset($_SESSION['nivel']) && $_SESSION['nivel'] > 0): ?>
            <nav class="main-menu">
                <a href="#">Logbook</a>
                <a href="#">Buscar</a>
                <a href="#">Añadir</a>
                <a href="#">Perfil</a>
                <a href="#">Estadísticas</a>
            </nav>

            <div class="user-actions">
            <div class="infoUser">
                <p><?php echo $_SESSION['nombreUsuario'] ?></p>
                <img class="userImg" src="/dwes/Extraordinaria/evaluableextraordinaria/web/images/users/<?php echo $_SESSION['photo'] ?>" alt="No">
            </div>
            <a href="index.php?ctl=logout" class="logout-button">Cerrar sesión</a>
        </div>
    <?php endif; ?>
</header>

    <div class="container">
        <?php echo $contenido ?>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; <?php echo date("Y"); ?> ClimbTrack. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>

</html>