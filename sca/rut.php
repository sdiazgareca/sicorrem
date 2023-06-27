<?php
 
function ValidaDVRut($rut) {

    $tur = strrev($rut);
    $mult = 2;

    for ($i = 0; $i <= strlen($tur); $i++) { 
       if ($mult > 7) $mult = 2; 
    
       $suma = $mult * substr($tur, $i, 1) + $suma;
       $mult = $mult + 1;
    }
    
    $valor = 11 - ($suma % 11);

    if ($valor == 11) { 
        $codigo_veri = "0";
      } elseif ($valor == 10) {
        $codigo_veri = "k";
      } else { 
        $codigo_veri = $valor;
    }
  return $codigo_veri;
}
/*
$rut = 12345678;
$val = ValidaDVRut($rut);
echo $val;
*/
?>

