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
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 37;
	set_time_limit(1000);
	include("../principal/conectar_principal.php");
    //$link = mysql_connect("10.56.11.7","adm_bd","672312");
	//mysql_select_db("proyecto_modernizacion", $link);

		$ChkSolicitud = $_REQUEST["ChkSolicitud"];
		$Busq = $_REQUEST["Busq"];
		$Mostrar = $_REQUEST["Mostrar"];
		$Orden = $_REQUEST["Orden"];
		$CmbProductos = $_REQUEST["CmbProductos"];
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];
		$Proveedor = $_REQUEST["Proveedor"];
		$TxtFiltroPrv = $_REQUEST["TxtFiltroPrv"];
		$CmbSeleccion = $_REQUEST["CmbSeleccion"];
		$CmbEstado = $_REQUEST["CmbEstado"];
		$Mes = $_REQUEST["Mes"];
		$Ano = $_REQUEST["Ano"];
	
?>
<html>
<head>
<title>CAL- Estados Solicitudes Excel</title>
</head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
  <?php		
  	$Mostrar='S';
		if ($Mostrar=="S")
		{
			if($CmbProductos=='1')
				include('cal_con_estados_full_producto_minero_excel.php');
			else
				include('cal_con_estados_full_otros_productos_excel.php');	
		}//FIN MOSTRAR = S	
		?>
</form>
</body>
</html>
