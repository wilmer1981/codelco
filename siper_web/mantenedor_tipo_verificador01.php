<?php include('conectar_ori.php');
include('funciones/siper_funciones.php');
	$Encontro=false;
	
	
	switch($Proceso)
	{
		case "N":
			$Consulta = "select ifnull(max(COD_VERIFICADOR),0) as mayor from sgrs_tipo_verificador"; 
			$Respuesta=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Mayor=$Fila[mayor] + 1;			
			$Inserta="insert into sgrs_tipo_verificador (COD_VERIFICADOR,DESCRIP_VERIFICADOR,ACTIVO,OBS)";
			$Inserta.=" values('".$Mayor."','".$TxtNombre."','".$Vigente."','".$ObsVeri."')";
			mysqli_query($link,$Inserta);

			$Obs='Se a Ingresado Verificador '.trim($TxtNombre).' y Activo '.$Vigente.'';	
			InsertaHistorico($CookieRut,'14',$Obs,'','','');//INGRESA VERIFICADOR

			header("location:mantenedor_tipo_verificador.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "M":
			$Consulta="select * from sgrs_tipo_verificador where COD_VERIFICADOR='".$Datos."'";
			$Respuesta=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$NONVERI=$Fila[DESCRIP_VERIFICADOR];
			$VIG=$Fila[ACTIVO];
			$Actualizar="update sgrs_tipo_verificador set DESCRIP_VERIFICADOR='".$TxtNombre."',ACTIVO='".$Vigente."',OBS='".$ObsVeri."' where COD_VERIFICADOR='".$Datos."' ";
			mysqli_query($link,$Actualizar);			

			$Obs='Se a Modificado Verificador '.trim($NONVERI).'y Activo '.$VIG.'';	
			$Obs2='Por Verificador '.$TxtNombre.' y Activo '.$Vigente.'';	
			InsertaHistorico($CookieRut,'15',$Obs,$Obs2,'','');//IMODIFICA VERIFICADOR

			header("location:mantenedor_tipo_verificador.php?Buscar=S&Mensaje=".$Mensaje);
		break;
		case "E":
			$Mensaje='';
			$Datos = explode("//",$DatosUni);
			while (list($clave,$Codigo)=each($Datos))
			{
				$DatosRel='N';
				$Consulta="select * from sgrs_sipercontroles where VERIFICADOR_OPER='".$Codigo."'";
				$Resp=mysqli_query($link,$Consulta);
				if($Fila=mysqli_fetch_array($Resp))
					$DatosRel='S';
				if($DatosRel=='N')
				{
					$Consulta="select * from sgrs_tipo_verificador where COD_VERIFICADOR='".$Codigo."'";
					$Respuesta=mysqli_query($link,$Consulta);
					while($Fila=mysqli_fetch_array($Respuesta))
					{
						$NONVERI=$NONVERI.$Fila[DESCRIP_VERIFICADOR].", ";
					}	
					
					$Eliminar="delete from sgrs_tipo_verificador where COD_VERIFICADOR='".$Codigo."'";
					mysqli_query($link,$Eliminar);
				}
				else
					$Mensaje='No se puede Eliminar Verificador, Existen Controles asociados';	
			}
			$NONVERI=substr($NONVERI,0,strlen($NONVERI)-2);	
			$Obs='Se a(han) Eliminado el(los) Verificador(es) '.trim($NONVERI).'';	
			InsertaHistorico($CookieRut,'16',$Obs,'','',$ObsEli);//IMODIFICA VERIFICADOR
			header("location:mantenedor_tipo_verificador.php?Buscar=S&Mensaje=".$Mensaje);
		break;
	
	}
?>
