<?php

 error_reporting(E_ALL);
 ini_set("display_errors", 1);

include('DAT/conf.php');
include('DAT/bd.php');


?>

<form action ="delete.php" method="post">
    
    <p><strong>Precaución Este módulo elimina los contratos.</strong></p>
    <p>Utilizar solo en caso de correguir un mal ingreso.</p>
    
    <br />
    
    <table>
        <tr>
            <td>Número de Contrato</td>
            <td><input type="text" name="num_solici" /></td>
            
             <td>Rut del Titular</td>
             <td><input type="text" name="nro_doc" /></td>
             <td><input type="submit" value="Aceptar" /></td>
        </tr>
    </table>
    
</form>

<?php

if(isset($_POST['num_solici']) && isset($_POST['nro_doc'])){
    
    foreach($_POST AS $campo=>$valor){
        if($valor == ""){
            
            echo 'Debe llenar todos campos';
            exit;
            
        }
    }
    
    $con ="SELECT contratos.num_solici FROM contratos WHERE contratos.titular=".$_POST['nro_doc'];

    $query = mysql_query($con);
    $num = mysql_num_rows($query);
    
    if($num == 1){
      
    $delete_0 = "DELETE FROM titulares WHERE titulares.nro_doc= ".$_POST['nro_doc'];        
        if (mysql_query($delete_0) ){
            echo '<br />delete titulares [OK]';
        }        
        
    }
    

    
    $sql = "select doc_pago, num_solici from contratos WHERE num_solici=".$_POST['num_solici']. ' AND titular='.$_POST['nro_doc'];
    $query = mysql_query($sql);
    
    $sql33 = "";
    
    $sal = mysql_fetch_array($query);
    
    if(is_numeric($sal['doc_pago'] == true)){
        $delete_1 = "DELETE FROM doc_f_pago WHERE doc_f_pago.numero =".$sal['doc_pago'];        
        if (mysql_query($delete_1) ){
            echo '<br />delete doc_f_pago [OK]';
        }
    }
    
    $delete_2 = "DELETE FROM afiliados WHERE afiliados.num_solici= ".$_POST['num_solici'];        
        if (mysql_query($delete_2) ){
            echo '<br />delete afiliados [OK]';
        }
        
    $delete_3 = "DELETE FROM copago WHERE numero_socio= ".$_POST['num_solici'];        
        if (mysql_query($delete_3) ){
            echo '<br />delete copago [OK]';
        }
        
    $delete_4 = "DELETE FROM contratos WHERE contratos.num_solici= ".$_POST['num_solici'];        
        if (mysql_query($delete_4) ){
            echo '<br />delete contratos [OK]';
        }
        
    $delete_5 = "DELETE FROM cta WHERE cta.num_solici= ".$_POST['num_solici'];        
        if (mysql_query($delete_5) ){
            echo '<br />delete cta [OK]';
        }  
        
    $delete_6 = "DELETE FROM domicilios WHERE domicilios.num_solici= ".$_POST['num_solici'];        
        if (mysql_query($delete_6) ){
            echo '<br />delete domicilios [OK]';
        }
        
    $delete_7 = "DELETE FROM ventas_reg WHERE ventas_reg.num_solici= ".$_POST['num_solici'];        
        if (mysql_query($delete_7) ){
            echo '<br />delete ventas_reg [OK]';
        }
        
    $delete_8 = "DELETE FROM IMG_TC WHERE IMG_TC.NUM_SOLICI= ".$_POST['num_solici'];        
        if (mysql_query($delete_8) ){
            echo '<br />delete IMG_TC [OK]';
        }
        
    $delete_9 = "DELETE FROM IMG_MANDATOS WHERE IMG_MANDATOS.NUM_SOLICI= ".$_POST['num_solici'];        
        if (mysql_query($delete_9) ){
            echo '<br />delete IMG_MANDATOS [OK]';
        } 
        
    $delete_10 = "DELETE FROM IMG_estados WHERE IMG_estados.NUM_SOLICI= ".$_POST['num_solici'];        
        if (mysql_query($delete_10) ){
            echo '<br />delete IMG_estados [OK]';
        }
        
    $delete_11 = "DELETE FROM IMG_EMPRESAS WHERE IMG_EMPRESAS.NUM_SOLICI= ".$_POST['num_solici'];        
        if (mysql_query($delete_11) ){
            echo '<br />delete IMG_EMPRESAS [OK]';
        }
        
    $delete_12 = "DELETE FROM fichas WHERE fichas.num_solici= ".$_POST['num_solici'];        
        if (mysql_query($delete_12) ){
            echo '<br />delete fichas [OK]';
        }
        
    $delete_13 = "DELETE FROM doc WHERE doc.num_solici= ".$_POST['num_solici'];        
        if (mysql_query($delete_13) ){
            echo '<br />delete doc [OK]';
        }          

        
    
}

?>