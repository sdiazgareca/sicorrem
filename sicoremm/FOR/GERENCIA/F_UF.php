<script type="text/javascript">
    $(document).ready(function () {

        // Validación de RUT si aplica
        $('.rut').Rut({
            on_error: function () { alert('Rut incorrecto'); }
        });

        // Calendario si algún campo lo necesita
        $(".calendario").datepicker({ dateFormat: 'dd-mm-yy' });

        // Envío del formulario de ingreso UF vía AJAX
        $('#ajax3 #ff_ing_uf').submit(function () {
            var url_ajax = $(this).attr('action');
            var data_ajax = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: url_ajax,
                cache: false,
                data: data_ajax,
                success: function (data) {
                    $('#ajax3').html(data);
                }
            });

            return false;
        });

    });
</script>

<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>

<div id="ajax1">
    <h1>INGRESO UF</h1>

    <form action="INT/M_UF.php" method="post" id="ff_ing_uf" name="ff_ing_uf">
        <input type="hidden" name="ff_ing_uf" value="1" />
        
        <div class="caja_cabezera">
            &nbsp;INGRESO
        </div>

        <div class="caja">
            <table>
                <tr>
                    <td><strong>MES</strong></td>
                    <td>
                        <?php
                        $select = new Select;
                        $select->selectMesActual('mes', 'mes');
                        ?>
                    </td>
                    <td><strong>A&Ntilde;O</strong></td>
                    <td>
                        <?php
                        $select = new Select;
                        $select->selectAnios('anio', 'anio');
                        ?>
                    </td>
                    <td><strong>VALOR</strong></td>
                    <td>
                        <input type="text" name="valor" id="valor" />
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>

        <div class="caja_boton" align="right">
            <input type="submit" value="Guardar" class="boton">
        </div>
    </form>
</div>
