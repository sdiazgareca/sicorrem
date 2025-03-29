<?php

class Select{

function selectSimple($tabla,$cadena,$desc,$value,$id,$name,$cond){

	if ($cond != 'NULL'){
		$con = $cond;
	}
	else{
		$con ="";
	}
	
$sql ="select ".$tabla.".".$cadena.", ".$tabla.".".$value." from ".$tabla." ".$con."";

$con = mysql_query($sql);

echo '<select id="'.$id.'" name="'.$name.'">';
	echo '<option value=""></option>';		
	while ($select =  mysql_fetch_array($con)){
	echo '<option value="'.$select[$value].'">'.strtoupper($select[$desc]).'</option>';
	}
	
echo '</select>'; 

}

function selectOpp2($tabla,$cadena,$desc,$value,$id,$name,$cond,$id_sele,$val){

	if ($cond != 'NULL'){
		$con = $cond;
	}
	else{
		$con ="";
	}
	
$sql ="select ".$tabla.".".$cadena.", ".$tabla.".".$value." from ".$tabla." ".$con."";

$con = mysql_query($sql);

echo '<select id="'.$id.'" name="'.$name.'">';
	echo '<option value="'.$id_sele.'" style="background:#09C">'.strtoupper($val).'</option>';
	while ($select =  mysql_fetch_array($con)){
	echo '<option value="'.$select[$value].'">'.strtoupper($select[$desc]).'</option>';
	}
	
echo '</select>'; 

}

function selectSimpleOpcion($tabla,$cadena,$desc,$value,$id,$name,$cond,$todos){

	if ($cond != 'NULL'){
		$con = $cond;
	}
	else{
		$con ="";
	}
	
$sql ="select ".$tabla.".".$cadena.", ".$tabla.".".$value." from ".$tabla." ".$con."";
//echo $sql;
$con = mysql_query($sql);

echo '<select id="'.$id.'" name="'.$name.'">';
	
	echo '<option value="'.$todos.'">'.strtoupper($todos).'</option>';	
	while ($select =  mysql_fetch_array($con)){
	echo '<option value="'.$select[$value].'">'.strtoupper($select[$desc]).'</option>';
	}

	
echo '</select>'; 

}


function selectSimpleOpcion_II($tabla,$cadena,$desc,$value,$id,$name,$cond,$todos,$todos2){

	if ($cond != 'NULL'){
		$con = $cond;
	}
	else{
		$con ="";
	}
	
$sql ="select ".$tabla.".".$cadena.", ".$tabla.".".$value." from ".$tabla." ".$con."";

$con = mysql_query($sql);

echo '<select id="'.$id.'" name="'.$name.'">';
	
	echo '<option value="'.$todos.'">'.strtoupper($todos2).'</option>';	
	while ($select =  mysql_fetch_array($con)){
	echo '<option value="'.$select[$value].'">'.strtoupper($select[$desc]).'</option>';
	}

	
echo '</select>'; 

}


function selectFecha($anio,$mes,$dia,$anio_inicial){


//diaecho $anio.' '.$mes;

echo '<select name="'.$dia.'"><option value="0">--</option>';
	for($d =1; $d < 32; $d ++){
		echo '<option value="'.$d.'">'.$d.'</option>';
		}
echo '</select>&nbsp;'; 

//mes
echo '<select name="'.$mes.'">';
echo '<option value="0">--</option>';
echo '<option value="1">ENE</option>';
echo '<option value="2">FEB</option>';
echo '<option value="3">MAR</option>';
echo '<option value="4">ABR</option>';
echo '<option value="5">MAY</option>';
echo '<option value="6">JUN</option>';
echo '<option value="7">JUL</option>';
echo '<option value="8">AGO</option>';
echo '<option value="9">SEP</option>';
echo '<option value="10">OCT</option>';
echo '<option value="11">NOV</option>';
echo '<option value="12">DIC</option>';
echo '</select>&nbsp;';

//anio
echo '<select name="'.$anio.'"><option value="0">--</option>';
for ($i = $anio_inicial; $i < (date('Y') +1 ) ; $i ++){
echo '<option value="'.$i.'">'.$i.'</option>';
}
echo '</select>';
}

}

?>


