<?php
class Controller{

    public function inicio(){
        require __DIR__."/../../web/templates/inicio.php";
    }

    public function login(){
        require __DIR__."/../../web/templates/login.php";
    }

    public function registro(){
        require __DIR__."/../../web/templates/registro.php";
    }
}