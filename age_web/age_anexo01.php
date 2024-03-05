<?php
	include("../principal/conectar_principal.php");
	
	//Proceso=AM&Ano="+Frm.Ano.value+"&Mes="+Frm.Mes.value;

	$CookieRut = $_COOKIE["CookieRut"];
	$Proceso = $_REQUEST["Proceso"];
	$Ano     = $_REQUEST["Ano"];
    $Mes     = $_REQUEST["Mes"];
	$Sistema = $_REQUEST["Sistema"];
	$TxtPassword = $_REQUEST["TxtPassword"];

	switch ($Proceso)
	{
		case "G":
			//Consulto si las existencias del mes estab bloqueadas
			$Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM age_web.flujos_mes ";
			$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND bloqueado = '1'";    
			$Respuesta = mysqli_query($link, $Consulta);
			$Fila = mysqli_fetch_array($Respuesta);
			if ($Fila["valor"] == "0")
			{
				//INSERTA REGISTRO EN TABLA CIERRE MES
				$Insertar = "INSERT INTO proyecto_modernizacion.cierre_mes (cod_sistema, ano, mes, fecha_cierre, cod_bloqueo, estado, rut_funcionario) ";
				$Insertar.= " values('15','".$Ano."','".$Mes."','".date("Y-m-d H:i:s")."','1', 'C', '".$CookieRut."')";
				mysqli_query($link, $Insertar);
				//ACTUALIZO REGISTRO EN TABLA FLUJOS MES
				$Actualizar = "UPDATE age_web.flujos_mes ";
				$Actualizar.= " set bloqueado = '1' ";
				$Actualizar.= " where ano = '".$Ano."' ";
				$Actualizar.= " and mes = '".$Mes."' ";
				mysqli_query($link, $Actualizar);
				//header("location:age_anexo.php?Mostrar=S&Ano=".$Ano."&Mes=".$Mes."");
				header("location:age_anexo2.php?Mostrar=S&Ano=".$Ano."&Mes=".$Mes."");
			}			
			break;		
		case "AM":
			//VALIDA PASSWORD
			$Consulta = "select count(*) as existe from proyecto_modernizacion.funcionarios ";
			$Consulta.= " where rut ='".$CookieRut."' and password2 = md5('".strtoupper(trim($TxtPassword))."')";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila= mysqli_fetch_array($Respuesta);
			if ($Fila["existe"] == 0)
			{
				header("location:../principal/abrir_mes_anexo.php?PWValida=N&Sistema=".$Sistema."&Ano=".$Ano."&Mes=".$Mes);
				break;
			}
			else
			{
				//INSERTA REGISTRO EN TABLA CIERRE MES
				$Insertar = "INSERT INTO proyecto_modernizacion.cierre_mes (cod_sistema, ano, mes, fecha_cierre, cod_bloqueo, estado, rut_funcionario) ";
				$Insertar.= " values('15','".$Ano."','".$Mes."','".date("Y-m-d H:i:s")."','1', 'A', '".$CookieRut."')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
				//ACTUALIZO REGISTRO EN TABLA FLUJOS MES
				$Actualizar = "UPDATE age_web.flujos_mes ";
				$Actualizar.= " set bloqueado = '0' ";
				$Actualizar.= " where ano = '".$Ano."' ";
				$Actualizar.= " and mes = '".$Mes."' ";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				echo "<script language=JavaScript>";
				//echo "window.opener.document.frmPrincipal.action='age_con_anexo2.php?Mostrar=S&Ano=".$Ano."&Mes=".$Mes."';";
				echo "window.opener.document.frmPrincipal.action='age_anexo2.php?Mostrar=S&Ano=".$Ano."&Mes=".$Mes."';";
				echo "window.opener.document.frmPrincipal.submit();";
				echo "window.close();";
				echo "</script>";
			}
			break;		
	}
?>