<?php
	include("../principal/conectar_principal.php");
	if (!isset($DiaIni))
	{
		$DiaIni = date("d");
		$MesIni = date("m");
		$AnoIni = date("Y");
		$DiaFin = date("d");
		$MesFin = date("m");
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
?>
<html>
<head>
<title>Informe Clasificacion Catodos Conerciales</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1(opcion)
{	
	var f = document.frmPrincipal;
	if (opcion=='S')
	  // {f.action = "cortes2_aux.php?recarga=S"+"&dia1="+f.dia1.value+"&mes1="+f.mes1.value+"&ano1="+f.ano1.value+"&circuito="+f.cmbcircuito.value+"&mostrar=S&Buscar=N";}
	   {f.action = "ref_clasificacion_catodos_comerciales.php?cmbcircuito="+f.cmbcircuito.value+"&Buscar=S"+"&DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value;}
	f.submit();
}
function Imprimir(f)
{
  window.print();
}
function Salir(f)
{
 window.close();
}
function Grafico(f)
{
	var fecha1=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var fecha2=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	
	var URL ="../ref_web/ref_grafico_clasificacion_cat_com_global.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=930 height=650 scrollbars=no");
}	
function Excel(f)

{
	var fecha1=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var fecha2=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	document.location = "ref_globales_selec_catodos_xls.php?DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value+"&DiaFin="+f.DiaFin.value+"&MesFin="+f.MesFin.value+"&AnoFin="+f.AnoFin.value;
}
function detalle_anodos(fecha,grupo)
{
	var Frm=document.form1;
	window.open("Detalle_carga_anodos.php?fecha="+ fecha+"&grupo="+grupo,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
	
}
</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="632" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" > 
      <td colspan="7" class="ColorTabla01"><strong>INFORME DE CLASIFICACION FISICA 
        DE CATODOS COMERCIALES (detalle rechazo por circuito)</strong></td>
    </tr>
    <tr> 
      <td width="90" class="Detalle02"><strong>Fecha Inicio:</strong></td>
      <td width="84" class="detalle01"><strong><?php echo $FechaInicio;?></strong>
	  <input name="AnoIni" type="hidden" value="<?php echo $AnoIni;?>">
	  <input name="MesIni" type="hidden" value="<?php echo $MesIni;?>">
	  <input name="DiaIni" type="hidden" value="<?php echo $DiaIni;?>"></td>
      <td width="51">&nbsp;</td>
      <td width="89" class="Detalle02"><strong>Fecha Termino:</strong></td>
      <td width="78" class="detalle01"><strong><?php echo $FechaTermino;?></strong>
	  <input name="AnoFin" type="hidden" value="<?php echo $AnoFin;?>">
	  <input name="MesFin" type="hidden" value="<?php echo $MesFin;?>">
	  <input name="DiaFin" type="hidden" value="<?php echo $DiaFin;?>"></td>
      <td width="47" >&nbsp;</td>
      <td width="162">&nbsp;</td>
    </tr>
  </table>
    <table width="300" border="2" cellspacing="1" cellpadding="1" bordercolor="#b26c4a" class="TablaDetalle" align="center">
	<tr bgcolor="#FFFFFF" class="ColorTabla01">
	<?php 	
			$consulta_circuito="select cod_circuito from sec_web.circuitos order by cod_circuito ";
			$respuesta_circuito=mysqli_query($link, $consulta_circuito);
			$fila_dentro='S';
			while ($row_circuito=mysqli_fetch_array($respuesta_circuito))
				{
					if ($fila_dentro=='S')
					   {
						echo '<td colspan="7" align="center"><strong>Circuito '.$row_circuito["cod_circuito"].'</strong></td>';
						$fila_dentro='N';   
					   }
					else {
							echo '<td colspan="6" align="center"><strong>Circuito '.$row_circuito["cod_circuito"].'</strong></td>';
							$fila_dentro='N';
						 }   
				}
	?>			
	</tr>	
		<tr bgcolor="#FFFFFF" class="ColorTabla01">
		<td  align="center"><strong>Dia</strong><strong></strong></td>
		<?php 	
			$consulta_circuito="select cod_circuito from sec_web.circuitos order by cod_circuito ";
			$respuesta_circuito=mysqli_query($link, $consulta_circuito);
			while ($row_circuito=mysqli_fetch_array($respuesta_circuito))
				{
				 echo '<td  align="center"><strong>NE</strong><strong></strong></td>';
				 echo '<td align="center">ND</td>';
				 echo '<td  align="center">RA</td>';
				 echo '<td align="center">CS</td>';
				 echo '<td  align="center">CL</td>';
				 echo '<td  align="center">OT</td>';
	   			 
				}
	  ?>
	 </tr>
	 <?php 
	 	$consulta_fechas="select distinct fecha from cal_web.rechazo_catodos where fecha BETWEEN '".$FechaInicio."' and '".$FechaTermino."' ";
		$respuesta_fechas=mysqli_query($link, $consulta_fechas);
		while ($row_fechas=mysqli_fetch_array($respuesta_fechas))
			{
				echo '<tr>';
				echo '<td align="center" class=detalle01>'.substr($row_fechas["fecha"],8,2).'</td>';
				$consulta_circuito="select cod_circuito from sec_web.circuitos order by cod_circuito ";
				$respuesta_circuito=mysqli_query($link, $consulta_circuito);
				$color1="";
				while ($row_circuito=mysqli_fetch_array($respuesta_circuito))
					{
					  $consulta_grupo="select distinct cod_grupo from ref_web.grupo_electrolitico2 where cod_circuito='".$row_circuito["cod_circuito"]."'";
					  $respuesta_grupo=mysqli_query($link, $consulta_grupo);
					  $total_dia_ne=0;
					  $total_dia_nd=0;
					  $total_dia_ra=0;
					  $total_dia_cs=0;
					  $total_dia_cl=0;
					  $total_dia_ot=0;
					  while ($row_grupo=mysqli_fetch_array($respuesta_grupo))
					  	{
							 $consulta_rechazo="select sum(unid_recup) as recuperado_tot,sum(estampa) as ne,sum(dispersos) as nd,sum(rayado) as ra,sum(cordon_superior) as cs,sum(cordon_lateral) as cl,sum(otros) as ot , fecha from cal_web.rechazo_catodos ";
		  					 $consulta_rechazo.=" where fecha = '".$row_fechas["fecha"]."' and grupo='".intval($row_grupo["cod_grupo"])."' group by fecha";
		  					 $respuesta_rechazo = mysqli_query($link, $consulta_rechazo);
							 while ($row_rechazo = mysqli_fetch_array($respuesta_rechazo))
							 	{
							 		$total_dia_ne=$total_dia_ne+$row_rechazo[ne];
									$total_dia_nd=$total_dia_nd+$row_rechazo[nd];
									$total_dia_ra=$total_dia_ra+$row_rechazo[ra];
									$total_dia_cs=$total_dia_cs+$row_rechazo[cs];
									$total_dia_cl=$total_dia_cl+$row_rechazo[cl];
									$total_dia_ot=$total_dia_ot+$row_rechazo["ot"];
								}
						}
						if ($color1=='detalle02')
							{
							//echo $color1;
							 $color1='detalle01'; 
							}
					    else {$color1='detalle02';}			
						echo '<td align="center" class='.$color1.'>'.$total_dia_ne.'</td>';
						echo '<td align="center" class='.$color1.'>'.$total_dia_nd.'</td>';
						echo '<td align="center" class='.$color1.'>'.$total_dia_ra.'</td>';
						echo '<td align="center" class='.$color1.'>'.$total_dia_cs.'</td>';
						echo '<td align="center" class='.$color1.'>'.$total_dia_cl.'</td>';
						echo '<td align="center" class='.$color1.'>'.$total_dia_ot.'</td>';
					
					}
				echo '</tr>';
			
			}
	 
	 
	 ?>
    </table>

  <p>&nbsp;</p>
  <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"><input name="btnimprimir2" type="button" value="Excel" style="width:70;" onClick="JavaScript:Excel(this.form)"> 
        <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir(this.form)"> 
      <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir(this.form)" value="Salir"></td>
  </tr>
</table>
</form>
</body>
</html>

