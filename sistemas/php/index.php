<?php
//Trae parámetro de cantidad maxima de intentos fallidos y tiempo de espera.
$ConsIntento="SELECT * from sict_ope_parametros_generales where cod_parametro in ('90','91')";
$RespIntento=$dataBaseMysql->consulta($ConsIntento);
while($Fila=mysqli_fetch_assoc($RespIntento)){
	if($Fila["cod_parametro"]=='90')//Cantidad de intentos fallidos
		$maxIntentos=$Fila["cod_agrupacion"];
	if($Fila["cod_parametro"]=='91')//Tiempo de espera antes de desbloquear clave
		$tiempoEspera=$Fila["cod_agrupacion"];
}

switch($_GET["Opcion"])
{
	case "change":
		require_once("jsonConstructor.php");
	    if (filter_input(INPUT_SERVER, "REQUEST_METHOD") == "POST") {
            $Actual = filter_input(INPUT_POST, "inputActual", FILTER_DEFAULT, FILTER_FORCE_ARRAY);
            $New = filter_input(INPUT_POST, "inputNew", FILTER_DEFAULT, FILTER_FORCE_ARRAY);
            $New2 = filter_input(INPUT_POST, "inputNew2", FILTER_DEFAULT, FILTER_FORCE_ARRAY);

			$Consulta="SELECT * from sict_ope_usuario where rut='".$_SESSION[CookieRut]."' and password=md5('".$Actual[0]."')";
			//echo $Consulta;
			$Resp = $dataBaseMysql->consulta($Consulta);		
			if ($Fila=mysqli_fetch_assoc($Resp))
			{
	            $Query = "UPDATE sict_ope_usuario set password = md5('".$New2[0]."') where rut = '".$_SESSION[CookieRut]."'";
	            $dataBaseMysql->QueryAction($Query);	

				$json["mensaje"] = "Contraseña actualizada";
				$json["typeMsj"] = "success";		        	
				$json["sucess"] = true;		        	
				$json["p"] = "index";
	        }
	        else
	        {
				$json["mensaje"] = "La contraseña actual ingresada no es correcta";
				$json["typeMsj"] = "error";		        	
	        }		        
		}		
		echo json_encode($json);
		exit();
	break;
	case "login":
		require_once("jsonConstructor.php");
		$ahora = date('Y-m-d H:i:s');
		$fechaHoy=date('Y-m-d');
		$minutos;

		$TxtRut = $_POST["inputRut"];
		$TxtPassword = $_POST["inputPassword"];

		$fx->tiempoBloqueo($TxtRut, $tiempoEspera);	//revisa si ya paso el tiempo de bloqueo
		$_SESSION["ActionLogin"] = ""; 

			$Consulta = "SELECT * ";
			$Consulta.= " from sict_ope_usuario ";
			if($Tipo=='C')
				$Consulta.= " WHERE cuenta ='".$TxtRut."'"; 
			else
				$Consulta.= " WHERE CEIL(rut) = CEIL('".str_replace(".","",$TxtRut)."')"; 
			//echo 		$Consulta."<br>";
			$Resp = $dataBaseMysql->consulta($Consulta);
			if($Fila = mysqli_fetch_array($Resp))
			{
				if($Fila["bloqueo"]!='S') //Revisa si la contraseña del usuario está bloqueada y deniega acceso
				{			
					$Consulta = "SELECT * from sict_ope_usuario t1 ";
					if($Tipo=='C')
						$Consulta.= " WHERE id_usuario ='".$TxtRut."'"; 
					else
						$Consulta.= " WHERE CEIL(rut) = CEIL('".str_replace(".","",$TxtRut)."')";
					if($EncontroPortalX2 != 'S')
						$Consulta.= " and password = md5('".$TxtPassword."') "; 	
					//echo $Consulta;
					$Resp2 = $dataBaseMysql->consulta($Consulta);		
					if ($Fila2=mysqli_fetch_array($Resp2))
					{
						$NombreUsuario=$Fila2["ape_paterno"]." ".$Fila2["ape_materno"]." ".$Fila2["nombres"];
						setcookie("CookieNomUsuario", $NombreUsuario);
						$TipoUsu=$Fila2["cod_perfil"];
						$_SESSION["systemAccess"]["AccessoDateTime"]=date('Y-m-d G:i:s');
						$_SESSION["User"]=$Fila2["cuenta"];
						$_SESSION["CookieRut"]=$Fila2["rut"];

						$Resp3 = $fx->obtienePerfil($Fila2["cod_perfil"]);
						if($Fila3 = mysqli_fetch_array($Resp3))
						{
							$_SESSION["tipoPerfil"]=$Fila3["abrev_perfil"];
						}


						$TxtRutSinDigito = explode('-',$TxtRut);


						$Consulta="SELECT digito_verif_t,ape_paterno,ape_materno,nombre from sict_ope_trabajadores_asdt where rut_t='".$TxtRutSinDigito[0]."'";
						$Resp = $dataBaseMysql->consulta($Consulta);		
						$Fila=mysqli_fetch_assoc($Resp);
						$_SESSION["DigitoVerif"] = $Fila["digito_verif_t"];
						$_SESSION["PaternoApe"] = $Fila["ape_paterno"];
						$_SESSION["MaternoApe"] = $Fila["ape_materno"];
						$_SESSION["NombreUsu"] = $Fila["nombre"];
						$_SESSION["CookieNomUsuario"]=$Fila["ape_paterno"]." ".$Fila["ape_materno"]." ".$Fila["nombres"];
						mysqli_free_result($Resp);
						
						$_SESSION["CookieCodPerfil"] = $TipoUsu;
						$_SESSION['url_intermedia'] = $config['url_principal']."/".$rootPath."/?p=menu";

						//CONSULTAMOS SI LA CLAVE ES MENOR A 7 DIGITOS, SI ES ASI, SE DEBE CAMBIAR
						if(strlen($TxtPassword) < 7)
						{
							$_SESSION["PagCancel"] = "index";
							$json["MuestraMensaje"] = false;	
							$json["sucess"] = true;	
							$json["p"] = "changepass";	
						}
						else
						{
							$Consulta="SELECT * from sict_ope_usuario where rut='".$TxtRutSinDigito[0]."' and password=md5('".$TxtRutSinDigito[0]."')";
							//echo $Consulta."<br>";
							$Resp = $dataBaseMysql->consulta($Consulta);		
							if ($Fila=mysqli_fetch_assoc($Resp))
							{
								mysqli_free_result($Resp);	
								$_SESSION["PagCancel"] = "index";						
								$json["p"] = "changepass";
								$json["MuestraMensaje"] = false;	
								$json["sucess"] = true;	
								//header("location:sict_change_pass.php");
							}	
							else
							{
								$HoraAcceso = date("Y-m-d H:i:s");	

								$Insertar = "INSERT into sict_ope_accesos ";
								$Insertar.= " (fecha_hora, ip, rut, cod_perfil) ";
								$Insertar.= " VALUES ('".$HoraAcceso."', '".$IpUser."', '".$Fila2["rut"]."', '".$Fila2["cod_perfil"]."')";
								$dataBaseMysql->QueryAction($Insertar);
									$VALIDO='S';
								$Mensaje = "Ingresa al sistema";
								$json["MuestraMensaje"] = false;	
								$json["sucess"] = true;	
								$json["p"] = "menu";	
								//header("location:sict_menu.php");	
							}
						}
					}
					else 
					{	
						if($_SESSION["intentos"]==($maxIntentos-1)) //Si alcanza el máximo de intentos bloquea
						{
							$TxtRutSInDigito = explode('-',$TxtRut);
							$Actualizar = " UPDATE sict_ope_usuario set ";
							$Actualizar.= " bloqueo='S', fecha_bloqueo_pass='".$ahora."'";
							$Actualizar.= " where rut='".$TxtRutSInDigito[0]."'";
							//echo $Actualizar."<br>";
							$dataBaseMysql->QueryAction($Actualizar);
							$json["mensaje"] = "La clave ha sido bloqueada por alcanzar el máximo de intentos.\nPodría intentar nuevamente en ".$tiempoEspera." minutos.";
							$_SESSION["intentos"]=0;
						}
						else
						{
							if($_SESSION["intentos"] == "")
								$_SESSION["intentos"] = 1;

							$json["mensaje"] = "Datos ingresados incorrectos. Luego de ".$maxIntentos." intentos la clave será bloqueada.(Intento ".$_SESSION["intentos"].")";
							$_SESSION["intentos"]++;
						}
						$json["Titulo"] = "Mensaje de Sistema";
						$json["typeMsj"] = "error";
						//header("location:index.php?mensaje=".$Mensaje."&TxtRut=".str_replace("-","",str_replace(".","",$TxtRut))."");
					}
				}		
				else 
				{	
					$Mensaje = "Password Incorrecta";
					$json["mensaje"] = "Su clave se encuentra bloqueada.\nPodría intentar nuevamente en ".$_SESSION["minutos"]." minutos";
					$json["Titulo"] = "Mensaje de Sistema";
					$json["typeMsj"] = "error";
					//header("location:index.php?mensaje=".$Mensaje."&TxtRut=".str_replace("-","",str_replace(".","",$TxtRut))."");
				}		
			}
			else
			{
				$Mensaje = "Usuario no Existe"; 			
				$json["mensaje"] = "Usuario no Existe";
				$json["Titulo"] = "Mensaje de Sistema";
				$json["typeMsj"] = "error";
				//header("location:index.php?mensaje=".$Mensaje."");
			}			

		echo json_encode($json);
		exit();
	break;
	case "logout":
		session_destroy();
		$json["MuestraMensaje"] = false;	
		$json["sucess"] = true;
		$json["p"] = "index";	
		echo json_encode($json); 
		exit();
	break;
	default:
		session_destroy();
	break;
}

?>