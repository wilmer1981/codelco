<?php
	include("../principal/conectar_principal.php");
	
	$Fecha=date('Y-m-d');
	$CodCCosto='02-'.substr($CmbCCosto2,0,2).".".substr($CmbCCosto2,2);
	switch ($Proceso)
	{
		case "N"://NUEVO FUNCIONARIOS
			$Inserta="insert into proyecto_modernizacion.sistemas_por_usuario (cod_sistema,rut,nivel) values ('29','".$CmbRut."','".$CmbNivel3."')";
			//echo $Inserta."<br>";
			//$Insertar="insert into proyecto_modernizacion.funcionarios (rut,apellido_paterno,apellido_materno,nombres,cod_centro_costo,password,fecha_cambio_password) values (";
			//$Insertar.="'$TxtCodigo','$TxtApePaterno','$TxtApeMaterno','$TxtNombres','$CodCCosto','".substr($TxtCodigo,0,4)."','$Fecha')";
			mysqli_query($link,$Inserta);
			break;
		case "M"://MODIFICAR FUNCIONARIO
			$Modificar="update proyecto_modernizacion.sistemas_por_usuario set nivel='".$CmbNivel3."' where rut='$TxtCodigo' and cod_sistema='29'";
			//echo $Modificar."<br>";
			mysqli_query($link,$Modificar);
			break;
		case "E"://ELIMINAR FUNCIONARIO
			$Datos=explode('//',$Valores);
			//$Rut=$Datos[0];
			while (list($k,$v)=each($Datos))
			{
				$Eliminar ="delete from proyecto_modernizacion.sistemas_por_usuario where rut='".$v."' and cod_sistema='29'";
				mysqli_query($link,$Eliminar);
			}
			break;
		case "CP":
			$Datos = explode("~~",$Valores);
			while (list($k,$v)=each($Datos))
			{
				//ELIMINA PERFIL EXISTENTE DEL USUARIO
				$Eliminar="delete from proyecto_modernizacion.sistemas_por_usuario where rut='".$v."'";
				mysqli_query($link,$Eliminar);
				$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario where rut='".$CmbRut."'";
				$Resp = mysqli_query($link,$Consulta);
				while ($Fila=mysqli_fetch_array($Resp))
				{
					$Insertar = "insert into proyecto_modernizacion.sistemas_por_usuario (rut, cod_sistema, nivel) ";
					$Insertar.= " values('".$v."','".$Fila["cod_sistema"]."','".$Fila["nivel"]."')";
					mysqli_query($link,$Insertar);
				}
			}
			break;
	}
	if ($Proceso=="E")
	{
		header("location:ingreso_funcionarios.php?CmbCCosto=".$CmbCCosto);
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngFun.action='ingreso_funcionarios.php?&CmbRut=$CmbRut';";
		echo "window.opener.document.FrmIngFun.submit();";
		echo "window.close();";
		echo "</script>";
	}	
?>