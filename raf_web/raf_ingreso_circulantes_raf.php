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
	$Consulta.= " AND cod_producto IN(42)";
	$Consulta.= " AND cod_subproducto IN(16,31,39,43,69,70,73,74,75,76,77,78)";
	$Consulta.= " AND turno = '$cmbturno'";
	$Rs = mysqli_query($link, $Consulta);
	$Row = mysql_fetch_array($Rs);
	$Total = $Row[unid];
	$PesoTotal = $Row["peso"];
		
	$Consulta = "SELECT * FROM raf_web.movimientos WHERE left(fecha_carga,10) = '$fecha' AND hornada = $hornada";
	$Consulta.= " AND cod_producto IN(42)";
	$Consulta.= " AND cod_subproducto IN(16,31,39,43,69,70,73,74,75,76,77,78)";
	$Consulta.= " AND turno = '$cmbturno'";
	$rs = mysqli_query($link, $Consulta);
	while($Fila = mysql_fetch_array($rs))
	{
		if($Fila[cod_subproducto] == 43)
		{
			$Tallarines = $Fila["unidades"];
			$Peso_Tallarines = $Fila["peso"];
		}

		if($Fila[cod_subproducto] == 75)
		{
			$CuRecup = $Fila["unidades"];
			$Peso_CuRecup = $Fila["peso"];
		}	
		if($Fila[cod_subproducto] == 39)
		{
			$Queques = $Fila["unidades"];
			$Peso_Queques = $Fila["peso"];
		}
		if($Fila[cod_subproducto] == 76)
		{
			$BoteAlb = $Fila["unidades"];
			$Peso_BoteAlb = $Fila["peso"];
		}
		if($Fila[cod_subproducto] == 73)
		{	
			$Moldes = $Fila["unidades"];
			$Peso_Moldes = $Fila["peso"];
		}
		if($Fila[cod_subproducto] == 70)
		{
			$BoteOxid = $Fila["unidades"];
			$Peso_BoteOxid = $Fila["peso"];
		}
		if($Fila[cod_subproducto] == 74)
		{
			$AnodCirc = $Fila["unidades"];
			$Peso_AnodCirc = $Fila["peso"];	
		}
		if($Fila[cod_subproducto] == 31)
		{
			$Maceteros = $Fila["unidades"];
			$Peso_Maceteros = $Fila["peso"];
		}
		if($Fila[cod_subproducto] == 69)
		{
			$Rebalses = $Fila["unidades"];
			$Peso_Rebalses = $Fila["peso"];
		}
		if($Fila[cod_subproducto] == 16)
		{
			$Chatarra = $Fila["unidades"];				
			$Peso_Chatarra = $Fila["peso"];				
		}
		if($Fila[cod_subproducto] == 77)
		{
			$Placas = $Fila["unidades"];				
			$Peso_Placas = $Fila["peso"];				
		}
		if($Fila[cod_subproducto] == 78)
		{
			$CuPiso = $Fila["unidades"];				
			$Peso_CuPiso = $Fila["peso"];				
		}
		
	}
	$Consulta = "SELECT * FROM raf_web.movimientos WHERE left(fecha_carga,10) = '$fecha' AND hornada = $hornada";
	$Consulta.= " AND turno = '$cmbturno'";
	$rs = mysqli_query($link, $Consulta);
	if($row = mysql_fetch_array($rs))
	{
		$Proceso2 = 'S';
	}
	$peso_total = $TotalPeso - ($Peso_Tallarines + $Peso_CuRecup + $Peso_Queques + $Peso_BoteAlb + $Peso_Moldes + $Peso_BoteOxid + $Peso_AnodCirc + $Peso_Maceteros + $Peso_Rebalses + $Peso_Chatarra + $Peso_Placas + $Peso_CuPiso);
	$unid_total = $TotalUnid - ($Tallarines + $CuRecup + $Queques + $BoteAlb + $Moldes + $BoteOxid + $AnodCirc + $Maceteros + $Rebalses + $Chatarra + $Placas + $CuPiso);

}

if($Proceso == "G")
{
		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_Tallarines'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 1";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_Maceteros'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 2";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_Rebalses'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 3";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_Queques'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 4";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_Chatarra'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 5";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_BoteAlb'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 6";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_BoteOxid'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 7";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_CuRecup'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 8";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_AnodCirc'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 9";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_Moldes'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 10";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_Placas'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 13";
		mysql_query($Actualiza);

		$Actualiza = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1 = '$Prom_CuPiso'";
		$Actualiza.= " WHERE cod_clase = 8000 AND cod_subclase = 15";
		mysql_query($Actualiza);

		$Ano = substr($fecha_carga,0,4);
		$Mes = substr($fecha_carga,5,2);
		$Hornada = $Ano.$Mes.$hornada;

		$Elimina = "SELECT * FROM raf_web.movimientos ";
		$Elimina.= " WHERE fecha_carga = '$fecha_carga' AND hornada = $Hornada";
		$Elimina.= " AND cod_producto IN(42)";
		$Elimina.= " AND cod_subproducto IN(16,31,39,43,69,70,73,74,75,76,77,78)";
		$Elimina.= " AND turno = '$cmbturno'";
		mysql_query($Elimina);		
		
		if($Tallarines != '' || $Tallarines != 0)
		{
			$Peso_Tallarines = $Tallarines * $Prom_Tallarines;
			$Unid_Tallarines = $Tallarines;			
		}
		else
		{
			$Peso_Tallarines = 0;
			$Unid_Tallarines = 0;
		}
		$Valores.= "&tallarines=".$Unid_Tallarines."&peso_tallarines=".$Peso_Tallarines;
		if($Maceteros != '' && $Maceteros != 0)
		{
			$Peso_Maceteros = $Maceteros * $Prom_Maceteros;
			$Unid_Maceteros = $Maceteros;			
		}
		else
		{
			$Peso_Maceteros = 0;
			$Unid_Maceteros = 0;		
		}
		$Valores.= "&maceteros=".$Unid_Maceteros."&peso_maceteros=".$Peso_Maceteros;
		if($Rebalses != '' && $Rebalses != 0)
		{
			$Peso_Rebalses = $Rebalses * $Prom_Rebalses;
			$Unid_Rebalses = $Rebalses;			 
		}
		else
		{
			$Peso_Rebalses = 0;
			$Unid_Rebalses = 0;		
		}
		$Valores.= "&rebalses=".$Unid_Rebalses."&peso_rebalses=".$Peso_Rebalses;
		if($Queques != '' && $Queques != 0)
		{
			$Peso_Queques = $Queques * $Prom_Queques;
			$Unid_Queques = $Queques;			
		}
		else
		{
			$Peso_Queques = 0;
			$Unid_Queques = 0;	
		}
		$Valores.= "&queques=".$Unid_Queques."&peso_queques=".$Peso_Queques;
		if($Chatarra != '' && $Chatarra != 0)
		{
			$Peso_Chatarra = $Chatarra * $Prom_Chatarra;
			$Unid_Chatarra = $Chatarra;			
		}
		else
		{
			$Peso_Chatarra = 0;
			$Unid_Chatarra = 0;	
		}
		$Valores.= "&chatarra=".$Unid_Chatarra."&peso_chatarra=".$Peso_Chatarra;
		if($BoteAlb != '' && $BoteAlb != 0)
		{
			$Peso_BoteAlb = $BoteAlb * $Prom_BoteAlb;
			$Unid_BoteAlb = $BoteAlb;			
		}
		else
		{
			$Peso_BoteAlb = 0;
			$Unid_BoteAlb = 0;		
		}
		$Valores.= "&botealb=".$Unid_BoteAlb."&peso_botealb=".$Peso_BoteAlb;
		if($BoteOxid != '' && $BoteOxid != 0)
		{
			$Peso_BoteOxid = $BoteOxid * $Prom_BoteOxid;
			$Unid_BoteOxid = $BoteOxid;			
		}
		else
		{
			$Peso_BoteOxid = 0;
			$Unid_BoteOxid = 0;		
		}
		$Valores.= "&boteoxid=".$Unid_BoteOxid."&peso_boteoxid=".$Peso_BoteOxid;
		if($CuRecup != '' && $CuRecup != 0)
		{
			$Peso_CuRecup = $CuRecup * $Prom_CuRecup;
			$Unid_CuRecup = $CuRecup;			
		}
		else
		{
			$Peso_CuRecup = 0;
			$Unid_CuRecup = 0;
		}
		$Valores.= "&curecup=".$Unid_CuRecup."&peso_curecup=".$Peso_CuRecup;
		if($AnodCirc != '' && $AnodCirc != 0)
		{
			$Peso_AnodCirc = $AnodCirc * $Prom_AnodCirc;
			$Unid_AnodCirc = $AnodCirc;			
		}
		else
		{
			$Peso_AnodCirc = 0;
			$Unid_AnodCirc = 0;	
		}
		$Valores.= "&anodcirc=".$Unid_AnodCirc."&peso_anodcirc=".$Peso_AnodCirc;
		if($Moldes != '' && $Moldes != 0)
		{
			$Peso_Moldes = $Moldes * $Prom_Moldes;
			$Unid_Moldes = $Moldes;			
		}
		else
		{
			$Peso_Moldes = 0;
			$Unid_Moldes = 0;			
		}
		$Valores.= "&moldes=".$Unid_Moldes."&peso_moldes=".$Peso_Moldes;
		if($Placas != '' && $Placas != 0)
		{
			$Peso_Placas = $Placas * $Prom_Placas;
			$Unid_Placas = $Placas;			
		}
		else
		{
			$Peso_Placas = 0;
			$Unid_Placas = 0;
		}
		$Valores.= "&placas=".$Unid_Placas."&peso_placas=".$Peso_Placas;
		if($CuPiso != '' && $CuPiso != 0)
		{
			$Peso_CuPiso = $CuPiso * $Prom_CuPiso;
			$Unid_CuPiso = $CuPiso;			
		}
		else
		{
			$Peso_CuPiso = 0;
			$Unid_CuPiso = 0;	
		}
		$Valores.= "&cupiso=".$Unid_CuPiso."&peso_cupiso=".$Peso_CuPiso;
		
		$UnidTotal = $Tallarines + $Rebalses + $Queques + $BoteOxid + $BoteAlb + $Chatarra + $Maceteros + $CuRecup + $AnodCirc + $Moldes + $Placas + $CuPiso;
		$Total_Unid = ($unid_total - $TotalUnidCircRaf) + $UnidTotal;
		$PesoTotal = $Peso_Tallarines + $Peso_Rebalses + $Peso_Queques + $Peso_BoteOxid + $Peso_BoteAlb + $Peso_Chatarra + $Peso_Maceteros + $Peso_CuRecup + $Peso_AnodCirc + $Peso_Moldes + $Peso_Placas + $Peso_CuPiso;
		$Total_Peso = ($peso_total - $TotalPesoCircRaf) + $PesoTotal;
		
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
	$Consulta.= " WHERE cod_clase = 8000";
	$rs = mysqli_query($link, $Consulta);
	while($Fila = mysql_fetch_array($rs))
	{
		if($Fila["cod_subclase"] == 1)
			$Prom_Tallarines = $Fila["valor_subclase1"];

		if($Fila["cod_subclase"] == 2)
			$Prom_Maceteros = $Fila["valor_subclase1"];
	
		if($Fila["cod_subclase"] == 3)
			$Prom_Rebalses = $Fila["valor_subclase1"];

		if($Fila["cod_subclase"] == 4)
			$Prom_Queques = $Fila["valor_subclase1"];

		if($Fila["cod_subclase"] == 5)
			$Prom_Chatarra = $Fila["valor_subclase1"];

		if($Fila["cod_subclase"] == 6)
			$Prom_BoteAlb = $Fila["valor_subclase1"];

		if($Fila["cod_subclase"] == 7)
			$Prom_BoteOxid = $Fila["valor_subclase1"];

		if($Fila["cod_subclase"] == 8)
			$Prom_CuRecup = $Fila["valor_subclase1"];

		if($Fila["cod_subclase"] == 9)
			$Prom_AnodCirc = $Fila["valor_subclase1"];

		if($Fila["cod_subclase"] == 10)
			$Prom_Moldes = $Fila["valor_subclase1"];

		if($Fila["cod_subclase"] == 13)
			$Prom_Placas = $Fila["valor_subclase1"];

		if($Fila["cod_subclase"] == 15)
			$Prom_CuPiso = $Fila["valor_subclase1"];
	
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
	f.Total.value = f.Rebalses.value * 1 + f.Maceteros.value * 1 + f.Queques.value * 1 + f.Tallarines.value * 1; 
	f.Total.value = f.Total.value * 1+ f.Chatarra.value * 1 + f.BoteAlb.value * 1 + f.BoteOxid.value * 1 + f.CuRecup.value * 1;
	f.Total.value = f.Total.value * 1+ f.AnodCirc.value * 1 + f.Moldes.value * 1 + f.Placas.value * 1 + f.CuPiso.value * 1;	

	f.PesoTotal.value = ((f.Rebalses.value * f.Prom_Rebalses.value) * 1) + ((f.Maceteros.value * f.Prom_Maceteros.value) * 1);
    f.PesoTotal.value = (f.PesoTotal.value * 1)+ ((f.Queques.value * f.Prom_Queques.value) * 1) + ((f.Tallarines.value * f.Prom_Tallarines.value) * 1); 
	f.PesoTotal.value = (f.PesoTotal.value * 1)+ ((f.Chatarra.value * f.Prom_Chatarra.value) * 1) + ((f.BoteAlb.value * f.Prom_BoteAlb.value) * 1);
	f.PesoTotal.value = (f.PesoTotal.value * 1)+ ((f.BoteOxid.value * f.Prom_BoteOxid.value) * 1) + ((f.CuRecup.value * f.Prom_CuRecup.value) * 1) + ((f.CuPiso.value * f.Prom_CuPiso.value) * 1);
	f.PesoTotal.value = (f.PesoTotal.value * 1)+ ((f.AnodCirc.value * f.Prom_AnodCirc.value) * 1) + ((f.Moldes.value * f.Prom_Moldes.value) * 1) + ((f.Placas.value * f.Prom_Placas.value) * 1);	
	
	f.Peso_Rebalses.value = f.Rebalses.value * f.Prom_Rebalses.value;
	f.Peso_Tallarines.value = f.Tallarines.value * f.Prom_Tallarines.value;
	f.Peso_Maceteros.value = f.Maceteros.value * f.Prom_Maceteros.value;
	f.Peso_Chatarra.value = f.Chatarra.value * f.Prom_Chatarra.value;
	f.Peso_Queques.value = f.Queques.value * f.Prom_Queques.value;
	f.Peso_Moldes.value = f.Moldes.value * f.Prom_Moldes.value;
	f.Peso_AnodCirc.value = f.AnodCirc.value * f.Prom_AnodCirc.value;
	f.Peso_CuRecup.value = f.CuRecup.value * f.Prom_CuRecup.value;
	f.Peso_BoteAlb.value = f.BoteAlb.value * f.Prom_BoteAlb.value;
	f.Peso_BoteOxid.value = f.BoteOxid.value * f.Prom_BoteOxid.value;
	f.Peso_Placas.value = f.Placas.value * f.Prom_Placas.value;
	f.Peso_CuPiso.value = f.CuPiso.value * f.Prom_CuPiso.value;
	

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
				f.action = "raf_ingreso_circulantes_raf.php?Proceso=G&Proceso2=G";
				f.submit();
				break;	

		case "G2":
				f.action = "raf_ingreso_circulantes_raf.php?Proceso=G&Proceso2=M";
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
  <table width="429" height="140" border="0" class="TablaPrincipal">
    <tr> 
      <td width="421" align="center">
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
		<table width="362" border="1" cellspacing="" cellpadding="0" class="TablaInterior">
          <tr class="ColorTabla01"> 
            <td colspan="4" align="center">Circulantes Raf</td>
          </tr>
          <tr class="Detalle01"> 
            <td width="114" align="center">Descripci&oacute;n</td>
            <td width="80" align="center">Cantidad</td>
            <td width="79" align="center">Peso Prom</td>
            <td width="80" align="center">Peso Total</td>
          </tr>
          <tr> 
            <td>Tallarines</td>
            <td align="center"><input name="Tallarines" type="text" onBlur="Calcula();" value="<? echo $Tallarines?>" size="10"></td>
            <td align="center"><input name="Prom_Tallarines" type="text" onBlur="Calcula();" value="<? echo $Prom_Tallarines?>" size="10"></td>
            <td align="center"><input name="Peso_Tallarines" type="text" value="<? echo $Peso_Tallarines?>" size="10"></td>
          </tr>
          <tr> 
            <td>Fondo Maceteros</td>
            <td align="center"><input type="text" name="Maceteros" size="10 "value="<? echo $Maceteros?>" onBlur="Calcula();"></td>
            <td align="center"><input name="Prom_Maceteros" type="text" onBlur="Calcula();" value="<? echo $Prom_Maceteros?>" size="10"></td>
            <td align="center"><input name="Peso_Maceteros" type="text" value="<? echo $Peso_Maceteros?>" size="10"></td>
          </tr>
          <tr> 
            <td>Rebalses</td>
            <td align="center"><input type="text" name="Rebalses" size="10" value="<? echo $Rebalses?>" onBlur="Calcula();"></td>
            <td align="center"><input name="Prom_Rebalses" type="text" onBlur="Calcula();" value="<? echo $Prom_Rebalses?>" size="10"></td>
            <td align="center"><input name="Peso_Rebalses" type="text" value="<? echo $Peso_Rebalses?>" size="10"></td>
          </tr>
          <tr> 
            <td>Queques</td>
            <td align="center"><input type="text" name="Queques" size="10" value="<? echo $Queques?>" onBlur="Calcula();"></td>
            <td align="center"><input name="Prom_Queques" type="text" onBlur="Calcula();" value="<? echo $Prom_Queques?>" size="10"></td>
            <td align="center"><input name="Peso_Queques" type="text" value="<? echo $Peso_Queques?>" size="10"></td>
          </tr>
          <tr> 
            <td>Chatatarra</td>
            <td align="center"><input type="text" name="Chatarra" size="10" value="<? echo $Chatarra?>" onBlur="Calcula();"></td>
            <td align="center"><input name="Prom_Chatarra" type="text" onBlur="Calcula();" value="<? echo $Prom_Chatarra?>" size="10"></td>
            <td align="center"><input name="Peso_Chatarra" type="text" value="<? echo $Peso_Chatarra?>" size="10"></td>
          </tr>
          <tr> 
            <td>Bote Alba&ntilde;il</td>
            <td align="center"><input type="text" name="BoteAlb" size="10" value="<? echo $BoteAlb?>" onBlur="Calcula();"></td>
            <td align="center"><input name="Prom_BoteAlb" type="text" onBlur="Calcula();" value="<? echo $Prom_BoteAlb?>" size="10"></td>
            <td align="center"><input name="Peso_BoteAlb" type="text" value="<? echo $Peso_BoteAlb?>" size="10"></td>
          </tr>
          <tr> 
            <td>Bote Oxido</td>
            <td align="center"><input type="text" name="BoteOxid" size="10" value="<? echo $BoteOxid?>" onBlur="Calcula();"></td>
            <td align="center"><input name="Prom_BoteOxid" type="text" onBlur="Calcula();" value="<? echo $Prom_BoteOxid?>" size="10"></td>
            <td align="center"><input name="Peso_BoteOxid" type="text" value="<? echo $Peso_BoteOxid?>" size="10"></td>
          </tr>
          <tr> 
            <td>Cobre Recuperado</td>
            <td align="center"><input type="text" name="CuRecup" size="10" value="<? echo $CuRecup?>" onBlur="Calcula();"></td>
            <td align="center"><input name="Prom_CuRecup" type="text" onBlur="Calcula();" value="<? echo $Prom_CuRecup?>" size="10"></td>
            <td align="center"><input name="Peso_CuRecup" type="text" value="<? echo $Peso_CuRecup?>" size="10"></td>
          </tr>
          <tr> 
            <td height="20">Anodos Circulantes</td>
            <td align="center"><input type="text" name="AnodCirc" size="10" value="<? echo $AnodCirc?>" onBlur="Calcula();"></td>
            <td align="center"><input name="Prom_AnodCirc" type="text" onBlur="Calcula();" value="<? echo $Prom_AnodCirc?>" size="10"></td>
            <td align="center"><input name="Peso_AnodCirc" type="text" value="<? echo $Peso_AnodCirc?>" size="10"></td>
          </tr>
          <tr> 
            <td>Moldes</td>
            <td align="center"><input type="text" name="Moldes" size="10" value="<? echo $Moldes?>" onBlur="Calcula();"></td>
            <td align="center"><input name="Prom_Moldes" type="text" onBlur="Calcula();" value="<? echo $Prom_Moldes?>" size="10"></td>
            <td align="center"><input name="Peso_Moldes" type="text" value="<? echo $Peso_Moldes?>" size="10"></td>
          </tr>
          <tr> 
            <td>Placas</td>
            <td align="center"><input type="text" name="Placas" size="10" value="<? echo $Placas?>" onBlur="Calcula();"></td>
            <td align="center"><input name="Prom_Placas" type="text" onBlur="Calcula();" value="<? echo $Prom_Placas?>" size="10"></td>
            <td align="center"><input name="Peso_Placas" type="text" value="<? echo $Peso_Placas?>" size="10"></td>
          </tr>
          <tr> 
            <td>Cu Bajo Piso</td>
            <td align="center"><input type="text" name="CuPiso" size="10" value="<? echo $CuPiso?>" onBlur="Calcula();"></td>
            <td align="center"><input name="Prom_CuPiso" type="text" onBlur="Calcula();" value="<? echo $Prom_CuPiso?>" size="10"></td>
            <td align="center"><input name="Peso_CuPiso" type="text" value="<? echo $Peso_CuPiso?>" size="10"></td>
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
<input type="hidden" name="TotalUnidCircRaf" value="<? echo $TotalUnidCircRaf; ?>">
<input type="hidden" name="TotalPesoCircRaf" value="<? echo $TotalPesoCircRaf; ?>">
</form>
</body>
</html>
