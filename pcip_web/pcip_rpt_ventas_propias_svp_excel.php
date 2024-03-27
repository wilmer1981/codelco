<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");		
			
?>
<html>
<head>
<title>Reporte Ventas Propias Svp Excel</title>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<form name="frmPrincipal" action="" method="post">
<table width="100%" border="1" cellpadding="0" cellspacing="0" >
          <tr class="TituloTablaVerde">
            <td width="5%" align="center"><span class="Estilo9">Orden</span></td>
            <td width="3%"align="center"><span class="Estilo9">C.Sap</span></td>
            <td width="20%" align="center"><span class="Estilo9">Descripci&oacute;n</span></td>
            <td width="3%"align="center"><span class="Estilo9">Unid</span></td>
            <?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
		       	echo "<td width='6%' align='center'><span class='Estilo9'>".substr($Meses[$i-1],0,3)."</span></td>";
			}
			?>
            <td width="20%" align="center"><span class="Estilo9">Total</span></td>
          </tr>
          <?
		  	$Buscar='S';
		  	if($Buscar=='S')
			{	
				$Totales=array();
			    //$Consulta = "select distinct t1.OPorden from pcip_svp_ordenesproduccion t1 inner join pcip_svp_valorizacproduccion t2 on t1.OPorden=t2.VPorden where t2.VPa�o = '".$Ano."' AND t2.VPmes between '".$Mes."' and '".$MesFin."' and t2.VPtm in ('15','16','21','22' )";
				//if($CmbOrdenProd!='-1')
				//	$Consulta.= " and t1.OPorden='".$CmbOrdenProd."'";
				//$Consulta.= " order by t1.OPorden ";
				$Consulta = "select distinct t3.cod_sap,t3.nom_sap,MAorden as OPorden from pcip_svp_relmateriales t1 inner join pcip_svp_materiales t2 on t1.RMmaterial=t2.MAcodigo inner join pcip_svp_productos_sap t3 on t1.RMmaterialequivalente=t3.cod_sap ";
				$Consulta.= "where t2.MAorden<>''";
				if($CmbOrdenProd!='-1')
					$Consulta.= " and t2.MAorden='".$CmbOrdenProd."' ";
				$Consulta.= "order by t3.cod_sap,MAorden"; 				
				//echo $Consulta;			
				$Resp=mysqli_query($link, $Consulta);
				while ($Fila=mysql_fetch_array($Resp))
				{
					$Consulta = "select t1.RMmaterialequivalente as cod_sap,t3.OPorden,t3.OPdescripcion,t5.valor_subclase1 as vtmp from pcip_svp_relmateriales t1 ";
					$Consulta.= "left join pcip_svp_materiales t2 on t1.RMmaterial=t2.MAcodigo left join pcip_svp_ordenesproduccion t3 on t2.MAorden=t3.OPorden ";
					$Consulta.= "left join pcip_svp_productos_sap t4 on t1.RMmaterialequivalente=t4.cod_sap left join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='31043' and t5.cod_subclase=t1.tipo_movimiento_svp ";
					$Consulta.= "where t1.RMmaterialequivalente<>'' ";
					if($CmbProd!='-1')
						$Consulta.= "and t1.RMmaterialequivalente='".$CmbProd."'";
					$Consulta.= " and t3.OPorden='".$Fila[OPorden]."' order by t1.RMmaterialequivalente,t3.OPorden";
					$RespProd=mysqli_query($link, $Consulta);
					//echo $Consulta."<br>";
					if($FilaProd=mysql_fetch_array($RespProd))
					{					
						$Total=0;$Vtmp='';
						$DatosVtpm=explode(',',$FilaProd[vtmp]);
						while(list($c,$v)=each($DatosVtpm))
						{
							$Vtmp=$Vtmp."'".$v."',";
						}
						if($Vtmp!='')
						{
							$Vtmp=substr($Vtmp,0,strlen($Vtmp)-1);
							$Vtmp="in (".$Vtmp.")";
						}
						else
							$Vtmp="in('nada')";
						echo "<tr>";
						echo "<td align='center'><span class='Estilo9'>".$Fila[OPorden]."</span></td>";
						echo "<td align='right'><span class='Estilo9'>".$FilaProd[cod_sap]."&nbsp;</span></td>";
						echo "<td align='left'><span class='Estilo9'>".$FilaProd[OPdescripcion]."</span></td>";
						echo "<td align='center'><span class='Estilo9'>".$Unidad."</span></td>";
						for($i=$Mes;$i<=$MesFin;$i++)
						{
							$Consulta="SELECT sum(VPcantidad) as VPcantidad,sum(VPValor) as VPValor FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND VPorden = '".$Fila[OPorden]."' "; 
							$Consulta.=" AND VPtm ".$Vtmp;	
							$Resp2=mysqli_query($link, $Consulta);
							//echo $Consulta."<br>";
							if($Fila2=mysql_fetch_array($Resp2))
							{
								if($CmbTipoInforme=='1')
								{
									if(!is_null($Fila2[VPValor]))
									{
										echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Fila2[VPValor],3,',','.')."</span></td>";
										$Total=$Total+$Fila2[VPValor];
										$Totales[$i]=$Totales[$i]+$Fila2[VPValor];
									}
									else
										echo "<td width='6%' align='center'>&nbsp;</td>";
								}
								if($CmbTipoInforme=='2')
								{
									if(!is_null($Fila2[VPcantidad]))
									{
										echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Fila2[VPcantidad],3,',','.')."</span></td>";
										$Total=$Total+$Fila2[VPcantidad];
										$Totales[$i]=$Totales[$i]+$Fila2[VPcantidad];
									}
									else
										echo "<td width='6%' align='center'>&nbsp;</td>";
								}
							}
							else	
								echo "<td width='6%' align='center'>&nbsp;</td>";
						}
						echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
					}
					echo "</tr>";
				}
				$Total=0;
				echo "<tr class='corteamarillo'>";
				echo "<td colspan='5' align='right'><span class='Estilo9'>Totales</span></td>";
				reset($Totales);
				for($i=$Mes;$i<=$MesFin;$i++)
				{
					echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Totales[$i],3,',','.')."</span></td>";
					$Total=$Total+$Totales[$i];
				}
				echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
				echo "</tr>";
			}
		  ?>
      </table>
</form>
</body>
</html>