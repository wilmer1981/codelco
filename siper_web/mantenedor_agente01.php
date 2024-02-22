<? include('conectar_ori.php');
	$Encontro=false;
	
	
	switch($Proceso)
	{
		case "N":
			$TxtQLPP=str_replace('.','',$TxtQLPP);
			$TxtQLPP=str_replace(',','.',$TxtQLPP);
			if($TxtQLPP=='')
			$TxtQLPP=0;
			$Consulta = "SELECT ifnull(max(CAGENTE),0) as mayor from sgrs_cagentes"; 
			$Respuesta=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Respuesta);
			$Mayor=$Fila["mayor"] + 1;			
			$Inserta="INSERT INTO sgrs_cagentes (CAGENTE,NAGENTE,CUNIDAD,QLPP,MVIGENTE)";
			$Inserta.=" values('".$Mayor."','".$TxtNombre."','".$CmbUnidad."','".$TxtQLPP."','".$Vigente."')";
			mysql_query($Inserta);
			header("location:mantenedor_agente.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "M":
			$TxtQLPP=str_replace('.','',$TxtQLPP);
			$TxtQLPP=str_replace(',','.',$TxtQLPP);
			if($TxtQLPP=='')
			$TxtQLPP=0;
			$Actualizar="UPDATE sgrs_cagentes set NAGENTE='".$TxtNombre."',CUNIDAD='".$CmbUnidad."',QLPP='".$TxtQLPP."',MVIGENTE='".$Vigente."' where CAGENTE='".$Datos."' ";
			mysql_query($Actualizar);
			header("location:mantenedor_agente.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "E":
			$Mensaje='';
			$Datos = explode("//",$DatosUni);
			foreach($Datos as $clave => $Codigo)
			{
				$DatosRel='N';
				$Consulta="SELECT * from sgrs_medpersonales where CAGENTE='".$Codigo."'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$DatosRel='S';
				$Consulta="SELECT * from sgrs_medambientes where CAGENTE='".$Codigo."'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$DatosRel='S';
				if($DatosRel=='N')
				{
					$Eliminar="delete from sgrs_cagentes where CAGENTE='".$Codigo."'";
					mysql_query($Eliminar);
				}
				else
					$Mensaje='No se puede Eliminar Agente, Existen Mediciones asociadas';	
			}
			header("location:mantenedor_agente.php?Buscar=S&Mensaje=".$Mensaje);
		break;
	
	}
?>
