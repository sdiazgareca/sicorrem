<script type="text/javascript">
    $(document).ready(function () {

        $('#borrar').click(function () {
            $('input[name=nro_doc]').val('');
            $('input[name=descripcion]').val('');
        });

        $('#ajax #F_AUDI').submit(function () {

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

        $('#ajax1 a').click(function () {

            var ruta = $(this).attr('href');
            $('#ajax3').load(ruta);
            $.ajax({ cache: false });
            ruta = "";
            return false;
        });

    });
</script>

<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Select.php');
?>
<h1>CONFIGURACI&Oacute;N UF</h1>

<div class="caja_cabezera">UF</div>
<form action="INT/M_UF.php" method="post" id="F_AUDI" name="F_AUDI">
    <input type="text" name="ff_bus" value="1" style="display:none;" />
    <div class="caja">
        <table>
            <tr>
                <td><strong>MES</strong></td>
                <td>
                    <?php
                    $estado = new Select;
                    $estado->selectMesActual('id_mes', 'id_mes');
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
                    <input type="text" name="valor" id="valor"/>
                <td>
                    <div align="right"><input type="submit" value="Buscar" class="boton" />&nbsp;&nbsp;<input
                            type="button" value="Borrar" id="borrar" class="boton" /></div>
                </td>
            </tr>
        </table>

        <div align="left" id="link2">
            <a href="FOR/GERENCIA/F_UF.php?listado=1" class="boton2">INGRESO DE UF</a>
        </div>

    </div>

</form>
<div class="caja_cabezera">RESUMEN</div>
<div id="ajax3" class="caja"></div>