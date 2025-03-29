<?php

class Emision{

        public $query ="SELECT
                    cta.DEV,
                    cta.comprovante,
                    contratos.factu,
                    contratos.num_solici,
                    contratos.titular,
                    f_pago.descripcion AS f_pago,
                    e_contrato.descripcion AS estado,
                    contratos.f_baja,
                    cta.fecha_mov,
                    cta.cobrador,
                    cobrador.nombre1 AS cob_asignado,
                    cta.cod_mov,
                    cta.importe,
                    cta.debe,
                    cta.haber,
                    cta.fecha,
                    t_mov.corta
                    FROM contratos
                    LEFT JOIN e_contrato ON e_contrato.cod = contratos.estado
                    LEFT JOIN f_pago ON f_pago.codigo = contratos.f_pago
                    LEFT JOIN cta ON cta.num_solici= contratos.num_solici AND contratos.titular = cta.nro_doc
                    LEFT JOIN t_mov ON t_mov.codigo = cta.cod_mov
                    LEFT JOIN ZOSEMA ON ZOSEMA.ZO = contratos.ZO AND ZOSEMA.SE = contratos.SE AND ZOSEMA.MA = contratos.MA
                    LEFT JOIN cobrador ON cobrador.nro_doc = ZOSEMA.cobrador";

    function pendiente($periodo,$desde,$hasta,$cobrador,$imprimir,$dev){


    $periodoAnterior1 = date("Y-m-01", strtotime("$periodo - 1 month"));
    $periodoAnterior2 = date("Y-m-01", strtotime("$periodo - 2 month"));

    $sql = $this->query." WHERE cta.fecha_mov BETWEEN '".$periodoAnterior2."' AND '".$periodoAnterior1."' AND
                                t_mov.operador='D' AND afectacion < 1 AND
                                cta.cobrador='".$cobrador."' AND cobrador.codigo='".$cobrador."'
                                ORDER BY comprovante";

    $query = mysql_query($sql);

    while($informe = mysql_fetch_array($query)){

        //$importe = $importe +  $informe['debe'];

            $consulta = "SELECT COUNT(cta.comprovante) AS num FROM cta WHERE afectacion < 1 AND cta.nro_doc='".$informe['titular']."' AND cta.num_solici='".$informe['num_solici']."'";
            $query_con = mysql_query($consulta);
            $num = mysql_fetch_array($query_con);

            if ($num['num'] > 2 ){
                $importe = $importe + 0;
            }
            else{
                $importe = $importe +  $informe['debe'];
            }


        }

        return $importe;

}

    function pendiente_fp($periodo,$desde,$hasta,$cobrador,$imprimir,$dev,$fpago){


    $periodoAnterior1 = date("Y-m-01", strtotime("$periodo - 1 month"));
    $periodoAnterior2 = date("Y-m-01", strtotime("$periodo - 2 month"));

    $sql = $this->query." WHERE cta.fecha_mov ='".$periodoAnterior1."' AND
                                t_mov.operador='D' AND afectacion < 1 AND contratos.f_pago='".$fpago."' AND
                                cta.cobrador='".$cobrador."' AND cobrador.codigo='".$cobrador."'
                                ORDER BY comprovante";
    $query = mysql_query($sql);

    while($informe = mysql_fetch_array($query)){

        //$importe = $importe +  $informe['debe'];

            $consulta = "SELECT COUNT(cta.comprovante) AS num FROM cta WHERE afectacion < 1 AND cta.nro_doc='".$informe['titular']."' AND cta.num_solici='".$informe['num_solici']."'";
            $query_con = mysql_query($consulta);
            $num = mysql_fetch_array($query_con);

            if ($num['num'] > 2 ){
                $importe = $importe + 0;
            }
            else{
                $importe = $importe +  $informe['debe'];
            }

        }

        return $importe;

}

    function pendiente_pag($periodo,$desde,$hasta,$cobrador){


    $periodoAnterior1 = date("Y-m-01", strtotime("$periodo - 1 month"));
    $periodoAnterior2 = date("Y-m-01", strtotime("$periodo - 2 days"));

    $sql = $this->query." WHERE cta.fecha_mov ='".$periodoAnterior1."' AND DEV=0 AND
                                t_mov.operador='H' AND afectacion > 1 AND fecha > '".$desde."' AND fecha AND
                                cta.cobrador='".$cobrador."' AND cobrador.codigo='".$cobrador."'
                                ORDER BY comprovante";

    //echo '<br />'.$sql.'<br />';
   
    $query = mysql_query($sql);

    while($informe = mysql_fetch_array($query)){

        //$importe = $importe +  $informe['debe'];


           $importe = $importe +  $informe['haber'];

        }

        return $importe;

}

    function pendiente_pag_fpago($periodo,$desde,$hasta,$cobrador,$fpago){


    $periodoAnterior1 = date("Y-m-01", strtotime("$periodo - 1 month"));
    $periodoAnterior2 = date("Y-m-01", strtotime("$periodo - 1 days"));

    $sql = $this->query." WHERE cta.fecha_mov ='".$periodoAnterior1."' AND DEV=0 AND contratos.f_pago='".$fpago."' AND
                                t_mov.operador='H' AND afectacion > 1 AND fecha > '".$hasta."' AND fecha AND
                                cta.cobrador='".$cobrador."' AND cobrador.codigo='".$cobrador."' AND contratos.f_pago='".$fpago."' 
                                ORDER BY comprovante";

    //echo '<br />'.$sql.'<br />';

    $query = mysql_query($sql);

    while($informe = mysql_fetch_array($query)){

        //$importe = $importe +  $informe['debe'];


           $importe = $importe +  $informe['haber'];

        }

        return $importe;

}

    function actual_fp($periodo,$desde,$hasta,$cobrador,$fpago){

    $sql = $this->query." WHERE cta.fecha_mov ='".$periodo."' AND
                                t_mov.operador='D' AND  contratos.f_pago='".$fpago."' AND
                                cta.cobrador='".$cobrador."' AND cobrador.codigo='".$cobrador."'
                                ORDER BY comprovante";

    $query = mysql_query($sql);

    while($informe = mysql_fetch_array($query)){

           $importe = $importe +  $informe['debe'];

     }

        return $importe;

    }

    function actual($periodo,$desde,$hasta,$cobrador){

    $sql = $this->query." WHERE cta.fecha_mov ='".$periodo."' AND
                                t_mov.operador='D' AND
                                cta.cobrador='".$cobrador."' AND cobrador.codigo='".$cobrador."'
                                ORDER BY comprovante";


    //echo '<br />'.$sql.'<br />';

    $query = mysql_query($sql);

    while($informe = mysql_fetch_array($query)){

           $importe = $importe +  $informe['debe'];

     }

        return $importe;

    }


}

?>
