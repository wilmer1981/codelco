<?php 	
	include("../principal/conectar_sec_web.php");
	if (strlen($CmbMes)==1)
	{
		$CmbMes="0".$CmbMes;
	}
	$Fecha=$CmbAno."-".$CmbMes."-".date('d');
	$Datos=explode('//',$Valores);
	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$StockFinal=$Datos2[0];
		$CodProducto=$Datos2[1];
		$CodSubProducto=$Datos2[2];
		$Consulta="select * from sec_web.stock_final where tipo='2' and cod_producto='".$CodProducto."' and cod_subproducto='".$CodSubProducto."' and ";
		$Consulta=$Consulta." substring(fecha,1,7)=substring('".$Fecha."',1,7)";
		$Respuesta=mysqli_query($link, $Consulta);
		if (!$Fila=mysqli_fetch_array($Respuesta))
		{
			$StockFinal=0;
			$Insertar="insert into sec_web.stock_final(fecha,cod_producto,cod_subproducto,peso,bloqueo,tipo) values(";
			$Insertar=$Insertar."'$Fecha','$CodProducto','$CodSubProducto',$StockFinal,'N','2')";
			//echo $Insertar."<br>";
			mysqli_query($link, $Insertar);
		}
		else
		{
			$Actualizar="UPDATE sec_web.stock_final set peso=".$StockFinal." where tipo='2' and cod_producto='".$CodProducto."' and cod_subproducto='".$CodSubProducto."' and ";
			$Actualizar=$Actualizar." substring(fecha,1,7)=substring('".$Fecha."',1,7) and bloqueo='N'";
			mysqli_query($link, $Actualizar);
		}
		$StockFinal=0;
		$CodProducto=0;
		$CodSubProducto=0;
	}
	header('location:sec_stock_productos.php');
?>