<?php
	include("../principal/conectar_principal.php");
	if ($proceso=='T')
	    { 
		  if ($cmbleyes<>'')
		    {
			   $consulta_nom = "SELECT * FROM proyecto_modernizacion.leyes where Refineria='R' and cod_leyes='".$cmbleyes."'";
			   //echo  $consulta_nom;
			   $rs_nom = mysqli_query($link, $consulta_nom);
			   $row_nom = mysqli_fetch_array($rs_nom);
			   $insertar="insert into ref_web.leyes(cod_leyes,abreviatura) ";
			   $insertar = $insertar."values ('".$cmbleyes."','".$row_nom["abreviatura"]."')";
			   mysqli_query($link, $insertar);
			   header("Location:ref_informe_impuresas.php?&TextoSelec=$TextoSelec&DiaIni=$DiaIni&MesIni=$MesIni&AnoIni=$AnoIni&AnoFin=$AnoFin&MesFin=$MesFin&DiaFin=$DiaFin&cmbcircuito=$cmbcircuito&Contador=$Contador&limpiar=N");
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