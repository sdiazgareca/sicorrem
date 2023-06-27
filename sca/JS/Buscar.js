function DetalleAmbulancia(num){
document.getElementById('DetalleAmb').style.visibility = 'visible';
$ajaxload('DetalleAmb','Amb/DetalleMovil.php?num='+num,'<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);}

function MuestraDatosPor(){
num = document.getElementById("muestramovil").value;
$ajaxload('der','PHP/main.php?actualizar=2&num='+num,'<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);}

function MuestraVentana(pid,rut,correlativo){
document.getElementById(pid).style.visibility = 'visible';	
$ajaxload(pid,'Form/FormAtencion.php?rut='+rut+'&correlativo='+correlativo,'<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);}

function Muestra(id,correlativo){
document.getElementById(id).style.visibility = 'visible';
$ajaxload(id,'Form/form/TABLA_FORMULARIO.php?correlativo='+correlativo,'<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>',false,false);	
}

function abrir(pid){
document.getElementById(pid).style.visibility = 'visible';}

function abrirPopup(pid,cod){
document.getElementById(pid).style.visibility = 'visible';
$ajaxload(pid, 'Form/MuestraPopus.php?cod='+cod,'<div class="mensaje"><p><img src="IMG/bigrotation2.gif" /></p><p>Cargando</p></div>',false,false);}

function cerrarPopup(pid,cod){
document.getElementById(pid).style.visibility = 'hidden';}

function buscar(){
rut = document.getElementById("rut").value;

if (!rut){
	alert("Debe ingresar el RUT");}

else{
$ajaxload('bus2', 'PHP/main.php?rut='+rut+'&busq2=1','<div class="mensaje"><p><img src="IMG/bigrotation2.gif" /></p><p>Cargando</p></div>',false,false);
document.getElementById("nombre").value ="";
document.getElementById("apaterno").value ="";
document.getElementById("nro_contrato").value ="";}
}

function buscar3(){
ncont = document.getElementById("nro_contrato").value;

if (!ncont){
	alert("Debe ingresar el numero de contrato");}

else{
$ajaxload('bus2', 'PHP/main.php?ncont='+ncont,'<div class="mensaje"><p><img src="IMG/bigrotation2.gif" /></p><p>Cargando</p></div>',false,false);
document.getElementById("nombre").value ="";
document.getElementById("apaterno").value ="";}
document.getElementById("rut").value ="";}

function buscar2(){
document.getElementById("rut").value = "";
var nombre = document.getElementById("nombre").value;
var apaterno = document.getElementById("apaterno").value;
document.getElementById("nro_contrato").value ="";

if((!nombre)&&(!apaterno)){
	alert("Debe llenar por lo menos uncampo");
}
else{
$ajaxload('bus2', 'PHP/main.php?nombre='+nombre+'&apaterno='+apaterno,'<div class="mensaje"><p><img src="IMG/bigrotation2.gif" /></p><p>Cargando</p></div>',false,false);}
}

function limpiar(){
document.getElementById("rut").value ="";
document.getElementById("nombre").value ="";
document.getElementById("apaterno").value ="";
document.getElementById("nro_contrato").value ="";}

function GuardarFicha(){
var telefono = document.getElementById("telefono").value;
var direccion = document.getElementById("direccion").value;
var entre = document.getElementById("entre").value;
var sintomas = document.getElementById("sint").innerHTML;
var movil = document.getElementById("movil").value;
var color = document.getElementById("color").value;
var sector = document.getElementById("sector").value;
var observacion =document.getElementById("observacion").value;
var rut = document.getElementById("a").innerHTML;
//Celular
var celular = document.getElementById("celular").value;
var cel = document.getElementById("cel").value;
var numcelular = cel+'-'+celular;
var ncontrato = document.getElementById("ncontrato").innerHTML;
var rutoperador = document.getElementById("rutoperador").innerHTML;

if (document.getElementById("AgregarCargaNoregistrada").value > 0){
var paciente = document.getElementById("paciente_carga").value;
var edad = document.getElementById("edad_carga").value;
var cod_plann = 'CA';
var tipo_plann = 'CA'; 
var isapren = 'CA';
}
else{
var paciente = document.getElementById("paciente").innerHTML;
var edad = document.getElementById("edad").innerHTML;
var cod_plann = document.getElementById("cod_plann").innerHTML;
var tipo_plann = document.getElementById("tipo_plann").innerHTML;
var isapren = document.getElementById("isapren").innerHTML;
}

if(document.getElementById("autorizadopor")){
var autorizacion = document.getElementById("autorizadopor").value;

}
else {
var autorizacion = 5;
}

if ((!telefono) || (!direccion) || (!sintomas) || (movil< 1) || (color < 1) || (sector < 1) || (autorizacion < 1) ){
	alert('Debe llenar todos los campos');
}
else{
if(confirm("Esta seguro de guardar la ficha?")) {	
$ajaxload('bus', 'PHP/main.php?telefono='+telefono+'&direccion='+direccion+'&cod_plann='+cod_plann+'&tipo_plann='+tipo_plann+'&isapren='+isapren+'&entre='+entre+'&movil='+movil+'&color='+color+'&sector='+sector+'&observacion='+observacion+'&rut='+rut+'&edad='+edad+'&sintomas='+sintomas+'&ncontrato='+ncontrato+'&numcelular='+numcelular+'&paciente='+paciente+'&color='+color+'&sector='+sector+'&operador='+rutoperador+'&autorizacion='+autorizacion,'<div class="mensaje"><p><img src="IMG/bigrotation2.gif" /></p><p>Cargando</p></div>',false,false);
if ($ajaxload){
	$ajaxload('der', 'PHP/main.php?actualizar=1', '<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>', false, false);
	}
}
}
}

function GuardarFicha1(){
var telefono = document.getElementById("telefono").value;
var direccion = document.getElementById("direccion").value;
var entre = document.getElementById("entre").value;
var sintomas = document.getElementById("sint").innerHTML;
var movil = document.getElementById("movil").value;
var color = document.getElementById("color").value;
var sector = document.getElementById("sector").value;
var observacion =document.getElementById("observacion").value;
var rut = document.getElementById("a").innerHTML;
//Celular
var celular = document.getElementById("celular").value;
var cel = document.getElementById("cel").value;
var numcelular = cel+'-'+celular;
var ncontrato = document.getElementById("ncontrato").innerHTML;
var rutoperador = document.getElementById("rutoperador").innerHTML;
var paciente = document.getElementById("paciente_area").value;
var edad = document.getElementById("edad_area").value;
var tipo_plann = document.getElementById("tipo_plann").innerHTML;
var cod_plann = document.getElementById("cod_plann").innerHTML;
//
if(document.getElementById("autorizadopor")){
var autorizacion = document.getElementById("autorizadopor").value;
}
else {
var autorizacion = 5;
}

if ((!telefono) || (!direccion) || (!sintomas) || (movil< 1) || (color < 1) || (sector < 1) || (autorizacion < 1) ){
	alert('Debe llenar todos los campos');
}
else{
if(confirm("Esta seguro de guardar la ficha?")) {	
$ajaxload('bus', 'PHP/main.php?cod_plann='+cod_plann+'&tipo_plann='+tipo_plann+'&telefono='+telefono+'&direccion='+direccion+'&entre='+entre+'&movil='+movil+'&color='+color+'&sector='+sector+'&observacion='+observacion+'&rut='+rut+'&edad='+edad+'&sintomas='+sintomas+'&ncontrato='+ncontrato+'&numcelular='+numcelular+'&paciente='+paciente+'&color='+color+'&sector='+sector+'&operador='+rutoperador+'&autorizacion='+autorizacion,'<div class="mensaje"><p><img src="IMG/bigrotation2.gif" /></p><p>Cargando</p></div>',false,false);
	if ($ajaxload) {
		$ajaxload('der', 'PHP/main.php?actualizar=1', '<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>', false, false);
	}
}
}
}

function GuardarFicha2(){
var telefono = document.getElementById("telefono").value;
var direccion = document.getElementById("direccion").value;
var entre = document.getElementById("entre").value;
var sintomas = document.getElementById("sint").innerHTML;
var movil = document.getElementById("movil").value;
var color = document.getElementById("color").value;
var sector = document.getElementById("sector").value;
var observacion =document.getElementById("observacion").value;
//var rut = document.getElementById("a").innerHTML;
//Celular
var celular = document.getElementById("celular").value;
var cel = document.getElementById("cel").value;
var numcelular = cel+'-'+celular;
//var ncontrato = document.getElementById("ncontrato").innerHTML;
var rutoperador = document.getElementById("rutoperador").innerHTML;
var paciente = document.getElementById("paciente_area").value;
var edad = document.getElementById("edad_area").value;
//
var autorizacion = 5;
var cod_plann = 'PA';
var tipo_plann = 'PA'; 
var isapren = 'PA';

if ((!telefono) || (!direccion) || (!sintomas) || (movil< 1) || (color < 1) || (sector < 1) || (!paciente) || (!edad) ){
	alert('Debe llenar todos los campos');
}
else{
if(confirm("Esta seguro de guardar la ficha?")) {	
$ajaxload('bus', 'PHP/main.php?telefono='+telefono+'&direccion='+direccion+'&cod_plann='+cod_plann+'&tipo_plann='+tipo_plann+'&isapren='+isapren+'&entre='+entre+'&movil='+movil+'&color='+color+'&sector='+sector+'&observacion='+observacion+'&edad='+edad+'&sintomas='+sintomas+'&numcelular='+numcelular+'&paciente='+paciente+'&color='+color+'&sector='+sector+'&operador='+rutoperador,'<div class="mensaje"><p><img src="IMG/bigrotation2.gif" /></p><p>Cargando</p></div>',false,false);

	if ($ajaxload) {
		$ajaxload('der', 'PHP/main.php?actualizar=1', '<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>', false, false);
	}
}
}
}

function GuardarMovil(){

var marca = document.getElementById("marca").value;
var modelo = document.getElementById("modelo").value;
var chasis = document.getElementById("chasis").value;
var patente1 = document.getElementById("patente1").value;
var patente2 = document.getElementById("patente2").value;
var patente3 = document.getElementById("patente3").value;
var anio = document.getElementById("anio").value;
var num = document.getElementById("num").value;
var p_seguro = document.getElementById("p_seguro").value;
var patente = patente1+"-"+patente2+"-"+patente3;

if ((!marca) || (!modelo) || (!chasis) || (!patente1) || (!patente2) || (!patente3) || (!anio) || (!num) || (!p_seguro)){
alert("Debe llenar todos los campos");
}
else {
$ajaxload('mensajemovil','PHP/main.php?marca='+marca+'&modelo='+modelo+'&patente='+patente+'&anio='+anio+'&chasis='+chasis+'&p_seguro='+p_seguro+'&num='+num,'<div class="mensaje"><p><img src="IMG/bigrotation2.gif" /></p><p>Cargando</p></div>',false,false);
}
}

function EditarMovil(){

var marca1 = document.getElementById("marca").value;
var modelo1 = document.getElementById("modelo").value;
var chasis1 = document.getElementById("chasis").value;
var patente11 = document.getElementById("patente1").value;
var patente21 = document.getElementById("patente2").value;
var patente31 = document.getElementById("patente3").value;
var anio1 = document.getElementById("anio").value;
var patente1 = patente11+"-"+patente21+"-"+patente31;
var nmovil1 = document.getElementById("numambulancia").innerHTML;

if ((!marca1) || (!modelo1) || (!chasis1) || (!patente11) || (!patente21) || (!patente31) || (!anio1)){
alert("Debe llenar todos los campos");
}

else {
$ajaxload('mensajemovil','PHP/main.php?marca='+marca1+'&modelo='+modelo1+'&patente='+patente1+'&anio='+anio1+'&chasis='+chasis1+'&nmovil='+nmovil1+'&editarmovil=1','<div class="mensaje"><p><img src="IMG/bigrotation2.gif" /></p><p>Cargando</p></div>',false,false);
}
}

function GuardarPersonal(){
	
var nombre1 = document.getElementById("nombre1").value;
var nombre2 = document.getElementById("nombre2").value;
var apellidos = document.getElementById("apellidos").value;
var rut2 = document.getElementById("rut2").value;
var cargo = document.getElementById("cargo").value;
var rut_1 = document.getElementById("rut_1").value;
var rut_d = document.getElementById("rut_d").value;

if ((!nombre1) || (!nombre2) || (!apellidos)|| (!rut2) || (!cargo) || (!rut_1) || (!rut_d) ){
	alert("Debe llenar todos los campos");
}
else{
$ajaxload('mensajemovil','PHP/main.php?nombre1='+nombre1+'&nombre2='+nombre2+'&apellidos='+apellidos+
'&rut2='+rut2+'&cargo='+cargo+'&rut_1='+rut_1+'&rut_d='+rut_d,false,false,false);
}
}

function EditarPersonal(){
	
var nombre1 = document.getElementById("nombre1").value;
var nombre2 = document.getElementById("nombre2").value;
var apellidos = document.getElementById("apellidos").value;
var rut2 = document.getElementById("rut2").value;
var cargo = document.getElementById("cargo").value;
var rut_1 = document.getElementById("rut_1").value;
var rut_d = document.getElementById("rut_d").value;

if ((!nombre1) || (!nombre2) || (!apellidos)|| (!rut2) || (!cargo)  || (!rut_1) || (!rut_d)){
	alert("Debe llenar todos los campos");
}
else{
$ajaxload('mensajemovil','PHP/main.php?nombre1='+nombre1+'&nombre2='+nombre2+'&apellidos='+apellidos+'&rut2='+rut2+'&cargo='+cargo+'&editarpersonal=1&rut_1='+rut_1+'&rut_d='+rut_d,false,false,false);
}
}

function GuardarMoviAsig(){

var paramedico = document.getElementById("paramedico").value;
var medico = document.getElementById("medico").value;
var conductor = document.getElementById("conductor").value;
var movil = document.getElementById("movil").value;

if ((!paramedico) || (!medico) || (!conductor)  || (!movil) ){
alert("No existen datos");
}
else{
if(confirm("Esta seguro de crear el movil?")) {
$ajaxload('bus','PHP/main.php?paramedico='+paramedico+'&medico='+medico+'&conductor='+conductor+'&asignarmovil=1&movil='+movil,false,false,false);
}
}
}

function EnviarClave(){
var rutoperador = document.getElementById("rutoperador").value;
var claveoperador= document.getElementById("claveoperador").value;

if ((!rutoperador) || (!claveoperador)){
alert("Debe llenar los campos");
}
else{
$ajaxload('bus', 'PHP/main.php?rutoperador='+rutoperador+'&claveoperador='+claveoperador,false,false,false);
}
}

function AgregarCarga(){
var AgregarCarga = document.getElementById("AgregarCargaNoregistrada").value;

if(AgregarCarga == 1){
$ajaxload('AgregarCarga', 'Form/AgregarCarga.php',false,false,false);
}
if(AgregarCarga == 0){
$ajaxload('AgregarCarga', 'Form/MuestraNada.php',false,false,false);
}
}

function sinto(cod,sinto){
var sint = document.getElementById("sint").innerHTML;

if(confirm("Esta seguro de agregar el sintoma\n "+sinto+"?")) {

if (sint ==""){
document.getElementById("sint").innerHTML = '-'+cod+'-'+sinto+'-';

}
else{
document.getElementById("sint").innerHTML = sint+'-'+cod+'-'+sinto+'-';
}
}
var p = document.div['sint'].innerHTML;
alert (p);
}

function cambiar_amb(num,corre,movil){
$ajaxload('bus', 'Form/Cambiar_movil.php?num='+num+'&corre='+corre+'&movil='+movil,false,false,false);
if ($ajaxload) {
	$ajaxload('der', 'PHP/main.php?actualizar=1', '<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>', true);
}
}

function cambiar_amb2(num,corre,movil){
$ajaxload('bus', 'Form/Cambiar_movil2.php?num='+num+'&corre='+corre+'&movil='+movil,false,false,false);
if ($ajaxload) {
	$ajaxload('der', 'PHP/main.php?actualizar=1', '<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>', true);
	}
}

function cambiar_amb3(num,corre,movil){
$ajaxload('bus', 'Form/Cambiar_movil2.php?espera='+num+'&corre='+corre+'&movil='+movil,false,false,false);
if ($ajaxload) {
	$ajaxload('der', 'PHP/main.php?actualizar=1', '<div class=mensaje><p><img src=IMG/bigrotation2.gif /></p><p>Cargando</p></div>', true);
	}
}

function cambiar_m(id){
	alert(id);
}

function guradar_traslado(url,plan,tipo_plan){

var tipo_plan1 = tipo_plan;
var convenio = plan;

if (document.getElementById("paciente_convenio")) {
	if(document.getElementById("convenio")){
	var convenio = document.getElementById("convenio").value;
	}
}

if(document.getElementById("a")){
	var rut = document.getElementById("a").innerHTML;
}

if(document.getElementById("num_solici")){
	var num_solici = document.getElementById("num_solici").innerHTML;
}

if (document.getElementById("paciente_convenio")) {
	var paciente = document.getElementById("paciente_convenio").value;
}
else{
	var paciente = document.getElementById("paciente").innerHTML;
}
/*
if (document.getElementById("plann")){
	var convenio = document.getElementById("plann").innerHTML;	
}

if (!document.getElementById("plann")){
	var convenio = "Particular";
}
*/

var telefono = document.getElementById("fono_paciente").value;
var celular = document.getElementById("celular_paciente").value;
var dia = document.getElementById("dia").value;
var mes = document.getElementById("mes").value;
var anio = document.getElementById("anio").value;
var hora = document.getElementById("hora").value;
var minutos = document.getElementById("minutos").value;
var direco = document.getElementById("direco").value;

var fecha_traslado = anio+'-'+mes+'-'+dia+'  '+hora+':'+minutos;

	if(document.getElementById("direccion_destino_H")){
		var direccion_destino = document.getElementById("direccion_destino_H").value;
		var ciudad = 'Antofagasta';
		var costo = 26000;}
		
	if(document.getElementById("direccion_destino_d")){
		var direccion_destino = document.getElementById("direccion_destino_d").value;
		var ciudad = 'Antofagasta';
		var costo = 26000;}
	
	if( (document.getElementById("direccion_destino_f")) && (document.getElementById("ciudad_d"))){
		var direccion_destino = document.getElementById("direccion_destino_f").value;
		var ciudad =  document.getElementById("ciudad_d").value;
		var costo = '0';
		}

	if( (document.getElementById("ciudad_e")) && (document.getElementById("valor_e")) && (document.getElementById("direccion_destino_e"))){
		var direccion_destino = document.getElementById("direccion_destino_e").value;
		var ciudad =  document.getElementById("ciudad_e").value;
		var costo =  document.getElementById("valor_e").value;}

if((!convenio)||(!paciente)||(!telefono)||(!fecha_traslado)||(!direccion_destino)||(!ciudad)||(!costo) || (!direco)){
	alert('Debe llenar todos los campos');
}
else{
if(confirm("Esta seguro de guardar los cambios?")) {
$ajaxload('traslado_s','Traslados/'+url+'?convenio='+convenio+'&tipo_plan='+tipo_plan1+'&paciente='+paciente+'&telefono='+telefono+'&celular='+celular+'&fecha_traslado='+fecha_traslado+'&direccion_destino='+direccion_destino+'&ciudad='+ciudad+'&costo='+costo+'&direco='+direco,false,false,false);
	if($ajaxload){
		$ajaxload('cabezera','Traslados/Actualizar_Aviso.php',false,false,false);
	}
}}
}

function guradar_traslado22(url,plan,tipo_plan,isapre){



var tipo_plan1 = tipo_plan;
var convenio = plan;

if (isapre){
	var isapre1=isapre;
}
if (!isapre){
	isapre1='(NULL)';
}

if (document.getElementById("paciente_convenio")) {
	if(document.getElementById("convenio")){
	var convenio = document.getElementById("convenio").value;
	}
}

if(document.getElementById("a")){
	var rut = document.getElementById("a").innerHTML;
}

if(document.getElementById("num_solici")){
	var num_solici = document.getElementById("num_solici").innerHTML;
}

if (document.getElementById("paciente_convenio")) {
	var paciente = document.getElementById("paciente_convenio").value;
}
else{
	var paciente = document.getElementById("paciente").innerHTML;
}
/*
if (document.getElementById("plann")){
	var convenio = document.getElementById("plann").innerHTML;	
}

if (!document.getElementById("plann")){
	var convenio = "Particular";
}
*/

var telefono = document.getElementById("fono_paciente").value;
var celular = document.getElementById("celular_paciente").value;
var dia = document.getElementById("dia").value;
var mes = document.getElementById("mes").value;
var anio = document.getElementById("anio").value;
var hora = document.getElementById("hora").value;
var minutos = document.getElementById("minutos").value;
var direco = document.getElementById("direco").value;

var fecha_traslado = anio+'-'+mes+'-'+dia+'  '+hora+':'+minutos;

	if(document.getElementById("direccion_destino_H")){
		var direccion_destino = document.getElementById("direccion_destino_H").value;
		var ciudad = 'Antofagasta';
		var costo = 26000;}
		
	if(document.getElementById("direccion_destino_d")){
		var direccion_destino = document.getElementById("direccion_destino_d").value;
		var ciudad = 'Antofagasta';
		var costo = 26000;}
	
	if( (document.getElementById("direccion_destino_f")) && (document.getElementById("ciudad_d"))){
		var direccion_destino = document.getElementById("direccion_destino_f").value;
		var ciudad =  document.getElementById("ciudad_d").value;
		var costo = '0';
		}

	if( (document.getElementById("ciudad_e")) && (document.getElementById("valor_e")) && (document.getElementById("direccion_destino_e"))){
		var direccion_destino = document.getElementById("direccion_destino_e").value;
		var ciudad =  document.getElementById("ciudad_e").value;
		var costo =  document.getElementById("valor_e").value;}

if((!convenio)||(!paciente)||(!telefono)||(!fecha_traslado)||(!direccion_destino)||(!ciudad)||(!costo) || (!direco)){
	alert('Debe llenar todos los campos');
}
else{
if(confirm("Esta seguro de guardar los cambios?")) {
$ajaxload('traslado_s','Traslados/'+url+'?convenio='+convenio+'&tipo_plan='+tipo_plan1+'&paciente='+paciente+'&telefono='+telefono+'&celular='+celular+'&fecha_traslado='+fecha_traslado+'&direccion_destino='+direccion_destino+'&ciudad='+ciudad+'&costo='+costo+'&direco='+direco+'&num_solici='+num_solici+'&rut='+rut+'&isapre='+isapre1,false,false,false);
	if($ajaxload){
		$ajaxload('cabezera','Traslados/Actualizar_Aviso.php',false,false,false);
	}
}}
}