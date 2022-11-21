<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


// 1. Validar la existencia del parametro 'controller'
// ...
if (isset($_GET['controller'])) {
    $nameController = ucfirst($_GET['controller']) . 'Controller';
    $pathController = 'Controller/' . $nameController . '.php';
    // 2. Validar la existencia del archivo
    // ...

    // 3. Validar la existencia del parámetro 'action'
    // ..
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        require_once $pathController;
        $controller = new $nameController();

        if ($action == 'store' || $action == 'update' || $action == 'delete' ||  $action == 'readOne'|| $action == 'reporte') {
            //almaceno todas las variables POST O GET
            $variablesPostOrGet = array();

            if ($action == 'readOne') {
                foreach ($_GET as $nombre_campo => $valor) {
                    $variablesPostOrGet += [$nombre_campo => $valor];
                }
            } else {
                foreach ($_POST as $nombre_campo => $valor) {
                    $variablesPostOrGet += [$nombre_campo => $valor];
                }
            }

            //echo $variablesPost['idEmpleado'] . PHP_EOL;
            $controller->$action($variablesPostOrGet);
        } else if ($action == 'readAll') {
            $controller->$action();
        } else {
            echo json_encode([
                'Mensaje' => 'La accion que intenta realizar no esta disponible'
            ]);
        }

    } else {
        echo json_encode([
            'Mensaje' => 'la variable [action] no esta presente en la URL'
        ]);
    }
} else {
    echo json_encode([
        'Mensaje' => 'la variable [controller] no esta presente en la URL'
    ]);
}
