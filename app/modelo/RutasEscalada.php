<?php
class RutasEscalada extends Model
{

    public function insertarUsuario($nombreUsuario, $email,  $contrasenya, $fileName)
    {
        $consulta = "INSERT INTO escalada.users (username, email, password_hash, profile_image) VALUES (:nombreUsuario, :email, :password_hash, :profile_image)";
        $result = $this->conection->prepare($consulta);
        $result->bindParam(':nombreUsuario', $nombreUsuario);
        $result->bindParam(':email', $email);
        $result->bindParam(':password_hash', $contrasenya);
        $result->bindParam(':profile_image', $fileName);
        $result->execute();
        return $result;
    }

    //devuelve la info de un usuario
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
                        WHERE r.user_id = :idUsuario 
                        ORDER BY r.date DESC;";
        $result = $this->conection->prepare($consulta);
        $result->bindParam('idUsuario', $idUsuario);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertarRuta($idUsuario,$nombre,$metros = '',$cintas = '',$pais = '',$localidad = '',$estilo = '',
                                $largos = '',$pegues = '',$encadene = '',$fecha = '',$comentarios = '', $fileName) 
    {
        $consulta = "INSERT INTO escalada.routes (user_id, `name`, meters, draws, country, `location`, style_id, pitches, tries, ascent_type_id, `date`, comments, photo)
                    VALUES (:idUsuario, :nombre, :metros, :cintas, :pais, :localidad, :estilo, :largos, :pegues, :encadene, :fecha, :comentarios, :photo)";
        
        $result=$this->conection->prepare($consulta);
        $result->bindParam(':idUsuario', $idUsuario);
        $result->bindParam(':nombre', $nombre);
        $result->bindParam(':metros', $metros);
        $result->bindParam(':cintas', $cintas);
        $result->bindParam(':pais', $pais);
        $result->bindParam(':localidad', $localidad);
        $result->bindParam(':estilo', $estilo);
        $result->bindParam(':largos', $largos);
        $result->bindParam(':pegues', $pegues);
        $result->bindParam(':encadene', $encadene);
        $result->bindParam(':fecha', $fecha);
        $result->bindParam(':comentarios', $comentarios);
        $result->bindParam(':photo', $fileName);

        $result->execute();
        return $result;

    }

// la funcion busca en la tabla rutas en funcion del campo que se le pase por parametro
    public function buscarRutas($idUsuario,$params, $campo)
    {
        switch($campo){
            case 'nombre':
                $columna='r.name';
                break;
            case 'pais':
                $columna='r.country';
                break;
            case 'estilo':
                $columna='r.style_id';
                break;
            case 'encadene':
                $columna='r.ascent_type_id';
                break;
        }

        $consulta = "SELECT r.id, r.name AS route_name, r.meters, r.draws, r.country, r.location, s.name AS style,
                            r.pitches, r.tries, a.name AS ascent_type, r.date, r.comments, r.photo
                        FROM routes r
                        JOIN styles s ON r.style_id = s.id
                        JOIN ascent_types a ON r.ascent_type_id = a.id
                        WHERE r.user_id = :idUsuario AND $columna = :valor
                        ORDER BY r.date DESC;";
        $result = $this->conection->prepare($consulta);
        $result->bindParam(':idUsuario', $idUsuario);
        $result->bindParam(':valor', $params);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    //elimina usuario segun id
    public function eliminarUsuario($idUsuario){

        $consulta="DELETE FROM routes WHERE user_id=:id;
                    DELETE FROM users WHERE id = :id";
        $result=$this->conection->prepare($consulta);
        $result->bindParam(':id', $idUsuario);
        $result->execute();
        return $result;

    }
}
