<form action="procesa_editor.php" method="post" enctype="multipart/form-data">
    <h3>Editor Pagos Bancarios</h3>
    <table>
        
        <tr>     
        <td><b>Periodo formato</b></td>
        <td><input type="text" name="periodo" /> yyyy-mm-dd</td>
        </tr>

        <tr>
        <td><b>Rendicion </b></td>
        <td><input type="text" name="rendicion" /></td>
        </tr>

        <tr>
        <td><b>Fecha de pago</b></td>
        <td><input type="text" name="f_pago" /> yyyy-mm-dd</td>
        </tr>


        <tr>
        <td><b>Archivo</b></td>
        <td><input name="userfile" type="file"></td>
        </tr>

    </table>

    <input type="submit" value="Enviar">

</form>

<?php

