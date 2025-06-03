<?php
class RutasEscalada extends Model
{

    public function insertarUsuario($nombreUsuario, $email,  $contrasenya)
    {
        $consulta = "INSERT INTO escalada.users (username, email, password_hash) VALUES (:nombreUsuario, :email, :password_hash)";
        $result = $this->conection->prepare($consulta);
        $result->bindParam(':nombreUsuario', $nombreUsuario);
        $result->bindParam(':email', $email);
        $result->bindParam(':password_hash', $contrasenya);
        $result->execute();
        return $result;
    }

    public function consultarUsuario($nombreUsuario)
    {
        $consulta = "SELECT * FROM escalada.users WHERE username=:nombreUsuario ";
        $result = $this->conection->prepare($consulta);
        $result->bindParam(':nombreUsuario', $nombreUsuario);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function listarRutas($idUsuario)
    {
        $consulta = "SELECT r.id, r.name AS route_name, r.meters, r.draws, r.country, r.location, s.name AS style,
                            r.pitches, r.tries, a.name AS ascent_type, r.date, r.comments, r.photo
                        FROM routes r
                        JOIN styles s ON r.style_id = s.id
                        JOIN ascent_types a ON r.ascent_type_id = a.id
                        WHERE r.user_id = :idUsuario -- ← aquí colocas el ID del usuario logueado
                        ORDER BY r.date DESC;";
        $result= $this->conection->prepare($consulta);
        $result->bindParam('idUsuario', $idUsuario);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
