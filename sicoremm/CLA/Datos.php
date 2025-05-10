<?php
class Datos{

var $campos;
var $campos_sp;
var $values;
var $values_sp;
var $query; 
var $num;
var $nro_doc;
var $where;
var $dv;

function Trans($query){
	$error = 0;		
	
	mysql_query("BEGIN");
	
	foreach($query as $n_consulta=>$consulta){
		$result = mysql_query($consulta);
		echo '<br /> [ OK ] '.$consulta.'<br />';
		
		if(!$result){
			$error=1;
			echo '<br /><strong> [ ERROR ] '.$consulta.'</strong><br />';
		}
	}

	if($error > 0) {
		mysql_query("ROLLBACK");
		echo ERROR;
	}

	else{
		mysql_query("COMMIT");
		echo OK;
	}	
}

function Trans3($query){
	$error = 0;		
	
	mysql_query("BEGIN");
	
	foreach($query as $n_consulta=>$consulta){
		$result = mysql_query($consulta);
		//echo '<br /> [ OK ] '.$consulta.'<br />';
		
		if(!$result){
			$error=1;
			//echo '<br /><strong> [ ERROR ] '.$consulta.'</strong><br />';
		}
	}

	if($error > 0) {
		mysql_query("ROLLBACK");
		return 0;
	}

	else{
		mysql_query("COMMIT");
		return 1;
	}	
}

function cambiaf_a_normal($fecha){ 
   	$fecha_mysql =explode("-",$fecha); 
   	$lafecha=$fecha_mysql[0]."-".$fecha_mysql[1]."-".$fecha_mysql[2]; 
   	return $lafecha; 
} 

function cambiaf_a_mysql($fecha){ 
   	$fecha_mysql =explode("-",$fecha); 
   	$lafecha=$fecha_mysql[2]."-".$fecha_mysql[1]."-".$fecha_mysql[0]; 
   	return $lafecha; 
} 

function INSERT_PoST($tabla,$condicion,$agg,$otr){

	$cont = count($_POST);$camp = array_keys($_POST);$val = array_values($_POST);

	for( $i=0 ; $i < $cont ; $i++){

		if ($i < 1){
			
			$this->campos = '(';
			$this->values ='(';
					 
	 			if(is_array($agg)){
	
					foreach($agg as $campo => $valor){
						$this->campos =$this->campos.$campo." ,";
						$this->values = $this->values."'".$valor."' ,";
					}
				}
	
	 			if(is_array($otr)){
	
					foreach($otr as $campo2 => $valor2){
						$this->campos = $this->campos.$campo2." ,";
						$this->values = $this->values."'".$valor2."' ,";
					}
		}
	
	}

	$fet = substr($camp[$i],0,3);

		if ($fet != 'ff_'){	
			
			$this->campos = $this->campos.$camp[$i];
			$this->campos_sp = $this->campos_sp.$camp[$i];

				if ($camp[$i] == 'nro_doc'){
					
					$this->Rut($val[$i]);
					
					$this->values = $this->values."'".$this->nro_doc."'";
					$this->values_sp = $this->values_sp."'".$this->nro_doc."'";
					}
					
				else{
					$this->values = $this->values."'".$val[$i]."'";
					$this->values_sp = $this->values_sp."'".$val[$i]."'";
					}

				if ($i < ($cont -1)){
				
					$this->campos = $this->campos.' , ';
					$this->campos_sp = $this->campos_sp.' , ';
					$this->values = $this->values.' , ';
					$this->values_sp = $this->values_sp.' ,';
					}
				
				else{
					$this->campos = $this->campos.' )';
					$this->values = $this->values.' )';
				}
			}
	}


$this->query = 'INSERT INTO '.$tabla.' '.$this->campos.' '.'VALUES '.$this->values.' '.$condicion;
//echo $this->query;
}

function INSERT_PoST_cont($tabla,$condicion,$agg){

$cont = count($agg);

$campos = '(';
$values ='(';			 
$i = 0;

	foreach($agg as $campo => $valor){
		$campos =$campos.$campo;
		
		if ($valor == 'NULL'){
			$values = $values."".$valor."";
		}
		else{
			$values = $values."'".$valor."'";
		}
		
		if ($i < ($cont - 1)){
		
			$campos = $campos.' , ';			
			$values = $values.' , ';
		}
		
		else{
			$campos = $campos.' )';
			$values = $values.' )';
		}
		$i = $i +1;

}

$this->query = 'INSERT INTO '.$tabla.' '.$campos.' '.'VALUES '.$values.' '.$condicion;

}

function UPDATE_PoST($tabla,$condicion){

	$cont = count($_POST);$camp = array_keys($_POST);$val = array_values($_POST); 

		for( $i=0 ; $i < $cont ; $i++){

			if ($i < ($cont -1)){
				$this->query = $this->query.' '.$camp[$i].' = "'.$val[$i].'", ';
			}
	
			else{
				$this->query = $this->query.' '.$camp[$i].' = "'.$val[$i].'"';	
			}
	
		}

	$this->query = 'UPDATE '.$tabla.' SET '.$this->query. ' '.$condicion;
}

function UPDATE_Param($tabla,$campos,$condicion){

	$cont = count($campos);
	$camp = array_keys($campos);
	$val = array_values($campos); 

		for( $i=0 ; $i < $cont ; $i++){

			if ($i < ($cont -1)){
				$this->query = $this->query.' '.$camp[$i].' = "'.$val[$i].'", ';
			}
	
			else{
				$this->query = $this->query.' '.$camp[$i].' = "'.$val[$i].'"';	
			}
	
		}
	
	$this->query = 'UPDATE '.$tabla.' SET '.$this->query. ' '.$condicion;
}

function CompData($campo,$tabla){

	$sql = "SELECT MAX(".$tabla.".".$campo.") AS maxi, COUNT(".$tabla.".".$campo.") AS cont FROM ".$tabla;
	$query = mysql_query($sql);

        //echo '<br/>'.$sql.'<br />';

	$cod = mysql_fetch_array($query);

		if ($cod['cont'] < 1){
			$this->num = $cod['cont'] + 1;
		}

		else{
			$this->num = $cod['maxi'] + 1;
		}
}

function ComDataUni($campos,$tabla){

	if(is_array($campos)){
		
		$num = count($campos);
		$con = 0;
		$condicion = "SELECT * FROM ".$tabla." WHERE ";
		
		foreach($campos as $campo2 => $valor2){
			
			$condicion = " ".$condicion.$campo2." = ";
			$condicion = $condicion."'".$valor2."'";
			
			$cont = $cont + 1;
				
				if ($cont < $num){
					$condicion = $condicion." AND ";
				}
		}

	}	
	$query = mysql_query($condicion);
	$num2 = mysql_num_rows($query);
	return $num2;
	
}

function Rut($rut){
	
	$rut =	str_replace(' ', '', strtr($rut,"."," "));
	
	$rut = substr($rut,0,strlen($rut) - 2);
	
	$this->nro_doc = $rut;}

function validar_rut($rut){

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
	$this->nro_doc = number_format($rut,"0",",",".").' - '.$codigo_veri;
        $this->dv =$codigo_veri;
} 
	
function Listado($campos,$tabla,$where,$cod,$opp,$opi,$ruta,$gett1,$gett2){
	
	$num = count($campos);
	$cont = 0;
	
	if (is_array($campos)){
		foreach($campos as $campo => $valor){
			$camp = $camp.$campo;
				
				if ($cont < ($num -1)){
					$camp = $camp.',';
				}
					
				$cont = $cont +1;
		}
	}
	
	if (is_array($where)){
		
		$cont = 0;
		$num = count($where);
		$condicion = 'WHERE ';
		foreach($where as $campo => $valor){
			$condicion = $condicion.$campo.$valor.' ';
				
				if ($cont < ($num -1)){
					$condicion = $condicion.'AND ';
				}
					
				$cont = $cont +1;
			}	
	}
	
	else{
	$condicion = "";
	}
	
	$query = "SELECT ".$camp." FROM ".$tabla." ".$condicion."";
	
	
	$data1 = mysql_query($query);
	$data2 = mysql_query($query);

$campos = mysql_fetch_assoc($data1);


$tabla = "<table class='table'> <tr>";

	if($campos) {
		foreach($campos as $campo => $valor) {
			$tabla = $tabla."<th>".$campo."</th>";
		}
	}
	
	$tabla = $tabla."<th>&nbsp;</th><th>&nbsp;</th></tr>";

	while($valores = mysql_fetch_assoc($data2)) {
   			
		$tabla = $tabla."<tr>";
   				
   		foreach($valores as $campo => $valor) {
			if ($campo == $cod){
				$indet = $valor;}
   				$tabla = $tabla."<td>".$valor."</td>";    				
   			}
   		
   		$tabla = $tabla."<td align='right'><a class='boton3' href='".$ruta."?".$opp."=".$indet;
   		   		
   		if (is_array($gett1)){
   			foreach($gett1 as $var1 => $val1) {
   				$tabla = $tabla."&".$var1."=".$val1;}
   			}
   		
   		$tabla = $tabla."'>".$opp."</a></td>";	
   		$tabla = $tabla."<td align='right'><a class='boton3' href='".$ruta."?".$opi."=".$indet;
   		
		if (is_array($gett2)){
   			foreach($gett2 as $var2 => $val2) {
   				$tabla = $tabla."&".$var2."=".$val2;}
   		} 
   		$tabla = $tabla."'>".$opi."</a></td>";
   		$tabla = $tabla."</tr>";	
	}
	$tabla = $tabla."</table>";
	echo $tabla;
}

function Listado_per($campos,$tabla,$where,$opp1,$opp2,$get1,$get2,$ruta,$rut,$get1_var,$get2_var,$css){
	
	$num = count($campos);
	$cont = 0;
	
	if (is_array($campos)){
		foreach($campos as $campo1 => $valor1){
			$camp = $camp.$campo1;
				
				if ($cont < ($num -1)){
					$camp = $camp.',';
				}
					
				$cont = $cont +1;
		}
	}
	
	if (is_array($where)){
		
		$cont = 0;
		$num = count($where);
		$condicion = 'WHERE ';
		foreach($where as $campo2 => $valor2){
			$condicion = $condicion.$campo2.$valor2.' ';
				
				if ($cont < ($num -1)){
					$condicion = $condicion.'AND ';
				}
					
				$cont = $cont +1;
			}	
	}
	
	else{
	$condicion = "";
	}
	
	$query = "SELECT ".$camp." FROM ".$tabla." ".$condicion."";

	//echo '<br /><strong>'.$query.'</strong><br />';
        
	$data1 = mysql_query($query);
	$campos = mysql_fetch_assoc($data1);

$tabla = "<table class='".$css."'><tr>";

	if($campos) {
		foreach($campos as $campo => $valor) {
				$tabla = $tabla."<th>".$campo."</th>";
		}
	}
	
	$tabla = $tabla."<th>&nbsp;</th><th>&nbsp;</th></tr>";
	
	$contador_m = 1;
	
	$data2 = mysql_query($query);
	
	while($valores = mysql_fetch_assoc($data2)) {
   			
		$tabla = $tabla."<tr>";
   				
   		foreach($valores as $campo2 => $valor2){

   			foreach($rut as $cmm => $vall){
				
   				if($cmm != $campo2){
   					$tabla = $tabla."<td>".$valor2."</td>";		
				}
				
				else{
					$tabla = $tabla."<td>".$this->validar_rut($valor2).$this->nro_doc."</td>";
   					}					
				}
  
   			foreach($get1 as $var1 => $val1){
   				if ($var1 == $campo2){  					
	   				$mat1[$var1] = $valor2;
	   				}
	   		}
	   		
   		   	foreach($get2 as $var2 => $val2){
   				if ($var2 == $campo2){  					
	   				$mat2[$var2] = $valor2;
	   				}
	   		}
	
	   	}
	   	$tabla = $tabla."<td align='right'><a class='boton3' href='".$ruta."?";
	   	foreach($mat1 as $camp3 =>$dato3){
   			$tabla = $tabla."&".$camp3."=".$dato3;	  	   		
		}
		unset($mat1);
		
		if ( is_array($get1_var)){
			foreach($get1_var as $vap => $cap){
				$tabla = $tabla."&".$vap."=".$cap;
			}
		}
		
	   	$tabla = $tabla."'>".$opp1."</a></td>";
		
		$tabla = $tabla."<td align='right'><a class='boton3' href='".$ruta."?";
	   	foreach($mat2 as $camp4 =>$dato4){
   			$tabla = $tabla."&".$camp4."=".$dato4;	  	   		
		}
		
		if ( is_array($get2_var)){
			foreach($get2_var as $vap2 => $cap2){
				$tabla = $tabla."&".$vap2."=".$cap2;
			}
		}
		
		unset($mat2);
			   		
		$tabla = $tabla."'>".$opp2."</a></td>"; 	
	   	$tabla = $tabla."</tr>"; 
	   	$contador_m = $contador_m + 1;
	}
	
$tabla = $tabla."</table>";
echo $tabla;
}

function Listado_simple2($campos,$tabla,$where,$opp1,$get1,$ruta,$rut,$get1_var,$css){
	
	$num = count($campos);
	$cont = 0;
	
	if (is_array($campos)){
		foreach($campos as $campo1 => $valor1){
			$camp = $camp.$campo1;
				
				if ($cont < ($num -1)){
					$camp = $camp.',';
				}
					
				$cont = $cont +1;
		}
	}
	
	if (is_array($where)){
		
		$cont = 0;
		$num = count($where);
		$condicion = 'WHERE ';
		foreach($where as $campo2 => $valor2){
			$condicion = $condicion.$campo2.$valor2.' ';
				
				if ($cont < ($num -1)){
					$condicion = $condicion.'AND ';
				}
					
				$cont = $cont +1;
			}	
	}
	
	else{
	$condicion = "";
	}
	
	$query = "SELECT ".$camp." FROM ".$tabla." ".$condicion."";
	
        //echo $query.'<br />';

	$data1 = mysql_query($query);
	$campos = mysql_fetch_assoc($data1);

$tabla = "<table class='".$css."'><tr>";

	if($campos) {
		foreach($campos as $campo => $valor) {
				$tabla = $tabla."<th>".$campo."</th>";
		}
	}
	
	$tabla = $tabla."<th>&nbsp;</th><th>&nbsp;</th></tr>";
	
	$contador_m = 1;
	
	$data2 = mysql_query($query);
	
	while($valores = mysql_fetch_assoc($data2)) {
   			
		$tabla = $tabla."<tr>";
   				
   		foreach($valores as $campo2 => $valor2){

   			foreach($rut as $cmm => $vall){
				
   				if($cmm != $campo2){
   					$tabla = $tabla."<td>".$valor2."</td>";		
				}
				
				else{
					$tabla = $tabla."<td>".$this->validar_rut($valor2).$this->nro_doc."</td>";
   					}					
				}
  
   			foreach($get1 as $var1 => $val1){
   				if ($var1 == $campo2){  					
	   				$mat1[$var1] = $valor2;
	   				}
	   		}
	
	   	}
	   	$tabla = $tabla."<td align='right'><a class='boton3' href='".$ruta."?";
	   	foreach($mat1 as $camp3 =>$dato3){
   			$tabla = $tabla."&".$camp3."=".$dato3;	  	   		
		}
		unset($mat1);
		
		if ( is_array($get1_var)){
			foreach($get1_var as $vap => $cap){
				$tabla = $tabla."&".$vap."=".$cap;
			}
		}
		
	   	$tabla = $tabla."'>".$opp1."</a></td>";
		
		$tabla = $tabla."<td align='right'><a class='boton3' href='".$ruta."?";
	   	foreach($mat2 as $camp4 =>$dato4){
   			$tabla = $tabla."&".$camp4."=".$dato4;	  	   		
		}
		
		unset($mat2);
			   		 	
	   	$tabla = $tabla."</tr>"; 
	   	$contador_m = $contador_m + 1;
	}
	
$tabla = $tabla."</table>";
echo $tabla;
}

function Imprimir($campos,$tabla,$where,$n_col,$rut){
	
	$num = count($campos);
	$cont = 0;
	
	if (is_array($campos)){
		foreach($campos as $campo => $valor){
			$camp = $camp.$campo;
				
				if ($cont < ($num -1)){
					$camp = $camp.',';
				}
				$cont = $cont +1;
		}
	}
	
	if (is_array($where)){
		
		$cont = 0;
		$num = count($where);
		$condicion = 'WHERE ';

		foreach($where as $campo => $valor){
			$condicion = $condicion.$campo.$valor.' ';
				
				if ($cont < ($num -1)){
					$condicion = $condicion.'AND ';
				}
					
				$cont = $cont +1;
			}	
	}
	
	else{
	$condicion = "";
	}
	
	$query = "SELECT ".$camp." FROM ".$tabla." ".$condicion."";

        //echo '<br />'.$query.'<br />';

	$data1 = mysql_query($query);
	$tabla = '<table class="table"><tr>';
	$contador = 1;
	
	while($valores_imp = mysql_fetch_assoc($data1)) {	
	
		foreach($valores_imp as $campo_imp => $valor_imp){
			
			foreach($rut as $cmm => $vall){
				
   				if($cmm != $campo_imp){
   					$tabla = $tabla.'<td><strong>'.$campo_imp.'</strong></td><td>'.strtoupper($valor_imp).'</td>';
				}
				
				else{
					$tabla = $tabla.'<td><strong>'.$campo_imp.'</strong></td><td>'.$this->validar_rut($valor_imp).$this->nro_doc.'</td>';
   					}					
				}
			
			if ( ($contador % $n_col) < 1){
				$tabla =$tabla.'</tr>';
			}
			$contador = $contador + 1;
		}
	}
	
$tabla = $tabla.'</tr></table>';
echo $tabla;
} 

function Formulario($valores,$n_col,$rut,$calendario,$blok){
	
	$num = count($campos);
	$cont = 1;
	
	if (is_array($valores)){
		
		echo '<table style="width:auto">';
		echo '<tr>';
		foreach($valores as $name => $value){
		
		$app = 0;	
			
			if (is_array($rut)){
				foreach($rut as $rut_col => $valor){
					if ($rut_col == $name){
						echo '<td><strong>'.$name.'</strong></td>';
						echo'<td><input type="text" name="ff_'.$name.'" value="'.$value.'" class="'.$valor.'" /></td>';
						$app = 1;
					}
				}
			}
			
			if (is_array($calendario)){
				foreach($calendario as $calendario_col => $calendario_valor){
					if ($calendario_col == $name){
						echo '<td><strong>'.$name.'</strong></td>';
						echo'<td><input type="text" name="ff_'.$name.'" value="'.$value.'" class="'.$calendario_valor.'" /></td>';
						$app = 1;
					}
				}
			}
			
			if (is_array($blok)){
			
				foreach($blok as $blok_col => $blok_valor){
					if ($blok_col == $name){
						echo '<td><strong>'.$name.'</strong></td>';
						echo'<td><input type="text" name="ff_'.$name.'" value="'.$value.'" readonly="readonly"  /></td>';
						$app = 1;
					}
				}
			}
			
			if ($app == 0){
				echo '<td><strong>'.$name.'</strong></td>';
				echo '<td><input type="text" name="ff_'.$name.'" value="'.$value.'"  /></td>';
			}
			
			if ($cont % $n_col == 0){
				echo '</tr>';
			}
			
			$cont = $cont + 1;
		
		}
	echo '</tr></table>';
	}
	
	
} 

}
?>