<?php

class Titular {

    public $nro_doc;
    public $apellido;
    public $nombre1;
    public $nombre2;
    public $fecha_nac;
    public $sexo;
    public $email;
    public $profesion;
    public $civil;
    public $telefono;
    public $lugar_de_trabajo;
    public $telefono_laboral;
    public $ciudad;
    public $l_trabajo;
    public $telefono_particular;

    //MUESTRA DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO
    function DatosContratante($num_solici,$editar){

        echo '<h1>DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO CLA</h1><br />';

        $contrato = new Datos;

	$campos = array('num_solici AS CONTRATO'=>'','t_apellidos AS APELLIDOS'=>'','t_nombre1 AS NOMBRE_1'=>'','t_nombre2 AS NOMBRE_2'=>'','titular AS RUT'=>'','t_fecha_nac AS F_NACIMIENTO'=>'','t_sexo AS SEXO'=>'','t_profesion AS PROFESION'=>'','telefono_emergencia AS FONO_EMERGENCIA'=>'','telefono_laboral AS FONO_LABORAL'=>'','telefono_particular AS FONO_PARTICULAR'=>'','trabajo AS LUGAR_DE_TRABAJO'=>'');
	$where = array('num_solici'=>' = "'.$num_solici.'"');
	$rut = array('RUT'=>"");
	$contrato->Imprimir($campos,"contr",$where,'2',$rut);

        if ($editar == 1){
            echo '<br/><div align="right"><a class="boton" href="INT/SUB_M_TESO_2.php?CONTRATANTE=1&CONTRATO='.$_GET['CONTRATO'].'">Editar</a></div><br />';
        }

        if ($editar == 0){
            echo '<br />';
        }
    }
}
?>
