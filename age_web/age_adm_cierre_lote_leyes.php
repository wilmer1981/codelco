<table width="740"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td>Leyes</td>
    <td>Unid</td>
    <td>Valor</td>
	<td>Retalla</td>
	<td>Inc.Retalla</td>
	<td>Ley Final</td>
	<td>Fino</td>
	<td>Min</td>
	<td>Max</td>
	<td>Historica</td>
	<td>M.Paral</td>
	<td>Retalla</td>
	<td>Inc.Ret</td>
	<td>Ley Final</td>
	<td>Control</td>
  </tr>
<?php
    //echo "Petalo:".$Petalo;
	$CmbPlantLimControl=3;
	$Ano=date('Y');
	$DatosLote= array();
	$ArrLeyes=array();
	$DatosLote["lote"]=$TxtLote;
	//LeyesLote($DatosLote,$ArrLeyes,"N","S","N","","","",$link);
	$ArrLeyes        = LeyesLote($DatosLote,$ArrLeyes,"N","S","N","","","",$Petalo,$link);  
	$DatosLote       = LeyesLote($DatosLote,$ArrLeyes,"N","S","N","","","","",$link);
	$PesoLote        = isset($DatosLote["peso_seco"])?$DatosLote["peso_seco"]:0;
	$tipo_remuestreo = isset($DatosLote["tipo_remuestreo"])?$DatosLote["tipo_remuestreo"]:"";
	$fecha_recepcion = isset($DatosLote["fecha_recepcion"])?$DatosLote["fecha_recepcion"]:"0000-00-00";
	reset($ArrLeyes);
	$Cont=0;
	foreach($ArrLeyes as $c=>$v)
	{	
       //echo "<br>v:".$v[6]."---";
		if($c!='01'&&$v[1]!='')
		{
			//if($DatosLote["tipo_remuestreo"]=='A')
			if($tipo_remuestreo=='A')
				$ValorLey=$v[60];
			else
				$ValorLey=$v[2];
			$Cont++;
			echo "<tr >\n";
			echo "<td align='center'>".$v[1]."</td>\n";
			echo "<td align='center'>".$v[4]."</td>\n";
			/* por ver $ValorPrueba = $ValorLey * 1000;
			echo "valores_1".$ValorPrueba."--".$ValorLey;
			$ValorLey = number_format($ValorPrueba,0,',','.');
			$ValorLey = $ValorLey / 1000;
			echo "valores".$ValorLey;*/
			$v12 = isset($v[12])?$v[12]:0;
			$v22 = isset($v[22])?$v[22]:0;
			echo "<td align='right'>".number_format($ValorLey,3,',','.')."</td>\n";		
			echo "<td align='right'>".number_format((float)$v12,3,',','.')."&nbsp;</td>\n";
			echo "<td align='right'>".number_format((float)$v22,4,',','.')."&nbsp;</td>\n";
			//echo "valores".$ValorLey."-".number_format($ValorLey,2,',','.');  // aca juan 11-06-2009
			$Ley="";$Fino="";$Color="";
			if ($DatosLote["peso_humedo"]>0 && $ArrLeyes[$v[0]][2]>0 && $ArrLeyes[$v[0]][5]>0)
			{
				$Fino = ($DatosLote["peso_humedo"]*($ValorLey+$v22))/$v[5];
				$Ley = ($Fino/$DatosLote["peso_humedo"])*$v[34];
			}
			$EntreMin="";$EntreMax=""; $ArrLimites=array();	
			$BajoMin ="";$SobreMax="";
			$Color = AsignaColor("", $v[0], $Ley, $ArrLimites, $Color, $BajoMin, $EntreMin, $EntreMax, $SobreMax);
			$ArrLimitesmin = isset($ArrLimites[$v[0]]["min"])?$ArrLimites[$v[0]]["min"]:"";
			$ArrLimitesmax = isset($ArrLimites[$v[0]]["max"])?$ArrLimites[$v[0]]["max"]:"";
			$ArrLimitesmed = isset($ArrLimites[$v[0]]["med"])?$ArrLimites[$v[0]]["med"]:"";
			echo "<td align='right' bgcolor='".$Color."' onMouseOver=\"JavaScript:muestra('".$Cont."');\" onMouseOut=\"JavaScript:oculta('".$Cont."');\">";
			echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:140px'>\n";
			echo "<table width='140' border='1' cellpadding='2' cellspacing='0' class='TablaInterior'>";
			echo "<tr class='ColorTabla01'><td colspan=\"3\" align='center'><strong>".$v[1]."</strong></td></tr>";
			echo "<tr align='center'><td width='70'>Min.</td><td width='70'>Max.</td></tr>";
			echo "<tr align='center' class='Detalle01'><td>".$ArrLimitesmin."</td><td>".$ArrLimitesmax."</td></tr>";
			echo "<tr align='center'><td colspan='2'>Prom.Mes</td></tr>";
			echo "<tr align='center' class='Detalle01'><td colspan='2'>".$ArrLimitesmed."</td></tr>";
			echo "</table></div>".number_format($ValorLey+$v22,4,',','.')."&nbsp;</td>\n";
			$Cont++;
			//echo "<td align='right' bgcolor='".$Color."'>".number_format($v[2]+$v[22],3,',','.')."&nbsp;</td>\n";
			if($v[5]>0)				
				echo "<td align='right'>".number_format(($ValorLey*$PesoLote)/$v[5],0,',','.')."</td>\n";
			else
				echo "<td align='right'>".number_format(0,0,',','.')."</td>\n";
			if ($v[0]<=60 && $v[0]!="")
			{
				$FechaBus=date('Y-m-d',mktime(0,0,0,(intval(substr($fecha_recepcion,5,2))-1),1,substr($fecha_recepcion,0,4)));
				//echo $FechaBus."<br>";
				$FechaAnoMes=substr($FechaBus,0,4).substr($FechaBus,5,2);
				$Consulta="select min(c_".$v[0].") as ley_min,max(c_".$v[0].") as ley_max ";
				$Consulta.="from age_web.historico where (concat(ano,lpad(mes,2,'0'))>= '200401' and concat(ano,lpad(mes,2,'0'))<= '".$FechaAnoMes."') and cod_producto='".$DatosLote["cod_producto"]."' and ";
				//$Consulta.="from age_web.historico where ano = '".date('Y')."' and mes < '".date("n")."' and cod_producto='".$DatosLote["cod_producto"]."' and ";
				$Consulta.="cod_subproducto='".$DatosLote["cod_subproducto"]."' and  rut_proveedor='".$DatosLote["rut_proveedor"]."' and c_".$v[0]." > 0 ";
				$Consulta.="group by cod_producto,cod_subproducto,rut_proveedor"; 
				//echo $Consulta."<br>";
				$Respuesta=mysqli_query($link, $Consulta);
				if($FilaLeyes=mysqli_fetch_array($Respuesta))
				{	
					echo "<td align='right'>".number_format($FilaLeyes["ley_min"],3,',','.')."</td>\n";
					echo "<td align='right'>".number_format($FilaLeyes["ley_max"],3,',','.')."</td>\n";
				}	
				else
				{	
					echo "<td align='right'>&nbsp;</td>\n";
					echo "<td align='right'>&nbsp;</td>\n";
				}	
			}
			else
			{
				echo "<td align='right'>&nbsp;</td>\n";
				echo "<td align='right'>&nbsp;</td>\n";
			}
			//echo "<td align='right'>&nbsp;</td>\n";
			//echo "<td align='right'>&nbsp;</td>\n";
			if ($v[0]<=60 && $v[0]!="")
			{
				$FechaBus=date('Y-m-d',mktime(0,0,0,(intval(substr($fecha_recepcion,5,2))-1),1,substr($fecha_recepcion,0,4)));
				//echo $FechaBus."<br>";
				$Consulta="select round(sum(peso_seco * round(c_".$v[0].",3)) / sum(peso_seco),3) as fino ";
				$FechaAnoMes=substr($FechaBus,0,4).substr($FechaBus,5,2);
				$Consulta.="from age_web.historico where (concat(ano,lpad(mes,2,'0'))>= '200401' and concat(ano,lpad(mes,2,'0'))<= '".$FechaAnoMes."') and cod_producto='".$DatosLote["cod_producto"]."' and ";
				//$Consulta.="from age_web.historico where ano = '".date('Y')."' and mes < '".date("n")."' and cod_producto='".$DatosLote["cod_producto"]."' and ";
				$Consulta.= "cod_subproducto='".$DatosLote["cod_subproducto"]."' and  rut_proveedor='".$DatosLote["rut_proveedor"]."' ";
				$Consulta.= " and c_".$v[0]."<>'0'";
				$Consulta.= "group by cod_producto,cod_subproducto,rut_proveedor"; 
				//echo $Consulta."<br>";
				$Respuesta=mysqli_query($link, $Consulta);
				if($FilaLeyes=mysqli_fetch_array($Respuesta))
					echo "<td align='right'><a href=\"JavaScript:DetalleHistorica('".$DatosLote["cod_subproducto"]."','".$DatosLote["rut_proveedor"]."','1990','".substr($FechaBus,0,4)."','".$v[0]."','".substr($FechaBus,5,2)."')\">".number_format($FilaLeyes["fino"],3,',','.')."</a></td>\n";
				else
					echo "<td align='right'>&nbsp;</td>\n";
			}
			else
			{
				echo "<td align='right'>&nbsp;</td>\n";
			}
			$ResultControl='';$ValorControl='';$Seguimiento='';
			$Consulta="select * from age_web.leyes_por_lote where lote='".$DatosLote["muestra_paralela"]."'  and cod_leyes='".$v[0]."'";
			//echo "veo".$Consulta."</br>";
			$Respuesta=mysqli_query($link, $Consulta);
			$ValorParalela=0;
			if($FilaLeyes=mysqli_fetch_array($Respuesta))
			{
				if ($FilaLeyes["recargo"]=="0")
					$LeyParalela=$FilaLeyes["valor"];
				else
					$LeyParalela=0;
				$IncRetalla=0;
				//BUSCA DATOS MUESTRA PARALELA
				$Consulta = "select * from cal_web.solicitud_analisis ";
				$Consulta.= " where id_muestra='".$DatosLote["muestra_paralela"]."' ";
				$Consulta.= " and year(fecha_muestra)='".substr($fecha_recepcion,0,4)."'";
				$Consulta.= " and tipo=4 and recargo='R' and estado_actual not in('7','16') ";
				//echo "ver".$Consulta."</br>";
				$RespAux=mysqli_query($link, $Consulta);
				if($FilaAux=mysqli_fetch_array($RespAux))
				{
					$PesoMuestraR=$FilaAux["peso_muestra"];
					$PesoRetallaR=$FilaAux["peso_retalla"];
				}
				$Consulta="select * from age_web.leyes_por_lote where lote='".$DatosLote["muestra_paralela"]."' and recargo='0' and cod_leyes='".$v[0]."' ";
				//echo $Consulta."<br>";
				$RespAux=mysqli_query($link, $Consulta);
				if($FilaAux=mysqli_fetch_array($RespAux))
					$LeyParRetalla=$FilaAux["valor"];
				else
					$LeyParRetalla=0;
				$IncRetalla=0;	
				$Consulta = "select distinct t1.cod_leyes, t1.valor, t2.abreviatura as nom_unidad, t2.conversion";
				$Consulta.= " from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
				$Consulta.= " t1.cod_unidad=t2.cod_unidad ";
				$Consulta.= " where t1.lote='".$DatosLote["muestra_paralela"]."' ";
				$Consulta.= " and ano='".substr($fecha_recepcion,0,4)."'";
				$Consulta.= " and t1.recargo='R'";	
				$Consulta.= " and t1.cod_leyes='".$v[0]."'";
				$Consulta.= " order by t1.cod_leyes";
				$RespAux = mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				if ($FilaAux = mysqli_fetch_array($RespAux))
				{									
					$LeyRetallaParalela=$FilaAux["valor"];
					//CALCULA LA LEY INCLUYENDO INCIDENCIA DE LA RETALLA
					if ($LeyParRetalla>0 && $PesoRetalla>0 && $PesoMuestraR>0)
					{
						$IncRetalla = ($FilaAux["valor"] - $LeyParRetalla) * ($PesoRetallaR/$PesoMuestraR);  //VALOR					
						//$IncRetalla = ((($FilaAux["valor"] - $LeyParRetalla)) / $PesoMuestra)*$PesoRetalla;  //VALOR
						//echo "(".$FilaAux["valor"]." - ".$LeyParRetalla.") * (".$PesoRetalla."/".$PesoMuestra.")<br>";
					}	
					else
						$IncRetalla = 0;  //VALOR				
				}
				//$ValorParalela=$LeyParalela+$IncRetalla;
				$ValorParalela=$LeyParalela;
				//echo $ValorParalela."=".$FilaLeyes["valor"]."+".$IncRetalla."<br>";
				echo "<td align='right'>".number_format($ValorParalela,3,',','.')."</td>\n";
				echo "<td align='right'>".number_format($LeyRetallaParalela,3,',','.')."</td>\n";
				echo "<td align='right'>".number_format($IncRetalla,3,',','.')."</td>\n";
				echo "<td align='right'>".number_format($LeyParalela+$IncRetalla,3,',','.')."&nbsp;</td>\n";
				$Consulta="select t1.limite_particion,t2.abreviatura,t1.descripcion from age_web.limites_particion t1 inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad =t2.cod_unidad ";
				$Consulta.="where proceso='REMUESTREO' and cod_plantilla='$CmbPlantilla' and cod_ley='".$v[0]."' and ".($v[2]+$v[22])." between rango1 and rango2";
				//echo $Consulta."<br>";
				$Respuesta=mysqli_query($link, $Consulta);
				if($Fila=mysqli_fetch_array($Respuesta))
				{
					$LimControl=$Fila["limite_particion"]*1;
					$Seguimiento="M.PARALELA: ".$Fila["descripcion"]."<BR>";
					$Seguimiento.="LIMITE CONTROL: ".$LimControl."&nbsp;(".$Fila["abreviatura"].")<br>";
					//echo "LIMITE CONTROL:".$LimControl."<br>";
					//$Dif=abs(($v[2]+$v[22])-$ValorParalela)*1;
					$Dif=abs($v[2]-$ValorParalela)*1;
					$Seguimiento.="DIF.LEY PQTE1 Y M.PAREL :".number_format($Dif,3,',','.')."<br>";
					//echo "DIF:".$Dif."<br>";
					if(doubleval($Dif+1-1) > doubleval($LimControl+1-1))
					{
						$ResultControl="<font color='#FF0000'>FR</font>";
						$Seguimiento.="MUESTRA FUERA DE RANGO<BR>";
					}	
					else
					{
						$ResultControl="<font color='BLUE'>OK</font>";
						$Seguimiento.="MUESTRA OK";
					}	
				}
				else
				{
					$ResultControl="<font color='#FF0000'>FR</font>";
					$Seguimiento.="MUESTRA FUERA DE RANGO<BR>";
				}
			}	
			else
			{
				echo "<td align='right'>&nbsp;</td>\n";
				echo "<td align='right'>&nbsp;</td>\n";
				echo "<td align='right'>&nbsp;</td>\n";
			}	
			if($Seguimiento=='')
				echo "<td align='center'>".$ResultControl."&nbsp;</td>\n";
			else
			{	
				echo "<td align='center' onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");' class='Detalle01'>";
				echo "<div align='left' id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:250px'>\n";
				echo "<font face='courier' color='#000000' size=1><b>".$Seguimiento."<br></b></div>".$ResultControl."</td>";
			}	
			echo "</tr>\n";
		}	
	}
function AsignaColor($Tipo, $CodLey, $Valor, $Limites, $BgColor, $BajoMin, $EntreMin, $EntreMax, $SobreMax)
{   
	$Limitesusada = isset($Limites[$CodLey]["usada"])?$Limites[$CodLey]["usada"]:"";
	if ($Limitesusada=="S")
	{
		switch ($Tipo)
		{
			case "": //LAS DEL MES				
				if ($Valor<$Limites[$CodLey]["min"])
				{
					$BgColor=$BajoMin;
				}				
				else
				{
					if ($Valor>$Limites[$CodLey]["max"] && $Limites[$CodLey]["max"]!=0)
					{
						$BgColor=$SobreMax;
					}
				}				
				break;
			case "PROM": //EL PROMEDIO DEL MES
				if ($Limites[$CodLey]["med"]!=0)
				{
					if ($Valor<$Limites[$CodLey]["med"])
					{
						$BgColor=$BajoMin;
					}				
					else
					{
						if ($Valor>$Limites[$CodLey]["med"])
						{
							$BgColor=$SobreMax;
						}
					}	
				}
				break;
		}	
	}//FIN USADA
	
	return $BgColor;
}
	
?>
  <tr class="ColorTabla02">
    <td colspan="16">&nbsp;</td>
  </tr>
</table>
