<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
?>
<html>
<head>
<title>Reporte Cuadro Diario Ventas Excel</title>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
    <tr>
      <td width="20%"  align="center" >Producto/Mes<br>
          <? echo $Ano;?></td>
      <?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
		  	?>
      <td width="7%" align="center" ><? echo $Meses[$i-1]?></td>
      <?	
			}
		  ?>
      <td width="6%" align="center">Acum</td>
    </tr>
    <?
			?>
    <tr>
      <td colspan="14">1. Cobre</td>
    </tr>
    <?
			$Buscar='S';			
		  if($Buscar=='S')
		  {			    
			$Consulta ="select nombre_subclase  as nom_grupo,cod_subclase as cod_grupo from proyecto_modernizacion.sub_clase";
			$Consulta.=" where cod_clase='31014' and valor_subclase1='C'";
			$Consulta.= " group by cod_grupo";	
			//echo $Consulta; 	
			$Resp=mysql_query($Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				$NomGrupo=$Fila[nom_grupo];
				$CodGrupo=$Fila["cod_grupo"];
					?>
    <tr>
      <td rowspan="1" align="left"><? echo $NomGrupo;?></td>
      <?
					$Acum=0;$ContMes=0;	
					for($i=$Mes;$i<=$MesFin;$i++)
					{						
						$Consulta =" select sum(kilos_finos) as KiloFino,sum(valor_cif_neto) as ValorNeto from pcip_cdv_productos_ventas_por_grupo t1 inner join pcip_cdv_cuadro_diario_ventas t2 on t1.cod_producto=t2.cod_producto ";
						$Consulta.=" where t1.cod_grupo='".$CodGrupo."' and t2.ano='".$Ano."' and mes='".$i."' and ajuste='N'";
						$Consulta.=" group by t1.cod_grupo ";
						//if($CodGrupo=='1'&&$i==1)
						//	echo $Consulta."<br>";
						$Resp2=mysql_query($Consulta);
						if($Fila2=mysql_fetch_array($Resp2))
						{
							if($Fila2[KiloFino]<>0)
							{
								$ContMes++;
								switch($CodGrupo)
								{
									case "1":
									case "2":
									case "3":
									//if($CodGrupo=='1'&&$i==1)
									//	 echo 	$Fila2[ValorNeto]."   ".$Fila2[KiloFino]."<br>";
									$Valor=1000*($Fila2[ValorNeto]/$Fila2[KiloFino]);
									break;
									default:
										$Valor=$Fila2[ValorNeto]/$Fila2[KiloFino];
									break;
								}		
							}
							else
								$Valor=0;
						}
						else
							$Valor=0;
						echo "<td align='right'>".number_format($Valor,2,',','.')."</td>";
						$Acum=$Acum+$Valor;	
					}
					if($ContMes>0)
						$Acum=$Acum/$ContMes;					    
					echo "<td align='right'>".number_format($Acum,2,',','.')."</td>";							    
					?>
    </tr>
    <?
				}
				    ?>
    <tr>
      <td colspan="14">3. SubProductos</td>
    </tr>
    <?
							$Consulta ="select nombre_subclase  as nom_grupo,cod_subclase as cod_grupo from proyecto_modernizacion.sub_clase";
							$Consulta.=" where cod_clase='31014' and valor_subclase1='S'";
							$Consulta.= " group by cod_grupo";	
							//echo $Consulta; 	
							$Resp=mysql_query($Consulta);
							while($Fila=mysql_fetch_array($Resp))
							{
								$NomGrupo=$Fila[nom_grupo];
								$CodGrupo=$Fila["cod_grupo"];
								?>
    <tr>
      <td rowspan="1" align="left"><? echo $NomGrupo;?></td>
      <?	
								$Acum2=0;$ContMes=0;	
								for($i=$Mes;$i<=$MesFin;$i++)
								{
									
									$Consulta =" select sum(kilos_finos) as KiloFino,sum(valor_cif_neto) as ValorNeto from pcip_cdv_productos_ventas_por_grupo t1 inner join pcip_cdv_cuadro_diario_ventas t2 on t1.cod_producto=t2.cod_producto ";
									$Consulta.=" where t1.cod_grupo='".$CodGrupo."' and t2.ano='".$Ano."' and mes='".$i."' and ajuste='N'";
									$Consulta.=" group by t1.cod_grupo ";
									$Resp2=mysql_query($Consulta);
									if($Fila2=mysql_fetch_array($Resp2))
									{
										if($Fila2[KiloFino]>0)
										{
											$ContMes++;
											switch($CodGrupo)
											{
												case "1":
												case "11":
												case "13":
													$Valor=1000*($Fila2[ValorNeto]/$Fila2[KiloFino]);
												break;
												case "14":
												case "15":
													$Valor=($Fila2[ValorNeto]/$Fila2[KiloFino])*(1/35.2739619);
												break;
												default:
													$Valor=$Fila2[ValorNeto]/$Fila2[KiloFino];
												break;
											}		
										}
										else
											$Valor=0;
									}
									else
										$Valor=0;
									echo "<td align='right'>".number_format($Valor,2,',','.')."</td>";	
									$Acum2=$Acum2+$Valor;
								}	
								if($ContMes>0)
									$Acum2=$Acum2/$ContMes;					    
								 
								 echo "<td align='right'>".number_format($Acum2,2,',','.')."</td>";							    
								?>
    </tr>
    <?
							}
				
			 }
			?>
  </table>
</form>
<? 
    echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Variaciones Inventario (s) Eliminado(s) Correctamente');";
	echo "</script>";
?>	
</body>
</html>