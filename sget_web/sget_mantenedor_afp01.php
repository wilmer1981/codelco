<? 
	include("../principal/conectar_sget_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
			$Consulta = "SELECT ifnull(max(cod_AFP),0) as mayor from sget_afp"; 
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysql_fetch_array($Respuesta);
			$Mayor=$Fila["mayor"] + 1;			
			
			$Inserta="INSERT INTO sget_afp (cod_afp,descripcion_afp,abreviatura_afp,estado)";
			$Inserta.=" values('".$Mayor."','".strtoupper($Descri)."', '".strtoupper($TxtAbreviatura)."','".$CmbEstado."')";
			mysql_query($Inserta);
			if($Volver=='S')
			{
			echo "<script languaje='JavaScript'>";		
			echo " window.opener.document.frmPrincipal.action=\"sget_mantenedor_personal_proceso.php?Afp=$Mayor\";";
			echo " window.opener.document.frmPrincipal.submit();";		
			echo " window.close();</script>";
			}else{
				echo "<script languaje='JavaScript'>";		
			echo " window.opener.document.FrmPrincipal.action='sget_mantenedor_AFP.php?Buscar=S';";
			echo " window.opener.document.FrmPrincipal.submit();";		
			echo " window.close();</script>";
			}
			
		break;
		case "M":
			$Actualizar="UPDATE sget_afp set descripcion_afp='".strtoupper($Descri)."' ";
			$Actualizar.=" ,abreviatura_afp = '".strtoupper($TxtAbreviatura)."',estado='".$CmbEstado."' ";
			$Actualizar.=" where cod_afp='".$Codigo."'";	
			mysql_query($Actualizar);
			if($Volver=='S')
			{
			echo "<script languaje='JavaScript'>";		
			echo " window.opener.document.frmPrincipal.action='sget_mantenedor_personal_proceso.php?Afp=$Codigo';";
			echo " window.opener.document.frmPrincipal.submit();";		
			echo " window.close();</script>";
			}else{
				echo "<script languaje='JavaScript'>";		
			echo " window.opener.document.FrmPrincipal.action='sget_mantenedor_AFP.php?Buscar=S';";
			echo " window.opener.document.FrmPrincipal.submit();";		
			echo " window.close();</script>";
			}
		break;
		case "E":
			$Mensaje='N';
			$Datos = explode("//",$Valor);
			foreach($Datos as $clave => $Codigo)
			{
				
				
				$Consulta="SELECT * from sget_personal where cod_afp='".$Codigo."'";
				$Respuesta=mysqli_query($link, $Consulta);
				if(!$Fila=mysql_fetch_array($Respuesta))
				{
							
					$Eliminar="delete from sget_afp where cod_afp='".$Codigo."'";
					mysql_query($Eliminar);
				
				}
				else
				{
					$Mensaje="S";
					break;	
				}	
				
				
				
		    }
			header("location:sget_mantenedor_AFP.php?Mensaje=".$Mensaje."&Buscar=S");
		break;
	}
?>
