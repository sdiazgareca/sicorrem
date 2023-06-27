<script type="text/javascript">

$(document).ready(function() {

	$('#dom').submit(function(){

		var url_ajax = $(this).attr('action');
		var data_ajax = $(this).serialize();

		$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$('#sub22').html(data);}})

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
?>
<form action="INT/SUB_M_TESO_4.php" method="post" name="dom" id="dom">
    <h1>FORMA DE PAGO MENSUAL</h1>
<?php
//PAC

if ($_POST['f_pag'] == 100){

        $SQL = "SELECT banco_cod,rut_titular_cta AS RUT_TITULAR_CUENTA,titular_cta AS NOMBRE1_TC,titular_nombre2 AS NOMBRE2_TC,titular_apellidos AS AP_TITULAR,
                cta as N_CUENTA,banco_des AS BANCO,n_doc AS N_DOC
                FROM contr WHERE num_solici ='".$_POST['num_solici']."'";

                $QUERY = mysql_query($SQL);

        $domi = mysql_fetch_assoc($QUERY);
        ?>

        <h2>PAC</h2>

        <table class="table">
            <input type="text" name="f_pago" style="display:none;" value="<?php echo $_POST['f_pag']; ?>" />
            <input type="text" name="num_soloci" style="display:none;"value="<?php echo $_POST['num_solici']; ?>">
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

        

        <?php

}


//TC
if ($_POST['f_pag'] == 200){

    $SQL = "SELECT contr.t_credito_cod,rut_titular_cta AS RUT_TITULAR_CUENTA,titular_cta AS NOMBRE1_TC,titular_nombre2 AS NOMBRE2_TC,titular_apellidos AS AP_TITULAR,
                cta AS N_CUENTA, contr.t_credito_des AS tc,n_doc AS N_DOC
                FROM contr WHERE num_solici ='".$_POST['num_solici']."'";

                $QUERY = mysql_query($SQL);

        $domi = mysql_fetch_assoc($QUERY);
        ?>

        <h2>TC</h2>

        <table class="table">
            <input type="text" name="num_soloci" style="display:none;"value="<?php echo $_POST['num_solici']; ?>">
        <input type="text" name="f_pago" style="display:none;" value="<?php echo $_POST['f_pag']; ?>" />
            <input style="display:none;" type="text" value="<?php echo $domi['N_DOC']; ?>" name="n_original" />
        <tr>
        <?php

        $cont = 0;
        $mat = (count($domi) -1);

        foreach ($domi AS $campo=>$valor){
            if ($campo !='tc' && $campo != 't_credito_cod'){
            ?>
        <td><strong><?php echo $campo; ?></strong></td>
        <td><input type="text" value="<?php echo $valor; ?>" name="<?php echo $campo; ?>" /></td>

           <?php
        }

        if ($campo == 'tc' && $campo != 't_credito_cod'){

            $banco_sql ="SELECT codigo, descripcion FROM t_credito WHERE codigo != '".$domi['t_credito_cod']."'";
            $bancos_query = mysql_query($banco_sql);
            ?>
        <td><strong>TC</strong></td>
        <td>
        <select name="tc">
            <option value="<?php echo $domi['t_credito_cod']; ?>"><?php echo $domi['tc']; ?></option>
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

        
<?php
}


//cobro domiciliario
if ($_POST['f_pag'] == 300){


    foreach($_POST AS $campo=>$valor){

        echo $campo.' '.$valor;

    }


        $SQL = "SELECT poblacion AS POBLACION, calle AS CALLE,numero AS NUMERO,piso AS PISO,departamento AS DEPARTAMENTO,
            localidad AS LOCALIDAD,telefono AS FONO,email AS EMAIL,entre as ENTRE
            FROM domicilios WHERE num_solici ='".$_POST['num_solici']."' AND tipo_dom='1'";
        
        
        $QUERY = mysql_query($SQL);

        $domi = mysql_fetch_array($QUERY);
        ?>

        <h2>Cobro Domiciliario</h2>

<table class="table">
            <input type="text" name="f_pago" style="display:none;" value="<?php echo $_POST['f_pag']; ?>" />
<input type="text" name="num_soloci" style="display:none;"value="<?php echo $_POST['num_solici']; ?>">

<tr>
        <td><strong>POBLACION</strong></td>
        <td><input type="text" value="<?php echo $domi['POBLACION']; ?>" name="poblacion" /></td>
        
        <td><strong>CALLE</strong></td>
        <td><input type="text" value="<?php echo $domi['CALLE']; ?>" name="calle" /></td>
        
        <td><strong>NUMERO</strong></td>
        <td><input type="text" value="<?php echo $domi['NUMERO']; ?>" name="numero" /></td>
</tr>


<tr>
        <td><strong>PISO</strong></td>
        <td><input type="text" value="<?php echo $domi['PISO']; ?>" name="piso" /></td>

        <td><strong>DEPARTAMENTO</strong></td>
        <td><input type="text" value="<?php echo $domi['DEPARTAMENTO']; ?>" name="departamento" /></td>

        <td><strong>LOCALIDAD</strong></td>
        <td><input type="text" value="<?php echo $domi['LOCALIDAD']; ?>" name="localidad" /></td>
</tr>


<tr>
        <td><strong>FONO</strong></td>
        <td><input type="text" value="<?php echo $domi['FONO']; ?>" name="fono" /></td>

        <td><strong>EMAIL</strong></td>
        <td><input type="text" value="<?php echo $domi['EMAIL']; ?>" name="email" /></td>

        <td><strong>ENTRE</strong></td>
        <td><input type="text" value="<?php echo $domi['ENTRE']; ?>" name="entre" /></td>
</tr>

</table>
<br />
            <div align="right"><input  value="Editar" type="submit" class="boton" /></div>

<?php
}


//DESCUENTO POR PLANILLA
if ($_POST['f_pag'] == 400){

	$campos_e =array('nro_doc AS RUT_EMPRESA'=>'','empresa AS EMPRESA'=>'','giro AS GIRO'=>'');
	$rut_e = array('RUT_EMPRESA'=>'');

	//OBTENER COD EMPRESA
	$sql ="SELECT contratos.empresa FROM contratos WHERE contratos.num_solici='".$_POST['num_solici']."'";
	$query = mysql_query($sql);
	$emp = mysql_fetch_array($query);


        $empresa_sql ="SELECT nro_doc AS RUT_EMPRESA,empresa AS EMPRESA,giro AS GIRO
                       FROM emp WHERE nro_doc = '".$emp['empresa']."'";

        $query = mysql_query($empresa_sql);
        $empres = mysql_fetch_array($query);
        ?>
            <input type="text" name="f_pago" style="display:none;" value="<?php echo $_POST['f_pag']; ?>" />
<input type="text" name="num_soloci" style="display:none;"value="<?php echo $_POST['num_solici']; ?>">
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
if ($_POST['f_pag'] == 500){
?>
    <input type="text" name="num_soloci" style="display:none;"value="<?php echo $_POST['num_solici']; ?>">
<?php
	echo '<h2>TRASFERENCIA ELECTRONICA</h2>';

        $sql ='SELECT contratos.d_pago  FROM contratos WHERE contratos.num_solici ="'.$_POST['num_solici'].'"';
        $query = mysql_query($sql);

        echo '<strong>Dia de Pago </strong>';

        echo '<input type="text" style="display:none" value="'.$_POST['f_pag'].'" name="f_pago" />';

        echo '<select name="d_pago">';

        $f_pago = mysql_fetch_array($query);
        echo '<option value="1">1</option>';
        echo '<option value="5">5</option>';
        echo '<option value="10">10</option>';

        echo '</select>';

        echo '<div align="right"><input  value="Editar" type="submit" class="boton" /></div>';

}
?>
</form>
