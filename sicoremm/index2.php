<?php
include('DAT/conf.php');
include('DAT/bd.php');

if (!$_SESSION['identificador'] && isset($_POST['cod_usuario']) && isset($_POST['clave'])) {

  $sql = "SELECT cod_usuario, usuarios.nombre, usuarios.apellido
            FROM usuarios WHERE usuarios.cod_usuario ='" . $_POST['cod_usuario'] . "' AND usuarios.clave='" . $_POST['clave'] . "'";

  //echo '<br />'.$sql.'<br />';

  $query = mysql_query($sql);
  $num = mysql_num_rows($query);
  $usuario = mysql_fetch_array($query);

  if ($num == 0) {
    $error = '<br /><br /><div class="mensaje2">Error: clave no valida...</div>';
  }

  if ($num > 0) {

    $_SESSION["identificador"] = 1;
  } else {

    $_SESSION["identificador"] = 0;
  }
}
?>


<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>SICOREMM</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script type="text/javascript" src="JS/jquery/jquery.js"></script>
  <script type="text/javascript" src="JS/jquery/jqueryRut.js"></script>
  <script type="text/javascript" src="JS/jquery/Jquery.Rut.min.js"></script>
  <script type="text/javascript" src="JS/DISP.js"></script>
  <script type="text/javascript" src="JS/calendar/development-bundle/ui/jquery.ui.core.js"></script>
  <script type="text/javascript" src="JS/calendar/development-bundle/ui/jquery.ui.widget.js"></script>
  <script type="text/javascript" src="JS/calendar/development-bundle/ui/jquery.ui.datepicker.js"></script>


  <!--<script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/validate/jquery.validate.js"></script>-->


  <link type="text/css" rel="stylesheet" href="JS/calendar/development-bundle/themes/base/jquery.ui.all.css" />
  <link href="CSS/estructura.css" rel="stylesheet" type="text/css" />
  <link href="CSS/fuentes.css" rel="stylesheet" type="text/css" />
  <link href="CSS/menu.css" rel="stylesheet" type="text/css" />
  <link href="CSS/main.css" rel="stylesheet" type="text/css" />
</head>

<body>


  <?php
  if ($_SESSION["identificador"] > 0) {
    ?>

    <div id="contenedor">
      <div id="cabezera">

        <table width="100%">
          <tr>
            <td align="left"><img src="IMG/L1.jpg" /</td>
            <td align="right"><a href="MAUAL_SICOREMM.pdf" class="enlace"><span>Manual</span></a></td>
          </tr>
        </table>

      </div><!-- cabezera -->

      <div class="usuario">Usuario: <strong><?php echo $usuario['nombre'] . ' ' . $usuario['apellido']; ?></strong></div>
      <!-- usuario -->
      <div id="contenido">

        <div id="tabs1">
          <?php
          $modulos_sql = "select cod_modulo,modulo_nombre FROM privilegios WHERE cod_usuario='" . $usuario['cod_usuario'] . "' GROUP BY modulo_nombre";
          $modulos_query = mysql_query($modulos_sql);
          echo "<ul>";
          while ($modulos = mysql_fetch_array($modulos_query)) {
            ?>
            <li><a
                href="MEN/m_link.php?modulo=<?php echo $modulos['cod_modulo']; ?>&cod_usuario=<?php echo $usuario['cod_usuario']; ?>"
                class="enlace"><span><?php echo $modulos['modulo_nombre']; ?></span></a></li>
            <?php
          }

          echo "</ul>";
          ?>
        </div>


        <br /><br />
        <div id="cargando_imagen">
          <img alt="" src="IMG/C3.gif" />
          <br />
          Espere...
        </div>

        <div id="ajax">
          <div align="right">
            <img src="IMG/I2.PNG" />
          </div>

        </div><!-- ajax -->
      </div><!-- contenido -->
    </div><!-- contenedor -->
    <?php
  } else {
    ?>
    <div id="contenedor">
      <div id="cabezera">

        <table width="100%">
          <tr>
            <td align="left"><img src="IMG/L1.jpg" /></td>
            <td align="right">&nbsp;</td>
          </tr>
        </table>

      </div><!-- cabezera -->


      <div id="contenido">
        <div class="usuario">&nbsp;</div><!-- usuario -->
        <div id="tabs1">&nbsp;</div>
        <div id="ajax">

          <h1>SICOREMM</h1>

          <form action='index2.php' method="post" name="validacion">

            <table class="table2" align="center" style=" font-size: 14px; font-weight: bold;">
              <tr>
                <td>
                  <table>
                    <tr>
                      <td><label class='etiqueta-entrada'>Usuario&nbsp;</label></td>
                      <td><input name='cod_usuario' type="text" maxlength="5" /><br /></td>
                    </tr>

                    <tr>
                      <td><label class="etiqueta-entrada">Clave&nbsp;</label></td>
                      <td><input type="password" name="clave" maxlength="6" /><br /></td>
                    </tr>

                    <tr>
                      <td>&nbsp;</td>
                      <td>
                        <div align="right"><input type="submit" value="Entrar" class="boton" /></div>
                      </td>
                    </tr>

                  </table>
                </td>
              </tr>
            </table>
          </form>
          <?php echo $error; ?>
        </div>
      </div><!-- contenido -->
    </div><!-- contenedor -->
    <?php
  }
  ?>
</body>

</html>