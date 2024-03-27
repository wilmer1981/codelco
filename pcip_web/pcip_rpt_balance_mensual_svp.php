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
<title>Reporte Balanace Mensual</title>
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
		case "C"://BUSCA DISPONIBILIDAD EQUIPOS
			if(f.CmbEtapa.value=='-1')
			{
				alert('Debe Seleccionar Etapa');
				f.CmbEtapa.focus();
				return;
			}
			if(f.CmbTipoInforme.value=='-1')
			{
				alert('Debe Seleccionar Tipo Informe');
				f.CmbTipoInforme.focus();
				return;
			}

			if(parseInt(f.Mes.value)>parseInt(f.MesFin.value))
			{
				alert('Mes Hasta debe ser menor o igual Mes Desde');
				return;
			}
			f.action = "pcip_rpt_balance_mensual_svp.php?Buscar=S";
			f.submit();
		break;
		case "E":
			URL='pcip_rpt_balance_mensual_svp_excel.php?CmbTipoNegocio='+f.CmbTipoNegocio.value+'&CmbEtapa='+f.CmbEtapa.value+'&CmbTipoInforme='+f.CmbTipoInforme.value+'&CmbProd='+f.CmbProd.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value+"&MesFin="+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;
		case "R":
			f.action = "pcip_rpt_balance_mensual_svp.php";
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
 <? include("encabezado.php")?>

 <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
 <tr> 
 <td width="958" valign="top">
 <table width="760" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td height="30" align="right" ><table width="770" class="TablaPrincipal2">
            <tr valign="middle"> 
              <td width="271"><img src="archivos\Titulos\balance_mensual.png" width="240" height="16"></td>
              <td width="179" align="right"><font color="#9E5B3B">&nbsp;<font face="Times New Roman, Times, serif" size="2">Servidor 
                <? 
				$IP_SERV = $HTTP_HOST;
				echo $IP_SERV;?>
              </font></font></td>
              <td width="304" align="right"><font size="2" face="Times New Roman, Times, serif">&nbsp; 
                </font><font color="#9E5B3B" face="Times New Roman, Times, serif">&nbsp; 
                <? 
				//$Fecha_Hora = date("d-m-Y h:i");
				$FechaFor=FechaHoraActual();
				echo $FechaFor." hrs";
				?>
                </font></td>
            </tr>
        </table></td>
    </tr>
  </table>
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
    <td width="16%" height="17" class='formulario2'>Negocio</td>
    <td colspan="4" class="formulario2" ><select name="CmbTipoNegocio" >
        <option value="T" selected="selected">Todos</option>
        <?
	    $Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31005' order by cod_subclase ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbTipoNegocio==$FilaTC["cod_subclase"])
				echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
		?>
      </select></td>
  </tr>
  <tr>
    <td width="16%" height="17" class='formulario2'>Etapa</td>
    <td colspan="4" class="formulario2" ><select name="CmbEtapa">
      <option value="T" selected="selected">Todos</option>
      <?
	    $Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31004' order by cod_subclase ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEtapa==$FilaTC["cod_subclase"])
				echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
    </select></td>
  </tr>
  <tr>
    <td width="16%" height="17" class='formulario2'>Tipo Informe</td>
    <td width="31%" class="formulario2" ><select name="CmbTipoInforme" onChange="Procesos('R')" >
      <option value="-1" selected="selected">Seleccionar</option>
      <?
	    $Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31002' order by cod_subclase ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbTipoInforme==$FilaTC["cod_subclase"])
				echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
    </select></td>
    <td width="10%" class="formulario2" >Producto</td>
    <td width="35%" class="formulario2" ><select name="CmbProd" >
      <option value="T" selected="selected">Todos</option>
      <?
	    $Consulta = "select * from pcip_svp_productos_etapas where cod_tipo_balance='".$CmbTipoInforme."' order by cod_producto_etapa ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbProd==$FilaTC["cod_producto_etapa"])
				echo "<option selected value='".$FilaTC["cod_producto_etapa"]."'>".ucfirst($FilaTC["nom_producto_etapa"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_producto_etapa"]."'>".ucfirst($FilaTC["nom_producto_etapa"])."</option>\n";
		}
			?>
    </select></td>
    <td width="8%" class="formulario2" >&nbsp;</td>
  </tr>	  	  
  <tr>

    <td height="25" class='formulario2'>Periodo</td>
    <td colspan="4" class='formulario2'>A&ntilde;o
      <select name="Ano" id="Ano">
      <?
	for ($i=2003;$i<=date("Y");$i++)
	{
		if ($i==$Ano)
			echo "<option selected value=\"".$i."\">".$i."</option>\n";
		else
			echo "<option value=\"".$i."\">".$i."</option>\n";
	}
?>
    </select>
      Mes Desde
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
		  <?
		  	if($Buscar=='S')
			{	
				$Consulta = "select nombre_subclase,cod_subclase as cod_negocio from proyecto_modernizacion.sub_clase where cod_clase='31005' and cod_subclase='".$CmbTipoNegocio."' order by cod_subclase ";			
				//echo $Consulta;
				$RespNeg=mysqli_query($link, $Consulta);
				while ($FilaNeg=mysql_fetch_array($RespNeg))
				{
				   $CodNegocio=$FilaNeg["cod_subclase"];
				   $NomNegocio=$FilaNeg["nombre_subclase"];
					$CantCol=3;
					for($i=$Mes;$i<=$MesFin;$i++)
						$CantCol++;
					echo "<tr class='formulario2'>";
					echo "<td colspan='".($CantCol*2)."'><span class='Estilo9'>NEGOCIO: ".strtoupper($NomNegocio)."</strong></td>";
					echo "</tr>";
					$Consulta = "select nombre_subclase,cod_subclase as cod_etapa from proyecto_modernizacion.sub_clase where cod_clase='31004' ";
					if($CmbEtapa!='T')
						$Consulta.="and cod_subclase='".$CmbEtapa."'";
					$Consulta.= "order by cod_subclase ";			
					$RespEtapa=mysqli_query($link, $Consulta);
					while ($FilaEtapa=mysql_fetch_array($RespEtapa))
					{
						$CantCol=3;
						for($i=$Mes;$i<=$MesFin;$i++)
							$CantCol++;
						echo "<tr  class='CorteAmarillo'>";
						echo "<td colspan='".($CantCol*2)."'><span class='Estilo9'>".$FilaEtapa["nombre_subclase"]."</td>";
						echo "</tr>";
						?>
						  <tr class="TituloTablaVerde">
							<td width="10%" rowspan="2" align="center"><span class="Estilo9">Tipos</span></td>
							<?
							for($i=$Mes;$i<=$MesFin;$i++)
							{
								echo "<td width='6%' colspan='2' align='center'><span class='Estilo9'>".substr($Meses[$i-1],0,3)."</span></td>";
							}
							?>
							 <td colspan="2" align="center"><span class="Estilo9">ACUMULADO</span></td>
							 </tr>
						  <tr class="TituloTablaVerde">
							  <?
							for($i=$Mes;$i<=$MesFin;$i++)
							{
								echo "<td width='3%' align='center'><span class='Estilo9'>REAL</span></td>";
								echo "<td width='3%' align='center'><span class='Estilo9'>PROGRAMADA</span></td>";
							}
							?>
							<td width="20%" align="center"><span class="Estilo9">REAL</span></td>
							<td width="20%" align="center"><span class="Estilo9">PROGRAMADA</span></td>
						  </tr>
						<?
						$Consulta = "select nombre_subclase,cod_subclase as cod_bal from proyecto_modernizacion.sub_clase where cod_clase='31003' order by valor_subclase1 ";			
						$RespBal=mysqli_query($link, $Consulta);
						while ($FilaBal=mysql_fetch_array($RespBal))
						{
							$CantCol=3;
							for($i=$Mes;$i<=$MesFin;$i++)
								$CantCol++;
							echo "<tr class='CorteAmarillo'>";
							echo "<td colspan='".($CantCol*2)."'><span class='Estilo9'>".strtoupper($FilaBal["nombre_subclase"])."</td>";
							echo "</tr>";
							$Consulta = "select distinct t1.cod_producto_etapa,t2.nom_producto_etapa from pcip_svp_balance_mensual t1 inner join pcip_svp_productos_etapas t2 on t1.cod_producto_etapa=t2.cod_producto_etapa ";
							$Consulta.= "where t1.cod_etapa='".$FilaEtapa[cod_etapa]."' and t1.cod_tipo_negocio='".$FilaNeg[cod_negocio]."' and t1.cod_tipo_balance='".$FilaBal[cod_bal]."'";
							if($CmbTipoInforme!='-1')
								$Consulta.="and t1.cod_tipo_informe='".$CmbTipoInforme."'";
							if($CmbProd!='T')
								$Consulta.="and t1.cod_producto_etapa='".$CmbProd."'";		
							$Consulta.= "order by cod_producto_etapa ";
							//echo $Consulta."<br>";		
							$RespProd=mysqli_query($link, $Consulta);
							while ($FilaProd=mysql_fetch_array($RespProd))
							{
								echo "<tr>";
								echo "<td>".$FilaProd[nom_producto_etapa]."</td>";
								$Consulta = "select * from pcip_svp_balance_mensual t1 where t1.cod_etapa='".$FilaEtapa[cod_etapa]."' and t1.cod_tipo_negocio='".$FilaNeg[cod_negocio]."' and t1.cod_tipo_balance='".$FilaBal[cod_bal]."' and t1.cod_producto_etapa='".$FilaProd[cod_producto_etapa]."'";
								if($CmbTipoInforme!='-1')
									$Consulta.="and t1.cod_tipo_informe='".$CmbTipoInforme."'";	
								$Consulta.= "order by cod_producto_etapa ";
								//echo $Consulta."<br>";		
								$RespParam=mysqli_query($link, $Consulta);
								while ($FilaParam=mysql_fetch_array($RespParam))
								{
									$Total=0;
									for($i=$Mes;$i<=$MesFin;$i++)
									{
										$Consulta="SELECT VPcantidad FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND VPtm = ".$FilaParam[tramo]." AND VPorden = '".$FilaParam[num_orden]."' and VPtipinv='".$FilaParam[tipo_inventario]."' and VPmaterial='".$FilaParam[cod_material]."' and VPordes='".$FilaParam[ordes]."'";
										$Resp2=mysqli_query($link, $Consulta);
										//echo $Consulta."<br>";
										if($Fila2=mysql_fetch_array($Resp2))
											echo "<td align='right'>".number_format($Fila2[VPcantidad],3,',','.')."</td>";
										else
											echo "<td>&nbsp;</td>";
										echo "<td>&nbsp;</td>";	
										$Total=$Total+$Fila2[VPcantidad];
									}
									echo "<td align='right'>".number_format($Total,3,',','.')."</td>";
									echo "<td>&nbsp;</td>";
								}
								echo "</tr>";	
							}
						}
					}
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