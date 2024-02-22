<?php	
	include("../principal/conectar_principal.php");	

	$Proceso = $_REQUEST["Proceso"];
	$Valores = $_REQUEST["Valores"];

	$CmbProductos = $_REQUEST["CmbProductos"];
	$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	$CmbLeyes = $_REQUEST["CmbLeyes"];
	$CmbProveedores = $_REQUEST["CmbProveedores"];
	$LimitIni = $_REQUEST["LimitIni"];
	$LimitFin = $_REQUEST["LimitFin"];
	$CmbUnidad = $_REQUEST["CmbUnidad"];
	$Proc = $_REQUEST["Proc"];
	$NewRec = $_REQUEST["NewRec"];
	$TipoConsulta = $_REQUEST["TipoConsulta"];
		

	switch ($Proceso)
	{
		case "N":
				$Consulta="SELECT * FROM cal_web.limite where cod_producto='".$CmbProductos."' and cod_subproducto='".$CmbSubProducto."'";
				if($CmbProductos=='1')
					$Consulta.=" and rut_proveedor='".$CmbProveedores."'";
				else
					$Consulta.=" and rut_proveedor=''";
				
				$Consulta.=" and cod_ley='".$CmbLeyes."'";	
				$Respuesta = mysqli_query($link, $Consulta);
				if(!$Fila=mysqli_fetch_array($Respuesta))
				{
					if($CmbProductos!='1')
						$CmbProveedores='';
					$LimitIni=str_replace(".","",$LimitIni);	
					$LimitIni=str_replace(",",".",$LimitIni);	
					$LimitFin=str_replace(".","",$LimitFin);	
					$LimitFin=str_replace(",",".",$LimitFin);
					$Insertar="INSERT INTO cal_web.limite (cod_producto,cod_subproducto,rut_proveedor,cod_ley,limite_inicial,limite_final,unidad)";
					$Insertar.="values ('".$CmbProductos."','".$CmbSubProducto."','".$CmbProveedores."','".$CmbLeyes."','".$LimitIni."','".$LimitFin."','".$CmbUnidad."')";
					mysqli_query($link, $Insertar);
					$Msj='1';	
				}	
				else
					$Msj='2';
				$Clave=$CmbProductos."~".$CmbSubProducto."~".$CmbProveedores."~".$CmbLeyes;
				header('location:cal_mantenedor_limite_control_proceso.php?Opc=M&Msj='.$Msj.'&Valores='.$Clave);				
		break;
		case "M":
				$LimitIni=str_replace(".","",$LimitIni);	
				$LimitIni=str_replace(",",".",$LimitIni);	
				$LimitFin=str_replace(".","",$LimitFin);	
				$LimitFin=str_replace(",",".",$LimitFin);	
				$Actualizar="UPDATE cal_web.limite set limite_inicial='".$LimitIni."', limite_final='".$LimitFin."', unidad='".$CmbUnidad."'";
				$Actualizar.="where cod_producto='".$CmbProductos."' and cod_subproducto='".$CmbSubProducto."'";
				if($CmbProductos=='1')
					$Actualizar.=" and rut_proveedor='".$CmbProveedores."'";
				$Actualizar.=" and cod_ley='".$CmbLeyes."'";	
				mysqli_query($link, $Actualizar);
				$Msj='3';	
				$Clave=$CmbProductos."~".$CmbSubProducto."~".$CmbProveedores."~".$CmbLeyes;
				header('location:cal_mantenedor_limite_control_proceso.php?Opc=M&Msj='.$Msj.'&Valores='.$Clave);
		break;
		case "E":
				$Datos = explode("//",$Valor);
				//while (list($clave,$V)=each($Datos))
				foreach ($Datos as $clave => $V) 
				{
					$Datos1=explode("~",$V);
					$EliminarCate="DELETE from cal_web.limite where cod_producto='".$Datos1[0]."' and cod_subproducto='".$Datos1[1]."'";
					if($Datos1[0]=='1')
						$EliminarCate.=" and rut_proveedor='".$Datos1[2]."'";
					$EliminarCate.=" and cod_ley='".$Datos1[3]."'";	
					mysqli_query($link, $EliminarCate);
				}	  
				$Msj='4';
				header('location:cal_mantenedor_limite_control.php?Buscar=S&Msj='.$Msj.'&CmbProductos='.$CmbProductos.'&CmbSubProducto='.$CmbSubProducto.'&CmbProveedores='.$CmbProveedores.'&CmbLeyes='.$CmbLeyes);				
		break;
	}	
?>
