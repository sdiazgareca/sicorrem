<?php

class Fecha {


    //formato fecha 25-04-2011
    function DifeDias($primera, $segunda){
    $valoresPrimera = explode ("-", $primera);
    $valoresSegunda = explode ("-", $segunda);
    $diaPrimera    = $valoresPrimera[0];
    $mesPrimera  = $valoresPrimera[1];
    $anyoPrimera   = $valoresPrimera[2];
    $diaSegunda   = $valoresSegunda[0];
    $mesSegunda = $valoresSegunda[1];
    $anyoSegunda  = $valoresSegunda[2];
    $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);
    $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);
    if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
      // "La fecha ".$primera." no es válida";
      return 0;
    }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
      // "La fecha ".$segunda." no es válida";
      return 0;
    }else{
      return  $diasPrimeraJuliano - $diasSegundaJuliano;
    }
  }  

}
?>
