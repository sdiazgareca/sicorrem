<script type="text/javascript">

$(document).ready(function() {

$('#ajax1 a:contains("Recargar")').click(function() {
	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });



});

</script>

<?php


include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');
include_once('../CLA/Afiliados.php');
include_once('../CLA/Titular.php');
include_once('../CLA/Contrato.php');

//COMPROBAR RUT EXISTENTES

if ($_POST['afi'] > 0){
$rut = new Datos;

$rut->Rut($_POST['nro_doc']);

$sql = "SELECT nro_doc FROM afiliados WHERE nro_doc = '".$rut->nro_doc."'
    AND (cod_baja = 'AZ' || cod_baja ='00' || cod_baja= '01' || cod_baja='05')";
$query = mysql_query($sql);
$num = mysql_num_rows($query);

$sql2 = "SELECT titulares.nro_doc, contratos.estado FROM titulares
INNER JOIN contratos ON contratos.titular = titulares.nro_doc
WHERE titulares.nro_doc='".$rut->nro_doc."' AND (estado = 900 || estado ='3600' || estado='3100')";
$query2 = mysql_query($sql2);
$num2 = mysql_num_rows($query2);


if ($num > 0 || $num2 > 0){

        if($num2 > 0){
	echo '<div class="mensaje2"><img src="IMG/M2.png" />El afiliado existe como titular en otro contrato y tiene deuda pendiente</div>';
	echo '<div align="right" style="padding:10px;">
	  <a href="INT/M_CONT.php?ver=1&CONTRATO='.$_POST['num_solici'].'" class="boton">Recargar</a>
	  </div>';
        }

        if($num > 0){
	echo '<div class="mensaje2"><img src="IMG/M2.png" />El afiliado existe en la base de datos como activo</div>';
	echo '<div align="right" style="padding:10px;">
	  <a href="INT/M_CONT.php?ver=1&CONTRATO='.$_POST['num_solici'].'" class="boton">Recargar</a>
	  </div>';
        }

}
else{

$fech = $rut->cambiaf_a_mysql($_POST['fecha_nac']);

if ( $_POST['titular'] != $rut->nro_doc ) {
	$categoria = '2';
}

else{
	$categoria = '1';
}

$dat = new Datos;

$inser['cont'] ="INSERT INTO afiliados (nro_doc,nombre1,nombre2,apellido,sexo,obra_afi,obra_numero,fecha_nac,cod_parentesco,
num_solici,cod_plan,tipo_plan,fecha_alta,titular,fecha_act,fecha_ing,pais,cod_baja, categoria)
VALUES('".$rut->nro_doc."','".$_POST['nombre1']."','".$_POST['nombre2']."','".$_POST['apellido']."','".$_POST['sexo']."','".$_POST['obra_afi']."','".$_POST['obra_afi']."',
'".$fech."' ,'".$_POST['cod_parentesco']."','".$_POST['num_solici']."',
'".$_POST['cod_plan']."','".$_POST['tipo_plan']."','".$_POST['fecha_alta']."','".$_POST['titular']."','".$_POST['fecha_act']."',
'".$_POST['fecha_ing']."','".$_POST['pais']."','".$_POST['cod_baja']."','".$categoria."')";


foreach( $_POST as $campo => $valor){

	$cadena = explode("_",$campo);

	if ($cadena[0] == "ATE"  &&  $valor > 0){
		$inser[$campo.$valor] = "INSERT INTO `sicoremm2`.`ate_medicos_reg`(`codigo`,`ate_medicos`,`num_solici`) VALUES ( '".$rut->nro_doc."','".$valor."',".$_POST['num_solici'].")";

	}
}


$dat->Trans($inser);



	//DATOS DEL CONTRATO
        $afi = new Afiliados;
        $afi->VerAfiliado($_POST['num_solici'],'BUSQ/M_BUSQ_SUB_1.php?editar_afi=1','0',$rut->nro_doc);


}

}


if ($_POST['BOLL']){

	//CALCULCA COMISIONES
	$sql = "SELECT
			ventas_reg.monto,
                        mes_pago_inicial,
			ventas_reg.vendedor,
			vendedor.cat,
			ventas_reg.num_solici,
			contratos.f_pago,
			f_pago.comi_free,
			f_pago.locomocion,
			contratos.cod_plan,
			contratos.tipo_plan,
                        contratos.titular
			FROM ventas_reg
			INNER JOIN vendedor ON ventas_reg.vendedor = vendedor.nro_doc
			INNER JOIN contratos ON contratos.num_solici = ventas_reg.num_solici
			INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
			WHERE contratos.num_solici ='".$_POST['num_solici']."'
			";

        $query = mysql_query($sql);
	$comi = mysql_fetch_array($query);

       // echo 'categoria '.$comi['cat'];

        if( $comi['cat'] == '100'){
	$comision = $comi['monto'] * $comi['comi_free'] /100;
        }

        else{
            $comision = '0';
        }

//echo $_POST['n_boleta'];

	$query2['boleta'] = "UPDATE ventas_reg SET estado_venta='100', n_documento='".$_POST['n_boleta']."',locominion='".$comi['locomocion']."',comision='".$comision."', porcentaje = '".$comi['comi_free']."' WHERE num_solici='".$_POST['num_solici']."' AND cat_venta='100' AND vendedor='".$comi['vendedor']."'";

        //echo $query2['boleta'].'<br />';


	$query2['contrato'] = "UPDATE contratos SET estado='500' WHERE num_solici='".$_POST['num_solici']."'";


/*$query2['cta'] ="INSERT INTO cta(tipo_comp,serie,tip_doc,nro_doc,comprovante,cod_mov,afectacion,fecha_mov,importe,cobrador,num_solici,debe)VALUES ('B','50','1','".$comi['titular']."','".$_POST['n_boleta']."','1','','".$comi['mes_pago_inicial']."','".$comi['monto']."','1','".$_POST['num_solici']."','".$comi['monto']."')";*/



	$tr = new Datos;
	$tr->Trans($query2);


       $afi = new Afiliados;
       $afi->Secuencia($_POST['num_solici']);

	$contrato = new Datos;
	$campos = array('num_solici AS CONTRATO'=>'','t_apellidos AS APELLIDOS'=>'','t_nombre1 AS NOMBRE_1'=>'','t_nombre2 AS NOMBRE_2'=>'','titular AS RUT'=>'','t_fecha_nac AS F_NACIMIENTO'=>'','t_sexo AS SEXO'=>'','t_profesion AS PROFESION'=>'','telefono_emergencia AS FONO_EMERGENCIA'=>'','telefono_laboral AS FONO_LABORAL'=>'','telefono_particular AS FONO_PARTICULAR'=>'','trabajo AS LUGAR_DE_TRABAJO'=>'');
	$where = array('num_solici'=>' = "'.$_POST['num_solici'].'"');
	$rut = array('RUT'=>"");
	$contrato->Imprimir($campos,"contr",$where,'2',$rut);

        //DATOS DEL RESPONSABLE DEL PAGO
        $datosRespo = new Titular();
        $datosRespo->DatosContratante($_POST['num_solici'],1);

        //VALOR MENSUAL DE LOS SERVICIOS
        $valorMensual = new Contrato;
        $valorMensual->ValorMensual($_POST['num_solici'],1);

        //OBTIENE FORMA DE PAGO
        $pago = "SELECT contr.cod_f_pago FROM contr WHERE contr.num_solici='".$_GET['CONTRATO']."'";
        $pago_sql = mysql_query($pago);
        $tipo_pago = mysql_fetch_array($pago_sql);

        //FORMA DE PAGO MENSUAL
        $valorMensual->FormaPago($_POST['num_solici'],$tipo_pago['cod_f_pago'],0);

        //OBTIENE LA FORMA DE PAGO
        $sql3 ="SELECT cod_pago_venta, des_pago_venta FROM REG_VENTAS WHERE num_solici='".$_POST['num_solici']."'";
        $query = mysql_query($sql3);
        $fpago = mysql_fetch_array($query);

        //FORMA DE PAGO INICIAL
        $valorMensual->FormaPagoInicial($_POST['num_solici'],$fpago['cod_pago_venta'],0);

	//DATOS DEL CONTRATO
        //echo 'acap';
	$sql = "SELECT num_solici, contratos.titular, contratos.secuencia, contratos.cod_plan, contratos.tipo_plan FROM contratos WHERE contratos.num_solici='".$_POST[�num_solici�]."'";
	$query = mysql_query($sql);
	$comi = mysql_fetch_array($query);

        echo '<h1>GRUPO FAMILIAR</h1>';
        $afi = new Afiliados;
        $afi->VerAfiliados($_POST['num_solici'],'BUSQ/M_BUSQ_SUB_1.php?editar_afi=1','0');

?>


<div>
<a target="_blank" href="BIN/DOC1.pdf" class="boton">C. Bienv</a>
<a target="_blank" href="BIN/BOLL.php?boleta=<?php echo $_POST['n_boleta']; ?>&tipo=contrato&f_pago=<?php echo $doc_pago['cod_pago_venta']; ?>"class="boton">Boleta</a>
</div>
<?php
}
?>

