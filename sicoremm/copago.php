<?php

set_time_limit('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');

include('DAT/conf.php');
include('DAT/bd.php');
date_default_timezone_set('UTC');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SICOREMM</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="JS/jquery/jquery.js"></script>
<script type="text/javascript" src="JS/jquery/jqueryRut.js"></script>
<script type="text/javascript" src="JS/jquery/Jquery.Rut.min.js"></script>
<script type="text/javascript" src="JS/DISP.js"></script>
<script type="text/javascript" src="JS/calendar/development-bundle/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="JS/calendar/development-bundle/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="JS/calendar/development-bundle/ui/jquery.ui.datepicker.js"></script>


<script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/validate/jquery.validate.js"></script>


<link rel="stylesheet" href="JS/calendar/development-bundle/themes/base/jquery.ui.all.css" />
<link href="CSS/estructura.css" rel="stylesheet" type="text/css" />
<link href="CSS/fuentes.css" rel="stylesheet" type="text/css" />
<link href="CSS/menu.css" rel="stylesheet" type="text/css" />
<link href="CSS/main.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <div id="contenedor">
<div id="cabezera">
      <table width="100%">
  <tr>
  <td align="left"><img src="IMG/L1.jpg" /></td>
  <td align="right">&nbsp;</td>
  </tr>
</table>
</div>
        <?php
        if($_POST['modificar']==1 && is_numeric($_POST['valor']) == TRUE && is_numeric($_POST['valor2']) == TRUE){
            $sql9 = "UPDATE planes SET copago=copago+".$_POST['valor']." WHERE copago=".$_POST['valor2'];
            
            
            $sql10 = "UPDATE v_copagos SET codigo=codigo+".$_POST['valor']." WHERE codigo=".$_POST['valor2'];
            //echo '<br />'.$sql.'<br />';
            $query9 = mysql_query($sql9);
            if(!mysql_query($sql10)){
                $sql15 = "DELETE FROM v_copagos WHERE codigo=".$_POST['valor2'];
                $query15=mysql_query($sql15);
            }
        }
        ?>
        
        
        <div id="contenido" style="padding: 10px">
    <h1>Formulario de Edición de valores en Copagos y Traslados</h1>
    <form action="copago.php" method="post">
        <table class="table2">
            <input type="text" style="display: none;" name="modificar" value="1" />
            <tr>
                <td><strong>INCREMENTO</strong></td><td><input type="text" name="valor"/></td><td><strong>MONTO AFECTADO</strong></td><td><input type="text" name="valor2"/></td>
            </tr>
            <tr>
        <td></td><td></td><td></td><td><input type="submit" value="Modificar" /></td>
            </tr>
        </table>
    </form>

    <h1>Lista de valores de Copagos</h1>
    <table class="table2">
        
        <?php
        
        $sql3="UPDATE planes SET copago=0 WHERE copago IS NULL";
        $query3 =  mysql_query($sql3);
        
        $sql ="SELECT copago FROM planes
              UNION
              Select codigo as copago FROM v_copagos
              GROUP BY copago ORDER BY copago";
        $query = mysql_query($sql);
        $cont = 1;
        while($sal = mysql_fetch_array($query)){
            
            echo '<tr>';
            echo '<td>'.$cont.'</td>';
            echo '<td>'.number_format($sal['copago'],0,'.','.').'</td>';
            echo '</tr>';
            $cont ++;
        }
        ?>
    </table>
    
    <br /><br /><br />
    </div>

</div>
</body>
</html>
