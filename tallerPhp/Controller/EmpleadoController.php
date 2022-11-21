<?php
require_once 'Model/EmpleadoModel.php';
require_once 'Model/AutoModel.php';
require_once 'config/validaciones.php';
class EmpleadoController
{

    private $empleado;
    private $auto;
    private $validaciones;
    private  $response;
    private $swContinuar;

    public function __construct()
    {
        $this->empleado = new EmpleadoModel();
        $this->auto = new AutoModel();
        $this->validaciones = new validaciones();
        $this->response =  array();
        $this->swContinuar = true;
    }


    public function readAll()
    {

        // consultamos los datos de los empleados
        $resultEmpleados = $this->empleado->getAll();
        if ($resultEmpleados == null) {
            $this->response =  [
                'mensaje' => '0 registros encontrados'
            ];
        } else {
            foreach ($resultEmpleados as $row) {
                //consultamos los datos del auto de ese empleado
                $resultAuto = $this->auto->getById($row['idAuto']);
                //creamos un objeto temporal con la informacion del empleado y el auto relacionado
                $row["idAuto"] = $resultAuto;
                array_push($this->response, $row);
            }
        }
        header('Content-type:application/json;charset=utf-8');
        echo json_encode([
            'datos' => $this->response
        ]);
    }

    public function readOne($dataArray)
    {
        $idEmpleado = $dataArray['idEmpleado'];
        $resultEmpleado = $this->empleado->getById($idEmpleado);
        if ($resultEmpleado == null) {
            $this->response =  [
                'mensaje' => '0 registros encontrados'
            ];
        } else {
            //consultamos los datos del auto de ese empleado
            $resultAuto = $this->auto->getById($resultEmpleado['idAuto']);
            $resultEmpleado["idAuto"] = $resultAuto;
            array_push($this->response, $resultEmpleado);
        }
        header('Content-type:application/json;charset=utf-8');
        echo json_encode([
            'datos' => $this->response
        ]);
    }


    public function store($dataArray)
    {
        //validamos que los datos vengan correctos para insertarlos
        $campos = array("nombre", "apellido", "fecha_hora_entrega", "fecha_nacimiento", "telefono", "estatura", "email", "fecha", "idAuto");
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
                echo $valor;
                $this->response =  ['mensaje' => 'El parametro -> ' . $valor . ' no debe estar vacio'];
                header('Content-type:application/json;charset=utf-8');
                echo json_encode($this->response);
                $this->swContinuar = false;
                break;
            } 
            /*else {
                if (isset($dataArray[$valor]) && !empty($dataArray[$valor])) {
                    if ($valor == "nombre" || $valor == "apellido") { 
                        if (!$this->validaciones->validarTipo("cadena", $dataArray[$valor])) {
                            $str = 'El campo [' . $valor . '] solo acepta numeros y letras';
                            $this->response =  ['mensaje' => $str];
                            $this->swContinuar = false;
                            break;
                        }
                    } 
                    if ($valor == "telefono" || $valor == "estatura" || $valor == "idAuto") {
                        if (!$this->validaciones->validarTipo("numero", $dataArray[$valor])) {
                            $str = 'El campo [' . $valor . '] solo acepta numeros';
                            $this->response =  ['mensaje' => $str];
                            $this->swContinuar = false;
                            break;
                        }
                    } 

                    if ($valor == "fecha_nacimiento" || $valor == "fecha") {
                        echo $valor;

                        if (!$this->validaciones->validarTipo("date", $dataArray[$valor])) {
                            $str = 'El campo [' . $valor . '] debe estar en formato dd/mm/aaaa';
                            $this->response =  ['mensaje' => $str];
                            $this->swContinuar = false;
                            break;
                        }
                    } 
                    if ($valor == "email") {
                        if (!$this->validaciones->validarTipo("email", $dataArray[$valor])) {
                            $str = 'El campo [' . $valor . '] debe estar en formato dd/mm/aaaa';
                            $this->response =  ['mensaje' => $str];
                            $this->swContinuar = false;
                            break;
                        }
                    }
                }
            }*/

            /**/
        }
        if ($this->swContinuar) {
            //consultamos si el auto que se le asigna al empleado existe en la tabla autos
            $resultAuto = $this->auto->getById($dataArray['idAuto']);
            if ($resultAuto == null) {
                $this->response =  [
                    'mensaje' => 'El id del auto que intenta asignar al empleado, no existe',
                ];
            } else {
                //insertamos los datos en la tabla empleados
                $rst = $this->empleado->store($dataArray);
                if ($rst) {
                    //recuperamos el empleado insertado
                    $resultEmpleado = $this->empleado->getUltimo();
                    //consultamos los datos del auto de ese empleado
                    $resultAuto = $this->auto->getById($resultEmpleado['idAuto']);
                    //relacionamos el auto al empleado
                    $resultEmpleado["idAuto"] = $resultAuto;
                    $this->response =  [
                        'mensaje' => 'Registro Insertado satisfactoriamente',
                        'data' => $resultEmpleado
                    ];
                } else {
                    $this->response =  [
                        'mensaje' => 'Error, no se pudo insertar la informacion',
                    ];
                }
            }
            header('Content-type:application/json;charset=utf-8');
            echo json_encode($this->response);
        }
    }



    public function update($dataArray)
    {
        //validamos que vengan los datos para insertarlos
        $campos = array("idEmpleado", "nombre", "apellido", "fecha_hora_entrega", "fecha_nacimiento", "telefono", "estatura", "email", "fecha", "idAuto");
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
            $resultempleado = $this->empleado->getById($dataArray['idEmpleado']);
            //print_r($resultempleado['idEmpleado']);
            if ($resultempleado == null) {
                $this->response =  [
                    'mensaje' => 'El registo que desea Actualizar no existe'
                ];
            } else {
                //consultamos si el auto que se le asigna al empleado existe en la tabla autos
                $resultAuto = $this->auto->getById($dataArray['idAuto']);
                if ($resultAuto == null) {
                    $this->response =  [
                        'mensaje' => 'El id del auto que intenta asignar al empleado, no existe',
                    ];
                } else {
                    //modificamos los datos en la tabla empleados
                    $rst = $this->empleado->update($dataArray);
                    if ($rst) {
                        //recuperamos el empleado MODIFICADO
                        $resultEmpleado = $this->empleado->getById($dataArray['idEmpleado']);
                        //consultamos los datos del auto de ese empleado
                        $resultAuto = $this->auto->getById($resultEmpleado['idAuto']);
                        //relacionamos el auto al empleado
                        $resultEmpleado["idAuto"] = $resultAuto;
                        $this->response =  [
                            'mensaje' => 'Registro actualizado satisfactoriamente',
                            'data' => $resultEmpleado
                        ];
                    } else {
                        $this->response =  [
                            'mensaje' => 'Error, no se pudo Actualizar la información'
                        ];
                    }
                }
            }
            header('Content-type:application/json;charset=utf-8');
            echo json_encode($this->response);
        }
    }

    public function delete($dataArray)
    {
        //obtenemos el id del registro a eliminar
        $idEmpleado = $dataArray['idEmpleado'];
        //consultamos el registro antes de eliminar para ver si existe
        $resultempleado = $this->empleado->getById($idEmpleado);
        //print_r($resultempleado['idEmpleado']);
        if ($resultempleado == null) {
            $this->response =  [
                'mensaje' => 'El registo que desea eliminar no existe'
            ];
        } else {
            //consultamos los datos del auto de ese empleado
            $resultAuto = $this->auto->getById($resultempleado['idAuto']);
            //Eliminamos el registro de la tabla empleado

            if ($this->empleado->delete($idEmpleado)) {
                $resultempleado["idAuto"] = $resultAuto;
                $this->response =  [
                    'mensaje' => 'Registro Eliminado satisfactoriamente',
                    'data' => $resultempleado
                ];
            }
        }
        header('Content-type:application/json;charset=utf-8');
        echo json_encode($this->response);
    }
}
