<?php
/*
 * Baja mandatos desde archivo de texto
 */

include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>


<h1>CARGA MANDATOS CTA </h1>

<form action="upload_man.php" method="post" enctype="multipart/form-data">

<table class="table">
<tr>

    <td>
        <strong>RENDICION</strong><br /><br />
        <input type="text" name="rendicion" />
    </td>

<td>

<strong>DIA DE PAGO</strong><br /><br />

    <select name="d_pago">
        <option value=""></option>
        <option value="1">1</option>
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="25">25</option>
    </select>

</td>




<td>
<strong>PERIODO</strong><br /><br /> <input type="text" name="fecha_mov" class="calendario" size="7" />
</td>


</tr>

<tr>

<td>

    <strong>FECHA </strong><br /><br />

    <input type="text" name="fecha_f"  size="7" class="calendario3"/>

</td>

<td>
    <strong>ARCHIVO </strong><br /><br />
        <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
    <input name="userfile" type="file">
</td>



</tr>

</table>



    <input type="submit" value="Enviar" class="boton">

</form>

<?php

