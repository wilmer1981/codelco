<?php

include("../principal/conectar_pmn_web.php");
include("funciones/pmn_funciones.php");

$CmbAno    = $_REQUEST["CmbAno"];
$CmbMes    = $_REQUEST["CmbMes"];
$CmbDias   = $_REQUEST["CmbDias"];
$Peso      = $_REQUEST["Peso"];
$LeyOro    = $_REQUEST["LeyOro"];
$PesoOro   = $_REQUEST["PesoOro"];
$LeyPlata  = $_REQUEST["LeyPlata"];
$PesoPlata = $_REQUEST["PesoPlata"];

$Opcion    = $_REQUEST["Opcion"];

$NumBarra       = $_REQUEST["NumBarra"];
$Observacion    = $_REQUEST["Observacion"];
$TxtLoteVentana = $_REQUEST["TxtLoteVentana"];
$cmbrut 		= $_REQUEST["cmbrut"];


$CookieRut = $_COOKIE["CookieRut"]; 
$Rut =$CookieRut;
$Fecha = $CmbAno."-".$CmbMes."-".$CmbDias; 

$Correlativo    = $_REQUEST["Correlativo"];

if(isset($_REQUEST["ChkFecha"])){
	$ChkFecha       = $_REQUEST["ChkFecha"];
}else{
	$ChkFecha       = "";
}
if(isset($_REQUEST["ChkBarra"])){
	$ChkBarra       = $_REQUEST["ChkBarra"];
}else{
	$ChkBarra       = "";
}
if(isset($_REQUEST["ChkPeso"])){
	$ChkPeso       = $_REQUEST["ChkPeso"];
}else{
	$ChkPeso       = "";
}
if(isset($_REQUEST["ChkLeyOro"])){
	$ChkLeyOro       = $_REQUEST["ChkLeyOro"];
}else{
	$ChkLeyOro       = "";
}
if(isset($_REQUEST["ChkPesoOro"])){
	$ChkPesoOro       = $_REQUEST["ChkPesoOro"];
}else{
	$ChkPesoOro      = "";
}
if(isset($_REQUEST["ChkLeyPlata"])){
	$ChkLeyPlata       = $_REQUEST["ChkLeyPlata"];
}else{
	$ChkLeyPlata       = "";
}
if(isset($_REQUEST["ChkPesoPlata"])){
	$ChkPesoPlata       = $_REQUEST["ChkPesoPlata"];
}else{
	$ChkPesoPlata       = "";
}
if(isset($_REQUEST["ChkRut"])){
	$ChkRut       = $_REQUEST["ChkRut"];
}else{
	$ChkRut       = "";
}
if(isset($_REQUEST["ChkCorrelativo"])){
	$ChkCorrelativo       = $_REQUEST["ChkCorrelativo"];
}else{
	$ChkCorrelativo       = "";
}
if(isset($_REQUEST["ChkObservacion"])){
	$ChkObservacion       = $_REQUEST["ChkObservacion"];
}else{
	$ChkObservacion      = "";
}


if($Peso=='')
	$Peso=0;
if($LeyOro=='')
	$LeyOro=0;
if($PesoOro=='')
	$PesoOro=0;
if($LeyPlata=='')
	$LeyPlata=0;
if($PesoPlata=='')
	$PesoPlata=0;

switch ($Opcion)
{
	case "G":
		if($Correlativo=='')
		{
			$Consulta="select ifnull(max(correlativo)+1,1) as maximo from pmn_web.ingreso_oro_compra ";
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Resp))
			{
				$Correlativo=$Fila["maximo"];
			}				
		}
			
 		$Consulta = "select * from pmn_web.ingreso_oro_compra where fecha = '".$Fecha."' and correlativo = '".$Correlativo."' ";
		//echo $Consulta."<br>";
		$Respuesta=mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			$Consulta="select peso_barra from pmn_web.ingreso_oro_compra ";
			$Consulta.=" where fecha = '".$Fecha."' ";				
			$Consulta.= " and num_barra = '".$NumBarra."' ";														 
			$Consulta.= " and correlativo = '".$Correlativo."' ";
			//echo $Consulta."<br>";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Menor=$Fila["peso_barra"];
			$Mayor=$Peso;
			$Diferencia=$Mayor-$Menor;
			$Actualizar="UPDATE pmn_web.stock set peso=(peso +".$Diferencia.") ";
			$Actualizar.=" where cod_producto='34' and cod_subproducto='3' ";
			//echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);
			//Actualiza
			$Actualizar = "UPDATE pmn_web.ingreso_oro_compra set";
			$Actualizar.= " num_barra = '".str_replace(",",".",$NumBarra)."', ";
			$Actualizar.= " peso_barra = '".str_replace(",",".",$Peso)."', ";
			$Actualizar.= " ley_oro = '".str_replace(",",".",$LeyOro)."', ";
			$Actualizar.= " peso_oro = '".str_replace(",",".",$PesoOro)."', ";
			$Actualizar.= " ley_plata = '".str_replace(",",".",$LeyPlata)."', ";
			$Actualizar.= " peso_plata = '".str_replace(",",".",$PesoPlata)."', ";
			$Actualizar.= " rut_origen = '".$cmbrut."',";
			$Actualizar.= " observacion = '".$Observacion."', ";
			$Actualizar.= " lote_ventana = '".$TxtLoteVentana."' ";
			$Actualizar.= " where fecha = '".$Fecha."'";
			$Actualizar.= " and correlativo = '".$Correlativo."'";
		    //echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);
			
			//Movimientos_Pmn('','34','3','2',str_replace(",",".",$PesoOro),str_replace(",",".",$NumBarra),'','','1-2',$CookieRut,'M',$Correlativo,'0');
		}
		else 		
		{
			$Actualizar="UPDATE pmn_web.stock set peso=(peso +".str_replace(",",".",$Peso).") ";
			$Actualizar.=" where cod_producto='34' and cod_subproducto='3' ";
			//echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);
			$insertar="INSERT INTO ingreso_oro_compra(rut,fecha,num_barra,peso_barra ,";
			$insertar.=" ley_oro,peso_oro,ley_plata,peso_plata,observacion,rut_origen,lote_ventana) ";
			$insertar.=" values ('".$Rut."','".$Fecha."','".$NumBarra."','".str_replace(",",".",$Peso)."', ";
			$insertar.=" '".str_replace(",",".",$LeyOro)."','".str_replace(",",".",$PesoOro)."','".str_replace(",",".",$LeyPlata)."','".str_replace(",",".",$PesoPlata)."','".$Observacion."', '".$cmbrut."','".$TxtLoteVentana."')";
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);	
			//Movimientos_Pmn('','34','3','2',str_replace(",",".",$PesoOro),str_replace(",",".",$NumBarra),'','','1-2',$CookieRut,'I',$Correlativo,'0');			
		}	
		header("location:pmn_oro_compra.php?Mostrar=C&CmbAno=".$CmbAno."&CmbMes=".$CmbMes."&CmbDias=".$CmbDias."&Tab1=true&TabOC=true");
	break;
	case "M":
		if (count((array)$ChkFecha)>0)
		{
			reset($ChkFecha);
			//while (list($i,$p) = each($ChkFecha))
			foreach ($ChkFecha as $i => $p)
			{
				header("location:pmn_oro_compra.php?Mostrar=C&CmbDias=".$CmbDias."&CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&NumBarra=".$ChkBarra[$i]."&Peso=".$ChkPeso[$i]."&LeyOro=".$ChkLeyOro[$i]."&PesoOro=".$ChkPesoOro[$i]."&LeyPlata=".$ChkLeyPlata[$i]."&PesoPlata=".$ChkPesoPlata[$i]."&Observacion=".$ChkObservacion[$i]."&Correlativo=".$ChkCorrelativo[$i]."&cmbrut=".$ChkRut[$i]."&Tab1=true&TabOC=true");
			}
		}
		else
		{
				header("location:pmn_oro_compra.php?CmbDias=".$CmbDias."&CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&Tab1=true&TabOC=true");
		}
		break;
	break;
	case "E"://Borra el detalle
		if (count($ChkFecha)>0)
		{
			//while (list($i,$p) = each($ChkFecha))
			foreach ($ChkFecha as $i => $p)
			{
				$Consulta="select peso from pmn_web.stock ";
				$Consulta.=" where cod_producto='34' and cod_subproducto='3'	";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				if ($ChkPeso[$i] > $Fila["peso"])
				{
					$Mensaje="NE";
				}
				else
				{
					$Eliminar = "delete from  pmn_web.ingreso_oro_compra ";
					$Eliminar.=" where fecha = '".$Fecha."'";
					$Eliminar.= " and correlativo = '".$ChkCorrelativo[$i]."'";
					//echo $Eliminar."<nbr>";
					mysqli_query($link, $Eliminar);
					$Actualizar="UPDATE pmn_web.stock set peso=(peso -".$ChkPeso[$i].") ";
					$Actualizar.=" where cod_producto='34' and cod_subproducto='3' ";
					//echo $Actualizar."<br>";
					mysqli_query($link, $Actualizar);
					
					//Movimientos_Pmn('','34','3','2',str_replace(",",".",$PesoOro),str_replace(",",".",$NumBarra),'','','1-2',$CookieRut,'E',$ChkCorrelativo[$i],'0');
				}
			}
			header("location:pmn_oro_compra.php?Mostrar=C&CmbDias=".$CmbDias."&CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&Mensaje=".$Mensaje."&Tab1=true&TabOC=true");
		}
		else
		{
			header("location:pmn_oro_compra.php?CmbDias=".$CmbDias."&CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&Tab1=true&TabOC=true");
		}
		break;
	case "C":
		header("location:pmn_oro_compra.php?&Tab1=true&TabOC=true");
	break;
}
?>
