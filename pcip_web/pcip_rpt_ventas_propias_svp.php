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
<title>Reporte Ventas Propias Svp</title>
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

function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "C"://BUSCAR
			if(f.CmbTipoInforme.value=='-1')
			{
				alert('Debe Seleccionar Tipo Seleccion');
				f.CmbTipoInforme.focus();
				return;
			}
			if(parseInt(f.Mes.value)>parseInt(f.MesFin.value))
			{
				alert('Mes Hasta debe ser menor o igual Mes Desde');
				return;
			}
			f.action = "pcip_rpt_ventas_propias_svp.php?Buscar=S";
			f.submit();
		break;
		case "E":
			if(f.CmbTipoInforme.value=='-1')
			{
				alert('Debe Seleccionar Tipo Seleccion');
				f.CmbTipoInforme.focus();
				return;
			}
			URL='pcip_rpt_ventas_propias_svp_excel.php?CmbTipoInforme='+f.CmbTipoInforme.value+'&CmbOrdenProd='+f.CmbOrdenProd.value+"&CmbProd="+f.CmbProd.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value+"&MesFin="+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;
		case "R":
			f.action = "pcip_rpt_ventas_propias_svp.php";
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
.Estilo9 {font-size: 11px}
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
 EncabezadoPagina($IP_SERV,'ventas_propias.png')
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
    <td width="16%" height="17" class='formulario2'>Mostrar Por </td>
    <td class="formulario2" ><select name="CmbTipoInforme" onChange="Procesos('R')" >
      <option value="-1" selected="selected">Seleccionar</option>
      <?
	    $Consulta = "select nombre_subclase,cod_subclase,valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31006' order by cod_subclase ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbTipoInforme==$FilaTC["cod_subclase"])
			{
				echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				$Unidad=$FilaTC["valor_subclase1"];
			}
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
    </select></td>
  </tr>
  <tr>
    <td width="16%" height="17" class='formulario2'>Ordenes de Producci&oacute;n</td>
    <td class="formulario2" >
	<select name="CmbOrdenProd"onChange="Procesos('R')">
      <option value="-1" selected="selected">Todas</option>
      <?
	    $Consulta = "select distinct OPorden,OPdescripcion from pcip_svp_materiales t1 inner join pcip_svp_ordenesproduccion t2 on t1.MAorden=t2.OPorden order by t1.MAorden ";
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbOrdenProd==$FilaTC["OPorden"])
				echo "<option selected value='".$FilaTC["OPorden"]."'>".$FilaTC["OPorden"]."&nbsp;&nbsp;".ucfirst($FilaTC["OPdescripcion"])."</option>\n";
			else
				echo "<option value='".$FilaTC["OPorden"]."'>".$FilaTC["OPorden"]."&nbsp;&nbsp;".ucfirst($FilaTC["OPdescripcion"])."</option>\n";
		}
	  ?>
    </select>
	</td>
  </tr>
  <tr>
    <td width="16%" height="17" class='formulario2'>Productos</td>
    <td class="formulario2">
	<select name="CmbProd">
	<option value="-1" selected="selected">Todas</option>
	<?
	$Consulta = "select distinct t3.cod_sap,t3.nom_sap from pcip_svp_relmateriales t1 inner join pcip_svp_materiales t2 on t1.RMmaterial=t2.MAcodigo inner join pcip_svp_productos_sap t3 on t1.RMmaterialequivalente=t3.cod_sap ";
	$Consulta.= "where t2.MAorden<>''";
	if($CmbOrdenProd!='-1')
		$Consulta.= " and t2.MAorden='".$CmbOrdenProd."' order by cod_sap ";			
	$Resp=mysqli_query($link, $Consulta);
	while ($FilaTC=mysql_fetch_array($Resp))
	{
		if ($CmbProd==$FilaTC["cod_sap"])
			echo "<option selected value='".$FilaTC["cod_sap"]."'>".str_pad($FilaTC["cod_sap"],3,'0',STR_PAD_LEFT)."&nbsp;&nbsp;".ucfirst($FilaTC["nom_sap"])."</option>\n";
		else
			echo "<option value='".$FilaTC["cod_sap"]."'>".str_pad($FilaTC["cod_sap"],3,'0',STR_PAD_LEFT)."&nbsp;&nbsp;".ucfirst($FilaTC["nom_sap"])."</option>\n";
	}
	?>
	
    </select><? //echo $Consulta;?>    
	  </tr>	  
  <tr>
    <td height="25" class='formulario2'>A&ntilde;o</td>
    <td class='formulario2'><select name="Ano" id="Ano">
      <?
	for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
	{
		if ($i==$Ano)
			echo "<option selected value=\"".$i."\">".$i."</option>\n";
		else
			echo "<option value=\"".$i."\">".$i."</option>\n";
	}
?>
    </select>  </tr>
  <tr>
    <td height="25" class='formulario2'>Periodo</td>
    <td class='formulario2'>
Desde
  
  <select name="Mes" id="Mes">
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
Hasta

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
</select></tr>
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
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0" >
          <tr class="TituloTablaVerde">
            <td width="5%" align="center"><span class="Estilo9">Orden</span></td>
			<td width="20%" align="center"><span class="Estilo9">Descripci�n Orden</span></td>
            <td width="3%"align="center"><span class="Estilo9">C.Sap</span></td>
            <td width="20%" align="center"><span class="Estilo9">Descripci�n Sap</span></td>
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
				$Consulta.= " group by OPorden order by t3.cod_sap,MAorden "; 				
				//echo $Consulta."<br><br>";			
				$Resp=mysqli_query($link, $Consulta);
				while ($Fila=mysql_fetch_array($Resp))
				{
					$Consulta = "select t1.RMmaterialequivalente as cod_sap,t3.OPorden,t3.OPdescripcion,t4.nom_sap,t5.valor_subclase1 as vtmp from pcip_svp_relmateriales t1 ";
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
						echo "<td align='left'><span class='Estilo9'>".$FilaProd[OPdescripcion]."</span></td>";
						echo "<td align='right'><span class='Estilo9'>".$FilaProd[cod_sap]."&nbsp;</span></td>";
						echo "<td align='left'><span class='Estilo9'>".$FilaProd[nom_sap]."&nbsp;</span></td>";
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