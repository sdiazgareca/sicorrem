<script type="text/javascript">
    $(document).ready(function () {


        $('.rut').Rut({
            on_error: function () { alert('Rut incorrecto'); }
        });


        $('#ajax3 #ingVenFree').submit(function () {

            var url_ajax = $(this).attr('action');
            var data_ajax = $(this).serialize();

            $.ajax({
                type: 'POST', url: url_ajax, cache: false, data: data_ajax, success: function (data) {
                    $('#ajax3').html(data);
                }
            })

            url_ajax = "";
            data_ajax = "";

            return false;
        });

        $(function () { $(".calendario").datepicker({ dateFormat: 'dd-mm-yy' }); });

    });


</script>

<?php
//include_once('../DAT/conf.php');
//include_once('../DAT/bd.php');
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>

<div id="ajax1">
    <h1>INGRESO UF</h1>

    <form action="INT/M_PSALU.php" method="post" id="ingVenFree" name="ingVenFree">
        <div class="caja_cabezera">

            &nbsp;INGRESO

        </div>

        <div class="caja">
            <table>
                <tr>
                    <td><strong>MES</strong></td>
                    <td>
                        <?php
                        $estado = new Select;
                        $estado->selectMesActual('mes', 'mes');
                        ?>
                    </td>
                    <td><strong>A&Ntilde;O</strong></td>
                    <td>
                        <?php
                        $estado = new Select;
                        $estado->selectAnios('anio', 'anio');
                        ?>
                    </td>
                    <td><strong>Valor</strong></td>
                    <td>
                        <input type="text" name="valor" id="valor" />
                    <td></td>
                </tr>
            </table>
        </div>
        <div class="caja_boton" align="right"><input type="submit" value="Guardar" class="boton"></div>
    </form>
</div>