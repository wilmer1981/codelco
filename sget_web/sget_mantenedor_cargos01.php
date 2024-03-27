<? 
	include("../principal/conectar_sget_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
			$Consulta = "SELECT ifnull(max(cod_cargo),0) as mayor from sget_cargos"; 
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysql_fetch_array($Respuesta);
			$Mayor=$Fila["mayor"] + 1;			
			
			$Inserta="INSERT INTO  sget_cargos (cod_cargo,descrip_cargo,estado)";
			$Inserta.=" values('".$Mayor."','".strtoupper($Descri)."','".$CmbEstado."')";
			mysql_query($Inserta);
			
			if($Volver=='S')
			{
				echo "<script languaje='JavaScript'>";		
				echo " window.opener.document.frmPrincipal.action=\"sget_mantenedor_personal_proceso.php?Cargo=$Mayor\";";
				echo " window.opener.document.frmPrincipal.submit();";			
				echo " window.close();</script>";
			}
			else
			{
				echo "<script languaje='JavaScript'>";		
				echo " window.opener.document.FrmPrincipal.action='sget_mantenedor_cargos.php?Buscar=S';";
				echo " window.opener.document.FrmPrincipal.submit();";		
				echo " window.close();</script>";
			}	
		break;
		case "M":
			$Actualizar="UPDATE sget_cargos set descrip_cargo='".strtoupper($Descri)."',estado='".$CmbEstado."' ";
			$Actualizar.=" where cod_cargo='".$Codigo."'";	
			mysql_query($Actualizar);
			
			if($Volver=='S')
			{
				echo "<script languaje='JavaScript'>";		
				echo " window.opener.document.frmPrincipal.action=\"sget_mantenedor_personal_proceso.php?Cargo=$Codigo\";";
				echo " window.opener.document.frmPrincipal.submit();";		
				echo " window.close();</script>";
			}
			else
			{
				echo "<script languaje='JavaScript'>";		
				echo " window.opener.document.FrmPrincipal.action='sget_mantenedor_cargos.php?Buscar=S';";
				echo " window.opener.document.FrmPrincipal.submit();";		
				echo " window.close();</script>";
			}	
			
		break;
		case "E":
			$Mensaje='N';
			$Datos = explode("//",$Valor);
			foreach($Datos as $clave => $Codigo)
			{
				
				$Consulta="SELECT * from sget_personal where cargo='".$Codigo."'";
				$Respuesta=mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Respuesta))
				{
					$Mensaje='S';
				}
				$Consulta="SELECT * from sget_administrador_contratos where cargo='".$Codigo."'";
				$Respuesta=mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Respuesta))
				{
					$Mensaje='S';
				}
				$Consulta="SELECT * from sget_administrador_contratistas where cargo='".$Codigo."'";
				$Respuesta=mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Respuesta))
				{
					$Mensaje='S';
				}
				if($Mensaje=='N')
				{
					$Eliminar="delete from sget_cargos where cod_cargo='".$Codigo."'";
					mysql_query($Eliminar);
				}
				
				
				
				
			}
			header("location:sget_mantenedor_cargos.php?Mensaje=".$Mensaje."&Buscar=S");
		break;
	}
?>