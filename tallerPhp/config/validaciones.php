<?php

class validaciones
{


    public function validarFormatoFecha($tipo, $dato)
    {
        $reg = "";
        if ($tipo == 'date') {
            $expresion = '~(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/](19|20)\d\d~';
            if (!preg_match($expresion, $dato)) {
                return false;
            }
        }
        return true;
    }

    public function validarTipo($tipo, $dato)
    {

        if ($tipo == 'cadena') {
            if (preg_match("/^[a-zA-Z0-9]+$/", $dato)) {
                return true;
            } else {
                return false;
            }
        } else if ($tipo == 'numero') {
            if (preg_match('/^[0-9]*$/', $dato)) {
                return true;
            } else {
                return false;
            }
        } else if ($tipo == 'email') {
            if (preg_match('/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/', $dato)) {
                return true;
            } else {
                return false;
            }
        } else if ($tipo == 'date') {
            if (preg_match("~(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/](19|20)\d\d~", $dato)) {
                return true;
            } else {
                return false;
            }
        }
    }
}
