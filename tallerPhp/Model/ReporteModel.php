<?php

require_once('DB.php');
class ReporteModel
{


    protected $table = "empleados";
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
        $sql = "SELECT * FROM {$this->table} WHERE idAuto = ?";
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
        $placa_auto = $dataArray['placa_auto'];
        $anho_modelo = $dataArray['anho_modelo'];
        $modelo = $dataArray['modelo'];
        $precio = $dataArray['precio'];

        $sql = "INSERT INTO {$this->table} (placa_auto, anho_modelo, modelo, precio) VALUES (:placa_auto, :anho_modelo, :modelo, :precio)";
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':placa_auto', $placa_auto);
        $stm->bindParam(':anho_modelo', $anho_modelo);
        $stm->bindParam(':modelo', $modelo);
        $stm->bindParam(':precio', $precio);
        $stm->execute();
        if ($stm->rowCount() == 1) {
            return true;
        }
        return false;
    }


    public function update($dataArray)
    {
        $idAuto = $dataArray['idAuto'];
        $placa_auto = $dataArray['placa_auto'];
        $anho_modelo = $dataArray['anho_modelo'];
        $modelo = $dataArray['modelo'];
        $precio = $dataArray['precio'];

        $sql = "UPDATE {$this->table} SET placa_auto = :placa_auto, anho_modelo = :anho_modelo, modelo = :modelo, precio = :precio  WHERE idAuto = :idAuto";
        $stm = $this->connection->prepare($sql);
        $stm->bindParam(':placa_auto', $placa_auto);
        $stm->bindParam(':anho_modelo', $anho_modelo);
        $stm->bindParam(':modelo', $modelo);
        $stm->bindParam(':precio', $precio);
        $stm->bindParam(':idAuto', $idAuto);
        if ( $stm->execute()) {
            return true;
        }
        return false;
    }


    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE idAuto = ?";
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
        $sql = "SELECT * FROM {$this->table} order by idAuto desc limit 1";
        $stm = $this->connection->prepare($sql);
        $stm->execute();
        $res = $stm->fetch(PDO::FETCH_ASSOC);
        if ($res == false) {
            return null;
        }
        return $res;
    }
}
