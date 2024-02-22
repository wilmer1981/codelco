<?php

include("../principal/conectar_pmn_web.php");
include("funciones/pmn_funciones.php");
$Rut =$CookieRut;
$Fecha = $CmbAno."-".$CmbMes."-".$CmbDias; 
switch ($Opcion)
{
	case "G":
 		$Consulta = "select * from pmn_web.embarque_plata where fecha = '".$Fecha."' and correlativo = '".$Correlativo."' ";
		//echo $Consulta."<br>";
		$Respuesta=mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
				//Actualiza
				$Actualizar = "UPDATE pmn_web.embarque_plata set";
				$Actualizar.= " cantidad = '".$Cantidad."', ";
			    $Actualizar.= " peso = '".str_replace(",",".",$Peso)."', ";
				$Actualizar.= " valor = '".str_replace(",",".",$Dolar)."', ";
				$Actualizar.= " num_acta = '".str_replace(",",".",$Acta)."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and correlativo = '".$Correlativo."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				
				//ovimientos_Pmn('','1','12','4',str_replace(",",".",$Peso),$Cantidad,'0','0','12-1',$CookieRut,'M',$Correlativo,'0');
		}
		else 		
		{
			$insertar="INSERT INTO embarque_plata(rut,fecha,cantidad,peso,valor,num_acta)";			
			$insertar.=" values ('".$Rut."','".$Fecha."','".$Cantidad."','".$Peso."','".$Dolar."','".$Acta."')";
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);	

			$Consulta = "select correlativo from pmn_web.embarque_plata where fecha = '".$Fecha."' and num_acta='".$Acta."' and peso='".$Peso."'";
			//echo $Consulta."<br>";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
				$Coor=$Fila[correlativo];
				
			//Movimientos_Pmn('','1','12','4',str_replace(",",".",$Peso),$Cantidad,'0','0','12-1',$CookieRut,'I',$Coor,'0')	;
		}	
		header("location:pmn_principal_reportes.php?MostrarEmPlata=C&CmbAno=".$CmbAno."&CmbMes=".$CmbMes."&CmbDias=".$CmbDias."&Correlativo=".$Correlativo."&Tab9=true&TabEmba2=true");
	break;
	case "M":
/*		if (count($ChkCaja)>0)
		{

			while (list($i,$p) = each($ChkCaja))
			{
*/			
			$Datos=explode('~',$Datos);
			header("location:pmn_principal_reportes.php?MostrarEmPlata=C&CmbDias=".$CmbDias."&CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&Cantidad=".$Datos[2]."&Peso=".$Datos[3]."&Dolar=".$Datos[4]."&Acta=".$Datos[5]."&Correlativo=".$Datos[1]."&Tab9=true&TabEmba2=true");
/*			}
		}
		else
		{
			header("location:pmn_principal_reportes.php?CmbDias=".$CmbDias."&CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&Tab9=true&TabEmba2=true");
		}
*/		break;
	break;
	case "E"://Borra el detalle
		//echo "borrar el registro:     ".$Datos."<br>";
/*		if (count($ChkCaja)>0)
		{*/
			$Datos=explode('//',$Datos);
			while (list($i,$p) = each($Datos))
			{
				$Datos2=explode('~',$p);
				$Eliminar = "delete from  pmn_web.embarque_plata ";
				$Eliminar.=" where fecha = '".$Datos2[0]."'";
				$Eliminar.= " and correlativo = '".$Datos2[1]."'";
				//echo "Eli".$Eliminar;  
				mysqli_query($link, $Eliminar);
				
				//Movimientos_Pmn('','1','12','4','0','0','0','0','12-1',$CookieRut,'E',$Datos2[1],'0');	
			}
			header("location:pmn_principal_reportes.php?MostrarEmPlata=C&CmbDias=".$CmbDias."&CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&Tab9=true&TabEmba2=true");//."&NumCaja=".$p."&Sello=".$ChkSello[$i]."&NumElectrolisis=".$ChkElectrolisis[$i]."&PesoBruto=".$ChkPesoBruto[$i]."&ValorDec=".$ChkValor[$i]."&ProCajas=".$ChkPromCaja[$i]);
/*		}
		else
		{
			header("location:pmn_principal_reportes.php?CmbDias=".$CmbDias."&CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&Tab9=true&TabEmba2=true");
		}
*/		break;
		//header("location:pmn_produccion_granalla_horno_cristales_plata.php?Mostrar=C&CmbAno=".$CmbAno."&CmbMes=".$CmbMes."&CmbDias=".$CmbDias."&CmbOperador=".$CmbOperador."&TxtObservacion=".$TxtObservacion."&ProCajas=".$ProCajas."&Bloquear=".$Bloquear);
	case "C":
		header("location:pmn_principal_reportes.php?&Tab9=true&TabEmba2=true");
	break;
	case "G_Electrolisis":
	
		$Consulta = "select * from pmn_web.detalle_embarque_plata ";
		$Consulta.= " where num_acta = '".$Acta."'";
		$Consulta.= " and num_electrolisis = '".$Electrolisis."'";
		$Consulta.= " and ano = '".substr($FechaEmbarque,0,4)."'";
		$Consulta.= " and mes = '".intval(substr($FechaEmbarque,5,2))."'";
		$Resp = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		//echo $Numcaja2."<br>";
		if ($Fila = mysqli_fetch_array($Resp))
		{
		
			$Actualizar = "UPDATE pmn_web.detalle_embarque_plata set";
			$Actualizar.= " cantidad = '".$NumCajas."'";
			$Actualizar.= " ,caja_ini = '".$Numcaja1."'";
			$Actualizar.= " ,caja_fin = '".$Numcaja2."'";
			$Actualizar.= " where num_acta = '".$Acta."'";
			$Actualizar.= " and num_electrolisis = '".$Electrolisis."'";
			$Actualizar.= " and ano = '".substr($FechaEmbarque,0,4)."'";
			$Actualizar.= " and mes = '".intval(substr($FechaEmbarque,5,2))."'";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar."<br>";
		}
		else 
		{
			$Insertar = "INSERT INTO pmn_web.detalle_embarque_plata (ano, mes, num_acta, num_electrolisis, cantidad,caja_ini,caja_fin) ";
			$Insertar.= " values('".substr($FechaEmbarque,0,4)."', '".intval(substr($FechaEmbarque,5,2))."', '".$Acta."', '".$Electrolisis."', '".$NumCajas."', '".$Numcaja1."', '".$Numcaja2."')";
			//echo $Insertar."<br>";
			mysqli_query($link, $Insertar);
		}
		header("location:pmn_embarque_plata_det.php?DiaEmb=".substr($FechaEmbarque,8,2)."&MesEmb=".substr($FechaEmbarque,5,2)."&AnoEmb=".substr($FechaEmbarque,0,4)."&Acta=".$Acta."&Vuelta=S");
	break;
	case "E_Electrolisis":
	
		$Eliminar = "delete from pmn_web.detalle_embarque_plata ";
		$Eliminar.= " where num_acta = '".$ActaElim."'";
		$Eliminar.= " and num_electrolisis = '".$ElectrolisisElim."'";
		$Eliminar.= " and ano = '".substr($FechaEmbarque,0,4)."'";
		$Eliminar.= " and mes = '".intval(substr($FechaEmbarque,5,2))."'";
		//echo"Eli".$Eliminar;
		mysqli_query($link, $Eliminar);
		header("location:pmn_embarque_plata_det.php?DiaEmb=".substr($FechaEmbarque,8,2)."&MesEmb=".substr($FechaEmbarque,5,2)."&AnoEmb=".substr($FechaEmbarque,0,4)."&Acta=".$Acta."&Vuelta=S");
	break;
}
?>
