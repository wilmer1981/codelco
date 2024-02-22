<?php
	include("../principal/conectar_principal.php");
	
	$Fecha=date('Y-m-d');
	//"Proceso="+Proceso+"&Valores="+Valores;
	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}
	if(isset($_REQUEST["Valores"])){
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores = "";
	}

	if(isset($_REQUEST["TxtCodigo"])){
		$TxtCodigo = $_REQUEST["TxtCodigo"];
	}else{
		$TxtCodigo = "";
	}

	if(isset($_REQUEST["TxtCodigo"])){
		$CmbTipo = $_REQUEST["CmbTipo"];
	}else{
		$CmbTipo = "";
	}
	if(isset($_REQUEST["CmbRut"])){
		$CmbRut = $_REQUEST["CmbRut"];
	}else{
		$CmbRut = "";
	}

	
	switch ($Proceso)
	{
		case "N"://NUEVO FUNCIONARIOS
		
			$Consulta="SELECT ifnull(max(cod_subclase)+1,1) as corr from proyecto_modernizacion.sub_clase where cod_clase='6002'";
			//echo $Consulta;
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$CodSubClase=$Fila["corr"];

			$Inserta="INSERT INTO proyecto_modernizacion.sub_clase (cod_clase,cod_subclase,nombre_subclase,valor_subclase1,valor_subclase2,valor_subclase3,valor_subclase4,valor_subclase5,valor_subclase6,valor_subclase7) values ";
			$Inserta.="('6002','".$CodSubClase."','".$CmbRut."','".$CmbTipo."','','','','0','0','0')";
			//echo $Inserta."<br>";
			mysqli_query($link, $Inserta);
			break;
		case "M"://MODIFICAR FUNCIONARIO
			$Modificar="UPDATE proyecto_modernizacion.sub_clase SET valor_subclase1='".$CmbTipo."' WHERE cod_clase='6002' AND nombre_subclase='".$TxtCodigo."'";
			//$Modificar="UPDATE proyecto_modernizacion.sistemas_por_usuario set nivel='".$CmbNivel3."' where rut='$TxtCodigo' and cod_sistema='29'";
			//echo $Modificar."<br>";
			mysqli_query($link, $Modificar);
			break;
		case "E"://ELIMINAR FUNCIONARIO
			//echo "ELIMINAR";
			$Datos=explode('//',$Valores);
			//$Rut=$Datos[0];
			//foreach($Datos as $k => $v)
			foreach ($Datos as $k => $v)
			{
				$Eli=explode('~',$v)	;
				$Eliminar ="delete from proyecto_modernizacion.sub_clase where cod_clase='6002' and nombre_subclase='".$Eli[0]."' and valor_subclase1='".$Eli[1]."'";
				//$Eliminar ="delete from proyecto_modernizacion.sistemas_por_usuario where rut='".$v."' and cod_sistema='29'";
				//echo $Eliminar;
				mysqli_query($link, $Eliminar);
			}
			break;
	}
	if ($Proceso=="E")
	{
		header("location:pmn_ingreso_funcionarios.php");
	}
	else
	{
	    echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngFun.action='pmn_ingreso_funcionarios.php?CmbRut=$CmbRut';";
		echo "window.opener.document.FrmIngFun.submit();";
		echo "window.close();";
		echo "</script>";
	}	
?>