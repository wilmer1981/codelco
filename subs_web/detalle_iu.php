<?Php
	/********************** Establecer Codigos ***********/
	$CodigoDeSistema=19;
	$CodigoDePantalla=2;
	/****************************************************/
	include("funcion.php");
?>
<!--------------------------  Inicio de Html  ------------------------------->
<html>
<head>
	<title>Detalle I.U del Mes del <? echo $mes;?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
	<script language="JavaScript">
	<!---------------------------------  FUNCIONES  -------------------------------->
		<!--- Salir -------->	
		function Salir()
		// Funcion que me permite del detalle Imp.Unico
		{
			var f=document.detalles;
			window.close();
		}
   <!---------------------------------- FIN FUNCIONES  --------------------------------------->	
	</script>	
</head>
<!-------------------------------	Cuerpo Principal  ----------------------------->	
<body leftmargin="0" topmargin="0" marginwidth="3" marginheight="3">
<form name="detalles" method="post">	
    <!--------------------------------Tabla Principal ---------------------------------->
	<table width="399" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
	  <tr>				
		<td width="387" height="393" valign="top"> <br>
				<center>
					<b><h3><? echo $mes."  ".$ano;?></h3></b>
				</center>
				<!--------------------------------Tabla Interrna ---------------------------------->
				<table width="350" border="0" align="center"cellpadding="2"  cellspacing="0" class="TablaInterior">
					<tr  class="Detalle02">
						<td colspan="1"><b><h>Valor Afectado ($)</h></b></td>
						<td align="right" colspan="4" >
							<input type="text" name="afecto"  value="<? echo number_format($valor_afecto,0,',','.');?>" class="InputDer" readonly>
						</td>					
					</tr>
					<tr class="Detalle02">
						<td  colspan="1"><b>Rebaja ($)</b></td>
						<td align="right" colspan="4">
							<input type="text" name="rebaja" value="<? echo str_replace(".",",",$rebaja); ?>" class="InputDer" readonly>
						</td>										
					</tr>
				  </table>
				  <br>			  
				  <!-- Carga de Campos Impuesto Mensual  -->
				  <table width="350" border="1" align="center"cellpadding="2"  cellspacing="0" class="TablaInterior">
					<tr bgcolor="#FFFFCC" class="ColorTabla01"> 
					  <td colspan="2"><div align="center"><strong>Monto de la Renta<br>
						  Liquida Imponible</strong></div></td>
					  <td width="81" rowspan="2"><div align="center"><strong>Factor</strong></div></td>
					  <td width="80" rowspan="2"><div align="center"><strong>Cantidad a Rebajar</strong></div></td>
					</tr>
					<tr bgcolor="#FFFFCC" class="ColorTabla01"> 
					  <td width="79"><div align="center" ><strong>Desde</strong></div></td>
					  <td width="82"><div align="center"><strong>Hasta</strong></div></td>
					</tr>
					<tr> 
					  <td colspan="4"><div align="center" > 
				  <?  
				  	  $fecha_min = $ano."-".sacarmes($mes)."-01";
					  $fecha_max = $ano."-".sacarmes($mes)."-28";
					  include ("conectar.php");
					  $consulta = "SELECT desde, hasta, posicion, factor, rebaja FROM subs_web.detalle_mes WHERE (fecha >= '".$fecha_min."') and (fecha <= '".$fecha_max."') GROUP BY fecha, posicion";
					  $respuesta = mysql_query($consulta);				  
					  // Muestra los datos por la consulta realizada de SELECT anterior
					  while($row=mysql_fetch_array($respuesta))
					   {
						  if ((($row[desde] <= $valor_afecto) && ($row[posicion] == '8')) || (($row[desde] <= $valor_afecto)  && ($row[hasta] >= $valor_afecto))){ 
						  	$color='red';
						  } else {
						    $color='black';
						  }							  
						  echo '<tr align="center" class="Detalle03">';
						  if ($row[desde]=='1')
						  {
	  						echo '<td><font color="'.$color.'"> 0 </font></td>';
						  } 
						  else
						  {
	  						echo '<td><font color="'.$color.'">'.number_format($row[desde],0,',','.').'</font></td>';
						  }
						  if ($row[hasta]=='-1')
						  {
							echo '<td><font color="'.$color.'"> Y m&aacute;s...</font></td>';
						  }					  
						  else
						  {
							echo '<td><font color="'.$color.'">'.number_format($row[hasta],0,',','.').'</font></td>';
						  }
						  echo '<td><font color="'.$color.'">'.$row[factor].'</font></td>';
						  echo '<td align="right"><font color="'.$color.'">'.str_replace(".",",",$row[rebaja]).'</font></td>';
						  echo '</tr>';
						} // fin : while ...
					  include ("cerrar.php");					 
					  ?>
						</div>
						<div align="center"> </div>
						<div align="center"> </div>
						<div align="center"> </div>
					  </td>
					</tr>
				  </table>
				  <!----------------------------------  Fin tabla interior  ----------------------------->
				  <p align="center">
				  	<input type="button" name="BtnSalir"  value="Salir" style="width:70px" onClick="Salir()">
				  </p>				  
			</td>
		</tr>
	</table>
  <!----------------------------------  Fin tabla principal  ----------------------------->
</form>
</body>
</html>
