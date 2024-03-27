<?
	include('conectar_ori.php');
	include('funciones/siper_funciones.php');
	switch($Proceso)
	{
		case "AP"://AGREGAR CONTACTO/PELIGRO
			$Vig=0;$Sel='0';
			if($CheckVig==true)
				$Vig='1';
			if($CheckSel==true)
				$Sel='1';	
			$Insertar="INSERT INTO sgrs_codcontactos (CCONTACTO,NCONTACTO,MOPCIONAL,QPROBHIST,QCONSECHIST,FCONTACTO,MVIGENTE,OBS) values('".$CodConta.$CmbCod."','".trim($TxtDescripcion)."','".$Sel."','".$CmbProbH."','".$CmbConsH."','".date('Y-m-d')."','".$Vig."','".$OBS."')";
			mysql_query($Insertar);
			//echo $Insertar;

			$Obs="Se a Ingresado Peligro ".trim($TxtDescripcion)." Con Probabilidad Historica ".$CmbProbH." y Consecuancia Hist�rica ".$CmbConsH."";	
			InsertaHistorico($CookieRut,'8',$Obs,'','','');//INGRESA PELIGRO

			header('location:mantenedor_peligros.php?Buscar=S&CmbCONTACTO='.$CodConta);
		break;
		case "MP"://MODIFICAR CONTACTO/PELIGRO
			$Vig=0;$Sel='0';
			if($CheckVig==true)
				$Vig='1';
			if($CheckSel==true)
				$Sel='1';
			$Consulta="SELECT * from sgrs_codcontactos where CCONTACTO='".$CodConta."'";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysql_fetch_array($Resp);
			$NOMANT=$Fila[NCONTACTO];
			$PH=$Fila[QPROBHIST];
			$PC=$Fila[QCONSECHIST];
			$Actualizar="UPDATE sgrs_codcontactos set NCONTACTO='".trim($TxtDescripcion)."',MOPCIONAL='".$Sel."',QPROBHIST='".$CmbProbH."',QCONSECHIST='".$CmbConsH."',MVIGENTE='".$Vig."',OBS='".$OBS."' where CCONTACTO='".$CodConta."'";
			mysql_query($Actualizar);
			//echo $Actualizar;
			
			$Obs="Se a Modificado Peligro ".trim($NOMANT).", Probabilidad Historica ".$PH." y Consecuancia Hist�rica ".$PC." ";	
			$Obs2="Por Peligro ".trim($TxtDescripcion).", Probabilidad Historica ".$CmbProbH." y Consecuancia Hist�rica ".$CmbConsH."";	
			InsertaHistorico($CookieRut,'9',$Obs,$Obs2,'','');//MODIFICA PELIGRO

			/*MODIFICAR LA PROBABILIDAD Y CONSECUENCIA HISTORICA CONLLEVA A ACTUALIZAR LA TABLA SGRS_SIPERPELIGROS*/
			if((intval($PH)<>intval($CmbProbH))||(intval($PC)<>intval($CmbConsH)))
			{
				$Obs=$CodConta.",".$PH.",".$PC.",".$Vig.",EXI";
				RegistroSiper(16,$CookieRut,'MP',$Obs);	
				$Obs=$CodConta.",".$CmbProbH.",".$CmbConsH.",".$Vig.",MOD";
				RegistroSiper(16,$CookieRut,'MP',$Obs);	
				$Consulta="SELECT * from sgrs_siperpeligros where CCONTACTO='".$CodConta."' AND MVIGENTE = '1' AND (QPC<>0 AND QCC<>0 AND QMR<>0 AND QMRH<>0) AND (QPC IS NOT NULL AND QCC IS NOT NULL)";
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					//echo "ORIG: ".$Fila[CPELIGRO]." - ".$Fila[QMR]." - ".$Fila[QPC]." - ".$Fila[QCC]." - ".$Fila[QMRH]."<br>";
					CalculoMR($CodConta,$Fila[CPELIGRO],&$PH,&$CH,&$MRi,&$PC,&$CC,&$MR,$Descrip,$Semaforo);
					//echo "REAL: ".$Fila[CPELIGRO]." - ".$MR." - ".$PC." - ".$CC." - ".$MRi."<br><br>";
					$Actualizar="UPDATE sgrs_siperpeligros set QMR='".$MR."',QPC='".$PC."', QCC='".$CC."',QMRH='".$MRi."' where CPELIGRO='".$Fila[CPELIGRO]."'";
					//echo $Actualizar."<br>";
					mysql_query($Actualizar);
				}
			}
			header('location:mantenedor_peligros.php?Buscar=S&CmbCONTACTO='.$CodConta);
		break;
		case "EP"://ELIMINAR CONTACTO/PELIGRO
			$PoseeHijos="N";
			//echo $CodConta."<br>";
			$CodConta1=explode('//',$CodConta);
			while(list($c,$v)=each($CodConta1))
			{
				$CodConta=$v;
				$Consultar="SELECT * from sgrs_codcontactos where CCONTACTO='".$CodConta."' and MOPCIONAL='0'";
				$Resp=mysql_query($Consultar);
				if($Fila=mysql_fetch_array($Resp))
				{
					$Consultar="SELECT * from sgrs_codcontactos where CCONTACTO like '".$CodConta."%' and CCONTACTO<>'".$CodConta."' and MOPCIONAL='1'";
					$Resp=mysql_query($Consultar);
					if($Fila=mysql_fetch_array($Resp))
						$PoseeHijos="S";	
				}
				if($PoseeHijos=="N")
				{
					$Consultar="SELECT * from sgrs_siperpeligros where CCONTACTO='".$CodConta."'";
					$Resp=mysql_query($Consultar);
					if(!$Fila=mysql_fetch_array($Resp))
					{
						$Consultar="SELECT * from sgrs_codcontactos where CCONTACTO='".$CodConta."'";
						$Resp=mysql_query($Consultar);
						if($Fila=mysql_fetch_array($Resp))
							$NomPeli=$Fila[NCONTACTO];
	
						$Eliminar="delete from sgrs_codcontactos where CCONTACTO='".$CodConta."'";
						mysql_query($Eliminar);
						//echo $ObsEli."<br>";
						$Obs="Se a Eliminado Peligro ".trim($NomPeli)."";	
						InsertaHistorico($CookieRut,'10',$Obs,'','',$ObsEli);//ELIMINA PELIGRO
					}
					else
						$Mensaje='No se Puede Eliminar Contacto/Peligro esta asignado a tareas';
				}
				else
						$Mensaje='No se Puede Eliminar Control, Padre tiene Hijos asignados';
				//echo $Eliminar;
			}
			header('location:mantenedor_peligros.php?Mensaje='.$Mensaje);
		break;
	}
?>