<?php

 header('Content-type: application/msword');
 header('Content-Disposition: inline; filename=FEDOC.rtf');

include_once('DAT/conf.php');
include_once('DAT/bd.php');
include_once('CLA/Periodos_Final.php');
include_once('CLA/Datos.php');
?>

<style type="type/css" >

    body{
        font-size: 10px;
        font-family: Arial;
        text-align: justify;
}

p{
    text-align: justify;
    font-size: 15px;
}

table{
    background-color:  #C0C0C0;
    border: none;
}

table tr{
    background-color:#ffffff;
    border: solid 1px #ffffff;
}

table tr td{
    background-color:#ffffff;
    font-size: 12px;
    border: solid 1px #ffffff;

}

</style>
<?php

$cobrador_sql = "SELECT cobrador.nombre1, cobrador.nombre2, cobrador.apellidos, cobrador.codigo,nro_doc
                 FROM cobrador
                 WHERE cobrador.codigo='".$_GET['cobrador']."'";

$query_cobrador = mysql_query($cobrador_sql);

$cobrador = mysql_fetch_array($query_cobrador);

$rut = new Datos();
$rut->validar_rut($cobrador['nro_doc']);

?>



    <strong>FORMULARIO DE ENTREGA DE DOCUMENTOS</strong>

<p>Se deja constancia de la entrega por parte de <strong>NORTH MEDICAL SERVICE S.A.</strong>, a don(a)
<strong><?php echo strtoupper($cobrador['nombre1'].' '.$cobrador['nombre2'].' '.$cobrador['apellidos']); ?></strong>,
<strong>Rut <?php echo $rut->nro_doc;?></strong>, según documento adjunto:</p>
<p>Cabe destacar que:</p>
<p>- El receptor de esta documentación es totalmente responsable de ella, por lo que ante
    cualquier pérdida, mal uso u otra situación que altere o modifique las instrucciones 
    emanadas por la Administración de la Sociedad, será susceptible a la aplicación de las
    cláusulas contempladas en el contrato de trabajo y su anexo.
</p>
<p>- El receptor de esta documentación estará obligado a rendir diariamente a la Administración de 
    <strong>NORTH MEDICAL SERVICE S.A.</strong> los contratos suscritos y las rendiciones de caja diaria.</p>
<p>Para dejar constancia de la entrega, firma el receptor de los documentos, boletas en cobro.</p>

<?php
$periodos = new Periodos_Final();
$sumaPeriodoActual = $periodos->entregaActual($_GET['periodo'], $_GET['cierre1'], $_GET['cierre3'],$_GET['cobrador'],1);

echo '<br />';
echo '<strong>TOTAL '.$sumaPeriodoActual.'</strong>';
echo '<br />';
echo '<br />';
echo '<strong>Nombre Recaudador : '.strtoupper($cobrador['nombre1'].' '.$cobrador['nombre2'].' '.$cobrador['apellidos']).'</strong>';
echo '<br />';
echo '<br />';
echo '<strong>Rut               : '.$rut->nro_doc.'</strong>';
echo '<br />';
echo '<br />';
echo '<br />';
echo '<strong>Firma	        :</strong>';

?>


&zwnj;