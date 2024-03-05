<?php
	include("../principal/conectar_principal.php");
//	echo $ValoresAux;

$Proceso        = $_REQUEST["Proceso"];
$CmbRutPrv      = $_REQUEST["CmbRutPrv"];
$TxtAsig        = $_REQUEST["TxtAsig"];
$TxtSalida      = $_REQUEST["TxtSalida"];
$TxtEntrada     = $_REQUEST["TxtEntrada"];
$Agrupados      = $_REQUEST["Agrupados"];
$Valores        = $_REQUEST["Valores"];


	switch ($Proceso)
	{
		case "N":
			$Existe=false;
			$Consulta="select * from interfaces_codelco.asignaciones where ";
			$Consulta.="asignacion ='".$TxtAsig."' and rut_proveedor='".$CmbRutPrv."' ";
			$Resp=mysqli_query($link, $Consulta);
			//echo $Consulta;
			if($Fila=mysqli_fetch_array($Resp))
			{
				$Existe=true;
				header("location:inter_asignaciones_proceso.php?Existe=".$Existe."&Proceso=".$Proceso);
			}
			else
			{
				$Insertar=" INSERT INTO interfaces_codelco.asignaciones ";
				$Insertar.=" (asignacion,rut_proveedor,entrada,salida,agrupados) values(";
				$Insertar.=" '".$TxtAsig."','".$CmbRutPrv."','".$TxtEntrada."',";
				$Insertar.=" '".$TxtSalida."','".$Agrupados."')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
				echo "<script languaje='JavaScript'>";
				echo "window.opener.document.frmPrincipal.action='inter_asignaciones.php';";
				echo "window.opener.document.frmPrincipal.submit();";
				echo "window.close();</script>";
			}
		break;
		case "E":
			$Datos = explode("//",$Valores);
			//foreach($Datos as $clave => $Codigo)
			foreach ($Datos as $clave => $Codigo)
			{
				$arreglo=explode("~",$Codigo);
				$Eliminar=" delete from interfaces_codelco.asignaciones ";
				$Eliminar.=" where asignacion ='".$arreglo[1]."' and rut_proveedor='".$arreglo[0]."'";
				mysqli_query($link, $Eliminar);
				//echo $Eliminar."<br>";
			}
			header("location:inter_asignaciones.php");
		break;
		case "M":
			//$Datos2=explode('~',$Valores);
			$Actualizar=" UPDATE  interfaces_codelco.asignaciones set ";
			$Actualizar.="  entrada='".$TxtEntrada."' , salida = '".$TxtSalida."', agrupados='".$Agrupados."'";
			$Actualizar.=" where asignacion ='".$TxtAsig."' and rut_proveedor='".$CmbRutPrv."' ";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar;
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='inter_asignaciones.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";
		break;
	}
?>