<?php
	include("conectar_principal.php");

	//Sistema=15&Ano=2023&Mes=12
	
	if(isset($_REQUEST["Sistema"])){
		$Sistema = $_REQUEST["Sistema"];
	}else{
		$Sistema = "";
	}

	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = "";
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = "";
	}

	$Consulta = "select * from proyecto_modernizacion.sistemas where cod_sistema='".$Sistema."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$NomSistema = $Fila["descripcion"];
	}
?>
<html>
<head>
<title>Sistemas Informaticos</title>
<link rel="stylesheet" href="estilos/css_principal.css" type="text/css">
<style type="text/css">

body {
	background-image: url(imagenes/fondo3.gif);
}

</style>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{			
		case "I":
			window.print();
			break;		
		case "S":
			window.close();
			break;
	}
}
</script>
</head>

<body>
<form name="frmPopUp" action="" method="post">
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr>
    <td width="76">Sistema</td>
    <td width="409"><?php echo $NomSistema ?></td>
  </tr>
  <tr>
    <td>A&ntilde;o</td>
    <td><?php echo $Ano;?></td>
  </tr>
  <tr>
    <td>Mes</td>
    <td><?php echo $Meses[$Mes-1];?></td>
  </tr>
  <tr align="center">
    <td colspan="2"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" onClick="Proceso('I')" style="width:70px ">
    <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" onClick="Proceso('S')" style="width:70px "></td>
  </tr>
</table>
<br>
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla01">
    <td colspan="3"><strong>CIERRE PARCIAL </strong></td>
  </tr>
  <tr align="center" class="ColorTabla01">
    <td>Fecha</td>
    <td>Estado</td>
    <td>Responsable</td>
  </tr>
<?php  
	$Consulta = "SELECT * from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='".$Sistema."'";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1'";
	$Consulta.= " order by fecha_cierre desc";
	$Resp = mysqli_query($link, $Consulta);	
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr>\n";
		echo "<td align='center'>".$Fila["fecha_cierre"]."</td>\n";
		if ($Fila["estado"]=="C")
			echo "<td align='center'><img src='imagenes/cand_cerrado.gif'></td>\n";
		else
			echo "<td align='center'><img src='imagenes/cand_abierto.gif'></td>\n";
		$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Fila["rut_funcionario"]."'";
		$Resp3 = mysqli_query($link, $Consulta);
		if ($Fila3 = mysqli_fetch_array($Resp3))
		{
			$Nombre = ucwords(strtolower($Fila3["nombres"]))." ".ucwords(strtolower($Fila3["apellido_paterno"]))." ".ucwords(strtolower($Fila3["apellido_materno"]));
			echo "<td>".$Nombre."</td>\n";
		}				
		else
		{	
			echo "<td>No Encontrado</td>\n";
		}
		echo "</tr>\n";
	}
?>  
</table>
<br>
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla01">
    <td colspan="3"><strong>CIERRE GENRAL </strong></td>
  </tr>
  <tr align="center" class="ColorTabla01">
    <td>Fecha</td>
    <td>Estado</td>
    <td>Responsable</td>
  </tr>
<?php  
	$Consulta = "SELECT * from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='".$Sistema."'";
	$Consulta.= " AND ano='".$Ano."' AND mes='".$Mes."' AND cod_bloqueo='2'";
	$Consulta.= " ORDER BY fecha_cierre desc";
	$Resp = mysqli_query($link, $Consulta);	
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr>\n";
		echo "<td align='center'>".$Fila["fecha_cierre"]."</td>\n";
		if ($Fila["estado"]=="C")
			echo "<td align='center'><img src='imagenes/cand_cerrado.gif'></td>\n";
		else
			echo "<td align='center'><img src='imagenes/cand_abierto.gif'></td>\n";
		$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Fila["rut_funcionario"]."'";
		$Resp3 = mysqli_query($link, $Consulta);
		if ($Fila3 = mysqli_fetch_array($Resp3))
		{
			$Nombre = ucwords(strtolower($Fila3["nombres"]))." ".ucwords(strtolower($Fila3["apellido_paterno"]))." ".ucwords(strtolower($Fila3["apellido_materno"]));
			echo "<td>".$Nombre."</td>\n";
		}				
		else
		{	
			echo "<td>No Encontrado</td>\n";
		}
		echo "</tr>\n";
	}
?> </table>
</form>
</body>
</html>
