<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo7 {font-size: 14px}
-->
</style>
<?php
if(!isset($Mes) || $Mes=='')
	$Mes=date('m');
if(!isset($Ano) || $Ano=='')
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
        <td align="center" valign="top" class="formulario Estilo7">Movimiento de Calcina  </td>
        <td width="214" align="right" class="formulario">
		<a href="JavaScript:Proceso('B','5')"><img src="archivos/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="javascript:Proceso('E','5')"><img src="archivos/excel.png" alt='Excel' width="25" height="25" border="0" align="absmiddle" /></a> &nbsp;
		<a href="javascript:window.print()"><img src="archivos/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle" /></a>&nbsp; 
		<a href="JavaScript:Proceso('S')"><img src="archivos/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle" /></a></td>
        <td width="10" align="right" class="formulario">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" class="formulario">Fecha</td>
        <td class="formulario"><select name="Mes">
          <option value="-1" selected="selected">Seleccionar</option>
          <?php
			for ($i=1;$i<=12;$i++)
			{
				if ($i == $Mes)
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else	
					echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
		?>
        </select>
		&nbsp;
		<select name='Ano'>
		  <option value="-1" selected="selected">Seleccionar</option>
		  <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if ($i == $Ano)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		  ?>
		</select></td>
        </tr>
      <tr>
		<?php
		   $Consulta23="select si_p from pmn_web.stock_pmn where mes='".$Mes."' and ano='".$Ano."' and cod_producto='36' and cod_subproducto='1'";
		   $Resp=mysqli_query($link, $Consulta23);
		   if($Fila=mysqli_fetch_array($Resp))
				$Exist=$Fila[si_p];
		?>
	  
        <td colspan="3" class="formulario">&nbsp;</td>
        </tr>
      <tr>
        <td class="formulario">Existencia Inicial </td>
        <td colspan="2" class="formulario">
		<input type="hidden" name="Exist2" value="<?php echo number_format($Exist,2,',','.');?>" readonly="" size="10" maxlength="5" />
		<?php echo number_format($Exist,2,',','.');?>&nbsp;</td>
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
        <td width="5%" colspan="4" align="center">Planta de Selenio</td>
        <td width="5%" colspan="4" align="center">Carga Horno Trof</td>
	  </tr>	
      <tr class="TituloCabeceraAzul" bordercolor="#333333">
        <td width="5%" rowspan="2" align="center">D&iacute;a</td>
        <td width="10%" rowspan="2" align="center">Turno</td>
        <td width="26%" align="center" >Exist. Ini </td>
        <td  align="center" >Producci&oacute;n</td>
        <td colspan="3" align="center">Beneficio H. Trof </td>
        <td width="14%" align="center">Stock Final </td>
      </tr>
      <tr class="TituloCabeceraAzul" bordercolor="#333333">
        <td align="center">Kg.</td>
        <td align="center">Kg.</td>
        <td width="11%" align="center">Turno</td>
        <td width="11%" align="center">Hornada</td>
        <td width="12%" align="center">Kg.</td>
        <!--<td width="11%" align="center">Total Kg.</td>-->
        <td align="center">Kg.</td>
      </tr>
	  <?php
	  if($Buscar=='S')
	  {
	  	?>
			<tr>
			<td colspan="14" align="left" class="titulo_azul"><?php echo $Meses[$Mes-1]." - ".$Ano;?></td>
			</tr>
		 <?php
		  $Vueltas=1; 	
		  for($i=1;$i<=31;$i++)
		  {		
				$Fecha=	$Ano."-".$Mes."-".$i;
				$EntroPLanta='N';
				$sql = "select * from pmn_web.deselenizacion t1";
				$sql.= " where t1.fecha='".$Fecha."'";
				$sql.= " group by t1.fecha order by t1.fecha asc,t1.turno ";
				$result = mysqli_query($link, $sql);
				if($Fila = mysqli_fetch_array($result))
				{
					$EntroPLanta='S';
					$FechaAux=explode('-',$Fecha);
					$AnoAux=$FechaAux[0];
					$MesAux=$FechaAux[1];
					$DiaAux=$FechaAux[2];
					//echo " fecha:   ".$Fila["fecha"]."<br>";
					$Sql3="select t1.prod_calcina,t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial,t1.turno from pmn_web.deselenizacion t1 ";								
					$Sql3.= " where t1.fecha='".$Fecha."' ";
					$Sql3.= " group by t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial order by t1.fecha asc,t1.turno";	
					$result3 = mysqli_query($link, $Sql3);$Calcina=0;
					while($row3 = mysqli_fetch_array($result3))
						$Calcina=$Calcina+$row3[prod_calcina];

					$Sql3="select t1.prod_calcina,t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial,t1.turno from pmn_web.deselenizacion t1 ";								
					$Sql3.= " where t1.fecha='".$Fecha."' ";
					$Sql3.= " group by t1.turno order by t1.fecha asc,t1.turno";	
					$result3 = mysqli_query($link, $Sql3);$TurnoProd='';
					while($row3 = mysqli_fetch_array($result3))
					{
						$sql5 = "select * from proyecto_modernizacion.sub_clase where cod_clase=1 and cod_subclase=".$row3[turno];
						$result5 = mysqli_query($link, $sql5);
						if ($row5=mysqli_fetch_array($result5))
							$TurnoProd=$TurnoProd.strtoupper($row5["nombre_subclase"]).", ";
					}
				    if($TurnoProd !='')
					   $TurnoProd=substr($TurnoProd,0,strlen($TurnoProd)-2);		
					$sql = "select t2.turno,t2.hornada from pmn_web.deselenizacion t1 left join pmn_web.carga_horno_trof t2 on t1.fecha=t2.fecha and cod_producto='36' and cod_subproducto='1' and t2.hornada<>''";
					$sql.= " where t1.fecha='".$Fecha."' ";
					$sql.= " group by t2.turno,t2.hornada order by t1.fecha asc,t1.turno ";
					$result2 = mysqli_query($link, $sql);$Cont=0;
					while($Fila2 = mysqli_fetch_array($result2))
						$Cont=$Cont+1;
						
					$Color='';
					if($i%2)
						$Color="#CCCCCC";	
					?>
					<tr >
					<?php	
					$sql = "select t2.turno,t2.hornada,t2.cantidad from pmn_web.deselenizacion t1 left join pmn_web.carga_horno_trof t2 on t1.fecha=t2.fecha and cod_producto='36' and cod_subproducto='1'  and t2.hornada<>''";
					$sql.= " where t1.fecha='".$Fecha."'";
					$sql.= " group by t2.turno,t2.hornada order by t1.fecha asc,t1.turno ";
					//echo $sql."<br>"; 
					$result2 = mysqli_query($link, $sql);$Vueltas='1';$Cuenta=0;
					while($Fila2 = mysqli_fetch_array($result2))
					{
						$TxtTurno2 = "--";
						if($Fila2[turno]!='')
						{
							$sql4 = "select * from proyecto_modernizacion.sub_clase where cod_clase=1 and cod_subclase=".$Fila2[turno];
							$result4 = mysqli_query($link, $sql4);
							if ($row4=mysqli_fetch_array($result4))
								$TxtTurno2 = strtoupper($row4["nombre_subclase"]);
						}							
						if($Vueltas=='1')
							$ExistIniF=$Exist;
						else
						{
							$ExistIniF=$Exist;	
							$ExistIniF=$ExistIniF;									
						}	
						?>
							<?php
							if($Cuenta==0)
							{
								$sql = "select t2.turno,t2.hornada,t2.cantidad from pmn_web.deselenizacion t1 left join pmn_web.carga_horno_trof t2 on t1.fecha=t2.fecha and cod_producto='36' and cod_subproducto='1'  and t2.hornada<>''";
								$sql.= " where t1.fecha='".$Fecha."'";
								$sql.= " group by t2.turno,t2.hornada order by t1.fecha asc,t1.turno ";
								//echo $sql."<br>"; 
								$result3 = mysqli_query($link, $sql);$ValorBeneficio=0;
								while($Fila3 = mysqli_fetch_array($result3))
									$ValorBeneficio=$ValorBeneficio+$Fila3[cantidad];
							$SkFinal=$ExistIniF+$Calcina-$ValorBeneficio;
							?>
							<td align='center' bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>"><?php echo $i?></td>
							<td align='center' bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>"><?php echo $TurnoProd?></td>
							<td align='right' bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>"><?php echo number_format($ExistIniF,2,',','.');?>&nbsp;</td>
							<td width="11%" bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>" align="right"><?php echo number_format($Calcina,0,',','.');?>&nbsp;</td>
							<?php
							}
							?>
							<td align='center' bgcolor="<?php echo $Color;?>" valign='middle' ><?php echo $TxtTurno2;?>&nbsp;</td>
							<td align='left' bgcolor="<?php echo $Color;?>" valign='middle'><?php echo $Fila2["hornada"];?>&nbsp;</td>
							<td align='right' bgcolor="<?php echo $Color;?>" valign='middle'><?php echo number_format($Fila2[cantidad],2,',','.');?>&nbsp;</td>
							<?php
							if($Cuenta==0)
							{
							?>
							<td align='right' bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>" valign='middle'><?php echo number_format($SkFinal,2,',','.');?>&nbsp;</td>
							<?php
							}
							?>
		  				</tr>
						<?php
						$Exist=$SkFinal;
						$Cuenta++;
					}
				$DiaUltimo=$i;
				}
				if($EntroPLanta=='N')
				{
				//CUANDO NO EXISTE EN PLANTA DE SELENIO PREGUNTO EN CARGA HORNO SI EXISTE EL DIA
				$sql = "select * from pmn_web.carga_horno_trof t1";
				$sql.= " where t1.fecha='".$Fecha."'";
				$sql.= " group by t1.fecha order by t1.fecha asc,t1.turno ";
				$result = mysqli_query($link, $sql);
				if($Fila = mysqli_fetch_array($result))
				{
					$FechaAux=explode('-',$Fecha);
					$AnoAux=$FechaAux[0];
					$MesAux=$FechaAux[1];
					$DiaAux=$FechaAux[2];
					
					$sql = "select t1.turno,t1.hornada from pmn_web.carga_horno_trof t1 left join pmn_web.deselenizacion t2 on t1.fecha=t2.fecha ";
					$sql.= " where t1.fecha='".$Fecha."' and cod_producto='36' and cod_subproducto='1'";
					$sql.= " group by t1.turno,t1.hornada";
					$result2 = mysqli_query($link, $sql);$Cont=0;
					while($Fila2 = mysqli_fetch_array($result2))
						$Cont=$Cont+1;
						
					$Color='';
					if($i%2)
						$Color="#CCCCCC";	
						
					$sql2 = "select * from proyecto_modernizacion.sub_clase where cod_clase=1 and cod_subclase=".$Fila[turno];
					$result2 = mysqli_query($link, $sql2);
					if ($row2=mysqli_fetch_array($result2))
						$TxtTurno = strtoupper($row2["nombre_subclase"]);
					$Sql3="select t1.prod_calcina,t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial from pmn_web.deselenizacion t1 ";								
					$Sql3.= " where t1.fecha='".$Fecha."' and t1.turno='".$Fila[turno]."'";
					$Sql3.= " group by t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial order by t1.fecha asc,t1.turno";	
					$result3 = mysqli_query($link, $Sql3);$Calcina=0;
					while($row3 = mysqli_fetch_array($result3))
						$Calcina=$Calcina+$row3[prod_calcina];
					$TurnoProd='--';	
					?>
					<tr >
					<?php	
					$sql = "select t1.turno,t1.hornada,t1.cantidad from pmn_web.carga_horno_trof t1 left join pmn_web.deselenizacion t2 on t1.fecha=t2.fecha ";
					$sql.= " where t1.fecha='".$Fecha."' and cod_producto='36' and cod_subproducto='1'";
					$sql.= " group by t1.turno,t1.hornada";
					$result2 = mysqli_query($link, $sql);$Vueltas='1';$Cuenta=0;
					while($Fila2 = mysqli_fetch_array($result2))
					{
						$TxtTurno2 = "--";
						if($Fila2[turno]!='')
						{
							$sql4 = "select * from proyecto_modernizacion.sub_clase where cod_clase=1 and cod_subclase=".$Fila2[turno];
							$result4 = mysqli_query($link, $sql4);
							if ($row4=mysqli_fetch_array($result4))
								$TxtTurno2 = strtoupper($row4["nombre_subclase"]);
						}							
						if($Vueltas=='1')
							$ExistIniF=$Exist;
						else
						{
							$ExistIniF=$Exist;	
							$ExistIniF=$ExistIniF;									
						}	
						?>
							<?php
							if($Cuenta==0)
							{
								$sql = "select t1.cantidad from pmn_web.carga_horno_trof t1 left join pmn_web.deselenizacion t2 on t1.fecha=t2.fecha and cod_producto='36' and cod_subproducto='1'";
								$sql.= " where t1.fecha='".$Fecha."' and cod_producto='36' and cod_subproducto='1'";
								$sql.= " group by t1.turno,t1.hornada order by t1.fecha asc,t1.turno ";
								//echo $sql."<br>"; 
								$result3 = mysqli_query($link, $sql);$ValorBeneficio=0;
								while($Fila3 = mysqli_fetch_array($result3))
									$ValorBeneficio=$ValorBeneficio+$Fila3[cantidad];
							$SkFinal=$ExistIniF+$Calcina-$ValorBeneficio;
							?>
							<td align='center' bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>"><?php echo $i?></td>
							<td align='center' bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>"><?php echo $TurnoProd?>&nbsp;</td>
							<td align='right' bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>"><?php echo number_format($ExistIniF,2,',','.');?>&nbsp;</td>
							<td width="11%" bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>" align="right"><?php echo number_format($Calcina,0,',','.');?>&nbsp;</td>
							<?php
							}
							?>
							<td align='center' bgcolor="<?php echo $Color;?>" valign='middle' ><?php echo $TxtTurno2;?>&nbsp;</td>
							<td align='left' bgcolor="<?php echo $Color;?>" valign='middle'><?php echo $Fila2["hornada"];?>&nbsp;</td>
							<td align='right' bgcolor="<?php echo $Color;?>" valign='middle'><?php echo number_format($Fila2[cantidad],2,',','.');?>&nbsp;</td>
							<?php
							if($Cuenta==0)
							{
							?>
							<td align='right' bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>" valign='middle'><?php echo number_format($SkFinal,2,',','.');?>&nbsp;</td>
							<?php
							}
							?>
		  				</tr>
						<?php
						$Exist=$SkFinal;
						$Cuenta++;
					}				
				}
				}				
				 $Vueltas++;
		  }	
	 }	
	  ?> 		  
    </table>      
    	
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
