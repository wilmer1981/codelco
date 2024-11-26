<?php
	include("../principal/conectar_principal.php");

	$Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores     = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$CodigoLote  = isset($_REQUEST["CodigoLote"])?$_REQUEST["CodigoLote"]:"";
	$NumeroLote  = isset($_REQUEST["NumeroLote"])?$_REQUEST["NumeroLote"]:"";
	$Ano         = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$subproducto = isset($_REQUEST["subproducto"])?$_REQUEST["subproducto"]:"";	
	$NumI        = isset($_REQUEST["NumI"])?$_REQUEST["NumI"]:"";
	$NumF        = isset($_REQUEST["NumF"])?$_REQUEST["NumF"]:"";
	$MesI        = isset($_REQUEST["MesI"])?$_REQUEST["MesI"]:"";
	$dia      = isset($_REQUEST["dia"])?$_REQUEST["dia"]:"";
	$mes      = isset($_REQUEST["mes"])?$_REQUEST["mes"]:"";
	$ano      = isset($_REQUEST["ano"])?$_REQUEST["ano"]:"";
	$hh       = isset($_REQUEST["hh"])?$_REQUEST["hh"]:"";
	$mm       = isset($_REQUEST["mm"])?$_REQUEST["mm"]:"";

	switch($Proceso)
	{
		case "M"://MODIFICA FECHA CREACION PAQUETES CUANDO ESTEN ABIERTOS
			$Fecha=$ano."-".$mes."-".$dia;
			$Hora=$Fecha." ".$hh.":".$mm;
			$Datos=explode('@@',$Valores);
			foreach ($Datos as $c => $v)
			{
				$Datos2=explode('//',$v);
				$CodPaquete=$Datos2[0];
				$NumPaquete=$Datos2[1];
				$Actualizar="UPDATE sec_web.paquete_catodo set fecha_creacion_paquete='$Fecha',hora='$Hora' ";
				$Actualizar.="where cod_paquete='$CodPaquete' and num_paquete='$NumPaquete' and LEFT(fecha_creacion_paquete,4)='".$Ano."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				$Actualizar="UPDATE sec_web.lote_catodo set fecha_creacion_paquete='$Fecha' ";
				$Actualizar.="where cod_bulto='$CodigoLote' and num_bulto='$NumeroLote' and cod_paquete='$CodPaquete' and num_paquete='$NumPaquete' and LEFT(fecha_creacion_paquete,4)='".$Ano."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				echo "<script languaje='JavaScript'>";
				echo "window.opener.document.frmConsulta.action='sec_detalle_paquete.php?Codigo=".$CodigoLote."&Numero=".$NumeroLote."&Ano=".$Ano."&Mes=".$MesI."&subproducto=".$subproducto."&NumI=".$NumI."&NumF=".$NumF."';";
				echo "window.opener.document.frmConsulta.submit();";
				echo "window.close();";
				echo "</script>";
			}
			break;
	}
?>