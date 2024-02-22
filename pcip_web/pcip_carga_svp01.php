<?php
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");


$Directorio='doc';
$Seg=date("s");

if($Archivo_name!='none')
{
	$Extension=explode('.',$Archivo_name);
	if(strtoupper($Extension[1])=='MDB')
	{
		$Acento=false;
		for ($j = 0;$j <= strlen($Archivo_name); $j++)
		{
			switch(substr($Archivo_name,$j,1))
			{
				case "á":
					$Archivo_name=str_replace( "á","a",$Archivo_name);
				break;
				case "Á":
					$Archivo_name=str_replace( "Á","A",$Archivo_name);
				break;
				case "é":
					$Archivo_name=str_replace( "é","e",$Archivo_name);
				break;
				case "É":
					$Archivo_name=str_replace( "É","E",$Archivo_name);
				break;
				case "í":
					$Archivo_name=str_replace( "í","i",$Archivo_name);
				break;
				case "Í":
					$Archivo_name=str_replace( "Í","I",$Archivo_name);
				break;
				case "ó":
					$Archivo_name=str_replace( "ó","o",$Archivo_name);
				break;
				case "Ó":
					$Archivo_name=str_replace( "Ó","O",$Archivo_name);
				break;
				case "ú":
					$Archivo_name=str_replace( "ú","u",$Archivo_name);
				break;
				case "Ú":
					$Archivo_name=str_replace( "Ú","U",$Archivo_name);
				break;
				case "&":
					$Archivo_name=str_replace( "&","",$Archivo_name);
				break;
				case "$":
					$Archivo_name=str_replace( "$","",$Archivo_name);
				break;
				case "#":
					$Archivo_name=str_replace( "#","",$Archivo_name);
				break;
				case "'":
					$Archivo_name=str_replace( "'","",$Archivo_name);
				break;
			}
		}
		if($Acento==false)
		{
				$NombreArchivo=$Archivo_name;
				if (copy($Archivo, $Directorio."/".$NombreArchivo))
					$ProcesaArchivo = "S";
				else
					$ProcesaArchivo = "N";
		}
	}
	else
		$ProcesaArchivo = "N";
}
if($ProcesaArchivo=="S")
{
	EliminarMesProceso($Ano,$Mes);
	CargarDatos($Ano,$Mes);
	$Mensaje='Archivo Procesado Exitosamente';
	header("location:pcip_carga_svp.php?Mensaje=".$Mensaje."&Ano2=".$Ano);
}
else
{
	$Mensaje='Problema al Cargar Base de Datoa Access, Archivo No Cargado';
	header("location:pcip_carga_svp.php?Mensaje=".$Mensaje);
}
function CargarDatos($Ano,$Mes)
{
	include("conectar_odbc.php");
	
	/*$Consulta = "select * from ConsumosInternos";
	$Respuesta= odbc_exec($conexion,$Consulta);
	while ($Fila = odbc_fetch_row($Respuesta))
	{  
		$Insertar="INSERT INTO pcip_consumosinternos (CImaterial,CIordenrecep,CIcantidad,CIValor) VALUES ('".odbc_result($Respuesta,"CImaterial")."','".odbc_result($Respuesta,"CIordenrecep")."','".odbc_result($Respuesta,"CIcantidad")."','".odbc_result($Respuesta,"CIValor")."')";
		//echo $Insertar."<br>";
		mysql_query($Insertar);
	}*/	
//	$Consulta = "select * from CuentasMayor";
//	$Respuesta= odbc_exec($conexion,$Consulta);
//	while ($Fila = odbc_fetch_row($Respuesta))
//	{  
//		$Insertar="INSERT INTO pcip_cuentasmayor (CMcodigo,CMdescripcion) VALUES ('".odbc_result($Respuesta,"CMcodigo")."','".odbc_result($Respuesta,"CMdescripcion")."')";
//		//echo $Insertar."<br>";
//		mysql_query($Insertar);
//	}	
	$Consulta = "select * from Materiales";
	$Respuesta= odbc_exec($conexion,$Consulta);
	while ($Fila = odbc_fetch_row($Respuesta))
	{  
		$Insertar="INSERT INTO `pcip_svp_materiales` (`MAcodigo`,`MAdescripcion`,`MAorden`,`MAalmacen`,`MAclasevalor`) VALUES ";
		$Insertar.="('".odbc_result($Respuesta,"MAcodigo")."','".odbc_result($Respuesta,"MAdescripcion")."','".odbc_result($Respuesta,"MAorden")."','".odbc_result($Respuesta,"MAalmacen")."','".odbc_result($Respuesta,"MAclasevalor")."')";
		//echo $Insertar."<br>";
		mysql_query($Insertar);
	}	
//	$Consulta = "select * from MaterialPrincipal";
//	$Respuesta= odbc_exec($conexion,$Consulta);
//	while ($Fila = odbc_fetch_row($Respuesta))
//	{  
//		$Insertar="INSERT INTO `pcip_svp_materialprincipal` (`MPorden`,`MPmaterial`) VALUES ('".odbc_result($Respuesta,"MPorden")."','".odbc_result($Respuesta,"MPmaterial")."')";
//		mysql_query($Insertar);
//	}	
//	$Consulta = "select * from OrdenesDestino";
//	$Respuesta= odbc_exec($conexion,$Consulta);
//	while ($Fila = odbc_fetch_row($Respuesta))
//	{  
//		$Insertar="INSERT INTO `pcip_svp_ordenesdestino` (`ODorden`,`ODdescripcion`) VALUES ('".odbc_result($Respuesta,"ODorden")."','".odbc_result($Respuesta,"ODdescripcion")."')";
//		//echo $Insertar."<br>";
//		mysql_query($Insertar);
//	}	
	$Consulta = "select * from OrdenesProduccion";
	$Respuesta= odbc_exec($conexion,$Consulta);
	while ($Fila = odbc_fetch_row($Respuesta))
	{  
		$Insertar="INSERT INTO `pcip_svp_ordenesproduccion` (`OPorden`,`OPdescripcion`,`OPsecuencia`,`OPunidad`,`OPcentrobenef`,`OPctacostovta`,`OPctaexistencia`) VALUES ";
		$Insertar.="('".odbc_result($Respuesta,"OPorden")."','".odbc_result($Respuesta,"OPdescripcion")."','".odbc_result($Respuesta,"OPsecuencia")."','".odbc_result($Respuesta,"OPunidad")."','".odbc_result($Respuesta,"OPcentrobenef")."','".odbc_result($Respuesta,"OPctacostovta")."','".odbc_result($Respuesta,"OPunidad")."')";
		//echo $Insertar."<br>";
		mysql_query($Insertar);
	}
//	$Consulta = "select * from OrdenStock";
//	$Respuesta= odbc_exec($conexion,$Consulta);
//	while ($Fila = odbc_fetch_row($Respuesta))
//	{  
//		$Insertar="INSERT INTO `pcip_ordenstock` (`OSmaterial`,`OSmaterial`) values ('".odbc_result($Respuesta,"OSmaterial")."','".odbc_result($Respuesta,"OSmaterial")."')";
//		//echo $Insertar."<br>";
//		mysql_query($Insertar);
//	}	
	$Consulta = "select * from RelMateriales";
	$Respuesta= odbc_exec($conexion,$Consulta);
	while ($Fila = odbc_fetch_row($Respuesta))
	{  
		$Consulta="select * from pcip_svp_relmateriales where RMmaterial='".odbc_result($Respuesta,"RMmaterial")."' and RMmaterialequivalente='".odbc_result($Respuesta,"RMmaterialequivalente")."'";
		$Resp=mysql_query($Consulta);
		if(!$Fila=mysql_fetch_array($Resp))
		{
			$Insertar="INSERT INTO `pcip_svp_relmateriales` (`RMmaterial`,`RMmaterialequivalente`)  values ('".odbc_result($Respuesta,"RMmaterial")."','".odbc_result($Respuesta,"RMmaterialequivalente")."')";
			//echo $Insertar."<br>";
			mysql_query($Insertar);
		}
	}	
//	$Consulta = "select * from StockOrden";
//	$Respuesta= odbc_exec($conexion,$Consulta);
//	while ($Fila = odbc_fetch_row($Respuesta))
//	{  
//		$Insertar="INSERT INTO `pcip_svp_stockorden` (`SOmaterial`,`SOordenrecep`,`SOcantidad`)  values ('".odbc_result($Respuesta,"SOmaterial")."','".odbc_result($Respuesta,"SOordenrecep")."','".odbc_result($Respuesta,"SOcantidad")."')";
//		//echo $Insertar."<br>";
//		mysql_query($Insertar);
//	}	
//	$Consulta = "select * from StockVentas";
//	$Respuesta= odbc_exec($conexion,$Consulta);
//	while ($Fila = odbc_fetch_row($Respuesta))
//	{  
//		$Insertar="INSERT INTO `pcip_svp_stockventas` (`SVorden`,`SVcantidad`,`SVvalor`) values ('".odbc_result($Respuesta,"SVorden")."','".odbc_result($Respuesta,"SVcantidad")."','".odbc_result($Respuesta,"SVvalor")."')";
//		//echo $Insertar."<br>";
//		mysql_query($Insertar);
//	}	
	$Consulta = "select * from TiposInventarios";
	$Respuesta= odbc_exec($conexion,$Consulta);
	while ($Fila = odbc_fetch_row($Respuesta))
	{  
		$Insertar="INSERT INTO `pcip_svp_tiposinventarios` (`TIcodigo`,`TIdescripcion`,`TIorden`) values ('".odbc_result($Respuesta,"TIcodigo")."','".odbc_result($Respuesta,"TIdescripcion")."','".odbc_result($Respuesta,"TIorden")."')";
		//echo $Insertar."<br>";
		mysql_query($Insertar);
	}	
	$Consulta = "select * from ValorizacProduccion where VPaño=".$Ano." and VPmes=".$Mes;
	//$Consulta = "select * from ValorizacProduccion ";
	//echo $Consulta;
	$Respuesta= odbc_exec($conexion,$Consulta);
	while ($Fila = odbc_fetch_row($Respuesta))
	{  
		$Insertar="INSERT INTO `pcip_svp_valorizacproduccion` (`VPaño`,`VPmes`,`VPorden`,`VPtm`,`VPsubtm`,`VPordenrel`,`VPmaterial`,`VPtipinv`,`VPtv`,`VPordes`,`VPcantidad`,`VPcostun`,`VPvalor`,`VPdiaref`) VALUES ";
		$Insertar.="('".odbc_result($Respuesta,"VPaño")."','".odbc_result($Respuesta,"VPmes")."','".odbc_result($Respuesta,"VPorden")."','".odbc_result($Respuesta,"VPtm")."','".odbc_result($Respuesta,"VPsubtm")."','".odbc_result($Respuesta,"VPordenrel")."','".odbc_result($Respuesta,"VPmaterial")."','".odbc_result($Respuesta,"VPtipinv")."',";
		$Insertar.="'".odbc_result($Respuesta,"VPtv")."','".odbc_result($Respuesta,"VPordes")."','".odbc_result($Respuesta,"VPcantidad")."','".odbc_result($Respuesta,"VPcostun")."','".odbc_result($Respuesta,"VPvalor")."','".odbc_result($Respuesta,"VPdiaref")."')";
		//echo $Insertar."<br>";
		mysql_query($Insertar);
	}

}

function EliminarMesProceso($Ano,$Mes)
{
	//$Eliminar='delete from pcip_consumosinternos ';
	//mysql_query($Eliminar);
//	$Eliminar='delete from pcip_cuentasmayor ';
//	mysql_query($Eliminar);
	$Eliminar='delete from pcip_svp_materiales ';
	mysql_query($Eliminar);
	$Eliminar='delete from pcip_svp_materialprincipal ';
	mysql_query($Eliminar);
	$Eliminar='delete from pcip_svp_ordenesdestino ';
	mysql_query($Eliminar);
	$Eliminar='delete from pcip_svp_ordenesproduccion ';
	mysql_query($Eliminar);
//	$Eliminar='delete from pcip_ordenstock ';
//	mysql_query($Eliminar);
//	$Eliminar='delete from pcip_svp_relmateriales ';
//	mysql_query($Eliminar);
//	$Eliminar='delete from pcip_svp_stockorden ';
//	mysql_query($Eliminar);
//	$Eliminar='delete from pcip_stockventas ';
//	mysql_query($Eliminar);
	$Eliminar='delete from pcip_svp_tiposinventarios ';
	mysql_query($Eliminar);
	//$Eliminar='delete from pcip_svp_valorizacproduccion ';
	$Eliminar='delete from pcip_svp_valorizacproduccion where VPaño="'.$Ano.'" and VPmes="'.$Mes.'" ';
	mysql_query($Eliminar);

}
?>
