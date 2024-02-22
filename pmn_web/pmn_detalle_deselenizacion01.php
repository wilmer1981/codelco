<?php include("../principal/conectar_pmn_web.php");?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt,H)//Opcion y la ornada
{
	var f = document.frmConsulta;
	switch (opt)
	{
		case "S":
			window.close();
			break;
		case "R":
			f.action = "pmn_detalle_deselenizacion01.php?Hornada="+H;
			f.submit();
			break;
	}
}

function CargaDatos(RB)
{
	var f = document.frmConsulta;
	var NumHorno01="";
	var NumFunda01="";
	var HornadaTotal01="";
	var HornadaParcial01="";
	
	/*alert(f.CheckModificar.value);
	alert(f.Horno.value);
	alert(f.Funda.value);
	alert(f.HornadaTotal.value);
	alert(f.HornadaParcial.value);*/
	window.opener.document.frmPrincipalRpt.action = "pmn_principal_reportes.php?ModifDese=S&NumHorno01=" +f.Horno.value +"&NumFunda01="+f.Funda.value+"&HornadaTotal01="+f.HornadaTotal.value+"&HornadaParcial01="+f.HornadaParcial.value + "&Dia01=" + f.DiaConsulta.value + "&Mes01=" + f.MesConsulta.value + "&Ano01=" + f.AnoConsulta.value+"&Tab8=true";
	window.opener.document.frmPrincipalRpt.submit();
	window.close();
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
<table width="650" height="20" border="0">
  <tr>
    <td class="TituloCabeceraAzul">Detalle Planta de Selenio por D&iacute;a</td>
  </tr>
</table>
<br>
<table width="650" border="0" cellpadding="3" cellspacing="1" class="TablaInterior">
  <tr> 
      <td width="116">&nbsp;</td>  <td width="343"><div align="center">
        <input type="button" name="btnVerDia" value="Consultar" onClick="Proceso('R','<?php echo $Hornada;  ?>');" style="width:70px">          
        &nbsp; 
          <input type="button" name="btnCerrar" value="Cerrar" onClick="Proceso('S');" style="width:70px">
        </div></td>
      <td width="166">&nbsp;</td>
  </tr>
</table>
<br>
  <table width="666" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr class="TituloCabeceraAzul"> 
      <td width="57">&nbsp;</td>
      <td width="161"><strong>Funcionario</strong></td>
      <td width="128"><strong>Fecha</strong></td>
      <td width="108"><strong>Hornada</strong></td>
      <td width="41"><strong>Turno</strong></td>
      <td width="100"><strong>Prod. Calcina</strong></td>
	  <td width="164" align="center"><strong>Otros Productos</strong></td>
    </tr>
    <?php  
	//$Fecha = $AnoConsulta."-".$MesConsulta."-".$DiaConsulta;
	$Consulta = "select t1.rut, t1.fecha, t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial,t1.turno, t1.prod_calcina, concat(left(t2.nombres,1),'. ',t2.apellido_paterno) as nombre";
	$Consulta.= " from pmn_web.deselenizacion t1 left join proyecto_modernizacion.funcionarios t2 on t1.rut = t2.rut";
	$Consulta.= " where t1.num_horno = '".$NumHorno."' and t1.num_funda='".$NumFunda."' and t1.hornada_total='".$HornadaTotal."' and t1.hornada_parcial='".$HornadaParcial."'";
	$Consulta.= " order by t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial";

	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		//echo "<td><input type='radio' name='CheckModificar' value='".$Row[num_horno]."~".$Row[num_funda]."&&".$Row[hornada_total]."@@".$Row[hornada_parcial]."//"."' onClick='CargaDatos(this);'></td>\n";
		echo "<td><input type='radio' name='CheckModificar' value='".$Row["fecha"]."' onClick='CargaDatos(this);'></td>\n";
		echo "<input type='hidden' name='DiaConsulta' value='".substr($Row["fecha"],8,2)."'>\n";
		echo "<input type='hidden' name='MesConsulta' value='".substr($Row["fecha"],5,2)."'>\n";
		echo "<input type='hidden' name='AnoConsulta' value='".substr($Row["fecha"],0,4)."'>\n";
		echo "<input type='hidden' name='Horno' value='".$Row[num_horno]."'>\n";
		echo "<input type='hidden' name='Funda' value='".$Row[num_funda]."'>\n";
		echo "<input type='hidden' name='HornadaTotal' value='".$Row[hornada_total]."'>\n";
		echo "<input type='hidden' name='HornadaParcial' value='".$Row[hornada_parcial]."'>\n";
		echo "<td>".ucwords(strtolower($Row["nombre"]))."&nbsp;</td>\n";
		echo "<td>".$Row["fecha"]."&nbsp;</td>\n";
		echo "<td>".$Row[num_horno]."-".$Row[num_funda]."-".$Row[hornada_total]."-".$Row[hornada_parcial]."</td>\n";
		$Consulta= "select * from proyecto_modernizacion.sub_clase where cod_clase ='1' and cod_subclase = '".$Row[turno]."'";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);  
		echo "<td>".$Fila["nombre_subclase"]."&nbsp;</td>\n";
		echo "<td align='left'>".$Row[prod_calcina]."&nbsp;</td>\n";
		echo "</tr>\n";
	}
?>
  </table>
</form>
</body>
</html>
