﻿<?php

/****
 * Librería con funciones generales y de validación
 * @author Heike Bonilla
 * 
 */


//***** Funciones de sanitización **** //


/**
 * funcion sinTildes
 *
 * Elimina caracteres con tilde de las cadenas
 * 
 * @param string $frase
 * @return string
 */

function sinTildes($frase): string
{
    $no_permitidas = array(
        "á",
        "é",
        "í",
        "ó",
        "ú",
        "Á",
        "É",
        "Í",
        "Ó",
        "Ú",
        "à",
        "è",
        "ì",
        "ò",
        "ù",
        "À",
        "È",
        "Ì",
        "Ò",
        "Ù"
    );
    $permitidas = array(
        "a",
        "e",
        "i",
        "o",
        "u",
        "A",
        "E",
        "I",
        "O",
        "U",
        "a",
        "e",
        "i",
        "o",
        "u",
        "A",
        "E",
        "I",
        "O",
        "U"
    );
    $texto = str_replace($no_permitidas, $permitidas, $frase);
    return $texto;
}

/**
 * Funcion sinEspacios
 * 
 * Elimina los espacios de una cadena de texto
 * 
 * @param string $frase
 * @param string $espacio
 * @return string
 */

function sinEspacios($frase)
{
    $texto = trim(preg_replace('/ +/', ' ', $frase));
    return $texto;
}


/**
 * Funcion recoge
 * 
 * Sanitiza cadenas de texto
 * 
 * @param string $var
 * @return string
 */

function recoge(string $var)
{
    if (isset($_REQUEST[$var]) && (!is_array($_REQUEST[$var]))) {
        $tmp = sinEspacios($_REQUEST[$var]);
        $tmp = strip_tags($tmp);
    } else
        $tmp = "";

    return $tmp;
}

/**
 * Funcion recogeArray
 * 
 * Sanitiza arrays
 * 
 * @param string $var
 * @return array
 */

function recogeArray(string $var): array
{
    $array = [];
    if (isset($_REQUEST[$var]) && (is_array($_REQUEST[$var]))) {
        foreach ($_REQUEST[$var] as $valor)
            $array[] = strip_tags(sinEspacios($valor));
    }

    return $array;
}



//***** Funciones de validación **** //

/**
 * Funcion cTexto
 *
 * Valida una cadena de texto con respecto a una RegEx. Reporta error en un array.
 * 
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param integer $min
 * @param integer $max
 * @param bool $espacios
 * @param bool $case
 * @return bool
 */


function cTexto(string $text, string $campo, array &$errores, int $max = 30, int $min = 1, bool $espacios = TRUE, bool $case = TRUE): bool
{
    $case = ($case === TRUE) ? "i" : "";
    $espacios = ($espacios === TRUE) ? " " : "";
    if ((preg_match("/^[a-zñ$espacios]{" . $min . "," . $max . "}$/u$case", sinTildes($text)))) {
        return true;
    }
    $errores[$campo] = "Error en el campo $campo";
    return false;
}


/**
 * Funcion cUser
 *
 * Valida una cadena de texto con respecto a una RegEx. Reporta error en un array.
 * 
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param integer $min
 * @param integer $max
 * @return bool
 */


 function cUser(string $text, string $campo, array &$errores, int $max = 30, int $min = 1): bool
 {
     
     if ((preg_match("/^[a-zA-Z0-9_]{" . $min . "," . $max . "}$/u", sinTildes($text)))) {
         return true;
     }
     $errores[$campo] = "Error en el campo $campo";
     return false;
 }
 





function unixFechaAAAAMMDD($fecha,$campo,&$errores){

    $arrayfecha=explode("-",$fecha);
if (count($arrayfecha)==3){
    $fechavalida=checkdate($arrayfecha[1], $arrayfecha[2], $arrayfecha[0]);

    if( $fechavalida){

        return mktime(0,0,0,$arrayfecha[2],$arrayfecha[1],$arrayfecha[0]);

    }
}
        $errores[$campo]="Fecha no valida";
        return false;
    
}








/**
 * Funcion cNum
 *
 * Valida que un string sea numerico menor o igual que un número y si es o no requerido
 * 
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param bool $requerido
 * @param integer $max
 * @return bool
 */
function cNum(string $num, string $campo, array &$errores, bool $requerido = TRUE, int $max = PHP_INT_MAX): bool
{
    $cuantificador = ($requerido) ? "+" : "*";
    if ((preg_match("/^[0-9]" . $cuantificador . "$/", $num))) {

        if ($num <= $max) return true;
    }
    $errores[$campo] = "Error en el campo $campo";
    return false;
}

/**
 * Funcion cRadio
 *
 * Valida que un string se encuentre entre los valores posibles. Si es requerido o no
 * 
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param array $valores
 * @param bool $requerido
 * 
 * @return boolean
 */
function cRadio(string $text, string $campo, array &$errores, array $valores, bool $requerido = TRUE)
{
    if (in_array($text, $valores)) {
        return true;
    }
    if (!$requerido && $text == "") {
        return true;
    }
    $errores[$campo] = "Error en el campo $campo";
    return false;
}

function cSelect(string $text, string $campo, array &$errores, array $valores, bool $requerido = TRUE)
{
    if (array_key_exists($text, $valores)) {
        return true;
    }
    if (!$requerido && $text == "") {
        return true;
    }
    $errores[$campo] = "Error en el campo $campo";
    return false;
}
/**
 * Funcion cCheck
 *
 * Valida que los valores seleccionado en un checkbox array están dentro de los 
 * valores válidos dados en un array. Si es requerido o no
 * 
 * 
 * @param array $text
 * @param string $campo
 * @param array $errores
 * @param array $valores
 * @param bool $requerido
 * 
 * @return boolean
 */

function cCheck(array $text, string $campo, array &$errores, array $valores, bool $requerido = TRUE)
{

    if (($requerido) && (count($text) == 0)) {
        $errores[$campo] = "Error en el campo $campo";
        return false;
    }
    foreach ($text as $valor) {
        if (!in_array($valor, $valores)) {
            $errores[$campo] = "Error en el campo $campo";
            return false;
        }
    }
    return true;
}


/**
 * Funcion cFile
 * 
 * Valida la subida de un archivo a un servidor.
 *
 * @param string $nombre
 * @param array $extensiones_validas
 * @param string $directorio
 * @param integer $max_file_size
 * @param array $errores
 * @param boolean $required
 * @return boolean|string
 */
function cFile(string $nombre, array &$errores, array $extensionesValidas, string $directorio, int  $max_file_size,  bool $required = TRUE)
{
    // Caso especial que el campo de file no es requerido y no se intenta subir ningun archivo
    if ((!$required) && $_FILES[$nombre]['error'] === 4)
        return true;
    // En cualquier otro caso se comprueban los errores del servidor 
    if ($_FILES[$nombre]['error'] != 0) {
        $errores["$nombre"] = "Error al subir el archivo " . $nombre . ". Prueba de nuevo";
        return false;
    } else {

        $nombreArchivo = strip_tags($_FILES["$nombre"]['name']);
        /*
             * Guardamos nombre del fichero en el servidor
            */
        $directorioTemp = $_FILES["$nombre"]['tmp_name'];
        /*
             * Calculamos el tamaño del fichero
            */
        $tamanyoFile = filesize($directorioTemp);
        
        /*
            * Extraemos la extensión del fichero, desde el último punto.
            */
        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

        /*
            * Comprobamos la extensión del archivo dentro de la lista que hemos definido al principio
            */
        if (!in_array($extension, $extensionesValidas)) {
            $errores["$nombre"] = "La extensión del archivo no es válida";
            return false;
        }
        /*
            * Comprobamos el tamaño del archivo
            */
        if ($tamanyoFile > $max_file_size) {
            $errores["$nombre"] = "La imagen debe de tener un tamaño inferior a $max_file_size kb";
            return false;
        }

        // Almacenamos el archivo en ubicación definitiva si no hay errores ( al compartir array de errores TODOS LOS ARCHIVOS tienen que poder procesarse para que sea exitoso. Si cualquiera da error, NINGUNO  se procesa)

        if (empty($errores)) {
            /**
             * Comprobamos si el directorio pasado es válido
             */
            if (is_dir($directorio)) {
                /**
             * Tenemos que buscar un nombre único para guardar el fichero de manera definitiva.
             * Podemos hacerlo de diferentes maneras, en este caso se hace añadiendo microtime() al nombre del fichero 
             * si ya existe un archivo guardado con ese nombre.
             * */
                $nombreArchivo = is_file($directorio . DIRECTORY_SEPARATOR . $nombreArchivo) ? time() . $nombreArchivo : $nombreArchivo;
                $nombreCompleto = $directorio . DIRECTORY_SEPARATOR . $nombreArchivo;
                /**
                 * Movemos el fichero a la ubicación definitiva.
                 * */
                if (move_uploaded_file($directorioTemp, $nombreCompleto)) {
                    /**
                     * Si todo es correcto devuelve la ruta y nombre del fichero como se ha guardado
                     */


                    return $nombreCompleto;
                } else {
                    $errores["$nombre"] = "Ha habido un error al subir el fichero";
                    return false;
                }
            }else {
                $errores["$nombre"] = "Ha habido un error al subir el fichero";
                return false;
            }
        }
    }
}


function crypt_blowfish($password) {

    $salt = '$2a$07$usesomesillystringforsalt$';
    $pass= crypt($password, $salt);
    
    return $pass;
    }

    

    function cEmail(string $email, string $campo, array &$errores, int $max = 254): bool
{
    // Verificamos la longitud máxima (254 es el estándar máximo para un email)
    if (strlen($email) > $max) {
        $errores[$campo] = "El campo $campo supera el máximo de $max caracteres.";
        return false;
    }

    // Validación con filtro y expresión regular adicional para control
    if (filter_var($email, FILTER_VALIDATE_EMAIL) &&
        preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
        return true;
    }

    $errores[$campo] = "El campo $campo no es un email válido.";
    return false;
}

function encriptar($password, $cost=10) {
    return password_hash($password, PASSWORD_DEFAULT, ['cost' => $cost]);
}

function comprobarhash($pass, $passBD) {
    // Primero comprobamos si se ha empleado una contraseña correcta:
    return password_verify($pass, $passBD) ;
}

//validar fecha dd/mm/aaaa
function cFechaddmmaaaa(string $fecha, string $campo, array &$errores, string $min = "01/01/1900", string $max = "31/12/2100"): bool
{
    // Verifica el formato dd/mm/aaaa
    if (preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $fecha)) {
        list($dia, $mes, $anio) = explode("/", $fecha);

        // Verifica si la fecha es válida (calendario real)
        if (checkdate((int)$mes, (int)$dia, (int)$anio)) {
            // Convertimos las fechas a timestamp para comparar rangos
            $fechaTimestamp = strtotime("$anio-$mes-$dia");
            $minTimestamp = strtotime(implode("-", array_reverse(explode("/", $min))));
            $maxTimestamp = strtotime(implode("-", array_reverse(explode("/", $max))));

            if ($fechaTimestamp < $minTimestamp || $fechaTimestamp > $maxTimestamp) {
                $errores[$campo] = "La fecha en $campo debe estar entre $min y $max";
                return false;
            }

            return true;
        } else {
            $errores[$campo] = "La fecha ingresada en $campo no es válida";
            return false;
        }
    }

    $errores[$campo] = "Formato de fecha no válido en $campo. Use dd/mm/aaaa";
    return false;
}

//validar fecha en formato aaaa/mm/dd
function cFechaaaaammdd(string $fecha, string $campo, array &$errores, string $min = "1900-01-01", string $max = "2100-12-31"): bool
{
    // Verifica si el formato es correcto con una expresión regular
    if (preg_match("/^\d{4}-\d{2}-\d{2}$/", $fecha)) {
        $timestamp = strtotime($fecha);
        if ($timestamp === false) {
            $errores[$campo] = "Fecha no válida en $campo";
            return false;
        }

        // Compara con los límites mínimos y máximos
        if ($fecha < $min || $fecha > $max) {
            $errores[$campo] = "La fecha en $campo debe estar entre $min y $max";
            return false;
        }

        return true;
    }

    $errores[$campo] = "Formato de fecha no válido en $campo";
    return false;
}


    
    ?>