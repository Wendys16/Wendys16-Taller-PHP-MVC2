<?php

require_once('DB.php');

class EmpleadoModel
{


    protected $table = "empleados";
    private $connection;

    public function __construct()
    {
        $this->connection = DB::getInstance();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stm = $this->connection->prepare($sql);
        $stm->execute();
        $res = $stm->fetchAll(PDO::FETCH_ASSOC);
        if ($res == false) {
            return null;
        }
        return $res;
    }


    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE idEmpleado = ?";
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(1, $id);
        $stm->execute();
        $res = $stm->fetch(PDO::FETCH_ASSOC);
        if ($res == false) {
            return null;
        }
        return $res;
    }


    public function store($dataArray)
    {
        $nombre = $dataArray['nombre'];
        $apellido = $dataArray['apellido'];
        $fecha_hora_entrega = $dataArray['fecha_hora_entrega'];
        $fecha_nacimiento = $dataArray['fecha_nacimiento'];
        $telefono = $dataArray['telefono'];
        $estatura = $dataArray['estatura'];
        $email = $dataArray['email'];
        $fecha = $dataArray['fecha'];
        $idAuto = $dataArray['idAuto'];

        $sql = "INSERT INTO {$this->table} (nombre, apellido, fecha_hora_entrega, fecha_nacimiento, telefono, estatura, email, fecha, idAuto) values (:nombre, :apellido, :fecha_hora_entrega, :fecha_nacimiento, :telefono, :estatura, :email,  :fecha, :idAuto)";
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':nombre', $nombre);
        $stm->bindParam(':apellido', $apellido);
        $stm->bindParam(':fecha_hora_entrega', $fecha_hora_entrega);
        $stm->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stm->bindParam(':telefono', $telefono);
        $stm->bindParam(':estatura', $estatura);
        $stm->bindParam(':email', $email);
        $stm->bindParam(':fecha', $fecha);
        $stm->bindParam(':idAuto', $idAuto);
        $stm->execute();
        if ($stm->rowCount() == 1) {
            return true;
        }
        return false;
    }


    public function update($dataArray)
    {
        $idEmpleado = $dataArray['idEmpleado'];
        $nombre = $dataArray['nombre'];
        $apellido = $dataArray['apellido'];
        $fecha_hora_entrega = $dataArray['fecha_hora_entrega'];
        $fecha_nacimiento = $dataArray['fecha_nacimiento'];
        $telefono = $dataArray['telefono'];
        $estatura = $dataArray['estatura'];
        $email = $dataArray['email'];
        $fecha = $dataArray['fecha'];
        $idAuto = $dataArray['idAuto'];

        $sql = "UPDATE {$this->table} SET nombre = :nombre, apellido = :apellido, fecha_hora_entrega = :fecha_hora_entrega, fecha_nacimiento = :fecha_nacimiento, telefono = :telefono, estatura = :estatura, email = :email, fecha = :fecha, idAuto = :idAuto WHERE idEmpleado = :idEmpleado";
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':nombre', $nombre);
        $stm->bindParam(':apellido', $apellido);
        $stm->bindParam(':fecha_hora_entrega', $fecha_hora_entrega);
        $stm->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stm->bindParam(':telefono', $telefono);
        $stm->bindParam(':estatura', $estatura);
        $stm->bindParam(':email', $email);
        $stm->bindParam(':fecha', $fecha);
        $stm->bindParam(':idAuto', $idAuto);
        $stm->bindParam(':idEmpleado', $idEmpleado);
        if ($stm->execute()) {
            return true;
        }
        return false;
    }


    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE idEmpleado = ?";
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(1, $id);
        $stm->execute();
        if ($stm->rowCount() == 1) {
            return true;
        }
        return false;
    }

    public function getUltimo()
    {
        $sql = "SELECT * FROM {$this->table} order by idEmpleado desc limit 1";
        $stm = $this->connection->prepare($sql);
        $stm->execute();
        $res = $stm->fetch(PDO::FETCH_ASSOC);
        if ($res == false) {
            return null;
        }
        return $res;
    }

    public function getByidAuto($idAuto){
        $sql = "SELECT * FROM {$this->table} WHERE idAuto = ?";
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(1, $idAuto);
        $stm->execute();
        $res = $stm->fetchAll(PDO::FETCH_ASSOC);
        if ($res == false) {
            return null;
        }
        return $res;
    }

    public function crear_reporte($fecha1, $fecha2){
        
    }
}
