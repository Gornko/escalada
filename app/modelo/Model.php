<?php
// Clase que conecta a la BD
class Model
{
    protected $conection = null;

    public function __construct()
    {
        $this->conection = new PDO(
            'mysql:host=' . Config::$db_host . ';dbname=' . Config::$db_name,
            Config::$db_user,
            Config::$db_password
        );
        $this->conection->exec("set names utf8");
        $this->conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
