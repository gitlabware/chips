<?php

/* /app/View/Helper/LinkHelper.php */
App::uses('AppHelper', 'View/Helper');

class UtilidadesHelper extends AppHelper
{
    //public function makeEdit($title, $url) {
    // Logic to create specially formatted link goes here...
    //}
    /**
     * @param dateTime se envia la fecha en formato ('Y-m-d H:m:s') Ej: Ej; (2012-02-24 23:45:12)
     * @return string la fecha en formato (Miercoles, 22 de Agosto de 2012 Hrs 16:22:07)
     */
     public function mostrarfecha($fecha){
        $arreglo_cadena = explode("-", $fecha);

        $arreglo = $arreglo_cadena[2] . '/' . $arreglo_cadena[1] . '/' . $arreglo_cadena[0];
        //debug($arreglo);
        echo $arreglo;
     }
	 public function mes($mes){
	    switch ($mes)
        {
            case "1":
                $mes_nombre = "Enero";
                break;
            case "2":
                $mes_nombre = "Febrero";
                break;
            case "3":
                $mes_nombre = "Marzo";
                break;
            case "4":
                $mes_nombre = "Abril";
                break;
            case "5":
                $mes_nombre = "Mayo";
                break;
            case "6":
                $mes_nombre = "Junio";
                break;
            case "7":
                $mes_nombre = "Julio";
                break;
            case "8":
                $mes_nombre = "Agosto";
                break;
            case "9":
                $mes_nombre = "Septiembre";
                break;
            case "10":
                $mes_nombre = "Octubre";
                break;
            case "11":
                $mes_nombre = "Noviembre";
                break;
            case "12":
                $mes_nombre = "Diciembre";
                break;
        }
		echo $mes_nombre;
	 }
    public function fechahoraes($fecha)
    {        
        $pieza = explode(" ", $fecha);
        $fecha_proc = $pieza[0];
        $hora_proc = $pieza[1];

        list($ano, $mes, $dia) = explode("-", $fecha_proc);

        $dias = array(
            'Domingo',
            'Lunes',
            'Martes',
            'Miercoles',
            'Jueves',
            'Viernes',
            'Sabado');
        $dia_semana = $dias[date("w", mktime(0, 0, 0, $mes, $dia, $ano))];

        switch ($mes)
        {
            case "1":
                $mes_nombre = "Enero";
                break;
            case "2":
                $mes_nombre = "Febrero";
                break;
            case "3":
                $mes_nombre = "Marzo";
                break;
            case "4":
                $mes_nombre = "Abril";
                break;
            case "5":
                $mes_nombre = "Mayo";
                break;
            case "6":
                $mes_nombre = "Junio";
                break;
            case "7":
                $mes_nombre = "Julio";
                break;
            case "8":
                $mes_nombre = "Agosto";
                break;
            case "9":
                $mes_nombre = "Septiembre";
                break;
            case "10":
                $mes_nombre = "Octubre";
                break;
            case "11":
                $mes_nombre = "Noviembre";
                break;
            case "12":
                $mes_nombre = "Diciembre";
                break;
        }
        echo $dia_semana . ", " . $dia . " " . " de " . $mes_nombre . " de " . $ano. " Hrs ".$hora_proc;

    }
    
    /**
     * @param dateTime se envia la fecha en formato ('Y-m-d') . Ej; (2012-02-24)   
     * @return string la fecha en formato (Miercoles, 22 de Agosto de 2012)
     */
    public function fechaes($fecha)
    {
        //$pieza = explode(" ", $fecha);
        //$fecha_proc = $pieza[0];
        //$hora_proc = $pieza[1];
        list($ano, $mes, $dia) = explode("-", $fecha);
        
        $dias = array(
            'Domingo',
            'Lunes',
            'Martes',
            'Miercoles',
            'Jueves',
            'Viernes',
            'Sabado');
        $dia_semana = $dias[date("w", mktime(0, 0, 0, $mes, $dia, $ano))];

        switch ($mes)
        {
            case "1":
                $mes_nombre = "Enero";
                break;
            case "2":
                $mes_nombre = "Febrero";
                break;
            case "3":
                $mes_nombre = "Marzo";
                break;
            case "4":
                $mes_nombre = "Abril";
                break;
            case "5":
                $mes_nombre = "Mayo";
                break;
            case "6":
                $mes_nombre = "Junio";
                break;
            case "7":
                $mes_nombre = "Julio";
                break;
            case "8":
                $mes_nombre = "Agosto";
                break;
            case "9":
                $mes_nombre = "Septiembre";
                break;
            case "10":
                $mes_nombre = "Octubre";
                break;
            case "11":
                $mes_nombre = "Noviembre";
                break;
            case "12":
                $mes_nombre = "Diciembre";
                break;
        }
        echo $dia_semana . ", " . $dia . " " . " de " . $mes_nombre . " de " . $ano;

    }
}
