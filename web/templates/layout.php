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

             <!-- Este estilo para el logo deberia estar en el css, pero no se porque no le afecta, y solo
              me funciona inline... asi que por ahora aqui se queda!-->
            <img src="/dwes/Extraordinaria/evaluableextraordinaria/web/images/appimages/logo.png" alt="Logo" 
            style="position: fixed; top: 7%; left: 50%; width: 70px; height: 70px; object-fit: 
            contain; transform: translate(-50%, -50%); z-index: 9999;">


            <nav class="main-menu">
                <a href="index.php?ctl=home">Logbook</a>
                <a href="index.php?ctl=buscar">Buscar</a>
                <a href="index.php?ctl=anyadir">Añadir</a>
                <a href="index.php?ctl=perfil">Perfil</a>
                <a href="index.php?ctl=stats">Estadísticas</a>
                <?php if($_SESSION['nivel']==2): ?>
                    <a href="index.php?ctl=admin">Admin</a>
                <?php endif;?>
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