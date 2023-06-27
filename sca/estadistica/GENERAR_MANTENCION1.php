<?php
include("../conf.php");
include("../bd.php");
?>



<table class="celda1">
<tr>
<td class="celda2">
<h1><img src="IMG/page_find.png" width="16" height="16" />&nbsp;MANTENCION </h1>
<form method="get" action="estadistica/mantencion.php">
<select id="mes_manten" name="mes_manten">
<option value="1">ENERO</option>
<option value="2">FEBRERO</option>
<option value="3">MARZO</option>
<option value="4">ABRIL</option>
<option value="5">MAYO</option>
<option value="6">JUNIO</option>
<option value="7">JULIO</option>
<option value="8">AGOSTO</option>
<option value="9">SEPTIEMBRE</option>
<option value="10">OCTUBRE</option>
<option value="11">NOVIEMBRE</option>
<option value="12">DICIEMBRE</option>
</select>

<select id="anio_manten" name="anio_manten">
<option value="2009">2009</option>
<option value="2010">2010</option>
<option value="2011">2011</option>
<option value="2012">2012</option>
</select>
&nbsp;Entre&nbsp;
<select id="mantenciondia1" name="mantenciondia1">
<option value=0>&nbsp;</option>
<?php 
for($i=1;$i<32;$i++){
if ($i <10){
$valor ='0'.$i;
}
else{
$valor =$i;
}
?>
<option value="<?php echo $i; ?>"><?php echo $valor; ?></option>
<?php
}
?>
</select>

&nbsp;Y&nbsp;
<select id="mantenciondia2" name="mantenciondia2">
<option value=0>&nbsp;</option>
<?php 
for($i=1;$i<32;$i++){
if ($i <10){
$valor ='0'.$i;
}
else{
$valor =$i;
}
?>
<option value="<?php echo $i; ?>"><?php echo $valor; ?></option>
<?php
}
?>
</select>


&nbsp;
<input type="submit"class="boton"  value="GENERAR"/>


</form>
</td>
</tr>


<tr>
<td class="celda2"><h1><img src="IMG/page_find.png" width="16" height="16" />&nbsp;COPAGOS</h1>
<form method="get" action="estadistica/COPAGO.php">
<select id="mes_manten" name="mes_manten">
<option value="1">ENERO</option>
<option value="2">FEBRERO</option>
<option value="3">MARZO</option>
<option value="4">ABRIL</option>
<option value="5">MAYO</option>
<option value="6">JUNIO</option>
<option value="7">JULIO</option>
<option value="8">AGOSTO</option>
<option value="9">SEPTIEMBRE</option>
<option value="10">OCTUBRE</option>
<option value="11">NOVIEMBRE</option>
<option value="12">DICIEMBRE</option>
</select>

<select id="anio_manten" name="anio_manten">
<option value="2009">2009</option>
<option value="2010">2010</option>
<option value="2011">2011</option>
<option value="2012">2012</option>
</select>

&nbsp;Entre&nbsp;
<select id="dia1" name="copagodia1">
<option value=0>&nbsp;</option>
<?php 
for($i=1;$i<32;$i++){
if ($i <10){
$valor ='0'.$i;
}
else{
$valor =$i;
}
?>
<option value="<?php echo $i; ?>"><?php echo $valor; ?></option>
<?php
}
?>
</select>

&nbsp;Y&nbsp;
<select id="dia2" name="copagodia2">
<option value=0>&nbsp;</option>
<?php 
for($i=1;$i<32;$i++){
if ($i <10){
$valor ='0'.$i;
}
else{
$valor =$i;
}
?>
<option value="<?php echo $i; ?>"><?php echo $valor; ?></option>
<?php
}
?>
</select>
<input type="submit"class="boton"  value="GENERAR"/>
</form>
</td>
</tr>



<tr>
<td class="celda2"><h1><img src="IMG/page_find.png" width="16" height="16" />&nbsp;COPAGOS DETALLE</h1>
<form method="get" action="estadistica/COPAGO_RESUMEN.php">
<select id="mes_manten" name="mes_manten">
<option value="1">ENERO</option>
<option value="2">FEBRERO</option>
<option value="3">MARZO</option>
<option value="4">ABRIL</option>
<option value="5">MAYO</option>
<option value="6">JUNIO</option>
<option value="7">JULIO</option>
<option value="8">AGOSTO</option>
<option value="9">SEPTIEMBRE</option>
<option value="10">OCTUBRE</option>
<option value="11">NOVIEMBRE</option>
<option value="12">DICIEMBRE</option>
</select>

<select id="anio_manten" name="anio_manten">
<option value="2009">2009</option>
<option value="2010">2010</option>
<option value="2011">2011</option>
<option value="2012">2012</option>
</select>

&nbsp;Entre&nbsp;
<select id="dia1" name="copagodia1">
<option value=0>&nbsp;</option>
<?php 
for($i=1;$i<32;$i++){
if ($i <10){
$valor ='0'.$i;
}
else{
$valor =$i;
}
?>
<option value="<?php echo $i; ?>"><?php echo $valor; ?></option>
<?php
}
?>
</select>

&nbsp;Y&nbsp;
<select id="dia2" name="copagodia2">
<option value=0>&nbsp;</option>
<?php 
for($i=1;$i<32;$i++){
if ($i <10){
$valor ='0'.$i;
}
else{
$valor =$i;
}
?>
<option value="<?php echo $i; ?>"><?php echo $valor; ?></option>
<?php
}
?>
</select>
<input type="submit"class="boton"  value="GENERAR"/>
</form>
</td>
</tr>



<tr>
<td class="celda2"><h1><img src="IMG/page_find.png" width="16" height="16" />&nbsp;CONVENIO MEDIMEL</h1>

<form method="get" action="estadistica/med.php">
<select id="mes_conv_med" name="mes_conv_med">
<option value="1">ENERO</option>
<option value="2">FEBRERO</option>
<option value="3">MARZO</option>
<option value="4">ABRIL</option>
<option value="5">MAYO</option>
<option value="6">JUNIO</option>
<option value="7">JULIO</option>
<option value="8">AGOSTO</option>
<option value="9">SEPTIEMBRE</option>
<option value="10">OCTUBRE</option>
<option value="11">NOVIEMBRE</option>
<option value="12">DICIEMBRE</option>
</select>

<select id="anio_conv_med" name="anio_conv_med">
<option value="2009">2009</option>
<option value="2010">2010</option>
<option value="2011">2011</option>
<option value="2012">2012</option>
</select>
<input type="submit"class="boton"  value="GENERAR"/>
</form>
</td>
</tr>







<tr>
<td class="celda2"><h1><img src="IMG/page_find.png" width="16" height="16" />&nbsp;TRASLADOS</h1>
<form method="get" action="estadistica/traslados.php">

<select name="plan_tras" id="plan_tras">
<?php
$query = "select cod_plan,desc_plan from planes_traslados";
$query2= mysql_query($query);
while ($mat = mysql_fetch_array($query2)){
?>
<option value="<?php echo $mat['cod_plan'];?>"><?php echo $mat['desc_plan'];?></option>
<?
}
?>
<option value="">Todos</option>
</select>

<select id="mes_tras" name="mes_tras">
<option value="1">ENERO</option>
<option value="2">FEBRERO</option>
<option value="3">MARZO</option>
<option value="4">ABRIL</option>
<option value="5">MAYO</option>
<option value="6">JUNIO</option>
<option value="7">JULIO</option>
<option value="8">AGOSTO</option>
<option value="9">SEPTIEMBRE</option>
<option value="10">OCTUBRE</option>
<option value="11">NOVIEMBRE</option>
<option value="12">DICIEMBRE</option>
</select>

<select id="anio_tras" name="anio_tras">
<option value="2009">2009</option>
<option value="2010">2010</option>
<option value="2011">2011</option>
<option value="2012">2012</option>
</select>
<input type="submit"class="boton"  value="GENERAR"/>
</form>
</td>
</tr>




















<tr>
<td class="celda2">
<h1><img src="IMG/page_find.png" width="16" height="16" />&nbsp;ESTADISTICA</h1>
<form method="get" action="estadistica/estadistica_nueva.php">
    
<table>
<tr>
<td><strong>FECHA DEL</strong></td><td> <input type="text" name="f_del" /> (Formato dd-mm-yyyy)</td>
</tr>
<tr>
<td><strong>FECHA AL </strong></td><td>  <input type="text" name="f_al" /></td>
</tr>

<tr>
<td></td><td> <input type="submit"class="boton"  value="GENERAR"/></td>
</tr>


</table>
    
</form>
</td>
</tr>

























<tr>
<td class="celda2">
<h1><img src="IMG/page_find.png" width="16" height="16" />&nbsp;LLAMADOS RECIBIDOS POR HORA Y FECHA</h1>
<form method="get" action="estadistica/estadistica_hora.php">
    
<table>
<tr>
<td><strong>FECHA DEL</strong></td><td> <input type="text" name="f_del" /> (Formato dd-mm-yyyy)</td>
</tr>
<tr>
<td><strong>FECHA AL </strong></td><td>  <input type="text" name="f_al" /></td>
</tr>

<tr>
<td><strong>ENTRE LAS</strong></td><td> 
    
    H <select name="H_ENTRE" >
        <?php
        for($i = 0; $i < 25; $i++){
            
           if ($i < 10){$i = '0'.$i;}
            
            echo '<option value="'.$i.'">'.$i.'</option>';
            
        }
        ?>
        
    </select>

    M <select name="M_ENTRE" >
        <?php
        for($i = 0; $i < 60; $i++){
            if ($i < 10){$i = '0'.$i;}
            echo '<option value="'.$i.'">'.$i.'</option>';
            
        }
        ?>
        
    </select>    
    
    
</td>
</tr>
<tr>
<td><strong>Y LAS </strong></td><td>
    
        H <select name="H_AL" >
        <?php
        for($i = 0; $i < 25; $i++){
            if ($i < 10){$i = '0'.$i;}
            echo '<option value="'.$i.'">'.$i.'</option>';
            
        }
        ?>
        
    </select>

    M <select name="M_AL" >
        <?php
        for($i = 0; $i < 60; $i++){
            if ($i < 10){$i = '0'.$i;}
            echo '<option value="'.$i.'">'.$i.'</option>';
            
        }
        ?>
        
    </select>  
    
    
</td>
</tr>

<tr>
<td></td><td> <input type="submit"class="boton"  value="GENERAR"/></td>
</tr>


</table>
    
</form>
</td>
</tr>

















<tr>
<td class="celda2">
<h1><img src="IMG/page_find.png" width="16" height="16" />&nbsp;LLAMADOS RECIBIDOS POR HORA Y FECHA (NOMINA)</h1>
<form method="get" action="estadistica/estadistica_hora_nomina.php">
    
<table>
<tr>
<td><strong>FECHA DEL</strong></td><td> <input type="text" name="f_del" /> (Formato dd-mm-yyyy)</td>
</tr>
<tr>
<td><strong>FECHA AL </strong></td><td>  <input type="text" name="f_al" /></td>
</tr>

<tr>
<td><strong>ENTRE LAS</strong></td><td> 
    
    H <select name="H_ENTRE" >
        <?php
        for($i = 0; $i < 25; $i++){
            
           if ($i < 10){$i = '0'.$i;}
            
            echo '<option value="'.$i.'">'.$i.'</option>';
            
        }
        ?>
        
    </select>

    M <select name="M_ENTRE" >
        <?php
        for($i = 0; $i < 60; $i++){
            if ($i < 10){$i = '0'.$i;}
            echo '<option value="'.$i.'">'.$i.'</option>';
            
        }
        ?>
        
    </select>    
    
    
</td>
</tr>
<tr>
<td><strong>Y LAS </strong></td><td>
    
        H <select name="H_AL" >
        <?php
        for($i = 0; $i < 25; $i++){
            if ($i < 10){$i = '0'.$i;}
            echo '<option value="'.$i.'">'.$i.'</option>';
            
        }
        ?>
        
    </select>

    M <select name="M_AL" >
        <?php
        for($i = 0; $i < 60; $i++){
            if ($i < 10){$i = '0'.$i;}
            echo '<option value="'.$i.'">'.$i.'</option>';
            
        }
        ?>
        
    </select>  
    
    
</td>
</tr>

<tr>
<td></td><td> <input type="submit"class="boton"  value="GENERAR"/></td>
</tr>


</table>
    
</form>
</td>
</tr>





















</table>