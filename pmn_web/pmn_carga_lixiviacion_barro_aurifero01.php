<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	$Fecha = $AnoAuri."-".$MesAuri."-".$DiaAuri;
	//echo "Operador".$Operador."<br>";
	
	$TxtPeso=str_replace('.','',$TxtPeso);
	$TxtPeso=str_replace(',','.',$TxtPeso);
	$TxtHumedad=str_replace('.','',$TxtHumedad);
	$TxtHumedad=str_replace(',','.',$TxtHumedad);
	switch ($Proceso)
	{
		case "G": //GRABAR
			$Consulta = "select * from pmn_web.carga_lixiviacion_barro_aurifero ";
			$Consulta.= " where fecha = '".$Fecha."' ";
			$Consulta.= " and turno = '".$Turno."' ";
			$Consulta.= " and num_electrolisis = '".$TxtElectrolisis."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				//Actualiza
				$Actualizar = "UPDATE pmn_web.carga_lixiviacion_barro_aurifero set ";
				$Actualizar.= " peso = '".$TxtPeso."', ";
				$Actualizar.= " operador ='".$OperadorLixiv1."', ";
				$Actualizar.= " humedad = '".$TxtHumedad."',";
				$Actualizar.= " correlativo = '".$Correlativo."'";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and turno = '".$Turno."'";
				$Actualizar.= " and num_electrolisis = '".$TxtElectrolisis."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				
				//Movimientos_Pmn('','26','2','2',str_replace(",",".",$TxtPeso),'1','0',$TxtElectrolisis,'7-1',$CookieRut,'M',$Fecha,$Turno);
			}
			else
			{
				$Insertar = "INSERT INTO pmn_web.carga_lixiviacion_barro_aurifero ";
				$Insertar.= "(rut, fecha, turno, peso,num_electrolisis,operador,correlativo,humedad) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Turno."','".$TxtPeso."','".$TxtElectrolisis."',";
				$Insertar.= "'".$OperadorLixiv1."','".$Correlativo."', '".$TxtHumedad."')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
				
				//Movimientos_Pmn('','26','2','2',str_replace(",",".",$TxtPeso),'1','0',$TxtElectrolisis,'7-1',$CookieRut,'I',$Fecha,$Turno);			
				/*
				$Consulta = "select count(*) as valor from pmn_web.carga_lixiviacion_barro_aurifero ";
				$Consulta.= " where fecha = '".$Fecha."' ";
				$Consulta.= " and turno = '".$Turno."' ";
				echo $Consulta."<br>";
				$Respuesta1 = mysqli_query($link, $Consulta);
				$Fila1=mysqli_fetch_array($Respuesta1);
				//echo $Fila1["valor"]."<br>";
				if($Fila1["valor"]!='0')
				{
					$Consulta = "select correlativo from pmn_web.carga_lixiviacion_barro_aurifero ";
					$Consulta.= " where fecha = '".$Fecha."' ";
					$Consulta.= " and turno = '".$Turno."' ";
					//echo $Consulta."<br>";
					$Respuesta2 = mysqli_query($link, $Consulta);
					$Fila2=mysqli_fetch_array($Respuesta2);
					$Insertar = "INSERT INTO pmn_web.carga_lixiviacion_barro_aurifero ";
					$Insertar.= "(rut, fecha, turno, peso,num_electrolisis,operador,correlativo,humedad) ";
					$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Turno."','".str_replace(",",".",$TxtPeso)."','".$TxtElectrolisis."',";
					$Insertar.= "'".$Operador."','".$Fila2[correlativo]."', '".$TxtHumedad."')";
					//echo $Insertar."<br>";
					mysqli_query($link, $Insertar);			
				}
				else
				{
					$Consulta = "select max(correlativo) as numero from pmn_web.carga_lixiviacion_barro_aurifero ";
					$Respuesta2=mysqli_query($link, $Consulta);
					$Fila2=mysqli_fetch_array($Respuesta2);
					$Numero=$Fila2["numero"] + 1 ;	
					$Insertar = "INSERT INTO pmn_web.carga_lixiviacion_barro_aurifero ";
					$Insertar.= "(rut, fecha, turno, peso,num_electrolisis,operador,correlativo,humedad) ";
					$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Turno."','".str_replace(",",".",$TxtPeso)."','".$TxtElectrolisis."',";
					$Insertar.= "'".$Operador."','".$Numero."','".$TxtHumedad."')";
					//echo $Insertar."<br>";
					mysqli_query($link, $Insertar);							
				}				
				*/
			}			

			header("location:pmn_principal_reportes.php?DiaAuri=".$DiaAuri."&MesAuri=".$MesAuri."&AnoAuri=".$AnoAuri."&OperadorLixiv1=".$OperadorLixiv1."&Turno=".$Turno."&MostrarLixiv1=S&Correlativo=".$Correlativo."&Tab10=true&TabLixiAu1=true");
			break;
		case "M":
			if (count($ChkTurno)>0)
			{
				while (list($i,$p) = each($ChkTurno))
				{
					
					header("location:pmn_principal_reportes.php?DiaAuri=".$DiaAuri."&MesAuri=".$MesAuri."&AnoAuri=".$AnoAuri."&Turno=".$p."&OperadorLixiv1=".$OperadorLixiv1."&TxtElectrolisis=".$ChkNumElec[$i]."&TxtPeso=".$ChkPeso[$i]."&MostrarLixiv1=S&TxtHumedad=".$ChkHumedad[$i]."&Tab10=true&TabLixiAu1=true");
					//header("location:pmn_carga_lixiviacion_barro_aurifero.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
				}
			}
			else
			{
				header("location:pmn_principal_reportes.php?DiaAuri=".$DiaAuri."&MesAuri=".$MesAuri."&AnoAuri=".$AnoAuri."&Tab10=true&TabLixiAu1=true");
			}
			break;  
		case "E":
			if (count($ChkTurno)>0)
			{
				while (list($i,$p) = each($ChkTurno))
				{
					$Eliminar = "delete from pmn_web.carga_lixiviacion_barro_aurifero ";
					$Eliminar.= " where fecha = '".$AnoAuri."-".$MesAuri."-".$DiaAuri."'";
					$Eliminar.= " and turno = '".$p."'";
					$Eliminar.= " and peso = '".$ChkPeso[$i]."'";
					$Eliminar.= " and num_electrolisis = '".$ChkNumElec[$i]."'";
					mysqli_query($link, $Eliminar);
					
					//Movimientos_Pmn('','26','2','2',$ChkPeso[$i],'1','0',$ChkNumElec[$i],'7-1',$CookieRut,'E',$AnoAuri."-".$MesAuri."-".$DiaAuri,$p)	;		
				}
			}
			echo 
			header("location:pmn_principal_reportes.php?DiaAuri=".$DiaAuri."&MesAuri=".$MesAuri."&AnoAuri=".$AnoAuri."&Tab10=true&TabLixiAu1=true");
			break;
		case "C": //CANCELAR
			header("location:pmn_principal_reportes.php?&Tab10=true&TabLixiAu1=true");
			break;
	} 
?>