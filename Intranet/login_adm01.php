<?
	include("conectar.php");
	
	switch ($Tipo)
	{
		case "ADM_SIS":
			$consulta = "SELECT * ";
			$consulta.= " FROM intranet.usuarios ";
			$consulta.= " WHERE rut_funcionario = '".$txtrut."'"; //consulta en la tabla funcionarios
			$rs = mysql_query($consulta);
			if($row = mysql_fetch_array($rs))
			{
				if (strtoupper($row[password]) == strtoupper($txtpassword))
				{
					setcookie("CookieRut", $txtrut);			
					echo "<script>window.opener.document.frmPrincipal.action='index.php?Pagina=adm_intranet.php';";
					echo "window.opener.document.frmPrincipal.submit();window.close()</script>";
				}
				else 
				{				
					$mensaje = "Password Incorrecta"; 			
					header("Location:login_adm.php?Tipo=".$Tipo."&mensaje=".$mensaje."&txtrut=".$txtrut);
				}				
			}
			else
			{
				$mensaje = "Usuario no Existe"; 			
				header("Location:login_adm.php?Tipo=".$Tipo."&mensaje=".$mensaje);
			}	
			break;
		case "SUBIR";
			$consulta = "SELECT * ";
			$consulta.= " FROM intranet.directorios ";
			$consulta.= " WHERE rut_funcionario = '".$txtrut."'"; //consulta en la tabla funcionarios
			$rs = mysql_query($consulta);
			if($row = mysql_fetch_array($rs))
			{				
				setcookie("CookieSubir", $txtrut);			
				echo "<script>window.open(\"subir_archivos_usuario.php?Tipo=".$Tipo."\",\"\",\"top=50,left=30,width=500,height=400,resizable=yes, scrollbars=yes\");window.close()</script>";
			}
			else
			{
				$mensaje = "SIN AUTORIZACION"; 			
				header("Location:login_adm.php?Tipo=".$Tipo."&mensaje=".$mensaje);
			}	
			break;
	}
?>