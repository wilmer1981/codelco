<?php

ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
$filename="";
if ( preg_match( '/MSIE/i', $userBrowser ) ) 
{
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
	$CodigoDeSistema = 21;
	$CodigoDePantalla = 2;
	include("../principal/conectar_principal.php");
	include("funciones_interfaces_codelco.php");
	include("funcion_consulta.php");
	
	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$Mensaje = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Mes     = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");

	$CmbMovimiento  = isset($_REQUEST["CmbMovimiento"])?$_REQUEST["CmbMovimiento"]:"";
	$CmbOrden  = isset($_REQUEST["CmbOrden"])?$_REQUEST["CmbOrden"]:"";
	$CmbAlmacen  = isset($_REQUEST["CmbAlmacen"])?$_REQUEST["CmbAlmacen"]:"";

	$Orden        = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
	$CodProducto  = isset($_REQUEST["CodProducto"])?$_REQUEST["CodProducto"]:"";
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Valores      = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	
	if ($CmbMovimiento=="")
		$CmbMovimiento="921";
	if ($Orden=="")
		$Orden="L";	
    if ($CodProducto=="")
		$CodProducto="18";	

?>
<html>
<head>
<title>Traspaso Emb. Catodos</title>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
 
        <table border="1" align="center" cellpadding="2" cellspacing="0">
    <tr class="ColorTabla01">
      <td width="50">Tipo</td>
      <td width="100">Fecha Doc</td>
      <td width="100">Fecha Con</td>
      <td width="70">Tipo Mov</td> 
      <td width="70" align="center">Centro</td>
      <td width="70" align="center">Almacen</td>
      <td width="100" align="center">Orden Prod</td>
      <td width="70" align="center">Cod Material</td>
      <td width="100" align="center">Cantidad</td>
      <td width="70" align="center">Unid.</td>
      <td width="120" align="center">Lote.Ventana</td>
      <td width="120" align="center">Clase Valoriz.</td>
      <td width="100" align="center">Status</td>
    </tr>
<?php	
if ($Mostrar == "S")
{
	//echo "entroooo";
	//CONSULTA CODIGO DE MATRIAL SAP
	$Consulta = "select * from interfaces_codelco.ordenes_produccion ";
	$Consulta.= " where cod_producto='".$CodProducto."'";
	if ($SubProducto != "S")
	{
		$Consulta.="and cod_subproducto='".$SubProducto."' ";
	}	
	//$Consulta = "select * from interfaces_codelco.ordenes_produccion ";
	//$Consulta.= " where cod_producto='".$CodProducto."' and cod_subproducto='".$SubProducto."' ";	
	$Resp=mysqli_query($link, $Consulta);
	$CodMaterialSAP="";
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$CodMaterialSAP=$Fila["cod_material_sap"];
	}
	$ArrResp = array();
	if ($CodProducto=='18' || $CodProducto=='48')
	{
		SapValidos($CodProducto, $Ano, $Mes, $link);
		
		$Consulta = "select t1.referencia,t1.registro from interfaces_codelco.registro_traspaso t1,";
		$Consulta.= "interfaces_codelco.tmp_control_pas t2";
		$Consulta.= " where t1.ano='".$Ano."' and t1.mes='".$Mes."' and t1.tipo_movimiento='921' ";
		$Consulta.=" and  t1.ano = t2.ano and t1.mes = t2.mes and t1.referencia = t2.referencia";
		$Consulta.= " order by substring(t1.registro,24,4), t1.referencia";
	}
	else
	{
		$Consulta = "select * from interfaces_codelco.registro_traspaso ";
		$Consulta.= " where ano='".$Ano."' and mes='".$Mes."' and tipo_movimiento='921' ";
		$Consulta.= " order by substring(registro,24,4)";
	}
	$Resp=mysqli_query($link, $Consulta);
	$Cont=0;	
	while ($Fila=mysqli_fetch_array($Resp))
	{		
		$ArrResp[$Cont]["tipo"] = substr($Fila["registro"],0,1);
		$ArrResp[$Cont]["fecha_doc"] = substr($Fila["registro"],1,10);
		$ArrResp[$Cont]["fecha_con"] = substr($Fila["registro"],11,10);
		$ArrResp[$Cont]["tipo_mov"] = substr($Fila["registro"],21,3);
		$ArrResp[$Cont]["centro"] = substr($Fila["registro"],24,4);
		$ArrResp[$Cont]["almacen"] = substr($Fila["registro"],28,4);
		$ArrResp[$Cont]["orden_prod"] = substr($Fila["registro"],32,12);
		$ArrResp[$Cont]["cod_material"] = substr($Fila["registro"],44,18);					
		$ArrResp[$Cont]["cantidad"] = substr($Fila["registro"],62,15);
		$ArrResp[$Cont]["unidad"] = substr($Fila["registro"],77,3);
		$ArrResp[$Cont]["lote"] = substr($Fila["registro"],80,10);
		$ArrResp[$Cont]["clase_valoriz"] = substr($Fila["registro"],90,12);
		$ArrResp[$Cont]["status"] = substr($Fila["registro"],102,1);
		$ArrResp[$Cont]["msg"] = substr($Fila["registro"],103);
		$Cont++;
		//echo $Fila["registro"];
	}
	reset($ArrResp);
	$TotalPesoTraspasado=0;
	$TotalPesoCentro=0;
	$Centro="";
	$CentroAnt="";
	//while (list($k,$Fila)=each($ArrResp))
	foreach ($ArrResp as $k => $Fila)
	{
		if (intval($Fila["cod_material"])==$CodMaterialSAP)
		{
			$Centro=$Fila["centro"];
			if ($CentroAnt!=$Centro && trim($CentroAnt)!="")
			{
				echo "<tr class=\"Detalle01\">";
				echo "<td colspan=\"8\"><b>TOTAL ".$CentroAnt."</b></td>";
				echo "<td align=\"right\">".number_format($TotalPesoCentro,1,",",".")."</td>";
				echo "<td colspan=\"4\">&nbsp;</td>";
				echo "</tr>";
				$TotalPesoCentro=0;
			}
			$Cantidad=(str_replace(",",".",$Fila["cantidad"])*1);
			echo "<tr>";
			echo "<td align=\"center\">".$Fila["tipo"]."</td>";
			echo "<td align=\"center\">".$Fila["fecha_doc"]."</td>";
			echo "<td align=\"center\">".$Fila["fecha_con"]."</td>";
			echo "<td align=\"center\">".$Fila["tipo_mov"]."</td>";
			echo "<td align=\"center\">".$Centro."</td>";
			echo "<td align=\"center\">".$Fila["almacen"]."</td>";
			echo "<td align=\"center\">".$Fila["orden_prod"]."</td>";
			echo "<td align=\"center\">".intval($Fila["cod_material"])."</td>";
			echo "<td align=\"right\">".number_format($Cantidad,1,",",".")."</td>";
			echo "<td align=\"center\">".$Fila["unidad"]."</td>";
			echo "<td align=\"center\">".$Fila["lote"]."</td>";
			echo "<td align=\"center\">".$Fila["clase_valoriz"]."</td>";
			if ($Fila["status"]!="")
				echo "<td align=\"center\">".$Fila["status"]."</td>";
			else
				echo "<td align=\"center\">&nbsp;</td>";
			echo "</tr>";
			$TotalPesoTraspasado=$TotalPesoTraspasado + $Cantidad;
			$TotalPesoCentro=$TotalPesoCentro + $Cantidad;
			$CentroAnt=$Centro;
		}
	}
	/*if ($CentroAnt!=$Centro && $Centro!="")
	{*/
		echo "<tr class=\"Detalle01\">";
		echo "<td colspan=\"8\"><b>TOTAL ".$CentroAnt."</b></td>";
		echo "<td align=\"right\">".number_format($TotalPesoCentro,1,",",".")."</td>";
		echo "<td colspan=\"4\">&nbsp;</td>";
		echo "</tr>";
		$TotalPesoCentro=0;
	//}
	echo "<tr class=\"Detalle01\">";
	echo "<td colspan=\"8\"><b>TOTAL TRASPASADO</b></td>";
	echo "<td align=\"right\">".number_format($TotalPesoTraspasado,1,",",".")."</td>";
	echo "<td colspan=\"4\">&nbsp;</td>";
	echo "</tr>";
}
//echo "no entroooo";			
?>	
</table>	
</form>
</body>
</html>