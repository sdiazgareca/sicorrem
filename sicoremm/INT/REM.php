<script type="text/javascript">

$(document).ready(function() {

	$('#valor33').submit(function(){

		if(!confirm(" Esta seguro de guardar los cambios?")) {
		return false;}

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#ajax3').html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

});

</script>
<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');



//PROCESA CAMBIO DE PLAN Y DIA DE PAGO
if ($_POST['mod_plan_dp'] > 0){

    $plan = explode('-',$_POST['planes_mod']);
    $cod_plan = $plan[0];
    $tipo_plan = $plan[1];

    //COMPRUEBA LA SECUENCIA
    $sql ="SELECT secuencia,valor,cod_plan,tipo_plan FROM valor_plan WHERE cod_plan='".$cod_plan."' AND tipo_plan='".$tipo_plan."' AND secuencia='".$_POST['secuencia']."'";
    $query = mysql_query($sql);
    $num_sec = mysql_num_rows($query);

    if ($num_sec > 0){
        $con['contratos'] ="UPDATE contratos SET cod_plan ='".$cod_plan."', tipo_plan='".$tipo_plan."', d_pago='".$_POST['d_pago']."' WHERE num_solici ='".$_POST['num_solici']."'";
        $con['afiliados'] ="UPDATE afiliados SET cod_plan ='".$cod_plan."', tipo_plan='".$tipo_plan."' WHERE num_solici ='".$_POST['num_solici']."'";

        $query = new Datos;
        $query->Trans($con);

    }
    if ($num_sec < 1){

        echo '<div class="mensaje2">No es posible realizar el cambio dado que la secuencia no existe</div>';

    }

}

if ($_GET['V_SERVICIOS'] >0 && $_GET['CONTRATO'] > 0){


    $datos_sql ='SELECT d_pago,cod_plan AS COD_PLAN,tipo_plan AS TIPO_PLAN,desc_plan AS PLAN,valor AS VALOR_MENSUALIDAD,secuencia,copago AS VALOR_COPAGO
                   FROM contr WHERE num_solici ="'.$_GET['CONTRATO'].'"';

    //echo '<br />'.$datos_sql.'<br />';

    $datos_query = mysql_query($datos_sql);

    $datos = mysql_fetch_array($datos_query);


?>




<form action="INT/REM.php" method="post" id="valor33" name="valor33">
<table class="table2">
    <tr>
    <td><strong>PLAN</strong></td>
    <td><select name="planes_mod">
        <option value="<?php echo $datos['COD_PLAN'].'-'.$datos['TIPO_PLAN']; ?>"><?php echo $datos['COD_PLAN'].'-'.$datos['TIPO_PLAN'].'-'.$datos['PLAN']; ?></option>
        <?php
        $plan_sql ="SELECT cod_plan, tipo_plan, desc_plan FROM planes";
        $planes_query = (mysql_query($plan_sql));

        while ($plan = mysql_fetch_array($planes_query)){

        ?>
            <option value="<?php echo $plan['cod_plan'].'-'.$plan['tipo_plan']; ?>"><?php echo $plan[cod_plan].'-'.$plan['tipo_plan'].'-'.$plan['desc_plan']; ?></option>
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

        <td style="display:none;"><input type="text" value="<?php echo $_GET['CONTRATO']; ?>" name="num_solici"/><input type="text" value="1" name="mod_plan_dp"<input type="text" value="<?php echo $datos['secuencia'];?>" name="secuencia" /></td>
        <td><input type="submit" value="Guardar" class="boton" /></td>
    </tr>

</table>
</form>


<?
}

?>
