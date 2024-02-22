<? 
	include("../principal/conectar_sget_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
			$Consulta = "SELECT ifnull(max(cod_aseguradora),0) as mayor from sget_aseguradoras "; 
			$Respuesta=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Respuesta);
			$Mayor=$Fila["mayor"] + 1;			
			
			$Inserta="INSERT INTO  sget_aseguradoras (cod_aseguradora,descripcion_aseguradora,estado)";
			$Inserta.=" values('".$Mayor."','".strtoupper($Descri)."','1')";
			mysql_query($Inserta);
			
			echo "<script languaje='JavaScript'>";		
			echo " window.opener.document.frmPrincipal.action=\"sget_mantenedor_personal_proceso.php?Aseguradora=$Mayor\";";
			echo " window.opener.document.frmPrincipal.submit();";			
			echo " window.close();</script>";
		break;
		case "M":
			$Actualizar="UPDATE sget_aseguradoras set descripcion_aseguradora='".strtoupper($Descri)."',estado='".$CmbEstado."' ";
			$Actualizar.=" where cod_aseguradora='".$Codigo."' and cod_aseguradora not in(0,1)";	
			mysql_query($Actualizar);
			
			echo "<script languaje='JavaScript'>";		
			echo " window.opener.document.frmPrincipal.action=\"sget_mantenedor_personal_proceso.php?Aseguradora=$Codigo\";";
			echo " window.opener.document.frmPrincipal.submit();";		
			echo " window.close();</script>";
		break;
		case "E":
			$Mensaje='N';
			$Datos = explode("//",$Valor);
			foreach($Datos as $clave => $Codigo)
			{
				$Eliminar="delete from sget_aseguradoras where cod_aseguradora='".$Codigo."'";
				mysql_query($Eliminar);
			}
			header("location:sget_mantenedor_aseguradora_proceso.php?Mensaje=".$Mensaje);
		break;
	}
?>