<?php
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
			$Insertar="insert into sgrs_codcontactos (CCONTACTO,NCONTACTO,MOPCIONAL,QPROBHIST,QCONSECHIST,FCONTACTO,MVIGENTE,OBS) values('".$CodConta.$CmbCod."','".trim($TxtDescripcion)."','".$Sel."','".$CmbProbH."','".$CmbConsH."','".date('Y-m-d')."','".$Vig."','".$OBS."')";
			mysqli_query($link,$Insertar);
			//echo $Insertar;

			$Obs="Se a Ingresado Peligro ".trim($TxtDescripcion)." Con Probabilidad Historica ".$CmbProbH." y Consecuancia Histórica ".$CmbConsH."";	
			InsertaHistorico($CookieRut,'8',$Obs,'','','');//INGRESA PELIGRO

			header('location:mantenedor_peligros.php?Buscar=S&CmbCONTACTO='.$CodConta);
		break;
		case "MP"://MODIFICAR CONTACTO/PELIGRO
			$Vig=0;$Sel='0';
			if($CheckVig==true)
				$Vig='1';
			if($CheckSel==true)
				$Sel='1';
			$Consulta="select * from sgrs_codcontactos where CCONTACTO='".$CodConta."'";
			$Resp=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$NOMANT=$Fila[NCONTACTO];
			$PH=$Fila[QPROBHIST];
			$PC=$Fila[QCONSECHIST];
			$Actualizar="update sgrs_codcontactos set NCONTACTO='".trim($TxtDescripcion)."',MOPCIONAL='".$Sel."',QPROBHIST='".$CmbProbH."',QCONSECHIST='".$CmbConsH."',MVIGENTE='".$Vig."',OBS='".$OBS."' where CCONTACTO='".$CodConta."'";
			mysqli_query($link,$Actualizar);
			//echo $Actualizar;
			
			$Obs="Se a Modificado Peligro ".trim($NOMANT).", Probabilidad Historica ".$PH." y Consecuancia Histórica ".$PC." ";	
			$Obs2="Por Peligro ".trim($TxtDescripcion).", Probabilidad Historica ".$CmbProbH." y Consecuancia Histórica ".$CmbConsH."";	
			InsertaHistorico($CookieRut,'9',$Obs,$Obs2,'','');//MODIFICA PELIGRO

			/*MODIFICAR LA PROBABILIDAD Y CONSECUENCIA HISTORICA CONLLEVA A ACTUALIZAR LA TABLA SGRS_SIPERPELIGROS*/
			if((intval($PH)<>intval($CmbProbH))||(intval($PC)<>intval($CmbConsH)))
			{
				$Obs=$CodConta.",".$PH.",".$PC.",".$Vig.",EXI";
				RegistroSiper(16,$CookieRut,'MP',$Obs);	
				$Obs=$CodConta.",".$CmbProbH.",".$CmbConsH.",".$Vig.",MOD";
				RegistroSiper(16,$CookieRut,'MP',$Obs);	
				$Consulta="select * from sgrs_siperpeligros where CCONTACTO='".$CodConta."' AND MVIGENTE = '1' AND (QPC<>0 AND QCC<>0 AND QMR<>0 AND QMRH<>0) AND (QPC IS NOT NULL AND QCC IS NOT NULL)";
				$Resp=mysqli_query($link,$Consulta);
				while($Fila=mysqli_fetch_array($Resp))
				{
					//echo "ORIG: ".$Fila[CPELIGRO]." - ".$Fila[QMR]." - ".$Fila[QPC]." - ".$Fila[QCC]." - ".$Fila[QMRH]."<br>";
					CalculoMR($CodConta,$Fila[CPELIGRO],&$PH,&$CH,&$MRi,&$PC,&$CC,&$MR,$Descrip,$Semaforo);
					//echo "REAL: ".$Fila[CPELIGRO]." - ".$MR." - ".$PC." - ".$CC." - ".$MRi."<br><br>";
					$Actualizar="update sgrs_siperpeligros set QMR='".$MR."',QPC='".$PC."', QCC='".$CC."',QMRH='".$MRi."' where CPELIGRO='".$Fila[CPELIGRO]."'";
					//echo $Actualizar."<br>";
					mysqli_query($link,$Actualizar);
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
				$Consultar="select * from sgrs_codcontactos where CCONTACTO='".$CodConta."' and MOPCIONAL='0'";
				$Resp=mysqli_query($link,$Consultar);
				if($Fila=mysqli_fetch_array($Resp))
				{
					$Consultar="select * from sgrs_codcontactos where CCONTACTO like '".$CodConta."%' and CCONTACTO<>'".$CodConta."' and MOPCIONAL='1'";
					$Resp=mysqli_query($link,$Consultar);
					if($Fila=mysqli_fetch_array($Resp))
						$PoseeHijos="S";	
				}
				if($PoseeHijos=="N")
				{
					$Consultar="select * from sgrs_siperpeligros where CCONTACTO='".$CodConta."'";
					$Resp=mysqli_query($link,$Consultar);
					if(!$Fila=mysqli_fetch_array($Resp))
					{
						$Consultar="select * from sgrs_codcontactos where CCONTACTO='".$CodConta."'";
						$Resp=mysqli_query($link,$Consultar);
						if($Fila=mysqli_fetch_array($Resp))
							$NomPeli=$Fila[NCONTACTO];
	
						$Eliminar="delete from sgrs_codcontactos where CCONTACTO='".$CodConta."'";
						mysqli_query($link,$Eliminar);
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