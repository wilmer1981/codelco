
<?php
    include("conectar47.php");
	$ano    = isset($_REQUEST["ano"])?$_REQUEST["ano"]:"";
	$mes    = isset($_REQUEST["mes"])?$_REQUEST["mes"]:"";
	$dia    = isset($_REQUEST["dia"])?$_REQUEST["dia"]:"";	

	$Fecha =$ano."-".$mes."-".$dia;
	$Fecha_b =$ano."-".$mes."-".$dia;
	$Fecha_ant = date ("Y-m-d", mktime (0,0,0,$mes,$dia +1,$ano));
	$Cod_Tipo5="5";
    $sql = "SELECT * FROM sam_bdweb_proyecto.informe_del_turno WHERE Fecha LIKE '%$Fecha_b%' and (turno = 'A' or turno = 'B')";
    $result = mysqli_query($link, $sql);
	$Observacion_A = "";$Turno_A       = "";$Rut_A         = "";
	$Observacion_B = "";$Turno_B       = "";$Rut_B         = "";
	$Observacion_C = "";$Turno_C       = "";$Rut_C         = "";
	$Observacion_V = "";$Turno_V       = "";$Rut_V         = "";
    while($row = mysqli_fetch_array($result))
    {
       $Rut = $row["RESPONSABLE"];
   	   $Turno = $row["TURNO"];
	   $ObsGeneral = $row["OBSERVACION"];

	   if ($Turno == "A")
	   {
       $Observacion_A = $ObsGeneral;    
	   $Turno_A = $Turno;
	   $Rut_A = $Rut;
	   }
	   
	   if ($Turno == "B")
	   {
       $Observacion_B = $ObsGeneral;    
	   $Turno_B = $Turno;
	   $Rut_B = $Rut;
       } 
	   if ($Turno == "V")
	   {
       $Observacion_V = $ObsGeneral;    
   	   $Turno_V = $Turno;
	   $Rut_V = $Rut;

	   } 
	   
	}


   $sql = "SELECT * FROM sam_bdweb_proyecto.informe_del_turno WHERE Fecha LIKE '%$Fecha_ant%' and turno = 'c' ";
   $result = mysqli_query($link,$sql);
   while($row = mysqli_fetch_array($result))
   {
       $Rut = $row["RESPONSABLE"];
   	   $Turno = $row["TURNO"];
	   $ObsGeneral = $row["OBSERVACION"];

	   if ($Turno == "C")
	   {
       $Observacion_C = $ObsGeneral;
	   $Turno_C = $Turno;
	   $Rut_C = $Rut;

       }

	}

    include("cerrar.php"); 
?>
