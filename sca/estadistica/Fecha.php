<?php

class Fecha {

    public  $dia;
    public  $mes;
    public  $anio;
    public  $mysql;
    public  $normal;
    private $operador = '-';
    public $mes_palabras;
    
    function __construct($fecha){

        @$m_fecha = explode($this->operador,$fecha);

        @$posicion0 = $m_fecha[0];
        @$posicion1 = $m_fecha[1];
        @$posicion2 = $m_fecha[2];

        if (@checkdate($m_fecha[1], $m_fecha[0], $m_fecha[2]) == true){
            $this->dia    = $m_fecha[0];
            $this->mes    = $m_fecha[1];
            $this->anio   = $m_fecha[2];
            $prueba1 = 1;

        }

        else
            if (@checkdate($m_fecha[1], $m_fecha[2], $m_fecha[0]) == true){
            $this->dia    = $m_fecha[2];
            $this->mes    = $m_fecha[1];
            $this->anio   = $m_fecha[0];
            $prueba2 = 1;
        }

        if (@$prueba1 == 1 || @$prueba2 ==1){
            $this->mysql  = $this->anio.$this->operador.$this->mes.$this->operador.$this->dia;
            $this->normal = $this->dia.$this->operador.$this->mes.$this->operador.$this->anio;

            switch ($this->mes) {
    case 1:
        $this->mes_palabras = 'Enero';
        break;
    case 2:
        $this->mes_palabras = 'Febrero';
        break;
    case 3:
        $this->mes_palabras = 'Marzo';
        break;

    case 4:
        $this->mes_palabras = 'Abril';
        break;

    case 5:
        $this->mes_palabras = 'Mayo';
        break;
    case 6:
        $this->mes_palabras = 'Junio';
        break;
    case 7:
        $this->mes_palabras = 'Julio';
        break;
    case 8:
        $this->mes_palabras = 'Agosto';
        break;
    case 9:
        $this->mes_palabras = 'Septiembre';
        break;
    case 10:
        $this->mes_palabras = 'Octubre';
        break;

    case 11:
        $this->mes_palabras = 'Noviembre';
        break;

    case 12:
        $this->mes_palabras = 'Diciembre';
        break;
}


        }
    }
    
    function calcularEdad(){


    $dia=date(j);
    $mes=date(n);
    $ano=date(Y);

    $dianaz= $this->dia;
    $mesnaz= $this->mes;
    $anonaz= $this->anio;


    if (($mesnaz == $mes) && ($dianaz > $dia)) {
        $ano=($ano-1);

        }

    if ($mesnaz > $mes) {
        $ano=($ano-1);

        }

    $edad=($ano-$anonaz);

    if ($edad < 1){

        $edad = 0;

    }

    return $edad;

    }

}
?>
