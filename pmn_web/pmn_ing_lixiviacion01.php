<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	//echo "fechita".$Fechita."<br>";

	$CookieRut = $_COOKIE["CookieRut"]; 
	
	if(isset($_REQUEST["Proceso"])){
		$Proceso=$_REQUEST["Proceso"];
	}else{
		$Proceso="";
	}
	if(isset($_REQUEST["Lixiv"])){
		$Lixiv=$_REQUEST["Lixiv"];
	}else{
		$Lixiv="";
	}
	if(isset($_REQUEST["Turnito"])){
		$Turnito=$_REQUEST["Turnito"];
	}else{
		$Turnito="";
	}
	if(isset($_REQUEST["Fecha"])){
		$Fecha=$_REQUEST["Fecha"];
	}else{
		$Fecha="";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano=$_REQUEST["Ano"];
	}else{
		$Ano="";
	}
	if(isset($_REQUEST["Mes"])){
		$Mes=$_REQUEST["Mes"];
	}else{
		$Mes="";
	}
	if(isset($_REQUEST["Dia"])){
		$Dia=$_REQUEST["Dia"];
	}else{
		$Dia="";
	}
	if(isset($_REQUEST["AnoF"])){
		$AnoF=$_REQUEST["AnoF"];
	}else{
		$AnoF="";
	}
	if(isset($_REQUEST["MesF"])){
		$MesF=$_REQUEST["MesF"];
	}else{
		$MesF="";
	}
	if(isset($_REQUEST["DiaF"])){
		$DiaF=$_REQUEST["DiaF"];
	}else{
		$DiaF="";
	}
	
	if(isset($_REQUEST["FechaCarga"])){
		$FechaCarga =$_REQUEST["FechaCarga"];
	}else{
		$FechaCarga ="";
	}

if(isset($_REQUEST["Turno"])){
	$Turno =$_REQUEST["Turno"];
}else{
	$Turno ="";
}
if(isset($_REQUEST["TxtNumLixiv"])){
	$TxtNumLixiv		=$_REQUEST["TxtNumLixiv"];
}else{
	$TxtNumLixiv        ="";
}
if(isset($_REQUEST["Operador"])){
	$Operador			=$_REQUEST["Operador"];
}else{
	$Operador			="";
}
if(isset($_REQUEST["JefeTurno"])){
	$JefeTurno			=$_REQUEST["JefeTurno"];
}else{
	$JefeTurno			="";
}
if(isset($_REQUEST["OperadorAnalisis"])){
	$OperadorAnalisis	=$_REQUEST["OperadorAnalisis"];
}else{
	$OperadorAnalisis	="";
}
if(isset($_REQUEST["JefeTurnoAnalisis"])){
	$JefeTurnoAnalisis	=$_REQUEST["JefeTurnoAnalisis"];
}else{
	$JefeTurnoAnalisis	="";
}
if(isset($_REQUEST["AnoLixiv"])){
	$AnoLixiv			=$_REQUEST["AnoLixiv"];
}else{
	$AnoLixiv			="";
}
if(isset($_REQUEST["MesLixiv"])){
	$MesLixiv			=$_REQUEST["MesLixiv"];
}else{
	$MesLixiv			="";
}
if(isset($_REQUEST["DiaLixiv"])){
	$DiaLixiv			=$_REQUEST["DiaLixiv"];
}else{
	$DiaLixiv			="";
}
if(isset($_REQUEST["HoraLixiv"])){
	$HoraLixiv	=$_REQUEST["HoraLixiv"];
}else{
	$HoraLixiv	="";
}
if(isset($_REQUEST["MinutosLixiv"])){
	$MinutosLixiv		=$_REQUEST["MinutosLixiv"];
}else{
	$MinutosLixiv		="";
}
if(isset($_REQUEST["AnoFiltracion"])){
	$AnoFiltracion		=$_REQUEST["AnoFiltracion"];
}else{
	$AnoFiltracion		="";
}
if(isset($_REQUEST["MesFiltracion"])){
	$MesFiltracion		=$_REQUEST["MesFiltracion"];
}else{
	$MesFiltracion		="";
}
if(isset($_REQUEST["DiaFiltracion"])){
	$DiaFiltracion		=$_REQUEST["DiaFiltracion"];
}else{
	$DiaFiltracion		="";
}
if(isset($_REQUEST["HoraFiltra"])){
	$HoraFiltra			=$_REQUEST["HoraFiltra"];
}else{
	$HoraFiltra			="";
}
if(isset($_REQUEST["MinutosFiltra"])){
	$MinutosFiltra		=$_REQUEST["MinutosFiltra"];
}else{
	$MinutosFiltra		="";
}
if(isset($_REQUEST["TxtAcidc"])){
	$TxtAcidc			=$_REQUEST["TxtAcidc"];
}else{
	$TxtAcidc			="";
}
if(isset($_REQUEST["TxtPorcCu"])){
	$TxtPorcCu			=$_REQUEST["TxtPorcCu"];
}else{
	$TxtPorcCu			="";
}
if(isset($_REQUEST["TxtBAD"])){
	$TxtBAD				=$_REQUEST["TxtBAD"];
}else{
	$TxtBAD				="";
}
if(isset($_REQUEST["TxtNumLixiv"])){
	$TxtNumLixiv		=$_REQUEST["TxtNumLixiv"];
}else{
	$TxtNumLixiv		="";
}
if(isset($_REQUEST["TxtLixiv"])){
	$TxtLixiv			=$_REQUEST["TxtLixiv"];
}else{
	$TxtLixiv			="";
}
if(isset($_REQUEST["Observacion"])){
	$Observacion		=$_REQUEST["Observacion"];
}else{
	$Observacion		="";
}
if(isset($_REQUEST["Modif"])){
	$Modif			=$_REQUEST["Modif"];
}else{
	$Modif			="";
}
if(isset($_REQUEST["FechaModif"])){
	$FechaModif		=$_REQUEST["FechaModif"];
}else{
	$FechaModif		="";
}
if(isset($_REQUEST["NumLix"])){
	$NumLix		=$_REQUEST["NumLix"];
}else{
	$NumLix		="";
}
if(isset($_REQUEST["Porc"])){
	$Porc		=$_REQUEST["Porc"];
}else{
	$Porc		="";
}
		

	

	switch ($Proceso)
	{
		case "G":
			$Fecha = $Ano."-".$Mes."-".$Dia;
			$Hora = date("H:i:s");
			$FechaHora = $Fecha." ".$Hora;
			//-----------CONSULTA SI EL TURNO YA FUE INGRESADO-------
			$Consulta = "select * from pmn_web.lixiviacion_barro_anodico ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and turno = '".$Turno."'";
			$result = mysqli_query($link, $Consulta);
			if ($row = mysqli_fetch_array($result))
			{
				echo "<script language='JavaScript'>\n";
				echo "alert('YA FUE INGRESADO ESTE TURNO');";
				echo "window.history.back();";
				echo "</script>\n";					
			}
			else
			{
				//--------INSERTA DATOS EN TRABLA LIXIVIACION BARRO ANODICO---------------
				$H_Carga = $HoraLixiv.":".$MinutosLixiv.":00";
				$FechaAnalisis = "0000-00-00";
				$FechaCarga= $AnoLixiv."-".$MesLixiv."-".$DiaLixiv;
				$H_Analisis = "00:00:00";
				$FechaFiltracion = $AnoFiltracion."-".$MesFiltracion."-".$DiaFiltracion;
				if ($Operador == "S")
					$Operador = "";
				if ($JefeTurno == "S")
					$JefeTurno = "";
				if ($OperadorAnalisis == "S")
					$OperadorAnalisis = "";
				if ($JefeTurnoAnalisis == "S")
					$JefeTurnoAnalisis = "";	
				$H_Filtracion = $HoraFiltra.":".$MinutosFiltra.":00";
				$TxtAcidc = str_replace(".","",$TxtAcidc);
				$TxtAcidc = str_replace(",",".",$TxtAcidc);
				$TxtAcidc = str_replace(".","",$TxtAcidc);
				$TxtAcidc = str_replace(",",".",$TxtAcidc);
				$TxtBAD =str_replace(".","",$TxtBAD);
				$TxtBAD =str_replace(",",".",$TxtBAD);
				$Insertar = "INSERT INTO pmn_web.lixiviacion_barro_anodico ";
				$Insertar.= "(rut, fecha,turno, num_lixiviacion,lixiviador, acidc,fecha_carga, hora_carga, operador, jefe_turno, ";
				$Insertar.= " fecha_analisis, hora_analisis, porc_cobre, fecha_filtracion, hora_filtracion, bad, operador_analisis, jefe_turno_analisis
				,observacion,stock_bad)";
				$Insertar.= " values('".$CookieRut."','".$Fecha."', '".$Turno."', '".$TxtNumLixiv."', '".$TxtLixiv."', '".$TxtAcidc."', ";
				$Insertar.= "'".$FechaCarga."', '".$H_Carga."', '".$Operador."', '".$JefeTurno."', '".$FechaAnalisis."', '".$H_Analisis."', ";
				$Insertar.= "'".$TxtPorcCu."', '".$FechaFiltracion."', '".$H_Filtracion."', '".$TxtBAD."', '".$OperadorAnalisis."', '".$JefeTurnoAnalisis."'
				,'".$Observacion."','".$TxtBAD."')"; 
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);				
				$FechaModif=$Ano.'-'.$Mes.'-'.$Dia;
				
				//25 = barro anodico descobrizado - 1 = BAD ventanas.
				//Movimientos_Pmn('','25','1','2',str_replace(",",".",$TxtBAD),'1','',$TxtNumLixiv,'2',$CookieRut,'I','',$Turno);
				//StockPmn_valor('25','1',$Ano,$Mes,'I','P',$TxtBAD,'0');
				
				header("location:pmn_lixiviacion.php?ModifLixi=S&FechaModif=".$FechaModif."&TurnoModif=".$Turno."&NumLixModif=".$TxtNumLixiv."&D=".$Dia."&M=".$Mes."&A=".$Ano."&Ver=S&Tab6=true");
			}
			break;
		case "A":
			//CONSULTA DATOS EN BD
			$Consulta =  "select * from pmn_web.lixiviacion_barro_anodico";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and turno = '".$Turno."'";
			$Consulta.= " and num_lixiviacion = '".$TxtNumLixiv."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				if ($Row["bad"] == 0)
					$BadAnterior = "";
				else
					$BadAnterior = $Row["bad"];
			}
			else
			{
				$BadAnterior = "";
			}
			
			//---.
			//Verifica para no modificar el stock cuenado actualice datos.
			$rs1 = mysqli_query($link, $Consulta);
			if ($row1 = mysqli_fetch_array($rs1))
			{
				if (($TxtBAD != '') and ($row1["bad"] == 0))
					$BadStock = str_replace(",",".",$TxtBAD);
				else if (($TxtBAD != '') and ($row1["bad"] != 0 ))	
					$BadStock = $row1["stock_bad"];
				else 
					$BadStock = $row1["stock_bad"];
			}
			//---.
			
			
			//GRABA EN REGISTRO CAMBIOS SI HAY MODIG. EN BAD
			if (($BadAnterior != "") && ($BadAnterior != $TxtBAD))
			{
				$Insertar = "INSERT INTO pmn_web.registro_cambios (rut, fecha_hora, cod_pantalla, campo, valor_ant, valor_nuevo) ";
				$Insertar.= " values('".$CookieRut."','".date("Y-m-d H:i:s")."','3','B.A.D.','".$BadAnterior."','".$TxtBAD."')";
				mysqli_query($link, $Insertar);
			}
			//-------------------------------------------
			if ($Operador == "S")
				$Operador = "";
			if ($JefeTurno == "S")
				$JefeTurno = "";
			if ($OperadorAnalisis == "S")
				$OperadorAnalisis = "";
			if ($JefeTurnoAnalisis == "S")
				$JefeTurnoAnalisis = "";
			$FechaCarga= $AnoLixiv."-".$MesLixiv."-".$DiaLixiv;
			$H_Carga = $HoraLixiv.":".$MinutosLixiv.":00";
			$FechaAnalisis = "0000-00-00";
			$H_Analisis = "00:00:00";
			$FechaFiltracion = $AnoFiltracion."-".$MesFiltracion."-".$DiaFiltracion;
			$H_Filtracion = $HoraFiltra.":".$MinutosFiltra.":00";
			$TxtAcidc = str_replace(".","",$TxtAcidc);
			$TxtAcidc = str_replace(",",".",$TxtAcidc);
			$TxtPorcCu = str_replace(".","",$TxtPorcCu);
			$TxtPorcCu = str_replace(",",".",$TxtPorcCu);
			$TxtBAD =str_replace(".","",$TxtBAD);
			$TxtBAD =str_replace(",",".",$TxtBAD);
			//$Fecha = $Ano."-".$Mes."-".$Dia;
			$Actualizar =  "UPDATE pmn_web.lixiviacion_barro_anodico set ";
			$Actualizar.= " num_lixiviacion = '".$TxtNumLixiv."', lixiviador = '".$TxtLixiv."', acidc = '".$TxtAcidc."',observacion='".$Observacion."', ";
			$Actualizar.= " fecha_carga = '".$FechaCarga."', hora_carga = '".$H_Carga."', operador = '".$Operador."', jefe_turno = '".$JefeTurno."', ";
			$Actualizar.= " fecha_analisis = '".$FechaAnalisis."', hora_analisis = '".$H_Analisis."', porc_cobre = '".$TxtPorcCu."', ";
			$Actualizar.= " fecha_filtracion = '".$FechaFiltracion."', hora_filtracion = '".$H_Filtracion."', bad = '".$TxtBAD."', operador_analisis = '".$OperadorAnalisis."', jefe_turno_analisis = '".$JefeTurnoAnalisis."'";
			$Actualizar.= " where num_lixiviacion = '".$TxtNumLixiv."' ";
			$Actualizar.= " and fecha = '".$Fecha."'";
			$Actualizar.= " and turno = '".$Turno."'";
			//echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);

			//25 = barro anodico descobrizado - 1 = BAD ventanas.
			//Movimientos_Pmn('','25','1','2',str_replace(",",".",$TxtBAD),'1','',$TxtNumLixiv,'2',$CookieRut,'M','',$Turno);
			//StockPmn_valor('25','1',$Ano,$Mes,'E','P',$BadAnterior,'0');
			//StockPmn_valor('25','1',$Ano,$Mes,'I','P',$TxtBAD,'0');
			
			header("location:pmn_lixiviacion.php?ModifLixi=".$Modif."&DiaModif=".$Dia."&MesModif=".$Mes."&AnoModif=".$Ano."&TurnoModif=".$Turno."&NumLixModif=".$TxtNumLixiv."&FechaModif=".$FechaModif."&Tab6=true");
			break;
		case "C":
			header("location:pmn_lixiviacion.php");
			break;
		case "E2":
			//echo "Fecha:".$Fecha;
			$porciones = explode("-", $Fecha);
			$Ano = $porciones[0];
			$Mes = $porciones[1];
			$Dia = $porciones[2];

			$Consulta =  "select * from pmn_web.lixiviacion_barro_anodico";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and turno = '".$Turnito."'";
			$Consulta.= " and num_lixiviacion = '".$Lixiv."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				if ($Row["bad"] == 0)
					$BadAnterior = "";
				else
					$BadAnterior = $Row["bad"];
			}
			else
				$BadAnterior = "";

			//25 = barro anodico descobrizado - 1 = BAD ventanas.
			//Movimientos_Pmn('','25','1','2','','','',$Lixiv,'2',$CookieRut,'E','',$Turnito);
			//echo "Año:".$Ano." Mes:".$Mes;
			StockPmn_valor('25','1',$Ano,$Mes,'E','P',$BadAnterior,'0',$link);
			$Eliminar = "delete from pmn_web.lixiviacion_barro_anodico ";
			$Eliminar.= " where fecha = '".$Fecha."'";
			$Eliminar.= " and turno = '".$Turnito."'";
			$Eliminar.= " and num_lixiviacion = '".$Lixiv."' ";
			mysqli_query($link, $Eliminar);

			header("location:pmn_ing_lixiviacion03.php?NumLix=".$Lixiv);
			break;
		case "E":
			//25 = barro anodico descobrizado - 1 = BAD ventanas.
			$Consulta =  "select * from pmn_web.lixiviacion_barro_anodico";
			$Consulta.= " where fecha = '".$FechaCarga."'";
			$Consulta.= " and turno = '".$Turnito."'";
			$Consulta.= " and num_lixiviacion = '".$Lixiv."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				if ($Row["bad"] == 0)
					$BadAnterior = "";
				else
					$BadAnterior = $Row["bad"];
			}
			else
				$BadAnterior = "";

			//25 = barro anodico descobrizado - 1 = BAD ventanas.
			//Movimientos_Pmn('','25','1','2','','','',$Lixiv,'2',$CookieRut,'E','',$Turnito);
			//echo $BadAnterior;
			StockPmn_valor('25','1',$Ano,$Mes,'E','P',$BadAnterior,'0',$link);
			$Eliminar = "delete from pmn_web.lixiviacion_barro_anodico ";
			$Eliminar.= " where fecha = '".$FechaCarga."'";
			$Eliminar.= " and turno = '".$Turnito."'";
			$Eliminar.= " and num_lixiviacion = '".$Lixiv."' ";
			mysqli_query($link, $Eliminar);

			header("location:pmn_ing_lixiviacion02.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&DiaF=".$DiaF."&MesF=".$MesF."&AnoF=".$AnoF);
		break;	
		case "IngHum":
			$Fecha = $Ano."-".$Mes."-".$Dia;
			
			$TotFinal=$TxtBAD-($TxtBAD*$Porc/100);
			$Actualizar =  "UPDATE pmn_web.lixiviacion_barro_anodico set ";
			$Actualizar.= " porc_agua = '".$Porc."'";
			$Actualizar.= " ,stock_bad = '".$TotFinal."'";
			$Actualizar.= " where num_lixiviacion = '".$NumLix."' ";
			$Actualizar.= " and fecha = '".$Fecha."'";
			$Actualizar.= " and turno = '".$Turno."'";
			//echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);
			?>
			<script language="javascript">
			window.opener.document.frmPrincipalRpt.action = "pmn_lixiviacion.php?ModifLixi=S&DiaModif=<?php echo $Dia;?>&MesModif=<?php echo $Mes;?>&AnoModif=<?php echo $Ano;?>&TurnoModif=<?php echo $Turno;?>&NumLixModif=<?php echo $NumLix;?>&FechaModif=<?php echo $Fecha;?>&Tab6=true";
			window.opener.document.frmPrincipalRpt.submit();
			window.close();
			</script>
			<?php			
			//header("location:pmn_ing_lixiviacion04.php?NumLix=".$NumLix."&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Turno=".$Turno."&Msj=S");
		break;
	}
?>