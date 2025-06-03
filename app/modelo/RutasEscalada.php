<?php
class RutasEscalada extends Model{

    public function insertarUsuario($nombreUsuario, $email,  $contrasenya) {
        $consulta = "INSERT INTO escalada.users (username, email, password_hash) VALUES (:nombreUsuario, :email, :password_hash)";
        $result = $this->conection->prepare($consulta);
        $result->bindParam(':nombreUsuario', $nombreUsuario);
        $result->bindParam(':email', $email);
        $result->bindParam(':password_hash', $contrasenya);
        $result->execute();
        return $result;
    }

}