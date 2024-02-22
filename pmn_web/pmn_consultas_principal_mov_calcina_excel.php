<?php
	include("../principal/conectar_pmn_web.php");	
	include("pmn_funciones.php");	
	
ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
if ( preg_match( '/MSIE/i', $userBrowser ) ) 
{
$filename = urlencode($filename);
}
$filename = iconv('UTF-8', 'gb2312', $filename);
$file_name = str_replace(".php", "", $file_name);
header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
header("content-disposition: attachment;filename={$file_name}");
header( "Cache-Control: public" );
header( "Pragma: public" );
header( "Content-type: text/csv" ) ;
header( "Content-Dis; filename={$file_name}" ) ;
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$Consulta23="select si_p from pmn_web.stock_pmn where mes='".$Mes."' and ano='".$Ano."' and cod_producto='36' and cod_subproducto='1'";
$Resp=mysqli_query($link, $Consulta23);
if($Fila=mysqli_fetch_array($Resp))
	$ExistP=$Fila[si_p];
?>
<table width="32%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr class="TituloCabeceraAzul">
    <td colspan='5' align="center">Movimiento de Calcina </td>
  </tr>	
  <tr class="TituloCabeceraAzul">
    <td width="41%" colspan="2" align="left">Mes - Ao</td>
    <td width="59%" colspan="5" align="left"><?php echo $Meses[$Mes-1]." - ".$Ano;?></td>
  </tr>
  <tr class="TituloCabeceraAzul">
    <td align="left" colspan="2">Existencia</td>
    <td align="left" colspan="5"><?php echo number_format($ExistP,2,',','.');?></td>
  </tr>	
</table>
<br />
<table width="100%" border="1" cellpadding="0" cellspacing="0">
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
	  $Buscar='S';
	  if($Buscar=='S')
	  {
	  	?>
			<tr>
			<td colspan="8" align="left" class="titulo_azul"><?php echo $Meses[$Mes-1]." - ".$Ano;?></td>
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
							$ExistIniF=$ExistP;
						else
						{
							$ExistIniF=$ExistP;	
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
							<td align='right' bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>"><?php echo number_format($ExistIniF,2,',','.');?></td>
							<td width="11%" bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>" align="right"><?php echo number_format($Calcina,0,',','.');?></td>
							<?php
							}
							?>
							<td align='center' bgcolor="<?php echo $Color;?>" valign='middle' ><?php echo $TxtTurno2;?>&nbsp;</td>
							<td align='left' bgcolor="<?php echo $Color;?>" valign='middle'><?php echo $Fila2["hornada"];?>&nbsp;</td>
							<td align='right' bgcolor="<?php echo $Color;?>" valign='middle'><?php echo number_format($Fila2[cantidad],2,',','.');?></td>
							<?php
							if($Cuenta==0)
							{
							?>
							<td align='right' bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>" valign='middle'><?php echo number_format($SkFinal,2,',','.');?></td>
							<?php
							}
							?>
		  				</tr>
						<?php
						$ExistP=$SkFinal;
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
							$ExistIniF=$ExistP;
						else
						{
							$ExistIniF=$ExistP;	
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
							<td align='right' bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>"><?php echo number_format($ExistIniF,2,',','.');?></td>
							<td width="11%" bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>" align="right"><?php echo number_format($Calcina,0,',','.');?></td>
							<?php
							}
							?>
							<td align='center' bgcolor="<?php echo $Color;?>" valign='middle' ><?php echo $TxtTurno2;?>&nbsp;</td>
							<td align='left' bgcolor="<?php echo $Color;?>" valign='middle'><?php echo $Fila2["hornada"];?>&nbsp;</td>
							<td align='right' bgcolor="<?php echo $Color;?>" valign='middle'><?php echo number_format($Fila2[cantidad],2,',','.');?></td>
							<?php
							if($Cuenta==0)
							{
							?>
							<td align='right' bgcolor="<?php echo $Color;?>" rowspan="<?php echo $Cont;?>" valign='middle'><?php echo number_format($SkFinal,2,',','.');?></td>
							<?php
							}
							?>
		  				</tr>
						<?php
						$ExistP=$SkFinal;
						$Cuenta++;
					}				
				}
				}				
				 $Vueltas++;
		  }	
	 }	
	  ?> 		  
    </table>
