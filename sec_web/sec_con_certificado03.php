<?php
	include("../principal/conectar_principal.php");

	$CookieRut = $_COOKIE["CookieRut"];

		$Proceso = $_REQUEST["Proceso"];
		$Corr    = $_REQUEST["Corr"];
		$Mes     = $_REQUEST["Mes"];
		$Lote    = $_REQUEST["Lote"];
		$Estado	 = $_REQUEST["Estado"];
		$CmbMes	 = $_REQUEST["CmbMes"];
		$CmbAno	 = $_REQUEST["CmbAno"];
		$TxtPassword	= $_REQUEST["TxtPassword"];
		$Valor	= $_REQUEST["Valor"];

	if (($Proceso == "A") || ($Proceso == "H"))
	{
		$Actualizar = "UPDATE sec_web.solicitud_certificado set ";
		switch ($Proceso)
		{
			case "A":
				$Actualizar.= " estado_certificado = 'A'";
				break;
			case "H":
				$Actualizar.= " estado_certificado = ''";
				break;
		}
		$Actualizar.= " where cod_bulto = '".$Mes."' and num_bulto = '".$Lote."'";		
		mysqli_query($link, $Actualizar);
		header("location:sec_con_certificado_multiple.php?Mostrar=S&CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&CmbEstado=".$Estado);
		exit;
	}
	else
	{
		$Consulta = "SELECT  * from proyecto_modernizacion.funcionarios ";
		$Consulta.= " where rut = '".$CookieRut."' and password2 <> '' and not isnull(password2)";
		$Respuesta = mysqli_query($link, $Consulta);
		$Mes = "";
		$Lote = "";
		$Reescribir = "N";
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Consulta = "SELECT  * from proyecto_modernizacion.funcionarios ";
			$Consulta.= " where rut = '".$CookieRut."' and password2 = md5('".strtoupper(trim($TxtPassword))."')";
			$RespuestaPass = mysqli_query($link, $Consulta);
			if ($FilaPass=mysqli_fetch_array($RespuestaPass))
			{
				$Reescribir = "S";
				$Consulta = "SELECT * from sec_web.lote_catodo where corr_enm = '".$Valor."'";
				$Respuesta2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{			
					$Mes = $Fila2["cod_bulto"];
					$Lote = $Fila2["num_bulto"];
				}			
			}		
		}	
		if ($Reescribir == "S")
		{		
			header("location:sec_con_certificado.php?NumCertificado=".$NumCertificado."&Reescribir=S&Mes=".$Mes."&Lote=".$Lote."&CorrENM=".$Valor."&Idioma=".$Idioma."&Proceso=R");
			exit;
		}
		else
		{
			header("location:sec_con_certificado02.php?Error=E&Reescribir=N&CorrENM=".$Valor);
			exit;
		}	
	}
?>