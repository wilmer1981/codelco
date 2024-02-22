<?php
	include("../principal/conectar_principal.php");
	
	switch ($Proceso)
	{
		case "N"://NUEVO
			$Datos=explode('~',$TxtCodLeyes);
			while(list($c,$v)=each($Datos))
			{
				$Insertar="insert into age_web.leyes_canje (cod_producto,cod_subproducto,cod_ley) values (";
				$Insertar.="'1','$CmbSubProducto','$v')";
				mysqli_query($link, $Insertar);
			}	
			break;
		case "M"://MODIFICAR
			$Eliminar ="delete from age_web.leyes_canje  where cod_producto='1' and cod_subproducto='$CmbSubProducto'";
			mysqli_query($link, $Eliminar);
			$Datos=explode('~',$TxtCodLeyes);
			while(list($c,$v)=each($Datos))
			{
				$Insertar="insert into age_web.leyes_canje (cod_producto,cod_subproducto,cod_ley) values (";
				$Insertar.="'1','$CmbSubProducto','$v')";
				mysqli_query($link, $Insertar);
			}	
			break;
		case "E"://ELIMINAR
			$Eliminar ="delete from age_web.leyes_canje  where cod_producto='1' and cod_subproducto='$CmbSubProducto'";
			mysqli_query($link, $Eliminar);
			break;
	}
	header("location:age_leyes_canje_proceso.php?Recarga=S&CmbSubProducto=".$CmbSubProducto);
?>