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
<title>Reporte Recepciones Svp</title>
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
			if(f.CmbOrdenProd.value=='-1')
			{
				alert('Debe Seleccionar Orden de Producci�n');
				f.CmbOrdenProd.focus();
				return;
			}
			if(parseInt(f.Mes.value)>parseInt(f.MesFin.value))
			{
				alert('Mes Hasta debe ser menor o igual Mes Desde');
				return;
			}
			f.action = "pcip_rpt_recepciones_svp.php?Buscar=S";
			f.submit();
		break;
		case "E":
			URL='pcip_rpt_recepciones_svp_excel.php?CmbOrdenProd='+f.CmbOrdenProd.value+'&CmbMostrar='+f.CmbMostrar.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value+"&MesFin="+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;
		case "R":
			f.action = "pcip_rpt_recepciones_svp.php";
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
 EncabezadoPagina($IP_SERV,'recepciones.png')
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
    <td width="16%" height="17" class='formulario2'>Orden de Producci&oacute;n </td>
    <td width="36%" class="formulario2" ><select name="CmbOrdenProd">
      <option value="-1" selected="selected">Seleccionar</option>
      <?
	  $Consulta = "select OPorden,OPdescripcion from pcip_svp_ordenesproduccion order by OPorden ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbOrdenProd==$FilaTC["OPorden"])
				echo "<option selected value='".$FilaTC["OPorden"]."'>".$FilaTC["OPorden"]."&nbsp;&nbsp;".ucfirst($FilaTC["OPdescripcion"])."</option>\n";
			else
				echo "<option value='".$FilaTC["OPorden"]."'>".$FilaTC["OPorden"]."&nbsp;&nbsp;".ucfirst($FilaTC["OPdescripcion"])."</option>\n";
		}
			?>
    </select></td>
	    <td width="8%" height="17" class='formulario2'>Mostrar Por: </td>
		<td width="40%" class="formulario2" >
		<select name="CmbMostrar">
		<?
		switch($CmbMostrar)
		{
			case "1":
				echo "<option value='1' selected>D�lares</option>";
				echo "<option value='2'>Toneladas</option>";
			break;
			case "2":
				echo "<option value='1'>D�lares</option>";
				echo "<option value='2' selected>Toneladas</option>";
			break;
			default:
				echo "<option value='1'>D�lares</option>";
				echo "<option value='2'>Toneladas</option>";
			break;	
		}
		?>
		</select><? //echo $CmbDeCre;?>
		</td>
  </tr>	  
  <tr>

    <td height="25" class='formulario2'>A&ntilde;o</td>
    <td class='formulario2' colspan="3"><select name="Ano" id="Ano">
      <?
	for ($i=2003;$i<=date("Y");$i++)
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
    <td class='formulario2' colspan="3">
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
</select>
  </tr>
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
            <td width="18%" align="center"><span class="Estilo9">Orden de Producci&oacute;n </span></td>
            <td width="36%"align="center"><span class="Estilo9">Descripci&oacute;n Orden </span></td>
			<td width="18%"align="center"><span class="Estilo9">Tipo</span></td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
		       	echo "<td width='6%' align='center'><span class='Estilo9'>".substr($Meses[$i-1],0,3)."</span></td>";
			}
			?>
			 <td width="28%" align="center"><span class="Estilo9">Acumulado A�o</span></td>
          </tr>
		  <?
		  	if($Buscar=='S')
			{	
				$Consulta = "select OPorden,OPdescripcion from pcip_svp_ordenesproduccion ";
				$Consulta.= "where OPorden='".$CmbOrdenProd."'";
				$Consulta.= "order by OPorden ";
				//echo $Consulta;			
				$Resp=mysqli_query($link, $Consulta);
				while ($Fila=mysql_fetch_array($Resp))
				{
					echo "<tr>";
					echo "<td align='center' rowspan='2' class='formulario'><span class='Estilo9'>".$Fila[OPorden]."</span></td>";
					echo "<td align='left' rowspan='2' class='formulario'><span class='Estilo9'>".$Fila[OPdescripcion]."</span></td>";
					
					if($CmbMostrar=='2')
						Toneladas($Fila[OPorden],$Ano,$Mes,$MesFin);
					if($CmbMostrar=='1')	
						Dolares($Fila[OPorden],$Ano,$Mes,$MesFin);
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
function Toneladas($Orden,$Ano,$Mes,$MesFin)
{
	if($Orden<5999)
	{
		echo "<td align='left' class='formulario'><span class='Estilo9' >Tratado</span>&nbsp;[TO]</td>";
		$Total=0;
		for($i=$Mes;$i<=$MesFin;$i++)
		{
			$Consulta="SELECT sum(VPcantidad) as VPcantidad FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND VPtm in ( '4') AND VPorden = '".$Orden."' ";
			$Resp2=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			if($Fila2=mysql_fetch_array($Resp2))
			{
				if(!is_null($Fila2[VPcantidad]))
					echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Fila2[VPcantidad],3,',','.')."</span></td>";
				else
					echo "<td width='6%' align='center'>&nbsp;</td>";
				$Total=$Total+$Fila2[VPcantidad];
			}
			else	
				echo "<td width='6%' align='center'>&nbsp;</td>";
		}
		echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align='left' class='formulario'><span class='Estilo9'>Ajuste</span>&nbsp;[TO]</td>";
		$Total=0;
		for($i=$Mes;$i<=$MesFin;$i++)
		{
			$Consulta="SELECT sum(VPcantidad) as VPcantidad FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND VPtm in ( '5') AND VPorden = '".$Orden."' ";
			$Resp2=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			if($Fila2=mysql_fetch_array($Resp2))
			{
				if(!is_null($Fila2[VPcantidad]))
					echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Fila2[VPcantidad],3,',','.')."</span></td>";
				else
					echo "<td width='6%' align='right'>&nbsp;</td>";
				$Total=$Total+$Fila2[VPcantidad];
			}
			else	
				echo "<td width='6%' align='center'>&nbsp;</td>";
		}
		echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align='right' colspan='3' class='formulario2'><span class='Estilo9'>Total&nbsp;&nbsp;</span></td>";
		$Total=0;
		for($i=$Mes;$i<=$MesFin;$i++)
		{
			$Consulta="SELECT sum(VPcantidad) as VPcantidad FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND VPtm in ( '4','5') AND VPorden = '".$Orden."' ";
			$Resp2=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			if($Fila2=mysql_fetch_array($Resp2))
			{
				if(!is_null($Fila2[VPcantidad]))
					echo "<td width='6%' align='right' class='formulario2'><span class='Estilo9'>".number_format($Fila2[VPcantidad],3,',','.')."</span></td>";
				else
					echo "<td width='6%' align='center' class='formulario2'>&nbsp;</td>";
				$Total=$Total+$Fila2[VPcantidad];
			}
			else	
				echo "<td width='6%' align='right' class='formulario2'>&nbsp;</td>";
		}
		echo "<td width='6%' align='right' class='formulario2'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
		echo "</tr>";
	}
	if($Orden>=6000&&$Orden<=6999)
	{
		echo "<td align='left' class='formulario'><span class='Estilo9' >Tratado</span>&nbsp;[TO]</td>";
		$Total=0;
		for($i=$Mes;$i<=$MesFin;$i++)
		{
			$Cant=0;
			$Consulta="SELECT VPcantidad FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND (VPtm in ('11') AND VPordenrel = '".$Orden."' or VPtm in ('4') AND VPorden = '".$Orden."') ";
			$Resp2=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			while($Fila2=mysql_fetch_array($Resp2))
			{
				$Cant=$Cant+$Fila2[VPcantidad];
			}
			echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Cant,3,',','.')."</span></td>";
			$Total=$Total+$Cant;	
		}
		echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align='left' class='formulario'><span class='Estilo9' >Ajuste</span>&nbsp;[TO]</td>";
		$Total=0;
		for($i=$Mes;$i<=$MesFin;$i++)
		{
			$Cant=0;
			$Consulta="SELECT VPcantidad FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND (VPtm in ('12') AND VPordenrel = '".$Orden."' or VPtm in ('5') AND VPorden = '".$Orden."') ";
			$Resp2=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			while($Fila2=mysql_fetch_array($Resp2))
			{
				$Cant=$Cant+$Fila2[VPcantidad];
			}
			echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Cant,3,',','.')."</span></td>";
			$Total=$Total+$Cant;	
		}
		echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align='right' colspan='3' class='formulario2'><span class='Estilo9'>Total&nbsp;&nbsp;</span></td>";
		$Total=0;
		for($i=$Mes;$i<=$MesFin;$i++)
		{
			$Cant=0;
			$Consulta="SELECT VPcantidad FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND (VPtm in ('11','12') AND VPordenrel = '".$Orden."' or VPtm in ('4','5') AND VPorden = '".$Orden."') ";
			$Resp2=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			while($Fila2=mysql_fetch_array($Resp2))
			{
				$Cant=$Cant+$Fila2[VPcantidad];
			}
			echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Cant,3,',','.')."</span></td>";
			$Total=$Total+$Cant;	
		}
		echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
		echo "</tr>";
		
	}

} 
function Dolares($Orden,$Ano,$Mes,$MesFin)
{
	if($Orden<5999)
	{
		echo "<td align='left' class='formulario'><span class='Estilo9' >Tratado</span>&nbsp;[US$]</td>";
		$Total=0;
		for($i=$Mes;$i<=$MesFin;$i++)
		{
			$Consulta="SELECT sum(VPvalor) as VPvalor FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND VPtm in ( '4') AND VPorden = '".$Orden."' ";
			$Resp2=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			if($Fila2=mysql_fetch_array($Resp2))
			{
				if(!is_null($Fila2[VPvalor]))
					echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Fila2[VPvalor],3,',','.')."</span></td>";
				else
					echo "<td width='6%' align='center'>&nbsp;</td>";
				$Total=$Total+$Fila2[VPvalor];
			}
			else	
				echo "<td width='6%' align='center'>&nbsp;</td>";
		}
		echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align='left' class='formulario'><span class='Estilo9'>Ajuste</span>&nbsp;[US$]</td>";
		$Total=0;
		for($i=$Mes;$i<=$MesFin;$i++)
		{
			$Consulta="SELECT sum(VPvalor) as VPvalor FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND VPtm in ( '5') AND VPorden = '".$Orden."' ";
			$Resp2=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			if($Fila2=mysql_fetch_array($Resp2))
			{
				if(!is_null($Fila2[VPvalor]))
					echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Fila2[VPvalor],3,',','.')."</span></td>";
				else
					echo "<td width='6%' align='right'>&nbsp;</td>";
				$Total=$Total+$Fila2[VPvalor];
			}
			else	
				echo "<td width='6%' align='center'>&nbsp;</td>";
		}
		echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align='right' colspan='3' class='formulario2'><span class='Estilo9'>Total&nbsp;&nbsp;</span></td>";
		$Total=0;
		for($i=$Mes;$i<=$MesFin;$i++)
		{
			$Consulta="SELECT sum(VPvalor) as VPvalor FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND VPtm in ( '4','5') AND VPorden = '".$Orden."' ";
			$Resp2=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			if($Fila2=mysql_fetch_array($Resp2))
			{
				if(!is_null($Fila2[VPvalor]))
					echo "<td width='6%' align='right' class='formulario2'><span class='Estilo9'>".number_format($Fila2[VPvalor],3,',','.')."</span></td>";
				else
					echo "<td width='6%' align='center' class='formulario2'>&nbsp;</td>";
				$Total=$Total+$Fila2[VPvalor];
			}
			else	
				echo "<td width='6%' align='right' class='formulario2'>&nbsp;</td>";
		}
		echo "<td width='6%' align='right' class='formulario2'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
		echo "</tr>";
	}
	if($Orden>=6000&&$Orden<=6999)
	{
		echo "<td align='left' class='formulario'><span class='Estilo9' >Tratado</span>&nbsp;[US$]</td>";
		$Total=0;
		for($i=$Mes;$i<=$MesFin;$i++)
		{
			$Cant=0;
			$Consulta="SELECT VPvalor FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND (VPtm in ('11') AND VPordenrel = '".$Orden."' or VPtm in ('4') AND VPorden = '".$Orden."') ";
			$Resp2=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			while($Fila2=mysql_fetch_array($Resp2))
			{
				$Cant=$Cant+$Fila2[VPvalor];
			}
			echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Cant,3,',','.')."</span></td>";
			$Total=$Total+$Cant;	
		}
		echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align='left' class='formulario'><span class='Estilo9' >Ajuste</span>&nbsp;[US$]</td>";
		$Total=0;
		for($i=$Mes;$i<=$MesFin;$i++)
		{
			$Cant=0;
			$Consulta="SELECT VPvalor FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND (VPtm in ('12') AND VPordenrel = '".$Orden."' or VPtm in ('5') AND VPorden = '".$Orden."') ";
			$Resp2=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			while($Fila2=mysql_fetch_array($Resp2))
			{
				$Cant=$Cant+$Fila2[VPvalor];
			}
			echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Cant,3,',','.')."</span></td>";
			$Total=$Total+$Cant;	
		}
		echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align='right' colspan='3' class='formulario2'><span class='Estilo9'>Total&nbsp;&nbsp;</span></td>";
		$Total=0;
		for($i=$Mes;$i<=$MesFin;$i++)
		{
			$Cant=0;
			$Consulta="SELECT VPvalor FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND (VPtm in ('11','12') AND VPordenrel = '".$Orden."' or VPtm in ('4','5') AND VPorden = '".$Orden."') ";
			$Resp2=mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			while($Fila2=mysql_fetch_array($Resp2))
			{
				$Cant=$Cant+$Fila2[VPvalor];
			}
			echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Cant,3,',','.')."</span></td>";
			$Total=$Total+$Cant;	
		}
		echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
		echo "</tr>";
		
	}
} 
?>