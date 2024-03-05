<?php
	include("../principal/conectar_principal.php");
//	echo $ValoresAux;

	$Proceso   = $_REQUEST["Proceso"];
	$TxtCodigo = $_REQUEST["TxtCodigo"];
	$TxtDescrip = $_REQUEST["TxtDescrip"];
	$Valores    = $_REQUEST["Valores"];

	switch ($Proceso)
	{
		case "N":
			$Existe=false;
			$Consulta="select * from interfaces_codelco.empaque where ";
			$Consulta.="cod_empaque ='".$TxtCodigo."'";
			$Resp=mysqli_query($link, $Consulta);
			//echo $Consulta;
			if($Fila=mysqli_fetch_array($Resp))
			{
				$Existe=true;
				header("location:inter_empaques_proceso.php?Existe=".$Existe."&Proceso=".$Proceso);
			}
			else
			{
				$Insertar=" INSERT INTO interfaces_codelco.empaque ";
				$Insertar.=" (cod_empaque,descripcion) values(";
				$Insertar.=" '".$TxtCodigo."','".strtoupper($TxtDescrip)."')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
				echo "<script languaje='JavaScript'>";
				echo "window.opener.document.frmPrincipal.action='inter_empaques.php';";
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
				$Eliminar=" delete from interfaces_codelco.empaque ";
				$Eliminar.=" where cod_empaque ='".$arreglo[0]."'";
				mysqli_query($link, $Eliminar);
				//echo $Eliminar."<br>";
			}
			header("location:inter_empaques.php");
		break;
		case "M":
			//$Datos2=explode('~',$Valores);
			$Actualizar=" UPDATE  interfaces_codelco.empaque set ";
			$Actualizar.="  descripcion='".strtoupper($TxtDescrip)."' ";
			$Actualizar.=" where cod_empaque ='".$TxtCodigo."' ";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar;
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='inter_empaques.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";
		break;
	}
?>