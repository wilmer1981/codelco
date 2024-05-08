<? include("../principal/conectar_pcip_web.php");
$CodTipoAnalisis='1';
echo "<input type='hidden' name='CodTipoAnalisis' value='".$CodTipoAnalisis."'>";
?>

<table width="100%" border="1" cellpadding="3" cellspacing="0" >
  <tr class='formulario2'>
   <td align="center">
   <?
	$Consulta="select tipo_origen,analisis,tms from pcip_eva_negocios where corr='".$Cod."'";
	//echo $Consulta;
	$Resp=mysqli_query($link, $Consulta);
	$Fila=mysql_fetch_array($Resp);
	$Tms=$Fila[tms];
	$Origen=$Fila[tipo_origen];
	$Unidad=$Fila[cod_unidad];
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

				$ConsultaMaterial="select * from pcip_eva_negocios_material where corr='".$Cod."' and cod_ley not in ('0')";
				$RespMaterial=mysql_query($ConsultaMaterial);
				//echo "Consulta Material:   ".$ConsultaMaterial."<br>";
				while($FilaMa=mysql_fetch_array($RespMaterial))
				{				
					if($TipoAnalisis!='1')//POR CADA ANALISIS UN PROCESO 
						$Car_Analisis=CaracteristicasMaterial($Cod,$FilaMa[cod_ley],$TipoAnalisis,$Merma,$Tms,$ValorMerma,$Unidad);
					if($TipoAnalisisAux=='1')// ANALISIS DE COMPRA
						$Car_Analisis=CaracteristicasMaterial($Cod,$FilaMa[cod_ley],$TipoAnalisis,$Merma,$Tms,$ValorMermaCompra,$Unidad);
				}				
								
		   		$TotPerdDeduc=0;				
				//echo "valor:  ".$Valor."<br>";
				//ObtienePerdidadDeduc($Cod,$TipoAnalisis,$Div,$Tms,$i);
				$Consulta="select distinct t1.cod_ley,t2.nombre_subclase as nom_ley,corr,t3.nombre_subclase as nom_unidad,t1.cod_unidad from pcip_eva_negocios_material t1 ";
				$Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_ley=t2.cod_subclase ";
				$Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
				$Consulta.="where t1.corr='".$Cod."' order by t1.corr,t1.cod_ley";
				//echo "consulta principal:  ".$Consulta."<br>";
				$RespValor=mysqli_query($link, $Consulta);
				while($FilaValor=mysql_fetch_array($RespValor))
				{
					$Valor=0;$Valor2=0;
					$Valor=ObtienePerdidadDeduc($Cod,$FilaValor[cod_ley],$Tms,$ValorMerma);
					if($FilaValor[cod_unidad]=='11')
						$FilaValor[nom_unidad]='KG';
					echo "<tr>";
					echo "<td class='TituloCabecera'>".$FilaValor[nom_ley]."</td>";
					echo "<td class='TituloCabecera' align='center'>".$FilaValor[nom_unidad]."</td>";					
					echo "<td align='right'>".number_format($Valor,0,',','.')."</td>";
					if($FilaValor[cod_unidad]=='13')
					{
						$ValorLey=$Valor/$Tms*100;
						$Unidad="%";
					}
					else
					{
						$ValorLey=$Valor/$Tms*100/1000;	
						$Unidad="Grs/Ton";
					}
					echo "<td align='right' class='TituloCabecera'>".$Unidad."</td>";
					echo "<td align='right'>".number_format($ValorLey,3,',','.')."</td>";
					//echo "<td align='right'>".number_format(($Valor-$Valor2),0,',','.')."</td>";					
					echo "</tr>";
					//$TotPerdDeduc=$TotPerdDeduc+($Valor-$Valor2);
					$ValorDos=ObtienePerdidadDeduc($Cod,$FilaValor[cod_ley],$Tms,$ValorMerma);
					echo "<tr>";					
					echo "<td class='TituloCabecera'>".$FilaValor[nom_ley]."</td>";
					echo "<td class='TituloCabecera' align='center'>".$FilaValor[nom_unidad]."</td>";					
					echo "<td align='right'>".number_format($ValorDos,0,',','.')."</td>";
					echo "<td align='right'>&nbsp;</td>";
					echo "<td align='right'>&nbsp;</td>";
					echo "</tr>";
				}
		   ?>
		   <!--<tr width="20%">
		     <td colspan="4" class="pie_tabla_bold">P&eacute;rdidas Deducciones (US$)</td>
		     <td class="pie_tabla_bold" align="right"><? //echo number_format($TotPerdDeduc,8,',','.');?>&nbsp;</td>-->
	      </tr>
	  </table>
		<br>
		<table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
          <tr>
            <td width="20%" class="TituloCabecera">TOTAL PAGABLE</td>
            <td width="10%" class="TituloCabecera">&nbsp;</td>
            <td align="center" class="TituloCabecera"><? echo $NomOrigen;?></td>
            <td align="center" class="TituloCabecera"><? echo $DatosAnalisis;?></td>
            <td align="center" class="TituloCabecera">DIFERENCIA</td>
          </tr>
		  <?
				$Consulta="select distinct t1.cod_ley,t2.nombre_subclase as nom_ley,corr,t3.nombre_subclase as nom_unidad,t1.cod_unidad from pcip_eva_negocios_material t1 ";
				$Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_ley=t2.cod_subclase ";
				$Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
				$Consulta.="where t1.corr='".$Cod."' order by t1.corr,t1.cod_ley";
				//echo "consulta principal:  ".$Consulta."<br>";
				$RespValor=mysqli_query($link, $Consulta);
				while($FilaValor=mysql_fetch_array($RespValor))
				{
					$Valor=0;$Valor2=0;
					//echo "tipoanalisis:  ".$TipoAnalisis."<br>";
						$Valor=ObtienePerdidadDeduc2($Cod,$FilaValor[cod_ley],$TipoAnalisis,$Tms,$ValorMerma,$ValorMermaAux);//ANALISIS OTRAS
						$ValorUno=ObtienePerdidadDeduc2($Cod,$FilaValor[cod_ley],$TipoAnalisisAux,$Tms,$ValorMerma,$ValorMermaAux);//ANALISIS COMPRA ANALISIS 1	
					echo "<tr>";
					echo "<td class='TituloCabecera'>".$FilaValor[nom_ley]."</td>";
					echo "<td class='TituloCabecera' align='center'>US$</td>";					
					echo "<td align='right'>".number_format($ValorUno,0,',','.')."</td>";
					echo "<td align='right'>".number_format($Valor,0,',','.')."</td>";
					echo "<td align='right'>".number_format(($ValorUno-$Valor),0,',','.')."</td>";
					echo "</tr>";
					//$TotPerdDeduc=$TotPerdDeduc+($Valor-$Valor2);
				}
					
			   $TotDifCargos=0;
			   $Consulta="select distinct t2.cod_subclase as cod_cargo,t2.nombre_subclase as nom_cargo,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_costos t1 ";
			   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31039' and t1.cod_tipo=t2.cod_subclase ";
			   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
			   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_costo='1' order by cod_tipo";
			   //echo $Consulta;
			   $Resp=mysqli_query($link, $Consulta);
			   while($Fila=mysql_fetch_array($Resp))
			   {
					$Valor1=ValorCostos($Cod,$TipoAnalisisAux,$Fila[cod_cargo],$Tms);
					$Valor2=ValorCostos($Cod,$TipoAnalisis,$Fila[cod_cargo],$Tms);
					$Dif=$Valor1-$Valor2;
					$TotDifCargos=$TotDifCargos+$Dif;
			   ?>
				  <tr>
					<td width="20%" class='TituloCabecera'><strong><? echo strtoupper($Fila[nom_cargo]);?></strong></td>
					<td width="10%" align="center" class='TituloCabecera'><strong>US$/T</strong></td>
					<td align="right"><? echo number_format($Valor1,7,',','.');?>&nbsp;</td>
					<td align="right"><? echo number_format($Valor2,7,',','.');?>&nbsp;</td>
					<td align="right"><? echo number_format($Dif,7,',','.');?>&nbsp;</td>
				  </tr>
			   <?
			   }
				$Valor1=ValorTransp($Cod,$TipoAnalisisAux);
				$Valor2=ValorTransp($Cod,$TipoAnalisis);
				$Dif=$Valor1-$Valor2;
				$TotDifCargos=$TotDifCargos+$Dif;
			   ?>
				  <tr>
					<td width="20%" class='TituloCabecera'><strong>TRANSPORTE</strong></td>
					<td width="10%" align="center" class='TituloCabecera'><strong>US$/T</strong></td>
					<td align="right"><? echo number_format($Valor1,7,',','.');?>&nbsp;</td>
					<td align="right"><? echo number_format($Valor2,7,',','.');?>&nbsp;</td>
					<td align="right"><? echo number_format($Dif,7,',','.');?>&nbsp;</td>
				  </tr>
          <tr>
            <td colspan="4" class="pie_tabla_bold">Cargos (US$)</td>
            <td align="right" class="pie_tabla_bold"><? echo number_format($TotDifCargos,8,',','.');?>&nbsp;</td>
          </tr>
        </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td class="titulotablanaranja">TOTAL PERDIDAS EN&nbsp;<? echo number_format($Tms,0,',','.');?>&nbsp;TMS</td>
           <td width="24%" align="right" class="titulotablanaranja">US$</td>
           <td align="right" width="29%" class="titulotablanaranja"><? echo number_format(($TotPerdDeduc+$TotDifCargos)*$Tms,7,',','.')?>&nbsp;</td>
         </tr>
      </table>
		<br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
          <tr>
            <td align="center" class="pie_tabla_bold">
		<?
		if($Origen!=1)
		{
		?>	
        <table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
          <tr>
            <td colspan="3" align="center" class="pie_tabla_bold">Precio Compra </td>
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
            <td colspan="3" align="center" class="pie_tabla_bold">Precio Venta N�<? echo $i;?> </td>
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
function ValorCostos($Cod,$TipoAnalisis,$CodTipo,$Tms)
{

   $Consulta="select t1.valor,t1.cod_unidad from pcip_eva_negocios_costos t1 ";
   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$TipoAnalisis."' and t1.cod_tipo='".$CodTipo."' and t1.cod_tipo_costo='1' order by cod_tipo";
   //echo $Consulta;
   $RespValor=mysqli_query($link, $Consulta);
   if($FilaValor=mysql_fetch_array($RespValor))
   {
		$Valor=$FilaValor[valor];
		$Valor=ConvertirAUS($FilaValor[cod_unidad],$FilaValor[valor],$Tms);
   }
   else
	$Valor=0;
   return($Valor);
}
function ValorTransp($Cod,$TipoAnalisis)
{

   $Consulta="select sum(t1.valor) as valor from pcip_eva_negocios_transporte t1 ";
   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$TipoAnalisis."' ";
   //echo $Consulta;
   $RespValor=mysqli_query($link, $Consulta);
   if($FilaValor=mysql_fetch_array($RespValor))
   	$Valor=$FilaValor[valor];
   else
	$Valor=0;
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
function CaracteristicasMaterial($Codigo,$Ley,$TipoAnalisis,$Merma,$Tms,$MermaAnalisis,$Unidad)
{				
	$ConsultaMaterial="select * from pcip_eva_negocios_material where corr='".$Codigo."' and cod_ley='".$Ley."' ";
	$RespMaterial=mysql_query($ConsultaMaterial);
	while($FilaMaterial=mysql_fetch_array($RespMaterial))
	{
		$ValorInicial=ConvertirAFino($Unidad,$FilaMaterial[valor],$Tms);	
		//echo "Valor:  mmuestra ".$FilaMaterial[valor]."  ".$ValorInicial."<br>";
	}
	//APLICAMOS MERMA A LOS FINOS INICIALES	
	//echo "merma:   ".$MermaAnalisis."<br>";
	$ValorMerma=$ValorInicial*(1-($MermaAnalisis/100));
	echo "valor deapues de merma:  ".$ValorMerma."<br>";	
	return($ValorMerma);
}
function ConvertirAFino($CodUnidad,$Valor,$Tms)//CAMBIOS DE LOS FINOS INICIALES CON % Y GRS/TON � KG7/TON
{
	switch($CodUnidad)
	{
		case "12"://TMS 
		case "14"://KG
		case "10"://GRS/TON
		case "22"://KG/TON
			$Valor=$Tms*$Valor;			
		break;		
	}
	return($Valor);
}
function ObtienePerdidadDeduc2($Cod,$Ley,$TipoAnalisis,$Tms,$Merma,$Merma2)
{
	$ConsultaMaterial="select * from pcip_eva_negocios_material where corr='".$Cod."' and cod_ley='0'";
	$RespMaterial=mysql_query($ConsultaMaterial);
	if($FilaMaterial=mysql_fetch_array($RespMaterial));
	{
		if($FilaMaterial[cod_unidad]==12)
			$ValorMaterialTMS=$FilaMaterial[valor];//VALOR DE TMS SEGUN LOS MESES.		
		if($FilaMaterial[cod_unidad]==14)
			$ValorMaterialTMS=$FilaMaterial[valor]/1000;//VALOR DE TMS SEGUN LOS MESES.		
	}
	$Suma=0;
	$ConsultaValor="select corr,cod_ley,cod_division,cod_unidad,valor from pcip_eva_negocios_material t1 ";
	$ConsultaValor.="where t1.corr='".$Cod."' and cod_ley='".$Ley."'";
	//echo $Consulta."<br>";
	$RespValor=mysql_query($ConsultaValor);
	while($FilaValor=mysql_fetch_array($RespValor))
	{		
		if($FilaValor[cod_unidad]=='11')//DE GRAMOS A KG
			$ValorMaterial2=$FilaValor[valor]/1000;
		//echo $ValorMaterial2."<br>";
		if($FilaValor[cod_unidad]=='10')	
			$ValorMaterial2=$FilaValor[valor]/1000/1000;

		$Consulta="select * from pcip_eva_negocios_deduc_recup t1 ";
		$Consulta.="where t1.corr='".$FilaValor["corr"]."' and cod_tipo_analisis='".$TipoAnalisis."' and cod_ley='".$FilaValor[cod_ley]."'";
		//echo $Consulta."<br>";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($TipoAnalisis!='1')
			{
				if($Fila[cod_unidad]=='9')//% CAMBIOS DE UNIDADES EN DEDUCCIONES
				{				
					$Valor=$FilaValor[valor]*$Fila[valor]/100;
					$ValorCalculo=$FilaValor[valor]-$Valor;
				}
				if($Fila[cod_unidad]=='10')//GRS/TON CAMBIOS DE UNIDADES EN DEDUCCIONES
					$ValorCalculo=$ValorMaterial2*$Merma-$Fila[valor]*$ValorMaterialTMS*$Merma/1000;
			}
			if($TipoAnalisis=='1')
			{
				if($Fila[cod_unidad]=='9')//% CAMBIOS DE UNIDADES EN DEDUCCIONES
				{				
					$Valor=$FilaValor[valor]*$Fila[valor]/100;
					$ValorCalculo=$FilaValor[valor]-$Valor;
				}
				if($Fila[cod_unidad]=='10')//GRS/TON CAMBIOS DE UNIDADES EN DEDUCCIONES
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
					$Precios=ConversionPrecios($ValorPrecio,$ValorCalculo,$FilaPrecio[cod_unidad],$Merma,$Tms);
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
		if($FilaValor[cod_unidad]!='13')
			$Valor=$Valor+ConvertirAFino($FilaValor[cod_ley],$FilaValor[cod_unidad],$FilaValor[valor],$Tms);
		else
			$Valor=$Valor+$FilaValor[valor]-$ValorMerma;
	}
	return($Valor);
}
function ConvertirAUS($CodUnidad,$Precio,$Tms)
{
	switch($CodUnidad)
	{
		case "18"://US$/LB
			$Valor=($Precio/0.4536)*1000*$Tms;
		break;
		case "2"://US$/TMS
			$Valor=($Precio*$Tms)/1000;
		break;
		case "4"://US$Oz
			$Valor=$Precio*1000/31.103477*$Tms;
		break;
	}
	return($Valor);
}

?>