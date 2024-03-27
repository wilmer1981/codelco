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
	$Consulta = "SELECT SUM(unidades) as unid, SUM(peso) as peso FROM raf_web.movimientos WHERE left(fecha_carga,10) = '$fecha' AND hornada = $hornada";
	$Consulta.= " AND cod_producto = 16 AND cod_subproducto IN('40','41','42')";
	$Consulta.= " AND turno = '$cmbturno'";
	$Rs = mysqli_query($link, $Consulta);
	$Row = mysql_fetch_array($Rs);
	$Total = $Row[unid];
	$PesoTotal = $Row["peso"];
		
	$Consulta = "SELECT * FROM raf_web.movimientos WHERE left(fecha_carga,10) = '$fecha' AND hornada = $hornada";
	$Consulta.= " AND cod_producto = 16";
	$Consulta.= " AND turno = '$cmbturno'";
	$rs = mysqli_query($link, $Consulta);
	while($Fila = mysql_fetch_array($rs))
	{
		if($Fila[cod_subproducto] == 40)
		{
			$BlistCps = $Fila["unidades"];
			$Peso_BlistCps = $Fila["peso"];
		}

		if($Fila[cod_subproducto] == 41)
		{
			$BlistBasc = $Fila["unidades"];
			$Peso_BlistBasc = $Fila["peso"];
		}

		if($Fila[cod_subproducto] == 42)
		{
			$BlistReten = $Fila["unidades"];
			$Peso_BlistReten = $Fila["peso"];
		}	

	}

	$Consulta = "SELECT * FROM raf_web.movimientos WHERE left(fecha_carga,10) = '$fecha' AND hornada = $hornada";
	$Consulta.= " AND turno = '$cmbturno'";
	$rs = mysqli_query($link, $Consulta);
	if($row = mysql_fetch_array($rs))
	{
		$Proceso2 = 'S';
	}

	$peso_total = $TotalPeso - ($Peso_BlistReten + $Peso_BlistBasc + $Peso_BlistCps);
	$unid_total = $TotalUnid - ($BlistReten + $BlistBasc + $BlistCps);
}

if($Proceso == "G")
{
		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_BlistBasc'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 11";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_BlistReten'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 12";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_BlistCps'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 14";
		mysql_query($Actualiza);

		$Ano = substr($fecha_carga,0,4);
		$Mes = substr($fecha_carga,5,2);
		$Hornada = $Ano.$Mes.$hornada;

		$Elimina = "SELECT * FROM raf_web.movimientos WHERE fecha_carga = '$fecha_carga' AND hornada = $Hornada";
		$Elimina.= " AND cod_producto = 16 AND cod_subproducto IN('40','41','42')";
		$Elimina.= " AND turno = '$cmbturno'";
		mysql_query($Elimina);
		
		if($BlistCps != '' || $BlistCps != 0)
		{
			$Peso_BlistCps = $BlistCps * $Prom_BlistCps;
			$Unid_BlistCps = $BlistCps;		
		}
		else
		{
			$Peso_BlistCps = 0;
			$Unid_BlistCps = 0;
		}
		$Valores.= "&blistcps=".$Unid_BlistCps."&peso_blistcps=".$Peso_BlistCps;
		if($BlistBasc != '' || $BlistBasc != 0)
		{
			$Peso_BlistBasc = $BlistBasc * $Prom_BlistBasc;
			$Unid_BlistBasc = $BlistBasc;			
		}
		else
		{
			$Peso_BlistBasc = 0;
			$Unid_BlistBasc = 0;		
		}
		$Valores.= "&blistbasc=".$Unid_BlistBasc."&peso_blistbasc=".$Peso_BlistBasc;
		if($BlistReten != '' && $BlistReten != 0)
		{
			$Peso_BlistReten = $BlistReten * $Prom_BlistReten;
			$Unid_BlistReten = $BlistReten;			
		}
		else
		{
			$Peso_BlistReten = 0;
			$Unid_BlistReten = 0;		
		}
		$Valores.= "&blistreten=".$Unid_BlistReten."&peso_blistreten=".$Peso_BlistReten;
		
		$UnidTotal = $BlistBasc + $BlistReten + $BlistCps;
		$Total_Unid = ($unid_total - $TotalUnidBlister) + $UnidTotal;
		$PesoTotal = $Peso_BlistBasc + $Peso_BlistReten + $Peso_BlistCps;
		$Total_Peso = ($peso_total - $TotalPesoBlister) + $PesoTotal;

		if($Proceso2 == 'G')
			$Valores01 = "?Proceso=B&Order=".$order."&Blister_Unid=".$UnidTotal."&Blister_Peso=".$PesoTotal."&Total_Unid=".$Total_Unid."&Total_Peso=".$Total_Peso;		
		elseif($Proceso2 == 'M')
			$Valores01 = "?Proceso=H&Order=".$order."&Blister_Unid=".$UnidTotal."&Blister_Peso=".$PesoTotal."&Total_Unid=".$Total_Unid."&Total_Peso=".$Total_Peso;		
						
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmPrincipal.action = 'raf_ingreso_carga_preparacion.php".$Valores01."".$Valores."';";
		echo "window.opener.document.FrmPrincipal.submit();";
		echo "window.close();";										 	
		echo "</script>";
}

if($Proceso != "G")
{
	$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
	$Consulta.= " WHERE cod_clase = 8000";
	$rs = mysqli_query($link, $Consulta);
	while($Fila = mysql_fetch_array($rs))
	{
		if($Fila["cod_subclase"] == 11)
			$Prom_BlistBasc = $Fila["valor_subclase1"];

		if($Fila["cod_subclase"] == 12)
			$Prom_BlistReten = $Fila["valor_subclase1"];

		if($Fila["cod_subclase"] == 14)
			$Prom_BlistCps = $Fila["valor_subclase1"];		
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
	f.Total.value = f.BlistBasc.value * 1 + f.BlistReten.value * 1 + f.BlistCps.value * 1; 

	f.PesoTotal.value = ((f.BlistBasc.value * f.Prom_BlistBasc.value) * 1) + ((f.BlistReten.value * f.Prom_BlistReten.value) * 1) + ((f.BlistCps.value * f.Prom_BlistCps.value) * 1);
	
	f.Peso_BlistCps.value = f.BlistCps.value * f.Prom_BlistCps.value;
	f.Peso_BlistBasc.value = f.BlistBasc.value * f.Prom_BlistBasc.value;
	f.Peso_BlistReten.value = f.BlistReten.value * f.Prom_BlistReten.value;
	

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
				f.action = "raf_ingreso_circulantes_blister.php?Proceso=G&Proceso2=G";
				f.submit();
				break;	

		case "G2":
				f.action = "raf_ingreso_circulantes_blister.php?Proceso=G&Proceso2=M";
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
  <table width="370" height="140" border="0" class="TablaPrincipal">
    <tr> 
      <td align="center">
		<input type="hidden" name="hornada" size="20" value="<? echo $Hornada?>">
		<input type="hidden" name="order" size="20" value="<? echo $order?>">
		<input type="hidden" name="cmbturno" size="20" value="<? echo $cmbturno?>">
		<input type="hidden" name="encargado" size="20" value="<? echo $Encargado?>">
		<input type="hidden" name="fecha_carga" size="20" value="<? echo $fecha?>">
		<input type="hidden" name="fecha_ini" size="20" value="<? echo $fecha_ini?>">
		<input type="hidden" name="fecha_ter" size="20" value="<? echo $fecha_ter?>">
		<input type="hidden" name="Solera" size="20" value="<? echo $Solera?>">
		<input type="hidden" name="peso_estimado" size="20" value="<? echo $Peso_Estimado?>">
		<input type="hidden" name="peso_total" size="20" value="<? echo $peso_total?>">
		<input type="hidden" name="unid_total" size="20" value="<? echo $unid_total?>">
		<table width="362" border="1" cellspacing="" cellpadding="0" class="TablaInterior">
          <tr class="ColorTabla01"> 
            <td colspan="4" align="center">Blister Liquido</td>
          </tr>
          <tr class="Detalle01"> 
            <td width="114" align="center">Descripci&oacute;n</td>
            <td width="80" align="center">Cantidad</td>
            <td width="79" align="center">Peso Prom</td>
            <td width="80" align="center">Peso Total</td>
          </tr>
          <tr> 
            <td>Blist. CPS</td>
            <td align="center"><input name="BlistCps" type="text" onBlur="Calcula();" value="<? echo $BlistCps?>" size="10"></td>
            <td align="center"><input name="Prom_BlistCps" type="text" onBlur="Calcula();" value="<? echo $Prom_BlistCps ?>" size="10"></td>
            <td align="center"><input name="Peso_BlistCps" type="text" value="<? echo $Peso_BlistCps?>" size="10"></td>
          </tr>
          <tr> 
            <td>Blist. Horno Basc.</td>
            <td align="center"><input name="BlistBasc" type="text" onBlur="Calcula();" value="<? echo $BlistBasc?>" size="10"></td>
            <td align="center"><input name="Prom_BlistBasc" type="text" onBlur="Calcula();" value="<? echo $Prom_BlistBasc ?>" size="10"></td>
            <td align="center"><input name="Peso_BlistBasc" type="text" value="<? echo $Peso_BlistBasc?>" size="10"></td>
          </tr>
          <tr> 
            <td>Blist. Horno Reten.</td>
            <td align="center"><input type="text" name="BlistReten" size="10 "value="<? echo $BlistReten?>" onBlur="Calcula();"></td>
            <td align="center"><input name="Prom_BlistReten" type="text" onBlur="Calcula();" value="<? echo $Prom_BlistReten?>" size="10"></td>
            <td align="center"><input name="Peso_BlistReten" type="text" value="<? echo $Peso_BlistReten?>" size="10"></td>
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
            <td width="112"><strong>Peso Programado</strong></td>
            <td width="80" align="center"><input type="text" name="TotalEst" size="10" value="<? echo $Peso_Estimado;?>"></td>
            <td width="78" ><strong>Total Horn.</strong></td>
            <td width="81" align="center"><input type="text" name="TotalHornada" size="10" value="<? echo $TotalPeso?>"></td>
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
<input type="hidden" name="TotalUnidBlister" value="<? echo $TotalUnidBlister; ?>">
<input type="hidden" name="TotalPesoBlister" value="<? echo $TotalPesoBlister; ?>">
</form>
</body>
</html>
