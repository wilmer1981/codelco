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
	/*
	var f = document.frmConsulta;
	window.opener.document.frmPrincipal.action="pmn_carga_elec_oro.php?Mostrar=S&Ver=S&NumElectrolisis="+f.NumElec.value + "&D="+f.DiaConsulta.value + "&M="+f.MesConsulta.value + "&A="+f.AnoConsulta.value + "&Turno="+f.Turno.value + "&Cor="+f.Correlativo.value;
	window.opener.document.frmPrincipal.submit();
	window.close();
	*/
	
	var vector = RB.value.split('~'); //0:num_electrolisis, 1:fecha, 2:turno, 3:correlativo, 4:colada.
	var fecha = vector[1].split('-'); //0: año, 1:mes, 2:dia.
	
	var linea = "MostrarElOro=S&VerElOro=S&Ano_aux=" + fecha[0] + "&Mes_aux=" + fecha[1] + "&Dia_aux=" + fecha[2] + "&Correlativo_aux=" + vector[3];
	linea = linea + "&NumElectrolisis_aux=" + vector[0] + "&Colada_aux=" + vector[4] + "&Turno_aux=" + vector[2];
	
	var f = document.frmConsulta;
	window.opener.document.frmPrincipalRpt.action = "pmn_principal_reportes.php?" + linea+"&Tab4=true";
	window.opener.document.frmPrincipalRpt.submit();
	window.close();	
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
<table width="650" height="20" border="0">
  <tr>
      <td class="TituloCabeceraAzul"><strong>Detalle carga electrolisis plata</strong></td>
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
      <td width="176"><strong>Correlativo</strong></td>
    </tr>
    <?php  
	$Consulta="select distinct(num_electrolisis),fecha,turno,correlativo,colada from pmn_web.carga_electrolisis_oro";
	$Consulta.=" where num_electrolisis='".$Electrolisis."' ";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td><input type='radio' name='CheckElectrolisis' value='".$Row[num_electrolisis]."~".$Row["fecha"]."~".$Row[turno]."~".$Row[correlativo]."~".$Row[colada]."' onClick='CargaDatos(this);'></td>\n";
		echo "<input type='hidden' name='DiaConsulta' value='".substr($Row["fecha"],8,2)."'>\n";
		echo "<input type='hidden' name='MesConsulta' value='".substr($Row["fecha"],5,2)."'>\n";
		echo "<input type='hidden' name='AnoConsulta' value='".substr($Row["fecha"],0,4)."'>\n";
		echo "<input type='hidden' name='NumElec' value='".$Row[num_electrolisis]."'>\n";
		echo "<input type='hidden' name='Fecha' value='".$Row["fecha"]."'>\n";
		echo "<input type='hidden' name='Turno' value='".$Row[turno]."'>\n";
		echo "<input type='hidden' name='Correlativo' value='".$Row[correlativo]."'>\n";
		echo "<td>".$Row[num_electrolisis]."&nbsp;</td>\n";
		echo "<td>".$Row["fecha"]."&nbsp;</td>\n";
		$Consulta= "select * from proyecto_modernizacion.sub_clase where cod_clase ='1' and cod_subclase = '".$Row[turno]."'";
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Resp);  
		echo "<td>".$Fila["nombre_subclase"]."&nbsp;</td>\n";
		echo "<td>".$Row[correlativo]."&nbsp;</td>\n";
		echo "</tr>\n";
	}
?>
  </table>
</form>
</body>
</html>
