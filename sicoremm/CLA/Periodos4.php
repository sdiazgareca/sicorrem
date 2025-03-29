
<?php
class Periodos3 {

    public $inicio = "<table class='table2' border='1'>";
    public $cierre = "</table>";

    public $css ='<style type="text/css">
		  table {font-family: Gill, Helvetica, sans-serif; font-size: 10pt;}
		</style>';

    public $cabecera = '<tr><th>BOLETA</th><th>TIPO</th><th>CONTRATO</th><th>RUT</th><th>PERIODO</th><th>IMPORTE</th><th>FECHA PAGO</th></tr>';

    public $query ="SELECT
                    cta.DEV,
                    cta.comprovante,
                    contratos.factu,
                    contratos.num_solici,
                    contratos.titular,
                    f_pago.descripcion AS f_pago,
                    e_contrato.descripcion AS estado,
                    contratos.f_baja,
                    DATE_FORMAT(cta.fecha_mov,'%d-%m-%Y') AS fecha_mov,
                    cta.cobrador,
                    cobrador.nombre1 AS cob_asignado,
                    cta.cod_mov,
                    cta.importe,
                    cta.debe,
                    cta.haber,
                    DATE_FORMAT(cta.fecha,'%d-%m-%Y') AS fecha,
                    t_mov.corta
                    FROM contratos
                    INNER JOIN e_contrato ON e_contrato.cod = contratos.estado
                    INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
                    INNER JOIN cta ON cta.num_solici= contratos.num_solici AND contratos.titular = cta.nro_doc
                    INNER JOIN t_mov ON t_mov.codigo = cta.cod_mov
                    INNER JOIN ZOSEMA ON ZOSEMA.ZO = contratos.ZO AND ZOSEMA.SE = contratos.SE AND ZOSEMA.MA = contratos.MA
                    INNER JOIN cobrador ON cobrador.nro_doc = ZOSEMA.cobrador";

    function Devolucion($comp){

                    if($comp == 0){
                 $DEV = '&zwj;';}

             else{
                 $DEV = 'DEVUELTA';}

                 return $DEV;

    }

    function Estado($comp){
        if($comp > 0){
            $afectacion = 'PAGADA';}
         else{
            $afectacion = 'PENDIENTE';}

            return $afectacion;
    }

    function cobrado($operador_periodo,$periodo,$desde,$hasta,$cobrador,$operador_cob,$imprimir){

        $sql = $this->query." WHERE fecha_mov ".$operador_periodo." '".$periodo."' AND afectacion > 0 AND cta.fecha BETWEEN '".$desde."' AND '".$hasta."'
                            AND cta.cobrador='".$cobrador."' AND cobrador.codigo ".$operador_cob." '".$cobrador."' AND t_mov.operador='H'
                                ORDER BY cta.comprovante";


        $query = mysql_query($sql);


        while($informe = mysql_fetch_array($query)){

            if($imprimir > 0){

            echo '<tr>
                  <td>'.$informe['comprovante'].'</td>
                  <td>'.$informe['factu'].'</td>
                  <td>'.$informe['num_solici'].'</td>
                  <td>'.$informe['titular'].'</td>
                  <td>'.$informe['fecha_mov'].'</td>
                  <td>'.$informe['importe'].'</td>
                  <td>'.$informe['fecha'].'</td>
                  </tr>';
            }
            $importe = $importe +  $informe['haber'];

        }

        return $importe;

    }

    function cobrado_fp($periodo,$desde,$hasta,$cobrador,$imprimir,$F_PAGO,$operador_fmov){

        $sql = $this->query." WHERE afectacion > 0 AND cta.fecha BETWEEN '".$desde."' AND '".$hasta."' AND fecha_mov ".$operador_fmov." '".$periodo."'
                            AND t_mov.operador='H' AND contratos.f_pago ='".$F_PAGO."' AND cta.cobrador='".$cobrador."'";

        $query = mysql_query($sql);


        echo '<br />'.$sql.'<br />';


        while($informe = mysql_fetch_array($query)){

            if($imprimir > 0){

            echo '<tr>
                  <td>'.$informe['comprovante'].'</td>
                  <td>'.$informe['factu'].'</td>
                  <td>'.$informe['num_solici'].'</td>
                  <td>'.$informe['titular'].'</td>
                  <td>'.$informe['fecha_mov'].'</td>
                  <td>'.$informe['importe'].'</td>
                  <td>'.$informe['fecha'].'</td>
                  </tr>';
            }
            $importe = $importe +  $informe['haber'];

        }

        return $importe;

    }

    function pendiente($periodo,$desde,$hasta,$cobrador,$imprimir,$dev){


    $periodoAnterior1 = date("Y-m-01", strtotime("$periodo - 2 month"));
    $periodoAnterior2 = date("Y-m-01", strtotime("$periodo - 1 days"));

    $sql = $this->query." WHERE cta.fecha_mov BETWEEN '".$periodoAnterior1."' AND '".$periodo."' AND
                                        t_mov.operador='D' AND (afectacion < 1 || fecha > '".$hasta."') AND DEV =".$dev." AND
                                        cta.cobrador='".$cobrador."' AND cobrador.codigo='".$cobrador."'
                                        ORDER BY comprovante";

    //echo $sql;
    $query = mysql_query($sql);

    while($informe = mysql_fetch_array($query)){
              if($imprimir > 0){

            echo '<tr>
                  <td>'.$informe['comprovante'].'</td>
                  <td>'.$informe['factu'].'</td>
                  <td>'.$informe['num_solici'].'</td>
                  <td>'.$informe['titular'].'</td>
                  <td>'.$informe['fecha_mov'].'</td>
                  <td>'.$informe['importe'].'</td>
                  <td></td>
                  </tr>';
            }
            $importe = $importe +  $informe['debe'];

        }

        $sql = $this->query." WHERE  cta.fecha_mov BETWEEN '".$periodoAnterior1."' AND '".$periodoAnterior2."' AND
                                   t_mov.operador='H' AND (afectacion > 0 && fecha > '".$periodo2."') AND
                                   cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."'
                                   ORDER BY comprovante";

$query = mysql_query($sql);

    while($informe = mysql_fetch_array($query)){
              if($imprimir > 0){

            echo '<tr>
                  <td>'.$informe['comprovante'].'</td>
                  <td>'.$informe['factu'].'</td>
                  <td>'.$informe['num_solici'].'</td>
                  <td>'.$informe['titular'].'</td>
                  <td>'.$informe['fecha_mov'].'</td>
                  <td>'.$informe['importe'].'</td>
                  <td>'.$informe['fecha'].'</td>
                  </tr>';
            }
            $importe = $importe +  $informe['haber'];

        }

        return $importe;

}


/* PENDIENTE MONTO ENTREGADO */

function pendiente3($periodo,$desde,$hasta,$cobrador,$imprimir,$dev,$operador_periodo,$f_pago){

/*
    $periodoAnterior1 = date("Y-m-01", strtotime("$periodo - 2 month"));
    $periodoAnterior2 = date("Y-m-01", strtotime("$periodo - 1 days"));
*/

    $sql = $this->query." WHERE cta.fecha_mov = '".$periodo."' AND
                                        t_mov.operador='D' AND afectacion < 1 AND DEV =".$dev." AND contratos.f_pago='".$f_pago."' AND
                                        cta.cobrador='".$cobrador."' AND cobrador.codigo='".$cobrador."'
                                        ORDER BY comprovante";

    $query = mysql_query($sql);

    while($informe = mysql_fetch_array($query)){
              if($imprimir > 0){

            echo '<tr>
                  <td>'.$informe['comprovante'].'</td>
                  <td>'.$informe['factu'].'</td>
                  <td>'.$informe['num_solici'].'</td>
                  <td>'.$informe['titular'].'</td>
                  <td>'.$informe['fecha_mov'].'</td>
                  <td>'.$informe['importe'].'</td>
                  <td>'.$informe['fecha'].'</td>
                  </tr>';
            }
            $importe = $importe +  $informe['debe'];

        }

        $sql = $this->query." WHERE  cta.fecha_mov = '".$periodo."' AND
                                   t_mov.operador='H' AND (afectacion > 0 && fecha > '".$hasta."') AND
                                   cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."'
                                   ORDER BY comprovante";

$query = mysql_query($sql);

    while($informe = mysql_fetch_array($query)){
              if($imprimir > 0){

            echo '<tr>
                  <td>'.$informe['comprovante'].'</td>
                  <td>'.$informe['factu'].'</td>
                  <td>'.$informe['num_solici'].'</td>
                  <td>'.$informe['titular'].'</td>
                  <td>'.$informe['fecha_mov'].'</td>
                  <td>'.$informe['importe'].'</td>
                  <td>'.$informe['fecha'].'</td>
                  </tr>';
            }
            $importe = $importe +  $informe['haber'];

        }

        return $importe;

}



/****************************/


/* PENDIENTE MONTO ENTREGADO */

function pendiente2($periodo,$desde,$hasta,$cobrador,$imprimir,$dev,$operador_periodo){

/*
    $periodoAnterior1 = date("Y-m-01", strtotime("$periodo - 2 month"));
    $periodoAnterior2 = date("Y-m-01", strtotime("$periodo - 1 days"));
*/

    $sql = $this->query." WHERE cta.fecha_mov = '".$periodo."' AND
                                        t_mov.operador='D' AND afectacion < 1 AND DEV =".$dev." AND
                                        cta.cobrador='".$cobrador."' AND cobrador.codigo='".$cobrador."'
                                        ORDER BY comprovante";

    //echo $sql;
    $query = mysql_query($sql);

    while($informe = mysql_fetch_array($query)){
              if($imprimir > 0){

            echo '<tr>
                  <td>'.$informe['comprovante'].'</td>
                  <td>'.$informe['factu'].'</td>
                  <td>'.$informe['num_solici'].'</td>
                  <td>'.$informe['titular'].'</td>
                  <td>'.$informe['fecha_mov'].'</td>
                  <td>'.$informe['importe'].'</td>
                  <td>'.$informe['fecha'].'</td>
                  </tr>';
            }
            $importe = $importe +  $informe['debe'];

        }

        $sql = $this->query." WHERE  cta.fecha_mov = '".$periodo."' AND
                                   t_mov.operador='H' AND (afectacion > 0 && fecha > '".$hasta."') AND
                                   cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."'
                                   ORDER BY comprovante";

$query = mysql_query($sql);

    while($informe = mysql_fetch_array($query)){
              if($imprimir > 0){

            echo '<tr>
                  <td>'.$informe['comprovante'].'</td>
                  <td>'.$informe['factu'].'</td>
                  <td>'.$informe['num_solici'].'</td>
                  <td>'.$informe['titular'].'</td>
                  <td>'.$informe['fecha_mov'].'</td>
                  <td>'.$informe['importe'].'</td>
                  <td>'.$informe['fecha'].'</td>
                  </tr>';
            }
            $importe = $importe +  $informe['haber'];

        }

        return $importe;

}



/****************************/

//SOLO PARAEMITIDOS
//FUNCION
//periodo yyyy-mm-dd

function emitido_pen($cobrador,$periodo_anio,$periodo_mes){

    $sql = $this->query." WHERE cta.cobrador = '".$cobrador."' AND cobrador.codigo = '".$cobrador."'  AND cta.cod_mov=1
            AND MONTH(cta.fecha_mov) = '".$periodo_mes."' AND YEAR(cta.fecha_mov)= '".$periodo_anio."'
            AND DAY(cta.fecha_mov)='01'
            GROUP BY cobrador.codigo";

    echo '<br />'.$sql.'<br />';


    $query = mysql_query($sql);

    $salida = mysql_fetch_array($query);

    return $salida['importe'];
}
//USADA EN LA EMISION
function pagos_anticipados($cobrador,$periodo_anio,$periodo_mes,$desde){
        $sql ="SELECT SUM(cta.importe) AS importe
            FROM contratos
            INNER JOIN cta ON cta.nro_doc = contratos.titular AND cta.num_solici = contratos.num_solici
            INNER JOIN cobrador ON cobrador.codigo = cta.cobrador
            INNER JOIN t_mov ON t_mov.codigo = cta.cod_mov
            WHERE cta.cobrador = '".$cobrador."' AND t_mov.operador='H' AND afectacion > 1 AND fecha < '".$desde."'
            AND MONTH(cta.fecha_mov) = '".$periodo_mes."' AND YEAR(cta.fecha_mov)= '".$periodo_anio."'
            GROUP BY cobrador.codigo";
        $query = mysql_query($sql);
        $salida = mysql_fetch_array($query);
        return $salida['importe'];
}

function emitido_pen_fp($cobrador,$periodo_anio,$periodo_mes,$f_pago){

    $sql ="SELECT SUM(cta.debe) AS importe
            FROM contratos
            INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
            INNER JOIN cta ON cta.nro_doc = contratos.titular AND cta.num_solici = contratos.num_solici
            INNER JOIN cobrador ON cobrador.codigo = cta.cobrador
            INNER JOIN t_mov ON t_mov.codigo = cta.cod_mov
            WHERE cta.cobrador = '".$cobrador."' AND cta.cod_mov=1
                  AND MONTH(cta.fecha_mov) = '".$periodo_mes."' AND YEAR(cta.fecha_mov)= '".$periodo_anio."'
                  AND contratos.f_pago='".$f_pago."'
                  GROUP BY f_pago.codigo,cobrador.codigo";

    //echo '<br />'.$sql.'<br />';

    $query = mysql_query($sql);
    $salida = mysql_fetch_array($query);
    return $salida['importe'];
}


}
?>
