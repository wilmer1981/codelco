<?php include("../principal/conectar_principal.php"); ?>
<html>
<head>
<title>Consulta Compromiso Venta</title>
<link href="../Principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(o)
{
	var f = document.frmPrincipal;
	switch (o)
	{
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
			f.submit();
			break;
		case "R":
			f.action = "sec_compromiso_venta_consulta.php";
			f.submit();
			break;
		case "E":
			f.action = "sec_compromiso_venta_consulta_excel.php";
			f.submit();
			break;
	}
}

function DetalleReal(tipo,mes,cliente,contrato)
{
	window.open("sec_compromiso_venta_consulta_detalle.php?Tipo=" + tipo + "&Mes=" + mes + "&Cliente=" + cliente + "&Contrato=" + contrato,"","top=50,left=10,width=500,height=400,scrollbars=yes,resizable = yes");
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" class="TablaInterior">
    <tr> 
      <td width="26%">Tipo</td>
      <td width="26%"><SELECT name="Tipo" onChange="Proceso('R');">
          <?php
	  	if ($Tipo == "C")
		{
			echo "<option value='E'>ENAMI</option>";
			echo "<option SELECTed value='C'>CODELCO</option>";
		}
		else
		{
			echo "<option SELECTed value='E'>ENAMI</option>";
			echo "<option value='C'>CODELCO</option>";
		}
	  ?>
        </SELECT> <SELECT name="Ano" onChange="Proceso('R');">
          <?php
			for ($i=2004;$i<=date("Y")+1;$i++)
			{
				if (isset($Ano))
				{
					if ($i == $Ano)
						echo "<option SELECTed value='".$i."'>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == date("Y"))
						echo "<option SELECTed value='".$i."'>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
		?>
        </SELECT></td>
      <td width="48%" colspan="2" align="right">&nbsp; </td>
    </tr>
    <tr> 
      <td> 
        <?php 
			if ($Tipo != "C")
				echo "Mercado";
			else echo "Asignacion"; 
			?>
      </td>
      <td> 
        <?php 
			if ($Tipo != "C")
			{
				echo "<SELECT name='Pais' onChange=\"Proceso('R')\" style='width:200px'>\n";
                echo "<option value='S'>Todos</option>\n";
				$Consulta = "SELECT * from sec_web.paises ";
				$Consulta.= " order by nombre_pais";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{
					if ($Pais == $Fila["cod_pais"])
						echo "<option value='".$Fila["cod_pais"]."' SELECTed>".ucwords(strtolower($Fila["nombre_pais"]))."</option>\n";
					else
						echo "<option value='".$Fila["cod_pais"]."'>".ucwords(strtolower($Fila["nombre_pais"]))."</option>\n";
				}
				echo "</SELECT>\n";
			}
			else
			{
				echo "<SELECT name='Pais' style='width:200px'>\n";
                echo "<option value='S'>Todos</option>\n";
				$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
				$Consulta.= " where cod_clase = '3016'";
				$Consulta.= " order by cod_subclase";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{
					if ($Pais == $Fila["nombre_subclase"])
						echo "<option value='".$Fila["nombre_subclase"]."' SELECTed>".$Fila["valor_subclase1"]."</option>\n";
					else
						echo "<option value='".$Fila["nombre_subclase"]."'>".$Fila["valor_subclase1"]."</option>\n";
				}
				echo "</SELECT>\n";
			}
			?>
      </td>
      <td> 
        <?php 
			if ($Tipo != "C")
				echo "<div align='right'>Cliente</div>\n";
			?>
      </td>
      <td> 
        <?php 
			if ($Tipo != "C")
			{
				echo "<SELECT name='CmbCliente' onChange=\"Proceso('R')\"  style='width:330px'>\n";
                echo "<option value='S'>Todos</option>\n";
				if ($Pais == "001")
				{
					$Consulta = "SELECT * from sec_web.cliente_venta ";
					$Consulta.= " where substring(cod_cliente,1,2) = 'ZU' ";
					$Consulta.= " and substring(cod_cliente,1,2) <> 'VD'";//VENTA DIRECTA 
					$Consulta.= " order by sigla_cliente";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Respuesta))
					{
						if ($CmbCliente == $Fila["cod_cliente"])
							echo "<option value='".$Fila["cod_cliente"]."' SELECTed>".strtoupper($Fila["cod_cliente"])." - ".ucwords(strtolower($Fila["sigla_cliente"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_cliente"]."'>".strtoupper($Fila["cod_cliente"])." - ".ucwords(strtolower($Fila["sigla_cliente"]))."</option>\n";
					}
				}
				else
				{
					$Consulta = "SELECT * from sec_web.cliente_venta ";
					$Consulta.= " where cod_pais = '".$Pais."'";
					$Consulta.= " and substring(cod_cliente,1,2) <> 'ZU'";
					$Consulta.= " and substring(cod_cliente,1,2) <> 'VD'";//VENTA DIRECTA
					$Consulta.= " order by sigla_cliente";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Respuesta))
					{
						if ($CmbCliente == $Fila["cod_cliente"])
							echo "<option value='".$Fila["cod_cliente"]."' SELECTed>".strtoupper($Fila["cod_cliente"])." - ".ucwords(strtolower($Fila["sigla_cliente"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_cliente"]."'>".strtoupper($Fila["cod_cliente"])." - ".ucwords(strtolower($Fila["sigla_cliente"]))."</option>\n";
					}
				}
				echo "</SELECT>\n";
			}
			else //CODELCO
			{
				echo "<input type='hidden' name='CmbCliente'>\n";
			}
              ?>
      </td>
    </tr>
    <tr align="center"> 
      <td colspan="4"> <input name="btnOk" type="button" value="Consulta" style="width:70px;" onClick="Proceso('R');"> 
        <input name="btnExcel" type="button" id="btnExcel2" value="Excel" style="width:70px;" onClick="Proceso('E');"> 
        <input name="btnSalir" type="button" id="btnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S');"> 
      </td>
    </tr>
  </table>
<br>
<br>
  <table width="1030" border="1" cellpadding="0" cellspacing="0">
    <tr class="ColorTabla01"> 
      <td width="120"> <div align="center">Cliente</div></td>
      <?php
if ($Tipo != "C")	  
{
	echo "<td width='13%'><div align='center'>Contrato</div></td>\n";
}
?>
      <td width="70"> <div align="center"></div></td>
      <td width="70"> <div align="center">Ene</div></td>
      <td width="70"> <div align="center">Feb</div></td>
      <td width="70"> <div align="center">Mar</div></td>
      <td width="70"> <div align="center">Abr</div></td>
      <td width="70"> <div align="center">May</div></td>
      <td width="70"> <div align="center">Jun</div></td>
      <td width="70"> <div align="center">Jul</div></td>
      <td width="70"> <div align="center">Ago</div></td>
      <td width="70"> <div align="center">Sep</div></td>
      <td width="70"> <div align="center">Oct</div></td>
      <td width="70"> <div align="center">Nov</div></td>
      <td width="70"> <div align="center">Dic</div></td>
    </tr>
    <?php  

if ($Tipo == "E")
{
	$Consulta = "SELECT * from sec_web.paises where cod_pais = '".$Pais."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
		$Sigla = $Fila["abreviatura"];
	$Consulta = "SELECT * from sec_web.programa_ventas t1 inner join sec_web.cliente_venta t2 ";
	$Consulta.= " on t1.cod_cliente = t2.cod_cliente";
	$Consulta.= " where t1.enm_code = '".$Tipo."' and t1.ano = '".$Ano."'";
	if (($Pais != "S") && (isset($Pais)))
		$Consulta.= " and substring(t2.cod_cliente,1,2) = '".$Sigla."'";
	if (($CmbCliente != "S") && (isset($CmbCliente)))
		$Consulta.= " and t2.cod_cliente = '".$CmbCliente."'";
	$Consulta.= " order by substring(t2.cod_cliente,1,2),t1.cod_contrato,t2.cod_cliente";
}
else
{
	$Consulta = "SELECT * from sec_web.programa_ventas ";
	$Consulta.= " where enm_code = '".$Tipo."' and ano = '".$Ano."'";
	if (($Pais != "S") && (isset($Pais)))
		$Consulta.= " and cod_cliente = '".$Pais."'";
	$Consulta.= " order by cod_cliente ";
}
$CodPaisAnt = "";
$CodPais = "";
$SaldoEnami = 0;
$Respuesta = mysqli_query($link, $Consulta);
$i=1;
while ($Fila = mysqli_fetch_assoc($Respuesta))
{
	if ($Tipo == "E")
	{
		$Consulta = "SELECT * from sec_web.cliente_venta where cod_cliente = '".$Fila["cod_cliente"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_assoc($Resp2))
			$NomCliente = $Fila2["sigla_cliente"];
		else
			$NomCliente = "";
	}
	else
	{
		$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase = '3016' and nombre_subclase = '".$Fila["cod_cliente"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_assoc($Resp2))
			$NomCliente = $Fila2["valor_subclase1"];
		else
			$NomCliente = "";
	}
	//CORTE DE PAIS
	$CodPais = substr($Fila["cod_cliente"],0,2);
	if (($CodPaisAnt != $CodPais) && $Tipo!="C")
	{
		if ($i != 1)
		{
			$Consulta = "SELECT * from sec_web.paises where abreviatura = '".$CodPaisAnt."'";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
				$NomPais = $Fila2["nombre_pais"];
			echo "<tr bgcolor='#FFFF99'>";
			if ($Tipo != "C")
				echo "<td colspan='2' rowspan='3'><strong>TOTAL ".strtoupper($NomPais)."</strong></td>";
			else
				echo "<td rowspan='3'><strong>TOTAL ".strtoupper($NomPais)."</strong></td>";			
			echo "<td>COMP.</td>";
			echo "<td align='right'>".number_format($SubTotalCompEne,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalCompFeb,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalCompMar,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalCompAbr,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalCompMay,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalCompJun,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalCompJul,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalCompAgo,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalCompSep,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalCompOct,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalCompNov,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalCompDic,0,",",".")."</td>";				
			echo "</tr>";
			echo "<tr bgcolor='#FFFF99'>";
			echo "<td>REAL</td>";
			echo "<td align='right'>".number_format($SubTotalRealEne,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalRealFeb,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalRealMar,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalRealAbr,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalRealMay,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalRealJun,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalRealJul,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalRealAgo,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalRealSep,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalRealOct,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalRealNov,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalRealDic,0,",",".")."</td>";				
			echo "</tr>";
			echo "<tr bgcolor='#FFFF99'>";
			echo "<td>SALDO</td>";
			echo "<td align='right'>".number_format($SubTotalSaldoEne,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalSaldoFeb,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalSaldoMar,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalSaldoAbr,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalSaldoMay,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalSaldoJun,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalSaldoJul,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalSaldoAgo,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalSaldoSep,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalSaldoOct,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalSaldoNov,0,",",".")."</td>";
			echo "<td align='right'>".number_format($SubTotalSaldoDic,0,",",".")."</td>";				
			echo "</tr>";
			//COMP
			$SubTotalCompEne = 0;
			$SubTotalCompFeb = 0;
			$SubTotalCompMar = 0;
			$SubTotalCompAbr = 0;
			$SubTotalCompMay = 0;
			$SubTotalCompJun = 0;
			$SubTotalCompJul = 0;
			$SubTotalCompAgo = 0;
			$SubTotalCompSep = 0;
			$SubTotalCompOct = 0;
			$SubTotalCompNov = 0;
			$SubTotalCompDic = 0;
			//REAL
			$SubTotalRealEne = 0;
			$SubTotalRealFeb = 0;
			$SubTotalRealMar = 0;
			$SubTotalRealAbr = 0;
			$SubTotalRealMay = 0;
			$SubTotalRealJun = 0;
			$SubTotalRealJul = 0;
			$SubTotalRealAgo = 0;
			$SubTotalRealSep = 0;
			$SubTotalRealOct = 0;
			$SubTotalRealNov = 0;
			$SubTotalRealDic = 0;
			//SALDO
			$SubTotalSaldoEne = 0;
			$SubTotalSaldoFeb = 0;
			$SubTotalSaldoMar = 0;
			$SubTotalSaldoAbr = 0;
			$SubTotalSaldoMay = 0;
			$SubTotalSaldoJun = 0;
			$SubTotalSaldoJul = 0;
			$SubTotalSaldoAgo = 0;
			$SubTotalSaldoSep = 0;
			$SubTotalSaldoOct = 0;
			$SubTotalSaldoNov = 0;
			$SubTotalSaldoDic = 0;			
		}
	}
	$CodPaisAnt = substr($Fila["cod_cliente"],0,2);		
	echo "<tr> \n";
	echo "<td rowspan='3'>".$NomCliente."</td>\n";
	if ($Tipo != "C")	 
		echo "<td rowspan='3'>".$Fila["cod_contrato"]."</td>\n";
	//COMPROMISO
	$TotalCompEne = $TotalCompEne + $Fila["ene"];
	$TotalCompFeb = $TotalCompFeb + $Fila["feb"];
	$TotalCompMar = $TotalCompMar + $Fila["mar"];
	$TotalCompAbr = $TotalCompAbr + $Fila["abr"];
	$TotalCompMay = $TotalCompMay + $Fila["may"];
	$TotalCompJun = $TotalCompJun + $Fila["jun"];
	$TotalCompJul = $TotalCompJul + $Fila["jul"];
	$TotalCompAgo = $TotalCompAgo + $Fila["ago"];
	$TotalCompSep = $TotalCompSep + $Fila["sep"];
	$TotalCompOct = $TotalCompOct + $Fila["oct"];
	$TotalCompNov = $TotalCompNov + $Fila["nov"];
	$TotalCompDic = $TotalCompDic + $Fila["dic"];
	//SUBTOTAL COMPROMISO
	$SubTotalCompEne = $SubTotalCompEne + $Fila["ene"];
	$SubTotalCompFeb = $SubTotalCompFeb + $Fila["feb"];
	$SubTotalCompMar = $SubTotalCompMar + $Fila["mar"];
	$SubTotalCompAbr = $SubTotalCompAbr + $Fila["abr"];
	$SubTotalCompMay = $SubTotalCompMay + $Fila["may"];
	$SubTotalCompJun = $SubTotalCompJun + $Fila["jun"];
	$SubTotalCompJul = $SubTotalCompJul + $Fila["jul"];
	$SubTotalCompAgo = $SubTotalCompAgo + $Fila["ago"];
	$SubTotalCompSep = $SubTotalCompSep + $Fila["sep"];
	$SubTotalCompOct = $SubTotalCompOct + $Fila["oct"];
	$SubTotalCompNov = $SubTotalCompNov + $Fila["nov"];
	$SubTotalCompDic = $SubTotalCompDic + $Fila["dic"];
	echo "<td>Comp.</td>\n";
	echo "<td align='right'>".number_format($Fila["ene"],0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($Fila["feb"],0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($Fila["mar"],0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($Fila["abr"],0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($Fila["may"],0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($Fila["jun"],0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($Fila["jul"],0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($Fila["ago"],0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($Fila["sep"],0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($Fila["oct"],0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($Fila["nov"],0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($Fila["dic"],0,",",".")."</td>\n";
	echo "</tr>\n";
	echo "<tr> \n";
	echo "<td height='18'>Real</td>\n";
	if ($Tipo == "E")
	{
		$Consulta = "SELECT t3.mes_cuota as mes, sum(t1.peso_paquetes) as peso,t3.cod_cliente,t3.cod_contrato ";
		$Consulta.= "from sec_web.paquete_catodo t1 ";
		$Consulta.=" inner join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia and t1.fecha_embarque=t2.fecha_guia	";
		$Consulta.= " inner join sec_web.programa_enami t3 on t3.corr_enm = t2.corr_enm ";		
		$Consulta.= " where t1.cod_producto = '18' and t1.cod_subproducto = '40'"; //GRADO A
		$Consulta.= " and t3.cod_cliente = '".$Fila["cod_cliente"]."'";
		$Consulta.= " and t3.cod_contrato = '".$Fila["cod_contrato"]."'";
		$Consulta.= " group by t3.cod_cliente,t3.cod_contrato, t3.mes_cuota";
		
	}
	else
	{
		if ($Tipo == "C")
		{
			$Consulta = "SELECT month(t2.fecha_guia) as mes,sum(t1.peso_paquetes) as peso,t3.cod_cliente,t3.cod_contrato ";
			$Consulta.= "from sec_web.paquete_catodo t1 ";
			$Consulta.=" inner join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia and t1.fecha_embarque=t2.fecha_guia	";
			$Consulta.= " inner join sec_web.programa_codelco t3 on t3.corr_codelco = t2.corr_enm ";		
			$Consulta.= " where t1.cod_producto = '18' and t1.cod_subproducto = '40'"; //GRADO A
			$Consulta.= " and t3.cod_contrato_maquila = '".$Fila["cod_cliente"]."'";
			$Consulta.= " group by t3.cod_contrato_maquila, month(t2.fecha_guia)";
			
		}
	}
	//echo $Consulta."<br>";
	$Resp2 = mysqli_query($link, $Consulta);
	$PesoReal = 0;
	$ArrMeses = array();
	while ($Fila2 = mysqli_fetch_array($Resp2))
	{
		$ArrMeses[$Fila2["mes"]][0] = $Fila2["mes"];
		$ArrMeses[$Fila2["mes"]][1] = $Fila2["peso"];
		$ArrMeses[$Fila2["mes"]][2] = $Fila2["cod_cliente"];
		$ArrMeses[$Fila2["mes"]][3] = $Fila2["cod_contrato"];
	}	
	for ($i=1;$i<=12;$i++)
	{
		//REAL
		switch ($i)
		{
			case 1:
				$TotalRealEne = $TotalRealEne + $ArrMeses[$i][1];
				$SubTotalRealEne = $SubTotalRealEne + $ArrMeses[$i][1];
				break;
			case 2:
				$TotalRealFeb = $TotalRealFeb + $ArrMeses[$i][1];
				$SubTotalRealFeb = $SubTotalRealFeb + $ArrMeses[$i][1];
				break;
			case 3:
				$TotalRealMar = $TotalRealMar + $ArrMeses[$i][1];
				$SubTotalRealMar = $SubTotalRealMar + $ArrMeses[$i][1];
				break;
			case 4:
				$TotalRealAbr = $TotalRealAbr + $ArrMeses[$i][1];
				$SubTotalRealAbr = $SubTotalRealAbr + $ArrMeses[$i][1];
				break;
			case 5:
				$TotalRealMay = $TotalRealMay + $ArrMeses[$i][1];
				$SubTotalRealMay = $SubTotalRealMay + $ArrMeses[$i][1];
				break;
			case 6:
				$TotalRealJun = $TotalRealJun + $ArrMeses[$i][1];
				$SubTotalRealJun = $SubTotalRealJun + $ArrMeses[$i][1];
				break;
			case 7:
				$TotalRealJul = $TotalRealJul + $ArrMeses[$i][1];
				$SubTotalRealJul = $SubTotalRealJul + $ArrMeses[$i][1];
				break;
			case 8:
				$TotalRealAgo = $TotalRealAgo + $ArrMeses[$i][1];
				$SubTotalRealAgo = $SubTotalRealAgo + $ArrMeses[$i][1];
				break;
			case 9:
				$TotalRealSep = $TotalRealSep + $ArrMeses[$i][1];
				$SubTotalRealSep = $SubTotalRealSep + $ArrMeses[$i][1];
				break;
			case 10:
				$TotalRealOct = $TotalRealOct + $ArrMeses[$i][1];
				$SubTotalRealOct = $SubTotalRealOct + $ArrMeses[$i][1];
				break;
			case 11:
				$TotalRealNov = $TotalRealNov + $ArrMeses[$i][1];
				$SubTotalRealNov = $SubTotalRealNov + $ArrMeses[$i][1];
				break;
			case 12:
				$TotalRealDic = $TotalRealDic + $ArrMeses[$i][1];
				$SubTotalRealDic = $SubTotalRealDic + $ArrMeses[$i][1];
				break;
		}	
		echo "<td align='right'><a href=\"JavaScript:DetalleReal('".$Tipo."','".$i."','".$ArrMeses[$i][2]."','".$ArrMeses[$i][3]."')\">".number_format($ArrMeses[$i][1],0,",",".")."</a></td>\n";		
	}
	echo "</tr>\n";
	$SaldoEne = ($Fila["ene"]-$ArrMeses[1][1]);
	$SaldoFeb = $SaldoEne + ($Fila["feb"]-$ArrMeses[2][1]);
	$SaldoMar = $SaldoFeb + ($Fila["mar"]-$ArrMeses[3][1]);
	$SaldoAbr = $SaldoMar + ($Fila["abr"]-$ArrMeses[4][1]);
	$SaldoMay = $SaldoAbr + ($Fila["may"]-$ArrMeses[5][1]);
	$SaldoJun = $SaldoMay + ($Fila["jun"]-$ArrMeses[6][1]);
	$SaldoJul = $SaldoJun + ($Fila["jul"]-$ArrMeses[7][1]);
	$SaldoAgo = $SaldoJul + ($Fila["ago"]-$ArrMeses[8][1]);
	$SaldoSep = $SaldoAgo + ($Fila["sep"]-$ArrMeses[9][1]);
	$SaldoOct = $SaldoSep + ($Fila["oct"]-$ArrMeses[10][1]);
	$SaldoNov = $SaldoOct + ($Fila["nov"]-$ArrMeses[11][1]);
	$SaldoDic = $SaldoNov + ($Fila["dic"]-$ArrMeses[12][1]);	
	//SALDO
	$TotalSaldoEne = $TotalSaldoEne + $SaldoEne;
	$TotalSaldoFeb = $TotalSaldoFeb + $SaldoFeb;
	$TotalSaldoMar = $TotalSaldoMar + $SaldoMar;
	$TotalSaldoAbr = $TotalSaldoAbr + $SaldoAbr;
	$TotalSaldoMay = $TotalSaldoMay + $SaldoMay;
	$TotalSaldoJun = $TotalSaldoJun + $SaldoJun;
	$TotalSaldoJul = $TotalSaldoJul + $SaldoJul;
	$TotalSaldoAgo = $TotalSaldoAgo + $SaldoAgo;
	$TotalSaldoSep = $TotalSaldoSep + $SaldoSep;
	$TotalSaldoOct = $TotalSaldoOct + $SaldoOct;
	$TotalSaldoNov = $TotalSaldoNov + $SaldoNov;
	$TotalSaldoDic = $TotalSaldoDic + $SaldoDic;
	//SUBTOTAL SALDO
	$SubTotalSaldoEne = $SubTotalSaldoEne + $SaldoEne;
	$SubTotalSaldoFeb = $SubTotalSaldoFeb + $SaldoFeb;
	$SubTotalSaldoMar = $SubTotalSaldoMar + $SaldoMar;
	$SubTotalSaldoAbr = $SubTotalSaldoAbr + $SaldoAbr;
	$SubTotalSaldoMay = $SubTotalSaldoMay + $SaldoMay;
	$SubTotalSaldoJun = $SubTotalSaldoJun + $SaldoJun;
	$SubTotalSaldoJul = $SubTotalSaldoJul + $SaldoJul;
	$SubTotalSaldoAgo = $SubTotalSaldoAgo + $SaldoAgo;
	$SubTotalSaldoSep = $SubTotalSaldoSep + $SaldoSep;
	$SubTotalSaldoOct = $SubTotalSaldoOct + $SaldoOct;
	$SubTotalSaldoNov = $SubTotalSaldoNov + $SaldoNov;
	$SubTotalSaldoDic = $SubTotalSaldoDic + $SaldoDic;
	echo "<tr bgcolor='#CCCCCC'> \n";
	echo "<td>Saldo</td>\n";
	echo "<td align='right'>".number_format($SaldoEne,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($SaldoFeb,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($SaldoMar,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($SaldoAbr,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($SaldoMay,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($SaldoJun,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($SaldoJul,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($SaldoAgo,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($SaldoSep,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($SaldoOct,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($SaldoNov,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($SaldoDic,0,",",".")."</td>\n";
	echo "</tr>\n";
	$i++;
}
?>
    <tr bgcolor="#FFCC66"> 
      <td rowspan="3"><strong>TOTAL</strong><strong>ES </strong></td>
      <?php
if ($Tipo != "C")	  
{
	echo "<td rowspan='3'>&nbsp;</td>\n";
}
?>
      <td>COMPR.</td>
      <td align="right"><?php echo number_format($TotalCompEne,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalCompFeb,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalCompMar,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalCompAbr,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalCompMay,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalCompJun,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalCompJul,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalCompAgo,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalCompSep,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalCompOct,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalCompNov,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalCompDic,0,",","."); ?></td>
    </tr>
    <tr bgcolor="#FFCC66"> 
      <td>REAL</td>
      <td align="right"><?php echo number_format($TotalRealEne,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalRealFeb,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalRealMar,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalRealAbr,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalRealMay,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalRealJun,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalRealJul,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalRealAgo,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalRealSep,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalRealOct,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalRealNov,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalRealDic,0,",","."); ?></td>
    </tr>
    <tr bgcolor="#FFCC66">
      <td>SALDO</td>
      <td align="right"><?php echo number_format($TotalSaldoEne,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalSaldoFeb,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalSaldoMar,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalSaldoAbr,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalSaldoMay,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalSaldoJun,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalSaldoJul,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalSaldoAgo,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalSaldoSep,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalSaldoOct,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalSaldoNov,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalSaldoDic,0,",","."); ?></td>
    </tr>
  </table>
</form>
</body>
</html>
