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

$Consulta23="select si_p,si_c from pmn_web.stock_pmn where mes='".$Mes."' and ano='".$Ano."' and cod_producto='19' and cod_subproducto='17'";
$Resp=mysqli_query($link, $Consulta23);$AInicial=0;$PInicial=0;
if($Fila=mysqli_fetch_array($Resp))
{
	$AInicial=$Fila[si_c];
	$PInicial=$Fila[si_p];
}

?>
<form name="PrinElectPLata" method="post">
<table width="32%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr class="TituloCabeceraAzul">
    <td colspan='12' align="center">Traspaso de restos de anodos </td>
  </tr>	
  <tr class="TituloCabeceraAzul">
    <td width="41%" colspan="4" align="left">Mes - Ao</td>
    <td width="59%" colspan="8" align="left"><?php echo $Meses[$Mes-1]." - ".$Ano;?>&nbsp;</td>
  </tr>
  <tr class="TituloCabeceraAzul">
    <td width="41%" colspan="4" align="left">Cantidad Inicial</td>
    <td width="59%" colspan="8" align="left"><?php echo number_format($AInicial,2,",","");?></td>
  </tr>
  <tr class="TituloCabeceraAzul">
    <td width="41%" colspan="4" align="left">Peso Inicial</td>
    <td width="59%" colspan="8" align="left"><?php echo number_format($PInicial,2,",","");?></td>
  </tr>
</table>
 <br />
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
   	  $Buscar='S'	;
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
				//echo $Consulta;
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
     <td align="right" class="TituloCabeceraOz"><?php echo number_format($SumaPesos,2,",","");?></td>
     <td colspan="3" align="right">&nbsp;</td>
     <td  align="right" class="TituloCabeceraOz"><?php echo number_format($TotPesoBene,2,",","");?></td>
     <td align="right">&nbsp;</td>
   </tr>
   <?php	
	  }	
	  ?>
 </table>
 <br />
<p>&nbsp;</p>
</form>
