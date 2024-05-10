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

	$Mostrar = isset($_REQUEST['Mostrar']) ? $_REQUEST['Mostrar'] : '';
	$TipoBusq = isset($_REQUEST['TipoBusq']) ? $_REQUEST['TipoBusq'] : '';
	$TipoBusqueda = isset($_REQUEST['TipoBusqueda']) ? $_REQUEST['TipoBusqueda'] : '';
	$SubProducto = isset($_REQUEST['SubProducto']) ? $_REQUEST['SubProducto'] : '';
	$Busq = isset($_REQUEST['Busq']) ? $_REQUEST['Busq'] : '';
	$Proveedor = isset($_REQUEST['Proveedor']) ? $_REQUEST['Proveedor'] : '';
	$Flujos = isset($_REQUEST['Flujos']) ? $_REQUEST['Flujos'] : '';
	$Orden = isset($_REQUEST['Orden']) ? $_REQUEST['Orden'] : '';
	$Cont = isset($_REQUEST['Cont']) ? $_REQUEST['Cont'] : '';
	$ChkOrden = isset($_REQUEST['ChkOrden']) ? $_REQUEST['ChkOrden'] : 'R';
	$TxtFiltroPrv = isset($_REQUEST['TxtFiltroPrv']) ? $_REQUEST['TxtFiltroPrv'] : '';

	$ChkTipoFlujo = isset($_REQUEST['ChkTipoFlujo']) ? $_REQUEST['ChkTipoFlujo'] : 'RAM';
	$TipoFlujo = isset($_REQUEST['ChkTipoFlujo']) ? $_REQUEST['ChkTipoFlujo'] : 'RAM';
/*
	if (!isset($ChkTipoFlujo))
	{
		$ChkTipoFlujo="RAM";
		$TipoFlujo="RAM";
	}*/
?>
<html>
<head>
<title>AGE-Relaciones</title></head>

<body><?php
			echo "<table width='720' border='1' cellpadding='1' cellspacing='0' class='TablaDetalle'>\n";		
			echo "<tr class='ColorTabla01'>\n";
			echo "<td width='90' align='center'>Rut</td>\n";
			echo "<td width='220' align='center'>Proveedor</td>\n";
			echo "<td width='180' align='left'>SubProducto</td>\n";
			echo "<td width='30' align='center'>Flujo</td>\n";
			echo "<td width='220' align='left'>Descrip. Flujo</td>\n";
			echo "</tr>\n";
			$Consulta = "select t1.rut_proveedor,t1.cod_subproducto,t1.flujo,t3.nomprv_a as nombre,t2.abreviatura as subproducto,t4.descripcion as nomflujo ";
			$Consulta.= " from age_web.relaciones t1 inner join proyecto_modernizacion.subproducto t2 on t2.cod_producto=1 and t1.cod_subproducto=t2.cod_subproducto";
			$Consulta.=" left join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a ";
			$Consulta.= " left join proyecto_modernizacion.flujos t4 on case when t2.recepcion='PMN' then t4.sistema='PMN' else t4.sistema='RAM' end ";
			$Consulta.= " and t1.flujo=t4.cod_flujo and esflujo<>'N'";
			switch($TipoBusq)
			{
				case "1"://POR SUBPRODUCTO
					$Consulta.= " where t1.cod_producto='1' ";
					if ($SubProducto!="S")
						$Consulta.= " and t1.cod_subproducto='".$SubProducto."'";	
					break;
				case "2"://POR PROVEEDOR
					$Consulta.= " where t1.rut_proveedor='".$Proveedor."'";
					break;
				case "3"://POR FLUJO
					$Consulta.= " where t1.flujo='".$Flujos."'";
					break;
				default:
					$Consulta.= " where t1.rut_proveedor='-1'";
					break;	
			}
			$Consulta.= " order by lpad(t1.cod_subproducto,3,'0'), t3.nomprv_a,  t1.flujo";
			$Resp = mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='ChkRut'>";
			while ($Fila = mysqli_fetch_array($Resp))
			{
				echo "<tr>\n";
				echo "<td align='center'>".$Fila["rut_proveedor"]."</td>\n";
				echo "<td align='left'>".$Fila["nombre"]."</td>\n";
				echo "<td align='left'>".$Fila["subproducto"]."</td>\n";
				if ($Fila["flujo"]=="0" || $Fila["flujo"]=="")
				{
					echo "<td align='center'>-</td>\n";
					echo "<td align='left'>SIN FLUJO</td>\n";
				}
				else
				{
					echo "<td align='center'>".$Fila["flujo"]."</td>\n";
					echo "<td align='left'>".$Fila["nomflujo"]."</td>\n";
				}
				echo "</tr>\n";
			}
		
		?>  </td>
 </tr>
</table>
</body>
</html>
