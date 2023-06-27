<?php


class Periodos {
   
    public $queryPagos = 'SELECT
                          cta.DEV,
                          afectacion,DATE_FORMAT(cta.fecha, "%d-%m-%Y") AS fecha_pago,
                          cta.comprovante,cobrador.codigo AS cod_cobrador,
                          DATE_FORMAT(contratos.f_ingreso, "%d-%m-%Y") AS f_ingreso,
                          cta.nro_doc,
                          cta.debe,
                          cta.haber,
                          cta.cod_mov,
                          contratos.tipo_plan,
                          contratos.f_pago,
                          cta.rendicion AS rend,
                          fecha_mov, 
                          fecha,
                          cta.importe AS importe, 
                          t_mov.larga,t_mov.codigo 
                          
                          FROM cta 
                          
                          INNER JOIN t_mov ON t_mov.codigo = cta.cod_mov 
                          INNER JOIN contratos ON contratos.num_solici = cta.num_solici AND cta.nro_doc = contratos.titular
                          INNER JOIN ZOSEMA ON contratos.ZO = ZOSEMA.ZO AND contratos.SE = ZOSEMA.SE AND contratos.MA = ZOSEMA.MA
                          INNER JOIN cobrador ON ZOSEMA.cobrador = cobrador.nro_doc';

    public $table ='<table class="table2" border="1">';
    public $table_cierre = "</table>";
    public $cabecera = "<tr><th></th><th>ENTREGA</th><th>COBRADO</th><th>AJUSTE</th><th>MOROSO</th><th>SALDO</th><th>%</th></tr>";
    public $cabecera_tabla = "<tr><td><strong>RUT</strong></td><td><strong>F_INGRESO</strong></td><td><strong>COB</strong></td><td><strong>N</strong></td><td><strong>PERIODO</strong></td><td><strong>F PAGO</strong></td><td><strong>IMPORTE</strong></td><td><strong>ESTADO</strong></td><td>DEV</td></tr>";

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

    function tableDetalle($nro_doc,$f_ingreso,$cobrador,$comprovante,$fecha_mov,$fecha_pago,$importe,$estado,$dev){
        echo '<tr><td>'.$nro_doc.'</td><td>'.$f_ingreso.'</td><td>'.$cobrador.'</td><td>'.$comprovante.'</td><td>'.$fecha_mov.'</td><td>'.$fecha_pago.'</td><td style="text-align:right">'.number_format($importe,0,',','.').'</td><td>'.$estado.'</td><td>'.$dev.'</td></tr>';
    }

    function entregaActual($periodo,$periodo1,$periodo2,$cod_cobrador,$tabla){

        $sql = $this->queryPagos." WHERE t_mov.operador='D' AND fecha_mov = '".$periodo."' AND
                                   afectacion < 1 AND
                                   cta.cobrador='".$cod_cobrador."' ORDER BY comprovante";

        $query = mysql_query($sql);

        $monto = 0;

        if($tabla == 1){
            echo $this->table;
            echo $this->cabecera_tabla;
        }

        while($detalle = mysql_fetch_array($query)){

            if($tabla == 1){

              $DEV = $this->Devolucion($detalle['DEV']);
              $afectacion = $this->Estado($detalle['afectacion']);

              $this->tableDetalle($detalle['nro_doc'], $detalle['f_ingreso'], $detalle['cod_cobrador'], $detalle['comprovante'], $detalle['fecha_mov'], $detalle['fecha_pago'], $detalle['debe'],$afectacion,$DEV);
            }
            
            $monto = $monto + $detalle['debe'];


        }

        $sql = $this->queryPagos." WHERE t_mov.operador='H' AND fecha_mov = '".$periodo."' AND
                                   cta.fecha BETWEEN '".$periodo1."' AND '".$periodo2."' AND 
                                   cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."' ORDER BY comprovante";

        //echo '<br />'.$sql.'<br />';
        
        $query = mysql_query($sql);

         while($detalle2 = mysql_fetch_array($query)){

            if($tabla == 1){

              $DEV = $this->Devolucion($detalle2['DEV']);
              $afectacion = $this->Estado($detalle2['afectacion']);

              $this->tableDetalle($detalle2['nro_doc'], $detalle2['f_ingreso'], $detalle2['cod_cobrador'], $detalle2['comprovante'], $detalle2['fecha_mov'], $detalle2['fecha_pago'], $detalle2['haber'],$afectacion,$DEV);
            }
            
            $monto = $monto + $detalle2['haber'];

        }

        $sql = $this->queryPagos." WHERE t_mov.operador='H' AND fecha_mov = '".$periodo."' AND
                                   cta.fecha > '".$periodo2."' AND
                                   cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."' ORDER BY comprovante";

        $query = mysql_query($sql);

         while($detalle3 = mysql_fetch_array($query)){

            if($tabla == 1){

              $DEV = $this->Devolucion($detalle3['DEV']);
              $afectacion = $this->Estado(0);

              $this->tableDetalle($detalle3['nro_doc'], $detalle3['f_ingreso'], $detalle3['cod_cobrador'], $detalle3['comprovante'], $detalle3['fecha_mov'], $detalle3['fecha_pago'], $detalle3['haber'],$afectacion,$DEV);
            }

            $monto = $monto + $detalle3['haber'];

        }

        if($tabla == 1){
            echo $this->table_cierre;
        }

        return $monto;

  }

    function entregaAnterior($periodo,$periodo1,$periodo2,$cod_cobrador,$tabla){

        $periodoAnterior1 = date("Y-m-01", strtotime("$periodo - 2 month"));
        $periodoAnterior2 = date("Y-m-01", strtotime("$periodo - 1 days"));

          $sql = $this->queryPagos." WHERE  (contratos.f_baja='0000-00-00' || contratos.f_baja < '".$periodo1."' ) AND cta.fecha_mov BETWEEN '".$periodoAnterior1."' AND '".$periodoAnterior2."' AND
                                        t_mov.operador='D' AND (afectacion < 1 || fecha BETWEEN '".$periodo1."' AND '".$periodo2."') AND
                                        cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."' 
                                        GROUP BY cta.num_solici, cta.nro_doc,comprovante";



          $query = mysql_query($sql);

        $monto = 0;

        if($tabla == 1){
            echo $this->table;
            echo $this->cabecera_tabla;
        }

        while($detalle = mysql_fetch_array($query)){


            if($tabla == 1){

              $DEV = $this->Devolucion($detalle['DEV']);
              $afectacion = $this->Estado($detalle['afectacion']);

             $this->tableDetalle($detalle['nro_doc'], $detalle['f_ingreso'], $detalle['cod_cobrador'], $detalle['comprovante'], $detalle['fecha_mov'], $detalle['fecha_pago'], $detalle['debe'],$afectacion,$DEV);
            
             
            }

            $monto = $monto + $detalle['debe'];


        }


          $sql = $this->queryPagos." WHERE  cta.fecha_mov BETWEEN '".$periodoAnterior1."' AND '".$periodoAnterior2."' AND
                                        t_mov.operador='H' AND (afectacion > 0 && fecha > '".$periodo2."') AND
                                        cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."'
                                        GROUP BY cta.num_solici, cta.nro_doc,comprovante";

        $query = mysql_query($sql);

        while($detalle2 = mysql_fetch_array($query)){


            if($tabla == 1){

              $DEV = $this->Devolucion($detalle2['DEV']);
              $afectacion = $this->Estado($detalle2['afectacion']);

             $this->tableDetalle($detalle2['nro_doc'], $detalle2['f_ingreso'], $detalle2['cod_cobrador'], $detalle2['comprovante'], $detalle2['fecha_mov'], $detalle2['fecha_pago'], $detalle2['haber'],$afectacion,$DEV);


            }

            $monto = $monto + $detalle2['haber'];


        }

        if($tabla == 1){
            echo $this->table_cierre;
        }

        return $monto;

  }

  //$operador = muestra periodo actual < periodo anterior
  //Discrimina entre periodo actual y anterior
    function TotalCobrado($periodo,$periodo1,$periodo2,$cod_cobrador,$tabla,$operador){

         $sql = $this->queryPagos." WHERE cta.fecha BETWEEN '".$periodo1."' AND '".$periodo2."' AND
                                   t_mov.operador='H' AND afectacion > 0 AND fecha_mov ".$operador." '".$periodo."' AND
                                   cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."'";

        $query = mysql_query($sql);

        $monto = 0;

       if($tabla == 1){
            echo $this->table;
            echo $this->cabecera_tabla;
        }

        while($detalle = mysql_fetch_array($query)){


            if($tabla == 1){

              $DEV = $this->Devolucion($detalle['DEV']);
              $afectacion = $this->Estado($detalle['afectacion']);

             $this->tableDetalle($detalle['nro_doc'], $detalle['f_ingreso'], $detalle['cod_cobrador'], $detalle['comprovante'], $detalle['fecha_mov'], $detalle['fecha_pago'], $detalle['haber'],$afectacion,$DEV);


            }

            $monto = $monto + $detalle['haber'];


        }
        if($tabla == 1){
            echo $this->table_cierre;
        }

        return $monto;

    }



  //OFICINA

     function entregaOficina($periodo,$periodo1,$periodo2,$cod_cobrador,$fpago,$operador){

        $sql = $this->queryPagos." WHERE cta.fecha_mov  ".$operador." '".$periodo."' AND
                                   t_mov.operador='D'  AND contratos.fpago='".$fpago."' AND
                                   cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."'";

        $query = mysql_query($sql);

        $monto = 0;

        while($detalle = mysql_fetch_array($query)){

            $monto = $monto + $detalle['importe'];


        }

        return $monto;

  }

     function cobradoOficina($periodo,$periodo1,$periodo2,$cod_cobrador,$fpago,$operador){

        $sql = $this->queryPagos." WHERE cta.fecha BETWEEN '".$periodo1."' AND '".$periodo2."' AND contratos.estado = '".$fpago."' AND
                                   t_mov.operador='D' AND fecha_mov ".$operador." '".$periodo."' AND
                                   cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."'";

        //echo '<br />'.$sql.'<br />';

        $query = mysql_query($sql);

        $monto = 0;

        while($detalle = mysql_fetch_array($query)){

            $monto = $monto + $detalle['importe'];


        }

        return $monto;

  }

function entregaActualOficina($periodo,$periodo1,$periodo2,$cod_cobrador,$tabla,$fpago){

        $sql = $this->queryPagos." WHERE contratos.f_pago='".$fpago."' AND t_mov.operador='D' AND fecha_mov = '".$periodo."' AND
                                   afectacion < 1 AND
                                   cta.cobrador='".$cod_cobrador."' ORDER BY comprovante";

        $query = mysql_query($sql);

        $monto = 0;

        if($tabla == 1){
            echo $this->table;
            echo $this->cabecera_tabla;
        }

        while($detalle = mysql_fetch_array($query)){

            if($tabla == 1){

              $DEV = $this->Devolucion($detalle['DEV']);
              $afectacion = $this->Estado($detalle['afectacion']);

              $this->tableDetalle($detalle['nro_doc'], $detalle['f_ingreso'], $detalle['cod_cobrador'], $detalle['comprovante'], $detalle['fecha_mov'], $detalle['fecha_pago'], $detalle['debe'],$afectacion,$DEV);
            }

            $monto = $monto + $detalle['debe'];


        }

        $sql = $this->queryPagos." WHERE contratos.f_pago='".$fpago."' AND  t_mov.operador='H' AND fecha_mov = '".$periodo."' AND
                                   cta.fecha BETWEEN '".$periodo1."' AND '".$periodo2."' AND
                                   cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."' ORDER BY comprovante";

        //echo '<br />'.$sql.'<br />';

        $query = mysql_query($sql);

         while($detalle2 = mysql_fetch_array($query)){

            if($tabla == 1){

              $DEV = $this->Devolucion($detalle2['DEV']);
              $afectacion = $this->Estado($detalle2['afectacion']);

              $this->tableDetalle($detalle2['nro_doc'], $detalle2['f_ingreso'], $detalle2['cod_cobrador'], $detalle2['comprovante'], $detalle2['fecha_mov'], $detalle2['fecha_pago'], $detalle2['haber'],$afectacion,$DEV);
            }

            $monto = $monto + $detalle2['haber'];

        }

        $sql = $this->queryPagos." WHERE contratos.f_pago='".$fpago."' AND t_mov.operador='H' AND fecha_mov = '".$periodo."' AND
                                   cta.fecha > '".$periodo2."' AND
                                   cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."' ORDER BY comprovante";

        $query = mysql_query($sql);

         while($detalle3 = mysql_fetch_array($query)){

            if($tabla == 1){

              $DEV = $this->Devolucion($detalle3['DEV']);
              $afectacion = $this->Estado(0);

              $this->tableDetalle($detalle3['nro_doc'], $detalle3['f_ingreso'], $detalle3['cod_cobrador'], $detalle3['comprovante'], $detalle3['fecha_mov'], $detalle3['fecha_pago'], $detalle3['haber'],$afectacion,$DEV);
            }

            $monto = $monto + $detalle3['haber'];

        }

        if($tabla == 1){
            echo $this->table_cierre;
        }

        return $monto;

  }

function entregaAnteriorOficina($periodo,$periodo1,$periodo2,$cod_cobrador,$tabla,$fpago){

        $periodoAnterior1 = date("Y-m-01", strtotime("$periodo - 2 month"));
        $periodoAnterior2 = date("Y-m-01", strtotime("$periodo - 1 days"));

          $sql = $this->queryPagos." WHERE contratos.f_pago='".$fpago."' AND (contratos.f_baja='0000-00-00' || contratos.f_baja < '".$periodo1."' ) AND cta.fecha_mov BETWEEN '".$periodoAnterior1."' AND '".$periodoAnterior2."' AND
                                        t_mov.operador='D' AND (afectacion < 1 || fecha BETWEEN '".$periodo1."' AND '".$periodo2."') AND
                                        cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."' 
                                        GROUP BY cta.num_solici, cta.nro_doc,comprovante";

//echo $sql;

          $query = mysql_query($sql);

        $monto = 0;

        if($tabla == 1){
            echo $this->table;
            echo $this->cabecera_tabla;
        }

        while($detalle = mysql_fetch_array($query)){


            if($tabla == 1){

              $DEV = $this->Devolucion($detalle['DEV']);
              $afectacion = $this->Estado($detalle['afectacion']);

             $this->tableDetalle($detalle['nro_doc'], $detalle['f_ingreso'], $detalle['cod_cobrador'], $detalle['comprovante'], $detalle['fecha_mov'], $detalle['fecha_pago'], $detalle['debe'],$afectacion,$DEV);
            
             
            }

            $monto = $monto + $detalle['debe'];


        }


          $sql = $this->queryPagos." WHERE contratos.f_pago='".$fpago."' AND cta.fecha_mov BETWEEN '".$periodoAnterior1."' AND '".$periodoAnterior2."' AND
                                        t_mov.operador='H' AND (afectacion > 0 && fecha > '".$periodo2."') AND
                                        cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."'
                                        GROUP BY cta.num_solici, cta.nro_doc,comprovante";

        $query = mysql_query($sql);

        while($detalle2 = mysql_fetch_array($query)){


            if($tabla == 1){

              $DEV = $this->Devolucion($detalle2['DEV']);
              $afectacion = $this->Estado($detalle2['afectacion']);

             $this->tableDetalle($detalle2['nro_doc'], $detalle2['f_ingreso'], $detalle2['cod_cobrador'], $detalle2['comprovante'], $detalle2['fecha_mov'], $detalle2['fecha_pago'], $detalle2['haber'],$afectacion,$DEV);


            }

            $monto = $monto + $detalle2['haber'];


        }

        if($tabla == 1){
            echo $this->table_cierre;
        }

        return $monto;

  }

function TotalCobradoOficina($periodo,$periodo1,$periodo2,$cod_cobrador,$tabla,$operador,$fpago){

         $sql = $this->queryPagos." WHERE contratos.f_pago= '".$fpago."'AND cta.fecha BETWEEN '".$periodo1."' AND '".$periodo2."' AND
                                   t_mov.operador='H' AND afectacion > 0 AND fecha_mov ".$operador." '".$periodo."' AND
                                   cta.cobrador='".$cod_cobrador."' AND cobrador.codigo='".$cod_cobrador."'";

        $query = mysql_query($sql);

        $monto = 0;

       if($tabla == 1){
            echo $this->table;
            echo $this->cabecera_tabla;
        }

        while($detalle = mysql_fetch_array($query)){


            if($tabla == 1){

              $DEV = $this->Devolucion($detalle['DEV']);
              $afectacion = $this->Estado($detalle['afectacion']);

             $this->tableDetalle($detalle['nro_doc'], $detalle['f_ingreso'], $detalle['cod_cobrador'], $detalle['comprovante'], $detalle['fecha_mov'], $detalle['fecha_pago'], $detalle['haber'],$afectacion,$DEV);


            }

            $monto = $monto + $detalle['haber'];


        }
        if($tabla == 1){
            echo $this->table_cierre;
        }

        return $monto;

    }

}
?>
