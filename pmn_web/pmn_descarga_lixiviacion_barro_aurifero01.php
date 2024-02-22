<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	$Fecha = $AnoLixiA."-".$MesLixiA."-".$DiaLixiA;
	$HoraAux = $Hora.":".$Minuto.":00";
	
	$Muestra01=str_replace(".","",$Muestra01);
	$Muestra01=str_replace(",",".",$Muestra01);
	$PesoSeco=str_replace(".","",$PesoSeco);
	$PesoSeco=str_replace(",",".",$PesoSeco);
	switch ($Proceso)
	{
		case "G": //GRABAR
			$Consulta = "select * from pmn_web.descarga_lixiviacion_barro_aurifero ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and turno = '".$Turno."'";
			$Consulta.= " and correlativo = '".$CorrelativoAux."'";
			$Consulta.= " and num_electrolisis = '".$ElectrolisisAux."'" ;
			$Respuesta = mysqli_query($link, $Consulta);			

			//echo $Consulta."<br>";
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualiza
				$Actualizar = "UPDATE pmn_web.descarga_lixiviacion_barro_aurifero set";
				$Actualizar.= " peso_seco = '".$PesoSeco."', ";
			    $Actualizar.= " muestra01 = '".$Muestra01."', ";
				$Actualizar.= " operador = '".$Operador."', ";
				$Actualizar.= " observacion = '".$Obs."', ";
				$Actualizar.= " correlativo = '".$CmbCorrelativo."',";
				$Actualizar.= " num_electrolisis = '".$Electrolisis."'";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and turno = '".$Turno."'";
				$Actualizar.= " and correlativo = '".$CorrelativoAux."'";
				$Actualizar.= " and num_electrolisis = '".$ElectrolisisAux."'" ;
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
				
				//Movimientos_Pmn('','26','2','2',$PesoSeco,'1','0',$ElectrolisisAux,'7-2',$CookieRut,'M',$CorrelativoAux,$Turno);
			}
			else
			{
				//Inserta
				$Insertar = "INSERT INTO pmn_web.descarga_lixiviacion_barro_aurifero ";
				$Insertar.= "(rut, fecha, turno, hora, peso_seco, muestra01, operador, observacion,correlativo,num_electrolisis) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Turno."','".$HoraAux."','".$PesoSeco."',";
				$Insertar.= "'".$Muestra01."','".$Operador."', '".$Obs."','".$CmbCorrelativo."', '".$Electrolisis."')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
				//Movimientos_Pmn('','26','2','2',$PesoSeco,'1','0',$Electrolisis,'7-2',$CookieRut,'I',$CmbCorrelativo,$Turno);
			}
			header("location:pmn_principal_reportes.php?DiaLixiA=".$DiaLixiA."&MesLixiA=".$MesLixiA."&AnoLixiA=".$AnoLixiA."&Tab10=true&TabLixiAu2=true");
			break;
		case "M":
			if (count($ChkTurno)>0)
			{
				while (list($i,$p) = each($ChkTurno))
				{
					header("location:pmn_principal_reportes.php?Mostrar=S&DiaLixiA=".$DiaLixiA."&MesLixiA=".$MesLixiA."&AnoLixiA=".$AnoLixiA."&Turno=".$p."&HoraAux=".$ChkHora[$i]."&CmbCorrelativo=".$ChkCorrelativo[$i]."&Electrolisis=".$ChkElectrolisis[$i]."&Opc=M&CorrelativoAux=".$ChkCorrelativo[$i]."&ElectrolisisAux=".$ChkElectrolisis[$i]."&Tab10=true&TabLixiAu2=true");
				}
			}
			else
			{
				header("location:pmn_principal_reportes.php?DiaLixiA=".$DiaLixiA."&MesLixiA=".$MesLixiA."&AnoLixiA=".$AnoLixiA."&Tab10=true&TabLixiAu2=true");
			}
			break;
		case "E":
			if (count($ChkTurno)>0)
			{
				while (list($i,$p) = each($ChkTurno))
				{
					$Eliminar = "delete from pmn_web.descarga_lixiviacion_barro_aurifero ";
					$Eliminar.= " where fecha = '".$AnoLixiA."-".$MesLixiA."-".$DiaLixiA."'";
					$Eliminar.= " and turno = '".$p."'";
					$Eliminar.= " and num_electrolisis = '".$ChkElectrolisis[$i]."'";
					$Eliminar.= " and correlativo = '".$ChkCorrelativo[$i]."'";					
					//echo $Eliminar."<br>";
					mysqli_query($link, $Eliminar);
					
					//Movimientos_Pmn('','26','2','2','0','0','0',$ChkElectrolisis[$i],'7-2',$CookieRut,'I',$ChkCorrelativo[$i],$p);
				}
			}
			header("location:pmn_principal_reportes.php?DiaLixiA=".$DiaLixiA."&MesLixiA=".$MesLixiA."&Ano=".$AnoLixiA."&Tab10=true&TabLixiAu2=true");
			break;
		case "C": //CANCELAR
			header("location:pmn_principal_reportes.php?&Tab10=true&TabLixiAu2=true");
			break;
		case "R":
			//consulta segun correlativo del a�o, para traer el N� de Electrolisis.			
			$consulta = "SELECT * FROM pmn_web.carga_lixiviacion_barro_aurifero";
			$consulta.= " WHERE correlativo = '".$CmbCorrelativo."'";
   // AND YEAR(fecha) = '".$Ano."'";
	//		echo "hola".$consulta;
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			
			$linea = "DiaLixiA=".$DiaLixiA."&MesLixiA=".$MesLixiA."&Ano=".$AnoLixiA."&Electrolisis=".$row[num_electrolisis]."&Turno=".$Turno."&CmbCorrelativo=".$CmbCorrelativo;
			if ($Opc == "")
				$linea.= "&Opc=&CorrelativoAux=".$CmbCorrelativo."&ElectrolisisAux=".$row[num_electrolisis];
			else
				$linea.= "&Opc=M&Mostrar=S&PesoSeco=".$PesoSeco."&Muestra01=".$Muestra01."&Obs=".$Obs."&Operador=".$Operador."&Hora=".$Hora."&Minuto=".$Minuto."&CorrelativoAux=".$CorrelativoAux."&ElectrolisisAux=".$ElectrolisisAux;
				
				
			header("location:pmn_principal_reportes.php?".$linea."&Tab10=true&TabLixiAu2=true");			
			break;
	}
?>
