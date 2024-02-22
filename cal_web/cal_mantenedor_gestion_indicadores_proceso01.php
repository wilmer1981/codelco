<?php	
	include("../principal/conectar_principal.php");	

	$Proceso = $_REQUEST["Proceso"];
	$Valor = $_REQUEST["Valor"];

	$CmbProductos = $_REQUEST["CmbProductos"];
	$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	$CmbLeyes = $_REQUEST["CmbLeyes"];
	$CmbProveedores = $_REQUEST["CmbProveedores"];
	$LimitIni = $_REQUEST["LimitIni"];
	$LimitFin = $_REQUEST["LimitFin"];
	$CmbUnidad = $_REQUEST["CmbUnidad"];
	$TxtValor = $_REQUEST["TxtValor"];
	$Proc = $_REQUEST["Proc"];
	$NewRec = $_REQUEST["NewRec"];
	$TipoConsulta = $_REQUEST["TipoConsulta"];
	


	switch ($Proceso)
	{
		case "N":
				$Consulta="select * from cal_web.gestion_indicadores where cod_producto='".$CmbProductos."' and cod_subproducto='".$CmbSubProducto."'";
				$Consulta.=" and cod_leyes='".$CmbLeyes."' and cod_unidad='".$CmbUnidad."'";	
				$Respuesta = mysqli_query($link, $Consulta);
				if(!$Fila=mysqli_fetch_array($Respuesta))
				{
					$TxtValor=str_replace(".","",$TxtValor);	
					$TxtValor=str_replace(",",".",$TxtValor);	
					$Insertar="insert into cal_web.gestion_indicadores (cod_producto,cod_subproducto,cod_leyes,valor,cod_unidad)";
					$Insertar.="values ('".$CmbProductos."','".$CmbSubProducto."','".$CmbLeyes."','".$TxtValor."','".$CmbUnidad."')";
					mysqli_query($link, $Insertar);
					$Msj='1';	
				}	
				else
					$Msj='2';
				$Clave=$CmbProductos."~".$CmbSubProducto."~".$CmbLeyes."~".$CmbUnidad;
				header('location:cal_mantenedor_gestion_indicadores_proceso.php?Opc=M&Msj='.$Msj.'&Valores='.$Clave);				
		break;
		case "M":
				$TxtValor=str_replace(".","",$TxtValor);	
				$TxtValor=str_replace(",",".",$TxtValor);	
				$Actualizar="UPDATE cal_web.gestion_indicadores set valor='".$TxtValor."' ";
				$Actualizar.="where cod_producto='".$CmbProductos."' and cod_subproducto='".$CmbSubProducto."'";
				$Actualizar.=" and cod_leyes='".$CmbLeyes."' and  cod_unidad='".$CmbUnidad."'";	
				mysqli_query($link, $Actualizar);
				$Msj='3';	
				$Clave=$CmbProductos."~".$CmbSubProducto."~".$CmbLeyes;
				header('location:cal_mantenedor_gestion_indicadores_proceso.php?Opc=M&Msj='.$Msj.'&Valores='.$Clave);
		break;
		case "E":
				$Datos = explode("//",$Valor);
				//while (list($clave,$V)=each($Datos))
				foreach ($Datos as $clave => $V) 
				{
					$Datos1=explode("~",$V);
					$EliminarCate="delete from cal_web.gestion_indicadores where cod_producto='".$Datos1[0]."' and cod_subproducto='".$Datos1[1]."'";
					$EliminarCate.=" and cod_leyes='".$Datos1[2]."' and cod_unidad='".$Datos1[3]."'";	
					//echo $EliminarCate."<br>";
					mysqli_query($link, $EliminarCate);
				}	  
				$Msj='4';
				header('location:cal_mantenedor_gestion_indicadores.php?Buscar=S&Msj='.$Msj.'&CmbProductos='.$CmbProductos.'&CmbSubProducto='.$CmbSubProducto.'&CmbLeyes='.$CmbLeyes);				
		break;
	}	
?>
