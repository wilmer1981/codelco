<?php
	include("../principal/conectar_principal.php");
	$CookieRut = $_COOKIE["CookieRut"];

	$mes = $_REQUEST["mes"];
	$ano = $_REQUEST["ano"];
	$txtpassword = $_REQUEST["txtpassword"];
	$valor = $_REQUEST["valor"];
		

	$consulta = "select  * from proyecto_modernizacion.funcionarios where rut = '".$CookieRut."'";
	$rs = mysqli_query($link, $consulta);
	if ($row = mysqli_fetch_array($rs))
	{
		//Verifica Password.
		$consulta = "SELECT  * FROM proyecto_modernizacion.funcionarios WHERE rut = '".$CookieRut."'";
		$consulta.= " AND password2=md5('".strtoupper(trim($txtpassword))."')";
		$rsAux = mysqli_query($link, $consulta);
		if ($rowAux = mysqli_fetch_array($rsAux))
		{
			//Ver si se ha generado anexo.
			$consulta = "SELECT * FROM sea_web.existencia_nodo";
			$consulta = $consulta." WHERE ano = '".$ano."' AND mes = '".$mes."'";
			//echo $consulta;
			$rs1 = mysqli_query($link, $consulta);
			
			if ($row1 = mysqli_fetch_array($rs1))
			{
				$actualizar = "UPDATE sea_web.existencia_nodo SET bloqueado = '".$valor."'";
				$actualizar = $actualizar." WHERE ano = '".$ano."' AND mes = '".$mes."'";
				
				mysqli_query($link, $actualizar);
				
				echo '<script language="JavaScript">';
				if ($valor == 0)
					echo 'alert("Mes Abierto Correctamente");';
				else
					echo 'alert("Mes Cerrado Correctamente");';
						
				echo 'window.close();';
				echo '</script>';			
			}
			else
			{
				header("Location:sea_cierra_mes_popup.php?anexo=N");
			}
		}
		else 
		{
			header("Location:sea_cierra_mes_popup.php?pw=N&ano=".$ano."&mes=".$mes."&valor=".$valor);
		}
	}

	include("../principal/cerrar_principal.php");
?>