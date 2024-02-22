<html>
<head>
<link rel="stylesheet" href="../principal/estilos/css_ref_web.css">
<title>Sistema Calculo Subsidio e Incapacidad Laboral</title>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
function Salir()
{
	window.close();
}
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0";>
<form name="form1" method="post" action="">
  <? include("../principal/encabezado.php");?>
  <div id="Layer1" style="position:absolute; left:238px; top:54px; width:528px; height:308px; z-main:1; overflow: auto;"> 
    <? if ($valor == ""){
		 $valor = "intro.php";
		 }
	include($valor);?>
  </div>
  <table width="770" height="306" bordercolor="#000066" background="../principal/imagenes/fondo3.gif" class="Borde">
    <tr valign="top" > 
      <td width="225"><img src="../principal/imagenes/menu.gif" width="223" height="306"> 
	  <input name="valor_rut" type="hidden">
        <div style="position:absolute; left: 22px; width: 203px; height: 246px; top: 109px;overflow:auto;"> 
          <table border="0" width="100%" cellpadding="5" cellspacing="0" class="menu">
            <tr> <img src="../principal/imagenes/icono_menu.gif" width="20"> <a href='main.php?valor=info_mensual.php'target='_parent'> 
              <font color="#FFFF00"><strong>Ingreso Datos Mensuales<br> (UF - Impuesto &Uacute;nico).</strong></font> </a> </tr>
            <tr></tr>
            <tr> <img src="../principal/imagenes/icono_menu.gif" width="20"> <a href='main.php?valor=previcion.php' target='_parent' class='Links01'> 
              <font color="#ffff00" ><strong>Ingreso Datos Previcionales<br> (AFP - Isapre - Fonasa).</strong></font> </a><a href='dotacion.php?tipo=1' target='_parent' class='Links01'></a> 
            </tr>
            <tr></tr>
            <tr><img src="../principal/imagenes/icono_menu.gif" width="20"> <a href='main.php?valor=intro.php' target ='_parent' > 
              <strong><font color="#ffff00"><strong>Modificación Datos.</strong></font></strong> 
              </a> </tr>
            <tr></tr>
            <tr><br><img src="../principal/imagenes/icono_menu.gif" width="20"> <a href='main.php?valor=ing_trab.php' target='_parent' class='Links01'> 
              <strong><font color="#ffff00"><strong>Ingreso Datos Trabajador Accidentado.</strong></font></strong> 
              </a> </tr>
            <tr><img src="../principal/imagenes/icono_menu.gif" width="20"> <a href='main.php?valor=valor_diario.php' target='_parent' class='Links01'> 
              <strong><font color="#ffff00"><strong>Calculo del Subsidio e Incapacidad Laboral.</strong></font></strong> 
              </a> </tr>
			  <tr><img src="../principal/imagenes/icono_menu.gif" width="20"> <a href='main.php?valor=intro.php' target ='_parent' > 
              <strong><font color="#ffff00"><strong>Modificación Datos.</strong></font></strong> 
              </a> </tr>
			  <tr><br><img src="../principal/imagenes/icono_menu.gif" width="20"> <a href='main.php?valor=informes.php' target ='_parent' > 
              <strong><font color="#ffff00"><strong>Informes.</strong></font></strong> 
              </a> </tr>
			  <tr><img src="../principal/imagenes/icono_menu.gif" width="20"> <a href='main.php?valor=estadistica.php' target ='_parent' > 
              <strong><font color="#ffff00"><strong>Estadisticas.</strong></font></strong> 
              </a> </tr>
			  <tr><br><img src="../principal/imagenes/icono_menu.gif" width="20"> <a href='index.php' target ='_parent' > 
              <strong><font color="#ffff00"><strong>Salir.</strong></font></strong> 
              </a> </tr>
            <tr></tr>
          </table>
        </div></td>
      <td width="533" ></td>
    </tr> 
  </table>
 <? include("../principal/pie_pagina.php");?>
  </form>
<p>
</p>
<? if(isset($mensaje)&&($mensaje != "")){
	echo ' <script languaje = "Javascript">';
	echo " alert('".$mensaje."')";
	$mensaje = "";
	echo ' </script>';
	}
?>
</body>
</html>
