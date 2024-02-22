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
		
	}
}

function CargaDatos(RB)
{
	var f = document.frmConsulta;
	window.opener.document.frmPrincipalRpt.action="pmn_principal_reportes.php?MostrarElect1=S&VerElect1=S&NumElectrolisisElect1="+f.NumElec.value + "&DElect1="+f.DiaConsulta.value + "&MElect1="+f.MesConsulta.value + "&AElect1="+f.AnoConsulta.value + "&TurnoElect1="+f.Turno.value + "&CorElect1="+f.Correlativo.value + "&GruElect1="+f.Grupo.value+"&Tab3=true&TabElec1=true&Consulta=S";
	window.opener.document.frmPrincipalRpt.submit();
	window.close();
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
<table width="650" height="20" border="0">
  <tr>
      <td class="TituloCabeceraAzul"><strong class="TituloCabeceraAzul">Detalle carga electrolisis plata</strong></td>
  </tr>
</table>
<br>
<table width="650" border="0" cellpadding="3" cellspacing="1" class="TablaInterior">
  <tr> 
      <td width="116">&nbsp;</td>  <td width="343"><div align="center"> &nbsp; 
          <input type="button" name="btnCerrar" value="Cerrar" onClick="Proceso('S');" style="width:70px">
        </div></td>
      <td width="166">&nbsp;</td>
  </tr>
</table>
<br>
  <table width="666" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr class="TituloCabeceraAzul"> 
      <td width="60">&nbsp;</td>
      <td width="110"><strong>Electrolisis</strong></td>
      <td width="106"><strong>Fecha</strong></td>
      <td width="90"><strong>Turno</strong></td>
      <td width="88"><strong>Grupo</strong></td>
      <td width="176"><strong>Correlativo</strong></td>
    </tr>
    <?php  
	$Consulta="select distinct(num_electrolisis),fecha,turno,grupo,correlativo from pmn_web.carga_electrolisis_plata";
	$Consulta.=" where num_electrolisis='".$Electrolisis."' ";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td><input type='radio' name='CheckElectrolisis' value='".$Row[num_electrolisis]."' class='SinBorde' onClick='CargaDatos(this);'></td>\n";
		echo "<input type='hidden' name='DiaConsulta' value='".substr($Row["fecha"],8,2)."'>\n";
		echo "<input type='hidden' name='MesConsulta' value='".substr($Row["fecha"],5,2)."'>\n";
		echo "<input type='hidden' name='AnoConsulta' value='".substr($Row["fecha"],0,4)."'>\n";
		echo "<input type='hidden' name='NumElec' value='".$Row[num_electrolisis]."'>\n";
		echo "<input type='hidden' name='Fecha' value='".$Row["fecha"]."'>\n";
		echo "<input type='hidden' name='Turno' value='".$Row[turno]."'>\n";
		echo "<input type='hidden' name='Grupo' value='".$Row["grupo"]."'>\n";
		echo "<input type='hidden' name='Correlativo' value='".$Row[correlativo]."'>\n";
		echo "<td>".$Row[num_electrolisis]."&nbsp;</td>\n";
		echo "<td>".$Row["fecha"]."&nbsp;</td>\n";
		$Consulta= "select * from proyecto_modernizacion.sub_clase where cod_clase ='1' and cod_subclase = '".$Row[turno]."'";
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Resp);  
		echo "<td>".$Fila["nombre_subclase"]."&nbsp;</td>\n";
		echo "<td>".$Row["grupo"]."&nbsp;</td>\n";
		echo "<td>".$Row[correlativo]."&nbsp;</td>\n";
		echo "</tr>\n";
	}
?>
  </table>
</form>
</body>
</html>
