<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<style type="text/css">

.Estilo7 {font-size: 14px}

</style>
<?php
/*
if(!isset($Mes))
	$MesActual=date('m');
if(!isset($Ano))
	$AnoActual=date('Y');
*/

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
        <td colspan="4" align="center" valign="top" class="formulario Estilo7">Producci&oacute;n Barro Anodico Descobrizado </td>
        <td width="214" align="right" class="formulario">
		<a href="JavaScript:Proceso('B','3')"><img src="archivos/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="javascript:Proceso('E','3')"><img src="archivos/excel.png" alt='Excel' width="25" height="25" border="0" align="absmiddle" /></a> &nbsp;
		<a href="javascript:window.print()"><img src="archivos/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle" /></a>&nbsp; 
		<a href="JavaScript:Proceso('S')"><img src="archivos/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle" /></a></td>
        <td width="10" align="right" class="formulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="formulario">Fecha</td>
        <td colspan="4" class="formulario">
		<select name="Mes">
          <option value="-1">Seleccionar</option>
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
				/*
				else
				{
					if ($i == $MesActual)
						echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
					else	
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
				}*/
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
				}/*
				else
				{
					if ($i == $AnoActual)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	
						echo "<option value='".$i."'>".$i."</option>\n";
				}*/
			}
			?>
</select></td>
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
<table width="60%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr class="TituloCabeceraAzul" bordercolor="#333333">
        <td width="4%" rowspan="2" align="center">D&iacute;a</td>
        <td width="4%" rowspan="2" align="center">Turno</td>
        <td width="9%" align="center" >Lixiviaci&oacute;n</td>
        <td colspan="2" align="center" >Carga</td>
        <td width="8%" align="center">Acido</td>
        <td width="8%" align="center">Filtrado</td>
        <td width="9%" align="center">Producci&oacute;n</td>
        <td width="13%" rowspan="2" align="center">Operador Lixiviaci&oacute;n </td>
      </tr>
      <tr class="TituloCabeceraAzul" bordercolor="#333333">
        <td align="center">N&deg;</td>
        <td width="7%" align="center">D&iacute;a</td>
        <td width="6%" align="center">Hora</td>
        <td align="center">Lts</td>
        <td align="center">Hora</td>
        <td align="center">Peso H20 </td>
      </tr>
	  <?php
	  if($Buscar=='S')
	  {
	  	?>
			<tr>
			<td colspan="13" align="left" class="titulo_azul"><?php echo $Meses[$Mes-1]." - ".$Ano;?></td>
			</tr>
		 <?php
		 $Total=0;
		  for($i=1;$i<=31;$i++)
		  {		
		  		$Fecha=	$Ano."-".$Mes."-".$i;
				$sql = "select fecha from lixiviacion_barro_anodico";
				$sql.= " where fecha='".$Fecha."'";
				$sql.= " group by fecha order by fecha asc,turno";
				//echo $sql."<br>"; 
				$result = mysqli_query($link, $sql);
				$Conteo=0;
				if ($Fila = mysqli_fetch_array($result))
				{
					//echo " fecha:   ".$Fila["fecha"]."<br>"; 
					$Fecha=explode('-',$Fila["fecha"]);
					$Ano=$Fecha[0];
					$Mes=$Fecha[1];
					$Dia=$Fecha[2];
					//echo " fecha:   ".$Fila["fecha"]."<br>";
					$sqlDes = "select * from lixiviacion_barro_anodico";
					$sqlDes.= " where fecha='".$Fila["fecha"]."' ";
					$sqlDes.= " order by fecha asc,turno";
					//echo $sqlDes."<br>"; 
					$resultDes = mysqli_query($link, $sqlDes);
					$Cont=0;
					while ($rowDes = mysqli_fetch_array($resultDes))
							$Cont=$Cont+1;
					?>
					<tr bgcolor="#CCCCCC">
					<td align='center' rowspan="<?php echo $Cont;?>" valign='middle'><?php echo $Dia;?></td>
					<?php
					$sqlDes = "select * from lixiviacion_barro_anodico";
					$sqlDes.= " where fecha='".$Fila["fecha"]."' ";
					$sqlDes.= " order by fecha asc,turno";
					//echo $sqlDes."<br>"; 
					$resultDes = mysqli_query($link, $sqlDes);$Conteo2='0';
					
					while ($rowDes = mysqli_fetch_array($resultDes))
					{
						$Fecha2=explode('-',$rowDes["fecha"]);
						$Ano=$Fecha2[0];
						$Mes=$Fecha2[1];
						$Dia=$Fecha2[2];
		
							
							$sql = "select * from proyecto_modernizacion.sub_clase where cod_clase=1 and cod_subclase=".$rowDes["turno"];
							$result2 = mysqli_query($link, $sql);
							if ($row2=mysqli_fetch_array($result2))
								$TxtTurno = strtoupper($row2["nombre_subclase"]);
							else	$TxtTurno = "N";
							
							?>
							<td align='center' bgcolor="#CCCCCC" valign='middle'><?php echo $TxtTurno;?></td>
							<td align='center' valign='middle' bgcolor="#CCCCCC" class="TituloCabeceraOz"><?php echo $rowDes["num_lixiviacion"];?></td>
							<td align='center' bgcolor="#CCCCCC" valign='middle'><?php echo $rowDes["dia_carga"];?></td>
							<td align='center' bgcolor="#CCCCCC" valign='middle'><?php echo $rowDes["hora_carga"];?></td>
							<td align='right' bgcolor="#CCCCCC" valign='middle'><?php echo $rowDes["acidc"];?></td>
							<td align='center' bgcolor="#CCCCCC" valign='middle'><?php echo $rowDes["hora_filtracion"];?></td>
							<td align='right' bgcolor="#CCCCCC"  valign='middle'><?php echo number_format($rowDes["bad"],2,',','.');?></td>
							<?php
							$sql = "select * from proyecto_modernizacion.funcionarios where rut = '".$rowDes["operador"]."'";
							$result2 = mysqli_query($link, $sql);
							if ($row2=mysqli_fetch_array($result2))
								$TxtOperador = ucwords(strtolower(substr($row2["nombres"],0,1).". ".$row2["apellido_paterno"]));
							else	$TxtOperador = "No Encontrado";
							?>
							<td align='left' bgcolor="#CCCCCC" valign='middle'><?php echo $TxtOperador;?></td>
		  </tr>
					  <?php		
						$Total=$Total+$rowDes["bad"];
					}
				}
		  }	
		  ?>
		  <tr  class="TituloCabecera">
		  	<td colspan="7" align="right">Total</td>
		  	<td align="right" ><?php echo number_format($Total,2,',','.');?></td>
		  	<td>&nbsp;</td>
		  </tr>
		  <?php
	 }	
	  ?> 		  
    </table>      �	
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
