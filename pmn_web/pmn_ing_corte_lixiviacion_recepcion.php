<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 145;
	
	include("../principal/conectar_pmn_web.php");
	
	if ($opc == "B")	
	{
		$recargapag1 = "S";
		$ano = $ano1;
		$mes = $mes1;
		$txtlix = $num;
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Grabar()
{	
	var f = document.frmPrincipal;
	
	if (f.txtlix.value == "")
	{
		alert("Debe Ingresar Nº Lixiviacion");
		return;
	}
	
	f.action = "pmn_ing_corte_lixiviacion_recepcion01.php?proceso=G";
	f.submit();
}
/***************/
function Modificar()
{	
	var f = document.frmPrincipal;
	
	if (f.txtlix.value == "")
	{
		alert("Debe Ingresar Nº Lixiviacion");
		return;
	}
	
	f.action = "pmn_ing_corte_lixiviacion_recepcion01.php?proceso=M";
	f.submit();
}
/****************/
function Eliminar()
{
	var f = document.frmPrincipal;
	
	f.action = "pmn_ing_corte_lixiviacion_recepcion01.php?proceso=E";
	f.submit();
}

/****************/
function Consultar()
{
	window.open("pmn_ing_corte_lixiviacion_recepcion_popup.php?","","top=100,left=80,width=700,height=200,scrollbars=no,resizable=no");
}
/************/
function Cancelar()
{
	document.location = "pmn_ing_corte_lixiviacion_recepcion.php";
}
/******************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=146";
}
</script> 

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style><body>
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
<table width="770" height="330" border="0" class="TablaPrincipal">
<tr>
<td align="center" valign="top">
  <table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td width="280">Fecha</td>	  
      <td width="305">
	  <?php
  		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	  ?>
	  <select name="mes" size="1">
          <?php
		for($i=1;$i<13;$i++)
		{
			if (($recargapag1 == "S") && ($i == $mes))
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == date("n")) && ($recargapag1 != "S"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
        </select> <select name="ano" size="1">
          <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($recargapag1 == "S") && ($i == $ano))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($recargapag1 != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
        </select></td>
    </tr>
    <tr> 
            <td>N&ordm; de Lixiviacion (Para el Proceso)</td>
      <td><input name="txtlix" type="text" id="txtlix" value="<?php echo $txtlix ?>"></td>
    </tr>
  </table>
  <br>
        <table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td align="center"> 
              <?php
				if ($opc == "B")
					echo '<input name="btnmodificar" type="button" value="Modificar" style="width:70" onClick="Modificar()">';
				else
					echo '<input name="btngrabar" type="button" value="Grabar" style="width:70" onClick="Grabar()">';
			?>
              <input name="btneliminar" type="button" value="Eliminar" style="width:70" onClick="Eliminar()"> 
              <input name="btnconsultar" type="button" value="Consultar" style="width:70" onClick="Consultar()"> 
              <input name="btncancelar" type="button" style="width:70" value="Cancelar" onClick="Cancelar()"> 
              <input name="btnsalir" type="button" value="Salir" style="width:70" onClick="Salir()"></td>
          </tr>
      </table></td>
</tr>
</table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php 	include("../principal/cerrar_pmn_web.php"); ?>
