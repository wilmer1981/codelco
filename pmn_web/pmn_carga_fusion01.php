<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	$Rut =$CookieRut;
	$Fecha = $AnoFusion."-".$MesFusion."-".$DiaFusion;
	switch ($Proceso)
	{
		case "G2": //GRABAR
			$Consulta="select * from pmn_web.fusion  ";
			$Consulta.=" where fecha='".$Fecha."' and producto ='".$CmbProductos."' and subproducto = '".$CmbSubProducto."' and correlativo='".$Correlativo."' ";
			//echo $Consulta."<br>";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				$Actualizar="UPDATE pmn_web.fusion set peso='".str_replace(",",".",$Peso)."',observacion ='".$Observacion."' "; 
				$Actualizar.=" where fecha='".$Fecha."' and producto ='".$CmbProductos."' and subproducto = '".$CmbSubProducto."' and correlativo='".$Correlativo."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				
				//Movimientos_Pmn('',$CmbProductos,$CmbSubProducto,'2',str_replace(",",".",$Peso),'1','0','0','8',$CookieRut,'M',$Fecha,'0');
			}
			else
			{
				$Insertar = "INSERT INTO pmn_web.fusion ";
				$Insertar.= "(rut,fecha,producto,subproducto,peso,observacion,tipo) ";
				$Insertar.= "values('".$Rut."','".$Fecha."','".$CmbProductos."','".$CmbSubProducto."','".str_replace(",",".",$Peso)."','".$Observacion."','".$CmbTipo."')";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Insertar);

				//Movimientos_Pmn('',$CmbProductos,$CmbSubProducto,'2',str_replace(",",".",$Peso),'1','0','0','8',$CookieRut,'I',$Fecha,'0');
			}
			header("location:pmn_principal_reportes.php?MostrarFusion=S&DiaFusion=".$DiaFusion."&MesFusion=".$MesFusion."&AnoFusion=".$AnoFusion."&CmbTipo=".$CmbTipo."&Tab5=true");
		break;
		case "M":
			if (count($ChkFecha)>0)
			{

				while (list($i,$p) = each($ChkFecha))
				{
						header("location:pmn_principal_reportes.php?MostrarFusion=S&DiaFusion=".$DiaFusion."&MesFusion=".$MesFusion."&AnoFusion=".$AnoFusion."&CmbProductos=".$ChkProducto[$i]."&CmbSubProducto=".$ChkSubProducto[$i]."&Peso=".$ChkPesos[$i]."&Observacion=".$ChkObservacion[$i]."&Correlativo=".$ChkCorrelativo[$i]."&CmbTipo=".$ChkTipo[$i]."&Tab5=true");					
				}
			}
			else
			{
				header("location:pmn_principal_reportes.php?MostrarFusion=S&DiaFusion=".$DiaFusion."&MesFusion=".$MesFusion."&AnoFusion=".$AnoFusion."&Tab5=true");
			}
			break;
		case "E2":
			if (count($ChkFecha)>0)
			{
				while (list($i,$p) = each($ChkFecha))
				{
						$Eliminar = "delete from  pmn_web.fusion ";
						$Eliminar.= " where fecha = '".$AnoFusion."-".$MesFusion."-".$DiaFusion."'";
						$Eliminar.= " and producto = '".$ChkProducto[$i]."'";
						$Eliminar.= " and subproducto = '".$ChkSubProducto[$i]."'";
						$Eliminar.= " and correlativo = '".$ChkCorrelativo[$i]."'";
						//echo $Eliminar."<br>";
						mysqli_query($link, $Eliminar);
						
						//Movimientos_Pmn('',$ChkProducto[$i],$ChkSubProducto[$i],'2','0','1','0','0','8',$CookieRut,'E',$Ano."-".$Mes."-".$Dia,'0');
				}
				header("location:pmn_principal_reportes.php?MostrarFusion=S&DiaFusion=".$DiaFusion."&MesFusion=".$MesFusion."&AnoFusion=".$AnoFusion."&Tab5=true");
			}
			else
			{
				header("location:pmn_principal_reportes.php?MostrarFusion=S&DiaFusion=".$DiaFusion."&MesFusion=".$MesFusion."&AnoFusion=".$AnoFusion."&Tab5=true");
			}
			
			break;
		case "C": //CANCELAR
			header("location:pmn_principal_reportes.php?CmbTipo=2&Tab5=true");
			break;
		case "Recuperacion":
			$Actualizar=" UPDATE pmn_web.fusion set recuperacion='".str_replace(",",".",$Recuperacion)."', ";
			$Actualizar.=" cantidad_anodos='".$CantAnodos."' where fecha='".$Fecha."'";
			//echo $Actualizar;
			mysqli_query($link, $Actualizar);
			header("location:pmn_principal_reportes.php?MostrarFusion=S&DiaFusion=".$DiaFusion."&MesFusion=".$MesFusion."&AnoFusion=".$AnoFusion."&VerFusion=".$Ver."&Tab5=true");
			break;
	}
?>