<?php
	include("../principal/conectar_principal.php"); 
	if (!isset($DiaIni))
	{
		$DiaIni = date("j");
		$MesIni = date("n");
		$AnoIni = date("Y");
		$DiaFin = date("j");
		$MesFin = date("n");
		$AnoFin = date("Y");
	}
	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
		
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
	
	$FechaInicio =date("Y-m-d", mktime(0,0,0,$MesIni,$DiaIni ,$AnoIni));	
	$FechaTermino =date("Y-m-d", mktime(0,0,0,$MesFin,($DiaFin +1),$AnoFin));	

	
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link rel="stylesheet" href="../Principal/estilos/css_principal.css" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action ="ref_pesopaquetes.php";
			f.submit();
			break;
		case "E":
			f.action ="sec_con_inf_pesaje_prod_excel.php";
			f.submit();
			break;
		case "S":
			f.action ="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
</script>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><strong>PESAJE  PRODUCCION HOJAS MADRES </strong></td>
    </tr>
  </table>
  <br>
  
  <br>
<?php

	
	$FechaAux = $fecha;
	$FechaTermino = $fecha;
	$contador = 0;
	$i = 1;
	for($i=1;$i<=5;$i++)
	{
		$xx[i]=" ";
	}
	while (date($FechaAux) <= date($FechaTermino))
	{
		$Consulta = "select ifnull(count(*),0) as total_reg from sec_web.produccion_catodo ";
		$Consulta.= " where cod_producto in ('66')  and fecha_produccion = '".$FechaAux."'";
		$total_1 = $Fila["total_reg"];
		//echo "cons".$Consulta;
		//$Consulta.= " and cod_muestra <> 'S'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			
			
			if ($Fila["total_reg"] <> 0)
			{
				echo "<br><table width='500' border='0' align='center' cellpadding='2' cellspacing='1' class='TablaInterior'>\n";
				echo "<tr> \n";
				echo "<td align='center'><strong>DIA: ".substr($FechaAux,8,2)."/".substr($FechaAux,5,2)."/".substr($FechaAux,0,4)."</strong></td>\n";
				echo "</tr>\n";
				echo "</table>\n";
			}
		}							
		$Consulta = "select distinct t2.cod_producto, t2.cod_subproducto, t2.descripcion ";
		$Consulta.= " from sec_web.produccion_catodo t1 inner join proyecto_modernizacion.subproducto t2 ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
		$Consulta.= " where (t1.cod_producto = '66' and t1.cod_subproducto IN ('1','2','4'))";
		$Consulta.= " order by  t2.cod_producto desc, t2.cod_subproducto asc";
		$Respuesta = mysqli_query($link, $Consulta);
		$TotalDia = 0;
		$TotalDiaTara = 0; 
		$Total_produccion = 0;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{						
			$Consulta = "select * from sec_web.produccion_catodo ";
			$Consulta.= " where cod_producto = '".$Fila["cod_producto"]."'";
			$Consulta.= " and cod_subproducto = '".$Fila["cod_subproducto"]."'";
			$Consulta.= " and fecha_produccion = '".$FechaAux."' order by cod_grupo";			
			//echo "Cons".$Consulta;
			$Respuesta2 = mysqli_query($link, $Consulta);
			$SubTotalPeso = 0;
			$CodProductoAnt = 0;
			$CodSubProductoAnt = 0;
			$SubTotalTara = 0;
			$SubtotalProduccion = 0; 
			while ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				if (($Fila2["cod_producto"] != $CodProductoAnt) || ($Fila2["cod_subproducto"] != $CodSubProductoAnt))				
				{
					echo "</table>\n";
					echo "<table width='500' border='1' align='center' cellpadding='0' cellspacing='0' class='TablaDetalle'>\n";
					echo "<tr align='center' class='ColorTabla01'> \n";
					echo "<td width='57'><strong>".$Fila2["cod_producto"]."</strong></td>\n";
					echo "<td width='330' colspan='6'><strong>".$Fila["descripcion"]."</strong></td>\n";
					echo "</tr> \n";	
					echo "<tr align='center' class='ColorTabla01'> \n";
					echo "<td width='87'>&nbsp;</td>\n";
					echo "<td width='76'>TURNO</td>\n";
					echo "<td width='76'>HORA PESAJE</td>\n";
					echo "<td width='62'>PESO BRUTO</td>\n";
					echo "<td width='65'>TARA A DESCONTAR</td>\n";
					echo "<td width='87'>PRODUCCION DIA</td>\n";
					echo "</tr>\n";
				}
				echo "<tr>\n";
				$Turno =" ";
				if (substr($Fila2["hora"],0,2) >= '08' && substr($Fila2["hora"],0,2) <'16')
				{
					$Turno = 'TURNO A';
					$contador = $contador + 1;
				}	
				if (substr($Fila2["hora"],0,2) >= '16' && substr($Fila2["hora"],0,2) <'23')
				{
					$Turno = 'TURNO B';
					$contador = $contador + 1;
				}	
				//if (substr($Fila2["hora"],0,2) >= '24' && substr($Fila2["hora"],0,2) <'07')
				if (substr($Fila2["hora"],0,2) >= '00' && substr($Fila2["hora"],0,2) <'07')

				{
					$Turno = 'TURNO C';
					$contador = $contador + 1;
				}	
				echo "<td align='center'>".$contador."</td>\n";
				echo "<td align='center'>".$Turno."</td>\n";
				echo "<td align='center'>".$Fila2["hora"]."</td>\n";
				echo "<td align='right'>".number_format($Fila2["peso_produccion"],0,",",".")."</td>\n";
				echo "<td align='right'>".$Fila2["peso_tara"]."</td>\n";
				$ProduccionDia = ($Fila2["peso_produccion"]) - ($Fila2["peso_tara"]); 
				echo "<td align='right'> ".$ProduccionDia." </td>\n";
				echo "</tr>\n";
				$SubTotalTara = $SubTotalTara + $Fila2["peso_tara"];
				$SubTotalPeso = ($SubTotalPeso + $Fila2["peso_produccion"]);
				$TotalDia = $TotalDia + $Fila2["peso_produccion"];
				$TotalDiaTara = $TotalDiaTara + $Fila2["peso_tara"];
				$CodProductoAnt = $Fila2["cod_producto"];
				$CodSubProductoAnt = $Fila2["cod_subproducto"];				
				$SubtotalProduccion = $SubtotalProduccion + $ProduccionDia;
				$Total_produccion = $Total_produccion + $ProduccionDia;
				$prod= "$Fila2["cod_producto"]$Fila2["cod_subproducto"]";	
		}
			
			if ($SubTotalPeso != 0)
			{
				switch ($prod)
				{
					case '661':
								$prod1='661';
								break;
					case '662':
								$prod2='662';
								break;
					case '664':
								$prod3='664';
								break;
					/*case '488':
								$prod4='488';
								break;

					case '489':
								$prod5='489';
								break;*/

						
				}
				echo "<tr>\n";				
				echo "<td align='right' colspan='3'><strong>SUB TOTAL PRODUCTO</strong></td>\n";
				echo "<td align='right'><strong>".number_format($SubTotalPeso,0,",",".")."</strong></td>\n";
				echo "<td align='right'><strong>".number_format($SubTotalTara,0,",",".")."</strong></td>\n";
		  		echo "<td align='right'><strong>".number_format($SubtotalProduccion,0,",",".")."</strong></td>\n";
				echo "</tr>\n<br>";						
			}
				echo "</table>\n";
		}		
		if ($TotalDia != 0)
		{	
			echo "<br>";
			echo "<table width='500' border='1' align='center' cellpadding='0' cellspacing='0' class='TablaDetalle'>\n";
			echo "<tr align='center' class='ColorTabla01'> \n";
			//echo "<tr>\n";				
			echo "<td align='right' colspan='3'><strong>TOTAL DIA :".substr($FechaAux,8,2)."/".substr($FechaAux,5,2)."/".substr($FechaAux,0,4)."</strong></td>\n";
			echo "<td align='right'><strong>".number_format($TotalDia,0,",",".")."</strong></td>\n";
			echo "<td align='right'><strong>".number_format($TotalDiaTara,0,",",".")."</strong></td>\n";
			echo "<td align='right'><strong>".number_format($Total_produccion,0,",",".")."</strong></td>\n";
			echo "</tr>\n";						
		}
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2),(intval(substr($FechaAux,8,2)) + 1),substr($FechaAux,0,4)));
		echo "</table>\n";

	}
	
?>
<?php
//AQUI SOLO LOS RECHAZOS

	$FechaAux = $fecha;
	$FechaTermino = $fecha;
	$contador = 0;
	$i = 1;
	for($i=1;$i<=5;$i++)
	{
		$xx[i]=" ";
	}
	while (date($FechaAux) <= date($FechaTermino))
	{
		/*$Consulta = "select ifnull(count(*),0) as total_reg from sec_web.produccion_catodo ";
		$Consulta.= " where cod_producto in ('48')  and fecha_produccion = '".$FechaAux."'";
		$total_1 = $Fila["total_reg"];
		
		//$Consulta.= " and cod_muestra <> 'S'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Fila["total_reg"] <> 0)
			{
				echo "<br><table width='500' border='0' align='center' cellpadding='2' cellspacing='1' class='TablaInterior'>\n";
				echo "<tr> \n";
				echo "<td align='center'><strong>DIA: ".substr($FechaAux,8,2)."/".substr($FechaAux,5,2)."/".substr($FechaAux,0,4)."</strong></td>\n";
				echo "</tr>\n";
				echo "</table>\n";
			}
		}*/							
		$Consulta = "select distinct t2.cod_producto, t2.cod_subproducto, t2.descripcion ";
		$Consulta.= " from sec_web.produccion_catodo t1 inner join proyecto_modernizacion.subproducto t2 ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
		/*66-5 laminas rechazo s/oreja
		  48-9 laminas rechazadas con orejas
		*/
		$Consulta.= " where (t1.cod_producto = '66' and t1.cod_subproducto IN ('5') or t1.cod_producto='48' and t1.cod_subproducto IN ('8'))";
		$Consulta.= " order by  t2.cod_producto desc, t2.cod_subproducto asc";
		$Respuesta = mysqli_query($link, $Consulta);
		$TotalDia = 0;
		$TotalDiaTara = 0; 
		$Total_produccion = 0;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{						
			$Consulta = "select * from sec_web.produccion_catodo ";
			$Consulta.= " where cod_producto = '".$Fila["cod_producto"]."'";
			$Consulta.= " and cod_subproducto = '".$Fila["cod_subproducto"]."'";
			$Consulta.= " and fecha_produccion = '".$FechaAux."' order by cod_grupo";			
			$Respuesta2 = mysqli_query($link, $Consulta);
			$SubTotalPeso = 0;
			$CodProductoAnt = 0;
			$CodSubProductoAnt = 0;
			$SubTotalTara = 0;
			$SubtotalProduccion = 0; 
			while ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				if (($Fila2["cod_producto"] != $CodProductoAnt) || ($Fila2["cod_subproducto"] != $CodSubProductoAnt))				
				{
					echo "</table>\n";
					echo "<br>";
					echo "<br>";
					echo "<table width='500' border='1' align='center' cellpadding='0' cellspacing='0' class='TablaDetalle'>\n";
					echo "<tr align='center' class='ColorTabla01'> \n";
					echo "<td width='57'><strong>".$Fila2["cod_producto"]."</strong></td>\n";
					echo "<td width='330' colspan='6'><strong>".$Fila["descripcion"]."</strong></td>\n";
					echo "</tr> \n";	
					echo "<tr align='center' class='ColorTabla01'> \n";
					echo "<td width='87'>&nbsp;</td>\n";
					echo "<td width='76'>TURNO</td>\n";
					echo "<td width='76'>HORA PESAJE</td>\n";
					echo "<td width='62'>PESO BRUTO</td>\n";
					echo "<td width='65'>TARA A DESCONTAR</td>\n";
					echo "<td width='87'>PRODUCCION DIA</td>\n";
					echo "</tr>\n";
				}
				echo "<tr>\n";
				$Turno =" ";
				if (substr($Fila2["hora"],0,2) >= '08' && substr($Fila2["hora"],0,2) <'16')
				{
					$Turno = 'TURNO A';
					$contador = $contador + 1;
				}	
				if (substr($Fila2["hora"],0,2) >= '16' && substr($Fila2["hora"],0,2) <'23')
				{
					$Turno = 'TURNO B';
					$contador = $contador + 1;

				}	
				if (substr($Fila2["hora"],0,2) >= '00' && substr($Fila2["hora"],0,2) <'07')
				{
					$Turno = 'TURNO C';
					$contador = $contador + 1;

				}	
				
				echo "<td align='center'>".$contador."</td>\n";
				echo "<td align='center'>".$Turno."</td>\n";
				echo "<td align='center'>".$Fila2["hora"]."</td>\n";
				echo "<td align='right'>".number_format($Fila2["peso_produccion"],0,",",".")."</td>\n";
				echo "<td align='right'>".$Fila2["peso_tara"]."</td>\n";
				$ProduccionDia = ($Fila2["peso_produccion"]) - ($Fila2["peso_tara"]); 
				echo "<td align='right'> ".$ProduccionDia." </td>\n";
				echo "</tr>\n";
				$SubTotalTara = $SubTotalTara + $Fila2["peso_tara"];
				$SubTotalPeso = ($SubTotalPeso + $Fila2["peso_produccion"]);
				$TotalDia = $TotalDia + $Fila2["peso_produccion"];
				$TotalDiaTara = $TotalDiaTara + $Fila2["peso_tara"];

				$CodProductoAnt = $Fila2["cod_producto"];
				$CodSubProductoAnt = $Fila2["cod_subproducto"];				
				$SubtotalProduccion = $SubtotalProduccion + $ProduccionDia;
				$Total_produccion = $Total_produccion + $ProduccionDia;
				$prod= "$Fila2["cod_producto"]$Fila2[cod_subproducto]";	
		}
			
			if ($SubTotalPeso != 0)
			{
				switch ($prod)
				{
					/*case '661':
								$prod1='661';
								break;
					case '662':
								$prod2='662';
								break;
					case '665':
								$prod4='665';
								break;*/
					case '488':
								$prod4='488';
								break;

					case '665':
								$prod5='665';
								break;

						
				}

				echo "<tr>\n";				
				echo "<td align='right' colspan='3'><strong>TOTAL PRODUCTO</strong></td>\n";
				echo "<td align='right'><strong>".number_format($SubTotalPeso,0,",",".")."</strong></td>\n";
				echo "<td align='right'><strong>".number_format($SubTotalTara,0,",",".")."</strong></td>\n";
		  		echo "<td align='right'><strong>".number_format($SubtotalProduccion,0,",",".")."</strong></td>\n";

				echo "</tr>\n<br>";						
			}
				echo "</table>\n";
		
		}		
		/*if ($TotalDia != 0)
		{	
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<table width='500' border='1' align='center' cellpadding='0' cellspacing='0' class='TablaDetalle'>\n";
			echo "<tr align='center' class='ColorTabla01'> \n";
			//echo "<tr>\n";				
			echo "<td align='right' colspan='3'><strong>TOTAL DIA :".substr($FechaAux,8,2)."/".substr($FechaAux,5,2)."/".substr($FechaAux,0,4)."</strong></td>\n";
			echo "<td align='right'><strong>".number_format($TotalDia,0,",",".")."</strong></td>\n";
			echo "<td align='right'><strong>".number_format($TotalDiaTara,0,",",".")."</strong></td>\n";
			echo "<td align='right'><strong>".number_format($Total_produccion,0,",",".")."</strong></td>\n";
			echo "</tr>\n";						
		}*/
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2),(intval(substr($FechaAux,8,2)) + 1),substr($FechaAux,0,4)));
		//echo "</table>\n";

	}
	
?>





<?php
//AQUI SOLO LOS RECHAZOS
?>
<?php

$existe[1]='661';
$existe[2]='662';
$existe[3]='664';
$existe[4]='488';
$existe[5]='665';
$xx[1]=$prod1;
$xx[2]=$prod2;
$xx[3]=$prod3;
$xx[4]=$prod4;
$xx[5]=$prod5;
//aqui resumen 
	for ($l=1;$l<6;$l++)
	{
		$cont=0;	
		$cont1=0;
		
		for ($c=1;$c<=5;$c++)
		{
			//echo "uno--".$c."ll".$xx[$c]."dos..".$existe[$l];
			if ($xx[$c]==$existe[$l])
			{
				$cont=1;
			}
			else
			{
				$cont1=1;
			}	
		}
		if ($cont1==1 && $i>1 && $cont==0)
		{
			$producto1 = substr($existe[$l],0,2);
			$producto2 = substr($existe[$l],2,1);
	
			//echo "Para Esta Fecha No existe Producci�n de L�minas Aprobadas NE".$existe[$l]."---".$l;
			$Consulta1 = "select  t2.cod_producto, t2.cod_subproducto, t2.descripcion ";
			$Consulta1.= " from proyecto_modernizacion.subproducto t2 ";
			$Consulta1.= " where t2.cod_producto = '".$producto1."' and t2.cod_subproducto = '".$producto2."'";
			$Respuesta1 = mysqli_query($link, $Consulta1);
		//echo "<br>";
		echo "<br>";	
		echo "<br>";
		echo "<table width='500' border='1' align='center' cellpadding='0' cellspacing='0' class='TablaDetalle'>\n";
		echo "<tr> \n";

		//echo "<tr align='center' class='ColorTabla01'> \n";
			while ($Fila11 = mysqli_fetch_array($Respuesta1))
			{						
				//echo "<td align='right' colspan='3'><strong>SUB TOTAL PRODUCTO</strong></td>\n";
				echo "<td  align='center'><strong>PARA ESTA FECHA NO EXISTE PRODUCCION DE ".$Fila11["descripcion"]."</strong></td>\n";
			}
		}		
			echo "<tr>\n";
			echo "</table>\n";
		}	
?>		
</form>
</body>
</html>
