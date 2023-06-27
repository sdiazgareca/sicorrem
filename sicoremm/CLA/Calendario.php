<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class Calendario {

    public  $class;
    private $formato;
    public  $id;
    public  $name;

    function MuestraCalendatio($class,$formato,$id,$name){

    switch ($formato){
        case 1:
        $dateFormat = "mm-yy";
        break;

        case 2:
        $dateFormat = "dd-mm-yy";
        break;
    }

        echo '<script type="text/javascript">$(document).ready(function() {$(function() {$(".'.$class.'").datepicker({ dateFormat: "'.$dateFormat.'" });});});</script>
';

        echo '<input size="10" type="text" name="'.$name.'" class="'.$class.'" id="'.$id.'" />';

    }
}
?>
