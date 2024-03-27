<? 	
  include("conectar_infDiario_web.php");

  $Consulta="Select * from informe_diario.usuarios where Grupo = '".$CmbGrupo."' and DESCRIPCION_GRUPO !=''";
  $Resp=mysqli_query($link, $Consulta);
  if ($Row=mysql_fetch_array($Resp))
  {
  		$TxtDescripcion = $Row[DESCRIPCION_GRUPO];
  }
 switch ($Proceso)
 {
		case "G":
			$Consulta = "Select * from informe_diario.usuarios where RUT = '".$TxtRut."'";
			$Resp=mysqli_query($link, $Consulta);
			if ($Row=mysql_fetch_array($Resp))
			{
					$actualizo="Update informe_diario.usuarios set PASSWORD = md5('".strtoupper(trim($TxtPassword))."'),";
					$actualizo.="Grupo = '".$CmbGrupo."', DESCRIPCION_GRUPO = '".$TxtDescripcion."' where rut = '".$TxtRut."'";
					//echo $actualizo;
					mysql_query($actualizo);
			}
			else
			{
				$inserto="insert into informe_diario.usuarios (RUT,NOMBRE_APELLIDO,PASSWORD,Grupo,DESCRIPCION_GRUPO) values (";
				$inserto.="'".$TxtRut."', '".$TxtNombres."', md5('".strtoupper(trim($TxtPassword))."'), '".$CmbGrupo."',  '".$TxtDescripcion."')";
				//echo $inserto;
				mysql_query($inserto); 
			}
			break;
		case "E":
			$elimino="delete from informe_diario.usuarios where rut = '".$TxtRut."'";
			mysql_query($elimino);
			break;
}
		header("location:ingreso_funcionarios_infDiario.php?Proceso=A");
	
?>
