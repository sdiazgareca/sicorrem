<?php
define ('HOST','192.168.168.21');
define ('USUARIO','root');
define ('CLAVE','nuncalosabras');
define ('BD','sicoremm2');

/* mensajes */
define ('ERROR_RUT','<div class="mensaje2"><img src="IMG/M1.png" />El rut ingresado existe en la base de datos.</div>');
define ('INGRE_OK','<div class="mensaje1"><img src="IMG/M2.png" />Los datos se almacenaron con exito.</div>');
define ('ELI_OK','<div class="mensaje1"><img src="IMG/M2.png" />Los datos se elminaron con exito.</div>');
define ('OK','<div class="mensaje1"><img src="IMG/M2.png" />&nbsp;Valor Almacenado</div>');
define ('BORRADO','<div class="mensaje1"><img src="IMG/M2.png" />&nbsp;Valor Eliminado</div>');
define ('ERROR','<div class="mensaje2"><img src="IMG/M1.png" />&nbsp;El valor existe en la BD.</div>');
define ('ERROR2','<div class="mensaje2"><img src="IMG/M1.png" />&nbsp;No es posible eliminar el registro.</div>');
define ('v_secuencia','3999');

/*
echo '<br /><strong>'.$_SERVER['SCRIPT_NAME'].'</strong><br />';

foreach($_POST AS $campo=>$valor){
    echo 'POST '.$campo.' '.$valor.'<br />';
}
foreach($_GET AS $campo=>$valor){
    echo 'GET '.$campo.' '.$valor.'<br />';
}
*/
?>
