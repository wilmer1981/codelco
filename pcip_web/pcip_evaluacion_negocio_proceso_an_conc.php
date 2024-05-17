<? include("../principal/conectar_pcip_web.php");
$CodTipoAnalisis='1';
echo "<input type='hidden' name='CodTipoAnalisis' value='".$CodTipoAnalisis."'>";
?>

<table width="100%" border="1" cellpadding="3" cellspacing="0" >
  <tr class='formulario2'>
   <td align="center">
   <?
	$Consulta="select corr,tipo_origen,analisis,tms,porc_hum from pcip_eva_negocios where corr='".$Cod."'";
	$Resp=mysqli_query($link, $Consulta);
	$Fila=mysql_fetch_array($Resp);
	$TMH=$Fila[porc_hum];
	$Tms=$Fila[tms];
	$Origen=$Fila[tipo_origen];
	$Datos=explode('||',$Fila[analisis]);
	while(list($c,$v)=each($Datos))
	{
		if($v!='')
		{
			$Datos2=explode('~',$v);
			$TipoAnalisis=$Datos2[0];
			//echo $TipoAnalisis."<br>";
			$Div=$Datos2[1];
			if(($Origen==1&&$TipoAnalisis!=2))//SI ORIGEN ES PROPIO Y ANALISIS ES DISTINTO DE PROCESAMIENTO VENTANAS
				Analisis($Cod,$Origen,$TipoAnalisis,$Div,$Tms); 
			if(($Origen==2&&$TipoAnalisis!=1))//SI ORIGEN ES COMPRA Y ANALISIS ES DISTINTO DE COMPRA
				Analisis($Cod,$Origen,$TipoAnalisis,$Div,$Tms); 
		}	
	}
   ?>		
   </td>
  </tr>
</table>
<?
function Analisis($Cod,$Origen,$TipoAnalisis,$Div,$Tms) 
{
if($Origen==2)
{
	$NomOrigen='COMPRA';
	$TipoAnalisisAux=1;
}
else
{
	$NomOrigen='PROCESAMIENTO PROPIO';
	$TipoAnalisisAux=2;
}
if($Div!='')	
{
	$NomAnalisis=strtoupper(DatosSubClase('31034',$TipoAnalisis));
	$DivAnalisis=strtoupper(DatosSubClase('31036',$Div));
	$DatosAnalisis=$NomAnalisis." (".$DivAnalisis.")";
	$TipoAnalisis=$TipoAnalisis.$Div;
}
else
	$DatosAnalisis=strtoupper(DatosSubClase('31034',$TipoAnalisis));	
echo "COD ANALISIS: ".$TipoAnalisis."<BR>";
//CONSULTA PARA DETERMINAR SI SE MUESTRAN LOS CALCULOS PARA UN PRECIO O 2
$CantPrecio=1;
$Consulta="select ifnull(sum(valor2),0) as valor2 from pcip_eva_negocios_precios ";
$Consulta.="where corr='".$Cod."' and cod_tipo_analisis='".$TipoAnalisis."' group by corr,cod_tipo_analisis";
//echo $Consulta;
$RespValor=mysqli_query($link, $Consulta);
$FilaValor=mysql_fetch_array($RespValor);
if($FilaValor["valor2"]>0)
	$CantPrecio=2;
for($i=1;$i<=$CantPrecio;$i++)
{
?>
<table width="70%" border="1" cellpadding="0" cellspacing="0" >
  <tr><td align="center" bgcolor="#CCCCCC"><h3>ANALISIS&nbsp;<? echo $NomOrigen." - ".$DatosAnalisis?></h3></td></tr>
  <tr>
   <td align="center">   
		<table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
		   <tr>
			 <td class="TituloCabecera">Finos Iniciales</td>
			 <td class="TituloCabecera">&nbsp;</td>
			 <!--<td align="center" class="TituloCabecera"><? //echo $NomOrigen;?></td>
			 <td align="center" class="TituloCabecera"><? //echo $DatosAnalisis;?></td>-->
			 <td align="center" class="TituloCabecera">Valor</td>
			 <td align="center" class="TituloCabecera">&nbsp;</td>
			 <td align="center" class="TituloCabecera">Leyes</td>
			 <td align="center" class="TituloCabecera">&nbsp;</td>
		   </tr>
		   <? 
				//CALCULO PARA FINOS INICIALES
				$ConsultaInicial="select t1.corr,t1.cod_ley,t1.cod_unidad,t2.nombre_subclase as nom_ley,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_material t1";
				$ConsultaInicial.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_ley=t2.cod_subclase";
				$ConsultaInicial.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase";
				$ConsultaInicial.=" where corr='".$Cod."' and cod_ley not in ('0') group by cod_ley";
				$RespInicial=mysql_query($ConsultaInicial);
				//echo "Consulta Inicial:   ".$ConsultaInicial."<br>";
				while($FilaInicial=mysql_fetch_array($RespInicial))
				{
					if($FilaInicial["cod_unidad"]=='9'||$FilaInicial["cod_unidad"]=='10'||$FilaInicial["cod_unidad"]=='22')//Leyes Ingresadas en % y en GRS/TON			
					{
						if($FilaInicial[cod_ley]=='1')
						{
							if($FilaInicial["cod_unidad"]=='9')
								$NomUni='TMS';
						}
						else
						{
							if($FilaInicial["cod_unidad"]=='9'||$FilaInicial["cod_unidad"]=='10'||$FilaInicial["cod_unidad"]=='22')
								$NomUni='KG';
						}
						$ValorLeyes=CaracteristicasMaterialLeyes($Cod,$FilaInicial[cod_ley],$TipoAnalisis,$Tms,$FilaInicial["cod_unidad"]);//Solo Suma de leyes
						$ValoresLeyes=$ValorLeyes;//Mostrar suma de leyes en pantalla
						$Valor_Iniciales=CaracteristicasMaterialLeyesIniciales($Cod,$FilaInicial[cod_ley],$TipoAnalisis,$Tms,$FilaInicial["cod_unidad"]);//Calculo para Fnos Iniciales						
						$Valor_Inicial=$Valor_Iniciales;//Mostrar calculo de finos iniciales en pantalla
					}
					else
					{	
						if($FilaInicial[cod_ley]=='1')
						{
							$NomUni=$FilaInicial[nom_unidad];
							if($FilaInicial["cod_unidad"]=='11'||$FilaInicial["cod_unidad"]=='14'||$FilaInicial["cod_unidad"]=='13')
								$FilaInicial[nom_unidad]='%';
						}				
						else
						{	
							$NomUni=$FilaInicial[nom_unidad];						
							if($FilaInicial["cod_unidad"]=='11')
								$FilaInicial[nom_unidad]='GRS/TON';
							if($FilaInicial["cod_unidad"]=='14')	
								$FilaInicial[nom_unidad]='KG/TON';
						}	
						$ValoresIniciales=CaracteristicasMaterialInicial($Cod,$FilaInicial[cod_ley],$TipoAnalisis,$Tms,$FilaInicial["cod_unidad"]);//Finos Suma		
						$Valor_Inicial=$ValoresIniciales;//Mostrar suma de finos iniciales en pantalla
						//$ValoresLeyes=CaracteristicasMaterialInicialLeyes($Cod,$FilaInicial[cod_ley],$TipoAnalisis,$Tms,$FilaInicial["cod_unidad"],$ValoresIniciales);//Calculo Leyes						
						if($FilaInicial["cod_unidad"]=='13')//TMF
							$ValoresLeyes=($Valor_Inicial/$Tms)*100;
						else
							$ValoresLeyes=($Valor_Inicial/$Tms);
					}
					echo "<tr>";
					echo "<td class='TituloCabecera'>".$FilaInicial[nom_ley]."</td>";
					echo "<td class='TituloCabecera' align='center'>".$NomUni."</td>";					
					echo "<td align='right'>".number_format($Valor_Inicial,2,',','.')."</td>";
					echo "<td align='right'>&nbsp;</td>";					
					echo "<td align='right'>".number_format($ValoresLeyes,4,',','.')."</td>";					
					echo "<td class='TituloCabecera' align='center'>".$FilaInicial[nom_unidad]."</td>";
					echo "</tr>";
				}				
		   ?>
	  </table>
		<br>
		<table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
          <tr>
            <td width="20%" class="TituloCabecera">FINOS PAGABLES</td>
            <td width="10%" class="TituloCabecera">&nbsp;</td>
            <td align="center" class="TituloCabecera"><? echo $NomOrigen;?></td>
            <td align="center" class="TituloCabecera"><? echo $DatosAnalisis;?></td>
            <td align="center" class="TituloCabecera">DIFERENCIA</td>
          </tr>
		  <?
				$Consultamerma="select * from pcip_eva_merma where corr='".$Cod."' and cod_tipo_analisis='".$TipoAnalisisAux."'";//MERMA DE COMPRA 
				//echo "MERMA:   ".$Consultamerma."<BR>";
				$Respmerma=mysql_query($Consultamerma);
				if($Filamerma=mysql_fetch_array($Respmerma));
					$ValorMermaCompra=$Filamerma[valor];

				$Consultamerma="select * from pcip_eva_merma where corr='".$Cod."' and cod_tipo_analisis='".$TipoAnalisis."'";//MERMA DE LOS DEMAS ANALISIS
				//echo "MERMA:   ".$Consultamerma."<BR>";
				$Respmerma=mysql_query($Consultamerma);
				if($Filamerma=mysql_fetch_array($Respmerma));
					$ValorMerma=$Filamerma[valor];
		  
				//CALCULO PARA FINOS PAGABLES.
				$ConsultaMaterial="select t1.corr,t1.cod_ley,t1.cod_unidad,t2.nombre_subclase as nom_ley,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_material t1";
				$ConsultaMaterial.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_ley=t2.cod_subclase";
				$ConsultaMaterial.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase";
				$ConsultaMaterial.=" where corr='".$Cod."' and cod_ley not in ('0') group by cod_ley";
				$RespMaterial=mysql_query($ConsultaMaterial);
				//echo "Consulta Material:   ".$ConsultaMaterial."<br>";
				while($FilaMa=mysql_fetch_array($RespMaterial))
				{				
					//POR CADA ANALISIS UN PROCESO 
					$Valor=CaracteristicasMaterial($Cod,$FilaMa[cod_ley],$TipoAnalisis,$Tms,$ValorMerma,$FilaMa["cod_unidad"]);
					// ANALISIS DE COMPRA
					$ValorUno=CaracteristicasMaterial($Cod,$FilaMa[cod_ley],$TipoAnalisisAux,$Tms,$ValorMermaCompra,$FilaMa["cod_unidad"]);
					if($FilaMa[cod_ley]==1)
					{
						if($FilaMa["cod_unidad"]==13||$FilaMa["cod_unidad"]==9)
							$NomUni='TMS';	
					}
					else
					{
						if($FilaMa["cod_unidad"]==9||$FilaMa["cod_unidad"]==10||$FilaMa["cod_unidad"]==22)
							$NomUni='KG';	
					}
					echo "<tr>";
					echo "<td class='TituloCabecera'>".$FilaMa[nom_ley]."</td>";
					echo "<td class='TituloCabecera' align='center'>".$NomUni."</td>";					
					echo "<td align='right'>".number_format($ValorUno,3,',','.')."</td>";
					echo "<td align='right'>".number_format($Valor,3,',','.')."</td>";
					echo "<td align='right'>".number_format(($ValorUno-$Valor),2,',','.')."</td>";
					echo "</tr>";
				}
				?>	
				  </table>
				<br>			
				<table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
				  <tr>
					<td width="27%" class="TituloCabecera">COSTOS - CARGOS</td>
					<td width="3%" class="TituloCabecera">&nbsp;</td>
		            <td align="center" class="TituloCabecera"><? echo $NomOrigen;?></td>
					<td align="center" class="TituloCabecera"><? echo $DatosAnalisis;?></td>
					<td align="center" class="TituloCabecera">DIFERENCIA</td>
				  </tr>
			  <?
			   //COSTOS DE CADA TIPO DE ANALISIS
			   $TotDifCargos=0;
			   $Consulta="select distinct t2.cod_subclase as cod_cargo,t2.nombre_subclase as nom_cargo,t3.nombre_subclase as nom_unidad,t2.valor_subclase2 as valor_ley from pcip_eva_negocios_costos t1 ";
			   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31039' and t1.cod_tipo=t2.cod_subclase ";
			   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
			   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$TipoAnalisis."' and t1.cod_tipo_costo='1' order by cod_tipo";
			   //echo $Consulta;
			   $Resp=mysqli_query($link, $Consulta);
			   while($Fila=mysql_fetch_array($Resp))
			   {
					$Valor1=ValorCostos($Cod,$TipoAnalisisAux,$Fila[cod_cargo],$Tms,$Fila[valor_ley]);
					$Valor2=ValorCostos($Cod,$TipoAnalisis,$Fila[cod_cargo],$Tms,$Fila[valor_ley]);
					$Dif=$Valor1-$Valor2;
					$TotDifCargos=$TotDifCargos+$Dif;
				?>
				  <tr>
						<td width="20%" class='TituloCabecera'><strong><? echo strtoupper($Fila[nom_cargo]);?></strong></td>
						<td width="10%" align="center" class='TituloCabecera'><strong>US$</strong></td>
						<td align="right"><? echo number_format($Valor1,2,',','.');?>&nbsp;</td>
						<td align="right"><? echo number_format($Valor2,2,',','.');?>&nbsp;</td>
						<td align="right"><? echo number_format($Dif,2,',','.');?>&nbsp;</td>
				  </tr>
				<?
			   }
				$TotDifCargos=$TotDifCargos+$Dif;
			   ?>
          <tr>
            <td colspan="4" class="pie_tabla_bold">Cargos (US$)</td>
            <td align="right" class="pie_tabla_bold"><? echo number_format($TotDifCargos,4,',','.');?>&nbsp;</td>
          </tr>
        </table>
		 <table width="100%" border="0" cellspacing="0" cellpadding="0">
			   <tr>
			   <td class="titulotablanaranja">TOTAL PERDIDAS EN&nbsp;<? echo number_format($Tms,0,',','.');?>&nbsp;TMS</td>
			   <td width="24%" align="right" class="titulotablanaranja">US$</td>
			   <td align="right" width="29%" class="titulotablanaranja"><? echo number_format(($TotPerdDeduc+$TotDifCargos)*$Tms,4,',','.')?>&nbsp;</td>
			   </tr>
      	 </table><br>
			<!--CASTIGOS DE ANALISIS-->
			<table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
			  <tr>
				<td width="27%" class="TituloCabecera">CASTIGOS</td>
				<td width="3%" class="TituloCabecera">&nbsp;</td>
				<td align="center" class="TituloCabecera"><? echo $NomOrigen;?></td>
				<td align="center" class="TituloCabecera"><? echo $DatosAnalisis;?></td>
				<td align="center" class="TituloCabecera">DIFERENCIA</td>
			  </tr>
			  <?
				$Consulta="select tipo_origen,analisis,tms,porc_hum from pcip_eva_negocios where corr='".$Cod."'";
				//echo $Consulta;
				$Resp=mysqli_query($link, $Consulta);
				$Fila=mysql_fetch_array($Resp);
				$TMH=$Fila[porc_hum];
			  ?>
			  <tr>
				<td width="27%" class="TituloCabecera">HUMEDAD</td>
				<td align="center" colspan="4" ><? echo $TMH;?>%</td>
			  </tr>	
			  <?
				   /*$Consulta="select distinct t2.cod_subclase as cod_castigos,t1.observacion,t1.cod_unidad,t1.cod_tipo,t1.valor,t1.cada,t1.sobre,t2.nombre_subclase as nom_castigos,t3.nombre_subclase as nom_unidad";
				   $Consulta.=" from pcip_eva_negocios_castigos t1 ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31040' and t1.cod_tipo=t2.cod_subclase ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
				   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis in ('".$TipoAnalisis."','".$TipoAnalisisAux."') and cod_tipo in ('1','2','3') group by cod_castigos";
				   echo $Consulta."<br>";
				   $Resp=mysqli_query($link, $Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
						$Valor1=CastigosValores($Cod,$Fila[cod_tipo],$TipoAnalisisAux,$Tms);
						$Valor2=CastigosValores($Cod,$Fila[cod_tipo],$TipoAnalisis,$Tms);
						$Dif=$Valor1-$Valor2;
						$TotDifCargos=$TotDifCargos+$Dif;
						echo "<tr>";							
						echo "<td class='TituloCabecera'>".$Fila[nom_castigos]."</td>";
						echo "<td class='TituloCabecera' align='center'>US$</td>";					
						echo "<td align='right'>".number_format($Valor1,3,',','.')."</td>";
						echo "<td align='right'>".number_format($Valor2,3,',','.')."</td>";
						echo "<td align='right'>".number_format(($Valor1-$Valor2),2,',','.')."</td>";
						echo "</tr>";
				   }*/
				   $Consulta="select distinct t2.cod_subclase as cod_castigos,t1.observacion,t1.cod_unidad,t1.cod_ley,t1.cod_tipo,t1.valor,t1.cada,t1.sobre,t2.nombre_subclase as nom_castigos,t3.nombre_subclase as nom_unidad";
				   $Consulta.=" from pcip_eva_negocios_castigos t1 ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31040' and t1.cod_tipo=t2.cod_subclase ";
				   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
				   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis in ('".$TipoAnalisis."','".$TipoAnalisisAux."') and cod_tipo not in ('1','2','3') group by cod_castigos";
				   //echo $Consulta."<br>";
				   $Resp=mysqli_query($link, $Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
						$ValorOtros1=CastigosOtrosValores($Cod,$Fila[cod_tipo],$TipoAnalisisAux,$Tms,$Fila[cod_ley]);
						$ValorOtros2=CastigosOtrosValores($Cod,$Fila[cod_tipo],$TipoAnalisis,$Tms,$Fila[cod_ley]);
						echo "<tr>";
						echo "<td class='TituloCabecera'>".$Fila[nom_castigos]."</td>";
						echo "<td class='TituloCabecera' align='center'>US$</td>";					
						echo "<td align='right'>".number_format($ValorOtros1,3,',','.')."</td>";
						echo "<td align='right'>".number_format($ValorOtros2,3,',','.')."</td>";
						echo "<td align='right'>".number_format(($ValorOtros1-$ValorOtros2),2,',','.')."</td>";
						echo "</tr>";						
				   }						
			  ?>
 			</table>
		<br>
			<!--TRANSPORTES PARA ANALISIS-->
			<table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
			  <tr>
				<td width="27%" class="TituloCabecera">TRANSPORTES</td>
				<td width="3%" class="TituloCabecera">&nbsp;</td>
				<td align="center" class="TituloCabecera"><? echo $NomOrigen;?></td>
				<td align="center" class="TituloCabecera"><? echo $DatosAnalisis;?></td>
				<td align="center" class="TituloCabecera">DIFERENCIA</td>
			  </tr>
			  <?
				$Consulta="select tipo_origen,analisis,tms,porc_hum from pcip_eva_negocios where corr='".$Cod."'";
				//echo $Consulta;
				$Resp=mysqli_query($link, $Consulta);
				$Fila=mysql_fetch_array($Resp);
				$TMH=$Fila[porc_hum];

				   $Consulta="select * from pcip_eva_negocios_transporte where corr='".$Cod."' and cod_tipo_analisis in ('".$TipoAnalisis."','".$TipoAnalisisAux."') group by cod_origen_destino";
				   //echo "transportes:  ".$Consulta."<br>";
				   $Resp=mysqli_query($link, $Consulta);
				   while($Fila=mysql_fetch_array($Resp))
				   {
					   $Consulta2="select distinct t2.cod_subclase as cod_transporte,t1.cod_origen_destino,t1.valor,cod_unidad,t2.nombre_subclase as nom_transporte_ori_dest,t4.nombre_subclase as nom_unidad";
					   $Consulta2.=" from pcip_eva_negocios_transporte t1 ";
					   $Consulta2.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31036' and t1.cod_origen_destino=t2.cod_subclase ";
					   $Consulta2.="inner join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='31051' and t1.cod_unidad=t4.cod_subclase ";
					   $Consulta2.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$Fila[cod_tipo_analisis]."' and t1.cod_origen_destino='".$Fila[cod_origen_destino]."'";
					   $Resp2=mysql_query($Consulta2);
					   while($Fila2=mysql_fetch_array($Resp2))
					   {
							$ConsultaMaterial="select t1.corr,t1.cod_ley,t1.cod_unidad,t2.nombre_subclase as nom_ley,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_material t1";
							$ConsultaMaterial.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_ley=t2.cod_subclase";
							$ConsultaMaterial.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase";
							$ConsultaMaterial.=" where corr='".$Cod."' and cod_ley in ('1')";
							$RespMaterial=mysql_query($ConsultaMaterial);
							//echo "Consulta Material:   ".$ConsultaMaterial."<br>";
							while($FilaMa=mysql_fetch_array($RespMaterial))
							{				
								//POR CADA ANALISIS UN PROCESO 
								$ValorPagable=CaracteristicasMaterial($Cod,'1',$TipoAnalisis,$Merma,$Tms,$ValorMerma,$FilaMa["cod_unidad"]);
								// ANALISIS DE COMPRA
								$ValorPagableUno=CaracteristicasMaterial($Cod,'1',$TipoAnalisisAux,$Merma,$Tms,$ValorMermaCompra,$FilaMa["cod_unidad"]);
							}	
							$Valor1=ValorTransp($Cod,$Fila2[cod_origen],$Fila2[cod_destino],$TipoAnalisisAux,$Tms,$TMH,$ValorPagableUno);
							$Valor2=ValorTransp($Cod,$Fila2[cod_origen],$Fila2[cod_destino],$TipoAnalisis,$Tms,$TMH,$ValorPagable);
							echo "<tr>";							
							echo "<td class='TituloCabecera'>".$Fila2[nom_transporte_ori_dest]."</td>";
							echo "<td class='TituloCabecera' align='center'>US$</td>";					
							echo "<td align='right'>".number_format($Valor1,3,',','.')."</td>";
							echo "<td align='right'>".number_format($Valor2,3,',','.')."</td>";
							echo "<td align='right'>".number_format(($Valor1-$Valor2),2,',','.')."</td>";
							echo "</tr>";
					   }
				   }  
			  ?>
 			</table>
		<br>
			<!--FACTORES PARA ANALISIS-->
			<table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
			  <tr>
				<td width="27%" class="TituloCabecera">FACTORES</td>
				<td width="3%" class="TituloCabecera">&nbsp;</td>
				<td align="center" class="TituloCabecera"><? echo $NomOrigen;?></td>
				<td align="center" class="TituloCabecera"><? echo $DatosAnalisis;?></td>
				<td align="center" class="TituloCabecera">DIFERENCIA</td>
			  </tr>
			  <?
				$Consulta="select tipo_origen,analisis,tms,porc_hum from pcip_eva_negocios where corr='".$Cod."'";
				//echo $Consulta;
				$Resp=mysqli_query($link, $Consulta);
				$Fila=mysql_fetch_array($Resp);
				$TMH=$Fila[porc_hum];
								 
				   $Consulta1="select * from pcip_eva_negocios_factores where corr='".$Cod."' and cod_tipo_analisis in ('".$TipoAnalisis."','".$TipoAnalisisAux."') group by cod_tipo";
				   $Resp1=mysql_query($Consulta1);
				   while($Fila1=mysql_fetch_array($Resp1))
				   {
					   $Consulta2="select distinct t2.cod_subclase as cod_factores,t1.cod_tipo,t1.euro,t1.valor,cod_unidad,t2.nombre_subclase as nom_factor,t3.nombre_subclase as nom_unidad";
					   $Consulta2.=" from pcip_eva_negocios_factores t1 ";
					   $Consulta2.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31053' and t1.cod_tipo=t2.cod_subclase ";
					   $Consulta2.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
					   $Consulta2.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$Fila1[cod_tipo_analisis]."' and cod_tipo='".$Fila1[cod_tipo]."'";
					   $Resp2=mysql_query($Consulta2);
					   while($Fila2=mysql_fetch_array($Resp2))
					   {
					   		//FINO DE COBRE. PARA CONVERSION EN US$/TMF Y EURO/TMF
							$ConsultaMaterial="select t1.corr,t1.cod_ley,t1.cod_unidad,t2.nombre_subclase as nom_ley,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_material t1";
							$ConsultaMaterial.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_ley=t2.cod_subclase";
							$ConsultaMaterial.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase";
							$ConsultaMaterial.=" where corr='".$Cod."' and cod_ley in ('1')";
							$RespMaterial=mysql_query($ConsultaMaterial);
							//echo "Consulta Material:   ".$ConsultaMaterial."<br>";
							while($FilaMa=mysql_fetch_array($RespMaterial))
							{				
								//POR CADA ANALISIS UN PROCESO 
								$ValorPagable=CaracteristicasMaterial($Cod,'1',$TipoAnalisis,$Merma,$Tms,$ValorMerma,$FilaMa["cod_unidad"]);								
								// ANALISIS DE COMPRA
								$ValorPagableUno=CaracteristicasMaterial($Cod,'1',$TipoAnalisisAux,$Merma,$Tms,$ValorMermaCompra,$FilaMa["cod_unidad"]);
							}	
							$ValorFac1=ValorFactor($Cod,$Fila2[cod_tipo],$TipoAnalisisAux,$Tms,$TMH,$ValorPagableUno);
							$ValorFac2=ValorFactor($Cod,$Fila2[cod_tipo],$TipoAnalisis,$Tms,$TMH,$ValorPagable);
							echo "<tr>";							
							echo "<td class='TituloCabecera'>".$Fila2[nom_factor]."</td>";
							echo "<td class='TituloCabecera' align='center'>US$</td>";					
							echo "<td align='right'>".number_format($ValorFac1,3,',','.')."</td>";
							echo "<td align='right'>".number_format($ValorFac2,3,',','.')."</td>";
							echo "<td align='right'>".number_format(($ValorFac1-$ValorFac2),2,',','.')."</td>";
							echo "</tr>";
					   }
				   }  
			  ?>
 			</table>
		<br>
		  <?
		   if($TipoAnalisis!=1&&$TipoAnalisis!=3)
		   {	
		  ?>	
			<!--PREMIOS PARA ANALISIS-->
			<table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
			  <tr>
				<td width="27%" class="TituloCabecera">PREMIOS</td>
				<td width="3%" class="TituloCabecera">&nbsp;</td>
				<td align="center" class="TituloCabecera"><? echo $DatosAnalisis;?></td>
			  </tr>
			  <?
			   $Consulta1="select * from pcip_eva_premios where corr='".$Cod."' and cod_tipo_analisis='".$TipoAnalisis."' group by cod_tipo";
			   $Resp1=mysql_query($Consulta1);
			   while($Fila1=mysql_fetch_array($Resp1))
			   {
				   $Consulta2="select distinct t2.cod_subclase as cod_premios,t1.cod_tipo,t1.euro,t1.valor,cod_unidad,t2.nombre_subclase as nom_premio,t3.nombre_subclase as nom_unidad";
				   $Consulta2.=" from pcip_eva_premios t1 ";
				   $Consulta2.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31052' and t1.cod_tipo=t2.cod_subclase ";
				   $Consulta2.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
				   $Consulta2.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$Fila1[cod_tipo_analisis]."' and cod_tipo='".$Fila1[cod_tipo]."'";
				   $Resp2=mysql_query($Consulta2);
				   while($Fila2=mysql_fetch_array($Resp2))
				   {
						//FINO DE COBRE. PARA CONVERSION EN US$/TMF Y EURO/TMF
						$ConsultaMaterial="select t1.corr,t1.cod_ley,t1.cod_unidad,t2.nombre_subclase as nom_ley,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_material t1";
						$ConsultaMaterial.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_ley=t2.cod_subclase";
						$ConsultaMaterial.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase";
						$ConsultaMaterial.=" where corr='".$Cod."' and cod_ley in ('1')";
						$RespMaterial=mysql_query($ConsultaMaterial);
						//echo "Consulta Material:   ".$ConsultaMaterial."<br>";
						while($FilaMa=mysql_fetch_array($RespMaterial))
						{				
							//POR CADA ANALISIS UN PROCESO 
							$ValorPagable=CaracteristicasMaterial($Cod,'1',$TipoAnalisis,$Merma,$Tms,$ValorMerma,$FilaMa["cod_unidad"]);
							// ANALISIS DE COMPRA
							//$ValorPagableUno=CaracteristicasMaterial($Cod,'1',$TipoAnalisisAux,$Merma,$Tms,$ValorMermaCompra,$FilaMa["cod_unidad"]);
						}	
						//$ValorPre1=ValorPremio($Cod,$Fila2[cod_tipo],$TipoAnalisisAux,$ValorPagableUno);
						$ValorPre2=ValorPremio($Cod,$Fila2[cod_tipo],$TipoAnalisis,$ValorPagable);
						echo "<tr>";							
						echo "<td class='TituloCabecera'>".$Fila2[nom_premio]."</td>";
						echo "<td class='TituloCabecera' align='center'>US$</td>";					
						echo "<td align='right'>".number_format($ValorPre2,3,',','.')."</td>";
						echo "</tr>";
				   }
			   }  
			  ?>
 			</table>
		<? }?><br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
          <tr>
            <td align="center" class="pie_tabla_bold">
		<?
		if($Origen!=1)
		{
			$Consulta = "select QP from pcip_eva_negocios_precios where corr='".$Cod."' and cod_tipo_analisis='".$TipoAnalisisAux."'";
			$Resp=mysqli_query($link, $Consulta);
			if($FilaTC=mysql_fetch_array($Resp))
			{
				$QP=$FilaTC[QP];
			}		
			else
				$QP='';			  
		?>	
        <table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
          <tr>
            <td colspan="3" align="center" class="pie_tabla_bold">Precio Compra <? echo "<span class='InputRojo'>&nbsp;MES + ".$QP."</span>";?></td>
          </tr>
		  <?
			   $Consulta="select distinct t2.cod_subclase as cod_precio,t2.nombre_subclase as nom_precio,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_precios t1 ";
			   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_tipo=t2.cod_subclase ";
			   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
			   $Consulta.="where t1.corr='".$Cod."' order by cod_tipo";
			   //echo $Consulta;
			   $Resp=mysqli_query($link, $Consulta);
			   while($Fila=mysql_fetch_array($Resp))
			   {
					$Valor1=ValorPrecios($Cod,1,$Fila[cod_precio],$i);
				?>
				  <tr>
					<td width="20%" class='TituloCabecera'><strong><? echo strtoupper($Fila[nom_precio]);?></strong></td>
					<td align="center" class='TituloCabecera'><? echo $Fila[nom_unidad];?>&nbsp;</td>
					<td align="right"><? echo number_format($Valor1,7,',','.');?>&nbsp;</td>
				  </tr>
				<?
		  	   }
		  ?>
        </table>
		<?
		}
		?>
		</td>
		<td>
        <table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
          <tr>
		  <?
			$Consulta = "select QP from pcip_eva_negocios_precios where corr='".$Cod."' and cod_tipo_analisis='".$TipoAnalisis."'";

			$Resp=mysqli_query($link, $Consulta);
			if($FilaTC=mysql_fetch_array($Resp))
			{
				$QP=$FilaTC[QP];
			}	
			else
				$QP='';			  
		  ?>
            <td colspan="3" align="center" class="pie_tabla_bold">Precio Venta <? echo "<span class='InputRojo'>&nbsp;MES + ".$QP."</span>";?> </td>
          </tr>
		  <?
			   $Consulta="select distinct t2.cod_subclase as cod_precio,t2.nombre_subclase as nom_precio,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_precios t1 ";
			   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_tipo=t2.cod_subclase ";
			   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
			   $Consulta.="where t1.corr='".$Cod."' order by cod_tipo";
			   //echo $Consulta;
			   $Resp=mysqli_query($link, $Consulta);
			   while($Fila=mysql_fetch_array($Resp))
			   {
					$Valor1=ValorPrecios($Cod,$TipoAnalisis,$Fila[cod_precio],$i);
				?>
				  <tr>
					<td width="20%" class='TituloCabecera'><strong><? echo strtoupper($Fila[nom_precio]);?></strong></td>
					<td align="center" class='TituloCabecera'><? echo $Fila[nom_unidad];?>&nbsp;</td>
					<td align="right"><? echo number_format($Valor1,7,',','.');?>&nbsp;</td>
				  </tr>
				<?
		  	   }
		  ?>
        </table></td>
		</tr></table><br>
		
    </td>
  </tr>
</table><br><br>
<?
}
}
function ValorPremio($Cod,$Cod_Premio,$TipoAnalisis,$ValorPagable)
{
   $Consulta="select * from pcip_eva_premios where corr='".$Cod."' and cod_tipo_analisis='".$TipoAnalisis."' and cod_tipo='".$Cod_Premio."' ";
   //echo "factores:  ".$Consulta."<br>";
   $Resp=mysqli_query($link, $Consulta);
   while($Fila=mysql_fetch_array($Resp))
   {	
		$ValorPrem=$Fila[valor];			
		$UniPrem=$Fila["cod_unidad"]; 
		$ValorSalida=ConversionPremio($ValorPrem,$UniPrem,$ValorPagable,$Fila[euro]);
   }	
   return($ValorSalida);
}
function ConversionPremio($ValorPrem,$UniPrem,$ValorPagable,$Euro)
{
	switch ($UniPrem)//UNIDAD DE FACTORES INGRESADOS 
	{
		case "6"://US$/TMH
				echo $ValorPagable."<br>";
				$Valor=$ValorPrem*$ValorPagable;
		break;
		case "17"://EURO/TMF FALTA CONVERSION
				$Valor=$ValorPrem*$ValorPagable/(1/$Euro);
		break;
	}
	return($Valor);
}
function ValorFactor($Cod,$Cod_Factor,$TipoAnalisis,$Tms,$TMH,$ValorPagable)
{
   $Consulta="select * from pcip_eva_negocios_factores where corr='".$Cod."' and cod_tipo_analisis='".$TipoAnalisis."' and cod_tipo='".$Cod_Factor."' ";
   //echo "factores:  ".$Consulta."<br>";
   $Resp=mysqli_query($link, $Consulta);
   while($Fila=mysql_fetch_array($Resp))
   {	
		$ValorFact=$Fila[valor];			
		$UniFact=$Fila["cod_unidad"]; 
		$ValorSalida=ConversionFactor($ValorFact,$UniFact,$TMH,$Tms,$ValorPagable,$Fila[euro]);
   }	
   return($ValorSalida);
}
function ConversionFactor($ValorFact,$UniFact,$TMH,$Tms,$ValorPagable,$Euro)
{
	switch ($UniFact)//UNIDAD DE FACTORES INGRESADOS 
	{
		case "1"://US$/TMH
				$TMHCalculo=$Tms/(1-($TMH/100));	
				$Valor=$ValorFact*$TMHCalculo;
		break;
		case "15"://EURO/TMH
				$TMHCalculo=$Tms/(1-($TMH/100));	
				$Valor=$ValorFact*(5/1)*$TMHCalculo;
		break;
		case "6"://US$/TMH
				$Valor=$ValorFact*$ValorPagable;
		break;
		case "17"://EURO/TMF FALTA CONVERSION
				$Valor=$ValorFact*$ValorPagable/(1/$Euro);
		break;
	}
	return($Valor);
}
function CastigosOtrosValores($Cod,$TipoCastigo,$TipoAnalisis,$Tms,$CodLey)
{
   $Consulta="select t1.valor from pcip_eva_negocios_material t1 ";
   $Consulta.="where t1.corr='".$Cod."' and t1.cod_ley='".$CodLey."'";
   //echo $Consulta;
   $Resp=mysqli_query($link, $Consulta);
   while($Fila=mysql_fetch_array($Resp))
   {
   		$ValorLey=$ValorLey+$Fila[valor];
   }
   $Consulta="select distinct t2.cod_subclase as cod_castigos,t1.observacion,t1.euro,t1.cod_unidad,t1.valor,t1.cada,t1.sobre,t2.nombre_subclase as nom_castigos,t3.nombre_subclase as nom_unidad";
   $Consulta.=" from pcip_eva_negocios_castigos t1 ";
   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31040' and t1.cod_tipo=t2.cod_subclase ";
   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$TipoAnalisis."' and t1.cod_tipo='".$TipoCastigo."'";
   //echo $Consulta;
   $Resp=mysqli_query($link, $Consulta);
   if($Fila=mysql_fetch_array($Resp))
   {
		if($Fila["cod_unidad"]=='8')
			$ValorSalida=$Fila[valor];
		if($Fila["cod_unidad"]=='23')
			$ValorSalida=$Fila[valor]*(1/$Fila[euro]);
   		if($Fila[sobre]!='0'&&$Fila[cada]!='0')
		{
			if($Fila["cod_unidad"]=='2'||$Fila["cod_unidad"]=='16')	
			{
				if($ValorLey>$Fila[sobre])
					$ValorSalida=($ValorLey-$Fila[sobre])/($Fila[cada]*$Fila[valor]*$Tms);
				else
					$ValorSalida=0;	
			}
  		}
		else
			$ValorSalida=$Fila[valor]*$Tms;	
	}
   return($ValorSalida);			    
}
function CastigosValores($Cod,$TipoCastigo,$TipoAnalisis,$Tms)
{
   $ConsultaCastigo="select * from proyecto_modernizacion.sub_clase where cod_clase = '31037' and valor_subclase2 = '".$TipoCastigo."'";
   //echo $ConsultaCastigo;
   $RespCas=mysql_query($ConsultaCastigo);
   while($FilaCas=mysql_fetch_array($RespCas))
   {			   		
	   //CASTIGOS :  ARSENICO 1 - ANTIMONIO 2 - CINC 3. 
	   $ConsultaLey="select * from pcip_eva_negocios_material where corr='".$Cod."' and cod_ley='".$FilaCas["cod_subclase"]."'";
	   //echo "consulta para saber si existe alguna ley con valor:  ".$ConsultaLey."<br>";
	   $RespLey=mysql_query($ConsultaLey);
	   if($FilaLey=mysql_fetch_array($RespLey))
	   {
		   $ValorLey=$FilaLey[valor]/100;
		   $Consulta="select distinct t2.cod_subclase as cod_castigos,t1.observacion,t1.cod_unidad,t1.valor,t1.cada,t1.sobre,t2.nombre_subclase as nom_castigos,t3.nombre_subclase as nom_unidad";
		   $Consulta.=" from pcip_eva_negocios_castigos t1 ";
		   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31040' and t1.cod_tipo=t2.cod_subclase ";
		   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
		   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$TipoAnalisis."' and t1.cod_tipo='".$TipoCastigo."'";
		   //echo $Consulta;
		   $Resp=mysqli_query($link, $Consulta);
		   if($Fila=mysql_fetch_array($Resp))
		   {
				$ValorSobre=$Fila[sobre]/100;
				$ValorCada=$Fila[cada]/100;
				$ValorCastigo=$Fila[valor];
				if($Fila["cod_unidad"]=='2')//US$/TMS UNIDAD DE CASTIGO
					$ValorCastigoFinal=(($ValorLey-$ValorSobre)/$ValorCada)*$ValorCastigo*$Tms;								
				if($Fila["cod_unidad"]=='16')//EURO/TMS UNIDAD DE CASTIGO	
					$ValorCastigoFinal=(($ValorLey-$ValorSobre)/$ValorCada)*$ValorCastigo*(5/1)*$Tms;				
		   }			    
	   }
	   else
	   {
		   $Consulta="select distinct t2.cod_subclase as cod_castigos,t1.observacion,t1.cod_unidad,t1.valor,t1.cada,t1.sobre,t2.nombre_subclase as nom_castigos,t3.nombre_subclase as nom_unidad";
		   $Consulta.=" from pcip_eva_negocios_castigos t1 ";
		   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31040' and t1.cod_tipo=t2.cod_subclase ";
		   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
		   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$TipoAnalisis."' and t1.cod_tipo='".$TipoCastigo."'";
		   //echo $Consulta;
		   $Resp=mysqli_query($link, $Consulta);
		   if($Fila=mysql_fetch_array($Resp))
		   {
				$ValorCastigo=$Fila[valor];
				if($Fila["cod_unidad"]=='2')//US$/TMS UNIDAD DE CASTIGO
					$ValorCastigoFinal=$ValorCastigo*$Tms;								
				if($Fila["cod_unidad"]=='16')//EURO/TMS UNIDAD DE CASTIGO	
					$ValorCastigoFinal=$ValorCastigo*(5/1)*$Tms;
		   }			    
	   }	
   }	 
 return($ValorCastigoFinal);
}
function ValorCostos($Cod,$TipoAnalisis,$CodTipo,$Tms,$ValorLey)
{
	$ConsultaMaterial="select t1.corr,t1.cod_ley,t1.cod_unidad,t2.nombre_subclase as nom_ley,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_material t1";
	$ConsultaMaterial.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_ley=t2.cod_subclase";
	$ConsultaMaterial.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase";
	$ConsultaMaterial.=" where corr='".$Cod."' ";
	if($ValorLey!=0)			
		$ConsultaMaterial.=" and t1.cod_ley='".$ValorLey."'";
	$RespMaterial=mysql_query($ConsultaMaterial);
	//echo "Consulta Material:   ".$ConsultaMaterial."<br>";
	if($FilaMa=mysql_fetch_array($RespMaterial))
	{				
		$Valor=CaracteristicasMaterial($Cod,$FilaMa[cod_ley],$TipoAnalisis,$Merma,$Tms,$ValorMerma,$FilaMa["cod_unidad"]);		
		$Valor=CaracteristicasMaterial($Cod,$FilaMa[cod_ley],$TipoAnalisisAux,$Merma,$Tms,$ValorMermaCompra,$FilaMa["cod_unidad"]);

		$Consulta="select t1.valor,t1.cod_unidad,t1.cod_tipo,t1.lote from pcip_eva_negocios_costos t1 ";
		$Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$TipoAnalisis."' and t1.cod_tipo='".$CodTipo."' and t1.cod_tipo_costo='1'";
		$Consulta.=" order by cod_tipo";
		//echo $Consulta."<br>";
		$RespValor=mysqli_query($link, $Consulta);
		if($FilaValor=mysql_fetch_array($RespValor))
		{
			$Valor=$FilaValor[valor];
			$Lote=$FilaValor["lote"];
			$Valor=ConvertirAUS($FilaValor["cod_unidad"],$FilaValor[cod_tipo],$FilaValor[valor],$Tms,$Valor,$Lote);
		}
		else
			$Valor=0;
	}
   return($Valor);
}
function ConvertirAUS($CodUnidad,$TipoCosto,$Costo,$Tms,$ValorPagable,$Lote)
{
	$Valor=0;
	switch($TipoCosto)
	{
		case "2"://PREPARACION / EMBALAJE
		case "3"://TRATAMIENTO
			switch($CodUnidad)
			{	//SOLO TRATAMIENTO Y OTROS
				case "2"://US$/TMS
						$Valor=$Tms*$Costo;
				break;
				case "8"://US$
						$Valor=$Costo;
				break;
				case "16"://EURO/TMS
						$Valor=$Tms*$Costo*(1/0.9);
				break;
				case "23"://EURO
						$Valor=$Costo*1/0.9;
				break;
			}			
		break;	
		case "4"://REFINERIA CU - AG - AU
		case "5":
		case "6":
			switch($CodUnidad)
			{	
				case "3"://CUS/LB
						$Valor=$Costo*(1/0.4536)*(1/100)*$ValorPagable*(1/1000);
				break;
				case "4"://US$Oz
						$Valor=$Costo*1000/31.103477*$ValorPagable;
				break;
				case "7"://US$KG
						$Valor=$Costo*(1/100)*$ValorPagable;
				break;
				case "19"://CUS/OZ
						$Valor=$Costo*(1/31.1035)*$ValorPagable*(1/100);
				break;
				case "18"://US$/LB
						$Valor=($Costo/0.4536)*1000*$ValorPagable;
				break;
				case "6"://US$/TMF
						$Valor=$Costo*(1/1000000)*$ValorPagable;
				break;
			}			
		break;	
		case "7"://ANALISIS QUIMICO
			switch($CodUnidad)
			{
				case "5"://US$/LOTE
						$Valor=$Tms*$Costo*(1/$Lote);
				break;	
				case "2"://US$/TMS
						$Valor=$Tms*$Costo;
				break;
				case "7"://US$KG
						$Valor=$Costo*(1/100)*$ValorPagable;
				break;
				case "16"://EURO/TMS
						$Valor=$Tms*$Costo*(1/0.9);
				break;
				case "8"://US$
						$Valor=$Costo;
				break;
				case "23"://EURO
						$Valor=$Costo*1/0.9;
				break;
			}					
		break;
		case "8"://OTROS
		case "9"://OTROS 2
			switch($CodUnidad)
			{
				case "8"://US$
						$Valor=$Costo;
				break;
				case "23"://EURO
						$Valor=$Costo*1/0.9;
				break;
			}					
		break;
		case "10"://PRODUCCI�N ACIDO
			switch($CodUnidad)
			{
				case "7"://US$KG
						$Valor=$Costo*(1/100)*$ValorPagable;
				break;
				case "2"://US$/TMS
						$Valor=$Tms*$Costo;
				break;
			}					
		break;
	}	
	return($Valor);	
}

function ValorTransp($Cod,$Cod_Origen_Dest,$TipoAnalisis,$Tms,$TMH,$ValorPagable)
{
   $Consulta="select * from pcip_eva_negocios_transporte where corr='".$Cod."' and cod_tipo_analisis='".$TipoAnalisis."' and cod_origen_destino='".$Cod_Origen_Dest."'";
   //echo "transportes:  ".$Consulta."<br>";
   $Resp=mysqli_query($link, $Consulta);
   while($Fila=mysql_fetch_array($Resp))
   {	
		$ValorTransp=$Fila[valor];			
		$UniTransp=$Fila["cod_unidad"]; 
		$ValorSalida=ConversionTransp($ValorTransp,$UniTransp,$TMH,$Tms,$ValorPagable);
   }	
   return($ValorSalida);
}
function ConversionTransp($ValorTransp,$UniTransp,$TMH,$Tms,$ValorPagable)
{	
	$Valor=0;
	switch ($UniTransp)//VALORES PARA CALCULO DE LOS TRASNPORTES. SI VIENE CON PROCESO PREVIO Y ES NINGUNO DEJAR 1 Y 15 SI NO 6.
	{
		case "1"://US$/TMH
				$TMHCalculo=$Tms/(1-($TMH/100));	
				$Valor=$ValorTransp*$TMHCalculo;
		break;
		case "15"://EURO/TMH
				$TMHCalculo=$Tms/(1-($TMH/100));	
				$Valor=$ValorTransp*(5/1)*$TMHCalculo;
		break;
		case "6"://US$TMF
				$Valor=$ValorTransp*$ValorPagable;
		break;
	}
	return($Valor);
}
function ValorPrecios($Cod,$TipoAnalisis,$CodTipo,$CantPrecio)
{
	if($CantPrecio==1)
		$PrecioBusq='t1.valor';
	else
		$PrecioBusq='t1.valor2';	
   $Consulta="select ".$PrecioBusq." as valor from pcip_eva_negocios_precios t1 ";
   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$TipoAnalisis."' and t1.cod_tipo='".$CodTipo."' order by cod_tipo";
   //echo $Consulta;
   $RespValor=mysqli_query($link, $Consulta);
   if($FilaValor=mysql_fetch_array($RespValor))
   	$Valor=$FilaValor[valor];
   else
	$Valor=0;
   return($Valor);
}
function ValorConversionCosto($Cod,$Tms,$Cod_tipo,$Cod_tipo_costo,$Cod_unidad,$TipoAnalisis,$Merma,$MermaAnalisis)
{
	$ConsultaMaterial="select * from pcip_eva_negocios_material where corr='".$Cod."' and cod_ley='0' ";
	$RespMaterial=mysql_query($ConsultaMaterial);
	if($FilaMaterial=mysql_fetch_array($RespMaterial))
		$UnidadInicial=$FilaMaterial["cod_unidad"];
		
	$ConsultaMaterial="select t1.corr,t1.cod_ley,t1.cod_unidad,t2.nombre_subclase as nom_ley,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_material t1";
	$ConsultaMaterial.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_ley=t2.cod_subclase";
	$ConsultaMaterial.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase";
	$ConsultaMaterial.=" where corr='".$Cod."' and cod_ley not in ('0')";
	$RespMaterial=mysql_query($ConsultaMaterial);
	//echo "Consulta Material:   ".$ConsultaMaterial."<br>";
	while($FilaMa=mysql_fetch_array($RespMaterial))
	{						
		$ConsultaLEY="select * from pcip_eva_negocios_material where corr='".$Cod."' and cod_ley<>'0'";
		$RespLEY=mysql_query($ConsultaLEY);
		while($FilaLEY=mysql_fetch_array($RespLEY))
			$Ley=$FilaLEY[cod_ley];
	
		$Consulta="select cod_tipo,valor,lote,dolar from pcip_eva_negocios_costos ";
		$Consulta.=" where corr='".$Cod."' and cod_tipo='".$Cod_tipo."' and cod_tipo_costo='".$Cod_tipo_costo."'";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			$ValorCosto=ConversionCostos($UnidadInicial,$Fila[cod_tipo],$Tms,$Cod_unidad,$Fila[valor],$Fila["lote"],$Fila[dolar],$ValorFinosPagables);		
		}			
	}
	return($ValorCosto);
}

function CaracteristicasMaterialInicial($Codigo,$Ley,$TipoAnalisis,$Tms,$Unidad)//CALCULO PARA FINOS INICIALES.
{
	$ConsultaMaterial="select sum(valor) as valor from pcip_eva_negocios_material where corr='".$Codigo."' and cod_ley='".$Ley."'";
	$RespMaterial=mysql_query($ConsultaMaterial);
	if($FilaMaterial=mysql_fetch_array($RespMaterial))
	{		
		$ValorAcumulado=$FilaMaterial[valor];//SUMA DE FINOS INICIALES INGRESADOS.
	}
	$ValorInicial=$ValorAcumulado;
	return($ValorInicial);
}
function CaracteristicasMaterialInicialLeyes($Codigo,$Ley,$TipoAnalisis,$Tms,$Unidad,$ValoresIniciales)//CALCULO PARA FINOS INICIALES leyes.
{
	$ConsultaMatIniSeco="select * from pcip_eva_negocios_material where corr='".$Codigo."' and cod_ley='0' ";
	$RespMatIniSeco=mysql_query($ConsultaMatIniSeco);
	while($FilaMatIniSeco=mysql_fetch_array($RespMatIniSeco))		
	{				
		$ConsultaMaterial="select sum(valor) as valor from pcip_eva_negocios_material where corr='".$Codigo."' and cod_ley='".$Ley."'";
		$RespMaterial=mysql_query($ConsultaMaterial);
		while($FilaMaterial=mysql_fetch_array($RespMaterial))
		{
			$ValorAcumulado=$FilaMaterial[valor];
		}
	}	
	$ValorSalida=$ValorAcumulado/$ValoresIniciales;
	return($ValorSalida);
}
function CaracteristicasMaterialLeyes($Codigo,$Ley,$TipoAnalisis,$Tms,$Unidad)//CALCULO PARA FINOS INICIALES leyes.
{
	$ConsultaMaterial="select sum(valor) as valor from pcip_eva_negocios_material where corr='".$Codigo."' and cod_ley='".$Ley."'";
	$RespMaterial=mysql_query($ConsultaMaterial);
	//echo $ConsultaMaterial."<br>";
	while($FilaMaterial=mysql_fetch_array($RespMaterial))
	{
		$ValorAcumulado=$FilaMaterial[valor];
	}
	$ValorSalida=$ValorAcumulado;
	return($ValorSalida);
}
function CaracteristicasMaterialLeyesIniciales($Codigo,$Ley,$TipoAnalisis,$Tms,$Unidad)//CALCULO PARA DE LEYES A FINOS.
{
	$ConsultaMatIniSeco="select * from pcip_eva_negocios_material where corr='".$Codigo."' and cod_ley='0' ";
	$RespMatIniSeco=mysql_query($ConsultaMatIniSeco);
	while($FilaMatIniSeco=mysql_fetch_array($RespMatIniSeco))		
	{				
		$ConsultaMaterial="select * from pcip_eva_negocios_material where corr='".$Codigo."' and cod_ley='".$Ley."' and cod_division='".$FilaMatIniSeco[cod_division]."'";
		$RespMaterial=mysql_query($ConsultaMaterial);
		while($FilaMaterial=mysql_fetch_array($RespMaterial))
		{
			$ValorAcumulado=ConvertirAFino($FilaMatIniSeco["cod_unidad"],$Unidad,$FilaMaterial[valor],$FilaMatIniSeco[valor]);
		}
	}	
	$ValorSalida=$ValorSalida+$ValorAcumulado;
	return($ValorSalida);
}
function ConvertirAFino($UniTMS,$CodUnidad,$Valor,$MatIniSeco)//CAMBIOS DE LAS LEYES PARA MOSTRAR EN FINOS
{
	switch($UniTMS)
	{
		case "12"://TMS MATERIAL INICIAL.
			switch($CodUnidad)
			{
				case "9"://%   ESTE ES UN CALCULO PARA SACAR LOS FINOS	
					 $ValorSalida=($MatIniSeco*($Valor/100));	
				break;
				case "10"://GRS/TON    ESTE ES UN CALCULO PARA SACAR LOS FINOS
					$ValorSalida=($MatIniSeco*$Valor);	
				break;
				case "22"://KG/TON	ESTE ES UN CALCULO PARA SACAR LOS FINOS		
					$ValorSalida=($MatIniSeco*$Valor);						
				break;		
			}	
		case "14"://KG
			switch($CodUnidad)
			{
				case "9"://%   ESTE ES UN CALCULO PARA SACAR LOS FINOS	
					 $ValorSalida=($MatIniSeco*($Valor/100));	
				break;
				case "10"://GRS/TON    ESTE ES UN CALCULO PARA SACAR LOS FINOS
					$ValorSalida=($MatIniSeco*$Valor)/1000;	
				break;
				case "22"://KG/TON	ESTE ES UN CALCULO PARA SACAR LOS FINOS		
					$ValorSalida=($MatIniSeco*$Valor)/1000;						
				break;		
			}
	}
	return($ValorSalida);		
}
function ConvertirALeyes($UniTMS,$CodUnidad,$Valor,$MatIniSeco)//CAMBIOS DE LOS FINOS INICIALES PARA MOSTRAR EN LEYES
{	
	switch($UniTMS)
	{
		case "12"://TMS MATERIAL INICIAL.
			switch($CodUnidad)
			{
				case "13"://TMF  FINOS CALCULO PARA SACAR LAS LEYES
					if($MatIniSeco>0)
				 		echo $ValorSalida."=(".$Valor."/".$MatIniSeco.")*100<br>";	
				break;
				case "14"://KG  FINOS CALCULO PARA SACAR LAS LEYES
					$ValorSalida=$Valor/1000;
				break;
				case "11"://GRS  FINOS CALCULO PARA SACAR LAS LEYES
					$ValorSalida=$Valor/1000;	
				break;
				case "20"://LB   FINOS CALCULO PARA SACAR LAS LEYES
					if($MatIniSeco>0)
						$ValorSalida=($Valor/0.4536)/$MatIniSeco;	
				break;
				case "21"://OZ    FINOS CALCULO PARA SACAR LAS LEYES
					if($MatIniSeco>0)
						$ValorSalida=($Valor/31.103477)/$MatIniSeco;	
				break;
			}
		break;
		case "14"://KG
			switch($CodUnidad)
			{
				case "14"://KG
					$ValorSalida=$Valor;	
				break;
				case "11"://GRS
					$ValorSalida=$Valor/1000;	
				break;
				case "20"://LB
					$ValorSalida=$Valor/0.4536;	
				break;
				case "21"://OZ
					$ValorSalida=$Valor/31.103477;	
				break;
			}
		break;
	}
	return($ValorSalida);
}
function CaracteristicasMaterial($Codigo,$Ley,$TipoAnalisis,$Tms,$MermaAnalisis,$Unidad)//CALCULO PARA FINOS PAGABLES.
{	
	$ConsultaMaterial="select * from pcip_eva_negocios_material where corr='".$Codigo."' and cod_ley='".$Ley."' ";
	//echo "valor material:  ".$ConsultaMaterial."<br>";
	$RespMaterial=mysql_query($ConsultaMaterial);$FinosTMS=0;
	while($FilaMaterial=mysql_fetch_array($RespMaterial))
	{				
		//APLICAMOS LA MERMA AL VALOR DEL TMS 
		$UnidadLey=$FilaMaterial["cod_unidad"];
		$ValorLey=$FilaMaterial[valor];

		$ValorTmsDesMerma=$Tms-$MermaAnalisis;
		$FinosTMS=$ValorTmsDesMerma*($ValorLey/100);
		
		$Consulta="select * from pcip_eva_negocios_deduc_recup ";
		$Consulta.="where corr='".$Codigo."' and cod_tipo_analisis='".$TipoAnalisis."' and cod_ley='".$FilaMaterial[cod_ley]."' order by orden";
		//echo $Consulta."<br>";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			$CodDeduccion=$Fila[cod_tipo];
			$ValorDedu=$Fila[valor];
			//echo "UNidad ley: ".$UnidadLey."   valor ley:  ".$FilaMaterial[valor]."    valor dedu:  ".$ValorDedu."&nbsp;  deduccion:  ".$CodDeduccion."<br>";			
			$UniDedu=$Fila["cod_unidad"];
			if($CodDeduccion==3)//ES DEDUCCION METALURGICA
			{	if($Fila[descuento]!=0)
				{
					$ValorUno=($ValorLey*$ValorDedu)/100;
					if($ValorUno<$Fila[descuento])
					{
						$ValorSalidaDeduccion=ObtenerFinosDeduccionesDescuentos(&$FinosTMS,$ValorTmsDesMerma,$ValorLey,$Fila[descuento]);								
					}
					else
						$ValorSalidaDeduccion=ObtenerFinosDeducciones(&$FinosTMS,$ValorTmsDesMerma,$UniDedu,$ValorDedu,$UnidadLey,$ValorLey);
				}
				else
					$ValorSalidaDeduccion=ObtenerFinosDeducciones(&$FinosTMS,$ValorTmsDesMerma,$UniDedu,$ValorDedu,$UnidadLey,$ValorLey);
			}
			else
				$ValorSalidaDeduccion=ObtenerFinosRecuperaciones(&$FinosTMS,$ValorDedu,$UnidadLey,$ValorLey);	
		}
	}		
	return($ValorSalidaDeduccion);	
}
function ObtenerFinosRecuperaciones(&$FinosTMS,$ValorDedu,$UnidadLey,$ValorLey)//finos pagables OTRAS RECUPERACIONES
{
	
	$ValorSalida=$FinosTMS*($ValorDedu/100);
	$FinosTMS=$ValorSalida;
	return($ValorSalida);
}
function ObtenerFinosDeduccionesDescuentos($FinosTMS,$ValorTmsDesMerma,$ValorLey,$Descuento)//DESCUENTO 
{
	$Valor=$ValorTmsDesMerma*($ValorLey-$Descuento)/100;
	$FinosTMS=$Valor;
	return($Valor);
}
function ObtenerFinosDeducciones($FinosTMS,$ValorTmsDesMerma,$UniDedu,$ValorDedu,$UnidadLey,$ValorLey)//DEDUCCIONES METALURGICA Y OTROS PROCESO
{
	switch ($UnidadLey)
	{
		case "9"://%
				switch ($UniDedu)
				{
					case "9"://%				
							$ValDeduPor=(100-$ValorDedu)/100;
							$Valor=$FinosTMS*$ValDeduPor;
					break;
					case "10"://GRS/TON
							$ValorGRS=$ValorDedu*$FinosTMS;
							$Valo2=$ValorGRS/1000000;
							$Valor=$FinosTMS-$Valo2;
					break;	
				}
		break;
		case "10"://GRS/TON
				 switch ($UniDedu)
				 {
					case "10"://GRS/TON
							$Valor1=$FinosTMS/10000;
							$Valor2=$ValorTmsDesMerma*$ValorDedu;
							$Valor3=$Valor2/1000000;
							$Valor=($Valor1-$Valor3)*1000;
					break;	
				 }
		break;
	}
	$FinosTMS=$Valor;
	return($Valor);
}
function ConvertirAFinoPagables($CodUnidad,$Valor,$Tms)//CAMBIOS DE LOS FINOS PAGABLES CON % Y GRS/TON � KG7/TON
{
	switch($CodUnidad)
	{
		case "9"://% 
			 $ValorSalida=($Tms*($Valor/100));	
		break;
		case "13"://TMF
			 $ValorSalida=$Valor;	
		break;
		case "14"://KG
		case "10"://GRS/TON
			$ValorSalida=($Tms*($Valor/100));	
		break;
		case "22"://KG/TON			
			$ValorSalida=($Tms*$Valor);						
		break;		
	}
	return($ValorSalida);
}
function ObtienePerdidadDeduc2($Cod,$Ley,$TipoAnalisis,$Tms,$Merma,$Merma2)
{
	$ConsultaMaterial="select * from pcip_eva_negocios_material where corr='".$Cod."' and cod_ley='0'";
	$RespMaterial=mysql_query($ConsultaMaterial);
	if($FilaMaterial=mysql_fetch_array($RespMaterial));
	{
		if($FilaMaterial["cod_unidad"]==12)
			$ValorMaterialTMS=$FilaMaterial[valor];//VALOR DE TMS SEGUN LOS MESES.		
		if($FilaMaterial["cod_unidad"]==14)
			$ValorMaterialTMS=$FilaMaterial[valor]/1000;//VALOR DE TMS SEGUN LOS MESES.		
	}
	$Suma=0;
	$ConsultaValor="select corr,cod_ley,cod_division,cod_unidad,valor from pcip_eva_negocios_material t1 ";
	$ConsultaValor.="where t1.corr='".$Cod."' and cod_ley='".$Ley."'";
	//echo $Consulta."<br>";
	$RespValor=mysql_query($ConsultaValor);
	while($FilaValor=mysql_fetch_array($RespValor))
	{		
		if($FilaValor["cod_unidad"]=='11')//DE GRAMOS A KG
			$ValorMaterial2=$FilaValor[valor]/1000;
		//echo $ValorMaterial2."<br>";
		if($FilaValor["cod_unidad"]=='10')	
			$ValorMaterial2=$FilaValor[valor]/1000/1000;

		$Consulta="select * from pcip_eva_negocios_deduc_recup t1 ";
		$Consulta.="where t1.corr='".$FilaValor["corr"]."' and cod_tipo_analisis='".$TipoAnalisis."' and cod_ley='".$FilaValor[cod_ley]."'";
		//echo $Consulta."<br>";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($TipoAnalisis!='1')
			{
				if($Fila["cod_unidad"]=='9')//% CAMBIOS DE UNIDADES EN DEDUCCIONES
				{				
					$Valor=$FilaValor[valor]*$Fila[valor]/100;
					$ValorCalculo=$FilaValor[valor]-$Valor;
				}
				if($Fila["cod_unidad"]=='10')//GRS/TON CAMBIOS DE UNIDADES EN DEDUCCIONES
					$ValorCalculo=$ValorMaterial2*$Merma-$Fila[valor]*$ValorMaterialTMS*$Merma/1000;
			}
			if($TipoAnalisis=='1')
			{
				if($Fila["cod_unidad"]=='9')//% CAMBIOS DE UNIDADES EN DEDUCCIONES
				{				
					$Valor=$FilaValor[valor]*$Fila[valor]/100;
					$ValorCalculo=$FilaValor[valor]-$Valor;
				}
				if($Fila["cod_unidad"]=='10')//GRS/TON CAMBIOS DE UNIDADES EN DEDUCCIONES
				{
					echo "=".$ValorMaterial2."*".$Merma2."-".$Fila[valor]."*".$ValorMaterialTMS."*".$Merma2."/1000<br>";
					$ValorCalculo=($ValorMaterial2*$Merma2-$Fila[valor]*$ValorMaterialTMS*$Merma2)/1000;
					echo $ValorCalculo."<br>";
				}
			}	
				$ConsultaPrecio="select * from pcip_eva_negocios_precios t1 ";
				$ConsultaPrecio.="where t1.corr='".$Fila["corr"]."' and cod_tipo_analisis='".$TipoAnalisis."' and cod_tipo='".$Fila[cod_ley]."'";
				//echo $ConsultaPrecio."<br>";
				$RespPrecio=mysql_query($ConsultaPrecio);
				while($FilaPrecio=mysql_fetch_array($RespPrecio))
				{
					$ValorPrecio=$FilaPrecio[valor];
					$Precios=ConversionPrecios($ValorPrecio,$ValorCalculo,$FilaPrecio["cod_unidad"],$Merma,$Tms);
					$Calculo=$Precios;
				}	
				$Suma=$Suma+$Calculo;
		}
	}
	return($Suma);
}
function ConversionPrecios($Precio,$Deduccion,$Unidad,$Merma,$Tms)
{	
	switch($Unidad)
	{
		case "4"://US$/OZ
			$ValorSalida=$Precio/31.103477*$Deduccion/0.001;
		break;
		case "6"://US$/TMF
			$ValorSalida=$Precio*$Deduccion/1000;
		break;
		case "18"://US$/LB
			$ValorSalida=$Precio/0.4536*$Deduccion;
		break;
		case "7"://US$/KG
			$ValorSalida=$Deduccion*$Precio;
		break;
		case "19"://CUS/OZ
			$ValorSalida=$Precio/31.103477*$Deduccion/0.001/1000;
		break;
		
	}
	return($ValorSalida);
	
}
function ObtienePerdidadDeduc($Cod,$Ley,$Tms,$ValorMerma)
{
	$Valor=0;
	$Consulta="select corr,cod_ley,cod_division,cod_unidad,valor from pcip_eva_negocios_material t1 ";
	$Consulta.="where t1.corr='".$Cod."' and cod_ley='".$Ley."'";
	//echo $Consulta."<br>";
	$RespValor=mysqli_query($link, $Consulta);
	while($FilaValor=mysql_fetch_array($RespValor))
	{			
		if($FilaValor["cod_unidad"]!='13')
			$Valor=$Valor+ConvertirAFino($FilaValor[cod_ley],$FilaValor["cod_unidad"],$FilaValor[valor],$Tms);
		else
			$Valor=$Valor+$FilaValor[valor]-$ValorMerma;
	}
	return($Valor);
}

?>