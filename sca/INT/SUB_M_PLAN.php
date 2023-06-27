

<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');







if( isset($_POST['secuencia']) ){



	$datos = new Datos;
	
	/* OPTIMIZA CON USO SE ARREGLOS */
	
	//comprobar secuencia
	$secuencia_ant_s ="SELECT secuencia,valor FROM valor_plan WHERE cod_plan ='".$_POST['cod_plan']."' AND tipo_plan ='".$_POST['tipo_plan']."' AND secuencia = (".$_POST['secuencia']." - 1)";
	$secuencia_ant_q = mysql_query($secuencia_ant_s);
	$secuencia_ant = mysql_fetch_array($secuencia_ant_q);
	
	//comprobar si existen secuencias
	$contador = new Datos;
	$campos = array("cod_plan"=>$_POST['cod_plan'],"tipo_plan"=>$_POST['tipo_plan']);
	$num = $contador->ComDataUni($campos,'valor_plan');
	
	//si exsiten secuencias
	if ($num > 0 && ($_POST['valor'] >= ($secuencia_ant['valor']))){
		$datos->INSERT_PoST('valor_plan','','',$_POST['cod_plan']);
			if (mysql_query($datos->query)){
				echo "";
			}
			else{
				echo ERROR;
	 		}	
	}
		
	//comprobar el valor si no existe secuenia se ingresa	
	if (!$secuencia_ant['valor'] && $num < 1){
		$datos->INSERT_PoST('valor_plan','','',$_POST['cod_plan']);
			if (mysql_query($datos->query)){
				echo "";
			}
			else{
				echo ERROR;
			}
		}

	$campos = array("secuencia AS SECUENCIA"=>"","valor AS VALOR"=>"","cod_plan AS COD"=>"","tipo_plan AS CAT"=>"");	
	$eliminar = array("COD"=>"","CAT"=>"");
	$ver = array("CED"=>"","CAT"=>"");	
	$rut = array("NULL"=>"");
	$var_ver = array("VER"=>'1');
	$var_eli = array("ELIMINAR"=>'1');	
	$condicion = array("cod_plan = '"=>$_POST['cod_plan']."'","tipo_plan = '"=>$_POST['tipo_plan']."'");
	$datos->Listado_per($campos,'valor_plan',$condicion,'MODIFICAR','ELIMINAR',$ver,$eliminar,'INT/SUB_M_PLAN.php',$rut,$var_ver,$var_eli,'table2');
}
	

?>