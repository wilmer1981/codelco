<? 
	include("../principal/conectar_sget_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
			$Consulta = "SELECT ifnull(max(cod_turno),0) as mayor from sget_turnos"; 
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysql_fetch_array($Respuesta);
			$Mayor=$Fila["mayor"] + 1;			
			
			$Inserta="INSERT INTO  sget_turnos (cod_turno,descrip_turno,estado)";
			$Inserta.=" values('".$Mayor."','".strtoupper($Descri)."','".$CmbEstado."')";
			mysql_query($Inserta);
			//echo 	$Inserta;
			echo "<script languaje='JavaScript'>";		
			echo " window.opener.document.FrmPrincipal.action='sget_mantenedor_turnos.php?Buscar=S';";
			echo " window.opener.document.FrmPrincipal.submit();";		
			echo " window.close();</script>";
		break;
		case "M":
			$Actualizar="UPDATE sget_turnos set descrip_turno='".strtoupper($Descri)."',estado='".$CmbEstado."' ";
			$Actualizar.=" where cod_turno='".$Codigo."'";	
			mysql_query($Actualizar);
			echo "<script languaje='JavaScript'>";		
			echo " window.opener.document.FrmPrincipal.action='sget_mantenedor_turnos.php?Buscar=S';";
			echo " window.opener.document.FrmPrincipal.submit();";		
			echo " window.close();</script>";
		break;
		case "E":
			$Mensaje='N';
			$Datos = explode("//",$Valor);
			foreach($Datos as $clave => $Codigo)
			{
				
				
				
				$Consulta="SELECT * from sget_personal where cod_turno='".$Codigo."'";
				$Respuesta=mysqli_query($link, $Consulta);
				if(!$Fila=mysql_fetch_array($Respuesta))
				{
					$Eliminar="delete from sget_turnos where cod_turno='".$Codigo."'";
					mysql_query($Eliminar);
				}
				else
				{
					$Mensaje='S';
				}	
			}
			header("location:sget_mantenedor_turnos.php?Mensaje=".$Mensaje."&Buscar=S");
		break;
	}
?>
