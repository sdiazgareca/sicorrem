<?php
function CambiarFormatoMYSQL($valor){
$Hs_despacho = explode(' ',$valor);
$Hs_despacho_fecha = $Hs_despacho[1];
$Hs_despacho_fecha_mysql = explode ('-',$Hs_despacho_fecha);
$final = $Hs_despacho_fecha_mysql[2].'-'.$Hs_despacho_fecha_mysql[1].'-'.$Hs_despacho_fecha_mysql[0].' '.$Hs_despacho[2];
return $final;
}
?>