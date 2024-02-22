<?php 	
	include("../principal/conectar_sec_web.php");

	$Consulta="Select peso_rango from  sec_web.sec_parametro_peso";
	$rs = mysqli_query($link, $Consulta);
	if ($row = mysqli_fetch_array($rs))
	{
		$TxtPeso=$row["peso_rango"];
	}
?>
<html>
<head>
<script language="JavaScript">
function Modificar()
{
	var Frm=document.FrmModifFechaPqte;
		
	if (confirm('Esta Seguro de Modificar Peso'))
	{
		Frm.action="sec_modificar_peso01.php?Proceso=M";
		Frm.submit();
	}	
}

function Salir()
{
	var Frm=document.FrmModifFechaPqte;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=65";
	Frm.submit();
}
</script>
<title>Modificar Peso Termino</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
.Estilo4 {color: #CC0000}
-->
</style>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
 <form name="FrmModifFechaPqte" method="post" action="">
 <?php include("../principal/encabezado.php")?> <table width="770" height="185" border="0" left="5" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
	<td align="center"><br>
	  <br>
		<table width="346" border="1" cellpadding="2" cellspacing="0" class="tablainterior">
		  <tr>
		    <td width="99">Peso Termino </td>
		    <td><input name="TxtPeso" type="text" maxlength="5" value="<?php echo $TxtPeso; ?>">
		      Kgrs</td>
	      </tr>
		  <tr>
			  <td height="61" colspan="2"><p class="Estilo4"><strong>Nota:</strong> Los pesos que se encuentren ingresado <strong>NO</strong> tendran efecto, solo para los nuevos pesos.</p>
		      <p class="Estilo4">Defecto 500 kgrs </p></td>
	      </tr>
		</table>
        <br><br>
		<table width="346" border="0" class="tablainterior">
          <tr>
			<td width="491" align="center">
			<input type="button" name="BtnOK" value="Modificar" style="width:70" onClick="Modificar();">
			<input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();">
			</td>
		  </tr>
		</table>
	</td>
  </tr>
  </table>

<?phpPHP
include("../principal/pie_pagina.php");
if($Msj==1)
{
?>
<script language="javascript">
alert("Valor Modificado")
</script>

<?php

}

?>

</form>
</body>
</html>
