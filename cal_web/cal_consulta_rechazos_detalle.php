<?php 
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	if(isset($_REQUEST["CmbSubProducto"])) {
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	}else{
		$CmbSubProducto = "";
	}
	if(isset($_REQUEST["Hornada"])) {
		$Hornada = $_REQUEST["Hornada"];
	}else{
		$Hornada = "";
	}

	$Consulta="select fecha_ini,fecha_ter from sea_web.rechazos"; 
	$Consulta=$Consulta." where cod_producto=17 and cod_subproducto='".$CodSubProducto."' and cod_tipo=6 and cod_defecto=0 and hornada='".$Hornada."' group by hornada,cod_subproducto";
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$Fecha=$Fila["fecha_ini"];
	$HoraIni=substr($Fila["fecha_ini"],10);
	$HoraTer=substr($Fila["fecha_ter"],10);
	$Consulta="select * from sea_web.produccion where hornada='".$Hornada."' ";
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$Rueda1=$Fila["rueda1"];
	$Rueda2=$Fila["rueda2"];
	$HMadres=$Fila["hm"];
	
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
  	  <table width="645" border="0" cellpadding="3" cellspacing="0" >
	  <tr>
	  <td align="right">MOLDEO N�&nbsp;<?php echo substr($Hornada,6,4);?> </td>
	  </tr>
	  </table><BR>  		  
	  <table width="645" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td align="center">Fecha:<?php echo $Fecha;?></td>
            <td align="center">Hora Ini:<?php echo $HoraIni;?></td>
			<td align="center">Hora Term:<?php echo $HoraTer;?></td>
          </tr>
	  </table><br>
	  <table width="645" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td align="center">Produccion</td>
            <td align="center">Rueda N�1</td>
			<td align="center">Rueda N�2</td>
			<td align="center">Hojas Madres</td>
			<td align="center">Totales</td>
          </tr>
		  <tr>
		  	<td>Unidades</td>
			<td align="center"><?php echo $Rueda1;?></td>
			<td align="center"><?php echo $Rueda2;?></td>
			<td align="center"><?php echo $HMadres;?></td>
			<td align="center"><?php echo ($Rueda1+$Rueda2+$HMadres);?></td>
		  </tr>
		  <tr>
		  	<td>Kgs</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
	  </table><br>
	  <table width="645" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
	  <tr>
	  <td align="center">RESULTADO INSPECCION</td>
	  </tr>
	  </table><BR>  		  
	  <table width="645" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="85" rowspan="2">DEFECTO</td>
            <td colspan="4" align="center">RECUPERABLE</td>
            <td colspan="4" align="center">RECHAZADO</td>
          </tr>
          <tr> 
            <td width="60" align="center">RUEDA 1</td>
            <td width="60" align="center">RUEDA 2</td>
            <td width="60" align="center">H.MADRES</td>
            <td width="60" align="center">TOTAL</td>
            <td width="60" align="center">RUEDA 1</td>
            <td width="60" align="center">RUEDA 2</td>
            <td width="60" align="center">H.MADRES</td>
            <td width="60" align="center">TOTAL</td>
          </tr>
		  <?php
			$TotalRecupRueda1=0;
			$TotalRecupRueda2=0;
			$TotalRecupHM=0;
			$TotalRecuperable=0;
			$TotalRechazRueda1=0;
			$TotalRechazRueda2=0;
			$TotalRechazHM=0;
			$TotalRechazado=0;
			$Consulta="select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='2008'";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				$TotalRecup='';
				echo "<td>".$Fila["nombre_subclase"]."</td>";
				$Consulta="select recuperables from sea_web.rechazos "; 
				$Consulta=$Consulta." where cod_producto=17 and cod_subproducto=4 and cod_tipo=6 and cod_defecto<>0 and hornada='".$Hornada."' and cod_defecto=".$Fila["cod_subclase"]." and rueda=1";
				$Respuesta2=mysqli_query($link, $Consulta);
				if ($Fila2=mysqli_fetch_array($Respuesta2))
				{
					echo "<td align='right'>".$Fila2["recuperables"]."</td>";
					$TotalRecup=$Fila2["recuperables"];
					$TotalRecupRueda1=$TotalRecupRueda1+$Fila2["recuperables"];
				}
				else
				{
					echo "<td>&nbsp;</td>";
				}	
				$Consulta="SELECT recuperables from sea_web.rechazos "; 
				$Consulta=$Consulta." where cod_producto=17 and cod_subproducto=4 and cod_tipo=6 and cod_defecto<>0 and hornada='".$Hornada."' and cod_defecto=".$Fila["cod_subclase"]." and rueda=2";
				$Respuesta2=mysqli_query($link, $Consulta);
				if ($Fila2=mysqli_fetch_array($Respuesta2))
				{
					echo "<td align='right'>".$Fila2["recuperables"]."</td>";
					$TotalRecup=$TotalRecup+$Fila2["recuperables"];
					$TotalRecupRueda2=$TotalRecupRueda2+$Fila2["recuperables"];
				}
				else
				{
					echo "<td>&nbsp;</td>";
				}	
				$Consulta="SELECT recuperables from sea_web.rechazos "; 
				$Consulta=$Consulta." where cod_producto=17 and cod_subproducto=8 and cod_tipo=6 and cod_defecto<>0 and hornada='".$Hornada."' and cod_defecto=".$Fila["cod_subclase"]." and rueda=0";
				$Respuesta2=mysqli_query($link, $Consulta);
				if ($Fila2=mysqli_fetch_array($Respuesta2))
				{
					echo "<td align='right'>".$Fila2["recuperables"]."</td>";
					$TotalRecup=$TotalRecup+$Fila2["recuperables"];
					$TotalRecupHM=$TotalRecupHM+$Fila2["recuperables"];
					$TotalRecuperable=$TotalRecuperable+$TotalRecup;
				}
				else
				{
					echo "<td>&nbsp;</td>";				
				}
				if ($TotalRecup!='')
				{
					echo "<td class='detalle01' align='right'>".$TotalRecup."</td>";
				}	
				else
				{
					echo "<td class='detalle01'>&nbsp;</td>";
				}
				$TotalRechaz='';
				$Consulta="SELECT rechazados from sea_web.rechazos "; 
				$Consulta=$Consulta." where cod_producto=17 and cod_subproducto=4 and cod_tipo=6 and cod_defecto<>0 and hornada='".$Hornada."' and cod_defecto='".$Fila["cod_subclase"]."' and rueda=1";
				$Respuesta2=mysqli_query($link, $Consulta);
				if ($Fila2=mysqli_fetch_array($Respuesta2))
				{
					echo "<td align='right'>".$Fila2["rechazados"]."</td>";
					$TotalRechaz=$Fila2["rechazados"];
					$TotalRechazRueda1=$TotalRechazRueda1+$Fila2["rechazados"];
				}
				else
				{
					echo "<td>&nbsp;</td>";
				}	
				$Consulta="select rechazados from sea_web.rechazos "; 
				$Consulta=$Consulta." where cod_producto=17 and cod_subproducto=4 and cod_tipo=6 and cod_defecto<>0 and hornada='".$Hornada."' and cod_defecto='".$Fila["cod_subclase"]."' and rueda=2";
				$Respuesta2=mysqli_query($link, $Consulta);
				if ($Fila2=mysqli_fetch_array($Respuesta2))
				{
					echo "<td align='right'>".$Fila2["rechazados"]."</td>";
					$TotalRechaz=$TotalRechaz+$Fila2["rechazados"];
					$TotalRechazRueda2=$TotalRechazRueda2+$Fila2["rechazados"];
				}
				else
				{
					echo "<td>&nbsp;</td>";
				}	
				$Consulta="select rechazados from sea_web.rechazos "; 
				$Consulta=$Consulta." where cod_producto=17 and cod_subproducto=8 and cod_tipo=6 and cod_defecto<>0 and hornada='".$Hornada."' and cod_defecto='".$Fila["cod_subclase"]."' and rueda=0";
				$Respuesta2=mysqli_query($link, $Consulta);
				if ($Fila2=mysqli_fetch_array($Respuesta2))
				{
					echo "<td align='right'>".$Fila2["rechazados"]."</td>";
					$TotalRechaz=$TotalRechaz+$Fila2["rechazados"];
					$TotalRechazHM=$TotalRechazHM+$Fila2["rechazados"];
					$TotalRechazado=$TotalRechazado+$TotalRechaz;
				}
				else
				{
					echo "<td>&nbsp;</td>";				
				}
				if ($TotalRechaz!='')
				{
					echo "<td class='detalle01' align='right'>".$TotalRechaz."</td>";
				}	
				else
				{
					echo "<td class='detalle01'>&nbsp;</td>";
				}
				echo "</tr>";
			}
			echo "<tr>";
			echo "</tr>";
			echo "<td width='100'>&nbsp;</td>";
			echo "<td width='70'>&nbsp;</td>";
			echo "<td width='70'>&nbsp;</td>";
			echo "<td width='70'>&nbsp;</td>";									
			echo "<td width='70'class='detalle01'>&nbsp;</td>";
			echo "<td width='70'>&nbsp;</td>";
			echo "<td width='70'>&nbsp;</td>";
			echo "<td width='70'>&nbsp;</td>";
			echo "<td width='70'class='detalle01'>&nbsp;</td>";
			echo "<tr class='detalle01'>";
			echo "<td width='100'>TOTALES</td>";
			echo "<td width='70' align='right'>$TotalRecupRueda1</td>";
			echo "<td width='70' align='right'>$TotalRecupRueda2</td>";
			echo "<td width='70' align='right'>$TotalRecupHM</td>";									
			echo "<td width='70' align='right'>$TotalRecuperable</td>";
			echo "<td width='70' align='right'>$TotalRechazRueda1</td>";
			echo "<td width='70' align='right'>$TotalRechazRueda2</td>";
			echo "<td width='70' align='right'>$TotalRechazHM</td>";
			echo "<td width='70' align='right'>$TotalRechazado</td>";
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
