<?php
class Controller
{

    //dirige a la pagina de inicio
    public function inicio()
    {
        require __DIR__ . "/../../web/templates/inicio.php";
    }


    //destruye la sesion y redirige a la pagina de inicio
    public function logout()
    {
        session_destroy();

        header("location:index.php?ctl=inicio");
    }

    //redirige a pagina generica de error
    public function error()
    {
        require __DIR__ . "/../../web/templates/error.php";
    }


    //Comienza la funcion de registrar un usuario
    public function registro()
    {

        //si esta definido el nivel del usuario a mas de 0, entonces ya esta logueado y manda al home
        if ($_SESSION['nivel'] > 0) {
            header("location:index.php?ctl=home");
        }

        $errores = [];
        $params = array(
            'nombreUsuario' => '',
            'email' => '',
            'contrasenya' => '',
            'contrasenyaBis' => '',

        );

        //sanitizar
        if (isset($_POST['bRegistro'])) {
            $nombreUsuario = recoge('username');
            $email = recoge('email');
            $contrasenya = recoge('password');
            $contrasenyaBis = recoge('confirm_password');

            //si se ha seleccionado una foto, la sube, sino pasa la de por defecto
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['foto']['tmp_name'];
                $fileName = time() . $_FILES['foto']['name'];

                $uploadDir = __DIR__ . '/../../web/images/users/';
                $uploadPath = $uploadDir . basename($fileName);

                if (move_uploaded_file($tmpName, $uploadPath)) {
                    // todo OK
                } else {
                    $errores['foto'] = "Error al subir la foto";
                }
            } else {
                $fileName = 'default.png'; // usar imagen por defecto si no se subió nada
            }
            //faltaria validar la imagen correctamente


            // validacion         
            cTexto($nombreUsuario, "nombre de usuario", $errores);
            cEmail($email, "email", $errores);
            cUser($contrasenya, "contrasenya", $errores);
            cUser($contrasenyaBis, "confirmar contrasenya", $errores);

            //si no hay errores, instancio modelo y hago consulta
            if (empty($errores)) {   
                try {

                    $m = new RutasEscalada();
                    if ($m->insertarUsuario($nombreUsuario, $email, encriptar($contrasenya), $fileName)) {

                        $params['mensaje'] = 'Usuario registrado correctamente.';
                    } else {

                        $params = array(
                            'nombreUsuario' => $nombreUsuario,
                            'email' => $email,
                            'contrasenya' => $contrasenya,
                            'contrasenyaBis' => $contrasenyaBis
                        );

                        $params['mensaje'] = 'No se ha podido insertar el usuario. Revisa el formulario.';
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logExceptio.txt");
                    header('Location: index.php?ctl=error');
                } catch (Error $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
                    header('Location: index.php?ctl=error');
                }
            } else { //si hay errores lo pasamos por params y se imprime en la plantilla
                $params = array(
                    'nombreUsuario' => $nombreUsuario,
                    'email' => $email,
                    'contrasenya' => $contrasenya,
                    'contrasenyaBis' => $contrasenyaBis
                );
                $params['mensaje'] = 'Hay datos que no son correctos. Revisa el formulario.';
            }
        }


        require __DIR__ . "/../../web/templates/registro.php";
    }
    //fin funcion registrar usuarios


    //empieza funcion iniciar sesion/login
    public function login()
    //contraseña del admin1 -> 1234
    //contraseña del admin2 -> admin
    {
        try {
            $params = array(
                'nombreUsuario' => '',
                'contrasenya' => ''
            );

            //si esta definido el nivel del usuario a mas de 0, entonces ya esta logueado y manda al home
            if ($_SESSION['nivel'] > 0) {
                header("location:index.php?ctl=home");
            }

            //sanitizar
            if (isset($_POST['bLogin'])) { 
                $nombreUsuario = recoge('username');
                $contrasenya = recoge('password');

                //validar
                if (cUser($nombreUsuario, "nombreUsuario", $params)) {
                    // Si no ha habido problema creo modelo y hago consulta                    
                    $m = new RutasEscalada();
                    if ($usuario = $m->consultarUsuario($nombreUsuario)) {
                        // Compruebo si el password es correcto
                        if (comprobarhash($contrasenya, $usuario['password_hash'])) {
                            // Obtenemos el resto de datos

                            $_SESSION['idUser'] = $usuario['id'];
                            $_SESSION['nombreUsuario'] = $usuario['username'];
                            $_SESSION['photo'] = $usuario['profile_image'];
                            $_SESSION['email'] = $usuario['email'];
                            if ($usuario['role'] == 'admin') {
                                $_SESSION['nivel'] = 2;
                            } else {
                                $_SESSION['nivel'] = 1;
                            }

                            //despues de obtenidos datos del usuario, dirige al home
                            header('Location: index.php?ctl=home');
                        }
                    } else {
                        $params = array(
                            'nombreUsuario' => $nombreUsuario,
                            'contrasenya' => $contrasenya
                        );
                        $params['mensaje'] = 'No se ha podido iniciar sesión. Revisa el formulario.';
                    }
                } else {
                    $params = array(
                        'nombreUsuario' => $nombreUsuario,
                        'contrasenya' => $contrasenya
                    );
                    $params['mensaje'] = 'Hay datos que no son correctos. Revisa el formulario.';
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/login.php';
    }
    //fin funcion login


    //Empieza funcion home, asociada tambien a la pestaña Logbook, que lista las rutas del usuario
    public function home()
    {
        try {
            $m = new RutasEscalada();
            $params = $m->listarRutas($_SESSION['idUser']); // ← directamente imprime la lista de rutas del usuario

            if (empty($params)) { //si no tiene rutas, lo indica
                $params['mensaje'] = "No hay rutas que mostrar.";
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . "/../../web/templates/home.php";
    }


    //empieza funcion de buscar una ruta en la BD
    public function buscar()
    {
        $errores = [];
        $params = [];
        $rutas = [];

        //si se pulsa el clguno de los botonos:
        if (isset($_POST['bNombre']) || isset($_POST['bPais']) || isset($_POST['bEstilo']) || isset($_POST['bEncadene'])) {

            //dependiendo del boton que se pulse recoge un dato distinto
            if (isset($_POST['bNombre'])) {
                $nombre = recoge('routename');
                cTexto($nombre, 'nombre', $errores);
                $params['param'] = $nombre;
                $campo = 'nombre';
            } else if (isset($_POST['bPais'])) {
                $pais = recoge('pais');
                cTexto($pais, 'pais', $errores);
                $params['param'] = $pais;
                $campo = 'pais';
            } else if (isset($_POST['bEstilo'])) {
                $estilo = recoge('estilo');
                cNum($estilo, 'estilo', $errores);
                $params['param'] = $estilo;
                $campo = 'estilo';
            } else if (isset($_POST['bEncadene'])) {
                $encadene = recoge('encadene');
                cNum($encadene, 'encadene', $errores);
                $params['param'] = $encadene;
                $campo = 'encadene';
            }

            if (empty($errores)) {
                try {
                    $m = new RutasEscalada();
                    $rutas = $m->buscarRutas($_SESSION['idUser'], $params['param'], $campo);
                } catch (Exception $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logExceptio.txt");
                    header('Location: index.php?ctl=error');
                } catch (Error $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
                    header('Location: index.php?ctl=error');
                }
            } else {
                $params['mensaje'] = 'Error en algun campo.';
            }
        }
        require __DIR__ . "/../../web/templates/buscar.php";
    }


    //comienza funcion de anyadir una ruta
    public function anyadir()
    {
        $errores = [];
        $params = array(
            'nombre' => '',
            'metros' => '',
            'cintas' => '',
            'pais' => '',
            'localidad' => '',
            'estilo' => '',
            'largos' => '',
            'pegues' => '',
            'encadene' => '',
            'fecha' => '',
            'comentarios' => ''
        );

        //si se pulsa boton de anyadir, recoge y sanitiza la info
        if (isset($_POST['bAnyadir'])) {
            $nombre = recoge('routename');
            $metros = recoge('metros');
            $cintas = recoge('cintas');
            $pais = recoge('pais');
            $localidad = recoge('localidad');
            $estilo = recoge('estilo');
            $largos = recoge('largos');
            $pegues = recoge('pegues');
            $encadene = recoge('encadene');
            $fecha = recoge('fecha');
            $comentarios = recoge('comentarios');

            //si se ha incluido imagen, la sube
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['foto']['tmp_name'];
                $fileName = time() . $_FILES['foto']['name'];

                $uploadDir = __DIR__ . '/../../web/images/routes/';
                $uploadPath = $uploadDir . basename($fileName);

                if (move_uploaded_file($tmpName, $uploadPath)) {
                    // todo OK
                } else {
                    $errores['foto'] = "Error al subir la foto";
                }
            } else { //si no se ha subido, pone imagen por defecto
                $fileName = 'defaultRoute.png'; 
            }
            
            //validacion
            cTexto($nombre, 'nombre', $errores);
            cNum($metros, 'metros', $errores);
            cNum($cintas, 'cintas', $errores);
            cTexto($pais, 'pais', $errores);
            cTexto($localidad, 'localidad', $errores);
            cNum($estilo, 'estilo', $errores);
            cNum($largos, 'largos', $errores);
            cNum($pegues, 'pegues', $errores);
            cNum($encadene, 'encadene', $errores);
            cFechaaaaammdd($fecha, 'fecha', $errores);
            cTexto($comentarios, 'comentarios', $errores, 100);
            //faltaria validar la imagen correctamente

            //consulta
            if (empty($errores)) {
                try {

                    $m = new RutasEscalada();
                    if ($m->insertarRuta(
                        $_SESSION['idUser'],
                        $nombre,
                        $metros,
                        $cintas,
                        $pais,
                        $localidad,
                        $estilo,
                        $largos,
                        $pegues,
                        $encadene,
                        $fecha,
                        $comentarios,
                        $fileName
                    )) {
                        $params['mensaje'] = "Ruta insertada correctamente.";
                    } else {
                        $params = array(
                            'nombre' => $nombre,
                            'metros' => $metros,
                            'cintas' => $cintas,
                            'pais' => $pais,
                            'localidad' => $localidad,
                            'estilo' => $estilo,
                            'largos' => $largos,
                            'pegues' => $pegues,
                            'encadene' => $encadene,
                            'fecha' => $fecha,
                            'comentarios' => $comentarios
                        );

                        $params['mensaje'] = 'No se ha podido insertar la ruta. Revisa el formulario.';
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logExceptio.txt");
                    header('Location: index.php?ctl=error');
                } catch (Error $e) {
                    error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
                    header('Location: index.php?ctl=error');
                }
            } else {
                $params = array(
                    'nombre' => $nombre,
                    'metros' => $metros,
                    'cintas' => $cintas,
                    'pais' => $pais,
                    'localidad' => $localidad,
                    'estilo' => $estilo,
                    'largos' => $largos,
                    'pegues' => $pegues,
                    'encadene' => $encadene,
                    'fecha' => $fecha,
                    'comentarios' => $comentarios
                );

                $params['mensaje'] = 'Hay datos que no son correctos. Revisa el formulario.';
            }
        }


        require __DIR__ . "/../../web/templates/anyadir.php";
    }

    //redirige al perfil, donde se pintan los datos de la sesion
    public function perfil()
    {
        require __DIR__ . "/../../web/templates/perfil.php";
    }

    //redirige a estadisticas, donde se mostraran estadisticas, en construccion
    public function stats()
    {
        require __DIR__ . "/../../web/templates/stats.php";
    }

    //redirige a admin, donde podemos borrar usuario por id
    public function admin()
    {
        $params = [];
        $errores = [];

        if (isset($_POST['bEliminar'])) {
            $idUsuario = recoge('user_id');
            cNum($idUsuario, 'id', $errores);
            if (empty($errores)) {
                    //si el usuario elegido es el 1 o el 2, que son los admin, no deja
                if ($idUsuario == 1 || $idUsuario == 2) {
                    $params['mensaje'] = 'No puedes borrar al administrador';
                } else {
                    try {
                        $m = new RutasEscalada();
                        if ($m->eliminarUsuario($idUsuario)) {
                            $params['mensaje'] = "Usuario eliminado correctamente.";
                        } else {
                            $params['mensaje'] = "No se ha podido eliminar.";
                        }
                    } catch (Exception $e) {
                        error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logExceptio.txt");
                        header('Location: index.php?ctl=error');
                    } catch (Error $e) {
                        error_log($e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/logError.txt");
                        header('Location: index.php?ctl=error');
                    }
                }
            } else {
                $params['mensaje'] = 'Ha habido algun problema con el formulario';
            }
        }

        require __DIR__ . "/../../web/templates/admin.php";
    }
}
