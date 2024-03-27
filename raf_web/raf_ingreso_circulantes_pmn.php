<?
include("../principal/conectar_raf_web.php");
if($Proceso != "G")
{		
	$Mes = str_pad($Mes,2,"0",STR_PAD_LEFT);
	$Dia = str_pad($Dia,2,"0",STR_PAD_LEFT);
	$fecha = $Ano.'-'.$Mes.'-'.$Dia;
	$fecha_ini = $AnoIni.'-'.str_pad($MesIni,2,"0",STR_PAD_LEFT).'-'.str_pad($DiaIni,2,"0",STR_PAD_LEFT);
	$fecha_ter = $AnoTer.'-'.str_pad($MesTer,2,"0",STR_PAD_LEFT).'-'.str_pad($DiaTer,2,"0",STR_PAD_LEFT);

	$hornada = $Ano.$Mes.$Hornada;
	$Consulta = "SELECT SUM(unidades) as unid, SUM(peso) as peso FROM raf_web.movimientos ";
	$Consulta.= " WHERE left(fecha_carga,10) = '$fecha' AND hornada = $hornada";
	$Consulta.= " AND (cod_producto=22 and cod_subproducto=6 ";
	$Consulta.= " OR cod_producto=39 and cod_subproducto=6 ";
	$Consulta.= " OR cod_producto=42 and cod_subproducto=21)";
	$Consulta.= " AND turno = '$cmbturno'";
	$Rs = mysqli_query($link, $Consulta);
	$Row = mysql_fetch_array($Rs);
	$Total = $Row[unid];
	$PesoTotal = $Row["peso"];

	$Consulta = "SELECT * FROM raf_web.movimientos WHERE left(fecha_carga,10) = '$fecha' AND hornada = $hornada";
	$Consulta.= " AND (cod_producto=22 and cod_subproducto=6 ";
	$Consulta.= " OR cod_producto=39 and cod_subproducto=6 ";
	$Consulta.= " OR cod_producto=42 and cod_subproducto=21)";
	$Consulta.= " AND turno = '$cmbturno'";
	$rs = mysqli_query($link, $Consulta);
	while($Fila = mysql_fetch_array($rs))
	{
		if($Fila["cod_producto"] == 42 AND $Fila[cod_subproducto] == 21)
		{
			$EscFus = $Fila["unidades"];				
			$Peso_EscFus = $Fila["peso"];				
		}
	
		if($Fila["cod_producto"] == 22 AND $Fila[cod_subproducto] == 6)
		{
			$EscOxid = $Fila["unidades"];				
			$Peso_EscOxid = $Fila["peso"];				
		}
		if($Fila["cod_producto"] == 39 AND $Fila[cod_subproducto] == 6)
		{
			$LadrTrof = $Fila["unidades"];				
			$Peso_LadrTrof = $Fila["peso"];				
		}
		
	}
	$Consulta = "SELECT * FROM raf_web.movimientos WHERE left(fecha_carga,10) = '$fecha' AND hornada = $hornada";
	$Consulta.= " AND turno = '$cmbturno'";
	$rs = mysqli_query($link, $Consulta);
	if($row = mysql_fetch_array($rs))
	{
		$Proceso2 = 'S';
	}

	$peso_total = $TotalPeso - ($Peso_EscFusion + $Peso_EscOxid + $Peso_LadrTrof);
	$unid_total = $TotalUnid - ($EscFus + $EscOxid + $LadrTrof);

}

if($Proceso == "G")
{
		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_EscFus'";
		$Actualiza.= " WHERE cod_clase = 8002 AND cod_subclase = 1";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_EscOxid'";
		$Actualiza.= " WHERE cod_clase = 8002 AND cod_subclase = 2";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_LadrTrof'";
		$Actualiza.= " WHERE cod_clase = 8002 AND cod_subclase = 3";
		mysql_query($Actualiza);


		$Ano = substr($fecha_carga,0,4);
		$Mes = substr($fecha_carga,5,2);
		$Hornada = $Ano.$Mes.$hornada;

		$Elimina = "SELECT * FROM raf_web.movimientos ";
		$Elimina.= " WHERE fecha_carga = '$fecha_carga' AND hornada = $Hornada";
		$Elimina.= " AND (cod_producto=22 and cod_subproducto=6 ";
		$Elimina.= " OR cod_producto=39 and cod_subproducto=6 ";
		$Elimina.= " OR cod_producto=42 and cod_subproducto=21)";
		$Elimina.= " AND turno = '$cmbturno'";
		mysql_query($Elimina);
		
		if($EscFus != '' || $EscFus != 0)
		{
			$Peso_EscFus = $EscFus * $Prom_EscFus;
			$Unid_EscFus = $EscFus;			
		}
		else
		{
			$Peso_EscFus = 0;
			$Unid_EscFus = 0;
		}
		$Valores.= "&escfus=".$Unid_EscFus."&peso_escfus=".$Peso_EscFus;
		if($EscOxid != '' && $EscOxid != 0)
		{
			$Peso_EscOxid = $EscOxid * $Prom_EscOxid;
			$Unid_EscOxid = $EscOxid;			
		}
		else
		{
			$Peso_EscOxid = 0;
			$Unid_EscOxid = 0;	
		}
		$Valores.= "&escoxid=".$Unid_EscOxid."&peso_escoxid=".$Peso_EscOxid;
		if($LadrTrof != '' && $LadrTrof != 0)
		{
			$Peso_LadrTrof = $LadrTrof * $Prom_LadrTrof;
			$Unid_LadrTrof = $LadrTrof;			 
		}
		else
		{
			$Peso_LadrTrof = 0;
			$Unid_LadrTrof = 0;		
		}
		$Valores.= "&ladrtrof=".$Unid_LadrTrof."&peso_ladrtrof=".$Peso_LadrTrof;

		$UnidTotal = $EscFus + $EscOxid + $LadrTrof;
		$Total_Unid = ($unid_total - $TotalUnidCircPmn) + $UnidTotal;
		$PesoTotal = $Peso_EscFus + $Peso_EscOxid + $Peso_LadrTrof;
		$Total_Peso = ($peso_total - $TotalUnidCircPmn) + $PesoTotal;

		if($Proceso2 == "G")
			$Valores01 = "?Proceso=B&Circ_Unid=".$UnidTotal."&Circ_Peso=".$PesoTotal."&Total_Unid=".$Total_Unid."&Total_Peso=".$Total_Peso;		
		elseif($Proceso2 == "M")
			$Valores01 = "?Proceso=H&Circ_Unid=".$UnidTotal."&Circ_Peso=".$PesoTotal."&Total_Unid=".$Total_Unid."&Total_Peso=".$Total_Peso;		
		

		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmPrincipal.action = 'raf_ingreso_carga_preparacion.php".$Valores01."".$Valores."';";
		echo "window.opener.document.FrmPrincipal.submit();";
		echo "window.close();";										 	
		echo "</script>";
}

if($Proceso != "G")
{
	$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
	$Consulta.= " WHERE cod_clase = 8002";
	$rs = mysqli_query($link, $Consulta);
	while($Fila = mysql_fetch_array($rs))
	{
		if($Fila["cod_subclase"] == 1)
			$Prom_EscFus = $Fila["valor_subclase1"];

		if($Fila["cod_subclase"] == 2)
			$Prom_EscOxid = $Fila["valor_subclase1"];
	
		if($Fila["cod_subclase"] == 3)
			$Prom_LadrTrof = $Fila["valor_subclase1"];

	
	}
}
?>
<html>
<head>
<title>Circulantes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Calcula()
{
	var f = document.FrmPopUp;
	var Total = 0;	
	f.Total.value = f.EscFus.value * 1 + f.EscOxid.value * 1 + f.LadrTrof.value * 1; 

	f.PesoTotal.value = ((f.EscFus.value * f.Prom_EscFus.value) * 1) + ((f.EscOxid.value * f.Prom_EscOxid.value) * 1) + ((f.LadrTrof.value * f.Prom_LadrTrof.value) * 1);
	
	f.Peso_EscFus.value = f.EscFus.value * f.Prom_EscFus.value;
	f.Peso_EscOxid.value = f.EscOxid.value * f.Prom_EscOxid.value;
	f.Peso_LadrTrof.value = f.LadrTrof.value * f.Prom_LadrTrof.value;
	

	 Total = (f.PesoTotal.value * 1) + (f.peso_total.value * 1); 
	 f.TotalHornada.value = (f.PesoTotal.value * 1) + (f.peso_total.value * 1); 

	 if(f.peso_estimado.value - Total < 0)
		alert("Sobrepaso El Peso Estimado");
	
}

function Proceso(opc)
{
	var f = document.FrmPopUp;
	Valores = '';

	switch (opc)
	{
		case "G":
				f.action = "raf_ingreso_circulantes_pmn.php?Proceso=G&Proceso2=G";
				f.submit();
				break;	

		case "G2":
				f.action = "raf_ingreso_circulantes_pmn.php?Proceso=G&Proceso2=M";
				f.submit();
				break;	

		case "S":
				window.close();										 	
				break							
	
	}

}

</script>
</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body class="TablaPrincipal">

<form name="FrmPopUp" method="post" action="">
  <table width="418" height="140" border="0" class="TablaPrincipal">
	<input type="hidden" name="hornada" size="20" value="<? echo $Hornada?>">
	<input type="hidden" name="cmbturno" size="20" value="<? echo $cmbturno?>">
	<input type="hidden" name="encargado" size="20" value="<? echo $Encargado?>">
	<input type="hidden" name="fecha_carga" size="20" value="<? echo $fecha?>">
	<input type="hidden" name="fecha_ini" size="20" value="<? echo $fecha_ini?>">
	<input type="hidden" name="fecha_ter" size="20" value="<? echo $fecha_ter?>">
	<input type="hidden" name="Solera" size="20" value="<? echo $Solera?>">
	<input type="hidden" name="peso_estimado" size="20" value="<? echo $Peso_Estimado?>">
	<input type="hidden" name="peso_total" size="20" value="<? echo $peso_total?>">
	<input type="hidden" name="unid_total" size="20" value="<? echo $unid_total?>">
    <tr> 
      <td width="410" align="center"><br>
        <table width="364" border="1" cellspacing="" cellpadding="0" class="TablaInterior">
          <tr class="ColorTabla01"> 
            <td colspan="4" align="center">Circulantes P.M.N.</td>
          </tr>
          <tr class="Detalle01"> 
            <td width="160" align="center">Descripci&oacute;n</td>
            <td width="58" align="center">Cantidad</td>
            <td width="67" align="center">Peso Prom</td>
            <td width="68" align="center">Peso Total</td>
          </tr>
          <tr> 
            <td>Escoria Fusion</td>
            <td align="center"><input type="text" name="EscFus" size="10 "value="<? echo $EscFus?>" onBlur="Calcula();"></td>
            <td align="center"><input type="text" name="Prom_EscFus" size="10 "value="<? echo $Prom_EscFus?>" onBlur="Calcula();"></td>
            <td align="center"><input type="text" name="Peso_EscFus" size="10 "value="<? echo $Peso_EscFus?>" onBlur="Calcula();"></td>
          </tr>
          <tr> 
            <td>Escoria Oxidaci&oacute;n</td>
            <td align="center"><input type="text" name="EscOxid" size="10" value="<? echo $EscOxid?>" onBlur="Calcula();"></td>
            <td align="center"><input type="text" name="Prom_EscOxid" size="10" value="<? echo $Prom_EscOxid?>" onBlur="Calcula();"></td>
            <td align="center"><input type="text" name="Peso_EscOxid" size="10" value="<? echo $Peso_EscOxid?>" onBlur="Calcula();"></td>
          </tr>
          <tr> 
            <td>Ladrillos Horno Trof</td>
            <td align="center"><input type="text" name="LadrTrof" size="10" value="<? echo $LadrTrof?>" onBlur="Calcula();"></td>
            <td align="center"><input type="text" name="Prom_LadrTrof" size="10" value="<? echo $Prom_LadrTrof?>" onBlur="Calcula();"></td>
            <td align="center"><input type="text" name="Peso_LadrTrof" size="10" value="<? echo $Peso_LadrTrof?>" onBlur="Calcula();"></td>
          </tr>
          <tr class="ColorTabla02"> 
            <td height="15"><strong>Totales</strong></td>
            <td align="center"><input type="text" name="Total" size="10" value="<? echo $Total?>"></td>
            <td align="center">&nbsp;</td>
            <td align="center"><input type="text" name="PesoTotal" size="10" value="<? echo $PesoTotal?>"></td>
          </tr>
        </table>
		<br>
		<table width="362" border="1" cellspacing="" cellpadding="0" class="TablaInterior">
          <tr class="ColorTabla02"> 
            <td width="159"><strong>Peso Programado</strong></td>
            <td width="59" align="center"><input type="text" name="TotalEst" size="10" value="<? echo $Peso_Estimado;?>"></td>
            <td width="67" ><strong>Total Horn.</strong></td>
            <td width="66" align="center"><input type="text" name="TotalHornada" size="10" value="<? echo $TotalPeso?>"></td>
          </tr>
        </table>				
        	<br>	
			<table width="364" border="1" cellspacing="" cellpadding="0" class="TablaInterior">
				<tr>
				  <td width="359" align="center">
					<? 
					if($Proceso2 != "S")
					{
					?>
					  <input type="button" name="BtnOk" size="20" style="width:70px" value="Ok" onClick="Proceso('G');">
					<?
					}										
					if($Proceso2 == "S")
					{
					?>
					  <input type="button" name="BtnOk" size="20" style="width:70px" value="Ok" onClick="Proceso('G2');">
					<?
					}
					?>										
	                <input type="button" name="BtnSalir" size="20"  style="width:70px" value="Salir" onClick="Proceso('S');">
				  </td>	
				</tr>
		    </table>		
	  </td>	
   </tr>
</table>
<input type="hidden" name="TotalUnidCircPmn" value="<? echo $TotalUnidCircPmn; ?>">
<input type="hidden" name="TotalPesoCircPmn" value="<? echo $TotalPesoCircPmn; ?>">
</form>
</body>
</html>
