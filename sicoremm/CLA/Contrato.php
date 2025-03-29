<?php

class Contrato {

    public $num_solici;
    public $estado;
    public $titular;
    public $f_pago;
    public $cod_plan;
    public $tipo_plan;
    public $doc_pago;
    public $ZO;
    public $SE;
    public $MA;
    public $secuencia;
    public $d_pago;
    public $cont2;
    public $f_ingreso;
    public $empresa;
    public $cod_venta;
    public $factu;
    public $f_baja;
    public $ajuste;

    //MUESTRA INFO RESUMEN DEL CONTRTO
    function MuestraResumenContrato($num_solici){

        $sql="SELECT titulares.apellido AS APELLIDOS,titulares.nombre1 AS NOMBRE,contratos.num_solici AS CONT,contratos.factu AS FAC,DATE_FORMAT(contratos.f_ingreso,'%d-%m-%Y') AS F_ING,DATE_FORMAT(contratos.f_baja,'%d-%m-%Y') AS F_BAJ,COUNT(copago.tipo_pago) AS COP,COUNT(cta.nro_doc) AS MEN,e_contrato.descripcion AS EST,planes.desc_plan AS PLAN,contratos.cod_plan AS C_PLAN,contratos.tipo_plan AS T_PLAN,(valor_plan.valor + contratos.ajuste) AS MENSUALIDAD,f_pago.descripcion AS FPAGO
            FROM contratos LEFT JOIN f_pago ON f_pago.codigo = contratos.f_pago LEFT JOIN e_contrato ON e_contrato.cod = contratos.estado LEFT JOIN copago ON contratos.num_solici = copago.numero_socio AND copago.tipo_pago =3 LEFT JOIN tipo_pago ON copago.tipo_pago = tipo_pago.cod LEFT JOIN planes ON planes.cod_plan = contratos.cod_plan AND planes.tipo_plan = contratos.tipo_plan LEFT JOIN valor_plan ON valor_plan.cod_plan =contratos.cod_plan AND valor_plan.tipo_plan = contratos.tipo_plan AND valor_plan.secuencia = contratos.secuencia LEFT JOIN titulares ON titulares.nro_doc = contratos.titular LEFT JOIN cta ON cta.num_solici = contratos.num_solici AND cta.nro_doc = contratos.titular AND (cta.cod_mov =1) AND afectacion < 1
            WHERE contratos.num_solici='".$num_solici."' GROUP BY contratos.num_solici";
        $query = mysql_query($sql);
        $contrato = mysql_fetch_assoc($query);

        echo '<br />';
        echo '<table class="table2">';

        echo '<tr>';
        foreach($contrato AS $CAMPO=>$VALOR){
            echo '<th>'.$CAMPO.'</th>';
        }

        echo '</tr>';

        echo '<tr>';

        foreach($contrato AS $CAMPO=>$VALOR){
         echo '<td>'.$VALOR.'</td>';
        }

        echo '</tr>';
        echo '</table>';
    }

    //MUESTRA VALOR MENSUAL DE LOS SERVICIOS
    function ValorMensual($num_solici, $edicion){

        echo '<br /><h1>VALOR MENSUAL DE LOS SERVICIOS CLA</h1>';

        $valores = new Datos;
	$campos_v = array('cod_plan AS COD_PLAN'=>'','tipo_plan AS TIPO_PLAN'=>'','desc_plan AS PLAN'=>'','valor AS VALOR_MENSUALIDAD'=>'','ajuste AS AJUSTE'=>'','copago AS VALOR_COPAGO'=>'','secuencia AS GRUPO_FAMILIAR'=>'','d_pago AS DIA_DE_PAGO'=>'');
	$rut_v = array('NULO'=>'');
	$where_v = array('num_solici'=>' = "'.$num_solici.'"');
        $valores->Imprimir($campos_v,"contr",$where_v,'3',$rut_v);

        if ($edicion == 1){
            echo '<br /><div align="right"><a class="boton" href="INT/SUB_M_TESO_2.php?V_SERVICIOS=1&CONTRATO='.$_GET['CONTRATO'].'">Editar</a></div><br />';
        }
        if ($edicion == 0){
            echo '<br/>';
        }
    }

    //MUESTRA FORMA DE PAGO MENSUAL
    function FormaPago($num_solici,$f_pago,$edicion){

        echo '<br /><h1>FORMA DE PAGO MENSUAL CLA</h1>';

	$fpago = new Datos;

	//PAC
	if ($f_pago == 100){

	$campos_f =array('descripcion AS FORMA_DE_PAGO'=>'','titular_cta AS TITULAR_CUENTA'=>'','rut_titular_cta AS RUT_TITULAR_CUENTA'=>'','cta as N_CUENTA'=>'','banco_des AS BANCO'=>'');
	$rut_f = array('RUT_TITULAR_CUENTA'=>'');
	$where_f = array('num_solici'=>' = "'.$num_solici.'"');
	$fpago->Imprimir($campos_f,"contr",$where_f,'2',$rut_f);

	}

	//TARJETA DE CREDITO
	if ($f_pago == 200){

	$campos_f =array('descripcion AS FORMA_DE_PAGO'=>'','titular_cta AS TITULAR_CUENTA'=>'','rut_titular_cta AS RUT_TITULAR_CUENTA'=>'','cta as N_CUENTA'=>'','t_credito_des AS T_CREDITO'=>'');
	$rut_f = array('RUT_TITULAR_CUENTA'=>'');
	$where_f = array('num_solici'=>' = "'.$num_solici.'"');
	$fpago->Imprimir($campos_f,"contr",$where_f,'2',$rut_f);

	}
	//COBRO DOMICILIARIO
	if ($f_pago == 300){

	$campos_f =array('poblacion AS VILLA_POBLACION'=>'','calle AS CALLE_PASAJE'=>'','numero AS NUMERO'=>'','piso AS PISO'=>'','departamento AS DEPARTAMENTO'=>'','localidad AS LOCALIDAD'=>'','telefono AS FONO'=>'','email AS EMAIL'=>'','entre as ENTRE'=>'');
	$rut_f = array('NULL'=>'');
	$where_f = array('num_solici'=>' = "'.$num_solici.'"','tipo_dom ='=>'1');

        echo '<strong>DOMICILIO DE COBRO</strong>';
	$fpago->Imprimir($campos_f,"domicilios",$where_f,'2',$rut_f);
	}

	//DESCUENTO POR PLANILLA
	if ($f_pago == 400){

	$campos_e =array('nro_doc AS RUT_EMPRESA'=>'','empresa AS EMPRESA'=>'','giro AS GIRO'=>'');
	$rut_e = array('RUT_EMPRESA'=>'');

	//OBTENER COD EMPRESA
	$sql ="SELECT contratos.empresa FROM contratos WHERE contratos.num_solici='".$num_solici."'";
	$query = mysql_query($sql);
	$emp = mysql_fetch_array($query);

	$where_e = array('nro_doc ='=>'"'.$emp['empresa'].'"');
	echo '<strong>DESCUENTO POR PLANILLA</strong>';
	$fpago->Imprimir($campos_e,'emp',$where_e,'3',$rut_e);
	}

	//TRANFERENCIA ELECTRONICA
	if ($f_pago == 500){
	echo '<strong>TRASFERENCIA ELECTRONICA </strong>';
	}

        if ($edicion == 1){
            echo '<br /><div style="padding:10px" align="right"><a class="boton" href="INT/SUB_M_TESO_2.php?FPAGO=1&CONTRATO='.$num_solici.'&cod_f='.$f_pago.'">Editar</a></div><br />';
        }

        if($edicion == 0){
            echo '<br />';
        }
    }

    //MUESTRA FORMA DEPAGO INICIAL (BUSCAR POR NUMERO DE CONTRATO)
    function FormaPagoInicial($num_solici,$doc_pago,$rendicion){


        //echo '<br />'.$doc_pago.' acap<br />';

        echo '<br /><h1>PAGO INICIAL CLA</h1>';

        $fpago = new Datos;

	//CHEQUE A FECHA
	if ($doc_pago> 9 && $doc_pago< 11){
		$campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','n_che_tar AS N_CHEQUE'=>'','des_bancos AS BANCO'=>'','mes_pago_inicial AS MES_PAGO_INICIAL'=>'','n_documento AS N_DOCUMENTO_PAGO'=>'','des_t_documento AS T_DOCUMENTO'=>'');
		$rut_y = array('NULL'=>'');

	}
	//CHEQUE AL dia
	if ($doc_pago> 19 && $doc_pago< 21){
		$campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','n_che_tar AS N_CHEQUE'=>'','des_bancos AS BANCO'=>'','mes_pago_inicial AS MES_PAGO_INICIAL'=>'','n_documento AS N_DOCUMENTO_PAGO'=>'','des_t_documento AS T_DOCUMENTO'=>'');
		$rut_y = array('NULL'=>'');

	}

	//CHEQUE AL dia
	if ($doc_pago> 29 && $doc_pago< 31){
		$campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','n_che_tar AS N_TARJETA'=>'','des_t_credito AS TARJETA'=>'','mes_pago_inicial AS MES_PAGO_INICIAL'=>'','n_documento AS N_DOCUMENTO_PAGO'=>'','des_t_documento AS T_DOCUMENTO'=>'');
		$rut_y = array('NULL'=>'');

	}

	//EFECTIVO
	if ($doc_pago> 39 && $doc_pago< 41){
		$campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','mes_pago_inicial AS MES_PAGO_INICIAL'=>'','n_documento AS N_DOCUMENTO_PAGO'=>'','des_t_documento AS T_DOCUMENTO'=>'');
		$rut_y = array('NULL'=>'');

	}

        //DESCUENTO POR PLANILLA
        if ($doc_pago> 49 && $doc_pago< 51){

            $campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','mes_pago_inicial AS MES_PAGO_INICIAL'=>'','n_documento AS N_DOCUMENTO_PAGO'=>'');
            $rut_y = array('NULL'=>'');

	}

        //SIN COSTO
        if ($doc_pago> 59 && $doc_pago< 61){

            $campos_y =array('des_pago_venta AS F_PAGO'=>'','monto AS MONTO'=>'','mes_pago_inicial AS MES_PAGO_INICIAL'=>'','n_documento AS N_DOCUMENTO_PAGO'=>'');
            $rut_y = array('NULL'=>'');

	}

        //ESPECIFICA LA BUSQUEDA POR num_solici/numero de rendicion
        if ($rendicion < 1){
            $where_y = array('num_solici ='=>'"'.$num_solici.'"');
            }

        else{
            $where_y = array('rendicion ='=>'"'.$rendicion.'"','num_solici ='=>'"'.$num_solici.'"');
        }

        $fpago->Imprimir($campos_y,"REG_VENTAS",$where_y,'2',$rut_y);
    }

    //MUESTRA ZOSEMA
    function MuestraZOSEMA($num_solici,$editar){
        echo '<h1>ZONA DE COBRO CLA</h1>';

        $contrato = new Datos;
	$campos = array('ZO'=>'','SE'=>'','MA'=>'','nom_cob1 AS COBRADOR_NOMBRE1'=>'','nom_cob2 AS COBRADOR_NOMBRE2'=>'','ape_cob AS COBRADOR_APELLIDOS'=>'','nro_doc_cob AS RUT_COBRADOR'=>'');
	$where = array('num_solici'=>' = "'.$num_solici.'"');
	$rut = array('RUT_COBRADOR'=>"");
	$contrato->Imprimir($campos,"contr",$where,'3',$rut);

        if ($editar == 1){
            echo '<br /><div align="right"><a class="boton" href="INT/SUB_M_TESO_2.php?ZOSEMA=1&CONTRATO='.$num_solici.'">Editar</a></div></br>';
        }
        if ($editar == 0){
            echo '<br />';
        }
	

    }

    //CUENTA GRUPO FAMILIAR DESCARTA HONORARIO BAJAS ECT
    function cuentaGrupoFam($num_solici){

        $n_afi_sql ="SELECT COUNT(afiliados.num_solici) AS n_afi
                    FROM afiliados
                    WHERE (cod_baja = '00'  || cod_baja = 'AJ'  || cod_baja = '04'  || cod_baja ='AZ')
                    AND num_solici='".$num_solici."'
                    GROUP BY afiliados.num_solici";
        
        $n_afi_query = mysql_query($n_afi_sql);
        $num = mysql_fetch_array($n_afi_query);

        return $num['n_afi'];
        
    }
}
?>
