<?php 
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Consulta="select t1.lote_ventana,t1.lote_origen,t2.nombre_subclase as color from sea_web.relaciones t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase=2011 and t1.marca=t2.valor_subclase1 where t1.cod_origen=".$CodSubProducto." and t1.hornada_ventana=".$Hornada;
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$LoteOrigen=$Fila[lote_origen];
	$LoteVentana=$Fila["lote_ventana"];
	$Marca=$Fila[color];
	$Consulta="select fecha_ini from sea_web.rechazos where hornada=".$Hornada;
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$Fecha=substr($Fila[fecha_ini],0,10);	
	$Consulta="select descripcion from proyecto_modernizacion.subproducto where cod_producto=17 and cod_subproducto=".$CodSubProducto;
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$SubProducto=$Fila["descripcion"];
	$Consulta="select unidades from sea_web.hornadas where hornada_ventana=".$Hornada;
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$Unidades=$Fila["unidades"];
?>
<html>
<head>
<script language="JavaScript">
function Imprimir()
{
	window.print();
}
function Salir()
{
	window.close();
}

</script>
<title>Consulta Rechazos</title>
</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConsultaRechazosDeta" method="post" action="">
 <table width="645" border="0" left="5" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="645" align="center" valign="middle"><br>
  	  <table width="645" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
	  <tr>
	        <td align="center">INSPECCION FISICA DE ANODOS</td>
	  </tr>
	  </table><BR>
	  <table width="645" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
		  	<td>FECHA</td>
			<td colspan="4"><?php echo $Fecha;?></td>
		  </tr>
		  <tr>
		  	<td><?php echo $SubProducto;?></td>
			<td colspan="2"><?php echo $LoteOrigen;?></td>
			<td colspan="2">LOTE ENAMI&nbsp;<?php echo $LoteVentana;?></td>
		  </tr>
		  <tr>
		  	<td>MARCA</td>
			<td colspan="2"><?php echo $Marca;?></td>
			<td colspan="2">TOTAL UNIDADES:<?php echo $Unidades;?></td>
		  </tr>
		  <tr class='detalle01'> 
            <td>DEFECTO</td>
            <td align="center">RECUPERABLES</td>
			<td align="center">TOTAL</td>
            <td align="center">RECHAZOS</td>
			<td align="center">TOTAL</td>
          </tr>
		  <?php
			$TotalRecuperable=0;
			$TotalRechazado=0;
			$Consulta="select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='2008'";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				echo "<td>".$Fila["nombre_subclase"]."</td>";
				$Consulta="select recuperables from sea_web.rechazos "; 
				$Consulta=$Consulta." where cod_producto=17 and cod_subproducto=".$CodSubProducto." and cod_tipo=6 and cod_defecto<>0 and hornada=".$Hornada." and cod_defecto=".$Fila["cod_subclase"]." and rueda=0";
				$Respuesta2=mysqli_query($link, $Consulta);
				if ($Fila2=mysqli_fetch_array($Respuesta2))
				{
					echo "<td align='right'>".$Fila2[recuperables]."</td>";
					echo "<td align='right' class='detalle01'>".$Fila2[recuperables]."</td>";
					$TotalRecup=$TotalRecup+$Fila2[recuperables];
				}
				else
				{
					echo "<td>&nbsp;</td>";
					echo "<td class='detalle01'>&nbsp;</td>";
				}
				$Consulta="select rechazados from sea_web.rechazos "; 
				$Consulta=$Consulta." where cod_producto=17 and cod_subproducto=".$CodSubProducto." and cod_tipo=6 and cod_defecto<>0 and hornada=".$Hornada." and cod_defecto=".$Fila["cod_subclase"]." and rueda=0";
				$Respuesta2=mysqli_query($link, $Consulta);
				if ($Fila2=mysqli_fetch_array($Respuesta2))
				{
					echo "<td align='right'>".$Fila2[rechazados]."</td>";
					echo "<td align='right' class='detalle01'>".$Fila2[rechazados]."</td>";
					$TotalRechaz=$TotalRechaz+$Fila2[rechazados];
				}
				else
				{
					echo "<td>&nbsp;</td>";
					echo "<td class='detalle01'>&nbsp;</td>";
				}	
				echo "</tr>";
			}
			echo "<tr>";
			echo "</tr>";
			echo "<td width='100'>&nbsp;</td>";
			echo "<td width='70'>&nbsp;</td>";
			echo "<td width='70' class='detalle01'>&nbsp;</td>";
			echo "<td width='70'>&nbsp;</td>";
			echo "<td width='70'class='detalle01'>&nbsp;</td>";
			echo "<tr class='detalle01'>";
			echo "<td width='100'>TOTALES</td>";
			echo "<td width='70'>&nbsp;</td>";
			echo "<td width='70' align='right'>$TotalRecup</td>";
			echo "<td width='70' align='right'>&nbsp;</td>";
			echo "<td width='70' align='right'>$TotalRechaz</td>";
			echo "</tr>";
		  ?>
        </table>
        <br>
		<table width="645" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td align="center">
              <input name="BtnImprimir" type="button" value="Imprimir" style="width:90" onClick="Imprimir();">&nbsp;
              <input name="BtnSalir" type="button" value="Salir" style="width:90" onClick="Salir();"></td>
          </tr>
        </table>
        <br>
	  </td>
	</tr>
  </table>
</form>
</body>
</html>
