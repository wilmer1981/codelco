�<?
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
	$Consulta.= " AND (cod_producto=29 and cod_subproducto=1 ";
	$Consulta.= " OR cod_producto=48 and cod_subproducto=10 ";
	$Consulta.= " OR cod_producto=49 and cod_subproducto=4)";
	$Consulta.= " AND turno = '$cmbturno'";
	$Rs = mysql_query($Consulta);
	$Row = mysql_fetch_array($Rs);
	$Total = $Row[unid];
	$PesoTotal = $Row["peso"];
		
	$Consulta = "SELECT * FROM raf_web.movimientos WHERE left(fecha_carga,10) = '$fecha' AND hornada = $hornada";
	$Consulta.= " AND (cod_producto=29 and cod_subproducto=1 ";
	$Consulta.= " OR cod_producto=48 and cod_subproducto=10 ";
	$Consulta.= " OR cod_producto=49 and cod_subproducto=4)";
	$Consulta.= " AND turno = '$cmbturno'";
	$rs = mysql_query($Consulta);
	while($Fila = mysql_fetch_array($rs))
	{
		if($Fila["cod_producto"] == 49 && $Fila[cod_subproducto] == 4)
		{
			$BarroAnod = $Fila["unidades"];				
			$Peso_BarroAnod = $Fila["peso"];				
		}
		if($Fila["cod_producto"] == 48 && $Fila[cod_subproducto] == 10)
		{
			$BarridoCu = $Fila["unidades"];				
			$Peso_BarridoCu = $Fila["peso"];				
		}
		if($Fila["cod_producto"] == 29 && $Fila[cod_subproducto] == 1)
		{
			$GranaCu = $Fila["unidades"];				
			$Peso_GranaCu = $Fila["peso"];				
		}
		
	}

	$Consulta = "SELECT * FROM raf_web.movimientos WHERE left(fecha_carga,10) = '$fecha' AND hornada = $hornada";
	$Consulta.= " AND turno = '$cmbturno'";
	$rs = mysql_query($Consulta);
	if($row = mysql_fetch_array($rs))
	{
		$Proceso2 = 'S';
	}

	$peso_total = $TotalPeso - ($Peso_BarroAnod + $Peso_BarridoCu + $Peso_GranaCu);
	$unid_total = $TotalUnid - ($BarroAnod + $BarridoCu + $GranaCu);

}

if($Proceso == "G")
{
		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_BarroAnod'";
		$Actualiza.= " WHERE cod_clase = 8001 AND cod_subclase = 1";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_BarridoCu'";
		$Actualiza.= " WHERE cod_clase = 8001 AND cod_subclase = 2";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_GranaCu'";
		$Actualiza.= " WHERE cod_clase = 8001 AND cod_subclase = 3";
		mysql_query($Actualiza);


		$Ano = substr($fecha_carga,0,4);
		$Mes = substr($fecha_carga,5,2);
		$Hornada = $Ano.$Mes.$hornada;

		$Elimina = "SELECT * FROM raf_web.movimientos ";
		$Elimina.= " WHERE fecha_carga = '$fecha_carga' AND hornada = $Hornada";
		$Elimina.= " AND (cod_producto=29 and cod_subproducto=1 ";
		$Elimina.= " OR cod_producto=48 and cod_subproducto=10 ";
		$Elimina.= " OR cod_producto=49 and cod_subproducto=4)";
		$Elimina.= " AND turno = '$cmbturno'";
		mysql_query($Elimina);
		
		if($BarroAnod != '' || $BarroAnod != 0)
		{
			$Peso_BarroAnod = $BarroAnod * $Prom_BarroAnod;
			$Unid_BarroAnod = $BarroAnod;
		}
		else
		{
			$Peso_BarroAnod = 0;
			$Unid_BarroAnod = 0;
		}
		$Valores.= "&barroanod=".$Unid_BarroAnod."&peso_barroanod=".$Peso_BarroAnod;
		if($BarridoCu != '' && $BarridoCu != 0)
		{
			$Peso_BarridoCu = $BarridoCu * $Prom_BarridoCu;
			$Unid_BarridoCu = $BarridoCu;			
		}
		else
		{
			$Peso_BarridoCu = 0;
			$Unid_BarridoCu = 0;	
		}
		$Valores.= "&barridocu=".$Unid_BarridoCu."&peso_barridocu=".$Peso_BarridoCu;
		if($GranaCu != '' && $GranaCu != 0)
		{
			$Peso_GranaCu = $GranaCu * $Prom_GranaCu;
			$Unid_GranaCu = $GranaCu;			
		}
		else
		{
			$Peso_GranaCu = 0;
			$Unid_GranaCu = 0;	
		}
		$Valores.= "&granacu=".$Unid_GranaCu."&peso_granacu=".$Peso_GranaCu; 

		$UnidTotal = $BarroAnod + $BarridoCu + $GranaCu;
		$Total_Unid = ($unid_total - $TotalUnidCircRef) + $UnidTotal;
		$PesoTotal = $Peso_BarroAnod + $Peso_BarridoCu + $Peso_GranaCu;
		$Total_Peso = ($peso_total - $TotalPesoCircRef) + $PesoTotal;

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
	$Consulta.= " WHERE cod_clase = 8001";
	$rs = mysql_query($Consulta);
	while($Fila = mysql_fetch_array($rs))
	{
		if($Fila["cod_subclase"] == 1)
			$Prom_BarroAnod = $Fila["valor_subclase1"];

		if($Fila["cod_subclase"] == 2)
			$Prom_BarridoCu = $Fila["valor_subclase1"];
	
		if($Fila["cod_subclase"] == 3)
			$Prom_GranaCu = $Fila["valor_subclase1"];

	
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
	f.Total.value = f.BarroAnod.value * 1 + f.BarridoCu.value * 1 + f.GranaCu.value * 1; 

	f.PesoTotal.value = ((f.BarroAnod.value * f.Prom_BarroAnod.value) * 1) + ((f.BarridoCu.value * f.Prom_BarridoCu.value) * 1) + ((f.GranaCu.value * f.Prom_GranaCu.value) * 1);
	
	f.Peso_BarroAnod.value = f.BarroAnod.value * f.Prom_BarroAnod.value;
	f.Peso_BarridoCu.value = f.BarridoCu.value * f.Prom_BarridoCu.value;
	f.Peso_GranaCu.value = f.GranaCu.value * f.Prom_GranaCu.value;
	

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
				f.action = "raf_ingreso_circulantes_ref.php?Proceso=G&Proceso2=G";
				f.submit();
				break;	

		case "G2":
				f.action = "raf_ingreso_circulantes_ref.php?Proceso=G&Proceso2=M";
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
            <td colspan="4" align="center">Circulantes Refineria Electr.</td>
          </tr>
          <tr class="Detalle01"> 
            <td width="160" align="center">Descripci&oacute;n</td>
            <td width="58" align="center">Cantidad</td>
            <td width="67" align="center">Peso Prom</td>
            <td width="68" align="center">Peso Total</td>
          </tr>
          <tr> 
            <td>Residuos Barro Anodico</td>
            <td align="center"><input type="text" name="BarroAnod" size="10 "value="<? echo $BarroAnod?>" onBlur="Calcula();"></td>
            <td align="center"><input type="text" name="Prom_BarroAnod" size="10 "value="<? echo $Prom_BarroAnod?>" onBlur="Calcula();"></td>
            <td align="center"><input type="text" name="Peso_BarroAnod" size="10 "value="<? echo $Peso_BarroAnod?>" onBlur="Calcula();"></td>
          </tr>
          <tr> 
            <td>Barrido De Cobre</td>
            <td align="center"><input type="text" name="BarridoCu" size="10" value="<? echo $BarridoCu?>" onBlur="Calcula();"></td>
            <td align="center"><input type="text" name="Prom_BarridoCu" size="10" value="<? echo $Prom_BarridoCu?>" onBlur="Calcula();"></td>
            <td align="center"><input type="text" name="Peso_BarridoCu" size="10" value="<? echo $Peso_BarridoCu?>" onBlur="Calcula();"></td>
          </tr>
          <tr> 
            <td>Granallas De Cobre</td>
            <td align="center"><input type="text" name="GranaCu" size="10" value="<? echo $GranaCu?>" onBlur="Calcula();"></td>
            <td align="center"><input type="text" name="Prom_GranaCu" size="10" value="<? echo $Prom_GranaCu?>" onBlur="Calcula();"></td>
            <td align="center"><input type="text" name="Peso_GranaCu" size="10" value="<? echo $Peso_GranaCu?>" onBlur="Calcula();"></td>
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
<input type="hidden" name="TotalUnidCircRef" value="<? echo $TotalUnidCircRef; ?>">
<input type="hidden" name="TotalPesoCircRef" value="<? echo $TotalPesoCircRef; ?>">
</form>
</body>
</html>
