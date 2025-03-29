<script type="text/javascript">

$(document).ready(function() {

$('.rut').Rut({
  	on_error: function(){ alert('Rut incorrecto'); }
});

 $('#ajax1 a:contains("Editar")').click(function() {
	var ruta = $(this).attr('href');
 	$('#cont1').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });

 $('#ajax1 a:contains("PARTICULAR")').click(function() {
		var ruta = $(this).attr('href');
	 	$('#SUB20').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	 });

 $('#ajax1 a:contains("CONVENIO")').click(function() {
		var ruta = $(this).attr('href');
	 	$('#SUB20').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	 });

 $('#ajax1 a:contains("AREA_PROT")').click(function() {
		var ruta = $(this).attr('href');
	 	$('#SUB20').load(ruta);
		$.ajax({cache: false});
		ruta = "";
	 	return false;
	 });



	$('#zosema_guardar').submit(function(){

		if(!confirm(" Esta seguro de guardar los cambios?")) {
		return false;}

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#cont1').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});


	$('#e_titular').submit(function(){

		if(!confirm(" Esta seguro de guardar los cambios?")) {
		return false;}

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#cont1').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

	$('#valor').submit(function(){

		if(!confirm(" Esta seguro de guardar los cambios?")) {
		return false;}

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#cont1').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

	$('#valor2').submit(function(){

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#sub22').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});




    $(function() {$(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });});

});

</script>

<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');


//PROCESA EDITAR ZOSEMA

if (isset($_POST['zosema_edit'])){

    //echo $_POST['zosema_edit'];
    $zona = explode('-',$_POST['zosema_edit']);
    //echo $zona[0].'<br />';
    //echo $zona[1].'<br />';
    //echo $zona[2].'<br />';

    $cam_sona_sql ="UPDATE contratos SET ZO='".$zona[0]."', SE='".$zona[1]."', MA='".$zona[2]."' WHERE contratos.num_solici='".$_POST['num_solici']."'";
    if( mysql_query($cam_sona_sql)){
        echo OK;
    }
    else{
        echo ERROR;
    }

}

//ZOSEMA
if ($_GET['ZOSEMA'] > 0){
    //echo 'aca....';

    $zosema_sql ='SELECT ZOSEMA.MA, ZOSEMA.SE, ZOSEMA.ZO,cobrador.nombre1, cobrador.nombre2, cobrador.apellidos
                  FROM ZOSEMA
                  JOIN cobrador ON cobrador.nro_doc = ZOSEMA.cobrador';

    $zosema_query = mysql_query($zosema_sql);
    ?>
<form action="INT/SUB_M_TESO_2.php" method="post" id="zosema_guardar">
<table class="table2">
    <tr>
        <td><strong>Zona</strong></td>
        <td style="display:none;"><input name="num_solici" type="text" value="<?php echo $_GET['CONTRATO']; ?>" /></td>
        <td>
        <select name="zosema_edit">
        <option value=""></option>
        <?php
        while($zosema = mysql_fetch_array($zosema_query)){
        ?>
        <option value="<?php echo $zosema['ZO'].'-'.$zosema['SE'].'-'.$zosema['MA']; ?>"><?php echo $zosema['ZO'].'-'.$zosema['SE'].'-'.$zosema['MA'].'  '.$zosema['nombre1'].' '.$zosema['nombre2'].' '.$zosema['apellidos']; ?></option>
        <?php
        }
        ?>
    </select>
        </td>

        <td></td>
        <td><input type="submit" value="Guardar" /></td>

    </tr>
</table>
</form>
    <?php


}


if ($_POST['cod_f'] > 0){

    /*
    foreach($_POST AS $campo=>$valor){
        echo $campo.' = '.$valor.'<br />';
    }
     *
     */


    //TRANFERENCIA ELECTRONICA
    if ($_POST['cod_f'] == 500){

        $sql = "UPDATE contratos SET d_pago='".$_POST['d_pago']."' WHERE num_solici='".$_POST['num_solici']."'";

        if ($query = mysql_query($sql)){
            echo OK;
        }
        else{
            echo ERROR;
        }

    }

    //CAMBIO EMPRESA
    if ($_POST['cod_f'] == 400){

        $sql = "UPDATE contratos SET empresa='".$_POST['empresa']."' WHERE num_solici='".$_POST['num_solici']."'";

        if ($query = mysql_query($sql)){
            echo OK;
        }
        else{
            echo ERROR;
        }

    }

    //domicilio de cobro
    if ($_POST['cod_f'] == 300){

        $sql = "UPDATE domicilios SET poblacion='".$_POST['POBLACION']."',
                calle='".$_POST['CALLE']."',numero='".$_POST['NUMERO']."',
                piso='".$_POST['PISO']."',departamento='".$_POST['DEPARTAMENTO']."',
                localidad='".$_POST['LOCALIDAD']."',email='".$_POST['EMAIL']."',entre='".$_POST['ENTRE']."'

WHERE num_solici='".$_POST['CONTRATO']."' AND domicilios.tipo_dom=1";

        if ($query = mysql_query($sql)){
            echo OK;
        }
        else{
            echo ERROR;
        }

    }

//PAC
    if ($_POST['cod_f'] == 100){

        $tran = new Datos;


         $query['sql2']="UPDATE contratos SET doc_pago='".$_POST['N_DOC']."'WHERE num_solici='".$_POST['num_solici']."'";

        $query['sql'] = "UPDATE doc_f_pago SET apellidos = '".$_POST['AP_TITULAR']."', titular_cta='".$_POST['NOMBRE1_TC']."', rut_titular_cta='".$_POST['RUT_TITULAR_CUENTA']."',
            cta='".$_POST['N_CUENTA']."',banco='".$_POST['Banco']."',nombre2='".$_POST['NOMBRE2_TC']."',
                apellidos='".$_POST['']."' WHERE numero='".$_POST['n_original']."'";


        $tran->Trans($query);


    }

//TC
    if ($_POST['cod_f'] == 200){

        $tran = new Datos;


         $query['sql2']="UPDATE contratos SET doc_pago='".$_POST['N_DOC']."'WHERE num_solici='".$_POST['num_solici']."'";

        $query['sql'] = "UPDATE doc_f_pago SET apellidos = '".$_POST['AP_TITULAR']."', titular_cta='".$_POST['NOMBRE1_TC']."', rut_titular_cta='".$_POST['RUT_TITULAR_CUENTA']."',
            cta='".$_POST['N_CUENTA']."',t_credito='".$_POST['Tarjeta']."',nombre2='".$_POST['NOMBRE2_TC']."',
                apellidos='".$_POST['']."' WHERE numero='".$_POST['n_original']."'";


        $tran->Trans($query);


    }

}

//FORM EDICION FORMA DE PAGO MENSUALIDAD

if($_GET['FPAGO'] > 0){
    ?>

    <form action="INT/SUB_M_TESO_3.php" method="post" id="valor2">
        <h1>CAMBIO FORMA DE PAGO</h1>
        <table class="table2">
        <tr>
        <td><input type="text" value="<?php echo $_GET['CONTRATO']; ?>" name="num_solici" style="display:none;" /></td>
        <td>
        <?php
        $f_pago_sql ="SELECT codigo, descripcion FROM f_pago WHERE codigo != 600";
        $f_pago_query = mysql_query($f_pago_sql);
        ?>
        <select name="f_pag">

            <option value=""></option>

            <?php
            while($f_pago = mysql_fetch_array($f_pago_query)){
            ?>
            <option value="<?php echo $f_pago['codigo']; ?>"><?php echo $f_pago['descripcion']; ?></option>
            <?php
            }
            ?>
        </select>
        </td>
        <td><input type="submit" value="Cambiar"class="boton" /></td>
        </tr>
        </table>
    </form>

<div id="sub22">

    <h1>FORMA DE PAGO MENSUAL</h1>
    <form action="INT/SUB_M_TESO_2.php" method="post" id="valor" name="valor">
    <?php


$cod_f = $_GET['cod_f'];

echo '<input type="text" value="'.$cod_f.'" name="cod_f" style="display:none;" />';
echo '<input type="text" value="'.$_GET['CONTRATO'].'" name="num_solici" style="display:none;" />';


$fpago = new Datos;



//TC
	if ($cod_f== 200){

        $SQL = "SELECT t_credito_cod,descripcion AS FORMA_DE_PAGO,rut_titular_cta AS RUT_TITULAR_CUENTA,titular_cta AS NOMBRE1_TC,titular_nombre2 AS NOMBRE2_TC,titular_apellidos AS AP_TITULAR,
                cta as N_CUENTA,t_credito_des AS TARJETA,n_doc AS N_DOC
                FROM contr WHERE num_solici ='".$_GET['CONTRATO']."'";

                $QUERY = mysql_query($SQL);

        $domi = mysql_fetch_assoc($QUERY);
        ?>

        <h2>TARJETA</h2>

        <form action="" method="" name="" id="">
        <table class="table">
        <input style="display:none;" type="text" value="<?php echo $domi['N_DOC']; ?>" name="n_original" />
        <tr>
        <?php

        $cont = 0;
        $mat = (count($domi) -1);

        foreach ($domi AS $campo=>$valor){
            if ($campo !='TARJETA' && $campo != 't_credito_cod'){
            ?>
        <td><strong><?php echo $campo; ?></strong></td>
        <td><input type="text" value="<?php echo $valor; ?>" name="<?php echo $campo; ?>" /></td>

           <?php
        }

        if ($campo == 'TARJETA' && $campo != 't_credito_cod'){

            $banco_sql ="SELECT codigo, descripcion FROM t_credito WHERE codigo != '".$domi['t_credito_cod']."'";
            $bancos_query = mysql_query($banco_sql);
            ?>
        <td><strong>TARJETA</strong></td>
        <td>
        <select name="Tarjeta">
            <option value="<?php echo $domi['t_credito_cod']; ?>"><?php echo $domi['TARJETA']; ?></option>
            <?php while ($banco = mysql_fetch_array($bancos_query)){?>
            <option value="<?php echo $banco['codigo']; ?>"><?php echo $banco['descripcion']; ?></option>
            <?php
            }
            ?>
        </select>
        </td>
        <?php
        }

           if ( ($cont % 3) == 0){
               echo '</tr>';
           }
$cont ++;
        }
?>
        </tr>
        </table>
<br />
            <div align="right"><input  value="Editar" type="submit" class="boton" /></div>

        </form>
<?php
}






//PAC
	if ($cod_f== 100){

        $SQL = "SELECT banco_cod,descripcion AS FORMA_DE_PAGO,rut_titular_cta AS RUT_TITULAR_CUENTA,titular_cta AS NOMBRE1_TC,titular_nombre2 AS NOMBRE2_TC,titular_apellidos AS AP_TITULAR,
                cta as N_CUENTA,banco_des AS BANCO,n_doc AS N_DOC
                FROM contr WHERE num_solici ='".$_GET['CONTRATO']."'";

                $QUERY = mysql_query($SQL);

        $domi = mysql_fetch_assoc($QUERY);
        ?>

        <h2>PAC</h2>

        <form action="" method="" name="" id="">
        <table class="table">
        <input style="display:none;" type="text" value="<?php echo $domi['N_DOC']; ?>" name="n_original" />
        <tr>
        <?php

        $cont = 0;
        $mat = (count($domi) -1);

        foreach ($domi AS $campo=>$valor){
            if ($campo !='BANCO' && $campo != 'banco_cod'){
            ?>
        <td><strong><?php echo $campo; ?></strong></td>
        <td><input type="text" value="<?php echo $valor; ?>" name="<?php echo $campo; ?>" /></td>

           <?php
        }

        if ($campo == 'BANCO' && $campo != 'banco_cod'){

            $banco_sql ="SELECT codigo, descripcion FROM bancos WHERE codigo != '".$domi['banco_cod']."'";
            $bancos_query = mysql_query($banco_sql);
            ?>
        <td><strong>BANCO</strong></td>
        <td>
        <select name="Banco">
            <option value="<?php echo $domi['banco_cod']; ?>"><?php echo $domi['BANCO']; ?></option>
            <?php while ($banco = mysql_fetch_array($bancos_query)){?>
            <option value="<?php echo $banco['codigo']; ?>"><?php echo $banco['descripcion']; ?></option>
            <?php
            }
            ?>
        </select>
        </td>
        <?php
        }

           if ( ($cont % 3) == 0){
               echo '</tr>';
           }
$cont ++;
        }
?>
        </tr>
        </table>
<br />
            <div align="right"><input  value="Editar" type="submit" class="boton" /></div>

        </form>
<?php
}
/*
	//TARJETA DE CREDITO
	if ($cod_f== 200){

        $sql = "SELECT t_credito_cod,descripcion AS FORMA_DE_PAGO,titular_cta AS TITULAR_CUENTA,
                rut_titular_cta AS RUT_TITULAR_CUENTA,cta as N_CUENTA,t_credito_des AS T_CREDITO
                FROM contr WHERE num_solici ='".$_GET['CONTRATO']."'";
        $query = mysql_query($sql);

        $tar = mysql_fetch_assoc($query);

        ?>

        <h2>Tarjeta</h2>

        <table class="table">

        <tr>
        <?php

        $cont = 0;
        $mat = count($tar);

        foreach ($tar AS $campo=>$valor){
            if($campo != 'T_CREDITO'){
            ?>
        <td><strong><?php echo $campo; ?></strong></td>
        <td><input type="text" value="<?php echo $valor; ?>" name="<?php echo $campo; ?>" /></td>

           <?php
            }

            if ($campo == 'T_CREDITO'){
                $tc_s ="SELECT codigo, descripcion FROM t_credito WHERE codigo != '".$tar['t_credito_cod']."'";
                $tc_q = mysql_query($tc_s);
                ?>
        <td><strong><?php echo $campo; ?></strong></td>
        <td>
            <select>
                <option value="<?php echo $tar['t_credito_cod']; ?>"><?php echo $tar['T_CREDITO']; ?></option>
            <?php
            while ($tc = mysql_fetch_array($tc_q)){
            ?>
                <option value="<?php echo $tc['codigo']; ?>"><?php echo $tc['descripcion']; ?></option>
            <?php
            }
            ?>
            </select>


        </td>

        <?php

            }

           $cont ++;
           if ( ($cont % 3) == 0){
               echo '</tr>';
           }
        }
?>
        </tr>
        </table>
<br />
            <div align="right"><input  value="Editar" type="submit" class="boton" /></div>
*/




	//COBRO DOMICILIARIO
	if ($cod_f== 300){




        $SQL = "SELECT poblacion AS POBLACION, calle AS CALLE,numero AS NUMERO,piso AS PISO,departamento AS DEPARTAMENTO,
            localidad AS LOCALIDAD,telefono AS FONO,email AS EMAIL,entre as ENTRE
            FROM domicilios WHERE num_solici ='".$_GET['CONTRATO']."' AND tipo_dom='1'";

        $QUERY = mysql_query($SQL);

        $domi = mysql_fetch_assoc($QUERY);
        ?>

        <h2>Cobro Domiciliario</h2>

        <table class="table">

        <tr>
        <?php

        $cont = 0;
        $mat = count($domi);

        foreach ($domi AS $campo=>$valor){
            ?>
        <td><strong><?php echo $campo; ?></strong></td>
        <td><input type="text" value="<?php echo $valor; ?>" name="<?php echo $campo; ?>" /></td>

           <?php
           $cont ++;
           if ( ($cont % 3) == 0){
               echo '</tr>';
           }
        }
?>
        <input style="display:none;" name="CONTRATO" type="text" value="<?php echo $_GET['CONTRATO']; ?>"/></tr>
        </table>
<br />
            <div align="right"><input  value="Editar" type="submit" class="boton" /></div>


<?php
	}

	//DESCUENTO POR PLANILLA
	if ($cod_f== 400){

	$campos_e =array('nro_doc AS RUT_EMPRESA'=>'','empresa AS EMPRESA'=>'','giro AS GIRO'=>'');
	$rut_e = array('RUT_EMPRESA'=>'');

	//OBTENER COD EMPRESA
	$sql ="SELECT contratos.empresa FROM contratos WHERE contratos.num_solici='".$_GET['CONTRATO']."'";
	$query = mysql_query($sql);
	$emp = mysql_fetch_array($query);


        $empresa_sql ="SELECT nro_doc AS RUT_EMPRESA,empresa AS EMPRESA,giro AS GIRO
                       FROM emp WHERE nro_doc = '".$emp['empresa']."'";

        $query = mysql_query($empresa_sql);
        $empres = mysql_fetch_array($query);
        ?>

            <table class="table2">
                <tr>
                    <th>EMPRESA</th>
                    <td>
                        <select name="empresa">
                            <option value="<?php echo $empres['RUT_EMPRESA']; ?>"><?php echo $empres['EMPRESA']; ?></option>
                            <?php

                            $sql ="SELECT nro_doc, empresa FROM empresa";
                            $query2 = mysql_query($sql);
                            while ($emp2 = mysql_fetch_array($query2)){
                            ?>
                            <option value="<?php echo $emp2['nro_doc']; ?>"><?php echo $emp2['empresa']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <div align="right"><input  value="Editar" type="submit" class="boton" /></div>
                    </td>

                </tr>
            </table>

    <?php

	}

	//TRANFERENCIA ELECTRONICA
	if ($cod_f== 500){
	echo '<h2>TRASFERENCIA ELECTRONICA</h2>';

        $sql ='SELECT contratos.d_pago  FROM contratos WHERE contratos.num_solici ="'.$_GET['CONTRATO'].'"';
        $query = mysql_query($sql);

        echo '<strong>Dia de Pago </strong>';
        echo '<input type="text" style="display:none" value="'.$cod_f.'" name="f_pago" />';
        echo '<select name="d_pago">';

        $f_pago = mysql_fetch_array($query);

        echo '<option value="'.$f_pago['d_pago'].'">'.$f_pago['d_pago'].'</option>';
        echo '<option value="1">1</option>';
        echo '<option value="5">5</option>';
        echo '<option value="10">10</option>';

        echo '</select>';

        echo '<div align="right"><input  value="Editar" type="submit" class="boton" /></div>';

	}

        //PAGO EMPRESA
	if ($cod_f== 600){

	$campos_e =array('nro_doc AS RUT_EMPRESA'=>'','empresa AS EMPRESA'=>'','giro AS GIRO'=>'');
	$rut_e = array('RUT_EMPRESA'=>'');

	//OBTENER COD EMPRESA
	$sql ="SELECT contratos.empresa FROM contratos WHERE contratos.num_solici='".$_GET['CONTRATO']."'";
	$query = mysql_query($sql);
	$emp = mysql_fetch_array($query);

	$where_e = array('nro_doc ='=>'"'.$emp['empresa'].'"');
	echo '<strong>PAGO EMPRESA</strong>';
	$fpago->Imprimir($campos_e,'emp',$where_e,'3',$rut_e);
	}


?>
    </form>
</div>
    <?php
    }

//PROCESA CAMBIO DE PLAN Y DIA DE PAGO
if ($_POST['mod_plan_dp'] > 0){

    $plan = explode('-',$_POST['planes_mod']);
    $cod_plan = $plan[0];
    $tipo_plan = $plan[1];

    //COMPRUEBA LA SECUENCIA

    $secuencia_sql = "SELECT secuencia FROM contratos WHERE contratos.num_solici='".$_POST['num_solici']."'";
    $sec = mysql_query($secuencia_sql);
    $numero_secuencia = mysql_fetch_array($sec);


    $sql ="SELECT secuencia,valor,cod_plan,tipo_plan FROM valor_plan WHERE cod_plan='".$cod_plan."' AND tipo_plan='".$tipo_plan."' AND secuencia='".$numero_secuencia['secuencia']."'";
    $query = mysql_query($sql);
    $num_sec = mysql_num_rows($query);

    if ($num_sec > 0){

        if($_POST['factu'] !=""){
            $fa = ", factu = '".$_POST['factu']."'";
        }

        $con['contratos'] ="UPDATE contratos SET ajuste='".$_POST['ajuste']."',cod_plan ='".$cod_plan."', tipo_plan='".$tipo_plan."', d_pago='".$_POST['d_pago']."' ".$fa." WHERE num_solici ='".$_POST['num_solici']."'";
        $con['afiliados'] ="UPDATE afiliados SET cod_plan ='".$cod_plan."', tipo_plan='".$tipo_plan."' WHERE num_solici ='".$_POST['num_solici']."'";

        $query = new Datos;
        $query->Trans($con);

    }
    if ($num_sec < 1){

        echo '<div class="mensaje2">No es posible realizar el cambio dado que la secuencia no existe</div>';

    }

}


//MENU EDICION VALOR MENSUAL DE LOS SERVICIOS
if ($_GET['V_SERVICIOS'] >0 && $_GET['CONTRATO'] > 0){

    $datos_sql ='SELECT ajuste,d_pago,cod_plan AS COD_PLAN,tipo_plan AS TIPO_PLAN,desc_plan AS PLAN,valor AS VALOR_MENSUALIDAD,secuencia,copago AS VALOR_COPAGO
                   FROM contr WHERE num_solici ="'.$_GET['CONTRATO'].'"';

    //echo $datos_sql;

    $datos_query = mysql_query($datos_sql);
    $datos = mysql_fetch_array($datos_query);
?>

<form action="INT/SUB_M_TESO_2.php" method="post" id="valor" name="valor">
<table class="table2">
    <tr>
    <td><strong>PLAN</strong></td>
    <td><select name="planes_mod">
        <option value="<?php echo $datos['COD_PLAN'].'-'.$datos['TIPO_PLAN']; ?>"><?php echo $datos['COD_PLAN'].'-'.$datos['TIPO_PLAN'].'-'.$datos['PLAN']; ?></option>
        <?php
        $plan_sql ="SELECT cod_plan, tipo_plan, desc_plan FROM planes ORDER BY estado,desc_plan";
        $planes_query = (mysql_query($plan_sql));

        while ($plan = mysql_fetch_array($planes_query)){

        ?>
            <option value="<?php echo $plan['cod_plan'].'-'.$plan['tipo_plan']; ?>"><?php echo $plan['desc_plan'].' '.$plan[cod_plan].'-'.$plan['tipo_plan']; ?></option>
        <?php
        }
        ?>
</select>
    </td>
    <td><strong>D_Pago</strong></td>
    <td>
        <select name="d_pago">
            <option value="<?php echo $datos['d_pago']; ?>"><?php echo $datos['d_pago']; ?></option>
            <option value="1">1</option>
            <option value="5">5</option>
            <option value="10">10</option>
        </select>

    </td>

    <td><strong>Ajuste</strong></td>
    <td><input type="text" value="<?php echo $datos['ajuste']; ?>"  name="ajuste" /></td>

    <td><strong>T COMPROBANTE</strong></td>
    <td><select  name="factu" >
            <option value=""></option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>


        </select></td>

        <td style="display:none;"><input type="text" value="<?php echo $_GET['CONTRATO']; ?>" name="num_solici"/><input type="text" value="1" name="mod_plan_dp"<input type="text" value="<?php echo $datos['secuencia'];?>" name="secuencia" /></td>
        <td><input type="submit" value="Guardar" class="boton" /></td>
    </tr>

</table>
</form>


<?
}

//PROCESA EDICION DEL TITULAR DEL CONTRATO
if ($_POST['EDICION_DEL_TITULAR'] > 0){

    $num = (count($_POST) -4);
    $cont = 0;

    $fecha_nac = new Datos;

    $_POST['fecha_nac'] = $fecha_nac->cambiaf_a_mysql($_POST['fecha_nac']);



    foreach($_POST AS $campo=>$valor){

        if ($campo !='EDICION_DEL_TITULAR'  && $campo !='rut_original'&& $campo !='num_solici' && $campo !='nro_doc'){

            $consulta = $consulta.' '.$campo.' = "'.$valor.'"';
            $cont ++;

            if($cont < $num){
                $consulta = $consulta.' , ';
            }


        }


    }
$sql = "UPDATE titulares SET ".$consulta." WHERE nro_doc='".$_POST['rut_original']."'";

if (mysql_query($sql)){
    echo OK;
}
else{
    echo ERROR;
}


}


//MUESTRA EL FORMULARIO DE EDICION DEL TITULAR DEL CONTRATO
if ($_GET['CONTRATANTE'] > 0 && $_GET['CONTRATO'] > 0){

	echo '<h1>DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO</h1><br />';

	$sql = "SELECT nro_doc, apellido, email,
			fecha_nac, nombre1, nombre2, civil_cod,civil_des,
			sexo, profesion_cod,profesion_des, telefono_emergencia, l_trabajo_cod,l_trabajo_desc,
			telefono_laboral,ciudad_desc,ciudad_cod,telefono_particular
			FROM TITU
			INNER JOIN contratos ON contratos.titular = TITU.nro_doc
			WHERE contratos.num_solici='".$_GET['CONTRATO']."'";

	$query = mysql_query($sql);

	$con = mysql_fetch_array($query);

	$datos = new Datos;
	?>
	<form action="INT/SUB_M_TESO_2.php" method="post" name="e_titular" id="e_titular">
	<input type="text" name="EDICION_DEL_TITULAR" value="1" style="display:none" />
	<input type="text" name="num_solici" value="<?php echo $_GET['CONTRATO']; ?>" style="display:none" />

	<?php
	$rut = new Datos;
	$rut->validar_rut($con['nro_doc']);
	?>
        <input type="text" name="rut_original" value="<?php echo $con['nro_doc']; ?>" style="display:none" />
<table class="table2">
    <tr>
    <td><strong>RUT</strong></td><td><input type="text" readonly="readonly" value="<?php echo $rut->nro_doc; ?>" name="nro_doc" class="rut" /></td>
    <td><strong>P_NOMBRE</strong></td><td><input type="text" value="<?php echo $con['nombre1'];?>" name="nombre1" /></td>
    <td><strong>S_NOMBRE</strong></td><td><input type="text" value="<?php echo $con['nombre2'];?>" name="nombre2" /></td>
    </tr>

    <tr>
    <td><strong>APELLIDOS</strong></td><td><input type="text" value="<?php echo $con['apellido']; ?>" name="apellido" /></td>
    <td><strong>F_NACIMIENTO</strong></td><td><input type="text" value="<?php echo $con['fecha_nac']; ?>" name="fecha_nac" class="calendario" /></td>
    <td><strong>EMAIL</strong></td><td><input type="text" value="<?php echo $con['email']; ?>" name="email" /></td>
    </tr>
	</table>

<br />

<table class="table2">
    <tr>
        <td><strong> ESTADO CIVIL</strong></td>
        <td><?php $civil = new Select; $civil->selectOpp2('civil','descripcion,codigo','descripcion','codigo','civil','civil','NULL',$con['civil_cod'],$con['civil_des'])?></td>
        <td><strong> SEXO </strong></td>
	<td>
            <select name="sexo">
                <option value="<?php echo $con['sexo']; ?>" style="background:#09C;"><?php echo $con['sexo']; ?></option>
                <option value="F">F</option>
                <option value="M">M</option>
            </select>
        </td>
    </tr>

    <tr>
        <td><strong>PROFESION</strong></td>
        <td><?php $profesion = new Select; $profesion->selectOpp2('profesion','descripcion,codigo','descripcion','codigo','profesion','profesion','NULL',$con['profesion_cod'],$con['profesion_des']);?></td>
        <td><strong>FONO DE EMERGENCIA</strong></td>
        <td><input type="text" name="telefono_emergencia" value="<?php echo $con['telefono_emergencia']; ?>" /></td>
    </tr>

    <tr>
        <td><strong> LUGAR DE TRABAJO </strong></td>
        <td><?php $trabajo = new Select; echo $trabajo->selectOpp2('l_trabajo','codigo,nombre','nombre','codigo','l_trabajo','l_trabajo','',$con['l_trabajo_cod'],$con['l_trabajo_desc']); ?></td>

        <td><strong>CIUDAD</strong></td>
        <td><?php $ciudad = new Select; $ciudad->selectOpp2('ciudad','codigo,nombre','nombre','codigo','ciudad','ciudad','',$con['ciudad_cod'],$con['ciudad_desc']);?></td>
    </tr>

    <tr>
        <td><strong>FONO PARTICULAR</strong></td>
        <td><input type="text" name="telefono_particular" value="<?php echo $con['telefono_particular']; ?>" /></td>
	<td>&zwnj;</td>
        <td>&zwnj;</td>

    </tr>


</table>
<br />

<div style="padding:10px" align="right">
    <input type="submit" value="Editar" class="boton" />
</div>
</form>
<?php
}
?>
