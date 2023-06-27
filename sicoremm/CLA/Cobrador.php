<?php

class Cobrador {

    function SelectCobrador($name,$id){

        $select_sql ="SELECT nombre1, apellidos, nro_doc, codigo FROM cobrador";
        $select_query = mysql_query($select_sql);

        echo "<select name='".$name."' id='".$id."'>";


        while($cobrador = mysql_fetch_array($select_query)){
            echo "<option value='".$cobrador['codigo']."'>".$cobrador['apellidos']." ".$cobrador['nombre1']."</option>";
        }

        echo "</select>";

    }
}
?>
