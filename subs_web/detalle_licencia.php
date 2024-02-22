<?Php
	$CodigoDeSistema=19;
	$CodigoDePantalla=2;
	include("func_mes_texto.php");
?>
<html>
<head>
	<title>Detalle de Licencias</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
	<script language="JavaScript">
	function Salir()
		{
			var f=document.detalles;
			window.close();
		}
	</script>
	
</head>

<body leftmargin="0" topmargin="0" marginwidth="3" marginheight="3">
<form name="detalle_lic" method="post">
	<table width="362" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
	  <tr>
		<td width="350" height="313" valign="top">  		 
		  <br>    	    		  
			<table width="328" border="1" align="center"cellpadding="2"  cellspacing="0" class="TablaInterior">
					<tr class="ColorTabla01">
						<td colspan="5"><b>Licencia Desde <? echo $FechaDesde." Hasta ".$FechaHasta; ?></b></td>					
					</tr>	
			        <tr class="ColorTabla02"> 
					  <td width="29" ><div align="center">Perd.</div></td>
					  <td width="51"><div align="center">Mes</div></td>
					  <td width="47"><div align="center">D&iacute;as</div></td>
					  <td width="82"><div align="center">Valor Diario</div></td>
 					  <td width="86"><div align="center">Valor a Pagar</div></td>
					</tr>						
				<?
				    $puntmes=$FechaDesde[3]."".$FechaDesde[4];					
					$puntano=$FechaDesde[6]."".$FechaDesde[7]."".$FechaDesde[8]."".$FechaDesde[9];
					$diadesde=$FechaDesde[0]."".$FechaDesde[1];					
					$meshasta=$FechaHasta[3]."".$FechaHasta[4];					
					$anohasta=$FechaHasta[6]."".$FechaHasta[7]."".$FechaHasta[8]."".$FechaHasta[9];
					$diahasta=$FechaHasta[0]."".$FechaHasta[1];
					$perd=1;
					$suma_valor=0;
					$valor_licencia = str_replace('.','', $valor_licencia); // Elimina puntos
					if (($puntmes==$meshasta) && ($puntano==$anohasta))
					{
						echo '<tr>';						
						$num_dia_mes = $diahasta-$diadesde+1;// saca lon N| de dia de un solo mes (desde- hasta en el mismo mes)//
						$valor_mes=($valor_licencia/$num_dias)*$num_dia_mes;
						$texto_mes = sacarmestexto($puntmes);						
						echo '<td align="center">'.$perd.'</td>';
						echo '<td>'.$texto_mes.'</td>';
						echo '<td align="center">'.$num_dia_mes.'</td>';
//						$v_diario=$valor_mes/$valor_diario; ---> Para el case de que se tenga que dividir el valor
						echo '<td  align="right">'.$valor_diario.'</td>';
						echo '<td  align="right">'.number_format($valor_mes,0,',','.').'</td>';						
						echo '</tr>';						
						$num_dia=$num_dia_mes;
					} else 
					  {
						$salir='n';
						$num_dia=0;
						$resta_primera_fecha='s';
						while($salir=='n')
						{
						   echo '<tr>';
							$texto_mes = sacarmestexto($puntmes);						
							if ($resta_primera_fecha=='s')
							{
							  $num_dia_mes =date("t",mktime(0,0,0,$puntmes,02,$puntano))-$diadesde+1;
							  $resta_primera_fecha='n';
							} else
								{														
									if (($puntmes==$meshasta) && ($puntano==$anohasta))
									{
										$num_dia_mes = $diahasta;
									} else 
										{
											// Saca los dia de un mes completo //
											$num_dia_mes =date("t",mktime(0,0,0,$puntmes,02,$puntano));
										}
								}
							$valor_mes=explode(".",($valor_licencia/$num_dias)*$num_dia_mes);
							$valor_mes=	$valor_mes[0];
							$suma_valor=$suma_valor+$valor_mes;
 						    echo $suma;
							echo '<td align="center">'.$perd.'</td>';
							echo '<td>'.$texto_mes.'</td>';
							echo '<td align="center">'.$num_dia_mes.'</td>';
//							$v_diario=$valor_mes/$valor_diario; ---> Para el case de que se tenga que dividir el valor
							echo '<td  align="right">'.$valor_diario.'</td>';
							echo '<td  align="right">'.number_format($valor_mes,0,',','.').'</td>';						
							if (($puntmes==$meshasta) && ($puntano==$anohasta))
							{
								break;
							}
							if ($puntmes=='12')
							{
								$puntmes='01';
								$puntano++;							
							}
							else
							{
								$puntmes++;
							}				
							$perd++;
							$num_dia=$num_dia+$num_dia_mes;
						 echo '</tr>';
						}	
					}

				?>
			</table>			
		     <p align="center">
   				<input type="button" name="BtnSalir"  value="Salir" style="width:70px" onClick="Salir()">
		    </p>
		 </td>
	  </tr>
	</table>
</form>

</body>
</html>
