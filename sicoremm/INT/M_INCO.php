<script type="text/javascript">
$(document).ready(function() {

$('a').click(function() {

 	var ruta = $(this).attr('href');
 	$('#SUB1').load(ruta);
	$.ajax({cache: false});
	ruta ="";
 	return false;
 });

$('#ajax #incopp').submit(function(){

         if(!confirm(" Esta seguro de continuar?")) {
	  return false;}

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#bub0').html(data);}})

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

if ($_POST['num_solici'] > 1){

    echo '<h1>DATOS DEL CONTRATANTE RESPONSABLE DEL PAGO</h1><br />';

    $sql = 'SELECT * FROM CONTRATA_VISTA WHERE num_solici="'.$_POST['num_solici'].'"';

    //echo $sql;
    
    $query = mysql_query($sql);
    $num = mysql_num_rows($query);

    if ($num > 0){

    ?>
            <?php
            while ($cont = mysql_fetch_array($query)){

            $rut = new Datos;
            $rut->validar_rut($cont['titular']);

            echo '<div class="mensaje1">';
            echo '<table class="table">';
            echo "<tr>";
            echo "<td><strong>N CONTRATO</strong></td><td>".$cont['num_solici']."</td>";
            echo "<td><strong>ESTADO</strong></td><td>".$cont['e_contrato_des']."</td>";
            echo "<td><strong>RUT TITULAR</strong></td><td>".$rut->nro_doc."</td>";
            echo "<td><strong>TITULAR</strong></td><td>".$cont['nombre1']." ".$cont['nombre2']." ".$cont['apellido']."</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td><strong>COD_PLAN</strong></td><td>".$cont['cod_plan']."</td>";
            echo "<td><strong>TIPO_PLAN</strong></td><td>".$cont['tipo_plan']."</td>";
            echo "<td><strong>PLAN</strong></td><td>".$cont['desc_plan']."</td>";
            echo "<td><strong>SEC</strong></td><td>".$cont['secuencia']."</td>";
            echo "</tr>";

            echo "<tr>";

            if ($cont['empresa'] == ""){
                $empree = "WHERE codigo != 50 AND codigo != 60";
            }
            else{

                echo "<td>Empresa</td><td>".$cont['empresa']."</td>";
                $empree = "WHERE codigo != 60";
            }

            if($cont['cod_plan'] == 'W71' && $cont['tipo_plan'] == '2'){
                $empree = "WHERE codigo != 50 AND codigo != 60";
            }

            echo "<td><strong>F_PAGO</strong></td><td>".$cont['des_fpago']."</td>";
            echo "<td><strong>V_INCORPORACION</strong></td><td>".$cont['v_incor']."</td>";
            echo "<td><strong>MONTO</strong></td><td>".$cont['mensualidad']."</td>";
            echo "<td><strong>AJUSTE</strong></td><td>".$cont['ajuste']."</td>";
            echo "</tr>";

            echo "<td><strong>N_INCO_SP</strong></td><td>".$cont['n_inco_grat']."</td>";
            
            echo "</table>";
            echo '</div>';


            //COMPRUBA LA FORMA DE PAGO
            if ($cont['e_contrato'] == '400' || $cont['e_contrato'] == '500' || $cont['e_contrato'] == '3500'  || $cont['e_contrato'] == '1000'){

               ?>

            <form action="INT/SUB_M_INCO_2.php" method="post" id="incopp" name="incopp">
                <input type="text" value="<?php echo $_POST['vendedor']; ?>" style="display:none;" name="vendedor" />
                <input type="text" value="<?php echo $_POST['num_solici']; ?>" style="display:none;" name="num_solici" />
                <input type="text" value="<?php echo $cont['titular']; ?>" style="display:none;" name="titular" />
                <input type="text" value="<?php echo $cont['v_incor']; ?>" style="display:none;" name="v_incor" />
                <input type="text" value="<?php echo $cont['secuencia']; ?>" style="display:none;" name="sec_anterior" />
                <input type="text" value="<?php echo $cont['cod_plan']; ?>" style="display:none;" name="cod_plan" />
                <input type="text" value="<?php echo $cont['tipo_plan']; ?>" style="display:none;" name="tipo_plan" />
                <input type="text" value="<?php echo $cont['tipo_plan']; ?>" style="display:none;" name="tipo_plan" />
                <input type="text" value="<?php echo $cont['n_inco_grat']; ?>" style="display:none;" name="n_inco_grat" />
                <input type="text" value="<?php echo $cont['mensualidad']; ?>" style="display:none;" name="mensualidad" />
                <input type="text" value="<?php echo $cont['ajuste']; ?>" style="display:none;" name="ajuste" />

            <div class="mensaje1">
            <table class="table2">
            <tr>
            <td><strong>N Incorporaciones </strong><input type="text" name="sec" size="3" maxlength="3" /></td>
            <td><strong>N Rendicion</strong> <input type="text" name="rendicion" size="5" maxlength="5" /></td>
            <td><strong>Fecha</strong> <input type="text" name="ff_f_rendicion" class="calendario" /></td>
            </tr>
            </table>
            </div>

                <?php
                echo '<div id="bub0">';
                echo '<h2><strong>FORMA DE PAGO INCORPORACION</strong></h2>';

		$query_sql ="SELECT codigo,descripcion FROM pago_venta ".$empree;
		$query = mysql_query($query_sql);
		echo '<div id="forma_pago" class="sub_menu">';

			while ($f_pago = mysql_fetch_array($query)){
				echo '<a class="link2" href="INT/SUB_M_INCO_3.php?fpago='.$f_pago['codigo'].'&monto='.number_format($valor["valor"],"0",",",".").'">'.strtoupper($f_pago['descripcion']).'</a>&nbsp;&nbsp;';
			}
		echo '</div>';
		echo '<div id="SUB1"></div>';
                echo '</div>';
            ?>
     
            </form>

            <div id="detalle"></div>

            <?php
            }
            else{

                echo '<div class="mensaje2"><img src="IMG/M1.png" />No es posible realizar la incorporacion</div>';
            }

            }

    }

else{
    echo "<div class='mensaje2'><img src='IMG/M1.png' /> CONTRATO NO EXISTE...</div>";
}
}
?>