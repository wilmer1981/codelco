<?php
	include("../principal/conectar_principal.php");

	$Proceso     = $_REQUEST["Proceso"];


	$Valores  = $_REQUEST["Valores"];
	$Ano      = $_REQUEST["Ano"];
	$NumI     = $_REQUEST["NumI"];
	$NumF     = $_REQUEST["NumF"];
	$MesI     = $_REQUEST["MesI"];
	$CodigoLote  = $_REQUEST["CodigoLote"];
	$NumeroLote  = $_REQUEST["NumeroLote"];
	$subproducto = $_REQUEST["subproducto"];

	$dia      = $_REQUEST["dia"];
	$mes      = $_REQUEST["mes"];
	$ano      = $_REQUEST["ano"];
	$hh      = $_REQUEST["hh"];
	$mm      = $_REQUEST["mm"];

	switch($Proceso)
	{
		case "M"://MODIFICA FECHA CREACION PAQUETES CUANDO ESTEN ABIERTOS
			$Fecha=$ano."-".$mes."-".$dia;
			$Hora=$Fecha." ".$hh.":".$mm;
			$Datos=explode('@@',$Valores);
			//foreach($Datos as $c => $v)
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
				echo "window.opener.document.frmConsulta.action='sec_detalle_paquete.php?Codigo=".$CodigoLote."&Numero=".$NumeroLote."&Ano=".$Ano."&Mes=".$Mes."&subproducto=".$subproducto."&NumI=".$NumI."&NumF=".$NumF."';";
				echo "window.opener.document.frmConsulta.submit();";
				echo "window.close();";
				echo "</script>";
			}
			break;
	}
?>