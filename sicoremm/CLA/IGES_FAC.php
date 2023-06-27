<?php
class Periodos3 {

    public $inicio = '<table border="1">';
    public $cierre = "</table>";

    public $css ='<style type="text/css">
		  table {font-family: Gill, Helvetica, sans-serif; font-size: 10pt;}
		</style>';

    public $cabecera = '<tr><td>DEV</td><td>BOLETA</td><td>FAC</td><td>CONTRATO</td><td>RUT TITULAR</td><td>F PAGO MENSUALIDAD</td><td>ESTADO</td><td>FECHA RENUNCIA</td><td>PERIODO</td><td>COBRADOR PAGO</td><td>COBRADOR ASIGNADO</td><td>COD_MOV</td><td>IMPORTE</td><td>DEBE</td><td>HABER</td><td>FECHA PAGO</td><td>FORMA DE PAGO</td></tr>';

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
                    INNER JOIN e_contrato ON e_contrato.cod = contratos.estado
                    INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
                    INNER JOIN cta ON cta.num_solici= contratos.num_solici AND contratos.titular = cta.nro_doc
                    INNER JOIN t_mov ON t_mov.codigo = cta.cod_mov
                    INNER JOIN ZOSEMA ON ZOSEMA.ZO = contratos.ZO AND ZOSEMA.SE = contratos.SE AND ZOSEMA.MA = contratos.MA
                    INNER JOIN cobrador ON cobrador.nro_doc = ZOSEMA.cobrador";


    public $convenios ="SELECT
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
                    cta.cod_mov,
                    cta.importe,
                    cta.debe,
                    cta.haber,
                    cta.fecha,
                    t_mov.corta
                    FROM contratos
                    INNER JOIN e_contrato ON e_contrato.cod = contratos.estado
                    INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
                    INNER JOIN cta ON cta.num_solici= contratos.num_solici AND contratos.titular = cta.nro_doc
                    INNER JOIN t_mov ON t_mov.codigo = cta.cod_mov
                    INNER JOIN empresa ON empresa.nro_doc = contratos.empresa";


//DEVUELVE ENTREGA CORREPONDIENTE AL MES ESPECIFICADO < ó = el uso de > BLOQUEADO
    function cob_entrega_pen($periodo,$desde,$hasta,$cobrador,$dev,$operador_periodo,$operador_cob){

        $sql = $this->query." WHERE fecha_mov ".$operador_periodo." '".$periodo."'  AND afectacion < 1
                              AND cta.cobrador='".$cobrador."' AND cobrador.codigo ".$operador_cob." '".$cobrador."' AND cod_mov='1'
                              ORDER BY cta.comprovante";

        $query = mysql_query($sql);

        while ($debe = mysql_fetch_array($query) ){

            $importe = $importe + $debe['debe'];

        }
        return $importe;
    }

    function cob_entrega_cob($periodo,$desde,$hasta,$cobrador,$dev,$operador_periodo,$operador_cob){

        $sql = $this->query." WHERE fecha_mov ".$operador_periodo." '".$periodo."'  AND afectacion > 1  AND fecha >='".$desde."'
                              AND cta.cobrador='".$cobrador."' AND cobrador.codigo ".$operador_cob." '".$cobrador."'
                              AND t_mov.operador ='H' GROUP BY cta.comprovante";

        $query = mysql_query($sql);

        while ($haber = mysql_fetch_array($query) ){

            $importe = $importe + $haber['haber'];

        }
        return $importe;
    }

    function cob_recuperado($periodo,$desde,$hasta,$cobrador,$dev,$operador_periodo,$operador_cob){

                $sql = $this->query." WHERE fecha_mov ".$operador_periodo." '".$periodo."'  AND afectacion > 1  AND fecha BETWEEN '".$desde."' AND '".$hasta."'
                              AND cta.cobrador='".$cobrador."' AND cobrador.codigo ".$operador_cob." '".$cobrador."'
                              AND t_mov.operador ='H' GROUP BY cta.comprovante";

        $query = mysql_query($sql);

        while ($haber = mysql_fetch_array($query) ){

            $importe = $importe + $haber['haber'];

        }
        return $importe;

    }

    function cob_pendiente($periodo,$periodo1,$periodo2,$cod_cobrador){

        $periodoAnterior1 = date("Y-m-01", strtotime("$periodo - 2 month"));
        $periodoAnterior2 = date("Y-m-01", strtotime("$periodo - 1 month"));

          $sql = $this->query." WHERE afectacion < 1 AND fecha_mov BETWEEN '".$periodoAnterior1."' AND '".$periodoAnterior2."' AND
                                        t_mov.operador='D' AND
                                        cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."'
                                        GROUP BY cta.num_solici, cta.nro_doc,comprovante";

          //echo '<br /><strong>'.$sql.'</strong><br />';

          $query = mysql_query($sql);

        while($detalle = mysql_fetch_array($query)){

            $monto = $monto + $detalle['debe'];

            //echo $detalle['nro_doc']."<br />";

        }

        $sql = $this->query." WHERE afectacion > 0 AND fecha_mov BETWEEN '".$periodoAnterior1."' AND '".$periodoAnterior2."' AND
                                        t_mov.operador='H' AND fecha > '".$periodo2."' AND
                                        cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."'
                                        GROUP BY cta.num_solici, cta.nro_doc,comprovante";


        //echo '<br /><strong>'.$sql.'</strong><br />';

        $query2 = mysql_query($sql);

        while($detalle = mysql_fetch_array($query2)){

            $monto = $monto + $detalle['haber'];
        }

        return $monto;



  }

//FUNCIONES FORMA DE PAGO

function ofi_entrega_pen($periodo,$desde,$hasta,$cobrador,$dev,$operador_periodo,$operador_cob,$f_pago){

        $sql = $this->query." WHERE contratos.f_pago = '".$f_pago."' AND fecha_mov ".$operador_periodo." '".$periodo."'  AND afectacion < 1
                              AND cta.cobrador='".$cobrador."' AND cobrador.codigo ".$operador_cob." '".$cobrador."' AND cod_mov='1'
                              ORDER BY cta.comprovante";


        $query = mysql_query($sql);

        //echo '<table>';
        while ($debe = mysql_fetch_array($query) ){

            $importe = $importe + $debe['debe'];
            //echo $debe['titular']." ".$debe['num_solici']." ".$debe['comprovante']."<br />";

            //echo "<tr/><td>".$debe['titular']."</td><td>".$debe['num_solici']."</td><td>".$debe['comprovante']."</td><td>".$debe['fecha_mov']."</td><td>".$debe['importe']."</td></tr>";

        }
        //echo '</table>';
        return $importe;

  }

function ofi_entrega_cob($periodo,$desde,$hasta,$cobrador,$dev,$operador_periodo,$operador_cob,$f_pago){

        $sql = $this->query." WHERE contratos.f_pago = '".$f_pago."' AND  fecha_mov ".$operador_periodo." '".$periodo."'  AND afectacion > 1  AND fecha >='".$desde."'
                              AND cta.cobrador='".$cobrador."' AND cobrador.codigo ".$operador_cob." '".$cobrador."'
                              AND t_mov.operador ='H' GROUP BY cta.comprovante";


        //echo 'ofi_entrega_cob <strong>'.$sql.'<strong>';

        $query = mysql_query($sql);

        //echo '<table>';
        while ($haber = mysql_fetch_array($query) ){

            $importe = $importe + $haber['haber'];

            //echo "<tr/><td>".$haber['titular']."</td><td>".$haber['num_solici']."</td><td>".$haber['comprovante']."</td><td>".$haber['fecha_mov']."</td></tr>";
            //echo "<tr/><td>".$haber['titular']."</td><td>".$haber['num_solici']."</td><td>".$haber['comprovante']."</td></tr>";

        }
        //echo '</table>';
        return $importe;
    }


function ofi_recuperado($periodo,$desde,$hasta,$cobrador,$dev,$operador_periodo,$operador_cob,$f_pago){

                $sql = $this->query." WHERE contratos.f_pago = '".$f_pago."' AND fecha_mov ".$operador_periodo." '".$periodo."'  AND afectacion > 1  AND fecha BETWEEN '".$desde."' AND '".$hasta."'
                              AND cta.cobrador='".$cobrador."' AND cobrador.codigo ".$operador_cob." '".$cobrador."'
                              AND t_mov.operador ='H' GROUP BY cta.comprovante";


                //echo '<br /><strong>'.$sql.'</strong><br />';

        $query = mysql_query($sql);

        while ($haber = mysql_fetch_array($query) ){

            $importe = $importe + $haber['haber'];

        }
        return $importe;

    }

function ofi_pendiente($periodo,$periodo1,$periodo2,$cod_cobrador,$f_pago){

        $periodoAnterior1 = date("Y-m-01", strtotime("$periodo - 2 month"));
        $periodoAnterior2 = date("Y-m-01", strtotime("$periodo - 1 month"));

          $sql = $this->query." WHERE contratos.f_pago ='".$f_pago."' AND afectacion < 1 AND fecha_mov BETWEEN '".$periodoAnterior1."' AND '".$periodoAnterior2."' AND
                                        t_mov.operador='D' AND
                                        cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."'
                                        GROUP BY cta.num_solici, cta.nro_doc,comprovante";

          //echo '<br /><strong>'.$sql.'</strong><br />';

          $query = mysql_query($sql);

        while($detalle = mysql_fetch_array($query)){

            $sql2 = "SELECT COUNT(cta.importe) AS num FROM cta WHERE cta.num_solici='".$detalle['num_solici']."' and cta.nro_doc='".$detalle['titular']."' and comprovante='".$detalle['comprovante']."' AND YEAR(fecha) >= 2010 AND afectacion < 1";
            $query2 = mysql_query($sql2);
            $num = mysql_fetch_array($query2);

        //echo '<table>';
        while($detalle = mysql_fetch_array($query2)){

            $monto = $monto + $detalle['haber'];
            //echo "<tr/><td>".$detalle['titular']."</td><td>".$detalle['num_solici']."</td><td>".$detalle['comprovante']."</td><td>".$detalle['fecha_mov']."</td><td>".$detalle['importe']."</td></tr>";
        }
        //echo '</table>';

            if($num['num'] >= 2){
               $monto = $monto + 0;
            }
            else{
            $monto = $monto + $detalle['debe'];
            }
        }

        $sql = $this->query." WHERE contratos.f_pago ='".$f_pago."' AND  afectacion > 0 AND fecha_mov BETWEEN '".$periodoAnterior1."' AND '".$periodoAnterior2."' AND
                                        t_mov.operador='H' AND fecha > '".$periodo2."' AND
                                        cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."'
                                        GROUP BY cta.num_solici, cta.nro_doc,comprovante";


        //echo '<br /><strong>'.$sql.'</strong><br />';

        $query2 = mysql_query($sql);

        //echo '<table>';
        while($detalle = mysql_fetch_array($query2)){

            $monto = $monto + $detalle['haber'];
           // echo "<tr/><td>".$detalle['titular']."</td><td>".$detalle['num_solici']."</td><td>".$detalle['comprovante']."</td><td>".$detalle['fecha_mov']."</td><td>".$detalle['importe']."</td></tr>";
        }
        //echo '</table>';

        return $monto;



  }


//EVENTOS TRASLADOS MEDIMEL

  function eve($categoria,$periodo){
      $sql ="SELECT SUM(monto + iva) AS monto FROM eventos WHERE categoria = '".$categoria."' AND MONTH(fecha)=MONTH('".$periodo."') AND YEAR(fecha)=YEAR('".$periodo."')";
      //echo $sql;
      $query = mysql_query($sql);
      $monto = mysql_fetch_array($query);
      return $monto['monto'];
  }

  function copagos($periodo){
      $sql = "SELECT SUM(copago.importe) AS importe FROM copago WHERE copago.rendicion > 0 AND MONTH(fecha)=MONTH('".$periodo."') AND YEAR(fecha)=YEAR('".$periodo."')";
      

      $query = mysql_query($sql);
      $monto = mysql_fetch_array($query);
      return $monto['importe'];
  }

  function dicom($periodo){
      $sql ="SELECT SUM(monto) AS monto FROM dicom WHERE MONTH(fecha)=MONTH('".$periodo."') AND YEAR(fecha)=YEAR('".$periodo."')";
      //echo $sql;
      $query = mysql_query($sql);
      $monto = mysql_fetch_array($query);
      return $monto['monto'];
  }


  function convenios_entrega_pen($periodo,$desde,$hasta,$cobrador,$dev,$operador_periodo,$operador_cob,$f_pago){
              $sql = $this->convenios." WHERE contratos.f_pago = '".$f_pago."' AND fecha_mov ".$operador_periodo." '".$periodo."'  AND afectacion < 1
                              AND cod_mov='1'
                              ORDER BY cta.comprovante";


        $query = mysql_query($sql);

        while ($debe = mysql_fetch_array($query) ){

            $importe = $importe + $debe['debe'];

        }
        return $importe;

  }

function convenio_entrega_cob($periodo,$desde,$hasta,$cobrador,$dev,$operador_periodo,$operador_cob,$f_pago){

        $sql = $this->convenios." WHERE contratos.f_pago = '".$f_pago."' AND  fecha_mov ".$operador_periodo." '".$periodo."'  AND afectacion > 1  AND fecha >='".$desde."'
                              AND t_mov.operador ='H' GROUP BY cta.num_solici, cta.nro_doc,comprovante";


        //echo 'ofi_entrega_cob <strong>'.$sql.'<strong>';

        $query = mysql_query($sql);

        while ($haber = mysql_fetch_array($query) ){

            $importe = $importe + $haber['haber'];

        }
        return $importe;
    }

function convenio_ofi_recuperado($periodo,$desde,$hasta,$cobrador,$dev,$operador_periodo,$operador_cob,$f_pago){

                $sql = $this->convenios." WHERE contratos.f_pago = '".$f_pago."' AND fecha_mov ".$operador_periodo." '".$periodo."'  AND afectacion > 1  AND fecha BETWEEN '".$desde."' AND '".$hasta."'
                              AND t_mov.operador ='H' GROUP BY cta.num_solici, cta.nro_doc,comprovante";


                //echo '<br /><strong>'.$sql.'</strong><br />';

        $query = mysql_query($sql);

        while ($haber = mysql_fetch_array($query) ){

            $importe = $importe + $haber['haber'];

        }
        return $importe;

    }

function convenios_ofi_pendiente($periodo,$periodo1,$periodo2,$cod_cobrador,$f_pago){

        $periodoAnterior1 = date("Y-m-01", strtotime("$periodo - 2 month"));
        $periodoAnterior2 = date("Y-m-01", strtotime("$periodo - 1 month"));

          $sql = $this->convenios." WHERE contratos.f_pago ='".$f_pago."' AND afectacion < 1 AND fecha_mov BETWEEN '".$periodoAnterior1."' AND '".$periodoAnterior2."' AND
                                        t_mov.operador='D'
                                        GROUP BY cta.num_solici, cta.nro_doc,comprovante";

          $query = mysql_query($sql);

          //echo '<table>';
        while($detalle = mysql_fetch_array($query)){

            $sql2 = "SELECT COUNT(cta.importe) AS num FROM cta WHERE cta.num_solici='".$detalle['num_solici']."' and cta.nro_doc='".$detalle['titular']."' and comprovante='".$detalle['comprovante']."' AND YEAR(fecha) >= 2010 AND afectacion < 1";
            $query2 = mysql_query($sql2);
            $num = mysql_fetch_array($query2);

            //echo "<tr/><td>".$detalle['titular']."</td><td>".$detalle['num_solici']."</td><td>".$detalle['comprovante']."</td><td>".$detalle['fecha_mov']."</td><td>".$detalle['haber']."</td></tr>";
            //echo '<br />'.$sql2.'<br />';

            if($num['num'] >= 2){
               $monto = $monto + 0;
            }
            else{
            $monto = $monto + $detalle['debe'];
            }
        }

        //echo '</table>';

        $sql = $this->convenios." WHERE contratos.f_pago ='".$f_pago."' AND  afectacion > 0 AND fecha_mov BETWEEN '".$periodoAnterior1."' AND '".$periodoAnterior2."' AND
                                        t_mov.operador='H' AND fecha > '".$periodo2."' GROUP BY cta.num_solici, cta.nro_doc,comprovante";


        //echo '<br /><strong>'.$sql.'</strong><br />';

        $query2 = mysql_query($sql);

        while($detalle = mysql_fetch_array($query2)){

            $monto = $monto + $detalle['haber'];
        }

        return $monto;



  }

}
?>
