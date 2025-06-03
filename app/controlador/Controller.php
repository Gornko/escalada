<?php
class Controller
{

    public function inicio()
    {
        require __DIR__ . "/../../web/templates/inicio.php";
    }

    public function login()
    {
        require __DIR__ . "/../../web/templates/login.php";
    }

    public function error()
    {
        require __DIR__ . "/../../web/templates/error.php";
    }


    //Comienza la funcion de registrar un usuario
    public function registro()
    {

        if ($_SESSION['nivel'] > 0) {
            header("location:index.php?ctl=inicio");
        }

        $errores=[];
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

                        header('Location: index.php?ctl=registro');
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



    
}
