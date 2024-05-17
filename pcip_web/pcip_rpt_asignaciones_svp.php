<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
if(!isset($AnoFin))
 	$AnoFin=date('Y');
if(!isset($MesFin))
 	$MesFin=date('m');
if(!isset($CmbMostrar))
	$CmbMostrar='P';			
?>
<html>
<head>
<title>Reporte Asignaciones Svp</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">

function GenerarExcel(ctto,emp)
{
		var URL = "../sget_web/sget_genera_excel.php?Ctto="+ctto+"&Empresa="+emp;
			window.open(URL,"","top=30,left=30,width=550,height=180,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				
}

function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "C"://BUSCA ASIGNACIONES
			if(f.CmbProd.value=='-1')
			{
				alert('Debe Seleccionar Producto');
				f.CmbProd.focus();
				return;
			}
			if(parseInt(f.Mes.value)>parseInt(f.MesFin.value))
			{
				alert('Mes Hasta debe ser menor o igual Mes Desde');
				return;
			}
			f.action = "pcip_rpt_asignaciones_svp.php?Buscar=S";
			f.submit();
		break;
		case "E":
			if(f.CmbProd.value=='-1')
			{
				alert('Debe Seleccionar Producto');
				f.CmbProd.focus();
				return;
			}
			URL='pcip_rpt_asignaciones_svp_excel.php?CmbProd='+f.CmbProd.value+'&CmbMostrar='+f.CmbMostrar.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value+"&MesFin="+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;
		case "R":
			f.action = "pcip_rpt_asignaciones_svp.php";
			f.submit();
			break;	
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=8";
		break;
	
	}
	
}

</script>
<style type="text/css">
<!--
.Estilo11 {font-size: 11px}
-->
</style>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'asignaciones.png')
?>
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
  <tr>
   <td  width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
   <td>
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02" >
	<tr>
		<td width="81%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td width="19%" align="right" class='formulario2'>
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span></a><a href="JavaScript:Procesos('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Procesos('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp; <a href="JavaScript:Procesos('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> <a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a></td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
  <tr>
    <td width="16%" height="17" class='formulario2'>Asignaciones</td>
    <td class="formulario2" >    
      <select name="CmbProd">
        <option value="-1" selected="selected">Seleccionar</option>
        <?
	    $Consulta = "select * from pcip_svp_asignacion where mostrar_asig='1' order by nom_asignacion ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
			if ($CmbProd==$Fila["cod_asignacion"])
			{
				echo "<option selected value='".$Fila["cod_asignacion"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
				//$Unidad=$Fila["cod_unidad"];
			}
			else
				echo "<option value='".$Fila["cod_asignacion"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
		}
			?>
      </select>    </td>
  </tr>
  <tr>
    <td height="25" class='formulario2'>Mostrar</td>
    <td class='formulario2'><select name="CmbMostrar">
      <?
	  	switch($CmbMostrar)
		{
			case "R":
				echo "<option value='R' selected>Resumen</option>";
				echo "<option value='D'>Desglose</option>";
			break;
			case "D":
				echo "<option value='R'>Resumen</option>";
				echo "<option value='D' selected>Desglose</option>";
			break;
			default:
				echo "<option value='R' selected>Resumen</option>";
				echo "<option value='D'>Desglose</option>";
			break;
		}
	  ?>
    </select>  </tr>
  
  <tr>
    <td height="25" class='formulario2'>A&ntilde;o </td>
    <td class='formulario2'><select name="Ano" id="Ano">
      <?
	for ($i=date("Y")-3;$i<=date("Y");$i++)
	{
		if ($i==$Ano)
			echo "<option selected value=\"".$i."\">".$i."</option>\n";
		else
			echo "<option value=\"".$i."\">".$i."</option>\n";
	}
?>
    </select></tr>	  
  <tr>

    <td height="25" class='formulario2'>Mes Desde </td>
    <td class='formulario2'><select name="Mes" id="Mes">
      <?
	for ($i=1;$i<=12;$i++)
	{
		if ($i==$Mes)
			echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		else
			echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
	}
?>
    </select>
      Mes Hasta
      <select name="MesFin">
        <?
	for ($i=1;$i<=12;$i++)
	{
		if ($i==$MesFin)
			echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		else
			echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
	}
?>
      </select>  </tr>
 </table>  </td>
  <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" ><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" ><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
    <br>
    <table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
        <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
        <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
        <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
      </tr>
      <tr>
        <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
        <td><table width="100%" border="1" cellpadding="0" cellspacing="1" >
          <tr>
		  	<?
			  $Col=1;
			  if($CmbMostrar=='D')
					$Col=2;
			?>
            <td width="74%" class="TituloTablaVerde" colspan="<? echo $Col;?>" rowspan="2" align="center"><span class="Estilo11">Asignaciones Reales de Producci&oacute;n </span></td>
            <td width="74%" class="TituloTablaVerde" rowspan="2" align="center">Unidad</td>
			<?
			$Consulta="select t1.cod_negocio,t2.nom_negocio from pcip_svp_asignaciones_titulos t1 inner join pcip_svp_negocios t2 on t1.cod_negocio=t2.cod_negocio where t1.cod_asignacion='".$CmbProd."' and t1.vigente='1' and t1.mostrar_asig='1' and t2.cod_negocio<>'4' and t2.mostrar_asig='1'  group by t1.cod_asignacion,t1.cod_negocio order by t2.orden";
			$Resp=mysqli_query($link, $Consulta);
			//echo $Consulta;
			while($Fila=mysql_fetch_array($Resp))
			{			    
				$NumCols=NumOrdenesPorNegocio($CmbProd,$Fila[cod_negocio]);
			?>
				<td width="11%" class="TituloTablaVerde" colspan="<? echo $NumCols;?>" align="center"><span class="Estilo11"><? echo $Fila[nom_negocio]?></span></td>
			<?	
			}
			?>
			
            <td width="13%" class="TituloTablaVerde" rowspan="2" align="center"><span class="Estilo11">TOTAL</span></td>
          </tr>
          <tr>
            <?			 
			$Consulta="select t1.cod_titulo,t1.nom_titulo from pcip_svp_asignaciones_titulos t1 inner join pcip_svp_negocios t2 on t1.cod_negocio=t2.cod_negocio ";
			$Consulta.="where t1.cod_asignacion='".$CmbProd."' and t1.vigente='1' and t1.mostrar_asig='1' and t2.cod_negocio<>'4' and t2.mostrar_asig='1'  group by t1.cod_titulo order by t2.orden,t1.orden";
			//echo $Consulta;
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
			?>	
				<td class="TituloTablaVerde"><? echo $Fila[nom_titulo];?>&nbsp;</td>
			<?
			}
			?>			
          </tr>
		  <?
		  if($CmbMostrar=='D')
		  {
		  	for($i=$Mes;$i<=$MesFin;$i++)
			{
				//$Consulta="select * from pcip_svp_asignaciones_productos where cod_asignacion='".$CmbProd."' and tipo='SVP' order by orden";
				$Consulta="select distinct t1.cod_asignacion,t1.cod_producto,t1.nom_asignacion,t1.orden,t1.tipo,t1.vigente,t1.origen,t1.cod_unidad from pcip_svp_asignaciones_productos t1 inner join pcip_svp_productos_procedencias t2 on t2.cod_procedencia=t1.cod_producto";
				$Consulta.=" where t1.cod_asignacion='".$CmbProd."' and t1.tipo='SVP' group by t1.cod_asignacion,t1.cod_producto order by t1.orden";
				//echo $Consulta;
				$Resp=mysqli_query($link, $Consulta);
				$Cant=1;
				while($Fila=mysql_fetch_array($Resp))
				{
					$TotalProd=0;
					if($Cant==1)
					{
						$CantFilas=0;
						$Consulta="select count(*) as tot_fil from pcip_svp_asignaciones_productos t1 inner join  pcip_svp_productos_procedencias t2 on t1.cod_producto=t2.cod_procedencia";
						$Consulta.=" where t1.cod_asignacion='".$CmbProd."' and t1.tipo='SVP' group by t1.cod_asignacion,t1.cod_producto order by t1.orden";
						//echo $Consulta."<br>";
						$RespCant=mysqli_query($link, $Consulta);
						while($FilaCant=mysql_fetch_array($RespCant))
							$CantFilas++;
						echo "<tr>";
						echo "<td rowspan='".$CantFilas."'>".$Meses[$i-1]."</td>";
					}
					 
					echo "<td>".$Fila[nom_asignacion]."</td>";
					echo"<td align='center'>".$Fila["cod_unidad"]."&nbsp;</td>";					
					//$Consulta="select cod_titulo as cod_tit,orden from pcip_svp_asignaciones_titulos where vigente='1' and cod_asignacion='".$CmbProd."' and cod_negocio<>'4' order by orden";
					$Consulta="select t1.cod_titulo as cod_tit,t1.orden,t2.cod_negocio from pcip_svp_asignaciones_titulos t1 inner join pcip_svp_negocios t2 on t1.cod_negocio=t2.cod_negocio ";
					$Consulta.="where t1.cod_asignacion='".$CmbProd."' and t1.vigente='1' and t2.cod_negocio<>'4' and t1.mostrar_asig='1' and t2.mostrar_asig='1' group by t1.cod_titulo order by t2.orden,t1.orden";
					//echo $Consulta."<br>";
					$RespTit=mysqli_query($link, $Consulta);					
					while($FilaTit=mysql_fetch_array($RespTit))
					{
						$Clase='';
						if($FilaTit[cod_negocio]=='1')
							$Clase="CorteAmarillo";
						if($FilaTit[cod_negocio]=='2')
							$Clase="FilaAbeja";				
						if($FilaTit[cod_negocio]=='3')
							$Clase="texto_bold";	
						$Consulta="select t1.cod_negocio,t2.origen,t2.nodo,t2.signo,t2.factor,t2.num_orden,t2.num_orden_relacionada,t2.cod_material,t2.consumo_interno,t2.vptm from pcip_svp_negocios t1 inner join pcip_svp_productos_procedencias t2 on t1.cod_negocio=t2.cod_negocio and t2.origen in ('SVP','CDV','ENA','PMN')";
						$Consulta.="where t2.cod_asignacion='".$CmbProd."' and t2.ano='".$Ano."' and t2.cod_procedencia='".$Fila["cod_producto"]."' and t2.cod_titulo='".$FilaTit[cod_tit]."' and t1.vigente='1' and t1.cod_negocio<>'4' and t1.mostrar_asig='1' order by t1.orden";
						//echo $Consulta."<br>";
						$Resp2=mysqli_query($link, $Consulta);$Cantidad=0;
						while($Fila2=mysql_fetch_array($Resp2))
						{
						  //echo "entrooooo<br>";
							if($Fila2[cod_negocio]=='1')
								$Clase="CorteAmarillo";
							if($Fila2[cod_negocio]=='2')
								$Clase="FilaAbeja";				
							if($Fila2[cod_negocio]=='3')
								$Clase="texto_bold";	
						    switch($Fila2[origen])							
							{
							  case "SVP":
										$Consulta="select VPcantidad from pcip_svp_valorizacproduccion where VPorden='".$Fila2[num_orden]."' and VPa�o='".$Ano."' and VPmes='".$i."' ";
										if(!is_null($Fila2[num_orden_relacionada])&&$Fila2[num_orden_relacionada]!=0)
											$Consulta.=" and VPordenrel='".$Fila2[num_orden_relacionada]."'";
										if(!is_null($Fila2[cod_material]))
											$Consulta.=" and VPmaterial='".$Fila2[cod_material]."'";
										if(!is_null($Fila2[consumo_interno]))
											$Consulta.=" and VPordes='".$Fila2[consumo_interno]."'";
										if(!is_null($Fila2[vptm])&&$Fila2[vptm]<>0)
											$Consulta.=" and vptm='".$Fila2[vptm]."'";
										//echo "SVP:   ".$Consulta."<br>"; 
										$Resp3=mysqli_query($link, $Consulta);$CantidadAux=0;$Cantidad=0;
										while($Fila3=mysql_fetch_array($Resp3))
										{
											$CantidadAux=($Fila3[VPcantidad])*$Fila2[factor];	
											if($Fila2["signo"]=='')
												$Fila2["signo"]='+';
											if($Fila2["signo"]=='+')
												$Cantidad=$Cantidad+$CantidadAux;
											else
											   	$Cantidad=$Cantidad-$CantidadAux;
										}
							  break;	
							  case "CDV":		
								$Consulta="select sum(kilos_finos) as kilos_finos from pcip_cdv_cuadro_diario_ventas where cod_producto='".$Fila2[num_orden]."' and ano='".$Ano."' and mes='".$i."' and ajuste='N' and tipo_venta='8'";
								$Resp3=mysqli_query($link, $Consulta);
								//echo "CDV:   ".$Consulta."<br>";
								while($Fila3=mysql_fetch_array($Resp3))
								{
									if($Fila2["signo"]=='')
										$Fila2["signo"]='+';
								    if($Fila2["signo"]=='+')
										$Cantidad=($Cantidad+$Fila3[kilos_finos])*$Fila2[factor];
									else	
										$Cantidad=($Cantidad-$Fila3[kilos_finos])*$Fila2[factor];
								}
								if($Cantidad!='0')
									$Cantidad=$Cantidad/1000;
							  break;
							  case "ENA":
							  case "PMN":		
								$Consulta="select ";
								switch($Fila2[num_orden_relacionada])
								{
									case "1":
										$Consulta.=" cobre ";
										break;
									case "2":
										$Consulta.=" plata ";
										break;
									case "3":
										$Consulta.=" oro ";
										break;										
									default:
										$Consulta.=" cobre ";
										break;
								}
								$Consulta.=" as kilos_finos from pcip_ena_datos_enabal where origen='".$Fila2[origen]."' and cod_flujo='".$Fila2[num_orden]."' and ano='".$Ano."' and mes='".$i."' and tipo_dato='F' and tipo_mov='".$Fila2["nodo"]."'";
								$Resp3=mysqli_query($link, $Consulta);
								while($Fila3=mysql_fetch_array($Resp3))
								{
									if($Fila2["signo"]=='')
										$Fila2["signo"]='+';
								    if($Fila2["signo"]=='+')
										$Cantidad=($Cantidad+$Fila3[kilos_finos])*$Fila2[factor];
									else	
										$Cantidad=($Cantidad-$Fila3[kilos_finos])*$Fila2[factor];
								}
								if($Cantidad!='0' && ($Fila2[num_orden_relacionada]==2 ||$Fila2[num_orden_relacionada]==3))
									$Cantidad=$Cantidad/1000;
							  break;
							}		
						}
						if($Cantidad!=0)
						{	 						   					
							echo "<td align='right' class='".$Clase."'>".number_format($Cantidad,3,',','.')."</td>";
							$TotalProd=$TotalProd+$Cantidad;
						}
						else
							echo "<td class='".$Clase."'>&nbsp;</td>";	
					}
					echo "<td align='right'>".number_format($TotalProd,3,',','.')."</td>";	
					echo "</tr>";
					$Cant++;
				}
			}
		  }
		  if($CmbMostrar=='R')
		  {
				$Consulta="select distinct t1.cod_asignacion,t1.cod_producto,t1.nom_asignacion,t1.orden,t1.tipo,t1.vigente,t1.origen,t1.cod_unidad from pcip_svp_asignaciones_productos t1 inner join pcip_svp_productos_procedencias t2 on t1.cod_producto=t2.cod_procedencia";
				$Consulta.=" where t1.cod_asignacion='".$CmbProd."' and t1.tipo='SVP' group by t1.cod_asignacion,t1.cod_producto order by t1.orden";
				//echo $Consulta;
				$Resp=mysqli_query($link, $Consulta);
				$Cant=1;
				while($Fila=mysql_fetch_array($Resp))
				{
					//echo $EncontroValor."<br>";
					$TotalProd=0;
					echo "<td>".$Fila[nom_asignacion]."</td>";
					echo"<td align='center'>".$Fila["cod_unidad"]."&nbsp;</td>";					
					//$Consulta="select cod_titulo as cod_tit,orden from pcip_svp_asignaciones_titulos where vigente='1' and cod_asignacion='".$CmbProd."' and cod_negocio<>'4' order by orden";
					$Consulta="select t2.cod_negocio,t1.cod_titulo as cod_tit,t1.orden from pcip_svp_asignaciones_titulos t1 inner join pcip_svp_negocios t2 on t1.cod_negocio=t2.cod_negocio ";
					$Consulta.="where t1.cod_asignacion='".$CmbProd."' and t1.vigente='1' and t1.mostrar_asig='1' and t2.cod_negocio<>'4' and t2.mostrar_asig='1' group by t1.cod_titulo order by t2.orden,t1.orden";
					$RespTit=mysqli_query($link, $Consulta);
					//echo $Consulta."<br>";
					while($FilaTit=mysql_fetch_array($RespTit))
					{
						$Clase='';
						if($FilaTit[cod_negocio]=='1')
							$Clase="CorteAmarillo";
						if($FilaTit[cod_negocio]=='2')
							$Clase="FilaAbeja";				
						if($FilaTit[cod_negocio]=='3')
							$Clase="texto_bold";	
						$Consulta="select t2.origen,t2.signo,t2.factor,t2.nodo,t2.num_orden,t2.num_orden_relacionada,t2.cod_material,t2.consumo_interno,t2.vptm from pcip_svp_negocios t1 inner join pcip_svp_productos_procedencias t2 on t1.cod_negocio=t2.cod_negocio and t2.origen in ('SVP','CDV','ENA','PMN')";
						$Consulta.="where t2.cod_asignacion='".$CmbProd."' and t2.ano='".$Ano."' and t2.cod_procedencia='".$Fila["cod_producto"]."' and t2.cod_titulo='".$FilaTit[cod_tit]."' and t1.vigente='1' and t1.cod_negocio<>'4' and t1.mostrar_asig='1' order by t1.orden";
						//if($Fila[nom_asignacion]=='CATODOS GRADO A')
						//echo $Consulta."<br>";
						$Resp2=mysqli_query($link, $Consulta);$Encontro='N';$Cantidad=0;
						while($Fila2=mysql_fetch_array($Resp2))
						{												
							switch($Fila2[origen])
							{
								case "SVP":								
										$Consulta="select VPcantidad from pcip_svp_valorizacproduccion where VPorden='".$Fila2[num_orden]."' and VPa�o='".$Ano."' and VPmes>='".$Mes."' and VPmes<='".$MesFin."'";
										if(!is_null($Fila2[num_orden_relacionada])&&$Fila2[num_orden_relacionada]!=0)
											$Consulta.=" and VPordenrel='".$Fila2[num_orden_relacionada]."'";
										if(!is_null($Fila2[cod_material]))
											$Consulta.=" and VPmaterial='".$Fila2[cod_material]."'";
										if(!is_null($Fila2[consumo_interno]))
											$Consulta.=" and VPordes='".$Fila2[consumo_interno]."'";
										if(!is_null($Fila2[vptm])&&$Fila2[vptm]<>0)
											$Consulta.=" and vptm='".$Fila2[vptm]."'";
											//echo $Consulta."<br>";
										$Resp3=mysqli_query($link, $Consulta);$Cantidad=0;
										while($Fila3=mysql_fetch_array($Resp3))
										{
											if($Fila2["signo"]=='')
												$Fila2["signo"]='+';
											if($Fila2["signo"]=='+')
												$Cantidad=$Cantidad+$Fila3[VPcantidad];
											else	
												$Cantidad=$Cantidad-$Fila3[VPcantidad];
										}
								break;	
								case "CDV":
										$Consulta="select kilos_finos from pcip_cdv_cuadro_diario_ventas where cod_producto='".$Fila2[num_orden]."' and ano='".$Ano."' and mes>='".$Mes."' and mes<='".$MesFin."' and ajuste='N' and tipo_venta='8'";
										//echo $Consulta."<br>";
										$Resp3=mysqli_query($link, $Consulta);
										while($Fila3=mysql_fetch_array($Resp3))
										{
											if($Fila2["signo"]=='')
												$Fila2["signo"]='+';
											if($Fila2["signo"]=='+')
												$Cantidad=$Cantidad+$Fila3[kilos_finos];
											else
												$Cantidad=$Cantidad-$Fila3[kilos_finos];
										}
										if($Cantidad!='0')
											$Cantidad=$Cantidad/1000;
								break;	
								case "ENA":
								case "PMN";
										$Consulta="select ";
										switch($Fila2[num_orden_relacionada])
										{
											case "1":
												$Consulta.=" cobre ";
												break;
											case "2":
												$Consulta.=" plata ";
												break;
											case "3":
												$Consulta.=" oro ";
												break;										
											default:
												$Consulta.=" cobre ";
												break;
										}
										$Consulta.=" as kilos_finos from pcip_ena_datos_enabal where origen='".$Fila2[origen]."' and cod_flujo='".$Fila2[num_orden]."' and ano='".$Ano."' and mes='".$Mes."' and tipo_dato='F' and tipo_mov='".$Fila2["nodo"]."'";
										$Resp3=mysqli_query($link, $Consulta);
										//echo $Consulta."<br>";
										while($Fila3=mysql_fetch_array($Resp3))
										{
											if($Fila2["signo"]=='')
												$Fila2["signo"]='+';
											if($Fila2["signo"]=='+')
												$Cantidad=($Cantidad+$Fila3[kilos_finos])*$Fila2[factor];
											else	
												$Cantidad=($Cantidad-$Fila3[kilos_finos])*$Fila2[factor];
										}
										if($Cantidad!='0' && ($Fila2[num_orden_relacionada]==2 ||$Fila2[num_orden_relacionada]==3))
											$Cantidad=$Cantidad/1000;
								break;
							}	
						}
						if($Cantidad!=0)
						{
							echo "<td align='right' class='".$Clase."'>".number_format($Cantidad,3,',','.')."</td>";
							$TotalProd=$TotalProd+$Cantidad;
						}
						else
							echo "<td class='".$Clase."'>&nbsp;</td>";
					}									
					echo "<td align='right'>".number_format($TotalProd,3,',','.')."</td>";	
					echo "</tr>";
				}
		  }		  
		  ?>
        </table></td>
        <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
      </tr>
      <tr>
        <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
        <td height="15"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
        <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
      </tr>
    </table></td>
 </tr>
  </table>
	<? include("pie_pagina.php")?>

</form>
</body>
</html>
<?
function NumOrdenesPorNegocio($CodAsig,$CodNeg)
{
	$Consulta="select count(*) as cantidad from pcip_svp_asignaciones_titulos where vigente='1' and cod_asignacion='".$CodAsig."' and cod_negocio='".$CodNeg."' and mostrar_asig='1'";
	//echo $Consulta;
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
		return($Fila[cantidad]);
	else
		return(0);	
		
}
//function ProductoSinValor($CmbProd,$Ano,$Mes,$MesFin)
//{
//	$Consulta="select distinct t1.cod_asignacion,t1.cod_producto,t1.nom_asignacion,t1.orden,t1.tipo,t1.vigente,t1.origen,t1.cod_unidad from pcip_svp_asignaciones_productos t1 inner join pcip_svp_productos_procedencias t2 on t1.cod_producto=t2.cod_procedencia";
//	$Consulta.=" where t1.cod_asignacion='".$CmbProd."' and t1.tipo='SVP' group by t1.cod_asignacion,t1.cod_producto order by t1.orden";
//	//echo $Consulta;
//	$Resp=mysqli_query($link, $Consulta);
//	$Cant=1;
//	while($Fila=mysql_fetch_array($Resp))
//	{
//		$TotalProd=0;
//		//$Consulta="select cod_titulo as cod_tit,orden from pcip_svp_asignaciones_titulos where vigente='1' and cod_asignacion='".$CmbProd."' and cod_negocio<>'4' order by orden";
//		$Consulta="select t2.cod_negocio,t1.cod_titulo as cod_tit,t1.orden from pcip_svp_asignaciones_titulos t1 inner join pcip_svp_negocios t2 on t1.cod_negocio=t2.cod_negocio ";
//		$Consulta.="where t1.cod_asignacion='".$CmbProd."' and t1.vigente='1' and t2.cod_negocio<>'4' and t2.mostrar_asig='1' group by t1.cod_titulo order by t2.orden,t1.orden";
//		$RespTit=mysqli_query($link, $Consulta);
//		//echo $Consulta."<br>";
//		while($FilaTit=mysql_fetch_array($RespTit))
//		{
//			$Consulta="select t2.origen,t2.signo,t2.factor,t2.num_orden,t2.num_orden_relacionada,t2.cod_material,t2.consumo_interno,t2.vptm from pcip_svp_negocios t1 inner join pcip_svp_productos_procedencias t2 on t1.cod_negocio=t2.cod_negocio and t2.origen in ('SVP','CDV')";
//			$Consulta.="where t2.cod_asignacion='".$CmbProd."' and t2.ano='".$Ano."' and t2.cod_procedencia='".$Fila["cod_producto"]."' and t2.cod_titulo='".$FilaTit[cod_tit]."' and t1.vigente='1' and t1.cod_negocio<>'4' and t1.mostrar_asig='1' order by t1.orden";
//			//if($Fila[nom_asignacion]=='CATODOS GRADO A')
//			//echo $Consulta."<br>";
//			$Resp2=mysqli_query($link, $Consulta);$Encontro='N';$Cantidad=0;
//			while($Fila2=mysql_fetch_array($Resp2))
//			{			
//				switch($Fila2[origen])
//				{
//					case "SVP":								
//							$Consulta="select VPcantidad from pcip_svp_valorizacproduccion where VPorden='".$Fila2[num_orden]."' and VPa�o='".$Ano."' and VPmes>='".$Mes."' and VPmes<='".$MesFin."'";
//							if(!is_null($Fila2[num_orden_relacionada])&&$Fila2[num_orden_relacionada]!=0)
//								$Consulta.=" and VPordenrel='".$Fila2[num_orden_relacionada]."'";
//							if(!is_null($Fila2[cod_material]))
//								$Consulta.=" and VPmaterial='".$Fila2[cod_material]."'";
//							if(!is_null($Fila2[consumo_interno]))
//								$Consulta.=" and VPordes='".$Fila2[consumo_interno]."'";
//							if(!is_null($Fila2[vptm])&&$Fila2[vptm]<>0)
//								$Consulta.=" and vptm='".$Fila2[vptm]."'";
//							$Resp3=mysqli_query($link, $Consulta);
//							while($Fila3=mysql_fetch_array($Resp3))
//							{
//								if($Fila2["signo"]=='+')
//									$Cantidad=$Cantidad+$Fila3[VPcantidad];
//								else	
//									$Cantidad=$Cantidad-$Fila3[VPcantidad];	
//																																
//								if($Cantidad!=0)
//									$EncValor='S';
//								else
//									$EncValor='N';			
//							}							
//					break;	
//					case "CDV":
//							$Consulta="select kilos_finos from pcip_cdv_cuadro_diario_ventas where cod_producto='".$Fila2[num_orden]."' and ano='".$Ano."' and mes>='".$Mes."' and mes<='".$MesFin."' and ajuste='N' and tipo_venta='8'";
//							//echo $Consulta."<br>";
//							$Resp3=mysqli_query($link, $Consulta);
//							while($Fila3=mysql_fetch_array($Resp3))
//							{
//								if($Fila2["signo"]=='+')
//									$Cantidad=$Cantidad+$Fila3[kilos_finos];
//								else
//									$Cantidad=$Cantidad-$Fila3[kilos_finos];
//																									
//								if($Cantidad!=0)
//									$EncValor='S';
//								else
//									$EncValor='N';			
//							}
//					break;	
//					case "ENA":
//					case "PMN";
//							$Consulta="select ";
//							switch($Fila2[num_orden_relacionada])
//							{
//								case "1":
//									$Consulta.=" cobre ";
//									break;
//								case "2":
//									$Consulta.=" plata ";
//									break;
//								case "3":
//									$Consulta.=" oro ";
//									break;										
//								default:
//									$Consulta.=" cobre ";
//									break;
//							}
//							$Consulta.=" as kilos_finos from pcip_ena_datos_enabal where origen='".$Fila2[origen]."' and ano='".$Ano."' and mes='".$Mes."' and tipo_dato='F' and tipo_mov='2' ";
//							$Resp3=mysqli_query($link, $Consulta);
//							//echo $Consulta."<br>";
//							while($Fila3=mysql_fetch_array($Resp3))
//							{
//								if($Fila2["signo"]=='+')
//									$Cantidad=($Cantidad+$Fila3[kilos_finos])*$Fila2[factor];
//								else	
//									$Cantidad=($Cantidad-$Fila3[kilos_finos])*$Fila2[factor];
//									
//								if($Cantidad!=0)
//									$EncValor='S';
//								else
//									$EncValor='N';			
//							}																	
//					break;
//				}	
//			}			
//		}
//	}
//	return($EncValor);				
//}
?>