<?php  
include("conectar_principal.php");

$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

$Sistema     = isset($_REQUEST["Sistema"])?$_REQUEST["Sistema"]:"";
$NomSistema  = isset($_REQUEST["NomSistema"])?$_REQUEST["NomSistema"]:"";
$Descripcion = isset($_REQUEST["Descripcion"])?$_REQUEST["Descripcion"]:"";
$Anexo       = isset($_REQUEST["Anexo"])?$_REQUEST["Anexo"]:"";
$Nivel       = isset($_REQUEST["Nivel"])?$_REQUEST["Nivel"]:"";
$Usuario     = isset($_REQUEST["Usuario"])?$_REQUEST["Usuario"]:"";

switch ($Proceso)
{
	case "NS":
		$Error = "N";
		$Consulta = "select * from proyecto_modernizacion.sistemas where cod_sistema='".$Sistema."'";
		$Resp = mysqli_query($link,$Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$Error = "S";
			$Mensaje = "Sistema ya Existe, No se puede Ingresar";
			$Proceso = "NS";
		}
		else
		{
			$Insertar = "INSERT INTO proyecto_modernizacion.sistemas";
			$Insertar.= " (cod_sistema, nombre, descripcion, cierre)";
			$Insertar.= " VALUES ('".$Sistema."','".$NomSistema."', '".$Descripcion."', '".$Anexo."')";
			mysqli_query($link,$Insertar);			
			$Proceso = "MS";
			$Mensaje = "Sistema grabado con Exito.";
		}
		header("location:ing_sistema.php?Error=".$Error."&Mensaje=".$Mensaje."&Proceso=".$Proceso."&Sistema=".$Sistema); 
		break;
	case "MS":
		$Error = "N";
		$Consulta = "select * from proyecto_modernizacion.sistemas where cod_sistema='".$Sistema."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$Actualizar = "UPDATE proyecto_modernizacion.sistemas";
			$Actualizar.= " SET nombre = '".$NomSistema."' ";
			$Actualizar.= " , descripcion = '".$Descripcion."' ";
			$Actualizar.= " , cierre = '".$Anexo."' ";
			$Actualizar.= " WHERE cod_sistema = '".$Sistema."'";
			mysqli_query($link, $Actualizar);					
		}
		else
		{
			$Error = "S";
			$Mensaje = "Sistema NO Existe, No se puede Modificar";
		}
		header("location:ing_sistema.php?Error=".$Error."&Mensaje=".$Mensaje."&Proceso=MS&Sistema=".$Sistema); 
		break;
	case "ES":
		$Datos=explode("/",$Valores);
		$Mensaje="";
		foreach($Datos as $k => $v)
		{			
			//Usuarios del Sistema
			$Consulta = "select * from proyecto_modernizacion.sistemas ";
			$Consulta.= " where cod_sistema = '".$v."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
				$NomSistema = $Fila["nombre"];
			else
				$NomSistema = "";
			//Usuarios del Sistema
			$Consulta = "select ifnull(count(*),0) as cant_user from proyecto_modernizacion.sistemas_por_usuario ";
			$Consulta.= " where cod_sistema = '".$v."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
				$CantUsuarios = $Fila["cant_user"];
			else
				$CantUsuarios = 0;
			//Pantallas del Sistema
			$Consulta = "select ifnull(count(*),0) as cant_pant from proyecto_modernizacion.pantallas ";
			$Consulta.= " where cod_sistema = '".$v."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
				$CantPantallas = $Fila["cant_pant"];
			else
				$CantPantallas = 0;
			//Niveles de Sistema
			$Consulta = "select ifnull(count(*),0) as cant_nivel from proyecto_modernizacion.niveles_por_sistema ";
			$Consulta.= " where cod_sistema = '".$v."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
				$CantNivel = $Fila["cant_nivel"];
			else
				$CantNivel = 0;
			if ($CantUsuarios==0 && $CantPantallas == 0 && $CantNivel==0)
			{
				$Eliminar = "DELETE FROM proyecto_modernizacion.sistemas WHERE cod_sistema = '".$v."'";
				mysqli_query($link, $Eliminar);				
			}
			else
			{
				$Error="S";
				$Mensaje.=strtoupper($NomSistema)." No se puede Eliminar, Tiene Asociado=<br>";
				if ($CantUsuarios!=0)
					$Mensaje.= str_pad($CantUsuarios,3,"000",STR_PAD_LEFT)." Usuarios <br>";
				if ($CantPantallas!=0)
					$Mensaje.= str_pad($CantPantallas,3,"000",STR_PAD_LEFT)." Pantallas <br>";
				if ($CantNivel!=0)
					$Mensaje.= str_pad($CantNivel,3,"000",STR_PAD_LEFT)." Niveles <br><br>";
			}
		}	
		header("location:mantenedor_sistemas.php?Error=".$Error."&Mensaje=".$Mensaje);
		break;
	case "IU": //INGRESO USUARIO
		$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario ";
		$Consulta.= " where cod_sistema='".$Sistema."' and rut='".$Usuario."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$Error="S";
			$Mensaje = "Usuario ya estaba Ingresado";
		}
		else
		{
			$Insertar = "insert into proyecto_modernizacion.sistemas_por_usuario ";
			$Insertar.= " (rut,cod_sistema,nivel)";
			$Insertar.= " values('".$Usuario."','".$Sistema."','".$Nivel."')";
			mysqli_query($link, $Insertar);
			$Error = "N";
			$Mensaje ="";
		}
		header("location:ing_usuario.php?Sistema=".$Sistema."&Error=".$Error."&Mensaje=".$Mensaje);
		break;
	case "EU": //ELIMINA USUARIO
		$Datos=explode("/",$Valores);
		foreach($Datos as $k => $v)
		{			
			$Eliminar = "DELETE FROM proyecto_modernizacion.sistemas_por_usuario ";
			$Eliminar.= " WHERE cod_sistema = '".$Sistema."'";
			$Eliminar.= " and rut = '".$v."'";
			mysqli_query($link, $Eliminar);		
		}
		header("location:ing_usuario.php?Sistema=".$Sistema);
		break;
	case "MU":
		$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario ";
		$Consulta.= " where cod_sistema='".$Sistema."' and rut='".$Usuario."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$Actualizar = "UPDATE proyecto_modernizacion.sistemas_por_usuario SET ";
			$Actualizar.= " nivel='".$Nivel."' ";
			$Actualizar.= " WHERE cod_sistema = '".$Sistema."'";
			$Actualizar.= " and rut = '".$Usuario."'";
			mysqli_query($link, $Actualizar);
			$Error = "N";
			$Mensaje ="";
		}
		else
		{
			$Error="S";
			$Mensaje = "Usuario NO esta Ingresado en el Sistema";
		}
		header("location:ing_usuario.php?Sistema=".$Sistema."&Error=".$Error."&Mensaje=".$Mensaje);
		break;
	case "IN": //INGRESO NIVEL
		$Consulta = "select * from proyecto_modernizacion.niveles_por_sistema ";
		$Consulta.= " where cod_sistema='".$Sistema."' and nivel='".$Nivel."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$Error="S";
			$Mensaje = "Nivel ya estaba Ingresado";
		}
		else
		{
			$Insertar = "insert into proyecto_modernizacion.niveles_por_sistema ";
			$Insertar.= " (cod_sistema,nivel,descripcion)";
			$Insertar.= " values('".$Sistema."','".$Nivel."','".$Descripcion."')";
			mysqli_query($link, $Insertar);
			$Error = "N";
			$Mensaje ="Nivel ingresado correctamente.";
		}
		header("location:ing_niveles.php?Sistema=".$Sistema."&Error=".$Error."&Mensaje=".$Mensaje);
		break;
	case "EN": //ELIMINA NIVEL
		$Datos=explode("/",$Valores);
		foreach($Datos as $k => $v)
		{			
			$Eliminar = "DELETE FROM proyecto_modernizacion.niveles_por_sistema ";
			$Eliminar.= " WHERE cod_sistema = '".$Sistema."'";
			$Eliminar.= " and nivel = '".$v."'";
			mysqli_query($link, $Eliminar);		
		}
		header("location:ing_niveles.php?Sistema=".$Sistema);
		break;
	case "MN": // MODIFICAR NIVEL
		$Consulta = "select * from proyecto_modernizacion.niveles_por_sistema ";
		$Consulta.= " where cod_sistema='".$Sistema."' and nivel='".$Nivel."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$Actualizar = "UPDATE proyecto_modernizacion.niveles_por_sistema SET ";
			$Actualizar.= " descripcion='".$Descripcion."' ";
			$Actualizar.= " WHERE cod_sistema = '".$Sistema."'";
			$Actualizar.= " and nivel = '".$Nivel."'";
			mysqli_query($link, $Actualizar);
			$Error = "N";
			$Mensaje ="";
		}
		else
		{
			$Error="S";
			$Mensaje = "Nivel NO esta Ingresado en el Sistema";
		}
		header("location:ing_niveles.php?Sistema=".$Sistema."&Error=".$Error."&Mensaje=".$Mensaje);
		break;
}
?>