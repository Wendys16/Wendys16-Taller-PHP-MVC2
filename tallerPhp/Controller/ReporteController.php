<?php
require_once 'Model/AutoModel.php';
require_once 'Model/EmpleadoModel.php';
require_once 'Model/ReporteModel.php';
require_once 'config/validaciones.php';
class ReporteController
{

    private $auto;
    private $empleado;
    private  $response;
    private  $reporte;
    private $validaciones;
    public function __construct()
    {
        $this->auto = new AutoModel();
        $this->reporte = new ReporteModel();
        $this->empleado = new EmpleadoModel();
        $this->validaciones = new validaciones();
        $this->response =  array();
        $this->swContinuar =  true;
    }


    public function reporte($dataArray)
    {
        //validamos que vengan los datos para insertarlos
        $campos = array("fecha_ini", "fecha_fin");
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
            } else if (!$this->validaciones->validarTipo("date", $dataArray[$valor])) {
                echo  $dataArray[$valor];
                    $str = 'El campo [' . $valor . '] debe estar en formato dd/mm/aaaa';
                    $this->response =  ['mensaje' => $str];
                    header('Content-type:application/json;charset=utf-8');
                    echo json_encode($this->response);
                    $this->swContinuar = false;
                    break;
                
            }
        }

      
    }
}
