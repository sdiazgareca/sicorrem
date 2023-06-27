<?php
/******************************************************************/
include("../conf.php");
include("../bd.php");
include_once("class.php");
/******************************************************************/
$telefono = $_GET['telefono'];
$direccion =  $_GET['direccion'];
$nombre = $_GET['nombre'];
$apaterno = $_GET['apaterno'];
$rut = $_GET['rut'];
$actualizar = $_GET['actualizar'];
$marca = $_GET['marca'];
$modelo = $_GET['modelo'];
$chasis = $_GET['chasis'];
$patente = $_GET['patente'];
$anio = $_GET['anio'];
$seguridad = 1;
$nmovil = $_GET['nmovil'];
$rutpersonal = $_GET['rutpersonal'];
$ListaEdiatrMovil = $_GET['ListaEdiatrMovil'];
$nombre1 = $_GET['nombre1'];
$nombre2 = $_GET['nombre2'];
$apellidos= $_GET['apellidos'];
$rut2 = $_GET['rut2'];
$cargo = $_GET['cargo'];
$ListaEdiatrPersonal = $_GET['ListaEdiatrPersonal'];
$editarpersonal = $_GET['editarpersonal'];
$numero =$_GET['numero'];
$ambulancia =$_GET['ambulancia'];
$paramedico =$_GET['paramedico'];
$medico =$_GET['medico'];
$conductor =$_GET['conductor'];
$rutoperador =$_GET['rutoperador'];
$claveoperador=$_GET['claveoperador'];
$muestracargas = $_GET['muestracargas'];
/******************************************************************/
include('funciones.php');
$Hs_despacho=$_GET['Hs_despacho'];
$Hs_salida_base =$_GET['Hs_salida_base'];
$Hs_llega_domicilio=$_GET['Hs_llega_domicilio'];
$Hs_sale_domicilio = $_GET['Hs_sale_domicilio'];
$correlativo = $_GET['correlativo'];
$consulta_para_hora = $_GET['consulta_para_hora'];
$rut = $_GET['rut'];


if (($_GET['gravarhora'] == 1) && ($_GET['correlativo'])){
$fecha = date('Y-m-d H:i:s');
$query = "update fichas set  $consulta_para_hora='".$fecha."' where correlativo ='".$correlativo."' and nro_doc ='".$rut."'";
$resultados = mysql_query($query);
if($resultados){
echo date('d-m-Y H:i:s');
}
mysql_query($conexion);
exit;
}

if ($muestracargas =='1'){
$Buscar_Rut = new Afiliados;
$Buscar_Rut->MuestraCargas($conexion);
exit;
}

if ($actualizar =='1'){
$Buscar_Rut = new Afiliados;
$Buscar_Rut->MuestraDatos($conexion);
exit;
}

if (($actualizar =='2') && ($_GET['num'])){
$Buscar_Rut = new Afiliados;
$Buscar_Rut->MuestraDatos1($conexion);
exit;
}

if ((isset($_GET['movil'])) && (isset($paramedico)) && (isset($medico)) && (isset($conductor)) && (isset($_GET['asignarmovil']))){
$ambulancia2 = new Movil;
$ambulancia2->GuardarMovilAsig($conexion);
exit;
}

if ((isset($_GET['cambiarmovil'])) && (isset($_GET['num']))){
$ambulancia2 = new Movil;
$ambulancia2->CancelarMovilAsig($conexion);
exit;
}

if (($nombre1) && ($nombre2) && ($apellidos) && ($rut2) && ($cargo) && ($editarpersonal)){
$personal = new Personal;
$personal->GuardarEdicionPersonal($conexion);
exit;
}

if ($rutpersonal){
$personal = new Personal;
$personal->EditarPersonal($conexion,$rutpersonal);
exit;
}

if($ListaEdiatrPersonal){
$personal = new Personal;
$personal->ListaEdiatrPersonal($conexion);
}

if (($nombre1) && ($nombre2) && ($apellidos) && ($rut2) && ($cargo)){
$personal = new Personal;
$personal->CrearPersonal($conexion);
exit;
}

if ($ListaEdiatrMovil){
$ambulancia = new Movil;
$ambulancia->ListaEdiatrMovil($conexion);
exit;
} 

if (($nmovil) && (!$marca) && (!$modelo) && (!$chasis) && (!$patente) && (!$anio)){
$ambulancia = new Movil;
$ambulancia->EditarMovil($conexion,$nmovil);
exit;
}

if (($marca) && ($modelo) && ($chasis) && ($patente) && ($anio) && ($seguridad)&&(!$nmovil)&& (!$_GET['editarmovil'])){
$ambulancia = new Movil;
$ambulancia->GuardarMovil($conexion);
exit;
} 

if (($marca) && ($modelo) && ($chasis) && ($patente) && ($anio) &&($_GET['editarmovil'])){
$ambulancia = new Movil;
$ambulancia->GuardarEdicionMovil($conexion);
exit;
} 

if (($telefono) || ($direccion)){
$Buscar_Rut = new Afiliados;
$Buscar_Rut->GuardarFicha($conexion,$telefono,$direccion,$rut);
exit;
}

if($_GET['ncont']){
$Buscar_Rut = new Afiliados;
$Buscar_Rut->BuscarNrContrato($conexion,$mensaje1,$_GET['ncont']);
exit;
}


if($rut){
$Buscar_Rut = new Afiliados;
$Buscar_Rut->BuscarRut($conexion,$mensaje1,$rut);
exit;
}

if(($nombre) && (!$apaterno)){
$Buscar_Rut = new Afiliados;
$query ="nombre1 like '".$nombre."%' order by apellido";
$Buscar_Rut->BuscarNombre($conexion,$mensaje1,$query);
exit;
}

if((!$nombre) && ($apaterno)){
$Buscar_Rut = new Afiliados;
$query ="apellido like '".$apaterno."%' order by apellido";
$Buscar_Rut->BuscarNombre($conexion,$mensaje1,$query);
exit;
}

if(($nombre) && ($apaterno)){
$Buscar_Rut = new Afiliados;
$query ="nombre1 like '".$nombre."%' and apellido like '".$apaterno."%' order by apellido";
$Buscar_Rut->BuscarNombre($conexion,$mensaje1,$query);
exit;
}
?><!-- MMDW:success -->