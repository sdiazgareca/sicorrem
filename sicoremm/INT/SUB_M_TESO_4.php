<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');

$sql['uno'] = "UPDATE contratos SET contratos.empresa=NULL, doc_pago=NULL WHERE contratos.num_solici='".$_POST['num_soloci']."'";
$sql['dos'] = "DELETE FROM doc_f_pago WHERE numero='".$_POST['num_soloci']."'";


foreach($_POST  AS $campo=>$valor){
    if($valor == "" && $campo =! 'n_original' ){
        
        echo '<div class="mensaje2">Debe llenar todos los campos.</div>';
        exit;
    }

}


if ($_POST['f_pago'] == 100){

    $sql['cinco'] = "INSERT INTO doc_f_pago (numero,titular_cta,rut_titular_cta,cta,t_credito,banco,nombre2,apellidos)
VALUES('".$_POST['num_soloci']."','".$_POST['NOMBRE1_TC']."','".$_POST['RUT_TITULAR_CUENTA']."',
    '".$_POST['N_CUENTA']."',NULL,'".$_POST['Banco']."','".$_POST['NOMBRE2_TC']."','".$_POST['AP_TITULAR']."')";

    $sql['cuatro']="UPDATE contratos SET contratos.f_pago='100',ZO='777',SE='777',MA ='777', doc_pago='".$_POST['num_soloci']."' WHERE contratos.num_Solici='".$_POST['num_soloci']."'";

    $cambia = new Datos;
    $cambia->Trans($sql);

}


if ($_POST['f_pago'] == 200){

    $sql['cinco'] = "INSERT INTO doc_f_pago (numero,titular_cta,rut_titular_cta,cta,t_credito,banco,nombre2,apellidos)
VALUES('".$_POST['num_soloci']."','".$_POST['NOMBRE1_TC']."','".$_POST['RUT_TITULAR_CUENTA']."',
    '".$_POST['N_CUENTA']."','".$_POST['tc']."',NULL,'".$_POST['NOMBRE2_TC']."','".$_POST['AP_TITULAR']."')";

    $sql['cuatro']="UPDATE contratos SET contratos.f_pago='200',ZO='888',SE='888',MA ='888', doc_pago='".$_POST['num_soloci']."' WHERE contratos.num_Solici='".$_POST['num_soloci']."'";

    $cambia = new Datos;
    $cambia->Trans($sql);

}


if ($_POST['f_pago'] == 300){


    $nro_doc_sql ="SELECT contratos.titular from contratos WHERE contratos.num_solici='".$_POST['num_soloci']."'";
    $query_contrato = mysql_query($nro_doc_sql);
    $nro_doc = mysql_fetch_array($query_contrato);

    $sql['tres'] = "DELETE FROM domicilios WHERE domicilios.tipo_dom=1 AND domicilios.num_solici='".$_POST['num_soloci']."'";


    $sql['cinco'] = "INSERT INTO domicilios
(calle,numero,piso,departamento,localidad,telefono,email,num_solici,nro_doc,entre,tipo_dom)
VALUES('".$_POST['calle']."','".$_POST['numero']."','".$_POST['piso']."','".$_POST['departamento']."','".$_POST['localidad']."','".$_POST['telefono']."','".$_POST['email']."','".$_POST['num_soloci']."','".$nro_doc['titular']."','".$_POST['entre']."',1)";

    $sql['cuatro']="UPDATE contratos SET contratos.f_pago='300' WHERE contratos.num_Solici='".$_POST['num_soloci']."'";

    $cambia = new Datos;
    $cambia->Trans($sql);

}


if ($_POST['f_pago'] == 400){


    $nro_doc_sql ="SELECT ZO,SE,MA FROM empresa WHERE empresa.nro_doc='".$_POST['empresa']."'";
    $query_contrato = mysql_query($nro_doc_sql);
    $nro_doc = mysql_fetch_array($query_contrato);

    $sql['cuatro']="UPDATE contratos SET ZO='".$nro_doc['ZO']."',SE='".$nro_doc['SE']."',MA='".$nro_doc['MA']."', contratos.f_pago='400', contratos.empresa='".$_POST['empresa']."' WHERE contratos.num_Solici='".$_POST['num_soloci']."'";

    $cambia = new Datos;
    $cambia->Trans($sql);

}


if ($_POST['f_pago'] == 500){


    $sql['cuatro']="UPDATE contratos SET ZO='111',SE='111',MA='111', contratos.f_pago='500', contratos.d_pago='".$_POST['d_pago']."' WHERE contratos.num_Solici='".$_POST['num_soloci']."'";

    $cambia = new Datos;
    $cambia->Trans($sql);

}


?>
