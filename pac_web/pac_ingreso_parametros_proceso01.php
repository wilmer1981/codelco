<?php
	include("../principal/conectar_pac_web.php");

	
	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$TxtCodigo = isset($_REQUEST["TxtCodigo"])?$_REQUEST["TxtCodigo"]:"";
	$TxtNombre     = isset($_REQUEST["TxtNombre"])?$_REQUEST["TxtNombre"]:"";
	$TxtValor1     = isset($_REQUEST["TxtValor1"])?$_REQUEST["TxtValor1"]:"";
	$TxtValor2     = isset($_REQUEST["TxtValor2"])?$_REQUEST["TxtValor2"]:"";

	$Entrar=true;
	switch ($Proceso)
	{
		case "N":
			$Consulta="select * from pac_web.parametros where codigo='".$TxtCodigo."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				header("location:pac_ingreso_parametros_proceso.php?EncontroCoincidencia=true");
				$Entrar=false;
			}
			else
			{
				$Insertar="insert into pac_web.parametros (codigo,nombre,valor1,valor2) values (";
				$Insertar = $Insertar."'$TxtCodigo','$TxtNombre','$TxtValor1','$TxtValor2')";
				mysqli_query($link, $Insertar);
			}	
			break;
		case "M":
			$Modificar="UPDATE pac_web.parametros set nombre='$TxtNombre',valor1='$TxtValor1',valor2='$TxtValor2' where codigo='".$TxtCodigo."'";
			mysqli_query($link, $Modificar);
			break;
		case "E":
			$EncontroRelacion=false;
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$Codigo=substr($Datos,0,$i);
					$Eliminar ="delete from pac_web.parametros where codigo='".$Codigo."'";
					mysqli_query($link, $Eliminar);
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}
			break;	
	}
	if ($Entrar==true)
	{
		if ($Proceso=="E")
		{
			header("location:pac_ingreso_parametros.php?EncontroRelacion=".$EncontroRelacion);
		}
		else
		{
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmIngParam.action='pac_ingreso_parametros.php';";
			echo "window.opener.document.FrmIngParam.submit();";
			echo "window.close();";
			echo "</script>";
		}	
	}	
?>