<?php 	
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 1;
	include("../principal/conectar_principal.php");
	// parrafo para agregar año a tabla leyes por lote revisando que no esten duplicadas
	$contador = 0;
	$Consulta = "select * from age_web.leyes_por_lote where lote like '0712%' and ano = ''";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		echo $Fila[lote]."--".$Fila[ano]."</br>";
		$Busca = "select year(fecha_muestra) as ano_muestra from cal_web.solicitud_analisis where ";
		$Busca.=" id_muestra = '".$Fila[lote]."' and recargo = '".$Fila["recargo"]."'";
		$Resb=mysqli_query($link, $Busca);
		if ($Filab = mysqli_fetch_array($Resb))
		{
			$Reviso = "select * from age_web.leyes_por_lote where lote = '".$Fila[lote]."' and recargo = '".$Fila["recargo"]."'";
			$Reviso.=" and cod_leyes = '".$Fila["cod_leyes"]."' and ano = '".$Filab[ano_muestra]."'";
			$Resr=mysqli_query($link, $Reviso);
			if ($Filar=mysqli_fetch_array($Resr))
			{
				echo "existe".$Filar[lote]."</br>";
			}
			else
			{
				$actualizo ="UPDATE leyes_por_lote set ano = '".$Filab[ano_muestra]."'  where lote = '".$Fila[lote]."' and ";
				$actualizo.=" recargo = '".$Fila["recargo"]."' and cod_leyes = '".$Fila["cod_leyes"]."'";
				mysqli_query($link, $actualizo);
				$contador = $contador + 1;
			}
		}
	}
	echo $contador."</br>";
	
	
	$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='15004' and cod_subclase='1'";
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$TxtIVA=$Fila["valor_subclase1"];
	$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='15005' and cod_subclase='1'";
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$TxtDolar=$Fila[valor_subclase1];
?>
<html>
<head>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Grabar()
{
	var Frm=document.FrmProceso;
	
	Frm.action="age_parametros01.php";
	Frm.submit();
}
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=60";	
}
</script>
<title>AGE-Ingreso de Parametros</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 3px;
	margin-bottom: 3px;
}
-->
</style><body onload="document.FrmProceso.TxtIVA.focus()">
<form name="FrmProceso" method="post" action="">
<?php include("../principal/encabezado.php") ?>
  <table width="770" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td height="330"><table width="300" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
      <tr>
        <td width="78" class="Detalle01">IVA (%)</td>
        <td width="207"><input name="TxtIVA" type="text" class="InputCen" value="<?php echo $TxtIVA;?>" size="15" maxlength="10">
        </td>
      </tr>
      <tr>
        <td class="Detalle01">Dolar (US$)</td>
        <td><input name="TxtDolar" type="text" class="InputCen" value="<?php echo $TxtDolar;?>" size="15" maxlength="10"></td>
      </tr>
      <tr align="center" valign="middle">
        <td height="30" colspan="2"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('')">
          <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();"></td>
        </tr>
    </table>     
        </td>
  </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
  </form>
</body>
</html>
