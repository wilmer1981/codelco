	<? //echo "resumen";?>
   <table width="100%"  border="0" align="center" cellpadding="0"  cellspacing="0">				 	
 <tr>	 
   <td colspan="2">
     	<table width="100%" border="1" align="left" cellpadding="2" cellspacing="0">
			<?
			  $Consulta1="select distinct tipo_inventario from scop_contratos_flujos where cod_contrato='".$TxtContrato."' order by tipo_inventario";
			  $Resp1=mysql_query($Consulta1);	
			  while ($Fila1=mysql_fetch_array($Resp1))
			  {
					$TipoInventario=$Fila1[tipo_inventario];
					if($TipoInventario==1)
					{
						$TipoInventario='STOCK INICIAL';
				   		$TipoMov='3';
					}
					if($TipoInventario==2)
					{
						$TipoInventario='RECEPCI&Oacute;N';
				   		$TipoMov='2';
					}
				   	if($TipoInventario==3)
					{
						$TipoInventario='BENEFICIO/EMBARQUE';
				   		$TipoMov='2';
					}
				   	if($TipoInventario==4)
					{
						$TipoInventario='STOCK FINAL';
				   		$TipoMov='3';
					}
				   echo "<tr class='TitulotablaNaranja'>";
					 echo "<td width='7%' align='left' colspan='4'>".$TipoInventario."</td>";
				   echo "</tr>";
				    echo "<tr class='TitulotablaVerde'>";	
					 echo "<td width='5%' align='center' >&nbsp;</td>";
					 echo "<td width='75%' align='center' >Flujo</td>";
					 echo "<td width='20%' align='center' >Tipo Flujo</td>";
					 echo "<td width='20%' align='center' >Signo</td>";
					echo "</tr>"; 
				  $Consulta="select distinct t1.cod_contrato,t1.tipo_flujo,t2.nom_flujo,t1.flujo,t1.signo from scop_contratos_flujos t1 inner join scop_datos_enabal t2 on t1.flujo=t2.cod_flujo and t1.tipo_flujo=t2.origen where t1.cod_contrato='".$TxtContrato."' and t1.tipo_inventario='".$Fila1[tipo_inventario]."' and t2.tipo_mov='".$TipoMov."'";
				  $Resp=mysqli_query($link, $Consulta);	
				  while ($Fila=mysql_fetch_array($Resp))
				  {
						$Contrato=$Fila["cod_contrato"];
						$NomFlujo=$Fila[nom_flujo];	
						$TipoFlujo=$Fila[tipo_flujo];
						$CodFlujo=$Fila["flujo"];
						if($Fila["signo"]=='1')
							$Signo='+';
						else
							$Signo='-';	
						echo "<tr>";
							echo "<td align='center'>".str_pad($CodFlujo,3,'0',STR_PAD_LEFT)."</td>";	
							echo "<td align='left'>".$NomFlujo."</td>";	
							echo "<td align='center'>".$TipoFlujo."</td>";	
							echo "<td align='center'>".$Signo."</td>";	
						echo "</tr>";	
				  }
			  }
			?>
	  	</table>
		<br>
	 </td>
  </tr>
  </table>
	   
