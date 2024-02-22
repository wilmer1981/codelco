<?php         ob_end_clean();
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
	//set_time_limit(1000);

	$Proceso = $_REQUEST["Proceso"];
	$Valores = $_REQUEST["Valores"];

	$CmbProductos   = $_REQUEST["CmbProductos"];
	$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	$CmbLeyes       = $_REQUEST["CmbLeyes"];
	$CmbProveedores = $_REQUEST["CmbProveedores"];
	$LimitIni       = $_REQUEST["LimitIni"];
	$LimitFin       = $_REQUEST["LimitFin"];
	$CmbUnidad      = $_REQUEST["CmbUnidad"];
	$Proc           = $_REQUEST["Proc"];
	$NewRec         = $_REQUEST["NewRec"];
	$TipoConsulta   = $_REQUEST["TipoConsulta"];
  $Buscar         = $_REQUEST["Buscar"];


?>
<html>
<head>
<title>Administraci�n Limite de Control Excel</title>
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmPrincipal" method="post" action="">
  <table width="1137" border="0" cellpadding="2" cellspacing="1" class="TablaDetalle" >
    <tr align="center" class="ColorTabla01">
      <td width="237" height="34">Producto</td>
      <td width="266">Subproducto</td>
      <td width="245">Proveedor</td>
      <td width="103">Ley</td>
      <td width="78">Unidad</td>
      <td width="75">Lim.Ini</td>
      <td width="97">Lim.Fin</td>
    </tr>
    <?php		
		$Buscar='S';
				if($Buscar=='S')
				{
					$Consulta="select t1.limite_inicial,t1.limite_final,t1.cod_producto,t1.cod_subproducto,t1.cod_ley,t1.rut_proveedor,t2.descripcion as nom_producto,t3.descripcion as nom_subproducto,t4.nombre_prv,t5.nombre_leyes,t5.abreviatura,t6.nombre_unidad,t6.abreviatura as abre_uni from cal_web.limite t1 inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
					$Consulta.=" inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto";
					$Consulta.=" left join sipa_web.proveedores t4 on t1.rut_proveedor=t4.rut_prv";
					$Consulta.=" inner join proyecto_modernizacion.leyes t5 on t1.cod_ley=t5.cod_leyes";
					$Consulta.=" inner join proyecto_modernizacion.unidades t6 on t1.unidad=t6.cod_unidad";
					$Consulta.=" where t1.cod_producto<>''";
					if($CmbProductos!='T')
						$Consulta.=" and t1.cod_producto='".$CmbProductos."'";
					if($CmbSubProducto!='T')
						$Consulta.=" and t1.cod_subproducto='".$CmbSubProducto."'";
					if($CmbProductos=='1')
							$Consulta.=" and t1.rut_proveedor='".$CmbProveedores."'";
					if($CmbLeyes!='T')
						$Consulta.=" and t1.cod_ley='".$CmbLeyes."'";
					$Consulta.=" order by t2.cod_producto,t3.cod_subproducto";	
					echo "<input name='CheckTipo' type='hidden'  value=''>";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if($Fila["rut_proveedor"]==''||$Fila["rut_proveedor"]=='Null')
							$Proveedor='NO APLICA';
						if($Fila["rut_proveedor"]!='')
							$Proveedor=$Fila["rut_proveedor"]." - ".$Fila["nombre_prv"];
						if($Fila["rut_proveedor"]=='T')
							$Proveedor='TODOS';		
						$Clave=$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."~".$Fila["rut_proveedor"]."~".$Fila["cod_ley"];
						?>
    <tr>
      <?php
							?>
      <?php
							?>
      <td align='left'><?php echo $Fila["nom_producto"];?></td>
      <?php
							?>
      <td align='left'><?php echo $Fila["nom_subproducto"];?></td>
      <?php
							?>
      <td align='left'><?php echo $Proveedor;?></td>
      <?php
							?>
      <td align='left'><?php echo $Fila["abreviatura"];?></td>
      <?php
							?>
      <td align='left'><?php echo $Fila["abre_uni"];?></td>
      <?php
							?>
      <td align='right'><?php echo number_format($Fila["limite_inicial"],3,',','.');?></td>
      <?php
							?>
      <td align='right'><?php echo number_format($Fila["limite_final"],3,',','.');?></td>
      <?php
						?>
    </tr>
    <?php
					}					
				}	
			?>
  </table>
</form>
</body>
</html>
