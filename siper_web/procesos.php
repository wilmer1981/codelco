<?php
	require_once("EnDecryptText.php"); 
	include('conectar_ori.php');
	include('funciones/siper_funciones.php');
	require "includes/class.phpmailer.php";	
	if(isset($ProcesoAux))
		$Proceso=$ProcesoAux;
	//echo "ENTRO:".$Proceso;
	switch($Proceso)
	{
		case "GI"://GRABAR ITEM ORGANICA
			$Descrip=$TxtDescrip;
			$Insertar="insert into sgrs_areaorg (NAREA,FAREA,CTAREA,MVIGENTE,CZGEOGRAFICA,CSISTEMA,CPARENT) values('".$Descrip."','".date('Y-m-d')."','$Tipo','$Vigente','V','2','$Parent')";
			mysqli_query($link,$Insertar);
			//echo $Insertar;
			
			$Consulta="select * from sgrs_organica where CORGANICA='".$Tipo."'";
			$RespTipo=mysqli_query($link,$Consulta);
			if($Fila=mysqli_fetch_array($RespTipo))
				$ORGAAREA=$Fila[NORGANICA];//NOMBRE DE LA DESCIPCION DONDE SE INGRESO LA AREA
			OrigenOrg($Parent,&$Ruta)	;
			$Obs="Se a creado: ".$Descrip." de Tipo ".$ORGAAREA.", En la siguiente Ruta: ".$Ruta.".";	
			InsertaHistorico($CookieRut,'1',$Obs,'','','');//AGREGA ORGANICA ITEM
			
			if($Tipo=='8')
			{
				$Consulta="select CAREA from sgrs_areaorg where NAREA='".$Descrip."' and CPARENT='".$Parent."' and FAREA='".date('Y-m-d')."' and CTAREA='".$Tipo."'";	
				//echo $Consulta."<br>";
				$Resp=mysqli_query($link,$Consulta);
				$Fila=mysqli_fetch_array($Resp);		
				$CAREA=$Fila[CAREA];
				$Insertar="insert into sgrs_siperoperaciones (CAREA,MIDENTIFICADO,MVALIDADO,MRUTINARIA,TCPARENT) values('".$CAREA."',0,0,'$Rutinario','')";
				mysqli_query($link,$Insertar);
				//echo $Insertar;
			}
			if($Parent==',0,1,')
			{
				$Consulta="select CAREA from sgrs_areaorg where NAREA='".$Descrip."' and CPARENT='".$Parent."' and FAREA='".date('Y-m-d')."' and CTAREA='".$Tipo."'";	
				//echo $Consulta."<br>";
				$Resp=mysqli_query($link,$Consulta);
				$Fila=mysqli_fetch_array($Resp);		
				$CAREA=$Fila[CAREA];
				$Consulta="select COD_GERENCIAS from sgrs_acceso_organica where RUT='".$CookieRut."'";	
				//echo $Consulta."<br>";
				$Resp=mysqli_query($link,$Consulta);
				$Fila=mysqli_fetch_array($Resp);		
				$CGER=$Fila[COD_GERENCIAS].",".$CAREA;
				$Actualizar="update sgrs_acceso_organica set COD_GERENCIAS='".$CGER."' where RUT='".$CookieRut."'";
				mysqli_query($link,$Actualizar);
				//echo $Actualizar."<br>";
			}			
			echo "<script languaje=javascript>";
			echo "top.frames['Procesos'].location='procesos_organica.php';";
			echo "top.frames['Organica'].BuscaItem2('".$Parent."','');";
			echo "</script>";
		break;
		case "MI"://MODIFICAR ITEM ORGANICA
			$Descrip=$TxtDescrip;
			$ParentAux=substr($Parent,0,strlen($Parent)-1);
			$Parent1=$Parent;
			$CODAREA=ObtenerCodParent(&$Parent);

			$Consulta="select * from sgrs_areaorg where CAREA='".$CODAREA."'";
			//echo $Consulta."<br>";
			$RespTipo=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($RespTipo);
			$NAREA=$Fila[NAREA];//NOMBRE DE LA DESCIPCION DONDE SE MODIFICO EL AREA
			$CTipo=$Fila[CTAREA];
			$Consulta="select * from sgrs_organica where CORGANICA='".$CTipo."'";
			$RespTipo=mysqli_query($link,$Consulta);
			if($Fila=mysqli_fetch_array($RespTipo))
				$ORGAAREA=$Fila[NORGANICA];//NOMBRE DE LA DESCIPCION DONDE SE INGRESO LA AREA

			$Modificar="update sgrs_areaorg set NAREA='".$Descrip."',MVIGENTE=".$Vigente;
			if($Tipo!='S')
				$Modificar.=", CTAREA='".$Tipo."'";
			$Modificar.=" where CAREA='".$CODAREA."'";
			mysqli_query($link,$Modificar);
			//echo $Modificar."<br>";
			//AGREGA REGISTRO HISTORICO
			$Consulta="select * from sgrs_organica where CORGANICA='".$Tipo."'";
			$RespTipo=mysqli_query($link,$Consulta);
			if($Fila=mysqli_fetch_array($RespTipo))
				$ORGAAREA2=$Fila[NORGANICA];//NOMBRE DE LA DESCIPCION DONDE SE INGRESO LA AREA
				
			OrigenOrg($Parent1,&$Ruta);
			$Obs="Se a modificado ".$NAREA.", Tipo ".$ORGAAREA.", en la siguiente Ruta: ".$Ruta.".";	
			$Obs2="Por ".$Descrip." de Tipo ".$ORGAAREA2.",  en la siguiente Ruta: ".$Ruta.".";	
			InsertaHistorico($CookieRut,'2',$Obs,$Obs2,'','');//MODIFICA ORGANICA ITEM
			//FIN AGREGA REGISTRO HISTORICO
			$Consulta="select CTAREA from sgrs_areaorg where CAREA='".$CODAREA."'";	
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resp);		
			if($Fila[CTAREA]=='8')
			{
				$Consulta="select * from sgrs_siperoperaciones where CAREA='".$CODAREA."'";	
				//echo $Consulta."<br>";
				$Resp=mysqli_query($link,$Consulta);
				if($Fila=mysqli_fetch_array($Resp))	
				{
					$Actualizar="update sgrs_siperoperaciones set MRUTINARIA='$Rutinario' where CAREA='".$CODAREA."'";
					mysqli_query($link,$Actualizar);
				}
				else
				{
					$Insertar="insert into sgrs_siperoperaciones (CAREA,MIDENTIFICADO,MVALIDADO,MRUTINARIA,TCPARENT) values('".$CODAREA."',0,0,'$Rutinario','')";
					mysqli_query($link,$Insertar);			
				}	
			}
			$ParentAux=str_replace($Parent,'',$ParentAux);
			echo "<script languaje=javascript>";
			echo "top.frames['Procesos'].location='procesos_organica.php';";
			echo "top.frames['Organica'].BuscaItem2('".$ParentAux."','');";
			echo "</script>";		
		break;
		case "EI"://ELIMINAR ITEM ORGANICA
			$Mensaje='';
			OrigenOrg($Parent,&$Ruta);
			$Area=$Descrip;
			$Consulta="select * from sgrs_areaorg where CPARENT='".$Parent."'";	
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link,$Consulta);
			if(!$Fila=mysqli_fetch_array($Resp))		
			{
				$ParentAux=substr($Parent,0,strlen($Parent)-1);
				$CODAREA=ObtenerCodParent(&$Parent);
				$Consulta="select * from sgrs_siperpeligros where CAREA='".$CODAREA."' and MVIGENTE <> '0' ";
				$Resp=mysqli_query($link,$Consulta);
				if(!$Fila=mysqli_fetch_array($Resp))		
				{
					$ConsultaAreaNom="select * from sgrs_areaorg where CAREA='".$CODAREA."'";
					$RespAreaNom=mysqli_query($link,$ConsultaAreaNom);
					$FilaAreaNom=mysqli_fetch_array($RespAreaNom);
					$NomArea=$FilaAreaNom[NAREA];
					
					$Eliminar="delete from sgrs_siperoperaciones where CAREA='".$CODAREA."'";
					mysqli_query($link,$Eliminar);
					$Eliminar="delete from sgrs_areaorg where CAREA='".$CODAREA."'";
					//echo $Eliminar;
					mysqli_query($link,$Eliminar);

					$Obs="Se Elimino ".$NomArea." de la siguiente Ruta: ".$Ruta.".";	
					InsertaHistorico($CookieRut,'3',$Obs,'','',$ObsEli);//ELIMINA ORGANICA ITEM ESTADO 3
				}
				else
					$Mensaje='No se puede Eliminar Tarea, posee Peligros asociados';
			}
			else
				$Mensaje='No se puede Eliminar Item, posee SubNiveles asociados';	
			$ParentAux=str_replace($Parent,'',$ParentAux);
			echo "<script languaje=javascript>";
			echo "top.frames['Procesos'].location='procesos_organica.php';";
			echo "top.frames['Organica'].BuscaItem2('".$ParentAux."','".$Mensaje."');";
			echo "</script>";	
		break;
		case "MP"://MODIFICAR OBSERVACION A PELIGRO ASOCIADO A TAREA
			//echo "DATOS:".DatosObsPel;
			$ParentFun=$Parent;
			$CODAREA=ObtenerCodParent(&$Parent);
			//$Datos=explode('//',$DatosPel);
			$Consulta="select * from sgrs_areaorg where CAREA='".$CODAREA."'";
			$Resp=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$NOMAREA=$Fila[NAREA];
			$Datos=explode('//',$DatosObsPel);
			while(list($c,$v)=each($Datos))
			{
				$DatosObs=explode('~@~',$v);
				$ObsAux=str_replace("'",'"',$DatosObs[2]);

				$Consulta="select * from sgrs_siperpeligros where CAREA='".$CODAREA."' and CPELIGRO='".$DatosObs[0]."' and CCONTACTO='".$DatosObs[1]."'";
				$Resp=mysqli_query($link,$Consulta);
				$Fila=mysqli_fetch_array($Resp);
				$OBSPRINCIPAL=$Fila[TOBSERVACION];
				$Consulta="select * from sgrs_codcontactos where CCONTACTO='".$DatosObs[1]."'";
				$Resp=mysqli_query($link,$Consulta);
				$Fila=mysqli_fetch_array($Resp);
				$NOMPELI=$Fila[NCONTACTO];
				
				$Actualizar="update sgrs_siperpeligros set TOBSERVACION='".$ObsAux."' where CAREA='".$CODAREA."' and CPELIGRO='".$DatosObs[0]."' and CCONTACTO='".$DatosObs[1]."'";
				//echo $Actualizar."<br>";
				mysqli_query($link,$Actualizar);
				$Obs='El Peligro: '.$DatosObs[1]." - ".$NOMPELI.' Se Modificó: Observación '.$OBSPRINCIPAL.'. Asociado a La Tarea: '.$NOMAREA.'';	
				$Obs2='Por Observación: '.$ObsAux.'. Asociado a La Tarea: '.$NOMAREA.'';	
				InsertaHistorico($CookieRut,'18',$Obs,$Obs2,$ParentFun,'');//modifica PELIGR A TAREA 
			}
			echo "<script languaje=javascript>";
			echo "top.frames['Procesos'].location='procesos_organica.php?TipoPestana=1&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;";
			echo "</script>";		
		break;
		case "EP"://ELIMINAR PELIGRO ASOCIADO A TAREA
			//echo "DATOS:".DatosObsPel;
			$Mensaje='';
			$ParentFun=$Parent;
			$CODAREA=ObtenerCodParent(&$Parent);
			$Consulta="select * from sgrs_sipercontroles where CPELIGRO='".$CodPel."'";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link,$Consulta);
			if(!$Fila=mysqli_fetch_array($Resp))		
			{
				$Consulta="select * from sgrs_areaorg where CAREA='".$CODAREA."'";
				$Resp=mysqli_query($link,$Consulta);
				$Fila=mysqli_fetch_array($Resp);
				$NOMAREA=$Fila[NAREA];
				
				$Consulta="select * from sgrs_siperpeligros where CAREA='".$CODAREA."' and CPELIGRO='".$CodPel."'";
				//echo $Consulta."<br>";
				$Resp=mysqli_query($link,$Consulta);
				$Fila=mysqli_fetch_array($Resp);
				$CODPELI=$Fila[CCONTACTO];	
							
				$Consulta="select * from sgrs_codcontactos where CCONTACTO='".$CODPELI."'";
				//echo $Consulta."<br>";
				$Resp=mysqli_query($link,$Consulta);
				$Fila=mysqli_fetch_array($Resp);
				$NOMPELI=$Fila[NCONTACTO];
				
				$Obs='Se a Eliminado Peligro: '.$CODPELI." - ".$NOMPELI.'. Asociado a la Tarea: '.$NOMAREA.'.';	
				InsertaHistoricoIdent($CookieRut,'19',$Obs,'',$ParentFun,'','1');//modifica PELIGR A TAREA 
				//InsertaHistoricoIdent($CookieRut,'19',$Obs,'',$ParentFun,$ObsEli,$TipoES);//modifica PELIGR A TAREA 
				$Eliminar="delete from sgrs_siperpeligros where CAREA='".$CODAREA."' and CPELIGRO='".$CodPel."'";
				//echo $Eliminar;
				mysqli_query($link,$Eliminar);
			}
			else
				$Mensaje='No se puede Eliminar Peligro, posee Controles asociados';	

			echo "<script languaje=javascript>";			
			echo "top.frames['Procesos'].location='procesos_organica.php?TipoPestana=1&Msj=".$Mensaje."&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;";
			echo "</script>";
		break;
		case "ACP"://ACTIVAR PELIGRO NO VIGENTE Y DEJARLO VIGENTE
			$Mensaje='';
			$CODAREA=ObtenerCodParent(&$Parent);
			$Actualizar="update sgrs_siperpeligros set MVIGENTE='1' where CAREA='".$CODAREA."' and CPELIGRO='".$CodPel."'";
			//echo $Eliminar;
			mysqli_query($link,$Actualizar);
			$Mensaje='Cambio a Peligro Vigente';	
			echo "<script languaje=javascript>";
			echo "top.frames['Procesos'].location='procesos_organica.php?TipoPestana=1&Msj=".$Mensaje."&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;";
			echo "</script>";		
		break;

		case "GP"://AGREGAR PELIGROS A LA TAREA DESDE POPUP
			$ParentFun=$Parent;
			$CODAREA=ObtenerCodParent(&$Parent);
			$Datos=explode('//',$DatosPel);	
			while(list($c,$v)=each($Datos))
			{
				$Dato2=explode('~',$v);		
				$Consulta="select * from sgrs_codcontactos where CCONTACTO='".$Dato2[0]."'";
				$Resp=mysqli_query($link,$Consulta);
				$Fila=mysqli_fetch_array($Resp);
				$NOMPELI=$NOMPELI.$Dato2[0]." - ".$Fila[NCONTACTO].", ";

				$Insertar="insert into sgrs_siperpeligros(CAREA,CCONTACTO,FPELIGRO,MVALIDADO,MVIGENTE,QPROBHIST,QCONSECHIST) values ('".$CODAREA."','".$Dato2[0]."','".date('Y-m-d')."',0,1,'".$Dato2[1]."','".$Dato2[2]."')";
				//echo $Insertar."<br>";
				mysqli_query($link,$Insertar);
			}
			$Consulta="select * from sgrs_areaorg where CAREA='".$CODAREA."'";
			$Resp=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$NOMAREA=$Fila[NAREA];
			
			$NOMANT=substr($NOMANT,0,strlen($NOMANT)-2);	
			$Obs='Se a(han) Agregado los Siguientes Peligros: '.trim($NOMPELI).'. En Tarea:  '.$NOMAREA.'';	
			InsertaHistorico($CookieRut,'17',$Obs,'',$ParentFun,'');//AGREGA PELIGR A TAREA 
			echo "<script languaje=javascript>";
			echo "top.frames['Procesos'].location='procesos_organica.php?TipoPestana=1&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;";
			echo "</script>";
		break;
		case "GC"://AGREGAR CONTROLES AL PELIGRO
			$Consulta="select QPROBHIST,QCONSECHIST from sgrs_codcontactos where CCONTACTO ='".$CodContacto."'";
			$Resultado=mysqli_query($link,$Consulta);
			$PH=$Fila[QPROBHIST];		
			$Consulta="select CCONTACTO from sgrs_siperpeligros where CPELIGRO='".$CodPel."'";
			$Resp=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$CodCC=$Fila[CCONTACTO];
			$ParentFun=$Parent;
			$CODAREA=ObtenerCodParent(&$Parent);
			//SACO EL AREA EN LA QUE SE TRABAJA
			$Consulta="select * from sgrs_areaorg where CAREA='".$CODAREA."'";
			$Resp=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$NOMAREA=$Fila[NAREA];
			$Eliminar="delete from sgrs_sipercontroles where CCONTACTO='".$CodCC."' and CPELIGRO='".$CodPel."'";
			mysqli_query($link,$Eliminar);
			$AplicoCtrl=false;	
			//echo 		"datos:    ".$DatosCtrl."<br>";
			$Datos=explode('//',$DatosCtrl);
			while(list($c,$v)=each($Datos))
			{
				$Datos2=explode('~@~',$v);
				//echo $Datos2[1]."<br>";
				if($Datos2[1]!='NA')
					$AplicoCtrl=true;
				$Consulta="select * from sgrs_sipercontroles where CPELIGRO='".$CodPel."' and CCONTACTO='".$CodCC."' and CCONTROL='".$Datos2[0]."'";
				//echo "Consulta  controles:   ".$Consulta."<br>";
				$Resp=mysqli_query($link,$Consulta);
				if($Fila=mysqli_fetch_array($Resp))
				{
					//echo "existe<br>";
					if(is_null($Fila[MCONTROLH]))
						$MCONTROLH=$Fila[MCONTROL];
					else
						if(!is_null($Fila[MCONTROLH]))
							$MCONTROLH=$Fila[MCONTROLH];
						else
							$MCONTROLH=NULL;
					if($Datos2[1]=='NA')
					{
						$Obs=$CodPel.",".$CodCC.",".$Datos2[0].",".$MCONTROL.",,".$CODAREA.",NA";
						RegistroSiper(15,$CookieRut,'EC',$Obs);
						$MCONTROL=0;
						$Eliminar="delete from sgrs_sipercontroles where CPELIGRO='".$CodPel."' and CCONTACTO='".$CodCC."' and CCONTROL='".$Datos2[0]."'";
						//echo $Eliminar."<br>";
						//mysqli_query($link,$Eliminar);
					}
					else
						$MCONTROL=$Datos2[1];
					//echo "aca";
					$Consulta="select * from sgrs_sipercontroles_obs where TOBSERVACION='".$Datos2[2]."' and CCONTROL='".$Datos2[0]."' and CAREA='".$CODAREA."'";
					$Resp=mysqli_query($link,$Consulta);
					if(!$Fila=mysqli_fetch_array($Resp))
					{
						$Consulta="select max(CIDCONTROL+1) as maximo from sgrs_sipercontroles_obs ";
						$Resp=mysqli_query($link,$Consulta);
						if($Fila=mysqli_fetch_array($Resp))
						{
							if($Fila[maximo]=='')
								$TxtVeriObs='1';
							else		
								$TxtVeriObs=$Fila[maximo];
						}
						
						$Inserta="INSERT INTO sgrs_sipercontroles_obs  (CIDCONTROL,CCONTROL,CPELIGRO,TOBSERVACION,CAREA,CCONTACTO)";
						$Inserta.=" values('".$TxtVeriObs."','".$Datos2[0]."','".$CodPel."','".$Datos2[2]."','".$CODAREA."','".$CodCC."')";		
						//echo $Inserta."<br>";
						//mysqli_query($link,$Inserta);
					}
						
					$Consulta="select * from sgrs_sipercontroles where  CPELIGRO='".$CodPel."' and CCONTACTO='".$CodCC."' and CCONTROL='".$Datos2[0]."'";
					$Resp=mysqli_query($link,$Consulta);
					$Fila=mysqli_fetch_array($Resp);
					$OBS=$Fila[TOBSERVACION];$VERI=$Fila[VERIFICADOR_OPER];$ESPE=$Fila[ESPECIFICACION_CTRL];
					$Consulta="select * from sgrs_tipo_verificador where COD_VERIFICADOR='".$VERI."'";
					$Respuesta=mysqli_query($link,$Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$NONVERI1=$Fila[DESCRIP_VERIFICADOR];
						
					$ObsAux=str_replace("'",'"',$Datos2[2]);
					$Verifica=$Datos2[3];
					$EspCtrl=$Datos2[4];
					$Actualizar="update sgrs_sipercontroles set MCONTROL='".$MCONTROL."',MCONTROLH='".$MCONTROLH."',FCONTROL='".date('Y-m-d')."' where CPELIGRO='".$CodPel."' and CCONTACTO='".$CodCC."' and CCONTROL='".$Datos2[0]."'";
					//echo "primer update:    ".$Actualizar."<br>";
					mysqli_query($link,$Actualizar);
					
					$Obs=$CodPel.",".$CodCC.",".$Datos2[0].",".$MCONTROL.",".$MCONTROLH.",".$CODAREA;
					if($Datos2[1]!='NA')
						RegistroSiper(15,$CookieRut,'MC',$Obs);
					$Consulta="select * from sgrs_codcontactos where CCONTACTO='".$CodCC."'";
					$Resp=mysqli_query($link,$Consulta);
					$Fila=mysqli_fetch_array($Resp);
					$NOMCONTACT=$Fila[NCONTACTO];
					$Consulta="select NCONTROL,QPESOESP from sgrs_codcontroles where CCONTROL='".$Datos2[0]."'";
					$Resp=mysqli_query($link,$Consulta);
					$Fila=mysqli_fetch_array($Resp);
					$NOMCONTROL=$Fila[NCONTROL];

					$Obs1='En el Control '.$NOMCONTROL.' del Peligro: '.$NOMCONTACT.', Se a Modificado OBSERVACION: '.$OBS.' y Especificación de Control '.$ESPE.' de: '.$NOMAREA.'';	
					$Obs2='Reemplazado por:  OBSERVACION: '.$ObsAux.' y Especificación de Control '.$EspCtrl.' de la Área: '.$NOMAREA.'';	
					InsertaHistorico($CookieRut,'21',$Obs1,$Obs2,$ParentFun,'');//MODIFICA ASIGNACION DE CONTROLES
				}
				else
				{
					//echo "No existe<br>";
					if($Datos2[1]!='NA'||($Datos2[2]!=''||$Datos2[3]!='NA'||$Datos2[4]!=''))//NO APLICA NO SE INSERTAR
					{
						//echo "entroa";
						$Insertar="insert into sgrs_sipercontroles(CCONTROL,CCONTACTO,CPELIGRO,MCONTROL,FCONTROL,MVIGENTE,CAREA) values ";
						$Insertar.="('".$Datos2[0]."','".$CodCC."','".$CodPel."','".$Datos2[1]."','".date('Y-m-d')."','1','".$CODAREA."')";
						//echo "No Existe Graba:    ".$Insertar."<br>";
						mysqli_query($link,$Insertar);

						if($Datos2[2]!='')
						{
							$Consulta="select * from sgrs_sipercontroles_obs where TOBSERVACION='".$Datos2[2]."' and CCONTROL='".$Datos2[0]."' and CAREA='".$CODAREA."'";
							$Resp=mysqli_query($link,$Consulta);
							if(!$Fila=mysqli_fetch_array($Resp))
							{
								$Consulta="select max(CIDCONTROL+1) as maximo from sgrs_sipercontroles_obs ";
								$Resp=mysqli_query($link,$Consulta);
								if($Fila=mysqli_fetch_array($Resp))
								{
									if($Fila[maximo]=='')
										$TxtVeriObs='1';
									else		
										$TxtVeriObs=$Fila[maximo];
								}
								
								$Inserta="INSERT INTO sgrs_sipercontroles_obs  (CIDCONTROL,CCONTROL,CPELIGRO,TOBSERVACION,CAREA,CCONTACTO)";
								$Inserta.=" values('".$TxtVeriObs."','".$Datos2[0]."','".$CodPel."','".$Datos2[2]."','".$CODAREA."','".$CodCC."')";		
								//echo $Inserta."<br>";
								//mysqli_query($link,$Inserta);
							}
						}
						
						$Obs=$CodPel.",".$CodCC.",".$Datos2[0].",".$Datos2[1].",,".$CODAREA;
						RegistroSiper(15,$CookieRut,'GC',$Obs);

						$Consulta="select * from sgrs_codcontactos where CCONTACTO='".$CodCC."'";
						$Resp=mysqli_query($link,$Consulta);
						$Fila=mysqli_fetch_array($Resp);
						$NOMCONTACT=$Fila[NCONTACTO];
						$Consulta="select NCONTROL,QPESOESP from sgrs_codcontroles where CCONTROL='".$Datos2[0]."'";
						$Resp=mysqli_query($link,$Consulta);
						$Fila=mysqli_fetch_array($Resp);
						$NOMCONTROL=$Fila[NCONTROL];
						

						$Obs='Se a Ingresado el Siguiente Familia de Control: '.$NOMCONTROL.' en el Peligro: '.$NOMCONTACT.', Observación: '.$Datos2[2].', Verificador: '.$NONVERI.' y Especificación de Control '.$Datos2[4].' de la Área: '.$NOMAREA.'';	
						InsertaHistorico($CookieRut,'20',$Obs,'',$ParentFun,'');//INSERTA ASIGNACION DE CONTROLES
					}
				}

			}
			//echo 		"datos OBS:    ".$DatosObsCtrl."<br>";
			$DatosObs=explode('//',$DatosObsCtrl);
			while(list($c,$v)=each($DatosObs))
			{
				$DatosObs2=explode('~',$v);
				if($DatosObs2[2]=='')
				{
					if($DatosObs2[0]!='')
					{
						$Consulta="select max(CIDCONTROL+1) as maximo from sgrs_sipercontroles_obs ";
						$Resp=mysqli_query($link,$Consulta);
						if($Fila=mysqli_fetch_array($Resp))
						{
							if($Fila[maximo]=='')
								$CodVeriObs='1';
							else		
								$CodVeriObs=$Fila[maximo];
						}
						$Inserta="INSERT INTO sgrs_sipercontroles_obs  (CIDCONTROL,CCONTROL,CPELIGRO,TOBSERVACION,CAREA,CCONTACTO)";
						$Inserta.=" values('".$CodVeriObs."','".$DatosObs2[1]."','".$CodPel."','".trim($DatosObs2[0])."','".$CODAREA."','".$CodCC."')";		
						//echo $Inserta."<br>";
						mysqli_query($link,$Inserta);
					}
				}
				else
				{
					$Actualizar="update sgrs_sipercontroles_obs set TOBSERVACION='".trim($DatosObs2[0])."' where CIDCONTROL='".$DatosObs2[2]."'";
					mysqli_query($link,$Actualizar);	
					//echo $Actualizar."<br>";
				}
			
			}

			if($AplicoCtrl==true)
			{
				//echo "aplica control<br>";
				$PC=PC_Controles(1,$PC,$CodPel);
				$CC=PC_Controles(0,$CC,$CodPel);			
				$Actualizar="update sgrs_siperpeligros set QPC='".$PC."', QCC='".$CC."' where CPELIGRO='".$CodPel."' and CAREA='".$CODAREA."'";
				mysqli_query($link,$Actualizar);
				CalculoMR($CodCC,$CodPel,&$PH,&$CH,&$MRi,&$PC,&$CC,&$MR,&$Descrip,&$Semaforo);
				$Actualizar="update sgrs_siperpeligros set QMR='".$MR."',QPC='".$PC."', QCC='".$CC."',QMRH='".$MRi."' where CPELIGRO='".$CodPel."' and CAREA='".$CODAREA."'";
				mysqli_query($link,$Actualizar);
				//echo $Actualizar;
			}
			else
			{
				$Actualizar="update sgrs_siperpeligros set QMR='0',QPC='0', QCC='0',QMRH='0' where CPELIGRO='".$CodPel."' and CAREA='".$CODAREA."'";
				//echo  "apicaCtrl: False:        ".$Actualizar."<br>";
				mysqli_query($link,$Actualizar);
			}	
			echo "<script languaje=javascript>";
			echo "top.frames['Procesos'].location='procesos_organica.php?TipoPestana=3&CmbPeligros=".$CodPel."&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;";
			echo "</script>";
		break;
		case "GVP"://AGREGAR VERIFICADOR PARA PELIGRO
			$Consulta="select QPROBHIST,QCONSECHIST from sgrs_codcontactos where CCONTACTO ='".$CodContacto."'";
			$Resultado=mysqli_query($link,$Consulta);
			$PH=$Fila[QPROBHIST];		
			$Consulta="select CCONTACTO from sgrs_siperpeligros where CPELIGRO='".$CodPel."'";
			$Resp=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$CodCC=$Fila[CCONTACTO];
			$ParentFun=$Parent;
			$CODAREA=ObtenerCodParent(&$Parent);
			//SACO EL AREA EN LA QUE SE TRABAJA
			$Consulta="select * from sgrs_areaorg where CAREA='".$CODAREA."'";
			$Resp=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$NOMAREA=$Fila[NAREA];
			$AplicoCtrl=false;	
			//echo 		"datos:    ".$DatosCtrl."<br>";
			$Eliminar="delete from sgrs_siperverificadores where CCONTACTO='".$CodCC."' and CPELIGRO='".$CodPel."'";
			mysqli_query($link,$Eliminar);
			$Datos=explode('//',$DatosCtrl);
			while(list($c,$v)=each($Datos))
			{
				$Datos2=explode('~@~',$v);
				//echo $Datos2[1]."<br>";
				if($Datos2[1]!='NA')
					$AplicoCtrl=true;
					//echo "No existe<br>";
				if($Datos2[1]!='NA')//NO APLICA NO SE INSERTAR
				{
					$Insertar="insert into sgrs_siperverificadores(CIDVERIFICADOR,COD_VERIFICADOR,CCONTACTO,CPELIGRO,FVERIFICADOR,CAREA) values ";
					$Insertar.="('".$Datos2[0]."','".$Datos2[0]."','".$CodCC."','".$CodPel."','".date('Y-m-d')."','".$CODAREA."')";
					//echo "No Existe Graba:    ".$Insertar."<br>";
					mysqli_query($link,$Insertar);
					$Obs=$CodPel.",".$CodCC.",".$Datos2[0].",".$Datos2[1].",,".$CODAREA;
					RegistroSiper(15,$CookieRut,'GC',$Obs);

					if($Datos2[2]!='')
					{
						$Consulta="select * from sgrs_siperverificadores_obs where TOBSERVACION='".$Datos2[2]."' and COD_VERIFICADOR='".$Datos2[0]."' and CAREA='".$CODAREA."'";
						$Resp=mysqli_query($link,$Consulta);
						if(!$Fila=mysqli_fetch_array($Resp))
						{
							$Consulta="select max(CIDVERIFICADOR+1) as maximo from sgrs_siperverificadores_obs ";
							$Resp=mysqli_query($link,$Consulta);
							if($Fila=mysqli_fetch_array($Resp))
							{
								if($Fila[maximo]=='')
									$TxtVeriObs='1';
								else		
									$TxtVeriObs=$Fila[maximo];
							}
							
							$Inserta="INSERT INTO sgrs_siperverificadores_obs  (CIDVERIFICADOR,COD_VERIFICADOR,CPELIGRO,TOBSERVACION,CAREA,CCONTACTO)";
							$Inserta.=" values('".$TxtVeriObs."','".$Datos2[0]."','".$CodPel."','".$Datos2[2]."','".$CODAREA."','".$CodCC."')";		
							//mysqli_query($link,$Inserta);
						}
					}

					$Consulta="select * from sgrs_codcontactos where CCONTACTO='".$CodCC."'";
					$Resp=mysqli_query($link,$Consulta);
					$Fila=mysqli_fetch_array($Resp);
					$NOMCONTACT=$Fila[NCONTACTO];
					$Consulta="select NCONTROL,QPESOESP from sgrs_codcontroles where CCONTROL='".$Datos2[0]."'";
					$Resp=mysqli_query($link,$Consulta);
					$Fila=mysqli_fetch_array($Resp);
					$NOMCONTROL=$Fila[NCONTROL];
					$Consulta="select * from sgrs_tipo_verificador where COD_VERIFICADOR='".$Datos2[0]."'";
					//echo $Consulta."<br>";
					$Respuesta=mysqli_query($link,$Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$NONVERI=$Fila[DESCRIP_VERIFICADOR];
					

					$Obs='Se a Ingresado el Siguiente Familia de Verificador: '.$NONVERI.' en el Peligro: '.$NOMCONTACT.'';	
					//echo $Obs."<br>";
					InsertaHistorico($CookieRut,'24',$Obs,'',$ParentFun,'');//INSERTA ASIGNACION DE CONTROLES
				}
			}
			$DatosObs=explode('//',$DatosObsCtrl);
			while(list($c,$v)=each($DatosObs))
			{
				$DatosObs2=explode('~',$v);
				if($DatosObs2[2]=='')
				{
					if($DatosObs2[0]!='')
					{
						$Consulta="select max(CIDVERIFICADOR+1) as maximo from sgrs_siperverificadores_obs ";
						$Resp=mysqli_query($link,$Consulta);
						if($Fila=mysqli_fetch_array($Resp))
						{
							if($Fila[maximo]=='')
								$CodVeriObs='1';
							else		
								$CodVeriObs=$Fila[maximo];
						}
						$Inserta="INSERT INTO sgrs_siperverificadores_obs  (CIDVERIFICADOR,COD_VERIFICADOR,CPELIGRO,TOBSERVACION,CAREA,CCONTACTO)";
						$Inserta.=" values('".$CodVeriObs."','".$DatosObs2[1]."','".$CodPel."','".$DatosObs2[0]."','".$CODAREA."','".$CodCC."')";		
						//echo $Inserta."<br>";
						mysqli_query($link,$Inserta);
					}
				}
				else
				{
					$Actualizar="update sgrs_siperverificadores_obs set TOBSERVACION='".$DatosObs2[0]."' where CIDVERIFICADOR='".$DatosObs2[2]."'";
					mysqli_query($link,$Actualizar);	
					//echo $Actualizar."<br>";
				}
			
			}
			echo "<script languaje=javascript>";
			echo "top.frames['Procesos'].location='procesos_organica.php?TipoPestana=2&CmbPeligros=".$CodPel."&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;";
			echo "</script>";
		break;
		case "EV"://ELIMINAR VERIFICADORES
			$ParentFun=$Parent;
			$CODAREA=ObtenerCodParent(&$Parent);
			//RegistroSiper(15,$CookieRut,'ECT',$CodPel);
			$Eliminar="delete from sgrs_siperverificadores where CPELIGRO='".$CodPel."'";
			//echo $Eliminar."<br>";
			mysqli_query($link,$Eliminar);
			$Eliminar="delete from sgrs_siperverificadores_obs where CPELIGRO='".$CodPel."' and CAREA='".$CODAREA."'";
			//echo $Eliminar."<br>";
			mysqli_query($link,$Eliminar);

			echo "<script languaje=javascript>";
			//echo "top.frames['Procesos'].location='procesos_organica.php?TipoPestana=2&CmbPeligros=".$CodPel."&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;";
			echo "top.frames['Procesos'].location='procesos_organica.php?TipoPestana=2&CmbPeligros=S&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;";
			echo "</script>";		
		break;
		case "EC"://ELIMINAR CONTROLES
			$ParentFun=$Parent;
			$CODAREA=ObtenerCodParent(&$Parent);
			RegistroSiper(15,$CookieRut,'ECT',$CodPel);
			$Eliminar="delete from sgrs_sipercontroles where CPELIGRO='".$CodPel."'";
			//echo $Eliminar."<br>";
			mysqli_query($link,$Eliminar);
			$Eliminar="delete from sgrs_sipercontroles_obs where CPELIGRO='".$CodPel."' and CAREA='".$CODAREA."'";
			//echo $Eliminar."<br>";
			mysqli_query($link,$Eliminar);
			$Actualizar="update sgrs_siperpeligros set QPC=NULL, QCC=NULL where CPELIGRO='".$CodPel."' and CAREA='".$CODAREA."'";
			mysqli_query($link,$Actualizar);					
			//echo $Actualizar."<br>";
			$Consulta="select * from sgrs_areaorg where CAREA='".$CODAREA."'";
			$Resp=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$NOMAREA=$Fila[NAREA];
			$Consulta="select * from sgrs_codcontactos where CCONTACTO='".$CodCC."'";
			$Resp=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$NOMCONTACT=$Fila[NCONTACTO];

			$Obs='Se a Eliminan Los Controles Asociados al Peligro '.$NOMCONTACT.' del Área: '.$NOMAREA.'';	
			//echo $ObsEli."<br>";
			InsertaHistorico($CookieRut,'22',$Obs,'',$ParentFun,$ObsEli);//INSERTA ASIGNACION DE CONTROLES

			echo "<script languaje=javascript>";
			echo "top.frames['Procesos'].location='procesos_organica.php?TipoPestana=3&CmbPeligros=S&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;";
			echo "</script>";		
		break;
		case "VFIP"://VALIDAR FIN IDENTIFICACION DE PELIGROS
			$ParentFun=$Parent;
			$CODAREA=ObtenerCodParent(&$Parent);	

			$CONTACTOS=explode('~',$CODCONT);
			$NOTIENECONTROLES='N';	
			while(list($c,$v)=each($CONTACTOS))
			{
				$Consulta="select * from sgrs_sipercontroles where CAREA='".$CODAREA."' and CCONTACTO='".$v."'";
				$Resp=mysqli_query($link,$Consulta);
				if(!$Fila=mysqli_fetch_array($Resp))
				{
					$NOTIENECONTROLES='S';									
					break;
				}	
			}
			if($NOTIENECONTROLES!='S')// QUE UN CONTROL NO TENGA
			{
				$Actualizar="update sgrs_siperoperaciones set MIDENTIFICADO='1' where CAREA='".$CODAREA."'";
				//echo $Actualizar."<br>";
				mysqli_query($link,$Actualizar);	
				$Consulta="select * from sgrs_areaorg where CAREA='".$CODAREA."'";
				$Resp=mysqli_query($link,$Consulta);
				$Fila=mysqli_fetch_array($Resp);
				$NOMAREA=$Fila[NAREA];
	
				$Consulta="select AVISO_CORREO,AVISO_CORREO2,RUT_JEFE,RUT_EXPERTO from sgrs_acceso_organica where RUT='".	$CookieRut."'";
				//echo $Consulta."<br>";
				$Resp=mysqli_query($link,$Consulta);
				if($Fila=mysqli_fetch_array($Resp))
				{
					if($Fila[AVISO_CORREO]!='')
					{
						//echo $Fila[RUT_JEFE];
						EnvioCorreo($Fila[AVISO_CORREO],$ParentFun,$CookieRut,'1',$Fila[RUT_JEFE]);//jefe area		
					}	
					if($Fila[AVISO_CORREO2]!='')
					{
						//echo $Fila[RUT_EXPERTO];
						EnvioCorreo($Fila[AVISO_CORREO2],$ParentFun,$CookieRut,'2',$Fila[RUT_EXPERTO]);//experto		
					}	
				}	
	
				$Obs='A Finalizado identificación de Peligros Para la Tarea: '.$NOMAREA.'.';	
				InsertaHistorico($CookieRut,'23',$Obs,'',$ParentFun,'');//FINALIZACION DE PELIGROS

				echo "<script languaje=javascript>";
				echo "top.frames['Procesos'].location='procesos_organica.php?TipoPestana=4&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;";
				echo "</script>";
			}
			else
			{
				echo "<script languaje=javascript>";
				echo "top.frames['Procesos'].location='procesos_organica.php?TipoPestana=4&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+'&MsjN=1';";
				echo "</script>";
			}
		break;			
		case "VT"://VALIDAR TAREAS
			$CODAREA=ObtenerCodParent(&$Parent);

			$Actualizar="update sgrs_siperoperaciones set MVALIDADO='1', FECHA_HORA_VAL='".date('Y-m-s H:m:s')."' where CAREA='".$CODAREA."'";
			//echo $Actualizar."<br>";
			mysqli_query($link,$Actualizar);	
			$Actualizar2="update sgrs_areaorg set FAREA='".date('Y-m-d')."' where CAREA='".$CODAREA."'";
			//echo $Actualizar2."<br>";
			mysqli_query($link,$Actualizar2);	
			$Consulta="select * from sgrs_areaorg where CAREA='".$CODAREA."'";
			$Resp=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$NAREA=$Fila[NAREA];
			
			$Obs="Se a Validado Tarea ".$NAREA."";	
			InsertaHistorico($CookieRut,'26',$Obs,'','','');
					
			echo "<script languaje=javascript>";
			echo "top.frames['Procesos'].location='procesos_operaciones.php?TipoPestana=1&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;";
			echo "</script>";		
		break;
		case "DVT"://DESVALIDAR TAREAS
			$CODAREA=ObtenerCodParent(&$Parent);

			$Actualizar="update sgrs_siperoperaciones set MVALIDADO='0', FECHA_HORA_VAL='' where CAREA='".$CODAREA."'";
			//echo $Actualizar."<br>";
			mysqli_query($link,$Actualizar);			

			$Actualizar2="update sgrs_areaorg set FAREA='".date('Y-m-d')."' where CAREA='".$CODAREA."'";
			//echo $Actualizar2."<br>";
			mysqli_query($link,$Actualizar2);	

			$Consulta="select * from sgrs_areaorg where CAREA='".$CODAREA."'";
			$Resp=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$NAREA=$Fila[NAREA];
			$Obs="Se a DesValidado Tarea ".$NAREA."";	
			InsertaHistorico($CookieRut,'27',$Obs,'','','');

			echo "<script languaje=javascript>";
			echo "top.frames['Procesos'].location='procesos_operaciones.php?TipoPestana=1&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;";
			echo "</script>";		
		break;
		case "DVP"://DESVALIDA EL PELIGRO
				$Actualizar="update sgrs_siperpeligros set MVALIDADO='0', MR1='0', MR2='0' where CAREA='".$CAREA."' and CPELIGRO='".$CodPeli."'";
				//echo $Actualizar."<br>";
				mysqli_query($link,$Actualizar);
				echo "<script languaje=javascript>";
				echo "top.frames['Procesos'].location='procesos_operaciones.php?TipoPestana=1&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;";
				echo "</script>";		
		break;
		//**********************PROCESOS PARA SISTEMA HIGIENE INDUSTRIAL HI**********************
		case "NMP"://NUEVA MEDICION PERSONAL
			$Informe=explode('~#',$CmbInformes);
			$Insertar="insert into sgrs_medpersonales(QMEDICION,QMR,QDOSIS,FINICIO,FTERMINO,CRUT,CAGENTE,CINFORME,COCUPACION,TOBSERVACION,QLPP,CAREA,REGACCIONES) values ";
			$Insertar.="(".str_replace(',','.',ValidaEntero($TxtMag)).",'".$MR."',".str_replace(',','.',$TxtDosis).",'".FormatoFechaAAAAMMDD($TxtFechaIni)." ".$TxtHoraIni."','".FormatoFechaAAAAMMDD($TxtFechaFin)." ".$TxtHoraFin."','".$CmbFun."',".intval($CmbAgentes).",'".intval($Informe[0])."',".intval($CmbOcupacion).",'".$TxtObs."',".intval($TxtQLPP).",".$CodNivel.",'".$TxtAccion."')";
			//echo $Insertar."<br>";
			mysqli_query($link,$Insertar);
			header('location:procesos_hi.php?TipoPestana=1');
		break;
		case "MMP"://MODIFICAR MEDICION PERSONAL
			$Informe=explode('~#',$CmbInformes);
			$Actualizar="update sgrs_medpersonales set QMEDICION=".str_replace(',','.',ValidaEntero($TxtMag)).",QMR='".$MR."',QDOSIS=".str_replace(',','.',$TxtDosis).",FINICIO='".FormatoFechaAAAAMMDD($TxtFechaIni)." ".$TxtHoraIni."',FTERMINO='".FormatoFechaAAAAMMDD($TxtFechaFin)." ".$TxtHoraFin."',";
			$Actualizar.="CAGENTE=".intval($CmbAgentes).",CINFORME='".intval($Informe[0])."',COCUPACION=".intval($CmbOcupacion).",TOBSERVACION='".$TxtObs."',QLPP=".intval($TxtQLPP).",CAREA='".$CodNivel."',REGACCIONES='".$TxtAccion."' where CMEDPERSONAL='".$CodMedPers."'";
			//echo $Actualizar."<br>";
			mysqli_query($link,$Actualizar);
			header('location:procesos_hi.php?TipoPestana=1');
		break;
		case "EMP"://ELIMINAR MEDICION PERSONAL
			$Mensaje='Datos Eliminados Existosamente';
			$Datos = explode("//",$DatosMedPer);
			while(list($clave,$Codigo)=each($Datos))
			{
				RegistroHi(11,$CookieRut,'EMP',$Codigo);
				$Eliminar="delete from sgrs_medpersonales where CMEDPERSONAL='".$Codigo."'";
				mysqli_query($link,$Eliminar);
				//echo $Eliminar."<br>";
			}
			header('location:procesos_hi.php?TipoPestana=1&Msj='.$Mensaje);
		break;
		case "NMA"://NUEVA MEDICION AMBIENTAL
			$Informe=explode('~#',$CmbInformes);
			$Insertar="insert into sgrs_medambientes(FINICIO,FTERMINO,QMEDICION,QMR,CLUGAR,CAGENTE,CINFORME,TOBSERVACION,QLPP,CAREA,QDOSIS,REGACCIONES) values ";
			$Insertar.="('".FormatoFechaAAAAMMDD($TxtFechaIni)." ".$TxtHoraIni."','".FormatoFechaAAAAMMDD($TxtFechaFin)." ".$TxtHoraFin."',".str_replace(',','.',ValidaEntero($TxtMag)).",'".$MR."',".intval($CmbLugares).",".intval($CmbAgentes).",'".intval($Informe[0])."','".$TxtObs."',".intval($TxtQLPP).",".$CodNivel.",'".str_replace(',','.',ValidaEntero($TxtDosis))."','".$TxtAccion."')";
			mysqli_query($link,$Insertar);
			header('location:procesos_hi.php?TipoPestana=2');
		break;
		case "MMA"://MODIFICAR MEDICION AMBIENTAL
			$Informe=explode('~#',$CmbInformes);
			$Actualizar="update sgrs_medambientes set QMEDICION=".str_replace(',','.',ValidaEntero($TxtMag)).",QMR='".$MR."',CLUGAR=".intval($CmbLugares).",FINICIO='".FormatoFechaAAAAMMDD($TxtFechaIni)." ".$TxtHoraIni."',FTERMINO='".FormatoFechaAAAAMMDD($TxtFechaFin)." ".$TxtHoraFin."',";
			$Actualizar.="CAGENTE=".intval($CmbAgentes).",CINFORME='".intval($Informe[0])."',TOBSERVACION='".$TxtObs."',QLPP=".intval($TxtQLPP).",CAREA='".$CodNivel."',QDOSIS='".str_replace(',','.',ValidaEntero($TxtDosis))."',REGACCIONES='".$TxtAccion."' where CMEDAMB='".$DatosMed."'";
			//echo $Actualizar."<br>";
			mysqli_query($link,$Actualizar);
			header('location:procesos_hi.php?TipoPestana=2');
		break;
		case "EMA"://ELIMINAR MEDICION AMBIENTAL
			$Mensaje='Datos Eliminados Existosamente';
			$Datos = explode("//",$DatosMedAmb);
			while(list($clave,$Codigo)=each($Datos))
			{
				RegistroHi(12,$CookieRut,'EMA',$Codigo);
				$Eliminar="delete from sgrs_medambientes where CMEDAMB='".$Codigo."'";
				mysqli_query($link,$Eliminar);
				//echo $Eliminar."<br>";
			}
			header('location:procesos_hi.php?TipoPestana=2&Msj='.$Mensaje);
		break;
		case "NEL"://NUEVO EXAMEN LABORATORIO
			$Informe=explode('~#',$CmbInformes);
			$Insertar="insert into sgrs_exlaboratorio(CRUT,FEXAMEN,CTEXAMEN,QVALOR,QPERIODICIDAD,CEVALUACION,TOBSERVACION,CINFORME,COCUPACION,REGACCIONES) values ";
			$Insertar.="('".$CmbFun."','".FormatoFechaAAAAMMDD($TxtFechaIni)."',".intval($CmbTipoExamen).",".str_replace(',','.',ValidaEntero($TxtValor)).",'".ValidaEntero($TxtPeriocidad)."',".intval($CmbEvaluacion).",'".$TxtObs."','".intval($Informe[0])."',".intval($CmbOcupacion).",'".$TxtAccion."')";
			//echo $Insertar."<br>";
			mysqli_query($link,$Insertar);
			header('location:procesos_hi.php?TipoPestana=3');
		break;
		case "MEL"://MODIFICAR EXAMEN LABORATORIO
			$Informe=explode('~#',$CmbInformes);
			$Actualizar="update sgrs_exlaboratorio set QVALOR=".str_replace(',','.',ValidaEntero($TxtValor)).",QPERIODICIDAD='".ValidaEntero($TxtPeriocidad)."',CTEXAMEN=".intval($CmbTipoExamen).",FEXAMEN='".FormatoFechaAAAAMMDD($TxtFechaIni)."',";
			$Actualizar.="CEVALUACION=".intval($CmbEvaluacion).",TOBSERVACION='".$TxtObs."',CINFORME='".intval($Informe[0])."',COCUPACION=".intval($CmbOcupacion).",REGACCIONES='".$TxtAccion."' where CEXAMEN='".$DatosMed."'";
			//echo $Actualizar."<br>";
			mysqli_query($link,$Actualizar);
			header('location:procesos_hi.php?TipoPestana=3');
		break;
		case "EEL"://ELIMINAR EXAMEN LABORATORIO
			$Mensaje='Datos Eliminados Existosamente';
			$Datos = explode("//",$DatosMed);
			while(list($clave,$Codigo)=each($Datos))
			{
				RegistroHi(13,$CookieRut,'EEL',$Codigo);
				$Eliminar="delete from sgrs_exlaboratorio where CEXAMEN='".$Codigo."'";
				mysqli_query($link,$Eliminar);
				//echo $Eliminar."<br>";
			}
			header('location:procesos_hi.php?TipoPestana=3&Msj='.$Mensaje);
		break;
		case "ALUG"://NUEVO LUGAR DE MEDICION
			$ParentAux=substr($Parent,0,strlen($Parent)-1);
			$CODAREA=ObtenerCodParent(&$Parent);
			$Insertar="insert into sgrs_lugares(NLUGAR,QALTGEOGRAFICA,CCORDX,CCORDY,CCORDZ,CAREA,MVIGENTE) values ";
			$Insertar.="('".$Descrip."',0,'".$CX."','".$CY."','".$CZ."','".$CODAREA."','".$Vigente."')";
			//echo $Insertar."<br>";
			mysqli_query($link,$Insertar);
						
			echo "<script languaje=javascript>";
			echo "top.frames['Procesos'].location='procesos_lugares.php';";
			echo "top.frames['Organica'].BuscaItem2('".$Parent."','');";
			echo "</script>";
		break;
		case "MLUG"://MODIFICAR LUGAR MEDICION
			$Actualizar="update sgrs_lugares set NLUGAR='".$Descrip."',CCORDX='".$CX."',CCORDY='".$CY."',CCORDZ='".$CZ."',";
			$Actualizar.="MVIGENTE='".$Vigente."' where CLUGAR='".$DatosLugar."'";
			//echo $Actualizar."<br>";
			mysqli_query($link,$Actualizar);

			echo "<script languaje=javascript>";
			echo "top.frames['Procesos'].location='procesos_lugares.php';";
			echo "top.frames['Organica'].BuscaItem2('".$Parent."','');";
			echo "</script>";
		break;
		case "ELUG"://ELIMINAR LUGAR MEDICION
			$Mensaje='';$DatosRel='N';
			$Datos = explode("//",$DatosLugar);
			while(list($clave,$Codigo)=each($Datos))
			{
				$Consulta="select * from sgrs_medambientes where CLUGAR='".$Codigo."'";
				$Resp=mysqli_query($link,$Consulta);
				if($Fila=mysqli_fetch_array($Resp))
					$DatosRel='S';
				if($DatosRel=='N')
				{
					RegistroHi(10,$CookieRut,'ELUG',$Codigo);
					$Eliminar="delete from sgrs_lugares where CLUGAR='".$Codigo."'";
					mysqli_query($link,$Eliminar);
					//echo $Eliminar."<br>";
					$Mensaje='Datos Eliminados Existosamente';
				}	
				else
				{
					$Mensaje='No se puede Eliminar Lugar de Medición, Existen Mediciones asociadas';
					echo "<script languaje=javascript>";
					echo "alert('".$Mensaje."');";
					echo "</script>";
				}	
			}
			echo "<script languaje=javascript>";
			echo "top.frames['Procesos'].location='procesos_lugares.php';";
			echo "top.frames['Organica'].BuscaItem2('".$Parent."','');";
			echo "</script>";
		break;
				
	}
	
function EnvioCorreo($Correo,$CodSelTarea,$Rut,$MRCAL,$RUT_JE_EX)	
{	
	$CODAREA=ObtenerCodParent($CodSelTarea);	
	$Consulta="select * from sgrs_areaorg where CAREA='".$CODAREA."'";
	$Resp=mysqli_query($link,$Consulta);
	$Fila=mysqli_fetch_array($Resp);
	$NOMAREA=$Fila[NAREA];

	$Asunto='Solicitud de validación tarea '.$NOMAREA.'';
	$Titulo='SASSO - Sistema de Aseguramiento de Seguridad y Salud Ocupacional';	
	$Consulta="select * from proyecto_modernizacion.funcionarios where rut='".$Rut."'";
	$Resul=mysqli_query($link,$Consulta);
	if($Fila=mysqli_fetch_array($Resul))
		$Nombre="<strong>".$Fila[apellido_paterno]." ".$Fila[apellido_materno]." ".$Fila[nombres]."</strong>";
	$Mensaje="<font face='Arial, Helvetica, sans-serif' size='2'>El Usuario ".strtoupper($Nombre)." a finalizado la identificación  de peligros de la Tarea ".$NOMAREA.", para su Validación.</font>";	
         
		 $Mensaje.="<table width='100%' border='1' cellpadding='0' cellspacing='0' align='left'>";
			$Mensaje.="<tr>";
				$Mensaje.="<td width='10%' bgcolor='#CCCCCC' align='center' ><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>Peligro</font></td>";
				$Mensaje.="<td width='10%' bgcolor='#CCCCCC' align='center'><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>Descripción</font></td>";
				$Mensaje.="<td align='center' width='2%' bgcolor='#CCCCCC' ><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>MRi</font></td>";
				$Mensaje.="<td align='left' width='30%' bgcolor='#CCCCCC' ><table width='100%' border='1' cellspacing='0' cellpadding='0'><tr><td width='70%'><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>Famila de Controles</font></td><td width='30%'><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>Especificación</font></td></tr></font></table></td>";
				$Mensaje.="<td width='35%' bgcolor='#CCCCCC'><table width='100%' border='1' cellspacing='0' cellpadding='0'><tr><td width='70%'><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>Famila de Verificadores</font></td><td width='30%'><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>Especificación</font></td></tr></font></table></td>";
				$Mensaje.="<td width='4%' bgcolor='#CCCCCC' ><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>MRr</font></td>";
				//$Mensaje.="<td width='3%' bgcolor='#CCCCCC' align='center'><font face='Arial, Helvetica, sans-serif' color='#9c3031' size='1'>Val</font></td>";
			 $Mensaje.="</tr>";

			$Consulta="select t2.NCONTACTO,t1.TOBSERVACION,t1.CPELIGRO,t1.CCONTACTO,t1.MVALIDADO,t1.QPROBHIST,t1.QCONSECHIST from sgrs_siperpeligros t1 inner join sgrs_codcontactos t2 on t1.CCONTACTO=t2.CCONTACTO where t1.MVIGENTE<>'0' and t1.CAREA ='".$CODAREA."' group by t1.CPELIGRO order by NCONTACTO";
			//echo $Consulta;
			$Resultado=mysqli_query($link,$Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$PH='';$CH='';$PC='';$CC='';$Validado='';
				if($Fila[MVALIDADO]=='1')
					$Validado='SI';
				CalculoMR($Fila[CCONTACTO],$Fila[CPELIGRO],&$PH,&$CH,&$MRi,&$PC,&$CC,&$MR,&$Descrip,&$Semaforo);
				CalculoMRI($Fila[QPROBHIST],$Fila[QCONSECHIST],&$DESMRI,&$SEMAMRI);							
				$Mensaje.="<tr>";
				$Mensaje.="<td align='left' width='25%'><font face='Arial, Helvetica, sans-serif' size='1'>".$Fila[NCONTACTO]."</font></td>";
				$Mensaje.="<td align='center' width='15%'><font face='Arial, Helvetica, sans-serif' size='1'>&nbsp;".$Fila[TOBSERVACION]."</font></td>";
				if($Descrip!='NO CALCULADO')
					$Mensaje.="<td align='center'>".$DESMRI."</td>";
				else
					$Mensaje.="<td align='left'>&nbsp;</td>";	
				$Mensaje.="<td align='left' width='40%'>";
				if($Descrip!="ACEPTABLE"&&$Descrip!="MODERADO"&&$Descrip!="INACEPTABLE")
					$Descrip=$Descrip;
					
				$Mensaje.="<table width='100%' border='1' cellspacing='0' cellpadding='0'>";
					$Consulta="select t2.NCONTROL,t1.CCONTROL,t3.ATCONTROLES from sgrs_sipercontroles t1";
					$Consulta.=" inner join sgrs_codcontroles t2 on t1.CCONTROL=t2.CCONTROL inner join sgrs_tipo_controles t3 on t1.MCONTROL=t3.CTCONTROLES";
					$Consulta.=" where t1.CPELIGRO ='".$Fila[CPELIGRO]."'";
					//echo $Consulta."<br>";
					$RespCtrl=mysqli_query($link,$Consulta);
					while($FilaCtrl=mysqli_fetch_array($RespCtrl))
					{
						$Mensaje.="<tr>";
						$ConsuOBS="select * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";
						$RespOBS=mysqli_query($link,$ConsuOBS);$Rows=0;
						while($FilaOBS=mysqli_fetch_array($RespOBS))
							$Rows=$Rows+1;
						$Mensaje.="<td rowspan='".$Rows."' align='left' width='70%'><font face='Arial, Helvetica, sans-serif' size='1'>".$FilaCtrl[CCONTROL]." - ".$FilaCtrl[NCONTROL]."</font>&nbsp;&nbsp;&nbsp;</td>";
						$ConsuOBS="select * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";
						$RespOBS=mysqli_query($link,$ConsuOBS);
						if($FilaOBS=mysqli_fetch_array($RespOBS))
						{
							$ConsuOBS="select * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila[CPELIGRO]."' and CCONTROL='".$FilaCtrl[CCONTROL]."'";
							$RespOBS=mysqli_query($link,$ConsuOBS);
							while($FilaOBS=mysqli_fetch_array($RespOBS))
							{
								$Mensaje.="<td align='left' width='30%'><font face='Arial, Helvetica, sans-serif' size='1'>".$FilaOBS[TOBSERVACION]."</font>&nbsp;</td>";
								$Mensaje.="</tr>";
							}	
						}
						else
							$Mensaje.="<td align='left' width='30%'>&nbsp;</td>";
					}
					$Mensaje.="</table>";
					$Mensaje.="</td>";
					$Mensaje.="<td><br>";
					$ConsuVeri="select * from sgrs_siperverificadores t1 inner join sgrs_tipo_verificador t2 on t1.COD_VERIFICADOR=t2.COD_VERIFICADOR where CPELIGRO='".$Fila[CPELIGRO]."' order by t1.COD_VERIFICADOR";
					$RespVeri=mysqli_query($link,$ConsuVeri);
					if($FilaVeri=mysqli_fetch_array($RespVeri))
					{
						$Mensaje.="<table width='100%' border='1' cellspacing='0' cellpadding='0'>";														
						$ConsuVeri="select * from sgrs_siperverificadores t1 inner join sgrs_tipo_verificador t2 on t1.COD_VERIFICADOR=t2.COD_VERIFICADOR where CPELIGRO='".$Fila[CPELIGRO]."' order by t1.COD_VERIFICADOR";
						$RespVeri=mysqli_query($link,$ConsuVeri);
						while($FilaVeri=mysqli_fetch_array($RespVeri))
						{
							$Mensaje.="<tr>";
							$ConsuOBS="select * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
							$RespOBS=mysqli_query($link,$ConsuOBS);$Rows=0;
							while($FilaOBS=mysqli_fetch_array($RespOBS))
								$Rows=$Rows+1;
							$ConsuOBS="select * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
							$RespOBS=mysqli_query($link,$ConsuOBS);
							if($FilaOBS=mysqli_fetch_array($RespOBS))
							{
								$Mensaje.="<td rowspan='".$Rows."' align='left' width='70%'><font face='Arial, Helvetica, sans-serif' size='1'>".$FilaVeri[DESCRIP_VERIFICADOR]."</font>&nbsp;&nbsp;&nbsp;</td>";
								$ConsuOBS="select * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
								$RespOBS=mysqli_query($link,$ConsuOBS);
								while($FilaOBS=mysqli_fetch_array($RespOBS))
								{
									$Mensaje.="<td align='left' width='30%'><font face='Arial, Helvetica, sans-serif' size='1'>".$FilaOBS[TOBSERVACION]."</font>&nbsp;</td>";
									$Mensaje.="</tr>";
								}	
							}
						}
						$Mensaje.="</table>";
	
					}
					else
					{
						$Mensaje.="<table width='100%' border='0' cellspacing='0' cellpadding='0'>";														
						$Mensaje.="<tr>";
						$Mensaje.="<td coslpan='2' align='left'><font face='Arial, Helvetica, sans-serif' size='1'>SIN VERIFICADORES</font></td>";
						$Mensaje.="</tr>";
						$Mensaje.="</table>";
					}					
					$Mensaje.="</td>";
				//$Mensaje.="</table>";
				//$Mensaje.="</td>";
/*				echo "<td align='center' width='3%'>".$PH."</td>";
				echo "<td align='center' width='3%'>".$CH."</td>";
				echo "<td align='center' width='3%'>".$PC."&nbsp;</td>";
				echo "<td align='center' width='3%'>".$CC."&nbsp;</td>";
*/				//$Mensaje.="<td align='center' width='4%'><font face='Arial, Helvetica, sans-serif' size='1'>".$Descrip."</font></td>";
				//$Mensaje.="<td align='center' width='5%'><font face='Arial, Helvetica, sans-serif' size='1'>".$Validado."&nbsp;</font></td>";
				$Mensaje.="</tr>";
			}
          $Mensaje.="</table>";

	$EnDecryptText = new EnDecryptText(); 
	
	/*DATOS ENCRIPTADOS*/
	//echo "RUT: ".$RUT_JE_EX."<br><br>";
	$User = $EnDecryptText->Encrypt_Text($RUT_JE_EX);
	//echo "USER: ".$User."<br>";
	$UserPrin = $EnDecryptText->Encrypt_Text($Rut);

	$ConsulServ="select * from proyecto_modernizacion.sub_clase where cod_clase='29001' and cod_subclase='1'";
	$RespServ=mysqli_query($link,$ConsulServ);
	$FilaServ=mysqli_fetch_array($RespServ);
	$NomServ=$FilaServ[nombre_subclase];
	
	$cuerpoMsj = '<html>';
	$cuerpoMsj.= '<head>';
	$cuerpoMsj.= '<title>'.$Titulo.'&nbsp;'.$MesCorreo.'&nbsp;'.$Ano.'</title>';
	$cuerpoMsj.= '</head>';
	$cuerpoMsj.= '<body>';
	$cuerpoMsj.= '<table  width="100%"  border="0" align="center">';
	$cuerpoMsj.= '<tr><td>';
	$cuerpoMsj.= ''.$Mensaje.'';
	$cuerpoMsj.= "<br><br>";
	$cuerpoMsj.= '</td></tr>';
	$cuerpoMsj.= '</table>';
	$cuerpoMsj.= '<table  width="100%"  border="0" align="center">';
	$cuerpoMsj.= '<tr><td>';
	$cuerpoMsj.= "<font face='Arial, Helvetica, sans-serif' size='2'>Seguir el link para realizar evaluación de la Magnitud de Riesgo Residual: <a href='http://".$NomServ."/proyecto/siper_web/proceso_magnitud_riesgo.php?CodSelTarea=".$CodSelTarea."&MRCAL=".$MRCAL."&U=".$User."&UPrin=".$UserPrin."'><font size='2'>MRr.</font></a>";
	//$cuerpoMsj.= "<font face='Arial, Helvetica, sans-serif' size='2'>Seguir el link para realizar evaluación de la Magnitud de Riesgo Residual: <a href='http://codelco.cl'><font size='2'>MRr.</font></a>";
	$cuerpoMsj.= "<br><br>";
	$cuerpoMsj.="Por Su Atención Muchas Gracias";
	$cuerpoMsj.= "<br>";
	$cuerpoMsj.="Servicio Automatico de Sistema de Aseguramiento de Seguridad y Salud Ocupacional Ventanas (SASSO)";
	$cuerpoMsj.= "<br>";
	$cuerpoMsj.= '</td></tr>';
	$cuerpoMsj.= '</table>';
	$cuerpoMsj.= '</body></html>';
	//echo $cuerpoMsj."<br>";
	$mail = new phpmailer();
	//$mail->AddEmbeddedImage("includes/logo_seti.jpg","logo","includes/logo_seti.jpg","base64","image/jpg");
	$mail->PluginDir = "includes/";
	$mail->Mailer = "smtp";
	$mail->Host = "VEFVEX03.codelco.cl";
	//$mail->From = "pfari002@codelco.cl";
	$mail->FromName = "SASSO - Sistema de Aseguramiento de Seguridad y Salud Ocupacional";
	$mail->Subject = $Asunto;
	$mail->Body=$cuerpoMsj;
	$mail->IsHTML(true);
	$mail->AltBody =str_replace('<br>','\n',$cuerpoMsj);
	$mail->AddAddress($Correo);	
	$mail->Timeout=120;
	//$mail->AddAttachment($Doc,$Doc);
	$exito = $mail->Send();
	$intentos=1; 
	while((!$exito)&&($intentos<5)&&($mail->ErrorInfo!="SMTP Error: Data not accepted")){
	sleep(5);
	$exito = $mail->Send();
	$intentos=$intentos+1;				
	}
	$mail->ClearAddresses();
}

?>