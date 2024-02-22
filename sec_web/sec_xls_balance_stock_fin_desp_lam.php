<?php
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
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
	include("../principal/conectar_principal.php");
	if (!isset($DiaIni))
	{
		$DiaIni = "01";
		$MesIni = $MesFin;
		$AnoIni = $AnoFin;
		$DiaFin = "31";
	}
	$FechaAux = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);	
	$FechaTermino = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad($DiaFin,2, "0", STR_PAD_LEFT);
	$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2) + 1,01,substr($FechaAux,0,4)));
	$FechaInicio = $FechaAux;
	$FechaTermino = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2) + 1,01,substr($FechaAux,0,4)));
	$FechaTermino = date("Y-m-d", mktime(0,0,0,substr($FechaTermino,5,2),intval(substr($FechaTermino,8,2)) - 1,substr($FechaTermino,0,4)));	
	
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
</head>
<script language="JavaScript">
function Proceso(opt)
{
	var f = frmPrincipal;
	switch (opt)
	{
		case "I":
			window.print();
			break;
		case "S":
			f.action = "sec_con_balance.php";
			f.submit();
			break;
	}
}

function Historial(SA)
{
	window.open("../cal_web/cal_con_registro_leyes.php?SA="+ SA,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
</script>
<body>
<form action="" method="post" name="frmPrincipal">
  <table width="622" border="1" cellspacing="0" cellpadding="2">
    <tr> 
      <td><strong>TIPO MOVIMIENTO</strong></td>
      <td>STOCK FINAL</td>
    </tr>
    <tr> 
      <td width="141"><strong>PRODUCTO</strong></td>
      <td width="363">DESPUNTE Y LAMINAS</td>
    </tr>
    <tr> 
      <td><strong>SUBPRODUCTO</strong></td>
      <td>TODOS</td>
    </tr>
    <tr> 
      <td><strong>PERIODO</strong></td>
      <td>
        <?php 
	  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	  	echo $Meses[$MesFin - 1]." del ".$AnoFin; 
	?>
      </td>
    </tr>
  </table>
<br>
<br>
  <table width="621" border="1" cellspacing="0" cellpadding="2">
    <tr align="center" class="ColorTabla01"> 
    <td width="220">SubProducto</td>
    <td width="142">Lote</td>
    <td width="113">N&ordm; Envio</td>
    <!--<td width="53">N&ordm; Cert.</td>-->
    <td width="107">Peso</td>
    <!--<td colspan="2">Leyes</td>-->
  </tr>
  <!--<tr class="ColorTabla01"> 
    <td width="56" align="center">S</td>
    <td width="47" align="center">O</td>
  </tr>-->
  <?php   	
	
	$Consulta = "select * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase = '3004' and cod_subclase = '".intval(substr($FechaAux,5,2))."'"	;
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$MesConsulta = $Fila["nombre_subclase"];
	}		
	$Eliminar = "DROP TABLE `sec_web`.`tmp_stock_ini`";
	mysqli_query($link, $Eliminar);
	$Consulta = " create table sec_web.tmp_stock_ini as ";
	$Consulta.= " select t2.cod_bulto, t2.num_bulto, year(t2.fecha_creacion_lote) as ano_creacion, sum(t1.peso_paquetes) as peso ";
	$Consulta.= " from sec_web.paquete_catodo t1 inner join sec_web.lote_catodo t2 ";
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
	$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
	$Consulta.= " where ";
	$Consulta.= " t1.cod_producto = '48'";
	$Consulta.= " and t1.cod_estado = 'a' ";
	$Consulta.= " and (year(t1.fecha_creacion_paquete) <= ".$AnoFin." and t1.cod_paquete < '".$MesConsulta."' ";
	$Consulta.= " or year(t1.fecha_creacion_paquete) < ".$AnoFin.") ";
	$Consulta.= " group by t2.cod_bulto, t2.num_bulto ";
	$Consulta.= " order by ano_creacion, t2.cod_bulto, t2.num_bulto";
	mysqli_query($link, $Consulta);	
	$Consulta = " select sum(t1.peso_paquetes) as peso,t2.cod_bulto,t2.num_bulto ";
	$Consulta.= " from sec_web.paquete_catodo t1  ";
	$Consulta.= " inner join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia ";
	$Consulta.= " where t2.fecha_guia between '".$FechaInicio."' and curdate() ";//'".$FechaTermino."' ";
	$Consulta.= " and t1.cod_producto = '48'";
	$Consulta.= " and (year(t1.fecha_creacion_paquete) = ".$AnoFin."  ";
	$Consulta.= " and t1.cod_paquete < '".$MesConsulta."' or year(t1.fecha_creacion_paquete) < ".$AnoFin.")  ";
	$Consulta.= " group by t2.cod_bulto,t2.num_bulto ";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Insertar = "insert into sec_web.tmp_stock_ini (cod_bulto, num_bulto, ano_creacion, peso) ";
		$Insertar.= "values('".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','','".$Fila["peso"]."')";
		mysqli_query($link, $Insertar);
	}
	$Consulta = "select * from sec_web.tmp_stock_ini order by cod_bulto, num_bulto";
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($Color == "")
			$Color = "WHITE";
		else
			$Color = "";
		echo "<tr bgcolor = '".$Color."'>\n";
		//CONSULTA SI TODOS LOS PAQUETES SON DE UN MISMO PRODUCTO-SUBPRODUCTO
		$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, t2.descripcion ";
		$Consulta.= " from sec_web.lote_catodo t3 inner join sec_web.paquete_catodo t1 ";
		$Consulta.= " on t3.cod_paquete = t1.cod_paquete and t3.num_paquete = t1.num_paquete ";
		$Consulta.= " and t3.fecha_creacion_paquete = t1.fecha_creacion_paquete";
		$Consulta.= " inner join proyecto_modernizacion.subproducto t2 ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";			
		$Consulta.= " where t3.cod_bulto = '".$Fila["cod_bulto"]."'";
		$Consulta.= " and t3.num_bulto = '".$Fila["num_bulto"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		$ContProd = 0;
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$ContProd++;
			$Descripcion = $Fila2["descripcion"];
		}
		if ($ContProd == 0)
		{
			echo "<td>Sin Sub-Producto</td>\n";
		}
		else
		{
			if ($ContProd == 1)
			{
				echo "<td>".$Descripcion."</td>\n";
			}
			else
			{
				echo "<td>DESPUNTE Y LAMINAS</td>\n";
			}
		}
		if ($Fila["cod_bulto"] == "")
			echo "<td>Sin Lote</td>\n";
		else
			echo "<td align='center'>".strtoupper($Fila["cod_bulto"])."-".str_pad($Fila["num_bulto"],6,0,STR_PAD_LEFT)."</td>\n";						
		$Consulta = "select num_envio from sec_web.embarque_ventana where cod_bulto = '".$Fila["cod_bulto"]."' and num_bulto = '".$Fila["num_bulto"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
			echo "<td align='center'>".str_pad($Fila2["num_envio"],5, "0", STR_PAD_LEFT)."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		//echo "<td>&nbsp;</td>\n";
		echo "<td align='right'>".number_format($Fila["peso"],0,",",".")."</td>\n";							
		$TotalPeso = $TotalPeso + $Fila["peso"];			
		//------------------------------------------------------------------------------------------------			
	}		
?>
  <tr> 
    <td colspan="3"><strong>TOTAL</strong></td>
    <td align="right" bgcolor="#FFFF66"><?php echo number_format($TotalPeso,0,",","."); ?></td>
    <!--<td align="right" bgcolor="#FFFF66">&nbsp;</td>
    <td align="right" bgcolor="#FFFF66">&nbsp;</td>-->
  </tr>
</table>
</form>
</body>
</html>
