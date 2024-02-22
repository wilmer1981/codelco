<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo7 {font-size: 14px}
-->
</style>
<?php
if(!isset($Mes))
	$Mes=date('m');
if(!isset($Ano))
	$Ano=date('Y');

?>
<form name="PrinElectPLata" method="post">
<table width="60%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="0" cellpadding="0"  cellspacing="0">
      <tr>
        <td width="98" height="35" align="left" class="formulario"   ><img src="archivos/LblCriterios.png" /> </td>
        <td colspan="4" align="center" valign="top" class="formulario Estilo7">Traspaso de restos de anodos </td>
        <td width="220" align="right" class="formulario">
		<a href="JavaScript:Proceso('B','8')"><img src="archivos/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="javascript:Proceso('E','8')"><img src="archivos/excel.png" alt='Excel' width="25" height="25" border="0" align="absmiddle" /></a> &nbsp;
		<a href="javascript:window.print()"><img src="archivos/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle" /></a>&nbsp; 
		<a href="JavaScript:Proceso('S')"><img src="archivos/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle" /></a></td>
      </tr>
      <tr>
        <td align="left" class="formulario">Fecha</td>
        <td colspan="5" class="formulario">
		<select name="Mes">
		<option value="-1" selected="selected">Seleccionar</option>
		<?php
			for ($i=1;$i<=12;$i++)
			{
				if (isset($Mes))
				{
					if ($i == $Mes)
						echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
					else	
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
				else
				{
					if ($i == $MesActual)
						echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
					else	
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}
			}
		?>
		</select>
		&nbsp;
		<select name='Ano'>
		<option value="-1" selected="selected">Seleccionar</option>
		<?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($Ano))
				{
					if ($i == $Ano)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == $AnoActual)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	
						echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
			?>
		 </select>		
          <!--<input type="text" size="9" readonly="" maxlength="10" name="FDesde" id="FDesde"  class="InputDer" value='<?php //echo $FDesde?>' />
          <img src="archivos/calendario.png" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18"  border="0" align="absmiddle" onclick="popFrame.fPopCalendar(FDesde,FDesde,popCal);return false" /> Hasta
          <input type="text" size="9" readonly="" maxlength="10" name="FHasta" id="FHasta"  class="InputDer" value='<?php //echo $FHasta?>'/>
          <img src="archivos/calendario.png" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18"  border="0" align="absmiddle" onclick="popFrame.fPopCalendar(FHasta,FHasta,popCal);return false" /></td>-->
        </tr>
		<?php
		   $MesAno=explode('-',date('Y-m',mktime(0,0,0,$Mes-1,1,$Ano)));
		   $Consulta23="select si_p,si_c from pmn_web.stock_pmn where mes='".$Mes."' and ano='".$Ano."' and cod_producto='19' and cod_subproducto='17'";
		   $Resp=mysqli_query($link, $Consulta23);$AInicial=0;$PInicial=0;
		   if($Fila=mysqli_fetch_array($Resp))
		   {
				$AInicial=$Fila[si_c];
				$PInicial=$Fila[si_p];
		   }
		?>
      <tr>
	  <td colspan="6" class="formulario">&nbsp;</td>
	  </tr>		
      <tr>
	  <td align="left" class="formulario">Acumulado Inicial</td>
	  <td colspan="5" class="formulario"><input name="AInicial" size="10" maxlength="6" class="InputDer" readonly="" value="<?php echo number_format($AInicial,2,',','.')?>"/></td>
	  </tr>		
      <tr>
	  <td align="left" class="formulario">Peso Inicial</td>
	  <td colspan="5" class="formulario"><input name="PInicial" size="10" maxlength="6" class="InputDer"  readonly="" value="<?php echo number_format($PInicial,2,',','.')?>"/></td>
	  </tr>		
      <tr>
        <td colspan="6" class="formulario">&nbsp;</td>
      </tr>
    </table></td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"></td>
  </tr>
</table>
<br />
<table width="80%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center">
	<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr class="TituloCabeceraAzul">
        <td width="4%" rowspan="2" align="center">D&iacute;a</td>
        <td width="4%" rowspan="2" align="center">Turno </td>
        <td width="12%" rowspan="2" align="center">N&deg; Electrolisis </td>
        <td width="2%" rowspan="2" align="center">M</td>
        <td width="9%" rowspan="2" align="center" >Inicial</td>
        <td width="9%" rowspan="2" align="center" >Cantidad Orejas </td>
        <td width="8%" rowspan="2" align="center" >Peso Restos </td>
        <!--<td colspan="2" align="center" >Acumulados</td>-->
        <td colspan="2" align="center">Personal</td>
        <td colspan="2" align="center">Beneficiadas</td>
        <td width="12%" rowspan="2" align="center">Existencia</td>
      </tr>
      <tr class="TituloCabeceraAzul">
        <!--<td width="10%" align="center" >Cantidad</td>
        <td width="8%" align="center" >Peso</td>-->
        <td width="12%" align="center">Jefe de Turno </td>
        <td width="12%" align="center">Operador E-Ag </td>
        <td width="9%" align="center">Hornada </td>
        <td width="10%" align="center">Peso </td>
      </tr>
	  <?php
	  if($Buscar=='S')
	  {
	  	//echo "mes:    ".$CmbMes;
		//$Consulta = "select * from pmn_web.carga_horno_trof t1 ";
		//$Consulta.= " where t1.fecha between '".$FDesde."' and '".$FHasta."' and t1.cod_producto='19' and t1.cod_subproducto='17'";	  
		//$Consulta.= " group by t1.fecha order by t1.fecha asc, t1.turno, t1.hornada";
		?>
		<tr>			
		<td colspan="12" align="left" class="TituloCabecera2"><?php echo $Meses[$Mes-1]." - ".$Ano;?></td>			
		</tr>
		<?php			
		  for($i=1;$i<=31;$i++)
		  {		
				$Fecha=	$Ano."-".$Mes."-".$i;
				$Consulta = "select t1.fecha from pmn_web.descarga_electrolisis_plata t1";
				//$Consulta.= " left join pmn_web.carga_horno_trof t2 on t1.fecha=t2.fecha and t2.cod_producto='19' and t2.cod_subproducto='17'";
				$Consulta.= " where t1.fecha='".$Fecha."'";	  
				$Consulta.= " group by t1.fecha order by t1.fecha asc";
				//echo $Consulta."<br>";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Row = mysqli_fetch_array($Respuesta))
				{
					$Consulta = "select *,t1.fecha from pmn_web.descarga_electrolisis_plata t1";
					//$Consulta.= " left join proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase = ".$Row1[turno]";
					$Consulta.= " where fecha='".$Fecha."'";	  
					$Consulta.= " group by t1.fecha order by t1.fecha asc";
					//echo $Consulta;
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						$Fecha=explode('-',$Row["fecha"]);
						$Ano=$Fecha[0];
						$Mes=$Fecha[1];
						$Dia=$Fecha[2];
						$Consulta1 = "select * from pmn_web.descarga_electrolisis_plata ";
						$Consulta1.= " where fecha='".$Row["fecha"]."'";	  
						$Consulta1.= " group by turno,num_electrolisis order by turno='3' desc, turno='1' desc , turno='2' desc";
						$Respuesta1 = mysqli_query($link, $Consulta1);
						$Rows=0;
						while ($Row1 = mysqli_fetch_array($Respuesta1))
							$Rows=$Rows+1;
						
						?>
						<tr bgcolor="#CCCCCC">			
						<td rowspan="<?php echo $Rows;?>" align="center" bgcolor="#CCCCCC"><?php echo $Dia;?></td>			
						<?php	
						$Consulta1 = "select *,t1.turno from pmn_web.descarga_electrolisis_plata t1";
						//$Consulta1.= " left join pmn_web.carga_horno_trof t2 on t1.fecha=t2.fecha and t2.cod_producto='19' and t2.cod_subproducto='17'";
						$Consulta1.= " where t1.fecha='".$Row["fecha"]."'";	  
						$Consulta1.= " group by t1.turno,t1.num_electrolisis order by t1.turno asc,num_electrolisis";
						$Respuesta1 = mysqli_query($link, $Consulta1);
						while ($Row1 = mysqli_fetch_array($Respuesta1))
						{
						
							$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase = ".$Row1[turno];
							//echo $Consulta;
							$Resp2 = mysqli_query($link, $Consulta);
							if ($Row2 = mysqli_fetch_array($Resp2))
							{
								echo "<td bgcolor='#CCCCCC' align='center'>".strtoupper($Row2["nombre_subclase"])."</td>\n";
							}
							else
							{
								echo "<td bgcolor='#CCCCCC'>&nbsp;</td>\n";
							}
							$AuxAcumu=$AInicial+$Row1[cant_orejas];
							$AuxPeso=$PInicial+$Row1[peso_resto];
							$PInicialB=$PInicial;
							$PExistencia=$PInicial+$Row1[peso_resto];
							?>
							<td align='center' bgcolor="#CCCCCC" class="TituloCabeceraOz"><?php echo $Row1[num_electrolisis];?></td>
							<td bgcolor="#CCCCCC" align='center'><?php echo $Row1["grupo"];?></td>
							<td bgcolor="#CCCCCC" align='right'><?php echo number_format($PInicial,2,",","");?></td>
							<td bgcolor="#CCCCCC" align='right'><?php echo $Row1[cant_orejas];?></td>
							<td bgcolor="#CCCCCC" align='right'><?php echo number_format($Row1[peso_resto],2,",","");?></td>
							<?php
							$sql = "select * from proyecto_modernizacion.funcionarios where rut = '".$Row1[jefe_turno]."'";
							$result2 = mysqli_query($link, $sql);
							if ($row2=mysqli_fetch_array($result2))
								$TxtJefeTurno = ucwords(strtolower(substr($row2["nombres"],0,1).". ".$row2["apellido_paterno"]));
							else	$JefeTurno = "No Encontrado";
							?>
							<td  align='left' bgcolor="#CCCCCC" valign='middle'><?php echo $TxtJefeTurno;?></td>
							<?php
							$sql = "select * from proyecto_modernizacion.funcionarios where rut = '".$Row1[operador]."'";
							$result2 = mysqli_query($link, $sql);
							if ($row2=mysqli_fetch_array($result2))
								$TxtOperador = ucwords(strtolower(substr($row2["nombres"],0,1).". ".$row2["apellido_paterno"]));
							else	$TxtOperador = "No Encontrado";
							?>
							<td align='left' bgcolor="#CCCCCC" valign='middle'><?php echo $TxtOperador;?></td>
							<td align='center' bgcolor="#CCCCCC" valign='middle'>-</td>
							<td align='center' bgcolor="#CCCCCC" valign='middle'>-</td>
							<td align='right' bgcolor="#CCCCCC" valign='middle'><?php echo number_format($PExistencia,2,",","");?></td>
					  </tr>
						<?php
							//EL RESULTADO DE LA SUMA SERIA AHORA EL CANTIDAD ACUMULADA INICIAL.
							$PInicial=$PExistencia;
							$SumaPesos=$SumaPesos+$Row1[peso_resto];
						}
					}
					$Resta='S';
				}	
				else
					$Resta='N';
				//TERMINA EL PROICESO PARA LA ELECTROLISIS
				$Consulta = "select * from pmn_web.carga_horno_trof t1 ";
				$Consulta.= " where day(fecha)='".$i."' and month(fecha)='".$Mes."' and year(fecha)='".$Ano."' and t1.cod_producto='19' and t1.cod_subproducto='17'";	  
				$Consulta.= " group by t1.fecha order by t1.fecha asc, t1.turno, t1.hornada";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Row = mysqli_fetch_array($Respuesta))
				{
					$Consulta = "select * from pmn_web.carga_horno_trof t1 ";
					$Consulta.= " where day(fecha)='".$i."' and month(fecha)='".$Mes."' and year(fecha)='".$Ano."' and t1.cod_producto='19' and t1.cod_subproducto='17'";	  
					$Consulta.= " group by t1.fecha order by t1.fecha asc, t1.turno, t1.hornada";
					//echo $Consulta;
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						$Fecha=explode('-',$Row["fecha"]);
						$Ano=$Fecha[0];
						$Mes=$Fecha[1];
						$Dia=$Fecha[2];
						
						$Consulta1 = "select * from pmn_web.carga_horno_trof ";
						$Consulta1.= " where fecha='".$Row["fecha"]."' and cod_producto='19' and cod_subproducto='17'";	  
						$Consulta1.= " order by fecha asc, turno, hornada";
						//echo "consulta rows:    ".$Consulta1."<br>";
						$Respuesta1 = mysqli_query($link, $Consulta1);
						$Rows=0;
						while ($RowRows = mysqli_fetch_array($Respuesta1))
								$Rows=$Rows+1;
						?>
						<tr>			
						<td rowspan="<?php echo $Rows;?>" align="center"><?php echo $Dia;?></td>			
						<?php			
						$Consulta1 = "select * from pmn_web.carga_horno_trof ";
						$Consulta1.= " where fecha='".$Row["fecha"]."' and cod_producto='19' and cod_subproducto='17'";	  
						$Consulta1.= " order by fecha asc, turno, hornada";
						$Respuesta1 = mysqli_query($link, $Consulta1);
						while ($Row1 = mysqli_fetch_array($Respuesta1))
						{			
							$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase = ".$Row1[turno];
							$Resp2 = mysqli_query($link, $Consulta);
							if ($Row2 = mysqli_fetch_array($Resp2))
							{
								echo "<td align='center'>".strtoupper($Row2["nombre_subclase"])."</td>\n";
							}
							else
							{
								echo "<td>&nbsp;</td>\n";
							}
							$PExistencia=number_format($PInicial,2,",","")-number_format($Row1[cantidad],2,",","");
							?>
							<td align='center'>-</td>
							<td align='center'>-</td>
							<td align='right'><?php echo number_format($PInicial,2,",","");?></td>
							<td align='center'>-</td>
							<td align='center'>-</td>
							<td align='center'>-</td>
							<td align='center'>-</td>
							<td align='center' class="Estilo5"><?php echo $Row1["hornada"];?></td>
							<td align='right'><?php echo number_format($Row1[cantidad],2,",","");?></td>
							<td align='right'><?php echo number_format($PExistencia,2,",","");?></td>
					  </tr>
						<?php
						$PInicial=$PExistencia;
						$PesoHornada=$Row1[cantidad];
						}
						$TotPesoBene=$TotPesoBene+$PesoHornada;
					}
/*					if($Resta=='S')
					{
						$TotPesoProd=$TotPesoProd+$PInicial;
						$PInicial=$PesoHornada-$PInicial;
					}	
					else
					{
						$TotPesoProd=$TotPesoProd+$PInicial;
						echo $PInicial;
						$PInicial=0;
					}	
*/					
					/*$TotPesoProd=$TotPesoProd+$PInicial;
					$PInicial=$PesoHornada-$PInicial;

					$AInicial=0;
					$PInicial=abs($PInicial);*/
				}	
		   }
		   ?>
		   <tr>
		   	<td colspan="5" align="right" class="TituloCabeceraOz">Totales:</td>
		   	<td align="right" class="TituloCabeceraOz">&nbsp;</td>
		   	<td align="right" class="TituloCabeceraOz"><?php echo number_format($SumaPesos,2,",","");?>&nbsp;</td>
		   	<td colspan="3" align="right">&nbsp;</td>
		   	<td  align="right" class="TituloCabeceraOz"><?php echo number_format($TotPesoBene,2,",","");?>&nbsp;</td>
		   	<td align="right">&nbsp;</td>
		   </tr>
		   <?php	
	  }	
	  ?>
    </table>  <br />
<!--<table width="50%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr class="TituloCabeceraAzul">
        <td width="10%" colspan="4" align="center" class="TituloCabecera">Beneficiadas</td>
	  </tr>
      <tr class="TituloCabeceraAzul">
        <td width="10%" align="center">D&iacute;a</td>
        <td width="12%" align="center">Turno </td>
        <td width="54%" align="center">Hornada</td>
        <td width="24%" align="center">Peso</td>
      </tr>-->
	  <?php
	  if($Buscar=='S')
	  {
		/*$Consulta = "select * from pmn_web.carga_horno_trof t1 ";
		$Consulta.= " where t1.fecha between '".$FDesde."' and '".$FHasta."' and t1.cod_producto='19' and t1.cod_subproducto='17'";	  
		$Consulta.= " group by t1.fecha order by t1.fecha asc, t1.turno, t1.hornada";
		//echo $Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			$Fecha=explode('-',$Row["fecha"]);
			$Ano=$Fecha[0];
			$Mes=$Fecha[1];
			$Dia=$Fecha[2];
			
			$Consulta1 = "select * from pmn_web.carga_horno_trof ";
			$Consulta1.= " where fecha='".$Row["fecha"]."' and cod_producto='19' and cod_subproducto='17'";	  
			$Consulta1.= " order by fecha asc, turno, hornada";
			//echo "consulta rows:    ".$Consulta1."<br>";
			$Respuesta1 = mysqli_query($link, $Consulta1);
			$Rows=0;
			while ($RowRows = mysqli_fetch_array($Respuesta1))
					$Rows=$Rows+1;
			?>
			<tr bgcolor="#CCCCCC">			
			<td rowspan="<?php echo $Rows;?>" align="center" bgcolor="#CCCCCC"><?php echo $Dia;?></td>			
			<?php			
			$Consulta1 = "select * from pmn_web.carga_horno_trof ";
			$Consulta1.= " where fecha='".$Row["fecha"]."' and cod_producto='19' and cod_subproducto='17'";	  
			$Consulta1.= " order by fecha asc, turno, hornada";
			//echo $Consulta1."<br>";
			$Respuesta1 = mysqli_query($link, $Consulta1);
			$i=1;
			while ($Row1 = mysqli_fetch_array($Respuesta1))
			{			
				$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase = ".$Row1[turno];
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Row2 = mysqli_fetch_array($Resp2))
				{
					echo "<td bgcolor='#CCCCCC' align='center'>".strtoupper($Row2["nombre_subclase"])."</td>\n";
				}
				else
				{
					echo "<td bgcolor='#CCCCCC'>&nbsp;</td>\n";
				}
				?>
				<td align='center' bgcolor="#CCCCCC" class="TituloCabeceraOz"><?php echo $Row1["hornada"];?></td>
				<td bgcolor="#CCCCCC" align='right'><?php echo $Row1[cantidad];?></td>
		  </tr>
			<?php
				$i++;
			}
		}*/
	  }	
	  ?>
    	    	
	</td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"></td>
  </tr>
</table>
<p>&nbsp;</p>
</form>
