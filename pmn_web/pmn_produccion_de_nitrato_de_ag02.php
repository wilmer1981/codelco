<?php include("../principal/conectar_pmn_web.php");?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_pmn_web.css" type="text/css" rel="stylesheet">
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
	window.opener.document.frmPrincipal.action="pmn_produccion_de_nitrato_de_ag.php?Mostrar=S&Ver=S&TxtElectrolisis="+StrElect + "&D="+StrDia + "&M="+StrMes + "&A="+StrAno + "&Turno="+StrTurno;
	window.opener.document.frmPrincipal.submit();
	window.close();
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="frmConsulta" action="" method="post">
<table width="647" height="20" border="0">
  <tr>
      <td width="641" class="ColorTabla01"><strong>Detalle Nitrato de Plata</strong></td>
  </tr>
</table>
<br>
<table width="647" border="0" cellpadding="3" cellspacing="1" class="TablaInterior">
  <tr> 
      <td width="155">&nbsp;</td>  
      <td width="286"> <div align="center">&nbsp; 
          <input type="button" name="btnCerrar" value="Cerrar" onClick="Proceso('S');" style="width:70px">
        </div></td>
      <td width="184">&nbsp;</td>
  </tr>
</table>
<br>
  <table width="646" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="53">&nbsp;</td>
      <td width="64"><strong>Electrolisis</strong></td>
      <td width="110"><strong>Fecha</strong></td>
      <td width="41"><strong>Turno</strong></td>
      <td width="124"><strong>Peso Cristales</strong></td>
      <td width="120"><strong>Volumen Acido</strong></td>
      <td width="92"><strong>Volumen Final</strong></td>	
	</tr>
    <?php  
	$Consulta="select * from pmn_web.produccion_nitrato_ag";
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
		echo "<td><input type='radio' name='CheckElectrolisis' value='".$Row[num_electrolisis]."' onClick='CargaDatos(this);'></td>\n";
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
		echo "<td align='center'>".$Row[num_electrolisis]."&nbsp;</td>\n";
		echo "<td align='left'>".$Row["fecha"]."&nbsp;</td>\n";
		$Consulta= "select * from proyecto_modernizacion.sub_clase where cod_clase ='1' and cod_subclase = '".$Row[turno]."'";
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Resp);  
		echo "<td>".$Fila["nombre_subclase"]."&nbsp;</td>\n";
		echo "<td align='center'>".$Row[peso_cristales]."&nbsp;</td>\n";
		echo "<td align='center'>".$Row[volumen_acido_nitrico]."&nbsp;</td>\n";
		echo "<td align='center'>".$Row[volumen_final]."&nbsp;</td>\n";
		echo "</tr>\n";
	}
?>
  </table>
</form>
</body>
</html>
