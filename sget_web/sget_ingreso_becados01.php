<? 
	include("../principal/conectar_sget_web.php");
	switch($Selec)
	{
		case "G":
			$RutBec=$TxtRutPrv."-".$TxtDv;
			$Consulta="Select * from sget_becados where rut='".$Rut."' and rut_becado='".$RutBec."'";
			$RespMod=mysqli_query($link, $Consulta);
			if($FilaMod=mysql_fetch_array($RespMod))
			{
				$Update="UPDATE sget_becados set nombres= '".strtoupper($TxtNombres)."',ape_paterno='".strtoupper($TxtApePaterno)."',ape_materno='".strtoupper($TxtApeMaterno)."',edad='".$TxtEdad."'";
				$Update.=" where rut='".$Rut."' and rut_becado='".$RutBec."'";
				mysql_query($Update);
			}
			else
			{
			  	$Insertar="INSERT INTO sget_becados(rut,rut_becado,nombres,ape_paterno,ape_materno,edad)";
				$Insertar.="values('".$Rut."','".$TxtRutPrv."-".$TxtDv."','".strtoupper($TxtNombres)."','".strtoupper($TxtApePaterno)."','".strtoupper($TxtApeMaterno)."','".$TxtEdad."')";
				mysql_query($Insertar);
			}
		break;
		case "E":
			$Eliminar="delete from sget_becados where rut='".$Rut."' and rut_becado='".$RutBec."'";
			mysql_query($Eliminar);
		break;
	}
	header('location:sget_ingreso_becados.php?Rut='.$Rut);	
?>
