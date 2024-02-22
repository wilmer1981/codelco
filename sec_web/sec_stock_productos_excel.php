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
	$CodigoDePantalla = 41;

	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut = $CookieRut;

	$Consulta = "SELECT * from proyecto_modernizacion.sistemas_por_usuario where rut = '".$Rut."' and cod_sistema = '3'";
	$Respuesta =mysqli_query($link, $Consulta);
	if($Fila =mysqli_fetch_array($Respuesta))
	{
		$Nivel = $Fila["nivel"];
	}

	$CmbAno  = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date('Y');
	$CmbMes  = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date('m');
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase=3004 and cod_subclase =".$CmbMes;
	$Respuesta =mysqli_query($link, $Consulta);
	if($Fila =mysqli_fetch_array($Respuesta))
	{
		$Letra=$Fila["nombre_subclase"];
	}

	/*
	if (!isset($CmbAno))
	{
		$CmbAno=date('Y');
	}
	if (!isset($CmbMes))
	{
		$CmbMes=date('n');
	}
	else
	{
		$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase=3004 and cod_subclase =".$CmbMes;
		$Respuesta =mysqli_query($link, $Consulta);
		if($Fila =mysqli_fetch_array($Respuesta))
		{
			$Letra=$Fila["nombre_subclase"];
		}		
	}
	*/
	
?>
<html>
<head>

<title>Stock Catodos Productos Excel</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmStockSec" method="post" action="">
  <table width="770" border="0" left="5" cellpadding="5" cellspacing="0">
  <tr>
      <td align="center"><br>
	  <table width="730" border="1" cellpadding="3" cellspacing="0">
          <tr>
		    <td align="center">&nbsp;</td>
			<td width='60' align="center">Existencia</td>
			<td colspan="3" width='' align="center">&nbsp;</td>
			<td width='' align="center">Existencia</td>
          </tr>
          <tr>
		    <td align="center">Tipo Producto</td>
			<td width='60' align="center">Inicial</td>
			<td width='' align="center">Paquetes</td>
			<td width='' align="center">Traspaso</td>
			<td width='' align="center">Embarques</td>
			<td width='' align="center">Final</td>
          </tr>
		  <?php
			if (strlen($CmbMes)==1)
			{
				$CmbMes="0".$CmbMes;
			}
			$FechaInicio=$CmbAno."-".$CmbMes."-01";
			$FechaTermino=$CmbAno."-".$CmbMes."-31";
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='3103' order by cod_subclase";
			$Respuesta3=mysqli_query($link, $Consulta);
			$TotalInicial=0;
			$TotalPaquetes=0;
			$TotalTraspaso=0;
			$TotalEmbarque=0;
			$TotalFinal=0;
			while ($Fila3=mysqli_fetch_array($Respuesta3))
			{
				echo "<tr>";
				echo "<td colspan='6' ><strong>".$Fila3["nombre_subclase"]."</STRONG></td>";
				echo "</tr>";	
				$Consulta="SELECT cod_producto,cod_subproducto,abreviatura as nombre from proyecto_modernizacion.subproducto where stock_sec='".$Fila3["cod_subclase"]."' order by orden_stock_sec";
				$Respuesta=mysqli_query($link, $Consulta);
				echo "<input type='hidden' name='TxtCodProducto'><input type='hidden' name='TxtCodSubProducto'><input type='hidden' name='TxtStockFinal'>";
				$SubTotalInicial=0;
				$SubTotalPaquetes=0;
				$SubTotalTraspaso=0;
				$SubTotalEmbarque=0;
				$SubTotalFinal=0;
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					$StockFinal=0;
					echo "<tr>";
					echo "<td width='200'>".$Fila["nombre"]."</td>";
					//STOCK INICIAL
					$Consulta="SELECT peso as peso_inicial from sec_web.stock_final where cod_producto='".$Fila["cod_producto"]."'";
					$Consulta=$Consulta." and cod_subproducto ='".$Fila["cod_subproducto"]."' and fecha ";
					$Consulta=$Consulta." between subdate('$FechaInicio',interval 1 month) and subdate('$FechaTermino',interval 1 month)"; 
					$Respuesta2=mysqli_query($link, $Consulta);
					if ($Fila2=mysqli_fetch_array($Respuesta2))
					{
						echo "<td  width='60' align='right'>".number_format($Fila2["peso_inicial"],0,',','.')."</td>";
						$StockFinal     = $StockFinal+$Fila2["peso_inicial"];
						$SubTotalInicial= $SubTotalInicial+$Fila2["peso_inicial"];
						$TotalInicial   = $TotalInicial+$Fila2["peso_inicial"];
					}
					else
					{
						echo "<td  width='60' align='right'>0</td>";
					}
					//STOCK PAQUETES
					$Paquetes=0;
					$Consulta="SELECT sum(peso_paquetes) as peso_paquetes  from sec_web.paquete_catodo where cod_producto='".$Fila["cod_producto"]."'";
					$Consulta=$Consulta." and cod_subproducto ='".$Fila["cod_subproducto"]."' and cod_paquete='".$Letra."' and year(fecha_creacion_paquete)=".$CmbAno;
					$Consulta=$Consulta." group by cod_producto,cod_subproducto"; 
					$Respuesta2=mysqli_query($link, $Consulta);
					if ($Fila2=mysqli_fetch_array($Respuesta2))
					{
						echo "<td width='60' align='right'>".number_format($Fila2["peso_paquetes"],0,',','.')."</td>";
						$StockFinal=$StockFinal+$Fila2["peso_paquetes"];
						$SubTotalPaquetes=$SubTotalPaquetes+$Fila2["peso_paquetes"];
						$TotalPaquetes=$TotalPaquetes+$Fila2["peso_paquetes"];
						$Paquetes=$Fila2["peso_paquetes"];
					}
					else
					{
						echo "<td width='60' align='right'>0</td>";
					}
					//STOCK TRASPASO
					$Consulta="SELECT sum(peso) as peso_traspaso  from sec_web.traspaso where cod_producto='".$Fila["cod_producto"]."'";
					$Consulta=$Consulta." and cod_subproducto ='".$Fila["cod_subproducto"]."' and fecha_traspaso ";
					$Consulta=$Consulta." between '$FechaInicio' and '$FechaTermino'";
					$Consulta=$Consulta." group by cod_producto,cod_subproducto"; 
					$Respuesta2=mysqli_query($link, $Consulta);
					if ($Fila2=mysqli_fetch_array($Respuesta2))
					{
						echo "<td width='60' align='right'>".number_format($Fila2["peso_traspaso"],0,',','.')."</td>";
						$StockFinal=abs($StockFinal-$Fila2["peso_traspaso"]);
						$SubTotalTraspaso=$SubTotalTraspaso+$Fila2["peso_traspaso"];
						$TotalTraspaso=$TotalTraspaso+$Fila2["peso_traspaso"];
					}
					else
					{
						echo "<td width='60' align='right'>0</td>";
					}
					//STOCK EMBARQUE
					$Consulta = "SELECT sum(t2.peso_paquetes) as peso_embarque  ";
					$Consulta.= "from sec_web.guia_despacho_emb t1 inner join sec_web.paquete_catodo t2  ";
					$Consulta.= "on t1.num_guia=t2.num_guia and t1.fecha_guia=t2.fecha_embarque ";
					$Consulta.= "where (t1.cod_estado <>'A') and (t1.fecha_guia between '".$FechaInicio."' and '".$FechaTermino."')";
					$Consulta.= " and (t2.cod_estado = 'c') and (t2.cod_producto='".$Fila["cod_producto"]."' and t2.cod_subproducto ='".$Fila["cod_subproducto"]."')";
					$Consulta.= "group by t2.cod_producto, t2.cod_subproducto ";
					$Respuesta2=mysqli_query($link, $Consulta);
					if ($Fila2=mysqli_fetch_array($Respuesta2))
					{
						echo "<td width='60' align='right'>".number_format($Fila2["peso_embarque"],0,',','.')."</td>";
						$StockFinal=abs($StockFinal-$Fila2["peso_embarque"]);
						$SubTotalEmbarque=$SubTotalEmbarque+$Fila2["peso_embarque"];
						$TotalEmbarque=$TotalEmbarque+$Fila2["peso_embarque"];
					}
					else
					{
						echo "<td width='60' align='right'>0</td>";
					}
					echo "<td  width='60' align='right'>".number_format($StockFinal,0,',','.')."</td>";
					$SubTotalFinal=$SubTotalFinal+$StockFinal;
					$TotalFinal=$TotalFinal+$StockFinal;
					echo "<input type='hidden' name='TxtCodProducto' value='".$Fila["cod_producto"]."'><input type='hidden' name='TxtCodSubProducto' value='".$Fila["cod_subproducto"]."'><input type='hidden' name='TxtStockFinal' value='".$StockFinal."'>";				
					echo "</tr>";
				}
				echo "<tr>";
				echo "<td >SUB-TOTAL</td>";
				echo "<td width='60' align='right'>".number_format($SubTotalInicial,0,',','.')."</td>";
				echo "<td width='60' align='right'>".number_format($SubTotalPaquetes,0,',','.')."</td>";
				echo "<td width='60' align='right'>".number_format($SubTotalTraspaso,0,',','.')."</td>";
				echo "<td  width='60' align='right'>".number_format($SubTotalEmbarque,0,',','.')."</td>";
				echo "<td  width='60' align='right'>".number_format($SubTotalFinal,0,',','.')."</td>";			
				$SubTotalInicial=0;
				$SubTotalPaquetes=0;
				$SubTotalTraspaso=0;
				$SubTotalEmbarque=0;
				$SubTotalFinal=0;
				echo "</tr>";	
			}	
			echo "<td width='60' align='left'><strong>TOTALES</strong></td>";
			echo "<td width='60' align='right'><strong>".number_format($TotalInicial,0,',','.')."</td>";
			echo "<td width='60' align='right'><strong>".number_format($TotalPaquetes,0,',','.')."</td>";
			echo "<td width='60' align='right'><strong>".number_format($TotalTraspaso,0,',','.')."</td>";
			echo "<td width='60' align='right'><strong>".number_format($TotalEmbarque,0,',','.')."</td>";
			echo "<td width='60' align='right'><strong>".number_format($TotalFinal,0,',','.')."</strong></td>";			
		  ?>
        </table>
      </td>
  </tr>
</table>
</form>
</body> 
</html>
