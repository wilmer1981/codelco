<?php
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f= document.frmPrincipal;
	switch (opt)
	{
		case "I":
			window.print();
			break;
		case "S":
			window.history.back();
			break;
	}
}
function Excel(FechaI,FechaT,T)
{
	var f=document.frmPrincipal;
	f.action="pmn_xls_carga_barro_aurifero_crudo.php?FechaIni="+FechaI + "&FechaFin="+FechaT + "&Turno="+T;
	f.submit();
}

</script>
</head>

<body class="TituloCabeceraOz" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form action="" method="post" name="frmPrincipal">
  <?php
  	$FechaIni = $AnoIniCon."-".$MesIniCon."-".$DiaIniCon;
	$FechaFin = $AnoFinCon."-".$MesFinCon."-".$DiaFinCon;
  ?>
  <table width="711" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      <td width="446" align="center" valign="middle"><strong class="titulo_azul">PRODUCCION BARRO AURIFERO CRUDO
        </strong></td>
      <td width="82" align="center" valign="middle"><input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>','<?php echo $Turno;  ?>');"></td>
      <td width="165" align="center" valign="middle"> 
        <input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
        &nbsp; 
      <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"></td>
    </tr>
  </table>
<strong> <br>
<br>
</strong> 
  <table width="586" border="1" cellspacing="0" cellpadding="3" class="TituloCabeceraAzul">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td width="36" rowspan="2">FECHA</td>
      <td width="41" rowspan="2">TURNO</td>
      <td colspan="5">BARROS AURIFEROS CRUDOS</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td width="80" align="center" valign="middle">PESO</td>
      <td width="72">N&deg;ELECTROLISIS</td>
      <td width="99" align="center" valign="middle">GRUPO</td>
      <td width="64">J.TURNO</td>
      <td> <div align="center">OPERADOR</div>
      </td>
    </tr>
    <?php 
	$Consulta = "select *,t2.nombre_subclase from pmn_web.barro_aurifero_crudo t1";
	$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t1.turno = t2.cod_subclase and cod_clase ='1'   ";
	$Consulta.= " where fecha between '".$FechaIni."' and '".$FechaFin."' ";
	if ($Turno != "S")
		$Consulta.= " and turno = '".$Turno."'";
	$Consulta.= " order by t1.fecha,valor_subclase1 ";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	$FechaAnt = "";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>";
			echo "<td align='left'>".substr($Row["fecha"],8,2)."/".substr($Row["fecha"],5,2)."/".substr($Row["fecha"],0,4)."&nbsp;</td>\n";
			echo "<td>".$Row["nombre_subclase"]."</td>";
			$Consulta="select * from pmn_web.detalle_barro_aurifero_crudo t1  " ;
			$Consulta.=" inner join barro_aurifero_crudo t2 on t1.rut = t2.rut and " ;
            $Consulta.=" t1.fecha = t2.fecha and t1.num_electrolisis = t2.num_electrolisis"   ;
            $Consulta.=" and t1.turno = t2.turno and t1.fecha =' " .$Row["fecha"]."'";
			//echo $Consulta."<br>";
			$Respuesta1= mysqli_query($link, $Consulta);
			echo "<td>";
			while ($Fila=mysqli_fetch_array($Respuesta1))
			{
				$Porc=($Fila[porc_humedad]/100);
				$Calculo=($Fila[peso_humedo]*$Porc);
				echo number_format($Calculo,3,",","")."<br>";
			}
			echo "</td>";
			echo "<td>".$Row[num_electrolisis]."</td>";
			echo "<td>".$Row["grupo"]."</td>";
			echo "<td>&nbsp;</td>";			
			$Consulta="select * from proyecto_modernizacion.funcionarios where rut = '".$Row[operador]."' ";
			$Respuesta2=mysqli_query($link, $Consulta);
			$Fila2=mysqli_fetch_array($Respuesta2);	
			echo "<td align='left'>".strtoupper(substr($Fila2["nombres"],0,1)).". ".ucwords(strtolower($Fila2["apellido_paterno"]))."</td>\n";
		echo "</tr>";
	}
?>
  </table>
</form>
</body>
</html>
