<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');

?>

<form action="REAJUSTE_CONVENIOS.php" method="post">
    
    <input type="text" name="empresa" />
    <input type="submit" value="cambiar" />
    
</form>

<?


if($_POST['empresa'] > 0){
$empresa = $_POST['empresa'];

$sql = "SELECT contratos.f_ingreso, contratos.ajuste, contratos.num_solici, contratos.titular, valor_plan.valor
        FROM contratos
        INNER JOIN valor_plan ON valor_plan.cod_plan = contratos.cod_plan AND contratos.tipo_plan = valor_plan.tipo_plan AND valor_plan.secuencia = contratos.secuencia
        WHERE empresa='".$empresa."' AND f_ingreso < '2010-04-01' ";

echo '<br />'.$sql.'<br />';

$query = mysql_query($sql);

while($con = mysql_fetch_array($query)){

    $re_ajuste = round(($con['valor'] * 10 / 100),-2);

    $d="UPDATE contratos SET contratos.ajuste='".$re_ajuste."'
        WHERE contratos.num_solici='".$con['num_solici']."' and contratos.titular='".$con['titular']."'";

    echo '<p>'.$d.'</p>';

    $q = mysql_query($d);

}
}
?>
