<?php 
	ob_end_clean();
	$file_name=basename($_SERVER['PHP_SELF']).".xls";
	$userBrowser = $_SERVER['HTTP_USER_AGENT'];
	$filename="";
	if ( preg_match( '/MSIE/i', $userBrowser ) ) {
	$filename = urlencode($filename);
	}
	$filename = iconv('UTF-8', 'gb2312', $filename);
	$file_name = str_replace(".php", "", $file_name);
	header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
	header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
	
	header("content-disposition: attachment;filename={$file_name}");
	header( "Cache-Control: public" );
	header( "Pragma: public" );
	header( "Content-type: text/csv" ) ;
	header( "Content-Dis; filename={$file_name}" ) ;
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 53;
	include("../principal/conectar_principal.php");
	$meses =array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
	$meses2 =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut=$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");	
	
	$FechaHora  = isset($_REQUEST["FechaHora"])?$_REQUEST["FechaHora"]:"";
	$Tipo       = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";
	$MesIni2    = isset($_REQUEST["MesIni2"])?$_REQUEST["MesIni2"]:date("m");
	$AnoIni2    = isset($_REQUEST["AnoIni2"])?$_REQUEST["AnoIni2"]:date("Y");

	$CmbCliente  = isset($_REQUEST["CmbCliente"])?$_REQUEST["CmbCliente"]:"";
	$Pais        = isset($_REQUEST["Pais"])?$_REQUEST["Pais"]:"";
	$CmbContrato = isset($_REQUEST["CmbContrato"])?$_REQUEST["CmbContrato"]:"";	
	$Mostrar     = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";

?>
<html>
<head>
<title>Programacion De Ventas</title>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<table width="762" height="47" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td height="15" colspan="15"><strong><font size="2">COMPROMISO DE VENTAS<br>
      CATODOS DE COBRE GRADO A<br>
<?php 
	if ($MesIni2 != "T")
		echo strtoupper($meses2[$MesIni2-1])." DEL ".$AnoIni2; 
	else
		echo " AñO ".$AnoIni2; 	
?>      </font></strong></td>
  </tr>
  <tr align="center" class="ColorTabla01"> 
    <td height="15" colspan="3">&nbsp;</td>
  </tr>
  <tr align="center" class="ColorTabla01"> 
    <td width="60" height="15"><strong>#Contrato</strong></td>
    <td width="80"><strong>Cliente</strong></td>
    <td width="55"><strong>Total</strong></td>
    <?php
			for($i=1;$i<13;$i++)
		  	{
				echo "<td width='40'>".$meses[$i-1]."</td>";
			}
			?>
  </tr>
  <?php	
		$Consulta = "select * from sec_web.programa_ventas t1 inner join sec_web.cliente_venta t2 ";
		$Consulta.= " on t1.cod_cliente = t2.cod_cliente ";
		$Consulta.= " where t1.ano = '".$AnoIni2."'";
		if ($MesIni2 != "T")			
			$Consulta.= " and (".$meses[$MesIni2-1]." <> '' or ".$meses[$MesIni2-1]." != NULL)";
		$Consulta.= " order by substring(t1.cod_cliente,1,2),t1.cod_contrato,t1.cod_cliente";	
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		$J=10;
		$CodPaisAnt = 0;
		$CodPais = 0;
		$Total=0;
		$TotalEne=0; $TotalFeb=0; $TotalMar=0; $TotalAbr=0; $TotalMay=0; $TotalJun=0;
		$TotalJul=0; $TotalAgo=0; $TotalSep=0; $TotalOct=0; $TotalNov=0; $TotalDic=0;
		$Total2=0;
		$TotalEne2=0; $TotalFeb2=0; $TotalMar2=0; $TotalAbr2=0; $TotalMay2=0; $TotalJun2=0;
		$TotalJul2=0; $TotalAgo2=0; $TotalSep2=0; $TotalOct2=0; $TotalNov2=0; $TotalDic2=0;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$CodPais = substr($Fila["cod_cliente"],0,2);
			if ($CodPaisAnt != $CodPais)
			{
				if ($i != 1)
				{
					$Consulta = "select * from sec_web.paises where abreviatura = '".$CodPaisAnt."'";
					$Resp2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Resp2))
						$NomPais = $Fila2["nombre_pais"];
					echo "<tr>";
					echo "<td align='left' colspan='2'><strong>TOTAL ".strtoupper($NomPais)."</strong></td>";
					echo "<td align='right'>".number_format($Total,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalEne,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalFeb,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalMar,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalAbr,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalMay,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalJun,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalJul,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalAgo,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalSep,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalOct,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalNov,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalDic,0,",",".")."</td>";				
					echo "</tr>";
					$Total = 0;
					$TotalEne = 0;
					$TotalFeb = 0;
					$TotalMar = 0;
					$TotalAbr = 0;
					$TotalMay = 0;
					$TotalJun = 0;
					$TotalJul = 0;
					$TotalAgo = 0;
					$TotalSep = 0;
					$TotalOct = 0;
					$TotalNov = 0;
					$TotalDic = 0;
				}
			}			
			$Sigla = $Fila["sigla_cliente"];
			echo "<tr>";			
			echo "<td align='center'>".$Fila["cod_contrato"]."</td>";
			echo "<td>".$Sigla."</td>";
			echo "<td align='right'>".number_format($Fila["tonelaje_total"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["ene"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["feb"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["mar"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["abr"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["may"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["jun"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["jul"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["ago"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["sep"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["oct"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["nov"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["dic"],0,",",".")."</td>";			
			echo "</tr>";
			//TOTAL POR PAIS
			$Total = $Total + $Fila["tonelaje_total"];
			$TotalEne = $TotalEne + $Fila["ene"];
			$TotalFeb = $TotalFeb + $Fila["feb"];
			$TotalMar = $TotalMar + $Fila["mar"];
			$TotalAbr = $TotalAbr + $Fila["abr"];
			$TotalMay = $TotalMay + $Fila["may"];
			$TotalJun = $TotalJun + $Fila["jun"];
			$TotalJul = $TotalJul + $Fila["jul"];
			$TotalAgo = $TotalAgo + $Fila["ago"];
			$TotalSep = $TotalSep + $Fila["sep"];
			$TotalOct = $TotalOct + $Fila["oct"];
			$TotalNov = $TotalNov + $Fila["nov"];
			$TotalDic = $TotalDic + $Fila["dic"];
			//TOTAL TOTAL
			$Total2 = $Total2 + $Fila["tonelaje_total"];
			$TotalEne2 = $TotalEne2 + $Fila["ene"];
			$TotalFeb2 = $TotalFeb2 + $Fila["feb"];
			$TotalMar2 = $TotalMar2 + $Fila["mar"];
			$TotalAbr2 = $TotalAbr2 + $Fila["abr"];
			$TotalMay2 = $TotalMay2 + $Fila["may"];
			$TotalJun2 = $TotalJun2 + $Fila["jun"];
			$TotalJul2 = $TotalJul2 + $Fila["jul"];
			$TotalAgo2 = $TotalAgo2 + $Fila["ago"];
			$TotalSep2 = $TotalSep2 + $Fila["sep"];
			$TotalOct2 = $TotalOct2 + $Fila["oct"];
			$TotalNov2 = $TotalNov2 + $Fila["nov"];
			$TotalDic2 = $TotalDic2 + $Fila["dic"];
			$i++;
			$J=$J+16;
			$CodPaisAnt = substr($Fila["cod_cliente"],0,2);
		}
		$Consulta = "select * from sec_web.paises where abreviatura = '".$CodPaisAnt."'";
		$NomPais="";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
			$NomPais = $Fila2["nombre_pais"];
		echo "<tr>";
		echo "<td align='left' colspan='2'><strong>TOTAL ".strtoupper($NomPais)."</strong></td>";
		echo "<td align='right'>".number_format($Total,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalEne,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalFeb,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalMar,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalAbr,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalMay,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalJun,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalJul,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalAgo,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalSep,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalOct,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalNov,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalDic,0,",",".")."</td>";				
		echo "</tr>";
		//TOTAL TOTAL
		echo "<tr>";
		echo "<td align='left' colspan='2'><strong>TOTAL</strong></td>";
		echo "<td align='right'>".number_format($Total2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalEne2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalFeb2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalMar2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalAbr2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalMay2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalJun2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalJul2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalAgo2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalSep2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalOct2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalNov2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalDic2,0,",",".")."</td>";				
		echo "</tr>";
		?>
</table>
</body>
</html>

