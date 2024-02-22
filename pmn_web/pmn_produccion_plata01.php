<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	$Fecha = $AnoPPlata."-".$MesPPlata."-".$DiaPPlata;
	
	$PesoCaja=str_replace(".","",$PesoCaja);
	$PesoCaja=str_replace(",",".",$PesoCaja);
	$Sobrante=str_replace(".","",$Sobrante);
	$Sobrante=str_replace(",",".",$Sobrante);
	switch ($Proceso)
	{
		case "G1": //GRABAR
			$Consulta = "select * from pmn_web.produccion_plata ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.=" and correlativo='".$CorrelativoPlata."'";
			//echo $Consulta;
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.produccion_plata set";
				//$Actualizar.= " observacion = '".str_replace("'"," ",$Obs)."' ";
				$Actualizar.= " num_electrolisis = '".str_replace(",",".",$NumElectrolisis)."', ";
				$Actualizar.= " num_caja = '".str_replace(",",".",$NumCaja)."', ";
				$Actualizar.= " peso = '".$PesoCaja."', ";
				$Actualizar.= " sobrante = '".$Sobrante."', ";
				$Actualizar.= " desde = '".$txtdesde."',";
				$Actualizar.= " hasta = '".$txthasta."'";
				//$Actualizar.= " granalla_reproceso = '".str_replace(",",".",$GranallaReproceso)."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.=" and correlativo='".$CorrelativoPlata."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				
				//Movimientos_Pmn('','1','12','2',str_replace(",",".",$PesoCaja),str_replace(",",".",$NumCaja),'0',$NumElectrolisis,'10',$CookieRut,'M',$CorrelativoPlata,'0');
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.produccion_plata ";
				$Insertar.= "(rut, fecha,num_electrolisis,num_caja,peso,sobrante,tipo,desde,hasta) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$NumElectrolisis."','".$NumCaja."','".$PesoCaja."','".$Sobrante."','".$CmbTipoPPlata."','".$txtdesde."', '".$txthasta."')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
			
				$Consulta = "select correlativo from pmn_web.produccion_plata ";
				$Consulta.= " where num_electrolisis = '".$NumElectrolisis."'";
				$Consulta.=" and fecha='".$Fecha."'";
				//echo $Consulta;
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Row = mysqli_fetch_array($Respuesta))
					$Corr=$Row[correlativo];
					
				//Movimientos_Pmn('','1','12','2',str_replace(",",".",$PesoCaja),str_replace(",",".",$NumCaja),'0',$NumElectrolisis,'10',$CookieRut,'I',$Corr,'0');	
			}
			//echo "CMB TIPO:    ".$CmbTipoPSub; 
			if ($CmbTipoPPlata==4)
			{
				header("location:pmn_principal_reportes.php?MostrarPSub=S&DiaPPlata=".$DiaPPlata."&MesPPlata=".$MesPPlata."&AnoPPlata=".$AnoPPlata."&CmbTipoPPlata=".$CmbTipoPPlata."&Opcion=S&Tab11=true");
			}
			else
			{
				header("location:pmn_principal_reportes.php?MostrarPSub=S&DiaPPlata=".$DiaPPlata."&MesPPlata=".$MesPPlata."&AnoPPlata=".$AnoPPlata."&CmbTipoPPlata=".$CmbTipoPPlata."&Tab11=true");
			}
			break;
		case "M1":
			//if (count($ChkNumCaja)>0)
			//{
				//echo $Datos."<br>";
				$Valor=explode('~',$Datos);
				//echo $Valor[4]."<br>";
				if ($Valor[2]!='4')
				{
					header("location:pmn_principal_reportes.php?MostrarPSub=S&DiaPPlata=".$DiaPPlata."&MesPPlata=".$MesPPlata."&AnoPPlata=".$AnoPPlata."&NumCaja=".$Valor[1]."&NumElectrolisis=".$Valor[0]."&PesoCaja=".$Valor[3]."&Sobrante=".$Valor[4]."&GranallaReproceso=".$Valor[5]."&CorrelativoPlata=".$Valor[6]."&CmbTipoPPlata=".$Valor[2]."&txtdesde=".$Valor[7]."&txthasta=".$Valor[8]."&Tab11=true");
				}
				else
				{
					header("location:pmn_principal_reportes.php?MostrarPSub=S&Opcion=S&DiaPPlata=".$DiaPPlata."&MesPPlata=".$MesPPlata."&AnoPPlata=".$AnoPPlata."&NumCaja=".$Valor[1]."&NumElectrolisis=".$Valor[0]."&PesoCaja=".$Valor[3]."&Sobrante=".$Valor[4]."&CorrelativoPlata=".$Valor[6]."&CmbTipoPPlata=".$Valor[2]."&txtdesde=".$Valor[7]."&txthasta=".$Valor[8]."&Tab11=true");
				}
			//}
			//else
			//{
			//	header("location:pmn_principal_reportes.php?MostrarPSub=S&DiaPPlata=".$DiaPPlata."&MesPPlata=".$MesPPlata."&AnoPPlata=".$AnoPPlata."&Tab11=true");
			//}
			break;
		case "E1":
			//if (count($ChkNumCaja)>0)
			//{
				$Datos=explode('//',$Datos);				
				while (list($i,$p) = each($Datos))
				{
					$Dato=explode('~',$p);
					$Eliminar = "delete from pmn_web.produccion_plata ";
					$Eliminar.= " where fecha = '".$AnoPPlata."-".$MesPPlata."-".$DiaPPlata."'";
					$Eliminar.=" and correlativo = '".$Dato[6]."'";
					//echo $Eliminar."<br>";
					mysqli_query($link, $Eliminar);
					
					//Movimientos_Pmn('','1','12','2','0','1','0',$NumElectrolisis,'10',$CookieRut,'E',$Dato[6],'0');
					//echo $Eliminar."<br>";
				}
			//}
			header("location:pmn_principal_reportes.php?MostrarPSub=S&DiaPPlata=".$DiaPPlata."&MesPPlata=".$MesPPlata."&AnoPPlata=".$AnoPPlata."&Tab11=true");
			break;
		case "C": //CANCELAR
			header("location:pmn_principal_reportes.php?Tab11=true");
			break;
	}
?>