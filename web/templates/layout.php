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
        <!-- Generar dinamicamente el menu si esta logueado-->
        <?php if (isset($_SESSION['nivel']) && $_SESSION['nivel'] > 0): ?>
            <div class="infoUser">
            <p><?php echo $_SESSION['nombreUsuario'] ?></p>
            <img class="userImg" src="/dwes/Extraordinaria/evaluableextraordinaria/web/images/users/<?php echo $_SESSION['photo'] ?>" alt="No">
            </div>
            
            <a href="index.php?ctl=logout" class="logout-button">Cerrar sesión</a>
        <?php endif; ?>
    </header>

    <div class="container">
        <?php echo $contenido ?>
    </div>

</body>

</html>