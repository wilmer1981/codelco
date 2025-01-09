<?php include('conectar_ori.php');
	$Encontro=false;
	
	
	switch($Proceso)
	{
		case "N":
			$TxtQLPP=str_replace('.','',$TxtQLPP);
			$TxtQLPP=str_replace(',','.',$TxtQLPP);
			if($TxtQLPP=='')
			$TxtQLPP=0;
			$Consulta = "select ifnull(max(CAGENTE),0) as mayor from sgrs_cagentes"; 
			$Respuesta=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Mayor=$Fila[mayor] + 1;			
			$Inserta="insert into sgrs_cagentes (CAGENTE,NAGENTE,CUNIDAD,QLPP,MVIGENTE)";
			$Inserta.=" values('".$Mayor."','".$TxtNombre."','".$CmbUnidad."','".$TxtQLPP."','".$Vigente."')";
			mysqli_query($link,$Inserta);
			header("location:mantenedor_agente.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "M":
			$TxtQLPP=str_replace('.','',$TxtQLPP);
			$TxtQLPP=str_replace(',','.',$TxtQLPP);
			if($TxtQLPP=='')
			$TxtQLPP=0;
			$Actualizar="update sgrs_cagentes set NAGENTE='".$TxtNombre."',CUNIDAD='".$CmbUnidad."',QLPP='".$TxtQLPP."',MVIGENTE='".$Vigente."' where CAGENTE='".$Datos."' ";
			mysqli_query($link,$Actualizar);
			header("location:mantenedor_agente.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "E":
			$Mensaje='';
			$Datos = explode("//",$DatosUni);
			while (list($clave,$Codigo)=each($Datos))
			{
				$DatosRel='N';
				$Consulta="select * from sgrs_medpersonales where CAGENTE='".$Codigo."'";
				$Resp=mysqli_query($link,$Consulta);
				if($Fila=mysqli_fetch_array($Resp))
					$DatosRel='S';
				$Consulta="select * from sgrs_medambientes where CAGENTE='".$Codigo."'";
				$Resp=mysqli_query($link,$Consulta);
				if($Fila=mysqli_fetch_array($Resp))
					$DatosRel='S';
				if($DatosRel=='N')
				{
					$Eliminar="delete from sgrs_cagentes where CAGENTE='".$Codigo."'";
					mysqli_query($link,$Eliminar);
				}
				else
					$Mensaje='No se puede Eliminar Agente, Existen Mediciones asociadas';	
			}
			header("location:mantenedor_agente.php?Buscar=S&Mensaje=".$Mensaje);
		break;
	
	}
?>
