<?php include("../principal/conectar_pmn_web.php");?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)//Opcion y la ornada
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
	var StrDia="";
	var StrMes="";
	var StrAno="";
	var StrProceso="";
	for (i=1;i<f.CheckElectrolisis.length;i++)
	{
		if (f.CheckElectrolisis[i].checked == true)
		{
			StrDia=f.DiaConsulta[i].value;
			StrMes=f.MesConsulta[i].value;
			StrAno=f.AnoConsulta[i].value;
			StrElect=f.NumElec[i].value;
			StrTurno=f.Turno[i].value;
		}
	}
	window.opener.document.frmPrincipalRpt.action="pmn_principal_reportes.php?MostrarElect2=S&VerElect2=S&NumElectrolisis2="+StrElect + "&DElect2="+StrDia + "&MElect2="+StrMes + "&AElect2="+StrAno + "&TElect2="+StrTurno+"&Tab3=true&TabElec2=true";
	window.opener.document.frmPrincipalRpt.submit();
	window.close();
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
<table width="473" height="20" border="0">
  <tr>
      <td width="467" class="TituloCabeceraAzul"><strong class="TituloCabeceraAzul">Detalle Descarga de Plata</strong></td>
  </tr>
</table>
<br>
<table width="470" border="0" cellpadding="3" cellspacing="1" class="TablaInterior">
  <tr> 
      <td width="155">&nbsp;</td>  
      <td width="286"> <div align="left">&nbsp; 
          <input type="button" name="btnCerrar" value="Cerrar" onClick="Proceso('S');" style="width:70px">
        </div></td>
      <td width="7">&nbsp;</td>
  </tr>
</table>
<br>
  <table width="472" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr class="TituloCabeceraAzul"> 
      <td width="60">&nbsp;</td>
      <td width="110"><strong>Electrolisis</strong></td>
      <td width="106"><strong>Fecha</strong></td>
      <td width="172"><strong>Turno</strong></td>
    </tr>
    <?php  
	$Consulta="select * from pmn_web.descarga_electrolisis_plata ";
	$Consulta.=" where num_electrolisis='".$Electrolisis."' ";
	$Respuesta = mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='CheckElectrolisis' value=''>\n";
	echo "<input type='hidden' name='DiaConsulta' value=''>\n";
	echo "<input type='hidden' name='MesConsulta' value=''>\n";
	echo "<input type='hidden' name='AnoConsulta' value=''>\n";
	echo "<input type='hidden' name='NumElec' value=''>\n";
	echo "<input type='hidden' name='Turno' value=''>\n";
		
	while ($Row=mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td><input type='radio' name='CheckElectrolisis' value='".$Row[num_electrolisis]."' class='SinBorde' onClick='CargaDatos(this);'></td>\n";
		echo "<input type='hidden' name='DiaConsulta' value='".substr($Row["fecha"],8,2)."'>\n";
		$DiaConsulta=substr($Row["fecha"],8,2);
		echo "<input type='hidden' name='MesConsulta' value='".substr($Row["fecha"],5,2)."'>\n";
		$MesConsulta=substr($Row["fecha"],0,4);
		echo "<input type='hidden' name='AnoConsulta' value='".substr($Row["fecha"],0,4)."'>\n";
		$AnoConsulta=substr($Row["fecha"],0,4);
		echo "<input type='hidden' name='NumElec' value='".$Row[num_electrolisis]."'>\n";
		$NumElec=$Row[num_electrolisis];
		echo "<input type='hidden' name='Fecha' value='".$Row["fecha"]."'>\n";
		$Fecha=$Row["fecha"];
		echo "<input type='hidden' name='Turno' value='".$Row[turno]."'>\n";
		$Turno=$Row[turno];
		echo "<td>".$Row[num_electrolisis]."&nbsp;</td>\n";
		echo "<td>".$Row["fecha"]."&nbsp;</td>\n";
		$Consulta= "select * from proyecto_modernizacion.sub_clase where cod_clase ='1' and cod_subclase = '".$Row[turno]."'";
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Resp);  
		echo "<td>".$Fila["nombre_subclase"]."&nbsp;</td>\n";
		echo "</tr>\n";
	}
?>
  </table>
</form>
</body>
</html>
