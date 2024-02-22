<?php
	include("conectar_principal.php");
	//Proc=A&Sistema=S&Ano=2021&Mes=1
	$CookieRut = $_COOKIE["CookieRut"];

	if(isset($_REQUEST["Proc"])){
		$Proc = $_REQUEST["Proc"];
	}else{
		$Proc = "";
	}
	if(isset($_REQUEST["Sistema"])){
		$Sistema = $_REQUEST["Sistema"];
	}else{
		$Sistema = "";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = "";
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = "";
	}
	if(isset($_REQUEST["TxtPassword"])){
		$TxtPassword = $_REQUEST["TxtPassword"];
	}else{
		$TxtPassword = "";
	}

	switch ($Proc)
	{
		case "C":
			//VALIDA PASSWORD
			$Consulta = "select count(*) as existe from proyecto_modernizacion.funcionarios ";
			$Consulta.= " where rut ='".$CookieRut."' and password2 =md5('".strtoupper(trim($TxtPassword))."')";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila= mysqli_fetch_array($Respuesta);
			if ($Fila["existe"] == 0)
			{
				header("location:../principal/abrir_mes_anexo.php?PWValida=N&Proc=".$Proc."&BalanceMes=S&Sistema=".$Sistema."&Ano=".$Ano."&Mes=".$Mes);
				break;
			}
			else
			{				
				//PROCESO CIERRAR					
				$Consulta = "select * from proyecto_modernizacion.sistemas ";
				$Consulta.= " where cierre='S'";
				if ($Sistema!="S")
				{
					$Consulta.= " and cod_sistema='".$Sistema."'";
				}
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					//CONSULTA ESTADO CIERRE OPERACIONAL		
					$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
					$Consulta.= " where cod_sistema='".$Fila["cod_sistema"]."'";
					$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1' and fecha_cierre = (";
					$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
					$Consulta.= " where cod_sistema='".$Fila["cod_sistema"]."'";
					$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1')";
					$Resp2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Resp2))
					{			
						if ($Fila2["estado"] == "C")
						{								
							//CONSULTA CIERRE GENERAL, SI YA ESTA CERRADO NO SE GRABA REGISTRO
							$Consulta = "select cod_sistema, estado, fecha_cierre, rut_funcionario from proyecto_modernizacion.cierre_mes";
							$Consulta.= " where cod_sistema='".$Fila["cod_sistema"]."'";
							$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2' and fecha_cierre = (";
							$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
							$Consulta.= " where cod_sistema='".$Fila["cod_sistema"]."'";
							$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2')";
							$Resp3 = mysqli_query($link, $Consulta);	
							if ($Fila3 = mysqli_fetch_array($Resp2))
							{									
								if ($Fila3["estado"]!="C")
								{
									$Insertar = "insert into proyecto_modernizacion.cierre_mes (cod_sistema, ano, mes, fecha_cierre, cod_bloqueo, estado, rut_funcionario) ";
									$Insertar.= " values('".$Fila["cod_sistema"]."','".$Ano."','".$Mes."','".date("Y-m-d H:i:s")."','2', 'C', '".$CookieRut."')";
									mysqli_query($link, $Insertar);
								}
							}
							else
							{
								$Insertar = "insert into proyecto_modernizacion.cierre_mes (cod_sistema, ano, mes, fecha_cierre, cod_bloqueo, estado, rut_funcionario) ";
								$Insertar.= " values('".$Fila["cod_sistema"]."','".$Ano."','".$Mes."','".date("Y-m-d H:i:s")."','2', 'C', '".$CookieRut."')";
								mysqli_query($link, $Insertar);
							}//FIN CIERRE GENERAL
						}//FIN CIERRE PARCIAL
					}									
				}//FIN WHILE
				echo "<script language=JavaScript>";
				echo "window.opener.document.frmPrincipal.action='cierre_mes.php?Proceso=R&Sistema=".$Sistema."&Ano=".$Ano."&Mes=".$Mes."';";
				echo "window.opener.document.frmPrincipal.submit();";
				echo "window.close();";
				echo "</script>";
			}
			break;			
		case "A":
			//VALIDA PASSWORD
			$Consulta = "select count(*) as existe from proyecto_modernizacion.funcionarios ";
			$Consulta.= " where rut ='".$CookieRut."' and password2 =md5('".strtoupper(trim($TxtPassword))."')";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila= mysqli_fetch_array($Respuesta);
			if ($Fila["existe"] == 0)
			{
				header("location:../principal/abrir_mes_anexo.php?PWValida=N&Proc=".$Proc."&BalanceMes=S&Sistema=".$Sistema."&Ano=".$Ano."&Mes=".$Mes);
				break;
			}
			else
			{
				//PROCESO ABRIR				
				$Consulta = "select * from proyecto_modernizacion.sistemas ";
				$Consulta.= " where cierre='S'";
				if ($Sistema!="S")
				{
					$Consulta.= " and cod_sistema='".$Sistema."'";
				}
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					//CONSULTA ESTADO CIERRE OPERACIONAL		
					$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
					$Consulta.= " where cod_sistema='".$Fila["cod_sistema"]."'";
					$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1' and fecha_cierre = (";
					$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
					$Consulta.= " where cod_sistema='".$Fila["cod_sistema"]."'";
					$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1')";
					$Resp2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Resp2))
					{			
						//echo "Estado Parcial=".$Fila2["estado"];
						if ($Fila2["estado"] == "C")
						{								
							//CONSULTA CIERRE GENERAL, SI YA ESTA CERRADO NO SE GRABA REGISTRO
							$Consulta = "select cod_sistema, estado, fecha_cierre, rut_funcionario from proyecto_modernizacion.cierre_mes";
							$Consulta.= " where cod_sistema='".$Fila["cod_sistema"]."'";
							$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2' and fecha_cierre = (";
							$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
							$Consulta.= " where cod_sistema='".$Fila["cod_sistema"]."'";
							$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2')";
							$Resp3 = mysqli_query($link, $Consulta);	
							//echo $Consulta."<br>";
							if ($Fila3 = mysqli_fetch_array($Resp3))
							{				
								//echo "Estado General=".$Fila3["estado"];					
								if ($Fila3["estado"]=="C")
								{
									$Insertar = "insert into proyecto_modernizacion.cierre_mes (cod_sistema, ano, mes, fecha_cierre, cod_bloqueo, estado, rut_funcionario) ";
									$Insertar.= " values('".$Fila["cod_sistema"]."','".$Ano."','".$Mes."','".date("Y-m-d H:i:s")."','2', 'A', '".$CookieRut."')";
									mysqli_query($link, $Insertar);
								}
							}							
						}//FIN CIERRE PARCIAL
					}									
				}//FIN WHILE				
				echo "<script language=JavaScript>";
				echo "window.opener.document.frmPrincipal.action='cierre_mes.php?Proceso=R&Sistema=".$Sistema."&Ano=".$Ano."&Mes=".$Mes."';";
				echo "window.opener.document.frmPrincipal.submit();";
				echo "window.close();";
				echo "</script>";
			}
			break;
	}
?>