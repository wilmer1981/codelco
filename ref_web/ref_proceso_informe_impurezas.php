<?php
	include("../principal/conectar_principal.php");
	$proceso     = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$cmbleyes    = isset($_REQUEST["cmbleyes"])?$_REQUEST["cmbleyes"]:"";

	$DiaIni    = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d");
	$MesIni    = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");
	$AnoIni    = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");
	$DiaFin    = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d");
	$MesFin    = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m");
	$AnoFin    = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y");
	$cmbcircuito  = isset($_REQUEST["cmbcircuito"])?$_REQUEST["cmbcircuito"]:"";
	$Contador     = isset($_REQUEST["Contador"])?$_REQUEST["Contador"]:"";

	if ($proceso=='T')
	    { 
		  if ($cmbleyes<>'')
		    {
			   $consulta_nom = "SELECT * FROM proyecto_modernizacion.leyes where Refineria='R' and cod_leyes='".$cmbleyes."'";
			   //echo  $consulta_nom;
			    $rs_nom = mysqli_query($link, $consulta_nom);			 
			    $row_nom = mysqli_fetch_array($rs_nom);
			     //var_dump($row_nom);
				$consultas = "SELECT count(*) as Total FROM ref_web.leyes where cod_leyes='".$cmbleyes."'";
				$result    = mysqli_query($link, $consultas);
				$Fila   = mysqli_fetch_array($result);				
			    if ($Fila["Total"] < 1)
			    {
				   $insertar="insert into ref_web.leyes(cod_leyes,abreviatura) ";
				   $insertar = $insertar."values ('".$cmbleyes."','".$row_nom["abreviatura"]."')";
				   mysqli_query($link, $insertar);
				}
			   header("Location:ref_informe_impuresas.php?cmbleyes=$cmbleyes&DiaIni=$DiaIni&MesIni=$MesIni&AnoIni=$AnoIni&AnoFin=$AnoFin&MesFin=$MesFin&DiaFin=$DiaFin&cmbcircuito=$cmbcircuito&Contador=$Contador&limpiar=N");
			}
		}
	if ($proceso=='Q')
	   {
	     $eliminar="delete from ref_web.leyes where cod_leyes='".$cmbleyes."'";
		 //echo $eliminar;
	     mysqli_query($link, $eliminar);
	    header("Location:ref_informe_impuresas.php?DiaIni=$DiaIni&MesIni=$MesIni&AnoIni=$AnoIni&AnoFin=$AnoFin&MesFin=$MesFin&DiaFin=$DiaFin&cmbcircuito=$cmbcircuito&Contador=$Contador&limpiar=N");
	   
	   }		
?>