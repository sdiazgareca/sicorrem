<?php
//include_once('../DAT/conf.php');
//include_once('../DAT/bd.php');
//include_once('../CLA/Datos.php');
//include_once('../CLA/Select.php');

class Afiliados {

    var $nro_doc;
    var $nombre1;
    var $nombre2;
    var $apellido;
    var $sexo;
    var $des_obras_soc;
    var $fecha_nac;
    var $num_solici;
    var $cod_plan;
    var $tipo_plan;
    var $desc_plan;
    var $fecha_ing;
    var $des_categoria;
    var $des_mot_baja;
    var $glosa_parentesco;
    var $afi;

    function VerAfiliado($num_solici,$ruta,$editar,$nro_doc){

        $afi_sql = "SELECT afi.fecha_baja,afi.titular,nro_doc, nombre1, nombre2, apellido, afi.sexo, des_obras_soc, fecha_nac,num_solici, cod_plan, tipo_plan,
            desc_plan, fecha_ing, des_categoria, des_mot_baja,glosa_parentesco
            FROM afi
            LEFT JOIN parentesco ON parentesco.cod_parentesco = afi.cod_parentesco
            WHERE num_solici='".$num_solici."' AND nro_doc='".$nro_doc."'";

        //echo $afi_sql;
        
        $afi_q = mysql_query($afi_sql);

        $afiliados = array();
        $rut = new Datos;
        while ($afi = mysql_fetch_array($afi_q)){
        
            $rut->validar_rut($afi['nro_doc']);

            ?>
            <div class="mensaje1">

                <h1><img src="IMG/U1.png" />&zwj;Beneficiario</h1>

            <table class="table">
            <tr>
                <td>RUT</td><td><?php echo $rut->nro_doc; ?></td>
                <td>NOMBRES</td><td><?php echo $afi['nombre1']; ?>&zwnj;&zwnj; <?php echo $afi['nombre2']; ?></td>
                <td>APELLIDOS</td><td><?php echo $afi['apellido']; ?></td>
                <td>&zwj;</td><td>&zwj;</td>
                
            </tr>

            <tr>
                
                <td>SEXO</td><td><?php echo $afi['sexo']; ?></td>
                <td>P. SALUD</td><td><?php echo $afi['des_obras_soc']; ?></td>
                <td>F_NACIMIENTO</td><td><?php echo $afi['fecha_nac']; ?></td>
                <td>F_INGRESO</td><td><?php echo $afi['fecha_ing']; ?></td>
            </tr>

            <tr>
                <td>F_BAJA</td><td><?php echo $afi['fecha_baja']; ?></td>
                <td>CATEGORIA</td><td><?php echo $afi['des_categoria']; ?></td>
                <td>ESTADO</td><td><?php echo $afi['des_mot_baja']; ?></td>
                <td>PARENTESCO</td><td><?php echo $afi['glosa_parentesco']; ?></td>
            </tr>

            </table>

                

            </div>
            <?php
            if ($editar > 0){
            ?>
<div align="right" class="mensaje1"><a href="<?php echo $ruta; ?>&num_solici=<?php echo $afi['num_solici']; ?>&nro_doc=<?php echo $afi['nro_doc'] ?>&titular=<?php echo $afi['titular']; ?>" class="boton">Editar</a></div>
            <?php
            }
        }

    }

//MUESTRA GRUPO
    function VerAfiliados($num_solici,$ruta,$editar){

        $afi_sql = "SELECT afi.fecha_baja,afi.titular,nro_doc, nombre1, nombre2, apellido, afi.sexo, des_obras_soc, fecha_nac,num_solici, cod_plan, tipo_plan,
            desc_plan, fecha_ing, des_categoria, des_mot_baja,glosa_parentesco
            FROM afi
            LEFT JOIN parentesco ON parentesco.cod_parentesco = afi.cod_parentesco
            WHERE num_solici='".$num_solici."'";

        //echo $afi_sql;
        
        $afi_q = mysql_query($afi_sql);

        $afiliados = array();
        $rut = new Datos;
        while ($afi = mysql_fetch_array($afi_q)){
        
            $rut->validar_rut($afi['nro_doc']);

            ?>
            <div class="mensaje1">

                <h1><img src="IMG/U1.png" />&zwj;Beneficiario</h1>

            <table class="table">
            <tr>
                <td>RUT</td><td><?php echo $rut->nro_doc; ?></td>
                <td>NOMBRES</td><td><?php echo $afi['nombre1']; ?>&zwnj;&zwnj; <?php echo $afi['nombre2']; ?></td>
                <td>APELLIDOS</td><td><?php echo $afi['apellido']; ?></td>
                <td>&zwj;</td><td>&zwj;</td>
                
            </tr>

            <tr>
                
                <td>SEXO</td><td><?php echo $afi['sexo']; ?></td>
                <td>P. SALUD</td><td><?php echo $afi['des_obras_soc']; ?></td>
                <td>F_NACIMIENTO</td><td><?php echo $afi['fecha_nac']; ?></td>
                <td>F_INGRESO</td><td><?php echo $afi['fecha_ing']; ?></td>
            </tr>

            <tr>
                <td>F_BAJA</td><td><?php echo $afi['fecha_baja']; ?></td>
                <td>CATEGORIA</td><td><?php echo $afi['des_categoria']; ?></td>
                <td>ESTADO</td><td><?php echo $afi['des_mot_baja']; ?></td>
                <td>PARENTESCO</td><td><?php echo $afi['glosa_parentesco']; ?></td>
            </tr>

            </table>

                

            </div>
            <?php
            if ($editar > 0){
            ?>
<div align="right" class="mensaje1"><a href="<?php echo $ruta; ?>&num_solici=<?php echo $afi['num_solici']; ?>&nro_doc=<?php echo $afi['nro_doc'] ?>&titular=<?php echo $afi['titular']; ?>" class="boton">Editar</a></div>
            <?php
            }
        }

    }

    function EditarAfiliado_form($num_solici,$rut_titular,$nro_doc){
        ?>
	<form action="BUSQ/M_BUSQ_SUB_1.php" method="post" id="Afiliados_editar">
        <div class="mensaje1">
        <?php
        $sql = "SELECT cod_obras_soc,des_obras_soc,afi.titular,nro_doc, nombre1, nombre2, apellido, sexo, des_obras_soc, fecha_nac,num_solici, cod_plan, tipo_plan,
            desc_plan, fecha_ing, des_categoria, des_mot_baja,glosa_parentesco, parentesco.cod_parentesco,afi.cod_mot_baja
            FROM afi
            LEFT JOIN parentesco ON parentesco.cod_parentesco = afi.cod_parentesco
            WHERE num_solici='".$num_solici."' AND nro_doc ='".$nro_doc."'";

        $query = mysql_query($sql);

        while ($afiliado = mysql_fetch_array($query) ){
        ?>

            <h1><img src="IMG/U1.png" />&zwnj;Beneficiario</h1>
	<table class="table">

        <tr>
            <td><strong>RUT</strong></td><td><input readonly="readonly" type="text" name="nro_doc" value="<?php $rut = new Datos; $rut->validar_rut($afiliado['nro_doc']); echo $rut->nro_doc; ?>" class="rut"/></td>
	<td><strong>NOMBRE 1</strong></td><td><input type="text" name="nombre1" value="<?php echo $afiliado['nombre1']; ?>"/></td>
	</tr>

	<tr>
	<td><strong>NOMBRE 2</strong></td><td><input type="text" name="nombre2" value="<?php echo $afiliado['nombre2']; ?>"  /></td>
	<td><strong>APELLIDOS</strong></td><td><input type="text" name="apellido" value="<?php echo $afiliado['apellido']; ?>" /></td>
	</tr>

	<tr>
	<td><strong>SEXO</strong></td><td><select name="sexo">
                <option value="<?php echo $afiliado['sexo']; ?>"><?php if($afiliado['sexo'] =='M'){echo 'MASCULINO';}else{echo 'FEMENINO'; } ?></option>
                <option value="M">MASCULINO</option>
                <option value="F">FEMENINO</option>
            </select>
        </td>

	<td><strong>P. DE SALUD</strong></td>
	<td>
	<?php
	$isa_sql = "SELECT nro_doc, descripcion FROM obras_soc WHERE nro_doc != '".$afiliado['cod_obras_soc']."'";



	$isa_query = mysql_query($isa_sql);

	?>
	<select name="obra_afi">
	<option value="<?php echo $afiliado['cod_obras_soc']; ?>"><?php echo $afiliado['des_obras_soc']; ?></option>
	<?php
	while ($isa = mysql_fetch_array($isa_query)){
	?>
	<option value="<?php echo $isa['nro_doc']; ?>"><?php echo $isa['descripcion']; ?></option>
	<?php
	}
	?>
	</select>
	</td>

	</tr>

	<tr>
	<td><strong>F.NAC</strong></td><td><input type="text" name="fecha_nac" class="calendario" value="<?php echo $afiliado['fecha_nac']; ?>"/></td>
	<td><strong>PARENTESCO</strong></td>

	<td>

	<?php
	$pare_sql = "SELECT cod_parentesco, glosa_parentesco FROM parentesco WHERE cod_parentesco != '".$afiliado['cod_parentesco']."'";
	$pare_query = mysql_query($pare_sql);

	?>
	<select name="cod_parentesco">
	<option value="<?php echo $afiliado['cod_parentesco'];?>"><?php echo $afiliado['glosa_parentesco']; ?></option>
	<?php
	while ($pare = mysql_fetch_array($pare_query)){
	?>
	<option value="<?php echo $pare['cod_parentesco']; ?>"><?php echo $pare['glosa_parentesco']; ?></option>
	<?php
	}
	?>
	</select>

	</td>
	</tr>

        <tr>
        
       <td>Estado</td>

        <td>

	<?php
	$pare_sql = "SELECT mot_baja.codigo, mot_baja.descripcion FROM mot_baja 
            WHERE codigo != '".$afiliado['cod_mot_baja']."'
                AND codigo != '04' AND codigo != 'AJ' AND codigo != 'AL' AND codigo != 'AM' AND codigo != '02'
                AND codigo != 'DI'";
	$pare_query = mysql_query($pare_sql);

	?>
	<select name="cod_baja">
	<option value="<?php echo $afiliado['cod_mot_baja'];?>"><?php echo strtoupper($afiliado['des_mot_baja']); ?></option>
	<?php
	while ($pare = mysql_fetch_array($pare_query)){
	?>
	<option value="<?php echo $pare['codigo']; ?>"><?php echo strtoupper($pare['descripcion']); ?></option>
	<?php
	}
	?>
	</select>

	</td>


        </tr>


	<tr style="display:none">
	<td><strong>num_solici</strong></td><td><input type="text" name="guardar_edicion" value="1"/></td>
	<td><strong>num_solici</strong></td><td><input type="text" name="num_solici" value="<?php echo $afiliado['num_solici']; ?>"/></td>
	<td><strong>cod_plan</strong></td><td><input type="text" name="cod_plan" value="<?php echo $afiliado['cod_plan']; ?>"/></td>
	<td><strong>tipo_plan</strong></td><td><input type="text" name="tipo_plan" value="<?php echo $afiliado['tipo_plan']; ?>"/></td>
	<td><strong>titular</strong></td><td><input type="text" name="titular" value="<?php echo $afiliado['titular']; ?>"/></td>
	</tr>
<?php
        }
?>
	</table>
        </div>

            <div align="right"><input type="submit" value="Cambiar" class="boton"/></div>

        </form>
        <?php


    }

    function VerAntecedentes_medico($nro_solici,$nro_doc){
        $ate = "SELECT ate_medicos.cod, ate_medicos.descripcion
               FROM ate_medicos
               INNER JOIN ate_medicos_reg ON ate_medicos_reg.ate_medicos = ate_medicos.cod
               WHERE ate_medicos_reg.codigo ='".$nro_doc."' AND ate_medicos_reg.num_solici='".$num_solici."'";
                }

 function Secuencia($num_solici){


$sql ="SELECT COUNT(num_solici) AS secuencia,num_solici,nro_doc
FROM afiliados
WHERE (afiliados.cod_baja='00'  ||  afiliados.cod_baja='AJ' || afiliados.cod_baja='AZ'  ||  afiliados.cod_baja='04')
AND num_solici='".$num_solici."' GROUP BY num_solici";


$query = mysql_query($sql);

    $secuencia = mysql_fetch_array($query);

    $con = 'UPDATE contratos SET secuencia="'.$secuencia['secuencia'].'"
        WHERE num_solici="'.$num_solici.'"';


    if (mysql_query($con)){

        echo '';
        return $secuencia['secuencia'];
    }

    else{
        echo '<br />error<br />';
    }
}

}

?>
