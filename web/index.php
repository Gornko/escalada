<?php

//incluimos librerias y clases
require_once __DIR__."/../app/libs/bGeneral.php";
require_once __DIR__."/../app/libs/Config.php";
require_once __DIR__."/../app/modelo/Model.php";
require_once __DIR__ . '/../app/controlador/Controller.php';
require_once __DIR__."/../app/modelo/RutasEscalada.php";




//iniciamos la sesion
session_start();

//si no se ha definido la session, se definde en nivel 0
if (!isset($_SESSION['nivel'])) {
    $_SESSION['nivel'] = 0;
}


//mapeo de las rutas
$map=array(
    'login'=>array( 'controller'=>'Controller', 'action'=>'login', 'nivel'=>0),
    'inicio'=>array('controller'=>'Controller', 'action'=>'inicio', 'nivel'=>0),
    'error'=>array('controller'=>'Controller', 'action'=>'error', 'nivel'=>0),
    'home'=>array('controller'=>'Controller', 'action'=>'home', 'nivel'=>1),
    'registro'=>array('controller'=>'Controller', 'action'=>'registro', 'nivel'=>0),
    'logout'=>array('controller'=>'Controller', 'action'=>'logout', 'nivel'=>1),
    'buscar'=>array('controller'=>'Controller', 'action'=>'buscar', 'nivel'=>1),
    'anyadir'=>array('controller'=>'Controller', 'action'=>'anyadir', 'nivel'=>1),
    'perfil'=>array('controller'=>'Controller', 'action'=>'perfil', 'nivel'=>1),
    'stats'=>array('controller'=>'Controller', 'action'=>'stats', 'nivel'=>1),
    'admin'=>array('controller'=>'Controller', 'action'=>'admin', 'nivel'=>2)
);


//comprobamos si GET ya indica una accion, sino indicamos que la ruta sea al login
if(isset($_GET['ctl'])){
    if(isset($map[$_GET['ctl']])){
        $ruta=$_GET['ctl'];
    }else{
        $ruta='error';
    }
}else{
    $ruta='inicio';
}

//asignamos el controlador 
$controlador = $map[$ruta];


//se llama al metodo correspondiente
if (method_exists($controlador['controller'], $controlador['action'])) {
    if ($_SESSION['nivel'] >= $controlador['nivel']  ) {
        call_user_func(array(
            new $controlador['controller'],
            $controlador['action']
        ));
    }else{
        call_user_func(array(
            new $controlador['controller'],
            'inicio'
        )); 
    }
} else {
    call_user_func(array(
            new $controlador['controller'],
            'error'
        )); 
    
}