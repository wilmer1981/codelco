<?php
	include("../principal/conectar_principal.php");
	switch ($Proceso)
	{
		case "G":
			//Consulto si las existencias del mes esta bloqueadas
			$Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM pmn_web.existencia_nodo ";
			$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND bloqueado = '1'";    
			$Respuesta = mysqli_query($link, $Consulta);
			$Fila = mysqli_fetch_array($Respuesta);
			if ($Fila["valor"] == "0")
			{
				//INSERTA REGISTRO EN TABLA CIERRE MES
				$Insertar = "INSERT INTO proyecto_modernizacion.cierre_mes (cod_sistema, ano, mes, fecha_cierre, cod_bloqueo, estado, rut_funcionario) ";
				$Insertar.= " values('6','".$Ano."','".$Mes."','".date("Y-m-d H:i:s")."','1', 'C', '".$CookieRut."')";
				mysqli_query($link, $Insertar);
				//ACTUALIZO REGISTRO EN TABLA EXISTENCIA NODO
				$Actualizar = "UPDATE pmn_web.existencia_nodo ";
				$Actualizar.= " set bloqueado = '1' ";
				$Actualizar.= " where ano = '".$Ano."' ";
				$Actualizar.= " and mes = '".$Mes."' ";
				mysqli_query($link, $Actualizar);
				header("location:pmn_con_balance_anexo.php?Proceso=S&Ano=".$Ano."&Mes=".$Mes."");
			}			
			break;		
		case "AM":
			//VALIDA PASSWORD
			$Consulta = "select count(*) as existe from proyecto_modernizacion.funcionarios ";
			$Consulta.= " where rut ='".$CookieRut."' and password2 =md5('".strtoupper(trim($TxtPassword))."')";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila= mysqli_fetch_array($Respuesta);
			if ($Fila[existe] == 0)
			{
				header("location:../principal/abrir_mes_anexo.php?PWValida=N&Sistema=".$Sistema."&Ano=".$Ano."&Mes=".$Mes);
				break;
			}
			else
			{
				//INSERTA REGISTRO EN TABLA CIERRE MES
				$Insertar = "INSERT INTO proyecto_modernizacion.cierre_mes (cod_sistema, ano, mes, fecha_cierre, cod_bloqueo, estado, rut_funcionario) ";
				$Insertar.= " values('6','".$Ano."','".$Mes."','".date("Y-m-d H:i:s")."','1', 'A', '".$CookieRut."')";
				mysqli_query($link, $Insertar);
				//ACTUALIZA REGISTRO EN TABLA EXISTENCIA NODO
				$Actualizar = "UPDATE pmn_web.existencia_nodo ";
				$Actualizar.= " set bloqueado = '0' ";
				$Actualizar.= " where ano = '".$Ano."' ";
				$Actualizar.= " and mes = '".$Mes."' ";
				mysqli_query($link, $Actualizar);
				echo "<script language=JavaScript>";
				echo "window.opener.document.frmPrincipal.action='pmn_con_balance_anexo.php?Proceso=S&Ano=".$Ano."&Mes=".$Mes."';";
				echo "window.opener.document.frmPrincipal.submit();";
				echo "window.close();";
				echo "</script>";
			}
			break;		
	}
?>