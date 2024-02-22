<?php
  //$EncontroPortalX = $_COOKIE["EncontroPortalX"]; 
  //$CookieRutAUX    = $_COOKIE["CookieRutAUX"]; 

    //agregado por Wilmer
    $txtrut      = $_POST["txtrut"]; 
	$txtpassword = $_POST["txtpassword"]; 

	//echo "<br>txtrut: ".$txtrut;
	//echo "<br>txtpassword: ".$txtpassword;
	/////////////////////////////////
	$EncontroPortalX='';
	if($EncontroPortalX == 'S')
	{
		$txtrut=$CookieRutAUX;
		echo "entrooo S";
	}
	else
	{	
		$EncontroPortalX='';
		echo "NO entrooo X='' ";
	}
	include("principal/conectar_index.php");
	//$IpUser=$HTTP_SERVER_VARS["REMOTE_ADDR"];

	$IpUser   = $_SERVER['REMOTE_ADDR'];
	$Consulta = "SELECT rut, password, fecha_cambio_password, bloqueo_pass ";
	$Consulta.= " FROM proyecto_modernizacion.funcionarios ";
	$Consulta.= " WHERE rut = '".$txtrut."'"; //consulta en la tabla funcionarios
	
	$rs = mysqli_query($link, $Consulta);

	if($row = mysqli_fetch_array($rs))
	{
		echo "<br><br>Resultado:<br>";
		var_dump($row);
		$txtpasswd = strtoupper($txtpassword);
		if($row["bloqueo_pass"]!='S') //revisa si la contraseña del usuario esta bloqueada y deniega acceso
		{
			echo "<br><br>no tiene bloqueo<br>";
			$Consulta = "SELECT * ";
			$Consulta.= " FROM proyecto_modernizacion.funcionarios ";
			$Consulta.= " WHERE rut = '".$txtrut."'";
			if($EncontroPortalX != 'S')
				$Consulta.= " and password = md5('".$txtpasswd."')"; 	
				//$EncontroPortalX='';
				$rsAux = mysqli_query($link, $Consulta);

			if ($rowAux=mysqli_fetch_array($rsAux))
			{
				$Activo = $rowAux["activo"];
				$FechaCambioPasswd = $rowAux["fecha_cambio_password"];

			    //echo "<br>Consulta resultado:<br>";
			    //var_dump($rowAux);
			    //exit();

				/*				
				//VERIFICA SI LA CUENTA ESTA CADUCADA
				$DifFecha=0;
				$ConsultaPass = "select max(fecha_hora) as fecha_hora from proyecto_modernizacion.control_acceso ";
				$ConsultaPass.= " where rut='".$txtrut."' and sistema='0'";
				//echo $ConsultaPass;
				$RespPass=mysqli_query($link, $ConsultaPass);
				if ($FilaPass=mysqli_fetch_array($RespPass))
				{
					$Fecha1 = $FilaPass["fecha_hora"];
					$Fecha2 = date("Y-m-d H:i:s");
					$DifFecha=0;
					//
					//echo $Fecha1."<br>";
					$AnoAux=substr($Fecha1,0,4);
					$MesAux=substr($Fecha1,5,2);
					$DiaAux=substr($Fecha1,8,2);
					$HoraAux=substr($Fecha1,11,2);
					$MinutoAux=substr($Fecha1,14,2);
					$SegundoAux=substr($Fecha1,17,2);
					//echo $Fecha2."<br>";
					$AnoAux2=substr($Fecha2,0,4);
					$MesAux2=substr($Fecha2,5,2);
					$DiaAux2=substr($Fecha2,8,2);
					$HoraAux2=substr($Fecha2,11,2);
					$MinutoAux2=substr($Fecha2,14,2);
					$SegundoAux2=substr($Fecha2,17,2);
					//echo $Fecha1." - ".$Fecha2."<br>";	
					//echo $HoraAux2."-".$HoraAux.", ".$MinutoAux2."-".$MinutoAux.", ".$SegundoAux2."-".$SegundoAux.", ".$MesAux2."-".$MesAux.", ".$DiaAux2."-".$DiaAux.", ".$AnoAux2."-".$AnoAux."<br>";
					$Fecha1=mktime($HoraAux, $MinutoAux, 0, $MesAux, $DiaAux, $AnoAux);
					$Fecha2=mktime($HoraAux2, $MinutoAux2, 0, $MesAux2, $DiaAux2, $AnoAux2);
					$DifFecha=$Fecha2-$Fecha1;
					$Horas = intval($DifFecha / 3600); 
					$Min = intval(($DifFecha-$Horas*3600)/60); 
					//$Min = (($Min * 100) / 60)/100;	
					//$seg = $DifFecha-$horas*3600-$min*60; 
					$DifFechaHr = $Horas;
					$DifFechaMin = $Min;
					$ValidaTime=true;
					$ConsultaPass2="select * from proyecto_modernizacion.funcionarios where rut='".$txtrut."'";
					$RespPass2=mysqli_query($link, $ConsultaPass2);			
					if ($FilaPass2=mysqli_fetch_array($RespPass2))
					{
						if ($FilaPass2["caduca"]=="N")
							$ValidaTime=false;
					}
					if (($DifFechaHr>0 && $ValidaTime==true) || ($DifFechaMin>60 && $ValidaTime==true))
					{
						$ActualizaActivo="UPDATE proyecto_modernizacion.funcionarios set activo='' where rut='".$txtrut."'";
						mysqli_query($ActualizaActivo);	
						$Activo = "";
						//header("location:caducado.php?Proceso=TimeOut");
					}
					//echo "Diferencia: $horas Hs:$min Min:$seg Seg"; 
					//$DifFecha=mktime($HoraAux2-$HoraAux, $MinutoAux2-$MinutoAux, $SegundoAux2-$SegundoAux, $MesAux2-$MesAux, $DiaAux2-$DiaAux, $AnoAux2-$AnoAux);
				}*/	
				//-----------------------------------
				//echo "<br>ingresando";

				if ($Activo=="" || $Activo==$IpUser || $rowAux["caduca"]=="N")
				{

					//echo "<br>Ingresooooo al IF caducva=N ";
					//echo "<br>TXTRUT: ".$txtrut;
					setcookie("CookieRut", $txtrut);	
					//exit();

					//PERIODO DE PESAJE DE RACKS Y CARROS
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '7' and cod_subclase='1'";
					$Respuesta = mysqli_query($link, $Consulta);

					//$filas = mysqli_fetch_array($Respuesta);
					//echo "<br>Consulta Result:<br> ";
					//var_dump($filas);
				
					$Periodo =0;
					$FechaComparacion='';
					if ($Fila = mysqli_fetch_array($Respuesta))
					{
					 //echo "<br>Consulta Result:<br> ";
					 //var_dump($Fila);
						//echo "<br>Subclase:".$Fila["valor_subclase1"];
						$Periodo = $Fila["valor_subclase1"];
						$FechaComparacion = date("Y-m-d", mktime(1,0,0,date("m")-$Periodo,date("d"),date("Y")));
					}
					//echo "<br>Periodo:".$Periodo;
					//echo "<br>FechaComparacion:".$FechaComparacion;
					//exit();
					//Junio 2017 Se modifica para nunca ingresar al recordar sesion
					//if ($ChkRecordar=="S")
					
					if(false)
					{
						//echo "entrooo con FALSE";
						$Consulta = "select * from proyecto_modernizacion.funcionarios ";
						$Consulta.= " where pc='".$IpUser."'";
						$Resp=mysqli_query($link, $Consulta);
						if ($Fila=mysqli_fetch_array($Resp))
						{
							$Actualizar = "UPDATE proyecto_modernizacion.funcionarios set";
							$Actualizar.= " pc='' ";
							$Actualizar.= " , recordar='' ";
							$Actualizar.= " where pc='".$IpUser."'";
							mysqli_query($link, $Actualizar);
						}
						$Actualizar = "UPDATE proyecto_modernizacion.funcionarios set";
						$Actualizar.= " pc='".$IpUser."' ";
						$Actualizar.= " , recordar='S' ";
						$Actualizar.= " where rut='".$txtrut."'";
						mysqli_query($link, $Actualizar);
					}else{
						echo "<br>entrooooo porq no es FALSE <br>";
						$Actualizar = "UPDATE proyecto_modernizacion.funcionarios set";
						$Actualizar.= " pc='' ";
						$Actualizar.= " , recordar='' ";
						$Actualizar.= " where rut='".$txtrut."'";
						mysqli_query($link, $Actualizar); // 1. aqui entroooooooooooooooooooooo
					}

					//echo "<br>bloque UPDATE<br>";
					
					//DEJA USUARIO ACTIVO EN EL SISTEMA
					//echo "DEJA USUARIO ACTIVO EN EL SISTEMA<br>";
					$Actualizar = " UPDATE proyecto_modernizacion.funcionarios set ";
					$Actualizar.= " activo='".$IpUser."'";
					$Actualizar.= " where rut='".$txtrut."'";
					//echo $Actualizar."<br>";
					mysqli_query($link, $Actualizar); // 2. aqui enroooooooooooooooo
					//exit();
					

					//echo "<br>bloque INSERTAR<br>";
					//-----------------GRABA EL ACCESO--------------------
					//echo "GRABA EL ACCESO<br>";
					//$HoraAcceso = date("Y-m-d H:i:s");
					$fecha = new DateTime();
					$HoraAcceso = $fecha->format("Y-m-d H:i:s");

					//echo "HoraAcceso:".$HoraAcceso."<br>";				
					$Insertar = "INSERT INTO control_acceso ";
					$Insertar.= " (fecha_hora, rut, ip, pc, sistema) ";
					$Insertar.= " VALUES ('".$HoraAcceso."', '".$txtrut."', '".$IpUser."', '', '0')";
					//$Insertar = "INSERT INTO control_acceso (fecha_hora, rut, ip, pc, sistema) VALUES ('".$HoraAcceso."', '".$txtrut."', '".$IpUser."', '', '0')";
					
					//echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
					//exit();

					//---------------------------------------------------
					/*echo "<br>Fecha_cambio_password: ".$rowAux["fecha_cambio_password"];
					echo "<br>FechaComparacion: ".$FechaComparacion;
					*/
					if ((date($rowAux["fecha_cambio_password"]) < date($FechaComparacion))||(substr($txtrut,0,4)==trim($txtpassword))){
						//echo "entroooooo a password02";
						header("Location:principal/password02.php");
					}else{
						//echo "entrooo a sistema usuarios";
						header("Location:principal/sistemas_usuario.php");
					}
				}
				else
				{
					header("location:principal/caducado.php?Proceso=NoAuto");
				}//FIN SI ESTA CADUCADO
			}else{	
				///////////agregado WSO/////////
				$intentos    = $_POST["intentos"];
				$maxIntentos = $_POST["maxIntentos"];
				
				/////////////////////////////////

				if($intentos>=($maxIntentos-1)) //Verifica si alcanza el máximo de intentos de ingreso al sistema
				{
					$mensaje='BLOQ';
					$Actualizar = " UPDATE proyecto_modernizacion.funcionarios set ";
					$Actualizar.= " bloqueo_pass='S' ";
					$Actualizar.= " where rut='".$txtrut."'";
					mysqli_query($link, $Actualizar);
					header("Location:index.php?mensaje=".$mensaje."&txtrut=".$txtrut);				
				}
				else			
					$mensaje = "PI"; 	//Contraseña incorrecta		
					header("Location:index.php?mensaje=".$mensaje."&txtrut=".$txtrut);
			}	
		}else
		{
			$mensaje = "BQ"; 	//Contraseña incorrecta		
			header("Location:index.php?mensaje=".$mensaje."&txtrut=".$txtrut);
		}
	}
	else
	{
		$mensaje = "UN"; //usuario no existe			
		header("Location:index.php?mensaje=".$mensaje);
	}
	include("principal/cerrar_principal.php");
?>
