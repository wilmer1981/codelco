<?
	include("../principal/conectar_principal.php");
	switch ($Proceso)
	{
		case "G":
			$Consulta = "SELECT * FROM ins_equipo.`equipo` where cod_equipo='".$TxtCodEquipo."'";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);
			if ($Fila =mysql_fetch_array($Resp))
			{
				$Codigo=$TxtCodEquipo;
				if ($CmbUser!="S")
					$Usuario=$CmbUser;
				elseif ($TxtUser!="")
						$Usuario=$TxtUser;
				if ($CmbCC=="S")
					$CC="";
				else
					$CC=$CmbCC;
				$Actualizar = "UPDATE ins_equipo.`equipo` SET";
				$Actualizar.= " `usuario`='".strtoupper($Usuario)."', `centro_costo`='".$CC."', ";
				$Actualizar.= " `fecha_instalacion`='".$TxtFechaIni."', `realizador`='".$TxtRealizador."', `ip`='".$TxtIP."', ";
				$Actualizar.= " `nom_pc`='".strtoupper($TxtNomPC)."', `nom_user`='".strtoupper($TxtNomUser)."', `correo`='".strtoupper($TxtCorreo)."', ";
				$Actualizar.= " `pass_bios_adm`='".$TxtBiosAdm."', `pass_bios_user`='".$TxtBiosUser."', `pass_red_user`='".$TxtRedUser."', ";
				$Actualizar.= " `observacion`='".$TxtObservacion."', `fecha_retiro`='".$TxtFechaFin."', `internet`='".$ChkInternet."', ";
				$Actualizar.= " `cpu`='".$TxtCpu."', `ram`='".$TxtRam."', `hdd`='".$TxtHdd."', validado='".$ChkValida."'  ";
				$Actualizar.= " where cod_equipo='".$TxtCodEquipo."'";
				mysql_query($Actualizar);
			}
			else
			{
				if ($CmbUser!="S")
					$Usuario=$CmbUser;
				elseif ($TxtUser!="")
						$Usuario=$TxtUser;
				if ($CmbCC=="S")
					$CC="";
				else
					$CC=$CmbCC;
				//SELECCIONA NUEVO CODIGO
				$Consulta = "SELECT max(lpad(cod_equipo,3,'0')) as mayor FROM ins_equipo.equipo" ;
				$Resp=mysqli_query($link, $Consulta);
				if ($Fila =mysql_fetch_array($Resp))
					$Codigo=1 + $Fila["mayor"];
				else
					$Codigo=1;
				$Insertar = "INSERT INTO ins_equipo.`equipo` (`cod_equipo`, `usuario`, `centro_costo`, ";
				$Insertar.= " `fecha_instalacion`, `realizador`, `ip`, `nom_pc`, `nom_user`, `correo`, ";
				$Insertar.= " `pass_bios_adm`, `pass_bios_user`, `pass_red_user`, `cod_ex_equipo`, ";
				$Insertar.= " `observacion`, `fecha_retiro`, `internet`, `cpu`, `ram`, `hdd`, `validado`) ";
				$Insertar.= " VALUES ('".$Codigo."', '".strtoupper($Usuario)."', '".$CC."', '".$TxtFechaIni."', '".$TxtRealizador."', ";
				$Insertar.= " '".$TxtIP."', '".strtoupper($TxtNomPC)."', '".strtoupper($TxtNomUser)."', '".strtoupper($TxtCorreo)."', '".$TxtBiosAdm."', ";
				$Insertar.= " '".$TxtBiosUser."', '".$TxtRedUser."', '', '".$TxtObservacion."', '".$TxtFechaFin."', '".$ChkInternet."', '".$TxtCpu."', '".$TxtRam."', '".$TxtHdd."', '".$ChkValida."');";
				//echo $Insertar."<br>";
				mysql_query($Insertar);
			}						
			header("location:cia_inst_equipos.php?TxtCodEquipo=".$Codigo."&CmbUser=".$CmbUser."&TxtUser=".$TxtUser);
			break;
		case "AD": //AGERGA DETALLE
			$Insertar = "INSERT INTO ins_equipo.detalle_equipo (cod_equipo, cod_clase, cod_subclase) ";
			$Insertar.= " values('".$CodEquipo."','".$CmbClase."','".$CmbModelo."')";
			mysql_query($Insertar);
			header("location:cia_inst_equipos_agrega_det.php?CodEquipo=".$CodEquipo."&CmbClase=".$CmbClase."&CmbSubClase=".$CmbSubClase);
			break;
		case "GD":
			$Datos=explode('//',$Valores);
			while(list($c,$v)=each($Datos))
			{
				$Datos2=explode('~',$v);
				$CodEquipo=$Datos2[0];
				$CodClase=$Datos2[1];
				$CodSubClase=$Datos2[2];
				$CodSerie=$Datos2[3];
				$CodUno=$Datos2[4];
				$Actualizar="UPDATE ins_equipo.detalle_equipo set campo1='".$CodSerie."',campo2='".$CodUno."' ";
				$Actualizar.="where cod_equipo='".$CodEquipo."' and cod_clase='".$CodClase."' and cod_subclase='".$CodSubClase."'";
				//echo $Actualizar."<br>";
				mysql_query($Actualizar);
			}
			header("location:cia_inst_equipos.php?TxtCodEquipo=".$TxtCodEquipo."&CmbUser=".$CmbUser."&TxtUser=".$TxtUser);			
			break;	
		case "E":
			$Datos=explode('~',$Valores);
			$Eliminar="delete from ins_equipo.detalle_equipo where cod_equipo='".$Datos[0]."' and cod_clase='".$Datos[1]."' and cod_subclase='".$Datos[2]."'";
			//echo $Eliminar;
			mysql_query($Eliminar);
			header("location:cia_inst_equipos.php?TxtCodEquipo=".$TxtCodEquipo."&CmbUser=".$CmbUser."&TxtUser=".$TxtUser);			
			break;	
	}
?>