<?php 	
	include("../principal/conectar_sec_web.php");
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut =$CookieRut;
	$Fecha=date('Y-m-d H:i:s');

	$Proceso = $_REQUEST["Proceso"];
	$Valores = $_REQUEST["Valores"];
	$CmbMes = $_REQUEST["CmbMes"];
	$CmbAno = $_REQUEST["CmbAno"];
	//$CmbEstado = $_REQUEST["CmbEstado"];
	$Estado = $_REQUEST["Estado"];
	$CodBulto = $_REQUEST["CodBulto"];
	$NumBulto = $_REQUEST["NumBulto"];
	$CodCliente = $_REQUEST["CodCliente"];
	$IE = $_REQUEST["IE"];
	$CorrCanje = $_REQUEST["CorrCanje"];
	
	switch ($Proceso)
	{  
		case "G":
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);
				/*echo "ie".$Datos2[0]."<br>";
				echo "cod_bulto".$Datos2[1]."<br>";
				echo "num".$Datos2[2]."<br>";*/
				$Consulta = "SELECT corr_enm from sec_web.solicitud_certificado where corr_enm = '".$Datos2[0]."'";
				$Consulta.= " and cod_bulto = '".$Datos2[1]."' and num_bulto = '".$Datos2[2]."' and year(fecha_hora)= year('".$Fecha."')";
				$Sel = mysqli_query($link, $Consulta);
			//	echo "RR.".$Consulta;
				if ($Fila=mysqli_fetch_array($Sel))
				{
					$a = 1;  
				}	
				else
				{
					$Insertar="INSERT INTO sec_web.solicitud_certificado (corr_enm,cod_bulto,num_bulto, ";
					$Insertar.=" estado,fecha_hora,rut) values(";
					$Insertar.=" '".$Datos2[0]."','".$Datos2[1]."','".$Datos2[2]."','".$CmbEstado."','".$Fecha."','".$Rut."') ";
					mysqli_query($link, $Insertar);
					//echo $Insertar;
				}	
			}
			header("location:sec_solicitud_certificados.php?CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&Estado=".$Estado."&Mostrar=S");
			break;
		case "G_Cliente":
			$Actualizar = "UPDATE sec_web.solicitud_certificado set ";
			if ($Cliente == "N")
				$Actualizar.= " cod_cliente2 = ''";
			else
				$Actualizar.= " cod_cliente2 = '".$Cliente."'";
			$Actualizar.= " where cod_bulto = '".$CodBulto."'";
			$Actualizar.= " and num_bulto = '".$NumBulto."'";
			$Actualizar.= " and corr_enm = '".$IE."'";
			mysqli_query($link, $Actualizar);
			header("location:sec_solicitud_certificados02.php?CodBulto=".$CodBulto."&NumBulto=".$NumBulto."&CodCliente=".$CodCliente."&IE=".$IE."&CorrCanje=".$CorrCanje);
			break;
			
		case "H":
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);  
			/*	echo "ie".$Datos2[0]."<br>";
				echo "cod_bulto".$Datos2[1]."<br>";
				echo "num".$Datos2[2]."<br>";*/
				$Consulta = "SELECT * from sec_web.solicitud_certificado where corr_enm = '".$Datos2[0]."'";
				$Consulta.= " and cod_bulto = '".$Datos2[1]."' and num_bulto = '".$Datos2[2]."' and year(fecha_hora)= '".$CmbAno."'";
				$Consulta.= " and generacion = 'S' and estado_certificado = 'A'";
				$Resp = mysqli_query($link, $Consulta);
			//	echo "RR.".$Consulta;
				if ($Fila1=mysqli_fetch_array($Resp))
				{
					$Consulta = "SELECT * from sec_web.certificacion_catodos where corr_enm = '".$Fila1["corr_enm"]."'";
					$Consulta.= " and num_certificado = '".$Fila1["num_certificado"]."' and year(fecha) = year('".$Fila1["fecha_hora"]."')";
				//	echo "WWW".$Consulta;
					$Resp1 = mysqli_query($link, $Consulta);
					if ($Fila2=mysqli_fetch_array($Resp1))
					{
						$Elimina = "DELETE from sec_web.solicitud_certificado where corr_enm = '".$Datos2[0]."'";
	  					$Elimina.= " and cod_bulto = '".$Datos2[1]."' and num_bulto = '".$Datos2[2]."' and year(fecha_hora)= '".$CmbAno."'";
						$Elimina.= " and generacion = 'S'  and estado_certificado = 'A'";
						mysqli_query($link, $Elimina);
					//	echo "EE".$Elimina;
						
						$Elimina1 = "DELETE from sec_web.certificacion_catodos where corr_enm = '".$Fila1["corr_enm"]."'";
						$Elimina1.= " and num_certificado = '".$Fila1["num_certificado"]."' and year(fecha) = year('".$Fila1["fecha_hora"]."')";
						mysqli_query($link, $Elimina1);
					//	echo "Hola".$Elimina1;
					}	
				}	
				else
				{
					$Consulta = "SELECT * from sec_web.solicitud_certificado where corr_enm = '".$Datos2[0]."'";
					$Consulta.= " and cod_bulto = '".$Datos2[1]."' and num_bulto = '".$Datos2[2]."' and year(fecha_hora)= '".$CmbAno."'";
					$Consulta.= " and generacion = 'N' and estado_certificado = 'A'";
					$RespN = mysqli_query($link, $Consulta);
					//	echo "RR.".$Consulta;
					if ($FilaN=mysqli_fetch_array($RespN))
					{
						$EliminaN = "DELETE from sec_web.solicitud_certificado where corr_enm = '".$Datos2[0]."'";
						$EliminaN.= " and cod_bulto = '".$Datos2[1]."' and num_bulto = '".$Datos2[2]."' and year(fecha_hora)= '".$CmbAno."'";
						$EliminaN.= " and generacion = 'N'  and estado_certificado = 'A'";
						mysqli_query($link, $EliminaN);
					//	echo "EE".$Elimina;
					}
				}	
			}
			header("location:sec_solicitud_certificados.php?CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&Estado=".$Estado."&Mostrar=S");
			break;
	}
?>
