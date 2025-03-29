
<?php


include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');

echo '=)';

$sql = "SELECT afiliados.num_solici, afiliados.nro_doc FROM afiliados WHERE afiliados.categoria=1 group by afiliados.nro_doc";
$query = mysql_query($sql);

while ($ctate = mysql_fetch_array($query)){

$s ="UPDATE `cta` SET `num_solici`='".$ctate['num_solici']."' WHERE `nro_doc`='".$ctate['nro_doc']."';";

echo '<br />'.$s.'<br />';

}
?>
