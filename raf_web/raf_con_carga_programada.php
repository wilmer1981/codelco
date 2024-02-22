<?
	include("../principal/conectar_pac_web.php");
	$Fechita = date("Y-m-d");
	$Fecha2 = date("Y-m-d", mktime(0,0,0,intval(substr($Fechita, 5, 2)) ,intval(substr($Fechita, 8, 2)) - 10 ,intval(substr($Fechita, 0, 4))));
	$Ano1=substr($Fechita,0,4);
	$Mes1=substr($Fechita,5,2);
	$Ano2=substr($Fecha2,0,4);
	$Mes2=substr($Fecha2,5,2);
	$AnoI=$Ano2."".$Mes2;
	$AnoF=$Ano1."".$Mes1;
	
	$Consulta = "SELECT MIN(fecha_carga) as fecha_carga FROM raf_web.movimientos";
	if(strlen($Hornada) == 4)
		$Consulta.= " WHERE right(hornada,4) = $Hornada";
	else
		$Consulta.= " WHERE right(hornada,5) = $Hornada";
	$Consulta.=" and left(hornada,6) between '".$AnoI."' and '".$AnoF."'";
	//echo $Consulta;
	$rs = mysql_query($Consulta);
	if($row = mysql_fetch_array($rs))
	{
		$Dia = substr($row[fecha_carga],8,2);
		$Ano = substr($row[fecha_carga],0,4);
		$Mes = substr($row[fecha_carga],5,2);
		if($Dia != '')
			$Encontrado = "S";
		else	
			$Encontrado = "N";
	}

	$Consulta = "SELECT * FROM raf_web.movimientos";
	if(strlen($Hornada) == 4)
		$Consulta.= " WHERE right(hornada,4) = $Hornada";
	else
		$Consulta.= " WHERE right(hornada,5) = $Hornada";
	$Consulta.=" and left(hornada,6) between '".$AnoI."' and '".$AnoF."'";

	$rs = mysql_query($Consulta);
	if($row = mysql_fetch_array($rs))
	{
		$Solera = $row[solera];
	}
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Proceso(opc)
{
	var f = document.FrmPrincipal;
	
	switch(opc)
	{
		case "P":
			f.BtnImprimir.style.visibility = 'hidden';
			f.BtnSalir.style.visibility = 'hidden';
			window.print();
			f.BtnImprimir.style.visibility = '';
			f.BtnSalir.style.visibility = '';
			break;

		case "S":
			window.history.back();
			break;
	}
	
}	
</script>	
</head>

<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<body class="TablaPrincipal">
<form name="FrmPrincipal" method="post" action="">
  <table width="400" border="1" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td colspan="4" align="center"><strong> Conformacion Hornada (Carga Programada)</strong></td>
    </tr>
  </table>
  <br>
  <br> 	
  <table width="318" border="0" cellspacing="0" cellpadding="0" align="center" class="TablaPrincipal">
    <tr> 
      <td colspan="4" class="Detalle01"><strong>Hornada</strong>: <? echo $Hornada.'-'.$Solera;?></td>
      <td width="172" colspan="4" class="Detalle01"><strong>Fecha Creaci�n</strong>: <? echo $Dia.'-'.$Mes.'-'.$Ano;?></td>
    </tr>
  </table>
    <?
	if($Encontrado == "S")
	{
		$Consulta = "SELECT distinct turno FROM raf_web.movimientos";
		if(strlen($Hornada) == 4)
			$Consulta.= " WHERE right(hornada,4) = $Hornada";
		else
			$Consulta.= " WHERE right(hornada,5) = $Hornada";
		$Consulta.=" and left(hornada,6) between '".$AnoI."' and '".$AnoF."'  ORDER BY turno";
		//echo $Consulta;
		$RS = mysql_query($Consulta);
		while($row = mysql_fetch_array($RS))
		{		
            $AcumAs = 0;
            $AcumSb = 0;
            $AcumFe = 0;
            $AcumPeso = 0;
            $AcumUnid = 0;
			$cont = 0;

			$Consulta = "SELECT encargado FROM raf_web.movimientos";
			if(strlen($Hornada) == 4)
				$Consulta.= " WHERE right(hornada,4) = $Hornada";
			else
				$Consulta.= " WHERE right(hornada,5) = $Hornada";
			$Consulta.= " and left(hornada,6) between '".$AnoI."' and '".$AnoF."' AND turno = '$row[turno]'";
			$Consulta.= " ORDER BY hornada,turno,cod_producto,cod_subproducto";
			//echo "2".$Cosnulta;
			$rs2 = mysql_query($Consulta);
			$Row = mysql_fetch_array($rs2);
			
			$Consulta =" SELECT * FROM proyecto_modernizacion.funcionarios WHERE rut = '".$Row[encargado]."'";
			$resp = mysql_query($Consulta);
			$Fil = mysql_fetch_array($resp);
			echo'<table width="500" border="1" cellspacing="0" cellpadding="0" align="center">
			       <tr> 
				     <td colspan="9"><b>Encargado</b>: '.$Fil["apellido_paterno"].' '.$Fil["apellido_materno"].' '.$Fil["nombres"].'</td>
				  </tr>';
			echo' <tr class="ColorTabla01"> 
				     <td width="121" height="15" align="center">Productos</td>
				     <td width="52" align="center">grupo</td>
				     <td width="97" align="center">Fecha Traspaso</td>
				     <td width="46" align="center">Turno</td>
				     <td width="46" align="center">As</td>
				     <td width="46" align="center">Sb</td>
				     <td width="46" align="center">Fe</td>
				     <td width="70" align="center">Cantidad</td>
				     <td width="60" align="center">Peso</td>
				  </tr>';

			$Consulta = "SELECT * FROM raf_web.movimientos";
			if(strlen($Hornada) == 4)
				$Consulta.= " WHERE right(hornada,4) = $Hornada";
			else
				$Consulta.= " WHERE right(hornada,5) = $Hornada";
			$Consulta.= " and left(hornada,6) between '".$AnoI."' and '".$AnoF."' AND turno = '$row[turno]'";
			$Consulta.= " ORDER BY cod_producto,cod_subproducto,grupo";
			//echo "3".$Consulta;
			$rs = mysql_query($Consulta);
			while($Fila = mysql_fetch_array($rs))
			{
				echo'<tr>';
				  $Consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = $Fila["cod_producto"] AND cod_subproducto = $Fila[cod_subproducto]";
				  $rs1 = mysql_query($Consulta);
				  $fila = mysql_fetch_array($rs1); 			
				  echo'<td>'.$fila["abreviatura"].'&nbsp;</td>';
	
				  echo'<td align="center">'.$Fila["grupo"].'&nbsp;</td>';
					$Dia = substr($Fila[fecha_sea],8,2);
					$Ano = substr($Fila[fecha_sea],0,4);
					$Mes = substr($Fila[fecha_sea],5,2);					  	
				  echo'<td align="center">'.$Dia.'-'.$Mes.'-'.$Ano.'</td>';
				  echo'<td align="center">'.$Fila[turno].'</td>';

				  $Consulta = "SELECT valor, cod_leyes FROM sea_web.leyes_por_hornada ";
				  $Consulta.= " WHERE cod_producto = '".$Fila["cod_producto"]."'";
				  $Consulta.= " AND cod_subproducto = '".$Fila[cod_subproducto]."'";
				  $Consulta.= " AND hornada = '".$Fila[hornada_sea]."'";
				  $Consulta.= " AND (cod_leyes = '08' or cod_leyes ='09' or cod_leyes = '31') ";
				  $resp2 = mysql_query($Consulta);
				  $As = 0;
				  $Sb = 0;
				  $Fe = 0;
				  while($fila1 = mysql_fetch_array($resp2))
				  {
						if($fila1["cod_leyes"] == '08')
							$As = $fila1[valor];
						if($fila1["cod_leyes"] == '09')
							$Sb = $fila1[valor];
						if($fila1["cod_leyes"] == '31')
							$Fe = $fila1[valor];
				  }
                  if($As !=0)
				  {
	 				  $cont = $cont + 1;
	 				  $cont2 = $cont2 + 1;
				  } 	
				  echo'<td align="right">'.number_format($As,0,'','').'&nbsp;</td>';
				  echo'<td align="right">'.number_format($Sb,0,'','').'&nbsp;</td>';
				  echo'<td align="right">'.number_format($Fe,0,'','').'&nbsp;</td>';
				  echo'<td align="right">'.$Fila["unidades"].'&nbsp;</td>';
				  echo'<td align="right">'.$Fila["peso"].'&nbsp;</td>';
				echo'</tr>';
				$AcumAs = $AcumAs + $As;
				$AcumSb = $AcumSb + $Sb;
				$AcumFe = $AcumFe + $Fe;
				$AcumUnid = $AcumUnid + $Fila["unidades"];
				$AcumPeso = $AcumPeso + $Fila["peso"];

				$AcumAsTotal = $AcumAsTotal + $As;
				$AcumSbTotal = $AcumSbTotal + $Sb;
				$AcumFeTotal = $AcumFeTotal + $Fe;
				$AcumUnidTotal = $AcumUnidTotal + $Fila["unidades"];
				$AcumPesoTotal = $AcumPesoTotal + $Fila["peso"];
			}

			echo'<tr class="Detalle02"> 
				    <td colspan="4">TOTAL TURNO PROGRAMADO</td>';
					if($AcumAs != 0 || $AcumAs != '')
					{
						echo'<td align="right">'.number_format($AcumAs/$cont,0,'','').'&nbsp;</td>
						<td align="right">'.number_format($AcumSb/$cont,0,'','').'&nbsp;</td>
						<td align="right">'.number_format($AcumFe/$cont,0,'','').'&nbsp;</td>';
					}
					else
					{										
						echo'<td align="right">&nbsp;</td>
						<td align="right">&nbsp;</td>
						<td align="right">&nbsp;</td>';
					}
					echo'<td align="right">'.$AcumUnid.'&nbsp;</td>
				    <td align="right">'.$AcumPeso.'&nbsp;</td>
				  </tr>
			    </table><br>';

		}					
	}
		if($Encontrado == "S" AND $AcumAsTotal != 0)
		{
			echo'<table width="500" border="1" cellspacing="0" cellpadding="0" align="center">
			  <tr class="Detalle01"> 
				<td width="415">TOTAL PROGRAMADO</td>';		   
				echo'<td width="46" align="right">'.number_format($AcumAsTotal/$cont2,0,'','').'&nbsp;</td>';
				echo'<td width="46" align="right">'.number_format($AcumSbTotal/$cont2,0,'','').'&nbsp;</td>';
				echo'<td width="46" align="right">'.number_format($AcumFeTotal/$cont2,0,'','').'&nbsp;</td>';

			    echo'<td width="75" align="right">'.$AcumUnidTotal.'&nbsp;</td>';
				echo'<td width="60" align="right">'.$AcumPesoTotal.'&nbsp;</td>';
			echo'  </tr>
			</table><br>';
	    }
		if($Encontrado == "S" AND $AcumAsTotal == 0)
		{
			echo'<table width="500" border="1" cellspacing="0" cellpadding="0" align="center">
			  <tr class="Detalle01"> 
				<td width="450">TOTAL PROGRAMADO</td>';		   
				echo'<td width="75" align="right">'.$AcumUnidTotal.'&nbsp;</td>';
				echo'<td width="60" align="right">'.$AcumPesoTotal.'&nbsp;</td>';
			echo'  </tr>
			</table><br>';
	    }
  ?>		
  <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">  
	<tr>
	  <td align="center">	
 	   <input type="button" name="BtnImprimir" value="Imprimir" style="width:70px" onClick="Proceso('P');">
	   <? if($Valor != 1)
	   	  {	
	   ?>
	         <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
	   <?
		  } 	
	      else
	   	  {	
	   ?>
   	         <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="self.close()">
	   <? 
	   	  }	
	   ?>

      </td>
	</tr>
  </table>	
</form>
</body>
</html>
