<?php include("../principal/conectar_ref_web.php");

$CookieRut   = $_COOKIE["CookieRut"];
$Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$cmbtema     = isset($_REQUEST["cmbtema"])?$_REQUEST["cmbtema"]:"";
$fecha       = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";

$tema                    = isset($_REQUEST["tema"])?$_REQUEST["tema"]:"";
$cod_tipo_procedimiento  = isset($_REQUEST["cod_tipo_procedimiento"])?$_REQUEST["cod_tipo_procedimiento"]:"";
$cod_procedimiento       = isset($_REQUEST["cod_procedimiento"])?$_REQUEST["cod_procedimiento"]:"";
$procedimiento           = isset($_REQUEST["procedimiento"])?$_REQUEST["procedimiento"]:"";
$desde   = isset($_REQUEST["desde"])?$_REQUEST["desde"]:"";
$hasta   = isset($_REQUEST["hasta"])?$_REQUEST["hasta"]:"";

    $consulta="select * from proyecto_modernizacion.funcionarios where rut='".$CookieRut."'  ";
	$rss = mysqli_query($link, $consulta);
	$rows = mysqli_fetch_array($rss);
    $nombre=$rows["nombres"]." ".$rows["apellido_paterno"]." ".$rows["apellido_materno"];

	if ($Proceso == "G")
	{
		$Insertar = "INSERT INTO ref_web.procedimientos (COD_TIPO_PROCEDIMIENTO,PROCEDIMIENTO, DESDE, HASTA, VIGENCIA, FECHA,usuario)";
		$Insertar.= " VALUES ('".$tema."','".$procedimiento."', '".$desde."', '".$hasta."', '1', '".$fecha."','".$nombre."')";
		echo $Insertar;
        mysqli_query($link, $Insertar);
		header ("location:ing_procedimientos.php?fecha=$fecha");
	}
	if ($Proceso == "E")
	{
		$Eliminar = "DELETE FROM ref_web.procedimientos WHERE COD_PROCEDIMIENTO = '".$cod_procedimiento."' and FECHA='".$fecha."'";
		//echo $Eliminar;
		mysqli_query($link, $Eliminar);
		header ("location:procedimientos.php?fecha=$fecha&cmbtema=$cmbtema");
	}
	if ($Proceso == "M")
	{
		$actualizar = "UPDATE ref_web.procedimientos SET COD_TIPO_PROCEDIMIENTO = '".$tema."',PROCEDIMIENTO = '".$procedimiento."', ";
		$actualizar.="DESDE ='".$desde."',HASTA = '".$hasta."',usuario = '".$nombre."' WHERE FECHA = '".$fecha."' AND COD_TIPO_PROCEDIMIENTO = '".$tema."' and COD_PROCEDIMIENTO='".$cod_procedimiento."' ";
	    //echo  $actualizar;
		mysqli_query($link, $actualizar);
		
		header ("location:procedimientos.php?fecha=$fecha&cmbtema=$tema");
	}	   
?> 
