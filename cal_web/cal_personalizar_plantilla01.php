<?php
	include("../principal/conectar_principal.php");
	$CookieRut=$_COOKIE["CookieRut"];
	$Rut=$CookieRut;
	$Opcion   = isset($_REQUEST["Opcion"])?$_REQUEST["Opcion"]:"";
	$Leyes    = isset($_REQUEST["Leyes"])?$_REQUEST["Leyes"]:"";
	
	$CmbProductos    = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:"";
	$CmbSubProducto  = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$Cod_Plantilla   = isset($_REQUEST["Cod_Plantilla"])?$_REQUEST["Cod_Plantilla"]:"";
	$TxtNombrePlantilla = isset($_REQUEST["TxtNombrePlantilla"])?$_REQUEST["TxtNombrePlantilla"]:"";
	$Salir           = isset($_REQUEST["Salir"])?$_REQUEST["Salir"]:"";
	
	switch ($Opcion)
	{		
		case "S":
			header("location:../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=12");	
			break;
		case "E":
			for ($i=0;$i<=strlen($Leyes);$i++)
			{
				if (substr($Leyes,$i,2)=="//")
				{
					$Ley = substr($Leyes,0,$i);
					$Eliminar = "delete from cal_web.leyes_por_plantillas where rut_funcionario='".$Rut."' and cod_plantilla=".$Cod_Plantilla." and cod_leyes='".$Ley."'";
					mysqli_query($link,$Eliminar);
					$Leyes=substr($Leyes,$i+2);
					$i=0;
				}
			}
			$Consulta = "select * from cal_web.leyes_por_plantillas where rut_funcionario='".$Rut."' and cod_plantilla=".$Cod_Plantilla;
			$Respuesta=mysqli_query($link,$Consulta);
			if (!$Fila=mysqli_fetch_array($Respuesta))
			{
				$Eliminar = "delete from cal_web.plantillas where rut_funcionario='".$Rut."' and cod_plantilla=".$Cod_Plantilla;
				mysqli_query($Eliminar);
				$TxtNombrePlantilla="";
			}
			header ("location:cal_personalizar_plantilla.php?Productos=".$CmbProductos."&SubProducto=".$CmbSubProducto."&Plantilla=".$Cod_Plantilla."&NombrePlantilla=".$TxtNombrePlantilla."&Salir=".$Salir);		
			break;
		case "L":
			header("location:cal_personalizar_plantilla.php?Salir=".$Salir);
			break;	
	}
?>
<html>
<head>
<title></title>
</head>
<body>
</body>
</html>
