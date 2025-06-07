<?php
class Controller
{

    public function inicio()
    {
        require __DIR__ . "/../../web/templates/inicio.php";
    }


    public function logout()
    {
        session_destroy();

        header("location:index.php?ctl=inicio");
    }

    public function error()
    {
        require __DIR__ . "/../../web/templates/error.php";
    }


    //Comienza la funcion de registrar un usuario
    public function registro()
    {

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

        if (isset($_POST['bRegistro'])) {
            $nombreUsuario = recoge('username');
            $email = recoge('email');
            $contrasenya = recoge('password');
            $contrasenyaBis = recoge('confirm_password');

            // Comprobar campos formulario. Aqui va la validación con las funciones de bGeneral o la clase Validacion         
            cTexto($nombreUsuario, "nombre de usuario", $errores);
            cEmail($email, "email", $errores);
            cUser($contrasenya, "contrasenya", $errores);
            cUser($contrasenyaBis, "confirmar contrasenya", $errores);
            if (empty($errores)) {
                // Si no ha habido problema creo modelo y hago inserción     
                try {

                    $m = new RutasEscalada();
                    if ($m->insertarUsuario($nombreUsuario, $email, encriptar($contrasenya))) {

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
            } else {
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


            if ($_SESSION['nivel'] > 0) {
                header("location:index.php?ctl=home");
            }
            if (isset($_POST['bLogin'])) { // Nombre del boton del formulario
                $nombreUsuario = recoge('username');
                $contrasenya = recoge('password');

                // Comprobar campos formulario. Aqui va la validación con las funciones de bGeneral   
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
            $params = $m->listarRutas($_SESSION['idUser']); // ← directamente la lista de rutas

            if (empty($params)) {
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

    public function buscar()
    {
        $errores = [];
        $params = [];
        $rutas = [];


        if (isset($_POST['bNombre']) || isset($_POST['bPais']) || isset($_POST['bEstilo']) || isset($_POST['bEncadene'])) {

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


    //comiena funcion de anyadir una ruta
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
                        $comentarios
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

    public function perfil()
    {
        require __DIR__ . "/../../web/templates/perfil.php";
    }

    public function stats()
    {
        require __DIR__ . "/../../web/templates/stats.php";
    }

    public function admin()
    {
        $params = [];
        $errores = [];

        if (isset($_POST['bEliminar'])) {
            $idUsuario = recoge('user_id');
            cNum($idUsuario, 'id', $errores);
            if (empty($errores)) {
                if ($idUsuario == 1 || $idUsuario==2) {
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
