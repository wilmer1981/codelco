<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" href="../principal/estilos/css_sea_web.css" type="text/css">
<script language="JavaScript">
function Buscar(f)
{
	var f= document.frm;
	fecha = f.ano.value + '-' + f.mes.value + '-' + f.dia.value;
	f.action = "sea_ing_prod_cor.php?mostrar=S&fecha=" + fecha;
	f.submit();
}
/***************/
function Elimina()
{
	var f = document.frm;
	var Datos = "";
	if (confirm("Esta seguro de Eliminar produccion marcada ¿Continua?"))
	{
				var control = 1;
	}
	else
	{
				f.action="sea_ing_prod_cor.php?EliminaP=''";
				f.submit();
	}
	
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="checkbox" && f.elements[i].checked==true)
		{
				Datos = Datos+f.elements[i+1].value+"//";
		}
	}
	Datos=Datos.substring(0,(Datos.length-2));
	f.action="sea_ing_prod_cor.php?EliminaP=S&DatosE=" + Datos;
	f.submit();

}
function Salir()
{
	window.close();
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal">
<form name="frm" action="" method="post">
<?
	echo '<input name="subproducto" type="hidden" value="'.$subproducto.'">';
?>
<br><table width="500" align="center" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr> 
    <td width="187" height="28" align="center"><font size="2">&nbsp; </font><font size="2">&nbsp; 
      Fecha Producción</font></td>
    <td width="296" align="left"><font size="2">
      <select name="dia" size="1">
        <?
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($mostrar == "S") && ($i == $dia))			
					echo "<option selected value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($mostrar != "S")) 
						echo "<option selected value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
      </select>
      </font> <font size="2"> 
      <select name="mes" size="1" id="select7">
        <?
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($mostrar != "S"))
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
      </select>
      <select name="ano" size="1">
        <?
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano))
					echo "<option selected value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo "<option selected value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
      </select>
      &nbsp; 
      <input name="btnbuscar" type="button" id="btnbuscar" value="Buscar" onClick="Buscar(this.form)">
      </font></td>
  </tr>
</table>
<?
 	include("../principal/conectar_sea_web.php");
	$fecha = $ano.'-'.$mes.'-'.$dia;
	$FechaInicio=$ano.'-'.$mes.'-'.$dia." 08:00:00";
	$FechaTermino =date("Y-m-d", mktime(1,0,0,$mes,($dia +1),$ano))." 07:59:59";
	$fecha2=date("Y-m-d", mktime(1,0,0,$mes,($dia +1),$ano));
	echo '<input name="fechamov" type="hidden" value="'.$fechamov.'">';
	if ($mostrar == "S")
	{
		echo '<table width="500" align="center" border="1" cellpadding="0" cellspacing="0">';
		echo '<tr class="ColorTabla01">';
		echo '<td height="20" width="100" align="center">&nbsp;</td>';
		echo '<td height="20" width="100" align="center">Grupo</td>';
		echo '<td width="100" align="center">Hornada</td>';		
		echo '<td width="100" align="center">Unidades</td>';		
		echo '<td width="100" align="center">Peso</td>';	
		echo '<td width="100" align="center">Lado/Cuba</td>';
		echo '</tr>';
		$total_unidades = 0;
		$total_peso = 0;
		echo '<td><input type="hidden" name="Datos" value="'.$Datos.'"></td>';
		//Consulta Solo los grupos del dia.
		$consulta = "SELECT DISTINCT campo2,campo1 FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND campo1 in('M','T')";
		$consulta = $consulta." AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino' ORDER BY campo2";
		//echo $consulta;
		$rs = mysql_query($consulta);
		while ($row = mysql_fetch_array($rs))
		{
			//Totales por Grupo.
			$consulta = "SELECT hornada, SUM(unidades) AS unidades, SUM(peso) AS peso";
			$consulta = $consulta." FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND campo1 in('M','T')";
			$consulta = $consulta." AND fecha_movimiento between '".$fecha."' and '".$fecha2."' AND campo2 = '".$row[campo2]."' and hora between '$FechaInicio' and '$FechaTermino' ";
			$consulta = $consulta." GROUP BY hornada, campo2,campo1";
			//echo $consulta."<br>";
			$rs2 = mysql_query($consulta);
			while ($row2 = mysql_fetch_array($rs2))
			{
				$Datos = $row2[hornada].":".$row[campo2].":".$row[campo1];
				echo '<tr>';
				echo '<td align="center"><input name="checkbox" type="checkbox"><input type="hidden" name="Datos" value="'.$Datos.'"></td>';
				echo '<td height="20" width="100" align="center">'.$row[campo2].'</td>';
				echo '<td width="100" align="center">'.substr($row2[hornada],6,6).'</td>';				
				echo '<td width="100" align="center">'.$row2["unidades"].'</td>';
				echo '<td width="100" align="center">'.$row2["peso"].'</td>';			
				echo '<td width="100" align="center">'.$row[campo1].'</td>';
				echo '</tr>';
				$total_unidades = $total_unidades + $row2["unidades"];
				$total_peso = $total_peso + $row2["peso"];				
			}		
		}
		$consulta = "SELECT DISTINCT campo2 FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3  AND cod_producto = 19 AND campo1 != 'M' AND campo1 != 'T'";
		$consulta = $consulta." AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino' ORDER BY campo2";
		$rs = mysql_query($consulta);
		while ($row = mysql_fetch_array($rs))
		{
			//Totales por Grupo.
			$consulta = "SELECT hornada, SUM(unidades) AS unidades, SUM(peso) AS peso";
			$consulta = $consulta." FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 3  AND cod_producto = 19 AND campo1 != 'M' AND campo1 != 'T'";
			$consulta = $consulta." AND fecha_movimiento between '".$fecha."' and '".$fecha2."' AND campo2 = '".$row[campo2]."' and hora between '$FechaInicio' and '$FechaTermino'";
			$consulta = $consulta." GROUP BY hornada, campo2";
			$rs2 = mysql_query($consulta);
			while ($row2 = mysql_fetch_array($rs2))
			{
				$campo1 = "";
				$Datos = $row2[hornada].":".$row[campo2].":".$campo1;
				echo '<tr>';
				echo '<td align="center"><input name="checkbox" type="checkbox"><input type="hidden" name="Datos" value="'.$Datos.'"></td>';
				echo '<td height="20" width="125" align="center">'.$row[campo2].'</td>';
				echo '<td width="125" align="center">'.substr($row2[hornada],6,6).'</td>';				
				echo '<td width="125" align="center">'.$row2["unidades"].'</td>';
				echo '<td width="125" align="center">'.$row2["peso"].'</td>';		
				echo '<td width="100" align="center">&nbsp;</td>';					
				echo '</tr>';
				$total_unidades = $total_unidades + $row2["unidades"];
				$total_peso = $total_peso + $row2["peso"];				
			}		
		}		
		echo '<tr class="Detalle02">';
		echo '<td height="20" colspan="2">TOTAL</td>';
		//echo '<td colspan="2"></td>';
		echo '<td align="center">&nbsp;</td>';		
		echo '<td align="center">'.$total_unidades.'</td>';
		echo '<td align="center">'.$total_peso.'</td>';		
		echo '<td align="center">&nbsp;</td>';		
		echo '</tr>';
		echo '</table>';		
	}
	
	if ($EliminaP=="S")
	{
	
		$vector = explode('/',$DatosE);
		while (list($c,$v) = each($vector))
		{
			$Datos = explode(':',$v);
			$Hornada =   $Datos[0];
			$Grupo   =   $Datos[1];
			$Lado    =   $Datos[2];

			// saco fecha beneficio para modificar
			$consulta="Select cod_subproducto, sum(unidades) as unidades,sum(peso) as peso from sea_web.movimientos ";
			$consulta.=" where tipo_movimiento in (3,4,10) and cod_producto = 19 and hornada = '".$Hornada."' ";
			$consulta.=" AND fecha_movimiento between '".$fecha."' and '".$fecha2."'  and hora between '".$FechaInicio."' and '".$FechaTermino."' and ";
			if ($Lado=="")
				$consulta.=" campo1 != 'M' and campo1 != 'T' and  campo2 = '".$Grupo."'";
				else
				$consulta.=" campo1 = '".$Lado."' and  campo2 = '".$Grupo."'";
			$consulta.=" group by cod_subproducto";
			//echo "uno".$consulta;
			$resp=mysql_query($consulta);
			while ($Fila=mysql_fetch_array($resp))
			{
				// elimino o actualizo hornadas de restos
				$consulta1="select * from sea_web.hornadas where hornada_ventana = '".$Hornada."' and cod_producto = 19 and ";
				$consulta1.=" cod_subproducto = '".$Fila["cod_subproducto"]."'";
				//echo "dos".$consulta1;
				$resp1=mysql_query($consulta1);
				if ($Fila1=mysql_fetch_array($resp1))
				{
					if ($Fila1[peso_unidades] - $Fila["peso"] > 0)
					{
						$actualizo="UPDATE sea_web.hornadas set unidades = unidades - '".$Fila["unidades"]."', ";
						$actualizo.=" peso_unidades = peso_unidades - '".$Fila["peso"]."' where hornada_ventana = '".$Hornada."' and ";
						$actualizo.=" cod_producto = 19 and cod_subproducto = '".$Fila["cod_subproducto"]."'";
						//echo "tres".$actualizo;
						mysql_query($actualizo);
					}
					else
					{
						$Elimino="delete from sea_web.hornadas where hornada_ventana = '".$Hornada."' and ";
						$Elimino.=" cod_producto = 19 and cod_subproducto = '".$Fila["cod_subproducto"]."'";
						//echo "cuatro".$Elimino;
						mysql_query($Elimino);
					}
				}
				// actualizo movimientos
			}
			$consulta="Select * from sea_web.movimientos  where tipo_movimiento in (3,4,10) and cod_producto = 19 and hornada = '".$Hornada."' ";
			$consulta.=" and fecha_movimiento between '".$fecha."' and '".$fecha2."'  and hora between '".$FechaInicio."' and '".$FechaTermino."' and ";
			if ($Lado=="")
				$consulta.=" campo1 != 'M' and campo1 != 'T' and  campo2 = '".$Grupo."'";
				else
				$consulta.=" campo1 = '".$Lado."' and  campo2 = '".$Grupo."'";
			//echo "cinco".$consulta;
			$respuesta=mysql_query($consulta);
			while ($FilaH=mysql_fetch_array($respuesta))
			{
				$actualizoMov="UPDATE sea_web.movimientos set numero_recarga = 0 where tipo_movimiento = 2 and ";
				$actualizoMov.=" cod_producto = 17 and cod_subproducto = '".$FilaH["cod_subproducto"]."' and campo2 = '".$FilaH[campo2]."'";
				$actualizoMov.=" and fecha_movimiento = '".$FilaH[fecha_benef]."'  and  campo1 = '".$FilaH[campo1]."'";
				//echo "seis".$actualizoMov;
				mysql_query($actualizoMov);
			}
			$BorroMov="delete from sea_web.movimientos where tipo_movimiento in (3,4,10) and ";
			$BorroMov.="cod_producto = 19  and hornada = '".$Hornada."' and ";
			$BorroMov.=" fecha_movimiento between '".$fecha."' and '".$fecha2."'  and hora between '".$FechaInicio."' and '".$FechaTermino."' and ";
			if ($Lado=="" )
				$BorroMov.=" campo1 != 'M' and campo1 != 'T' and campo2 = '".$Grupo."'";
				else
				$BorroMov.=" campo1 = '".$Lado."' and campo2 = '".$Grupo."' ";
			//echo "dos".$consulta1;
			mysql_query($BorroMov);
		}
		$EliminaP="";
		echo '<script language="JavaScript">';
		echo ' var f = documents.frm; ';
		echo  'f.action="sea_ing_prod_cor.php";';
		echo 'f.action;';
		echo '</script>';
	}


	include("../principal/cerrar_sea_web.php");
?>
<div style="position:absolute; left: 22px; top: 340px; width: 500px; height: 30px;" id="div4">
<table width="500" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center"><input name="btelimina" type="button" id="btelimina" value="Elimina Produccion." style="width:110" onClick="Elimina()"></td>
    <td align="center"><input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="Salir()"></td>
  </tr>
</table>
</div>

</form>
</body>
</html>
