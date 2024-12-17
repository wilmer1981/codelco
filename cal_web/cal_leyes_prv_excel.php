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
	include("../principal/conectar_principal.php");	
	
	$Proveedor = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Busq = isset($_REQUEST["Busq"])?$_REQUEST["Busq"]:"";
	$Orden = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
	$TipoBusq = isset($_REQUEST["TipoBusq"])?$_REQUEST["TipoBusq"]:"";
	$TipoBusqueda = isset($_REQUEST["TipoBusqueda"])?$_REQUEST["TipoBusqueda"]:"";
	
?>
<html>
<head>
<title>CAL-Asignacion Leyes Producto - Proveedor Excel</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
  <table width="770"  height="313"border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="762" align="center" valign="top"><br>        
	  <?php	
			echo "<table width='720' border='1' cellpadding='1' cellspacing='0' class='TablaDetalle'>\n";		
			echo "<tr class='ColorTabla01'>\n";
			echo "<td width='90' align='center'>Rut</td>\n";
			echo "<td width='220' align='center'>Proveedor</td>\n";
			echo "<td width='180' align='left'>SubProducto</td>\n";
			echo "<td width='30' align='center'>Leyes</td>\n";
			echo "<td width='60' align='left'>Impurezas</td>\n";
			echo "</tr>\n";
			$Consulta = "select t1.rut_proveedor,t1.cod_subproducto,t3.nomprv_a as nombre,t2.abreviatura as subproducto,t1.leyes,t1.impurezas ";
			$Consulta.= " from age_web.relaciones t1 inner join proyecto_modernizacion.subproducto t2 on t2.cod_producto=1 and t1.cod_subproducto=t2.cod_subproducto";
			$Consulta.=" left join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a ";
			if ($SubProducto!="S")
				$Consulta.= " and t1.cod_subproducto='".$SubProducto."'";	
			if ($Proveedor!="S")
				$Consulta.= " where t1.rut_proveedor='".$Proveedor."'";
			switch($Orden)
			{
				case "R"://POR SUBPRODUCTO
					$Consulta.= " order by lpad(t1.rut_proveedor,310,'0'), t3.nomprv_a, lpad(t1.cod_subproducto,3,'0')";
					break;
				case "P"://POR SUBPRODUCTO
					$Consulta.= " order by t3.nomprv_a, lpad(t1.cod_subproducto,3,'0')";
					break;
			}
			//echo $Consulta;
			$Resp = mysqli_query($link, $Consulta);
			$Cont=0;
			while ($Fila = mysqli_fetch_array($Resp))
			{
				$Cont++;
				echo "<tr>\n";
				echo "<td align='center'>".$Fila["rut_proveedor"]."</td>\n";
				$LeyesMuestra='';$ImpurezasMuestra='';$LeyesImp='';
				if($Fila["leyes"]!=''||$Fila["impurezas"]!='')
					$LeyesImp=$Fila["leyes"].'~'.$Fila["impurezas"];
				$Datos=explode('~',$LeyesImp);
				foreach($Datos as $c => $v)
				{
					if($v!='')
					{
						$Consulta = "select abreviatura as ley from proyecto_modernizacion.leyes where cod_leyes='$v'";
						$RespLey=mysqli_query($link, $Consulta);
						$FilaLey=mysqli_fetch_array($RespLey);
						if($v=='01'||$v=='02'||$v=='03'||$v=='04'||$v=='05')
							$LeyesMuestra=$LeyesMuestra.$FilaLey["ley"]."~";
						else
							$ImpurezasMuestra=$ImpurezasMuestra.$FilaLey["ley"]."~";
					}		
				}
				echo "<td >".$Fila["nombre"]."&nbsp;</td>";
				echo "<td align='left'>".$Fila["subproducto"]."</td>\n";
				echo "<td align='center'>".$LeyesMuestra."&nbsp;</td>\n";
				echo "<td align='center'>".$ImpurezasMuestra."&nbsp;</td>\n";
				echo "</tr>\n";
			}
		?>  </td>
 </tr>
</table>
</tr>
</table>
</form>
</body>
</html>
