<?php 	

	//$link = mysql_connect("localhost","adm_bd","672312");
	//mysql_select_db("informe_diario", $link);
	include("../principal/conectar_principal.php");

	$Proceso      = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$TxtRut       = isset($_REQUEST["TxtRut"])?$_REQUEST["TxtRut"]:"";
	$TxtNombres   = isset($_REQUEST["TxtNombres"])?$_REQUEST["TxtNombres"]:"";
	$TxtPassword  = isset($_REQUEST["TxtPassword"])?$_REQUEST["TxtPassword"]:"";
	$CmbGrupo     = isset($_REQUEST["CmbGrupo"])?$_REQUEST["CmbGrupo"]:"";
	$TxtDescripcion     = isset($_REQUEST["TxtDescripcion"])?$_REQUEST["TxtDescripcion"]:"";


  $Consulta="SELECT * from informe_diario.usuarios where Grupo = '".$CmbGrupo."' and DESCRIPCION_GRUPO !=''";
  //echo $Consulta;
  $Resp=mysqli_query($link, $Consulta);
  if ($Row=mysqli_fetch_array($Resp))
  {
  		$TxtDescripcion = $Row["DESCRIPCION_GRUPO"];
  }
 switch ($Proceso)
 {
		case "G":
			$Consulta = "SELECT * from informe_diario.usuarios where RUT = '".$TxtRut."'";
			$Resp=mysqli_query($link, $Consulta);
			if ($Row=mysqli_fetch_array($Resp))
			{
					$actualizo="UPDATE informe_diario.usuarios set PASSWORD = '".strtoupper(trim($TxtPassword))."',";
					$actualizo.="NOMBRE_APELLIDO = '".$TxtNombres."', Grupo = '".$CmbGrupo."', DESCRIPCION_GRUPO = '".$TxtDescripcion."' where rut = '".$TxtRut."'";
					//echo $actualizo;
					mysqli_query($link, $actualizo);
			}
			else
			{
				$inserto="INSERT INTO informe_diario.usuarios (RUT,NOMBRE_APELLIDO,PASSWORD,Grupo,DESCRIPCION_GRUPO) values (";
				$inserto.="'".$TxtRut."', '".$TxtNombres."', '".strtoupper(trim($TxtPassword))."', '".$CmbGrupo."',  '".$TxtDescripcion."')";
				//echo $inserto;
				mysqli_query($link, $inserto); 
			}
			break;
		case "E":
			$elimino="DELETE from informe_diario.usuarios where rut = '".$TxtRut."'";
			mysqli_query($link, $elimino);
			break;
}
		header("location:ingreso_funcionarios_infDiario.php?Proceso=A");
	
?>
