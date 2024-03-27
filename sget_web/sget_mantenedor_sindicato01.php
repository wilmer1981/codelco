<? 
	include("../principal/conectar_sget_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
			$Consulta = "SELECT ifnull(max(cod_sindicato),0) as mayor from sget_sindicato"; 
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysql_fetch_array($Respuesta);
			$Mayor=$Fila["mayor"] + 1;			
			
			$Inserta="INSERT INTO sget_sindicato (cod_sindicato,descripcion,abreviatura_sindicato,estado,vencctto,observacion,fecha_venc)";
			$Inserta.=" values('".$Mayor."','".strtoupper($Descri)."', '".strtoupper($TxtAbreviatura)."','".$CmbEstado."','".$CmbVencCtto."','".strtoupper($Obs)."','".$TxtFechaVenc."')";
			mysql_query($Inserta);
		
		
		if($Volver=='S')
		{
			echo "<script languaje='JavaScript'>";		
			echo " window.opener.document.frmPrincipal.action='sget_mantenedor_personal_proceso.php?Sindicato=$Mayor';";
			echo " window.opener.document.frmPrincipal.submit();";		
			echo " window.close();</script>";
		}
		else
		{
			echo "<script languaje='JavaScript'>";		
			echo " window.opener.document.FrmPrincipal.action='sget_mantenedor_sindicato.php?Buscar=S';";
			echo " window.opener.document.FrmPrincipal.submit();";		
			echo " window.close();</script>";
		}
		break;
		case "M":
			$Actualizar="UPDATE sget_sindicato set descripcion='".strtoupper($Descri)."', abreviatura_sindicato='".strtoupper($TxtAbreviatura)."',estado='".$CmbEstado."',vencctto='".$CmbVencCtto."',observacion='".strtoupper($Obs)."',fecha_venc='".$TxtFechaVenc."' ";
			$Actualizar.=" where cod_sindicato='".$Codigo."'";	
			mysql_query($Actualizar);
		
		if($Volver=='S')
		{
			echo "<script languaje='JavaScript'>";		
			echo " window.opener.document.frmPrincipal.action=\"sget_mantenedor_personal_proceso.php?Sindicato=$Codigo\";";
			echo " window.opener.document.frmPrincipal.submit();";		
			echo " window.close();</script>";
		}
		else
		{
			echo "<script languaje='JavaScript'>";		
			echo " window.opener.document.FrmPrincipal.action='sget_mantenedor_sindicato.php?Buscar=S';";
			echo " window.opener.document.FrmPrincipal.submit();";		
			echo " window.close();</script>";
		}
		break;
		case "E":
			$Mensaje='N';
			$Datos = explode("//",$Valor);
			foreach($Datos as $clave => $Codigo)
			{				
				$Consulta="SELECT * from sget_personal where cod_sindicato='".$Codigo."'";
				$Respuesta=mysqli_query($link, $Consulta);
				if(!$Fila=mysql_fetch_array($Respuesta))
				{
					$Eliminar="delete from sget_sindicato where cod_sindicato='".$Codigo."'";
					mysql_query($Eliminar);
				}
				else
				{
					$Mensaje='S';
				}		
			}
			header("location:sget_mantenedor_sindicato.php?Mensaje=".$Mensaje."&Buscar=S");
		break;
	}
?>
