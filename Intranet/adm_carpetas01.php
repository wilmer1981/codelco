<?
include("conectar.php");
	switch ($Proceso)
	{
		case "G":
			$Eliminar = "delete from intranet.directorios where rut_funcionario='".$RutFun."'";
			mysql_query($Eliminar);
			if ($ChkTodas=="S")
			{
				$Insertar="insert into intranet.directorios (rut_funcionario,directorio) ";
				$Insertar.= " values('".$RutFun."','*')";
				mysql_query($Insertar);
			}
			else
			{
				$Datos = explode("~~",$Directorios);			
				while (list($k,$v)=each($Datos))
				{
					if ($v!="")
					{
						$Insertar="insert into intranet.directorios (rut_funcionario,directorio) ";
						$Insertar.= " values('".$RutFun."','".$v."')";
						mysql_query($Insertar);
					}
				}
			}
			break;
	}
	header("location:adm_carpetas.php?RutFun=".$RutFun);
?>	