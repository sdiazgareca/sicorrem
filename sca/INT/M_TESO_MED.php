<script type="text/javascript">

$(document).ready(function() {

$('#ajax3 a:contains("Editar")').click(function() {

 /* if(!confirm(" Esta seguro de eliminar el antecedente medico?")) {
	  return false;} */
 
	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;

});


$('#tit').submit(function(){

	var url_ajax = $(this).attr('action');
	var data_ajax = $(this).serialize();

	$.ajax({type: 'POST',url:url_ajax,cache: false,data:data_ajax,success: function(data) {
	$('#sub_tes_1').html(data);}})

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

//CAMBIAR

if ($_POST['cambiar']> 0){
    
    $afi_sql ="SELECT num_solici, nombre1, nombre2, apellido, nro_doc, cod_plan, tipo_plan, afiliados.obra_numero
               FROM afiliados where num_solici='".$_POST['num_solici']."' AND nro_doc='".$_POST['afiliados']."'";
    $afi_query = mysql_query($afi_sql);

    $afi = mysql_fetch_array($afi_query);

    $paciente = $afi['nombre1'].' '.$afi['apellido'];

    $con['fichas_sql'] =   "UPDATE fichas SET num_solici='".$_POST['num_solici']."', paciente='".$paciente."',
                    cod_plan='".$afi['cod_plan']."',tipo_plan='".$afi['tipo_plan']."',isapre='".$afi['obra_numero']."',
                        nro_doc='".$_POST['afiliados']."'
                    WHERE fichas.correlativo='".$_POST['protocolo']."'";

    $con['copago_sql'] ="UPDATE copago SET numero_socio='".$_POST['num_solici']."' WHERE protocolo='".$_POST['protocolo']."'";

    $tran = new Datos;
    $tran->Trans($con);




    exit;
    
}


//EDITAR
if($_GET['Editar'] > 0){

    $query = "SELECT fichas.correlativo, copago.boleta,tipo_pago.tipo_pago,
              DATE_FORMAT(copago.fecha,'%d-%m-%Y') as fecha, copago.importe, fichas.paciente,copago.folio_med,
              fichas.paciente,fichas.nro_doc,fichas.num_solici,fichas.cod_plan,fichas.tipo_plan,
              titulares.nombre1 AS nombre1_t, titulares.apellido AS apellido_t, titulares.nro_doc AS nro_doc_t,
              obras_soc.reducido, empresa.empresa AS emp,fichas.observacion
              FROM fichas
              LEFT JOIN copago ON fichas.correlativo = copago.protocolo
              LEFT JOIN contratos ON contratos.num_solici = fichas.num_solici
              LEFT JOIN afiliados on afiliados.titular = contratos.titular
              LEFT JOIN titulares on titulares.nro_doc = contratos.titular
              LEFT JOIN obras_soc ON obras_soc.nro_doc = afiliados.obra_numero
              LEFT JOIN empresa ON empresa.nro_doc = contratos.empresa
              LEFT JOIN tipo_pago ON copago.tipo_pago = tipo_pago.cod 
              WHERE copago.protocolo = '".$_GET['protocolo']."' AND fichas.correlativo='".$_GET['protocolo']."'
              GROUP BY fichas.correlativo";

    $query_q = mysql_query($query);

    while($copagos = mysql_fetch_array($query_q)){
    ?>
                <table class="table4">
                <tr>
                    <th>PROT</th>
                    <th>PLAN</th>
                    <th>CONT</th>
                    <th>BOLE</th>
                    <th>FOLI</th>
                    <th>PACIENTE</th>
                    <th>RUT PACIENTE</th>
                    <th>TITULAR</th>
                    <th>RUT TITULAR</th>
                    <th>P_SAL</th>
                    <th>IMPOR</th>
                    <th>FECHA</th>

                </tr>

                <tr>
                <td><?php echo $copagos['correlativo']; ?></td>
                
                <td><?php echo $copagos['cod_plan'].'/'.$copagos['tipo_plan']; ?></td>
                <td><?php echo $copagos['num_solici']; ?></td>
                <td><?php echo $copagos['boleta']; ?></td>
                <td><?php echo $copagos['folio_med']; ?></td>
                <td><?php $paci = explode(' ',htmlentities($copagos['paciente']));echo  $paci[0].'<br />'.$paci[1].' '.$paci[2].' '.$paci[3].' '.$paci[4]?></td>
                <td><?php $nro_doc = new Datos;$nro_doc->validar_rut($copagos['nro_doc']);echo $nro_doc->nro_doc;?></td>
                <td><?php echo htmlentities($copagos['nombre1_t']).'<br />'.htmlentities($copagos['apellido_t']); ?></td>
                <td><?php $nro_doc = new Datos;$nro_doc->validar_rut($copagos['nro_doc_t']);echo $nro_doc->nro_doc;?></td>
                <td><?php echo $copagos['reducido']; ?></td>
                <td><?php echo $copagos['importe']; ?></td>
                <td><?php echo $copagos['fecha']; ?></td>
                <td style="display:none;"><input type="text" name="correlativo" value="<?php echo $copagos['correlativo']; ?>"/></td>
                </tr>
                </table>
                <br />
                <form action="INT/M_TESO_MED_2.php" method="post" id="tit">
                <table class="table2">
                    <tr>
                        <td><strong>CONTRATO</strong></td>
                        <td><input type="text" name="num_solici" /></td>
                        <td style="display:none;"><input type="text" value="<?php echo $_GET['protocolo']; ?>" size="5" name="protocolo"/></td>
                        <td><input type="submit" value="Buscar" class="boton" /></td>
                    </tr>
                </table>
                </form>
                <div id="sub_tes_1"></div>
<?php
    }
    exit;
}


// GUARDAR CAMBIOS
if(isset($_POST['grabar'])){
//ELIMINA LOS POST NO USADOS

    foreach($_POST as $campo=>$valor){
         
        $cadena = $campo[strlen($campo)-1];

        if (is_numeric($cadena)){
            $cad = substr ($campo, 0, strlen($campo) - 1);
            $_POST[$cad] = $valor;
            $correlativo = $_POST['protocolo'];
            unset($_POST[$campo]);
        }
    }
    //fin foreach
    $sql ='UPDATE copago SET boleta="'.$_POST['nboleta'].'", importe="'.$_POST['importe'].'", folio_med="'.$_POST['folio_med'].'"
        WHERE protocolo="'.$correlativo.'"';
    

    if (mysql_query($sql)){
        echo '<div class="mensaje1"><img src="IMG/M2.png" /> Cambios Guardados</div>';
    }
    else{
        echo '<div class="mensaje2"><img src="IMG/M1.png" /> Error</div>';
    }

}
    
    $condicion = "";
    $entre = "";
    $contador = 0;

    if (( $_POST['ff_f_inicio'] != "" )  &&  ( $_POST['ff_f_termino'] != "" ) ){

        $fecha = new Datos;
        $f_inicio  = $fecha->cambiaf_a_mysql($_POST['ff_f_inicio']);
        $f_termino = $fecha->cambiaf_a_mysql($_POST['ff_f_termino']);
        $entre = "copago.fecha BETWEEN '".$f_inicio."' AND '".$f_termino."'";

   }

       if (( $_POST['ff_f_inicio'] != "" )  &&  ( $_POST['ff_f_termino'] == "" ) ){

        $fecha = new Datos;
        $f_inicio  = $fecha->cambiaf_a_mysql($_POST['ff_f_inicio']);
        $entre = "copago.fecha = '".$f_inicio."'";

   }

   $num = count($_POST);

   $con2 = 0;
   foreach($_POST AS $campo => $valor){
        
        if ($valor != "" && $campo != 'ff_f_inicio'  &&  $campo != 'ff_f_termino' && $campo != 'ff_listado_med'  && $valor != 'TODOS' && $campo != 'folio_med' && $campo != 'importe' && $campo != 'nboleta' && $campo != 'grabar' && $campo != 'protocolo'){

            
            if ($campo == 'nro_doc' || $campo == 'num_solici' || $campo =='empresa'){

                switch($campo){
                    case  'nro_doc':
                    $tabla ='fichas.';
                    break;
                    case  'num_solici':
                    $tabla ='contratos.';
                    break;
                    case  'empresa':
                    $tabla ='contratos.';
                    break;

                }

                $condicion = $condicion.' '.$tabla.$campo.' = "'.$valor.'"  ';
                $con2 = $con2 + 1;

            }else{
                $condicion = $condicion.' '.$campo.' = "'.$valor.'"  ';
                $con2 = $con2 + 1;
            }
        }

     }


     $con = explode('  ',$condicion);
     $num_con = count($con);
     $i = 0;


     $condicion2 = "";

     while ($i < $num_con){

         if ($con[$i] != ""){
            
            $condicion2 = $condicion2.' '.$con[$i];
         }

         if($i < ($num_con -2) && $con[$i] != ""){
             $condicion2 = $condicion2.' AND';
         }


         $i ++;
     }

   if ($condicion2 == ""){
       $entre = 'WHERE '.$entre;
   }

   if ($condicion2 != "" && $enre != ""){
       $entre = 'AND '.$entre;
   }

   if ($condicion2 != ""){

       $condicion2 = 'WHERE '.$condicion2;
   }

   if ($condicion2 != "" AND $entre != ""){

       $condicion2 = $condicion2.' AND ';
   }


    $query = "SELECT fichas.correlativo, copago.boleta,tipo_pago.tipo_pago,
              DATE_FORMAT(copago.fecha,'%d-%m-%Y') as fecha, copago.importe, fichas.paciente,copago.folio_med,
              fichas.paciente,fichas.nro_doc,fichas.num_solici,fichas.cod_plan,fichas.tipo_plan,
              titulares.nombre1 AS nombre1_t, titulares.apellido AS apellido_t, titulares.nro_doc AS nro_doc_t,
              obras_soc.reducido, empresa.empresa AS emp,fichas.observacion
              FROM fichas
              LEFT JOIN copago ON fichas.correlativo = copago.protocolo
              LEFT JOIN contratos ON contratos.num_solici = fichas.num_solici
              LEFT JOIN afiliados on afiliados.titular = contratos.titular
              LEFT JOIN titulares on titulares.nro_doc = contratos.titular
              LEFT JOIN obras_soc ON obras_soc.nro_doc = afiliados.obra_numero
              LEFT JOIN empresa ON empresa.nro_doc = contratos.empresa
              LEFT JOIN tipo_pago ON copago.tipo_pago = tipo_pago.cod 
              ".$condicion2." ".$entre. "
              GROUP BY fichas.correlativo";

    
    //echo '<br /><br />'.$query.'<br /><br />';

    @$query_q = mysql_query($query);
    @$nums = mysql_num_rows($query_q);

    if ($nums > 0){

                $contador = 0;

                while ($copagos = mysql_fetch_array($query_q) ){
                ?>



                <script type="text/javascript">
                    $(document).ready(function() {

                        $('#formm<?php echo $contador; ?>').submit(function(){

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




                <form action="INT/M_TESO_MED.php" method="post" id="formm<?php echo $contador; ?>">
            <table class="table4">
                <tr>
                    <th>PROT</th>
                    <th>PLAN</th>
                    <th>CONT</th>
                    <th>BOLE</th>
                    <th>FOLI</th>
                    <th>PACIENTE</th>
                    <th>RUT PACIENTE</th>
                    <th>TITULAR</th>
                    <th>RUT TITULAR</th>
                    <th>P_SAL</th>
                    <th>IMPOR</th>
                    <th>FECHA</th>
                    <th>&zwnj;</th>
                    <th>&zwnj;</th>
                </tr>

                <tr>
                <td><?php echo $copagos['correlativo']; ?></td>
                <td style="display:none;"><input type="text" value="<?php echo $copagos['correlativo']; ?>" size="5" name="protocolo<?php echo $contador; ?>"/></td>
                <td><?php echo $copagos['cod_plan'].'/'.$copagos['tipo_plan']; ?></td>
                <td><?php echo $copagos['num_solici']; ?></td>
                <td><input type="text" value="<?php echo $copagos['boleta']; ?>" size="5" name="nboleta<?php echo $contador; ?>"/></td>
                <td><input type="text" value="<?php echo $copagos['folio_med']; ?>" size="5" name="folio_med<?php echo $contador; ?>" /></td>
                <td><?php $paci = explode(' ',htmlentities($copagos['paciente']));echo  $paci[0].'<br />'.$paci[1].' '.$paci[2].' '.$paci[3].' '.$paci[4]?></td>
                <td><?php $nro_doc = new Datos;$nro_doc->validar_rut($copagos['nro_doc']);echo $nro_doc->nro_doc;?></td>
                <td><?php echo htmlentities($copagos['nombre1_t']).'<br />'.htmlentities($copagos['apellido_t']); ?></td>
                <td><?php $nro_doc = new Datos;$nro_doc->validar_rut($copagos['nro_doc_t']);echo $nro_doc->nro_doc;?></td>
                <td><?php echo $copagos['reducido']; ?></td>
                <td><input type="text" value="<?php echo $copagos['importe']; ?>" size="5" name="importe<?php echo $contador; ?>" /></td>
                <td><?php echo $copagos['fecha']; ?></td>
                <td style="display: none;"><input type="text" value="1" name="grabar" /></td>

                <?php
                foreach($_POST AS $campo => $valor){
                    if ($valor != ""){
                        if($campo == 'boleta'){
                            $campo2 = 'boleta2';
                        }
                        else{
                            $campo2= $campo;
                        }
                    ?>
                    <td style="display:none;"><input type="text" value="<?php echo $valor; ?>" size="5" name="<?php echo $campo2; ?>"/></td>
                    <?php
                    }
                }
                ?>
                <td><input type="submit" value="Guardar" class="boton" /></td>
                <td><a href="INT/M_TESO_MED.php?Editar=1&protocolo=<?php echo $copagos['correlativo']; ?>" class="boton">Editar</a></td>
                </tr>
                </table>
                    <div style="background:#C6E8EC; width:900px;padding:5px 0px 5px 0px; font-size:9px;"><strong>FORMA DE PAGO</strong> <?php echo $copagos['tipo_pago']; ?> <strong>EMPRESA</strong> <?php echo $copagos['emp']; ?></div>
                    <?php
                    if ($copagos['observacion'] != ""){
                    ?>
                    <div style="background-color:#C6E8EC; width:900px; padding: 5px 0px 5px 0px; font-size: 10px;">&zwnj;<h1>OBSERVACIONES</h1><div style=" padding: 3px; background-color: #ffffff; border: #C6E8EC 5px solid;"><?php echo $copagos['observacion']; ?></div></div>
                    <?php
                    }
                    ?>
                </form>
<br /><br />
                <?php
                $contador = $contador + 1;
                }
                ?>


        
        <?php

    }
    else{
        echo '<div class="mensaje2"><img src="IMG/M1.png" /> No se encontraron datos.</div>';
    }

?>
