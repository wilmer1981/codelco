<?php
	include("conectar_principal.php");
	$Consulta = "select t1.descripcion, t2.nombre ";
	$Consulta.= " from proyecto_modernizacion.niveles_por_sistema t1 inner join proyecto_modernizacion.sistemas t2 ";
	$Consulta.= " on t1.cod_sistema = t2.cod_sistema";
	$Consulta.= " where t1.cod_sistema = '".$Sistem."' ";
	$Consulta.= " and t1.nivel = '".$NivelCons."' ";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$DescripNivel = $Fila["descripcion"];
		$NomSistema = $Fila["nombre"];	
	}
?>
<html>
<head>
<title>Administraci&oacute;n de Sistema</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt,valor)
{
	var f = frmConsulta;
	var Valores = "";
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
<!--
body {
	background-image: url(imagenes/fondo3.gif);
}
-->
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(imagenes/fondo3.gif);
}
a:link {
	color: #FFFFFF;
}
a:visited {
	color: #FFFFFF;
}
a:hover {
	color: #FFFFFF;
}
a:active {
	color: #FFFF00;
}
-->
</style>
</head>

<body>
<form name="frmConsulta" action="" method="post">

</form>
<table width="400"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla02">
    <td colspan="4"><strong>DETALLE NIVEL DE SISTEMA </strong></td>
  </tr>
  <tr>
    <td>SISTEMA:</td>
    <td colspan="3"><strong><?php echo $NomSistema; ?></strong></td>
  </tr>
  <tr>
    <td>NIVEL:</td>
    <td colspan="3"><strong><?php echo $NivelCons." - ".$DescripNivel; ?></strong></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr align="center" class="ColorTabla01">
    <td width="15%"><strong>Corr</strong></td>
    <td width="22%"><strong>Rut</strong></td>
    <td width="49%"><strong>Nombre</strong></td>
    <td width="14%"><strong>C.C.</strong></td>
  </tr>
<?php
	$Consulta = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres, t2.cod_centro_costo ";
	$Consulta.= " from proyecto_modernizacion.sistemas_por_usuario t1 inner join proyecto_modernizacion.funcionarios t2 ";
	$Consulta.= " on t1.rut=t2.rut ";
	$Consulta.= " where t1.cod_sistema = '".$Sistem."' and t1.nivel='".$NivelCons."' ";
	$Consulta.= " order by apellido_paterno, apellido_materno, nombres";
	$Resp = mysqli_query($link, $Consulta);
	$Cont =1;
	while ($Fila = mysqli_fetch_array($Resp))
	{  
		$partNum = substr($Fila["rut"],0,8);
		$dVerif = substr($Fila["rut"],9,1);
		$RutFun = str_pad(number_format($partNum,0,",","."),10,"0",STR_PAD_LEFT)."-".strtoupper($dVerif);
		echo "<tr>\n";
		echo "<td align='center'>".$Cont."</td>\n";
		echo "<td align='center'>".$RutFun."</td>\n";
		echo "<td>".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]))." ".ucwords(strtolower($Fila["nombres"]))."</td>\n";
		echo "<td align='center'>".str_replace(".","",substr($Fila["cod_centro_costo"],3))."</td>\n";
		echo "</tr>\n";
		$Cont++;
	}
?>  
  <tr align="center">
    <td height="30" colspan="4"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
    <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
</body>
</html>
