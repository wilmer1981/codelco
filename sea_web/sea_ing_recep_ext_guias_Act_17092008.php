<?php 
	include("../principal/conectar_sea_web.php");
	if(!isset($TxtFecha))
	{
		$TxtFecha=date('Y-m-d');
	}
	if($AnularGuia=='S')
	{
		$Actualizar="UPDATE sea_web.recepcion_externa set estado='$Estado' where guia='".$GuiaAnulada."'";
		//echo $Actualizar;
		mysqli_query($link, $Actualizar);
	}
	if($EliminarGuia=='S')
	{
		$Consulta="SELECT * from sea_web.recepcion_externa where guia='".$GuiaEliminada."'";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Resp))
		{
			//echo "GUIA TTE:".$Fila[guia]."<br>";
			$LoteOrigen=substr($Fila[lote_origen],0,1)."-".substr($Fila[lote_origen],1);
			$Consulta="SELECT hornada_ventana from sea_web.relaciones where cod_origen='2' and lote_ventana='".$Fila[lote_ventana]."' and lote_origen='".$LoteOrigen."'";
			$RespHornada=mysqli_query($link, $Consulta);
			$FilaHornada=mysqli_fetch_array($RespHornada);
			$Hornada=$FilaHornada[hornada_ventana];
			$Eliminar="delete from sea_web.hornadas where cod_producto='17' and cod_subproducto='2' and hornada_ventana='".$Hornada."'";
			//echo "TABLA HORNADAS:".$Eliminar."<br>";
			mysqli_query($link, $Eliminar);
			$Eliminar="delete from sea_web.movimientos where cod_producto='17' and cod_subproducto='2' and hornada='".$Hornada."'";
			//echo "TABLA MOVIMIENTOS:".$Eliminar."<br>";
			mysqli_query($link, $Eliminar);
			$Eliminar="delete from sea_web.relaciones where cod_origen='2' and lote_ventana='".$Fila[lote_ventana]."' and lote_origen='".$LoteOrigen."'";
			//echo "TABLA RELACIONES:".$Eliminar."<br>";
			mysqli_query($link, $Eliminar);
			$Eliminar="delete from sipa_web.recepciones where guia_despacho='".$GuiaEliminada."' and lote='".$Fila[lote_ventana]."' and tipo='A'";
			//echo "TABLA RECEPCIONES SIPA:".$Eliminar."<br><br><br>";
			mysqli_query($link, $Eliminar);
			$SA='';
			$Consulta="SELECT solicitud_analisis from cal_web.leyes_externas where lote_ventana='".$Fila[lote_ventana]."' and lote_origen='".$Fila[lote_origen]."'";
			$RespSA=mysqli_query($link, $Consulta);
			if($FilaSA=mysqli_fetch_array($RespSA))
			{
				$SA=$FilaSA[solicitud_analisis];
				if($SA!='')
				{
					$Eliminar="delete from cal_web.solicitud_analisis where rut_funcionario='61704000-K' and cod_producto='17' and cod_subproducto='2' and nro_solicitud='".$SA."'";
					//echo "TABLA SOLICITUD ANALISIS:".$Eliminar."<br>";
					mysqli_query($link, $Eliminar);
					$Eliminar="delete from cal_web.leyes_por_solicitud where rut_funcionario='61704000-K' and cod_producto='17' and cod_subproducto='2' and nro_solicitud='".$SA."'";
					//echo "TABLA LEYES POR SOLICITUD:".$Eliminar."<br>";
					mysqli_query($link, $Eliminar);
					$Eliminar="delete from cal_web.estados_por_solicitud where rut_funcionario='61704000-K' and nro_solicitud='".$SA."'";
					//echo "TABLA ESTADOS POR SOLICITUD:".$Eliminar."<br>";
					mysqli_query($link, $Eliminar);
					$Eliminar="delete from cal_web.registro_leyes where rut_funcionario='61704000-K' and nro_solicitud='".$SA."'";
					//echo "TABLA REGISTRO LEYES:".$Eliminar."<br><br><br>";
					mysqli_query($link, $Eliminar);
				}	
			}	
		}
		$Eliminar="delete from sea_web.recepcion_externa where guia='".$GuiaEliminada."'";
		//echo "TABLA RECEPCION EXTERNA:".$Eliminar."<br>";		
		mysqli_query($link, $Eliminar);
		$Eliminar="delete from sea_web.recepcion_externa_detalle where guia='".$GuiaEliminada."'";
		//echo "TABLA RECEPCION EXTERNA DETALLE:".$Eliminar."<br>";
		mysqli_query($link, $Eliminar);
	}

?>

<html>
<head>
<title>Informes Guias de Despachos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Datos_Excel()
{
var f = frmPoPup;
var dia,mes,ano;
var valores;
 
 	valores = "&ano=" + f.ano.value + "&mes=" + f.mes.value + "&dia=" + f.dia.value + "&cmbproductos=" + f.cmbproductos.value;    

    window.open("sea_ing_recep_ext04xls.php?Proceso=B"+valores);
}

function BuscarGuia()
{
var f = frmPoPup;

   if(f.TxtFecha.value!='')
   {
		f.action="sea_ing_recep_ext_guias.php?Buscar=S";
		f.submit();
   }
   else
   {
   		alert('Debe Ingresar Fecha');
   }		
}

function Imprimir()
{
	window.print();
}
function AnularGuiaTTE(Guia,Est,ExisteMov)
{
	var f = frmPoPup;

	if(Est=='X')
	{
		if(confirm('Esta Guia esta Anulada, Desea Activar Guia'))
		{
			f.action="sea_ing_recep_ext_guias.php?Buscar=S&AnularGuia=S&Estado=&GuiaAnulada="+Guia;
			f.submit();
		}
	}
	else
	{
		if(ExisteMov=='S')
		{
			alert('Existen Movimientos para Esta Guia, Tambien debe Eliminarlos');
		}
		if(confirm('Esta Seguro de Anular Guia N� '+Guia))
		{
			f.action="sea_ing_recep_ext_guias.php?Buscar=S&AnularGuia=S&Estado=X&GuiaAnulada="+Guia;
			f.submit();
		}	
	}	
}
function EliminarGuiaTTE(Guia,Est)
{
	var f = frmPoPup;


	if(confirm('Desea Eliminar Guia con sus Datos Relacionados'))
	{
		f.action="sea_ing_recep_ext_guias.php?Buscar=S&EliminarGuia=S&Estado=&GuiaEliminada="+Guia;
		f.submit();
	}
	
}

</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
<table cellpadding="3" cellspacing="0" width="520" border="1" align="center">
		  <tr>
			<td>Fecha</td>
			<td>
			  <input name="TxtFecha" type="text" class="InputCen" value="<?php echo $TxtFecha; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFecha,TxtFecha,popCal);return false"> &nbsp;
			  <input type="button" name="BtnBuscar" value="Buscar" onClick="BuscarGuia()">
			  </td>
		  </tr>
</table>
<br>
<?php
if($Buscar=='S')
{
	echo "<table cellpadding='3' cellspacing='0' width='520' border='1' align='center'>";
	echo "<tr align='center' class='ColorTabla01'>";
	echo "<td>Anular</td>";
	echo "<td>Eliminar</td>";
	echo "<td>Guia</td>";
	echo "<td>Patente</td>";
	echo "<td>Transportista</td>";
	echo "<td>Lote</td>";
	echo "<td>Marca</td>";
	echo "<td>Atados</td>";
	echo "<td>Piezas</td>";
	echo "<td>K.Bruto</td>";
	//echo "<td>Piezas Falt.</td>";
	echo "</tr>";
	$TotAtados=0;$TotPiezas=0;$TotPeso=0;
	$Consulta="SELECT guia from sea_web.recepcion_externa_detalle where fecha='$TxtFecha' group by guia,fecha";
	//echo $Consulta."<br>";
	$Resp=mysqli_query($link, $Consulta);
	while($FilaGuia=mysqli_fetch_array($Resp))
	{
		$MostrarGuia='S';
		$Consulta="SELECT * from sea_web.recepcion_externa_detalle where fecha='$TxtFecha' and guia='$FilaGuia[guia]'";
		//echo $Consulta."<br>";
		$RespDetalle=mysqli_query($link, $Consulta);
		while($FilaDetalle=mysqli_fetch_array($RespDetalle))
		{
			if($MostrarGuia=='S')
			{	
				//CONSULTA SI EXISTEN MOVIMIENTOS DE RECEPCION DE LA GUIA
				$ExisteMov='N';
				$Consulta="SELECT lote_ventana from sea_web.recepcion_externa where guia='".$FilaGuia[guia]."'";
				$RespLote=mysqli_query($link, $Consulta);
				while($FilaLote=mysqli_fetch_array($RespLote))
				{
					$Consulta="SELECT * from sea_web.movimientos where tipo_movimiento='1' and cod_producto='17' and cod_subproducto='2' and lote_ventana='".$FilaLote[lote_ventana]."'";
					$RespMov=mysqli_query($link, $Consulta);
					if($FilaMov=mysqli_fetch_array($RespMov))
					{
						$ExisteMov='S';
					}
				}
				$Consulta="SELECT estado from sea_web.recepcion_externa where guia='".$FilaGuia[guia]."'";
				$RespEst=mysqli_query($link, $Consulta);
				$FilaEst=mysqli_fetch_array($RespEst);
				if($FilaEst["estado"]=='X')
					echo "<tr class='Detalle03'>";
				else
					echo "<tr class='ColorTabla02'>";	
				echo "<td align='center'><input type='radio' name='OptAnulaGuia' onclick=AnularGuiaTTE('$FilaDetalle[guia]','$FilaEst["estado"]','$ExisteMov')></td>";
				echo "<td align='center'><input type='radio' name='OptEliminarGuia' onclick=EliminarGuiaTTE('$FilaDetalle[guia]','$FilaEst["estado"]')></td>";
				echo "<td>".$FilaDetalle[guia]."&nbsp;</td>";
			}	
			else
			{
				echo "<tr>";
				echo "<td colspan='3'>&nbsp;</td>";
			}	
			echo "<td>".$FilaDetalle[patente]."&nbsp;</td>";
			echo "<td>FEPASA</td>";
			echo "<td>".$FilaDetalle[lote_origen]."</td>";
			echo "<td>".$FilaDetalle[marca]."</td>";
			echo "<td align='right'>".$FilaDetalle[atados]."</td>";
			echo "<td align='right'>".$FilaDetalle[piezas]."</td>";
			echo "<td align='right'>".$FilaDetalle["peso_bruto"]."</td>";
			echo "</tr>";
			$MostrarGuia='N';
			$TotAtados=$TotAtados+intval($FilaDetalle[atados]);
			$TotPiezas=$TotPiezas+intval($FilaDetalle[piezas]);
			$TotPeso=$TotPeso+intval($FilaDetalle["peso_bruto"]);
		}
	}
	echo "<tr class='Detalle01'>";
	echo "<td colspan='7'>&nbsp;</td>";
	echo "<td align='right'>".number_format($TotAtados,0,"",".")."</td>";
	echo "<td align='right'>".number_format($TotPiezas,0,"",".")."</td>";
	echo "<td align='right'>".number_format($TotPeso,0,"",".")."</td>";
	echo "</tr>";
	echo "</table>";	
}
?>
<br>
<table cellpadding="3" cellspacing="0" width="520" border="1" align="center">
		  <tr>
			<td> <div align="center">
				<input name="btnimprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()"> 
				<input name="btnsalir" type="button" style="width:100" value="Cierra Ventana" onClick="self.close()">
			  </div></td>
		  </tr>
</table>
<br>
<?php
if($Buscar=='S')
{
	echo "<table cellpadding='3' cellspacing='0' width='520' border='1' align='center'>";
	echo "<tr class='Detalle01'><td colspan='9'>Lotes Cerrados Manualmente</td></tr>";
	echo "<tr align='center' class='ColorTabla01'>";
	echo "<td>Guia</td>";
	echo "<td>Lote Origen</td>";
	echo "<td>Lote Vtna</td>";
	echo "<td>Peso</td>";
	echo "<td>Peso Recep</td>";
	echo "<td>Piezas</td>";
	echo "<td>Piezas Recep</td>";
	echo "<td>Dif Piezas</td>";
	echo "<td>Marca</td>";
	echo "</tr>";
	$Consulta="SELECT distinct t1.lote_origen from sea_web.recepcion_externa t1 inner join sea_web.recepcion_externa_detalle t2 on t1.lote_origen=t2.lote_origen and t1.marca=t2.marca ";
	$Consulta.="where t1.fecha_guia='$TxtFecha' and t1.estado='C'";
	//echo $Consulta."<br>";
	$Resp=mysqli_query($link, $Consulta);
	while($FilaDetalle=mysqli_fetch_array($Resp))
	{
		$Consulta="SELECT * from sea_web.recepcion_externa where lote_origen='$FilaDetalle[lote_origen]' and estado='C'";
		//echo $Consulta."<br>";
		$Resp2=mysqli_query($link, $Consulta);
		$FilaDetalle2=mysqli_fetch_array($Resp2);
		echo "<tr>";
		echo "<td>".$FilaDetalle2[guia]."</td>";
		echo "<td>".$FilaDetalle2[lote_origen]."&nbsp;</td>";
		echo "<td>".$FilaDetalle2[lote_ventana]."</td>";
		echo "<td>".$FilaDetalle2["peso"]."</td>";
		echo "<td>".$FilaDetalle2[peso_recep]."</td>";
		echo "<td align='right'>".$FilaDetalle2[piezas]."</td>";
		echo "<td align='right'>".$FilaDetalle2[piezas_recep]."</td>";
		echo "<td align='right'>".($FilaDetalle2[piezas]-$FilaDetalle2[piezas_recep])."</td>";
		echo "<td>".$FilaDetalle2[marca]."</td>";
		echo "</tr>";
	}
	echo "</table>";	
}
?>	
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
