<?php
	include("../principal/conectar_principal.php");

    $Proceso      = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores      = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	//VARIABLES POST
	if(isset($_POST["CmbRut"])){
	$CmbRut=$_POST["CmbRut"];
	}else{
		$CmbRut="";
	}

	$TxtNombres    = isset($_REQUEST["TxtNombres"])?$_REQUEST["TxtNombres"]:"";
	$TxtApePaterno = isset($_REQUEST["TxtApePaterno"])?$_REQUEST["TxtApePaterno"]:"";
	$TxtApeMaterno = isset($_REQUEST["TxtApeMaterno"])?$_REQUEST["TxtApeMaterno"]:"";
	$TxtBloqueo    = isset($_REQUEST["TxtBloqueo"])?$_REQUEST["TxtBloqueo"]:"";
	$TxtCuentaCodelcoGDE    = isset($_REQUEST["TxtCuentaCodelcoGDE"])?$_REQUEST["TxtCuentaCodelcoGDE"]:"";
	$TxtCuentaEnamiGDE      = isset($_REQUEST["TxtCuentaEnamiGDE"])?$_REQUEST["TxtCuentaEnamiGDE"]:"";
	$TxtCodigo              = isset($_REQUEST["TxtCodigo"])?$_REQUEST["TxtCodigo"]:"";
	$CmbCCosto2             = isset($_REQUEST["CmbCCosto2"])?$_REQUEST["CmbCCosto2"]:"";
	
	if($Proceso=="M"){
		$passw   = isset($_REQUEST["passw"])?$_REQUEST["passw"]:"";
		$passw2  = isset($_REQUEST["passw2"])?$_REQUEST["passw2"]:"";
	}

	/////////////////////////////////////////////////////////////////
	$Fecha=date('Y-m-d');
    $CodCCosto='02-'.substr($CmbCCosto2,0,2).".".substr($CmbCCosto2,2,2);
	
	switch ($Proceso)
	{
		case "N"://NUEVO FUNCIONARIOS
			$consulta= "SELECT rut FROM proyecto_modernizacion.funcionarios WHERE rut ='".$TxtCodigo."' ";
			$result = mysqli_query($link, $consulta);
			if ($row = mysqli_fetch_array($result))
			{
				$Error = "S";
				$Mensaje = "Operacion no realizada, Funcionario ya existe";				
			}else{								
				$Insertar="INSERT into proyecto_modernizacion.funcionarios (rut,apellido_paterno,apellido_materno,nombres,cod_centro_costo,password,fecha_cambio_password,cod_ceco,cuenta_red,cuenta_artikos) values (";
				$Insertar.="'".$TxtCodigo."','".$TxtApePaterno."','".$TxtApeMaterno."','".$TxtNombres."','".$CodCCosto."',md5('".substr($TxtCodigo,0,4)."'),'$Fecha','".$CmbCCosto2."','".$TxtCuentaCodelcoGDE."','".$TxtCuentaEnamiGDE."')";
				mysqli_query($link, $Insertar);
			}		
			//header("location:ingreso_funcionarios.php?Sistema=".$Sistema."&Proceso=M&CodPantalla=".$CodPantalla."&Error=".$Error."&Mensaje=".$Mensaje);
			//echo $Insertar;
			//echo mysql_error($link);
			break;
		case "M"://MODIFICAR FUNCIONARIO  Junio-2017 Se agrega desbloqueo de contraseña de usuario
			$Modificar="UPDATE proyecto_modernizacion.funcionarios SET nombres='".$TxtNombres."',apellido_paterno='".$TxtApePaterno."',apellido_materno='".$TxtApeMaterno."',cuenta_red='".$TxtCuentaCodelcoGDE."',cuenta_artikos='".$TxtCuentaEnamiGDE."', ";
			if($passw=='S')
				$Modificar.="cod_centro_costo='".$CodCCosto."',password=md5('".substr($TxtCodigo,0,4)."'),bloqueo_pass='N',activo ='', fecha_cambio_password='$Fecha' WHERE rut='".$TxtCodigo."'";
			else
				$Modificar.="cod_centro_costo='".$CodCCosto."' where rut='".$TxtCodigo."'";
		   		
			//echo  $Modificar."<br>";
			//exit();

			mysqli_query($link, $Modificar);
			if($passw2=='S')
			{
				$Modificar="UPDATE proyecto_modernizacion.funcionarios set password2=md5('".substr($TxtCodigo,0,4)."') where rut='".$TxtCodigo."'";
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
			//echo "entrooooo";
			$Datos = explode("~~",$Valores);
			//while (list($k,$v)=each($Datos))
			foreach ($Datos as $k => $v)
			{
				//ELIMINA PERFIL EXISTENTE DEL USUARIO
				//echo "RUT:".$v;
				//echo "CmbRut:".$CmbRut;
				//exit();
				$Eliminar="DELETE from proyecto_modernizacion.sistemas_por_usuario where rut='".$v."'";
				mysqli_query($link, $Eliminar);
				$Consulta = "SELECT * from proyecto_modernizacion.sistemas_por_usuario where rut='".$CmbRut."'";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Resp))
				{
					$Insertar = "INSERT into proyecto_modernizacion.sistemas_por_usuario (rut, cod_sistema, nivel) ";
					$Insertar.= " values('".$v."','".$Fila["cod_sistema"]."','".$Fila["nivel"]."')";
					mysqli_query($link, $Insertar);
				}
			}
			break;
	}

	if ($Proceso=="E")
	{
		header("location:ingreso_funcionarios.php?CmbCCosto=".$CmbCCosto2);
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngFun.action='ingreso_funcionarios.php';";
		echo "window.opener.document.FrmIngFun.submit();";
		echo "window.close();";
		echo "</script>";
	}	
?>