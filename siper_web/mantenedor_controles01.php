<?php
	include('conectar_ori.php');
	include('funciones/siper_funciones.php');
	echo $Proceso."<br>";
	switch($Proceso)
	{
		case "AC"://AGREGAR CONTROLES
			
			$CodNew=$CodConta.$CmbCod;
			if($CodConta!='')
			{
				$Consulta="select MPROBCONSEC from sgrs_codcontroles where CCONTROL = '".$CodConta."'";
				//echo $Consulta."<br>";
				$Result=mysqli_query($link,$Consulta);
				$Fila2=mysqli_fetch_array($Result);
				$CmbProbConsec=$Fila2[MPROBCONSEC];	
			}
			$Vig=0;
			if($CheckVig==true)
				$Vig='1';
			if($TxtPESOESP==''||!isset($TxtPESOESP))
				$TxtPESOESP='NULL';
			else
				$TxtPESOESP="'".str_replace(',','.',$TxtPESOESP)."'";
			$Consulta="select ifnull(sum(QPESOESP),0) as PESO_ESP from sgrs_codcontroles where MPROBCONSEC='".$CmbProbConsec."'";			
			$Result=mysqli_query($link,$Consulta);
			$Fila2=mysqli_fetch_array($Result);
			$PESO_ESP=$Fila2[PESO_ESP]+str_replace("'","",$TxtPESOESP);
			//echo "TOT PESO ESP:".$Fila2[PESO_ESP]."<BR>";
			//echo "PESO ESP NEW:".str_replace("'","",$TxtPESOESP)."<BR>";
			
			if($PESO_ESP<=1)
			{
				$Obs=$CodNew.",".$CmbProbConsec.",".$TxtPESOESP.",".$Vig;
				RegistroSiper(17,$CookieRut,'AC',$Obs);			
				$Insertar="insert into sgrs_codcontroles (CCONTROL,NCONTROL,MPROBCONSEC,QPESOESP,FCONTROL,MVIGENTE,OBS) values('0".$CodNew."','".trim($TxtDescripcion)."','0',0,'".date('Y-m-d')."','".$Vig."','".$OBS."')";
				mysqli_query($link,$Insertar);
				//echo $Insertar;
				$Peso=str_replace("'",'',$TxtPESOESP);
				$Obs='Se a Ingresado Control '.trim($TxtDescripcion).' Con Peso Especifico '.$Peso.'';	
				InsertaHistorico($CookieRut,'11',$Obs,'','','');//INGRESA CONTROL
			}
			else
				$Mensaje='Peso Especifico Control Excede al maximo Permitido que es 1';
			header('location:mantenedor_controles.php?Buscar=S&CmbControl='.$CodConta.'&Mensaje='.$Mensaje);
		break;
		case "MC"://MODIFICAR CONTROLES
			if($CodConta!='')
			{
				$Consulta="select MPROBCONSEC from sgrs_codcontroles where CCONTROL = '".$CodConta."'";
				//echo $Consulta."<br>";
				$Result=mysqli_query($link,$Consulta);
				$Fila2=mysqli_fetch_array($Result);
				$CmbProbConsec=$Fila2[MPROBCONSEC];	
			}
			$Vig=0;
			if($CheckVig==true)
				$Vig='1';
			$Consulta="select ifnull(sum(QPESOESP),0) as PESO_ESP from sgrs_codcontroles where MPROBCONSEC='".$CmbProbConsec."' and CCONTROL<>'".$CodConta."'";			
			$Result=mysqli_query($link,$Consulta);
			$Fila2=mysqli_fetch_array($Result);
			$PESO_ESP=$Fila2[PESO_ESP]+str_replace("'","",$TxtPESOESP);
			//echo "TOT PESO ESP:".$Fila2[PESO_ESP]."<BR>";
			//echo "PESO ESP NEW:".str_replace("'","",$TxtPESOESP)."<BR>";
			if($PESO_ESP<=1)
			{
				$Obs=$CodConta.",".$CmbProbConsec.",".$TxtPESOESP.",".$Vig;
				RegistroSiper(17,$CookieRut,'MC',$Obs,'','');			
				
				$Consulta="select NCONTROL,QPESOESP from sgrs_codcontroles where CCONTROL='".$CodConta."'";
				$Resp=mysqli_query($link,$Consulta);
				$Fila=mysqli_fetch_array($Resp);
				$NOMCONTROL=$Fila[NCONTROL];
				$QPESOESP=$Fila[QPESOESP];
				if($TxtPESOESP=='')
					$TxtPESOESP='NULL';
				else
					$TxtPESOESP=str_replace(',','.',$TxtPESOESP);
				$Actualizar="update sgrs_codcontroles set NCONTROL='".trim($TxtDescripcion)."',MPROBCONSEC='0',QPESOESP='0',MVIGENTE='".$Vig."',OBS='".$OBS."' where CCONTROL='".$CodConta."'";
				//echo  $Actualizar."<br>";
				mysqli_query($link,$Actualizar);
				//echo doubleval($QPESOESP)."<br>";
				//echo doubleval($TxtPESOESP)."<br>";
				
				//FUNCION DE REGISTRO HISTORICO
				$Obs="Se a Modificado Control ".trim($NOMCONTROL)." y Peso Especifico ".$QPESOESP."";	
				$Obs2="Por Control ".trim($TxtDescripcion)." y Peso Especifico ".$TxtPESOESP."";	
				InsertaHistorico($CookieRut,'12',$Obs,$Obs2,'','');//MODIFICA CONTROL

				if(doubleval($QPESOESP)<>doubleval($TxtPESOESP))
				{
					$Obs=$CodConta.",".$QPESOESP.",".$Vig.",EXI";
					RegistroSiper(17,$CookieRut,'MC',$Obs);	
					$Obs=$CodConta.",".$TxtPESOESP.",".$Vig.",MOD";
					RegistroSiper(17,$CookieRut,'MC',$Obs);	
					$Consulta="select t1.CPELIGRO,t1.CCONTACTO,t1.QMR,t1.QPC,t1.QCC,t1.QMRH from sgrs_siperpeligros t1 inner join sgrs_sipercontroles t2 on t1.CPELIGRO=t2.CPELIGRO and t1.CCONTACTO=t2.CCONTACTO where t2.CCONTROL='".$CodConta."' AND t2.MVIGENTE = '1' AND (t1.QPC<>0 AND t1.QCC<>0 AND t1.QMR<>0 AND t1.QMRH<>0) AND (t1.QPC IS NOT NULL AND t1.QCC IS NOT NULL)";
					$Resp=mysqli_query($link,$Consulta);
					//echo $Consulta;
					while($Fila=mysqli_fetch_array($Resp))
					{
						//echo "ORIG: ".$Fila[CPELIGRO]." - ".$Fila[QMR]." - ".$Fila[QPC]." - ".$Fila[QCC]." - ".$Fila[QMRH]."<br>";
						CalculoMR($Fila[CCONTACTO],$Fila[CPELIGRO],&$PH,&$CH,&$MRi,&$PC,&$CC,&$MR,$Descrip,$Semaforo);
						//echo "REAL: ".$Fila[CPELIGRO]." - ".$MR." - ".$PC." - ".$CC." - ".$MRi."<br><br>";
						$Actualizar="update sgrs_siperpeligros set QMR='".$MR."',QPC='".$PC."', QCC='".$CC."',QMRH='".$MRi."' where CPELIGRO='".$Fila[CPELIGRO]."'";
						//echo $Actualizar."<br>";
						mysqli_query($link,$Actualizar);
					}
				}
			//echo $Insertar;
			}
			else
				$Mensaje='Peso Especifico del Control Excede al maximo Permitido que es 1';
			header('location:mantenedor_controles.php?Buscar=S&CmbControl='.$CodConta.'&Mensaje='.$Mensaje);
		break;
		case "EC"://ELIMINAR CONTROLES
				$Codigos='';
				$CODCONT=explode('//',$CodConta);
				while(list($c,$v)=each($CODCONT))
				{
					$Consultar="select * from sgrs_sipercontroles where CCONTROL='".$v."'";
					$Resp=mysqli_query($link,$Consultar);
					if(!$Fila=mysqli_fetch_array($Resp))
					{
						//OBTENGO DATOS PARA REGISTRO HISTORICO
						$Consulta="select NCONTROL,QPESOESP from sgrs_codcontroles where CCONTROL='".$v."'";
						$Resp=mysqli_query($link,$Consulta);
						$Fila=mysqli_fetch_array($Resp);
						$NOMCONTROL=$Fila[NCONTROL];
	
						$Obs=$v;
						//RegistroSiper(17,$CookieRut,'EC',$Obs);			
						$Eliminar="delete from sgrs_codcontroles where CCONTROL='".$v."'";
						//echo $Eliminar."<br>";
						mysqli_query($link,$Eliminar);
	
						//FUNCION DE REGISTRO HISTORICO
						$Obs='Se a Eliminado Control '.trim($NOMCONTROL).'';	
						//echo $ObsEli."<br>";
						InsertaHistorico($CookieRut,'13',$Obs,'','',$ObsEli);//ELIMINA CONTROL
						$Msj='S';
					}
					else
						$Codigos=$Codigos.$Fila[CCONTROL]."~";
				}
				if($Codigos!='')
					$Msj=substr($Codigos,0,strlen($Codigos)-1);
			//echo $Eliminar;
			header('location:mantenedor_controles.php?Msj='.$Msj.'&CmbControl='.$CmbControl.'&Buscar=S');
		break;
	}
?>