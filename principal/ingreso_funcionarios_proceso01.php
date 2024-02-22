<?php
	include("../principal/conectar_principal.php");


	if(isset($_GET["Proceso"])){
		$Proceso = $_GET["Proceso"];
	}else{
		$Proceso = "";
	}
	if(isset($_REQUEST["Valores"])){
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores = "";
	}


	//Proceso=M&TxtCodigo=40957290-7&CmbCCosto2=FA140

	//Frm.action="ingreso_funcionarios_proceso01.php?Proceso="+Proceso+"&TxtCodigo="+Frm.TxtCodigo.value+"&CmbCCosto2="+Frm.CmbCCosto2.value+"&Valores="+Valores;

	//VARIABLES POST
	if(isset($_POST["CmbRut"])){
	$CmbRut=$_POST["CmbRut"];
	}else{
		$CmbRut="";
	}

	if(isset($_POST["TxtCodigo"])){
		$TxtCodigo = $_POST["TxtCodigo"];
	}else{
		$TxtCodigo = "";
	}
	if(isset($_POST["TxtNombres"])){
		$TxtNombres = $_POST["TxtNombres"];
	}else{
		$TxtNombres = "";
	}
	if(isset($_POST["TxtApePaterno"])){
		$TxtApePaterno = $_POST["TxtApePaterno"];
	}else{
		$TxtApePaterno = "";
	}
	if(isset($_POST["TxtApeMaterno"])){
		$TxtApeMaterno = $_POST["TxtApeMaterno"];
	}else{
		$TxtApeMaterno = "";
	}
	if(isset($_POST["CmbCCosto2"])){
		$CmbCCosto2    = $_POST["CmbCCosto2"];
	}else{
		$CmbCCosto2 = "";
	}
	if(isset($_POST["TxtBloqueo"])){
		$TxtBloqueo    = $_POST["TxtBloqueo"];
	}else{
		$TxtBloqueo = "";
	}
	if(isset($_POST["TxtCuentaCodelcoGDE"])){
		$TxtCuentaCodelcoGDE    = $_POST["TxtCuentaCodelcoGDE"];
	}else{
		$TxtCuentaCodelcoGDE = "";
	}
	if(isset($_POST["TxtCuentaEnamiGDE"])){
		$TxtCuentaEnamiGDE    = $_POST["TxtCuentaEnamiGDE"];
	}else{
		$TxtCuentaEnamiGDE = "";
	}

	if($Proceso=="M"){
		$passw   = $_POST["passw"];
		$passw2  = $_POST["passw2"];
	}

	/////////////////////////////////////////////////////////////////
	$Fecha=date('Y-m-d');
    $CodCCosto='02-'.substr($CmbCCosto2,0,2).".".substr($CmbCCosto2,2,2);
	
	switch ($Proceso)
	{
		case "N"://NUEVO FUNCIONARIOS
			$Insertar="INSERT into proyecto_modernizacion.funcionarios (rut,apellido_paterno,apellido_materno,nombres,cod_centro_costo,password,fecha_cambio_password,cod_ceco,cuenta_red,cuenta_artikos) values (";
			$Insertar.="'".$TxtCodigo."','".$TxtApePaterno."','".$TxtApeMaterno."','".$TxtNombres."','".$CodCCosto."',md5('".substr($TxtCodigo,0,4)."'),'$Fecha','".$CmbCCosto2."','".$TxtCuentaCodelcoGDE."','".$TxtCuentaEnamiGDE."')";
			mysqli_query($link, $Insertar);
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
			echo "entrooooo";
			$Datos = explode("~~",$Valores);
			//foreach($Datos as $k => $v)
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
		header("location:ingreso_funcionarios.php?CmbCCosto=".$CmbCCosto);
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