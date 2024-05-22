<?php
	include("../principal/conectar_principal.php");
	//echo "EEE".$Proceso;
	
	$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
    $Valores   = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";	

	$TxtCodigo      = isset($_REQUEST["TxtCodigo"])?$_REQUEST["TxtCodigo"]:"";
	$TxtDescripcion = isset($_REQUEST["TxtDescripcion"])?$_REQUEST["TxtDescripcion"]:"";
	$TxtValor1 = isset($_REQUEST["TxtValor1"])?$_REQUEST["TxtValor1"]:"";
	$TxtValor2 = isset($_REQUEST["TxtValor2"])?$_REQUEST["TxtValor2"]:"";
	$TxtValor3 = isset($_REQUEST["TxtValor3"])?$_REQUEST["TxtValor3"]:"";
	$TxtCodSubProdu = isset($_REQUEST["TxtCodSubProdu"])?$_REQUEST["TxtCodSubProdu"]:"";
	$Txtmostrar = isset($_REQUEST["Txtmostrar"])?$_REQUEST["Txtmostrar"]:"";
	$TxtAbrevia = isset($_REQUEST["TxtAbrevia"])?$_REQUEST["TxtAbrevia"]:"";
	$TxtLotes   = isset($_REQUEST["TxtLotes"])?$_REQUEST["TxtLotes"]:"";
	$TxtFlujos  = isset($_REQUEST["TxtFlujos"])?$_REQUEST["TxtFlujos"]:"";
	$TxtAnodo   = isset($_REQUEST["TxtAnodo"])?$_REQUEST["TxtAnodo"]:"";
	$TxtMostrarSea = isset($_REQUEST["TxtMostrarSea"])?$_REQUEST["TxtMostrarSea"]:"";
	$TxtAplicacion = isset($_REQUEST["TxtAplicacion"])?$_REQUEST["TxtAplicacion"]:"";
	$TxtRutProv    = isset($_REQUEST["TxtRutProv"])?$_REQUEST["TxtRutProv"]:"";
	$TxtProdRam    = isset($_REQUEST["TxtProdRam"])?$_REQUEST["TxtProdRam"]:"";
	$TxtMostrarPmn = isset($_REQUEST["TxtMostrarPmn"])?$_REQUEST["TxtMostrarPmn"]:"";
	$TxtTipMov     = isset($_REQUEST["TxtTipMov"])?$_REQUEST["TxtTipMov"]:"";
	$TxtStockSec   = isset($_REQUEST["TxtStockSec"])?$_REQUEST["TxtStockSec"]:"";
	$TxtOrdenStockSec = isset($_REQUEST["TxtOrdenStockSec"])?$_REQUEST["TxtOrdenStockSec"]:"";
	$TxtMostrar2      = isset($_REQUEST["TxtMostrar2"])?$_REQUEST["TxtMostrar2"]:"";
	$TxtBalanceSec    = isset($_REQUEST["TxtBalanceSec"])?$_REQUEST["TxtBalanceSec"]:"";
	$TxtTipoMovPmn    = isset($_REQUEST["TxtTipoMovPmn"])?$_REQUEST["TxtTipoMovPmn"]:"";
	$TxtProductoSipa  = isset($_REQUEST["TxtProductoSipa"])?$_REQUEST["TxtProductoSipa"]:"";
	$TxtRecepcion     = isset($_REQUEST["TxtRecepcion"])?$_REQUEST["TxtRecepcion"]:"";
	$TxtMostrarAge    = isset($_REQUEST["TxtMostrarAge"])?$_REQUEST["TxtMostrarAge"]:"";
	$TxtClaseProducto = isset($_REQUEST["TxtClaseProducto"])?$_REQUEST["TxtClaseProducto"]:"";
	$TxtHumedad       = isset($_REQUEST["TxtHumedad"])?$_REQUEST["TxtHumedad"]:"";
	$TxtEtiqueta      = isset($_REQUEST["TxtEtiqueta"])?$_REQUEST["TxtEtiqueta"]:"";
	
	$EncontroRelacion = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:false;
	
	switch ($Proceso)
	{
		case "NC"://NUEVA PRODUCTO
			$Insertar="insert into proyecto_modernizacion.productos(cod_producto,descripcion,Mostrar,abreviatura,balance_sec) values (";
			$Insertar.="'".$TxtCodigo."','".$TxtDescripcion."','".$TxtValor1."','".$TxtValor2."','".$TxtValor3."')";
			mysqli_query($link, $Insertar);
			break;
		case "MC"://MODIFICA PRODUCTO 
			$Modificar="UPDATE proyecto_modernizacion.productos set descripcion='".$TxtDescripcion."',Mostrar='".$TxtValor1."',abreviatura='".$TxtValor2."',balance_sec='".$TxtValor3."' ";
			$Modificar.="where cod_producto='".$TxtCodigo."'";
			mysqli_query($link, $Modificar);
			break;
		case "NS"://NUEVA SUBPRODUCTO
			$Insertar="insert into proyecto_modernizacion.subproducto (cod_producto,cod_subproducto,descripcion,mostrar,abreviatura,lotes,flujos,mostrar_anodos,mostrar_sea,ap_subproducto,rut_prov,prod_ram,mostrar_pmn,";
			$Insertar.="tipo_mov,stock_sec,orden_stock_sec,mostrar2,balance_sec,tipo_mov_pmn,producto_sipa,recepcion,mostrar_age,clase_producto,humedad,abreviatura_etiqueta_sec) values(";
			$Insertar.=" '".$TxtCodigo."','".$TxtCodSubProdu."','".$TxtDescripcion."','".$Txtmostrar."','".$TxtAbrevia."','".$TxtLotes."','".$TxtFlujos."','".$TxtAnodo."','".$TxtMostrarSea."','".$TxtAplicacion."','".$TxtRutProv."','".$TxtProdRam."','".$TxtMostrarPmn."'";
			$Insertar.=" ,'".$TxtTipMov."','".$TxtStockSec."','".$TxtOrdenStockSec."','".$TxtMostrar2."','".$TxtBalanceSec."','".$TxtTipoMovPmn."','".$TxtProductoSipa."','".$TxtRecepcion."','".$TxtMostrarAge."','".$TxtClaseProducto."','".$TxtHumedad."','".$TxtEtiqueta."')";
			//echo "TTTT".$Insertar;
			mysqli_query($link, $Insertar);
			break;
		case "MS"://MODIFICA SUBPRODUCTO 
		  	$Modificar="UPDATE proyecto_modernizacion.subproducto set descripcion='".$TxtDescripcion."',mostrar='".$Txtmostrar."',abreviatura='".$TxtAbrevia."',lotes='".$TxtLotes."',flujos='".$TxtFlujos."',mostrar_anodos='".$TxtAnodo."', ";
			$Modificar.="mostrar_sea='".$TxtMostrarSea."',ap_subproducto='".$TxtAplicacion."',rut_prov='".$TxtRutProv."',prod_ram='".$TxtProdRam."',mostrar_pmn='".$TxtMostrarPmn."',tipo_mov='".$TxtTipMov."',stock_sec='".$TxtStockSec."',";
			$Modificar.="orden_stock_sec='".$TxtOrdenStockSec."',mostrar2='".$TxtMostrar2."',tipo_mov_pmn='".$TxtTipoMovPmn."',producto_sipa='".$TxtProductoSipa."',recepcion='".$TxtRecepcion."',mostrar_age='".$TxtMostrarAge."',";
			$Modificar.=" clase_producto='".$TxtClaseProducto."',humedad='".$TxtHumedad."',balance_sec='".$TxtBalanceSec."' where cod_producto='".$TxtCodigo."' and cod_subproducto='".$TxtCodSubProdu."'";
			mysqli_query($link, $Modificar);
			break;
		case "ES"://ELIMINAR SUBPRODUCTO
		    $CodigoSub=$TxtCodSubProdu;
		    $Eliminar ="delete from proyecto_modernizacion.subproducto where cod_producto='".$TxtCodigo."' and cod_subproducto='".$CodigoSub."' ";
			mysqli_query($link, $Eliminar);
			break;
		case "E"://ELIMINAR PRODUCTO
			$Datos=explode('//',$Valores);
			//while (list($Clave,$Valor)=each($Datos))
			foreach ($Datos as $Clave => $Valor)
			{
				$Consulta="select * from proyecto_modernizacion.subproducto where cod_producto ='".$Valor."'";
				$Respuesta=mysqli_query($link, $Consulta);
				if(!$Fila=mysqli_fetch_array($Respuesta))
				{
					$Eliminar ="delete from proyecto_modernizacion.productos where cod_producto='".$Valor."'";
					mysqli_query($link, $Eliminar);
				}
				else
				{
					$EncontroRelacion=true;
				}	
			}
			break;	
						
	}
	
	if ($Proceso=="E")
	{
		header("location:ingreso_prod_subprod.php?EncontroRelacion=".$EncontroRelacion);
	}
	else
	{
		if ($Proceso=="NC"||$Proceso=="MC")
		{
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmIngProdSubprod.action='ingreso_prod_subprod.php';";
			echo "window.opener.document.FrmIngProdSubprod.submit();";
			echo "window.close();";
			echo "</script>";
		}
		else
		{
		
			header("location:ingreso_prod_subprod_proceso2.php?Proceso=NS&Valores=".$Valores);
		}	
	}	
?>