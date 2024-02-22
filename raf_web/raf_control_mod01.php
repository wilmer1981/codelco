<? 
include("../principal/conectar_principal.php");
$Entrar=true;
switch ($Proceso)
{
	case "A"://Comprueba Contrasea
		$Consulta = "select count(*) as existe from proyecto_modernizacion.funcionarios where rut ='".$CookieRut."' and password2 =md5('".strtoupper(trim($PW))."')";
		$Respuesta=mysql_query($Consulta);
		$Fila= mysql_fetch_array($Respuesta);
		if ($Fila[existe] == 0)
		{
			header("location:raf_control_mod.php?PWValida=N");
			$Entrar=false;
			break;
		}
		else
		{
			echo "<script languaje='JavaScript'>";

			//Preparacion
			if($Cambio == "E")
				echo "window.opener.document.FrmPrincipal.action = 'raf_ingreso_carga_preparacion01.php?Proceso=E';";
			if($Cambio == "M")
				echo "window.opener.document.FrmPrincipal.action = 'raf_ingreso_carga_preparacion01.php?Proceso=M';";

			//Carga Parcial
			if($Cambio == "E2")
				echo "window.opener.document.FrmPrincipal.action = 'raf_ingreso_carga_parcial.php?Proceso=E';";
			if($Cambio == "C")
				echo "window.opener.document.FrmPrincipal.action = 'raf_ingreso_carga_parcial01.php?Proceso=C';";

			echo "window.opener.document.FrmPrincipal.submit();";
			echo "window.close();";										 	
			echo "</script>";		
		}		
}		

?>