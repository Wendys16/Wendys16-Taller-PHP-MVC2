<?php
require_once 'Model/AutoModel.php';
require_once 'Model/EmpleadoModel.php';
class AutoController
{

    private $auto;
    private $empleado;
    private  $response;
    private $swContinuar = true;
    public function __construct()
    {
        $this->auto = new AutoModel();
        $this->empleado = new EmpleadoModel();
        $this->response =  array();
        $this->swContinuar =  true;
    }


    public function readAll()
    {
        $this->response = $this->auto->getAll();
        header('Content-type:application/json;charset=utf-8');
        echo json_encode([
            'datos' =>  $this->response
        ]);
    }

    public function readOne($dataArray)
    {
        $idAuto = $dataArray['idAuto'];
        $resultAuto = $this->auto->getById($idAuto);
        if ($resultAuto == null) {
            $this->response =  [
                'mensaje' => '0 registros encontrados'
            ];
        } else {
            array_push($this->response, $resultAuto);
        }
        header('Content-type:application/json;charset=utf-8');
        echo json_encode([
            'datos' => $this->response
        ]);
    }



    public function store($dataArray)
    {
        //validamos que vengan los datos para insertarlos
        $campos = array("placa_auto", "anho_modelo", "modelo", "precio");
        foreach ($campos as $valor) {
            if (!isset($dataArray[$valor])) {
                $this->response =  [
                    'mensaje' => 'se esperaba el parametro -> ' . $valor
                ];
                header('Content-type:application/json;charset=utf-8');
                echo json_encode($this->response);
                $this->swContinuar = false;
                break;
            } else if (isset($dataArray[$valor]) && empty($dataArray[$valor])) {
                $this->response =  [
                    'mensaje' => 'El parametro -> ' . $valor . ' no debe estar vacio'
                ];
                header('Content-type:application/json;charset=utf-8');
                echo json_encode($this->response);
                $this->swContinuar = false;
                break;
            }
        }

        if ($this->swContinuar) {
            //insertamos los datos en la tabla autos
            $rst = $this->auto->store($dataArray);
            if ($rst) {
                //recuperamos el auto insertado
                $resultAuto = $this->auto->getUltimo();
                $this->response =  [
                    'mensaje' => 'Registro Insertado satisfactoriamente',
                    'data' => $resultAuto
                ];
            } else {
                $this->response =  [
                    'mensaje' => 'Error, no se pudo insertar la informacion',
                ];
            }
            header('Content-type:application/json;charset=utf-8');
            echo json_encode($this->response);
        }
    }

    public function update($dataArray)
    {
        //validamos que vengan los datos para modificarlos
        $campos = array("placa_auto", "anho_modelo", "modelo", "precio");
        foreach ($campos as $valor) {
            if (!isset($dataArray[$valor])) {
                $this->response =  [
                    'mensaje' => 'se esperaba el parametro -> ' . $valor
                ];
                header('Content-type:application/json;charset=utf-8');
                echo json_encode($this->response);
                $this->swContinuar = false;
                break;
            } else if (isset($dataArray[$valor]) && empty($dataArray[$valor])) {
                $this->response =  [
                    'mensaje' => 'El parametro -> ' . $valor . ' no debe estar vacio'
                ];
                header('Content-type:application/json;charset=utf-8');
                echo json_encode($this->response);
                $this->swContinuar = false;
                break;
            }
        }

        if ($this->swContinuar) {
            //consultamos el registro antes de eliminar para ver si existe
            $resultAuto = $this->auto->getById($dataArray['idAuto']);
            if ($resultAuto == null) {
                $this->response =  [
                    'mensaje' => 'El registo que desea Actualizar no existe'
                ];
            } else {
                //modificamos los datos en la tabla autos
                $rst = $this->auto->update($dataArray);
                if ($rst) {
                    $resultAuto = $this->auto->getById($dataArray['idAuto']);
                    $this->response =  [
                        'mensaje' => 'Registro actualizado satisfactoriamente',
                        'data' => $resultAuto
                    ];
                } else {
                    $this->response =  [
                        'mensaje' => 'Error, no se pudo Actualizar la información'
                    ];
                }
            }
            header('Content-type:application/json;charset=utf-8');
            echo json_encode($this->response);
        }
    }


    public function delete($dataArray)
    {
        //obtenemos el id del registro a eliminar
        $idAuto = $dataArray['idAuto'];
        //consultamos el registro antes de eliminar para ver si existe
        $resultAuto = $this->auto->getById($idAuto);

        if ($resultAuto == null) {
            $this->response =  [
                'mensaje' => 'El registo que desea eliminar no existe'
            ];
        } else {
            $rst = $this->empleado->getByidAuto($idAuto);
            if ($rst != null) {
                $this->response =  [
                    'mensaje' => 'no se puedo eliminar el auto, El idAuto que desea eliminar esta asociado a un empleado'
                ];
            } else {
                if ($this->auto->delete($idAuto)) {
                    $this->response =  [
                        'mensaje' => 'Registro Eliminado satisfactoriamente',
                        'data' => $resultAuto
                    ];
                }
            }
        }
        header('Content-type:application/json;charset=utf-8');
        echo json_encode($this->response);
    }
}
