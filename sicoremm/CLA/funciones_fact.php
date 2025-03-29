<?php

function unidad($numuero)
{
    switch ($numuero) {
        case 9: {
            $numu = "NUEVE";
            break;
        }
        case 8: {
            $numu = "OCHO";
            break;
        }
        case 7: {
            $numu = "SIETE";
            break;
        }
        case 6: {
            $numu = "SEIS";
            break;
        }
        case 5: {
            $numu = "CINCO";
            break;
        }
        case 4: {
            $numu = "CUATRO";
            break;
        }
        case 3: {
            $numu = "TRES";
            break;
        }
        case 2: {
            $numu = "DOS";
            break;
        }
        case 1: {
            $numu = "UN";
            break;
        }
        case 0: {
            $numu = "";
            break;
        }
    }
    return $numu;
}

function decena($numdero)
{

    if ($numdero >= 90 && $numdero <= 99) {
        $numd = "NOVENTA ";
        if ($numdero > 90)
            $numd = $numd . "Y " . (unidad($numdero - 90));
    } else if ($numdero >= 80 && $numdero <= 89) {
        $numd = "OCHENTA ";
        if ($numdero > 80)
            $numd = $numd . "Y " . (unidad($numdero - 80));
    } else if ($numdero >= 70 && $numdero <= 79) {
        $numd = "SETENTA ";
        if ($numdero > 70)
            $numd = $numd . "Y " . (unidad($numdero - 70));
    } else if ($numdero >= 60 && $numdero <= 69) {
        $numd = "SESENTA ";
        if ($numdero > 60)
            $numd = $numd . "Y " . (unidad($numdero - 60));
    } else if ($numdero >= 50 && $numdero <= 59) {
        $numd = "CINCUENTA ";
        if ($numdero > 50)
            $numd = $numd . "Y " . (unidad($numdero - 50));
    } else if ($numdero >= 40 && $numdero <= 49) {
        $numd = "CUARENTA ";
        if ($numdero > 40)
            $numd = $numd . "Y " . (unidad($numdero - 40));
    } else if ($numdero >= 30 && $numdero <= 39) {
        $numd = "TREINTA ";
        if ($numdero > 30)
            $numd = $numd . "Y " . (unidad($numdero - 30));
    } else if ($numdero >= 20 && $numdero <= 29) {
        if ($numdero == 20)
            $numd = "VEINTE ";
        else
            $numd = "VEINTI" . (unidad($numdero - 20));
    } else if ($numdero >= 10 && $numdero <= 19) {
        switch ($numdero) {
            case 10: {
                $numd = "DIEZ ";
                break;
            }
            case 11: {
                $numd = "ONCE ";
                break;
            }
            case 12: {
                $numd = "DOCE ";
                break;
            }
            case 13: {
                $numd = "TRECE ";
                break;
            }
            case 14: {
                $numd = "CATORCE ";
                break;
            }
            case 15: {
                $numd = "QUINCE ";
                break;
            }
            case 16: {
                $numd = "DIECISEIS ";
                break;
            }
            case 17: {
                $numd = "DIECISIETE ";
                break;
            }
            case 18: {
                $numd = "DIECIOCHO ";
                break;
            }
            case 19: {
                $numd = "DIECINUEVE ";
                break;
            }
        }
    } else
        $numd = unidad($numdero);
    return $numd;
}

function centena($numc)
{
    if ($numc >= 100) {
        if ($numc >= 900 && $numc <= 999) {
            $numce = "NOVECIENTOS ";
            if ($numc > 900)
                $numce = $numce . (decena($numc - 900));
        } else if ($numc >= 800 && $numc <= 899) {
            $numce = "OCHOCIENTOS ";
            if ($numc > 800)
                $numce = $numce . (decena($numc - 800));
        } else if ($numc >= 700 && $numc <= 799) {
            $numce = "SETECIENTOS ";
            if ($numc > 700)
                $numce = $numce . (decena($numc - 700));
        } else if ($numc >= 600 && $numc <= 699) {
            $numce = "SEISCIENTOS ";
            if ($numc > 600)
                $numce = $numce . (decena($numc - 600));
        } else if ($numc >= 500 && $numc <= 599) {
            $numce = "QUINIENTOS ";
            if ($numc > 500)
                $numce = $numce . (decena($numc - 500));
        } else if ($numc >= 400 && $numc <= 499) {
            $numce = "CUATROCIENTOS ";
            if ($numc > 400)
                $numce = $numce . (decena($numc - 400));
        } else if ($numc >= 300 && $numc <= 399) {
            $numce = "TRESCIENTOS ";
            if ($numc > 300)
                $numce = $numce . (decena($numc - 300));
        } else if ($numc >= 200 && $numc <= 299) {
            $numce = "DOSCIENTOS ";
            if ($numc > 200)
                $numce = $numce . (decena($numc - 200));
        } else if ($numc >= 100 && $numc <= 199) {
            if ($numc == 100)
                $numce = "CIEN ";
            else
                $numce = "CIENTO " . (decena($numc - 100));
        }
    } else
        $numce = decena($numc);

    return $numce;
}

function miles($nummero)
{
    if ($nummero >= 1000 && $nummero < 2000) {
        $numm = "MIL " . (centena($nummero % 1000));
    }
    if ($nummero >= 2000 && $nummero < 10000) {
        $numm = unidad(Floor($nummero / 1000)) . " MIL " . (centena($nummero % 1000));
    }
    if ($nummero < 1000)
        $numm = centena($nummero);

    return $numm;
}

function decmiles($numdmero)
{
    if ($numdmero == 10000)
        $numde = "DIEZ MIL";
    if ($numdmero > 10000 && $numdmero < 20000) {
        $numde = decena(Floor($numdmero / 1000)) . "MIL " . (centena($numdmero % 1000));
    }
    if ($numdmero >= 20000 && $numdmero < 100000) {
        $numde = decena(Floor($numdmero / 1000)) . " MIL " . (miles($numdmero % 1000));
    }
    if ($numdmero < 10000)
        $numde = miles($numdmero);

    return $numde;
}

function cienmiles($numcmero)
{
    if ($numcmero == 100000)
        $num_letracm = "CIEN MIL";
    if ($numcmero >= 100000 && $numcmero < 1000000) {
        $num_letracm = centena(Floor($numcmero / 1000)) . " MIL " . (centena($numcmero % 1000));
    }
    if ($numcmero < 100000)
        $num_letracm = decmiles($numcmero);
    return $num_letracm;
}

function millon($nummiero)
{
    if ($nummiero >= 1000000 && $nummiero < 2000000) {
        $num_letramm = "UN MILLON " . (cienmiles($nummiero % 1000000));
    }
    if ($nummiero >= 2000000 && $nummiero < 10000000) {
        $num_letramm = unidad(Floor($nummiero / 1000000)) . " MILLONES " . (cienmiles($nummiero % 1000000));
    }
    if ($nummiero < 1000000)
        $num_letramm = cienmiles($nummiero);

    return $num_letramm;
}

function decmillon($numerodm)
{
    if ($numerodm == 10000000)
        $num_letradmm = "DIEZ MILLONES";
    if ($numerodm > 10000000 && $numerodm < 20000000) {
        $num_letradmm = decena(Floor($numerodm / 1000000)) . "MILLONES " . (cienmiles($numerodm % 1000000));
    }
    if ($numerodm >= 20000000 && $numerodm < 100000000) {
        $num_letradmm = decena(Floor($numerodm / 1000000)) . " MILLONES " . (millon($numerodm % 1000000));
    }
    if ($numerodm < 10000000)
        $num_letradmm = millon($numerodm);

    return $num_letradmm;
}

function cienmillon($numcmeros)
{
    if ($numcmeros == 100000000)
        $num_letracms = "CIEN MILLONES";
    if ($numcmeros >= 100000000 && $numcmeros < 1000000000) {
        $num_letracms = centena(Floor($numcmeros / 1000000)) . " MILLONES " . (millon($numcmeros % 1000000));
    }
    if ($numcmeros < 100000000)
        $num_letracms = decmillon($numcmeros);
    return $num_letracms;
}

function milmillon($nummierod)
{
    if ($nummierod >= 1000000000 && $nummierod < 2000000000) {
        $num_letrammd = "MIL " . (cienmillon($nummierod % 1000000000));
    }
    if ($nummierod >= 2000000000 && $nummierod < 10000000000) {
        $num_letrammd = unidad(Floor($nummierod / 1000000000)) . " MIL " . (cienmillon($nummierod % 1000000000));
    }
    if ($nummierod < 1000000000)
        $num_letrammd = cienmillon($nummierod);

    return $num_letrammd;
}

function convertir($numero)
{
    $numf = milmillon($numero);
    return $numf;
}

function UltimoDia($anho, $mes)
{
    if (((fmod($anho, 4) == 0) and (fmod($anho, 100) != 0)) or (fmod($anho, 400) == 0)) {
        $dias_febrero = 29;
    } else {
        $dias_febrero = 28;
    }
    switch ($mes) {
        case 01:
            return 31;
            break;
        case 02:
            return $dias_febrero;
            break;
        case 03:
            return 31;
            break;
        case 04:
            return 30;
            break;
        case 05:
            return 31;
            break;
        case 06:
            return 30;
            break;
        case 07:
            return 31;
            break;
        case 08:
            return 31;
            break;
        case 09:
            return 30;
            break;
        case 10:
            return 31;
            break;
        case 11:
            return 30;
            break;
        case 12:
            return 31;
            break;
    }
}

function deuda($num_solici, $nro_doc)
{

    $s = 'SELECT COUNT(cta.fecha_mov) AS num_deuda,nro_doc, num_solici, importe, fecha_mov
        FROM cta
        WHERE cta.cod_mov=1  AND afectacion < 1 AND num_solici="' . $num_solici . '" AND nro_doc="' . $nro_doc . '" AND YEAR(fecha_mov) >= "2011" GROUP BY nro_doc, 
    num_solici, 
    importe, 
    fecha_mov;';

    /*echo $s . "<br />";
    return;*/

    $q = mysql_query($s);

    $num = mysql_fetch_array($q);

    $num_deuda = $num['num_deuda'];
    if ($num_deuda == "") {
        return 0;
    } else {
        return $num_deuda;
    }

}

function cambiarDicomAfiliados($num_solici, $f_baja)
{
    $query = "UPDATE afiliados SET afiliados.cod_baja ='AJ', afiliados.fecha_baja='" . $f_baja . "' WHERE num_solici = '" . $num_solici . "' AND afiliados.cod_baja != '02' AND afiliados.cod_baja != '01'AND afiliados.cod_baja != '03' AND afiliados.cod_baja != '05'  AND afiliados.cod_baja != '09'";
    return $query;
}

function cambiarDicomContratos($num_solici, $f_baja)
{
    $query = "UPDATE contratos SET estado='3100', f_baja='" . $f_baja . "' WHERE num_solici='" . $num_solici . "'";
    return $query;
}

//01 fallecimiento 02 renuncia 03 otras causas
function cambiaraRenuncaiAfiliados($num_solici, $f_baja)
{
    $query = "UPDATE afiliados SET afiliados.cod_baja ='02', afiliados.fecha_baja='" . $f_baja . "' WHERE num_solici = '" . $num_solici . "' AND afiliados.cod_baja != '01' AND afiliados.cod_baja != '02' AND afiliados.cod_baja != '03' AND afiliados.cod_baja != '05'  AND afiliados.cod_baja != '09' AND afiliados.cod_baja != 'DV'";
    //echo $query.'<br />';
    return $query;
}


//CAMBIA A RENUNCIA
function cambiarHonorarioMoroso($num_solici, $f_baja)
{
    $query = "UPDATE afiliados SET afiliados.cod_baja ='MO', afiliados.fecha_baja='" . $f_baja . "' WHERE num_solici = '" . $num_solici . "' AND afiliados.cod_baja = '05'";
    return $query;
}



function cambiarRenunciaContratos($num_solici, $f_baja)
{
    $query = "UPDATE contratos SET estado='700', f_baja='" . $f_baja . "' WHERE num_solici='" . $num_solici . "'";
    //echo $query.'<br />';
    return $query;
}

function obtenerDigitoVerificador($rutSinDV)
{
    $rut = str_replace('.', '', $rutSinDV); // Eliminar puntos
    $rut = str_replace('-', '', $rut); // Eliminar guión

    $reversedRut = strrev($rut); // Invertir el RUT
    $sum = 0;
    $multiplier = 2;

    for ($i = 0; $i < strlen($reversedRut); $i++) {
        $sum += intval($reversedRut[$i]) * $multiplier;
        $multiplier = $multiplier % 7 == 0 ? 2 : $multiplier + 1;
    }

    $dv = 11 - ($sum % 11);

    if ($dv == 11) {
        return '0';
    } elseif ($dv == 10) {
        return 'K';
    } else {
        return strval($dv);
    }
}

function cortarString($texto, $cantidadCaracteres)
{
    if (strlen($texto) <= $cantidadCaracteres) {
        return $texto;
    } else {
        $textoCortado = substr($texto, 0, $cantidadCaracteres);
        return $textoCortado;
    }
}

function escapeString($string)
{
    $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
    $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");

    return str_replace($search, $replace, $string);
}


function pago_cta($nro_doc, $tipo_comp, $comprovante, $afectacion, $fecha_mov, $fecha_vto, $importe, $cobrador, $num_solici, $fecha, $debe, $haber, $rendicion, $ajuste, $comp, $e_nombre, $e_domicilio, $zo, $se, $ma, $periodo, $mes, $telefono, $secuencia, $tipo_plan, $cod_plan, $mes_palabras, $anio)
{


    $fecha = explode("-", $fecha_mov);

    $consulta = "SELECT COUNT(cta.nro_doc) AS N FROM cta WHERE cta.nro_doc='" . $nro_doc . "' AND num_solici='" . $num_solici . "' AND  MONTH(fecha_mov)='" . $fecha[1] . "' AND YEAR(fecha_mov)='" . $fecha[0] . "' AND (cod_mov='1' || cod_mov='53')";

    $con = mysql_query($consulta) or die(mysql_error());
    $num = mysql_fetch_array($con) or die(mysql_error());


    if ($num['N'] < 1) {

        $insert_sql = "INSERT INTO cta (tip_doc,nro_doc,tipo_comp,serie,comprovante,cod_mov,afectacion,fecha_mov,fecha_vto,importe,cobrador,num_solici,fecha,debe,haber,rendicion) VALUES(1,'" . $nro_doc . "','" . $tipo_comp . "','50','" . $comprovante . "','1','0','" . $fecha_mov . "','" . $fecha_vto . "','" . $importe . "','" . $cobrador . "','" . $num_solici . "','" . $fecha[0] . '-' . $fecha['1'] . '-' . $fecha['2'] . "','" . $importe . "','0',NULL)";
        $digitoVerificador = obtenerDigitoVerificador($nro_doc);

        $e_domicilio = cortarString($e_domicilio, 30);
        $telefono = cortarString($telefono, 50);
        $e_domicilio = escapeString($e_domicilio);

        $emi_par = "INSERT INTO emi_par_b_imp(e_deuda,  e_tipo ,e_nro         ,e_tipo_comp,  e_serie_comp,   e_comp,          e_nombre,         e_domicilio,             e_cuit,          e_localidad,    e_zona,     e_seccion,     e_manzana,   e_periodo,          e_cond_iva,      e_cuota,         e_iva10,     e_iva05,    e_total,           e_telefono,          e_cant,                grupo_vie,              e_tipo_plan,       e_cod_plan,              fila,    e_codbar,             e_mes,                 e_letras,                      e_ano,         e_nromes,e_rut) 
                                     VALUES('0001', '01'   ,'" . $nro_doc . "','B',          '00050',        '" . $comp . "',     '" . $e_nombre . "',  '" . $e_domicilio . "',      '" . $nro_doc . "',  'ANTOFAGASTA',  '" . $zo . "',  '" . $se . "',     '" . $ma . "',   '" . $periodo . "',     '" . $mes . "',      '" . $importe . "',  '0',         '0',        '" . $importe . "',    '" . $telefono . "',     '" . $secuencia . "',      '" . $num_solici . "',      '" . $tipo_plan . "',  '" . $cod_plan . "',         '1',     NULL,                 '" . $mes_palabras . "',   '" . convertir($importe) . "',     '" . $anio . "',   '" . $mes . "', '" . $digitoVerificador . "');";


        $IVA = "INSERT INTO IVA(e_deuda,  e_tipo ,e_nro         ,e_tipo_comp,  e_serie_comp,   e_comp,          e_nombre,         e_domicilio,             e_cuit,          e_localidad,    e_zona,     e_seccion,     e_manzana,   e_periodo,          e_cond_iva,      e_cuota,         e_iva10,     e_iva05,    e_total,           e_telefono,          e_cant,                grupo_vie,              e_tipo_plan,       e_cod_plan,              fila,    e_codbar,             e_mes,                 e_letras,                      e_ano,         e_nromes,e_rut)
                                     VALUES('0001', '01'   ,'" . $nro_doc . "','B',          '00050',        '" . $comp . "',     '" . $e_nombre . "',  '" . $e_domicilio . "',      '" . $nro_doc . "',  'ANTOFAGASTA',  '" . $zo . "',  '" . $se . "',     '" . $ma . "',   '" . $periodo . "',     '" . $mes . "',      '" . $importe . "',  '0',         '0',        '" . $importe . "',    '" . $telefono . "',     '" . $secuencia . "',      '" . $num_solici . "',      '" . $tipo_plan . "',  '" . $cod_plan . "',         '1',     NULL,                 '" . $mes_palabras . "',   '" . convertir($importe) . "',     '" . $anio . "',   '" . $mes . "', '" . $digitoVerificador . "')";


        $bilia = "INSERT INTO emision_par_b (e_iva10,e_iva05,e_deuda,e_tipo,e_nro         ,e_tipo_comp,e_serie_comp,         e_comp,          e_nombre,        e_domicilio,              e_cuit,          e_localidad,   e_zona,     e_seccion,     e_manzana,    e_periodo,        e_cond_iva,        e_cuota,                                  e_total,           e_telefono,          e_cant,                 grupo_vie,              e_tipo_plan,e_cod_plan)
                                   VALUES('" . $importe . "','" . $importe . "','0001','01'  ,'" . $nro_doc . "','B',        '00050',         '" . $comp . "',     '" . $e_nombre . "', '" . $e_domicilio . "',       '" . $nro_doc . "',  'ANTOFAGASTA', '" . $zo . "',  '" . $se . "',     '" . $ma . "',    '01" . $mes . $anio . "',   '" . $mes . "',             '" . $importe . "',                           '" . $importe . "',    '" . $telefono . "',     '" . $secuencia . "',       '" . $num_solici . "',      '" . $tipo_plan . "',  '" . $cod_plan . "')";




        $update_con = "UPDATE contratos SET contratos.ajuste='" . $ajuste . "' WHERE num_solici='" . $num_solici . "' AND titular='" . $nro_doc . "'";
        mysql_query($bilia);
        mysql_query($IVA);
        mysql_query($insert_sql);
        mysql_query($update_con);
        mysql_query($emi_par);

        return 1;
    } else {
        return 0;
    }

}

function pago_cta2($nro_doc, $tipo_comp, $comprovante, $afectacion, $fecha_mov, $fecha_vto, $importe, $cobrador, $num_solici, $fecha, $debe, $haber, $rendicion, $ajuste, $comp, $e_nombre, $e_domicilio, $zo, $se, $ma, $periodo, $mes, $telefono, $secuencia, $tipo_plan, $cod_plan, $mes_palabras, $anio)
{


    $fecha = explode("-", $fecha_mov);

    $consulta = "SELECT COUNT(cta.nro_doc) AS N FROM cta WHERE cta.nro_doc='" . $nro_doc . "' AND num_solici='" . $num_solici . "' AND  MONTH(fecha_mov)='" . $fecha[1] . "' AND YEAR(fecha_mov)='" . $fecha[0] . "' AND (cod_mov='1' || cod_mov='53')";

    $con = mysql_query($consulta);
    $num = mysql_fetch_array($con);


    if ($num['N'] < 1) {

        $insert_sql = "INSERT INTO cta (tip_doc,nro_doc,tipo_comp,serie,comprovante,cod_mov,afectacion,fecha_mov,fecha_vto,importe,cobrador,num_solici,fecha,debe,haber,rendicion) VALUES(1,'" . $nro_doc . "','" . $tipo_comp . "','50','" . $comprovante . "','1','0','" . $fecha_mov . "','" . $fecha_vto . "','" . $importe . "','" . $cobrador . "','" . $num_solici . "','" . $fecha[0] . '-' . $fecha['1'] . '-' . $fecha['2'] . "','" . $importe . "','0','NULL')";

        $dv = new Datos;
        $dv->Rut($nro_doc);

        //$emi_par = "INSERT INTO emi_par_b_imp(e_deuda,  e_tipo ,e_nro         ,e_tipo_comp,  e_serie_comp,   e_comp,          e_nombre,         e_domicilio,             e_cuit,          e_localidad,    e_zona,     e_seccion,     e_manzana,   e_periodo,          e_cond_iva,      e_cuota,         e_iva10,     e_iva05,    e_total,           e_telefono,          e_cant,                grupo_vie,              e_tipo_plan,       e_cod_plan,              fila,    e_codbar,             e_mes,                 e_letras,                      e_ano,         e_nromes,e_rut)
        //                               VALUES('0001', '01'   ,'".$nro_doc."','B',          '00050',        '".$comp."',     '".$e_nombre."',  '".$e_domicilio."',      '".$nro_doc."',  'ANTOFAGASTA',  '".$zo."',  '".$se."',     '".$ma."',   '".$periodo."',     '".$mes."',      '".$importe."',  '0',         '0',        '".$importe."',    '".$telefono."',     '".$secuencia."',      '".$num_solici."',      '".$tipo_plan."',  '".$cod_plan."',         '1',     NULL,                 '".$mes_palabras."',   '".convertir($importe)."',     '".$anio."',   '".$mes."', '".$dv->nro_doc."');";

        $update_con = "UPDATE contratos SET contratos.ajuste='" . $ajuste . "' WHERE num_solici='" . $num_solici . "' AND titular='" . $nro_doc . "'";

        mysql_query($insert_sql);
        mysql_query($update_con);
        //mysql_query($emi_par);

        return 1;
    } else {
        return 0;
    }

}


function mes($mes)
{


    switch ($mes) {

        case "1":
            $sentencias = "ENERO";
            break;

        case "2":
            $sentencias = "FEBRERO";
            break;

        case "3":
            $sentencias = "MARZO";
            break;

        case "4":
            $sentencias = "ABRIL";
            break;

        case "5":
            $sentencias = "MAYO";
            break;

        case "6":
            $sentencias = "JUNIO";
            break;

        case "7":
            $sentencias = "JULIO";
            break;

        case "8":
            $sentencias = "AGOSTO";
            break;

        case "9":
            $sentencias = "SEPTIEMBRE";
            break;

        case "10":
            $sentencias = "OCTUBRE";
            break;

        case "11":
            $sentencias = "NOVIEMBRE";
            break;

        case "12":
            $sentencias = "DICIEMBRE";
            break;
    }

    return $sentencias;

}

?>