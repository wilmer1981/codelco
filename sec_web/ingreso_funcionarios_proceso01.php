<?php
	include("../principal/conectar_principal.php");
	
	$Fecha=date('Y-m-d');
	$CodCCosto='02-'.substr($CmbCCosto2,0,2).".".substr($CmbCCosto2,2,2);
	switch ($Proceso)
	{
		case "N"://NUEVO FUNCIONARIOS
			$Insertar="insert into proyecto_modernizacion.funcionarios (rut,apellido_paterno,apellido_materno,nombres,cod_centro_costo,password,fecha_cambio_password,cuenta_red,cuenta_artikos) values (";
			$Insertar.="'$TxtCodigo','$TxtApePaterno','$TxtApeMaterno','$TxtNombres','$CodCCosto',md5('".substr($TxtCodigo,0,4)."'),'$Fecha','".$TxtCuentaCodelcoGDE."','".$TxtCuentaEnamiGDE."')";
			mysqli_query($link, $Insertar);
			//echo $Insertar;
			//echo mysql_error($link);


			break;
		case "M"://MODIFICAR FUNCIONARIO  Junio-2017 Se agrega desbloqueo de contraseña de usuario
			$Modificar="UPDATE proyecto_modernizacion.funcionarios set nombres='$TxtNombres',apellido_paterno='$TxtApePaterno',apellido_materno='$TxtApeMaterno',cuenta_red='".$TxtCuentaCodelcoGDE."',cuenta_artikos='".$TxtCuentaEnamiGDE."', ";
			if($passw=='S')
				$Modificar.="cod_centro_costo='$CodCCosto',password=md5('".substr($TxtCodigo,0,4)."'),bloqueo_pass='N',activo ='', fecha_cambio_password='$Fecha' where rut='$TxtCodigo'";
			else
				$Modificar.="cod_centro_costo='$CodCCosto' where rut='$TxtCodigo'";
				echo  $Modificar."<br>";
			mysqli_query($link, $Modificar);
			if($passw2=='S')
			{
				$Modificar="UPDATE proyecto_modernizacion.funcionarios set password2=md5('".substr($TxtCodigo,0,4)."') where rut='$TxtCodigo'";
				mysqli_query($link, $Modificar);	
			}	
			break;
		case "E"://ELIMINAR FUNCIONARIO
			$Datos=explode('//',$Valores);
			$Rut=$Datos[0];
			$Eliminar ="delete from proyecto_modernizacion.funcionarios where rut='$Rut'";
			mysqli_query($link, $Eliminar);
			break;
		case "CP":
			$Datos = explode("~~",$Valores);
			foreach($Datos as $k => $v)
			{
				//ELIMINA PERFIL EXISTENTE DEL USUARIO
				$Eliminar="delete from proyecto_modernizacion.sistemas_por_usuario where rut='".$v."'";
				mysqli_query($link, $Eliminar);
				$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario where rut='".$CmbRut."'";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Resp))
				{
					$Insertar = "insert into proyecto_modernizacion.sistemas_por_usuario (rut, cod_sistema, nivel) ";
					$Insertar.= " values('".$v."','".$Fila["cod_sistema"]."','".$Fila["nivel"]."')";
					mysqli_query($link, $Insertar);
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
		/*echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngFun.action='ingreso_funcionarios.php';";
		echo "window.opener.document.FrmIngFun.submit();";
		echo "window.close();";
		echo "</script>";*/
	}	
?>