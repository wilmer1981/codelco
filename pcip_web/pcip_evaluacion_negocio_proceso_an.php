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
	$Datos=explode('||',$Fila[analisis]);
	while(list($c,$v)=each($Datos))
	{
		if($v!='')
		{
			$Datos2=explode('~',$v);
			$TipoAnalisis=$Datos2[0];
			$Div=$Datos2[1];
			if(($Origen==1&&$TipoAnalisis!=2))
				Analisis($Cod,$Origen,$TipoAnalisis,$Div,$Tms); 
			if(($Origen==2&&$TipoAnalisis!=3))
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
//echo "COD ANALISIS: ".$TipoAnalisis."<BR>";
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
  <tr><td align="center" bgcolor="#CCCCCC"><h3>ANALISIS&nbsp;<? echo $NomOrigen." - ".$DatosAnalisis;?></h3></td></tr>
  <tr>
   <td align="center">   
		<table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
		   <tr>
			 <td>&nbsp;</td>
			 <td>&nbsp;</td>
			 <td align="center" class="TituloCabecera"><? echo $NomOrigen;?></td>
			 <td align="center" class="TituloCabecera"><? echo $DatosAnalisis;?></td>
			 <td align="center" class="TituloCabecera">DIFERENCIA</td>
		   </tr>
		   <? 
		   		$TotPerdDeduc=0;
				$ArrayCalculos=array();
				ObtienePerdidadDeduc($Cod,&$ArrayCalculos,$TipoAnalisisAux,$Div,$Tms,$i);
		   		$ArrayCalculos2=array();
				ObtienePerdidadDeduc($Cod,&$ArrayCalculos2,$TipoAnalisis,$Div,$Tms,$i);
				$Consulta="select distinct t1.cod_ley,t2.nombre_subclase as nom_ley from pcip_eva_negocios_material t1 ";
				$Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31037' and t1.cod_ley=t2.cod_subclase ";
				$Consulta.="where t1.corr='".$Cod."' order by t1.corr,t1.cod_ley";
				//echo $Consulta;
				$RespValor=mysqli_query($link, $Consulta);
				while($FilaValor=mysql_fetch_array($RespValor))
				{
					$Valor=0;$Valor2=0;
					echo "<tr>";
					echo "<td class='TituloCabecera'>".$FilaValor[nom_ley]."</td>";
					echo "<td class='TituloCabecera'>US$/T</td>";
					reset($ArrayCalculos);
					reset($ArrayCalculos2);
					while(list($c,$v)=each($ArrayCalculos))
					{
						if($v[0]==$FilaValor[cod_ley])
							$Valor=$Valor+$v[2];
						if($ArrayCalculos2[$c][0]==$FilaValor[cod_ley]&&$ArrayCalculos2[$c][4]=='S')
							$Valor2=$Valor2+$ArrayCalculos2[$c][2];
					}
					echo "<td align='right'>".number_format($Valor,7,',','.')."</td>";
					echo "<td align='right'>".number_format($Valor2,7,',','.')."</td>";
					echo "<td align='right'>".number_format(($Valor-$Valor2),7,',','.')."</td>";
					echo "</tr>";
					$TotPerdDeduc=$TotPerdDeduc+($Valor-$Valor2);
				}
		   ?>
		   <tr width="20%">
		     <td colspan="4" class="pie_tabla_bold">P&eacute;rdidas Deducciones (US$)</td>
		     <td class="pie_tabla_bold" align="right"><? echo number_format($TotPerdDeduc,8,',','.');?>&nbsp;</td>
	      </tr>
	  </table>
		<br>
		<table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
          <tr>
            <td width="20%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td align="center" class="TituloCabecera"><? echo $NomOrigen;?></td>
            <td align="center" class="TituloCabecera"><? echo $DatosAnalisis;?></td>
            <td align="center" class="TituloCabecera">DIFERENCIA</td>
          </tr>
		  <?
			   $TotDifCargos=0;
			   $Consulta="select distinct t2.cod_subclase as cod_cargo,t2.nombre_subclase as nom_cargo,t3.nombre_subclase as nom_unidad from pcip_eva_negocios_costos t1 ";
			   $Consulta.="inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31039' and t1.cod_tipo=t2.cod_subclase ";
			   $Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31051' and t1.cod_unidad=t3.cod_subclase ";
			   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_costo='1' order by cod_tipo";
			   //echo $Consulta;
			   $Resp=mysqli_query($link, $Consulta);
			   while($Fila=mysql_fetch_array($Resp))
			   {
					$Valor1=ValorCostos($Cod,$TipoAnalisisAux,$Fila[cod_cargo]);
					$Valor2=ValorCostos($Cod,$TipoAnalisis,$Fila[cod_cargo]);
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
function ValorCostos($Cod,$TipoAnalisis,$CodTipo)
{

   $Consulta="select t1.valor from pcip_eva_negocios_costos t1 ";
   $Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$TipoAnalisis."' and t1.cod_tipo='".$CodTipo."' and t1.cod_tipo_costo='1' order by cod_tipo";
   //echo $Consulta;
   $RespValor=mysqli_query($link, $Consulta);
   if($FilaValor=mysql_fetch_array($RespValor))
   	$Valor=$FilaValor[valor];
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
function ObtienePerdidadDeduc($Cod,$ArrayCalculos,$TipoAnalisisAux,$Div,$Tms,$CantPrecio)
{
	reset($ArrayCalculos);
	while(list($c,$v)=each($ArrayCalculos))
	{
		$v[0]='';
		$v[1]='';
		$v[2]=0;
		$v[3]=0;
		$v[4]='';
	}
	//CARACTERISTICAS DEL MATERIAL A FINO
	$Consulta="select cod_ley,cod_division,cod_unidad,valor from pcip_eva_negocios_material t1 ";
	$Consulta.="where t1.corr='".$Cod."' order by cod_division,cod_ley";
	//echo $Consulta."<br>";
	$RespValor=mysqli_query($link, $Consulta);
	while($FilaValor=mysql_fetch_array($RespValor))
	{		
		$Fino=ConvertirAFino($FilaValor[cod_ley],$FilaValor[cod_unidad],$FilaValor[valor],$Tms);
		$Clave=$FilaValor[cod_division].$FilaValor[cod_ley];
		$ArrayCalculos[$Clave][0]=$FilaValor[cod_ley];
		$ArrayCalculos[$Clave][1]=$FilaValor[cod_unidad];
		$ArrayCalculos[$Clave][2]=$Fino;//FINO CALCULADO
		$ArrayCalculos[$Clave][3]=$Fino;//FINO INICIAL
		$ArrayCalculos[$Clave][4]='N';//VERIFICA SI EXISTEN DATOS DE DECUCCIONES Y PRECIOS
	}
	
	//TIPOS RECUPERACIONES A FINO <> UNICO
	reset($ArrayCalculos);
	while(list($c,$v)=each($ArrayCalculos))
	{
	   $FinoAnt=$v[2];
	   $Consulta="select t1.cod_ley,t1.cod_unidad,t1.valor from pcip_eva_negocios_deduc_recup t1 ";
	   $Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31038' and t1.cod_tipo=t2.cod_subclase and t2.valor_subclase1<>'U'";
	   $Consulta.=" where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$TipoAnalisisAux."' and t1.cod_ley='".$v[0]."' order by t2.valor_subclase2";
	   //echo $Consulta."<br>";
	   $RespValor=mysqli_query($link, $Consulta);
	   while($FilaValor=mysql_fetch_array($RespValor))
	   {
			//if($v[0]==1)
			//	echo $FinoAnt."<br>";
			$Fino=ConvertirAFino($FilaValor[cod_ley],$FilaValor[cod_unidad],$FilaValor[valor],$FinoAnt);
	   		$ArrayCalculos[$c][2]=$Fino;
			$ArrayCalculos[$c][4]='S';
			$FinoAnt=$Fino;
	   }		
	}

	//TIPOS RECUPERACIONES A FINO UNICO
	reset($ArrayCalculos);
	while(list($c,$v)=each($ArrayCalculos))
	{
	   $Consulta="select t1.cod_ley,t1.cod_unidad,t1.valor from pcip_eva_negocios_deduc_recup t1 ";
	   $Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31038' and t1.cod_tipo=t2.cod_subclase and t2.valor_subclase1='U'";
	   $Consulta.=" where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$TipoAnalisisAux."' and t1.cod_ley='".$v[0]."' order by t2.valor_subclase2";
	   //echo $Consulta."<br>";
	   $RespValor=mysqli_query($link, $Consulta);
	   if($FilaValor=mysql_fetch_array($RespValor))
	   {
	   		$Fino=ConvertirAFino($FilaValor[cod_ley],$FilaValor[cod_unidad],$FilaValor[valor],$v[2]);
	   		//echo "FINO:".$Fino."<br>";
			$ArrayCalculos[$c][2]=$Fino;
			$ArrayCalculos[$c][4]='S';
	   }		
	}
	//PERDIDAS US$
	if($CantPrecio==1)
		$PrecioBusq='t1.valor';
	else
		$PrecioBusq='t1.valor2';	
	reset($ArrayCalculos);
	while(list($c,$v)=each($ArrayCalculos))
	{
		$Consulta="select t1.cod_unidad,".$PrecioBusq." as valor from pcip_eva_negocios_precios t1 ";
		$Consulta.="where t1.corr='".$Cod."' and t1.cod_tipo_analisis='".$TipoAnalisisAux."' and t1.cod_tipo='".$v[0]."'";
		//echo $Consulta."<br>";
		$RespValor=mysqli_query($link, $Consulta);
		if($FilaValor=mysql_fetch_array($RespValor))
		{
			$Fino=ConvertirAUS($FilaValor[cod_unidad],$FilaValor[valor],($v[3]-$v[2]));
			if($Tms<0)
			{
				$ArrayCalculos[$c][2]=$Fino/$Tms;
				$ArrayCalculos[$c][4]='S';
			}
			else
				$ArrayCalculos[$c][2]=0;
		}
	}
	/*if($TipoAnalisisAux=='42')
	{
		reset($ArrayCalculos);
		while(list($c,$v)=each($ArrayCalculos))
		{
			if($v[0]==1)
			{
				echo "ORIGEN: ".$c."<br>";
				echo "LEY: ".$v[0]."<br>";
				echo "UNIDAD: ".$v[1]."<br>";
				echo "FINO INICIAL: ".$v[3]."<br>";
				echo "VALOR: ".$v[2]."<br>";
				echo "PERDIDA: ".($v[3]-$v[2])."<br><br>";
			}
		}
	}*/
}
function ConvertirAFino($CodLey,$CodUnidad,$Valor,$Tms)
{
	switch($CodUnidad)
	{
		case "9"://%
			$Valor=($Valor*$Tms)/100;
		break;
		case "10"://grs/ton
			$Valor=($Valor*$Tms)/1000;
		break;
		case "3":
		break;
	}
	return($Valor);
}
function ConvertirAUS($CodUnidad,$Precio,$Perdida)
{
	switch($CodUnidad)
	{
		case "18"://US$/LB
			$Valor=($Precio/0.4536)*1000*$Perdida;
		break;
		case "2"://US$/TMS
			$Valor=($Precio*$Perdida)/1000;
		break;
		case "4"://US$Oz
			$Valor=$Precio*1000/31.103477*$Perdida;
		break;
	}
	return($Valor);
}

?>