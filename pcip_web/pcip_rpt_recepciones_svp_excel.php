<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	

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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" >
    <tr >
      <td width="18%" align="center"><span class="Estilo9">Orden de Producci&oacute;n </span></td>
      <td width="36%"align="center"><span class="Estilo9">Descripci&oacute;n Orden </span></td>
      <td width="18%"align="center"><span class="Estilo9">Tipo</span></td>
      <?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
		       	echo "<td width='6%' align='center'><span class='Estilo9'>".substr($Meses[$i-1],0,3)."</span></td>";
			}
			?>
      <td width="28%" align="center"><span class="Estilo9">Acumulado A&ntilde;o</span></td>
    </tr>
    <?
	   $Buscar='S';
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
  </table>
</form>
</body>
</html>
<?
function Toneladas($Orden,$Ano,$Mes,$MesFin)
{
	if($Orden<5999)
	{
		echo "<td align='left'><span class='Estilo9' >Tratado</span>&nbsp;[TO]</td>";
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
		echo "<td align='left'><span class='Estilo9'>Ajuste</span>&nbsp;[TO]</td>";
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
		echo "<td align='right' colspan='3'><span class='Estilo9'>Total&nbsp;&nbsp;</span></td>";
		$Total=0;
		for($i=$Mes;$i<=$MesFin;$i++)
		{
			$Consulta="SELECT sum(VPcantidad) as VPcantidad FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND VPtm in ( '4','5') AND VPorden = '".$Orden."' ";
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
				echo "<td width='6%' align='right'>&nbsp;</td>";
		}
		echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
		echo "</tr>";
	}
	if($Orden>=6000&&$Orden<=6999)
	{
		echo "<td align='left'><span class='Estilo9' >Tratado</span>&nbsp;[TO]</td>";
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
		echo "<td align='left'><span class='Estilo9' >Ajuste</span>&nbsp;[TO]</td>";
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
		echo "<td align='right' colspan='3'><span class='Estilo9'>Total&nbsp;&nbsp;</span></td>";
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
		echo "<td align='left'><span class='Estilo9' >Tratado</span>&nbsp;[US$]</td>";
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
		echo "<td align='left'><span class='Estilo9'>Ajuste</span>&nbsp;[US$]</td>";
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
		echo "<td align='right' colspan='3'><span class='Estilo9'>Total&nbsp;&nbsp;</span></td>";
		$Total=0;
		for($i=$Mes;$i<=$MesFin;$i++)
		{
			$Consulta="SELECT sum(VPvalor) as VPvalor FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND VPtm in ( '4','5') AND VPorden = '".$Orden."' ";
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
				echo "<td width='6%' align='right'>&nbsp;</td>";
		}
		echo "<td width='6%' align='right'><span class='Estilo9'>".number_format($Total,3,',','.')."</span></td>";
		echo "</tr>";
	}
	if($Orden>=6000&&$Orden<=6999)
	{
		echo "<td align='left'><span class='Estilo9' >Tratado</span>&nbsp;[US$]</td>";
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
		echo "<td align='left'><span class='Estilo9' >Ajuste</span>&nbsp;[US$]</td>";
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
		echo "<td align='right' colspan='3'><span class='Estilo9'>Total&nbsp;&nbsp;</span></td>";
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