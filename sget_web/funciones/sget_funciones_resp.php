<?
	function edad($edad){
		list($anio,$mes,$dia) = explode("-",$edad);
		$anio_dif = date("Y") - $anio;
		$mes_dif = date("m") - $mes;
		$dia_dif = date("d") - $dia;
		if ($dia_dif < 0 || $mes_dif < 0)
		$anio_dif--;
		return $anio_dif;
	}
	function FormatoFechaAAAAMMDD($FechaReal)
	{
		//echo "fecha1".$FechaReal."<br>";
		if($FechaReal!='')
		{
			$Datos = explode("/",$FechaReal);
			$Dia=$Datos[2];
			$Mes=$Datos[1];
			$A�o=$Datos[0];
			$FechaFormat=$Dia.'-'.$Mes.'-'.$A�o;
			//echo "fecha2".$FechaFormat."<br>";
		}
		else
			$FechaFormat='0000-00-00';
		return ($FechaFormat);
	}
	function ValidaEntero($Cod)
	{
		if($Cod=='S'||$Cod=='')
			$Cod=0;
		else
			$Cod=$Cod;	
		return($Cod);
	}
	function DescripCtto($Ctto)
	{
		$Consulta="SELECT * from sget_contratos where cod_contrato='".$Ctto."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila["cod_contrato"].'~'.$Fila["descripcion"].'~'.$Fila[fecha_inicio].'~'.$Fila[fecha_termino].'~'.$Fila[cod_gerencia].'~'.$Fila[cod_area].'~'.$Fila[cod_tipo_contrato].'~'.$Fila[rut_prev];
		return($Descripcion);	
	}

	function DescripEmpresa($RutEmp)
	{
		$Consulta="SELECT * from sget_contratistas where rut_empresa='".$RutEmp."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[rut_empresa].'~'.$Fila[razon_social].'~'.$Fila[calle].'~'.$Fila[telefono_comercial].'~'.$Fila[mail_empresa].'~'.$Fila[cod_mutual_seguridad].'~'.$Fila[fecha_ven_cert];
		return($Descripcion);	
	}
	function AdmCttoCodelcoHR($HR)
	{
		$Consulta="SELECT t1.rut_adm_contrato,t1.nombres,t1.ape_paterno,t1.ape_materno,t1.telefono from sget_administrador_contratos t1 inner join sget_hoja_ruta_adm_ctto t2 on t1.rut_adm_contrato =t2.rut_adm_ctto where t2.num_hoja_ruta='".$HR."' ";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$AdmCodelco=$Fila[rut_adm_contrato].'~'.$Fila["nombres"].'~'.$Fila[ape_paterno].'~'.$Fila[ape_materno].'~'.$Fila[telefono];
		return($AdmCodelco);	
	}

	function AdmCttoCodelco($Ctto)
	{
		$Consulta="SELECT t1.rut_adm_contrato,t1.nombres,t1.ape_paterno,t1.ape_materno,t1.telefono from sget_administrador_contratos t1 inner join sget_contratos t2 on t1.rut_adm_contrato =t2.rut_adm_contrato where t2.cod_contrato='".$Ctto."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$AdmCodelco=$Fila[rut_adm_contrato].'~'.$Fila["nombres"].'~'.$Fila[ape_paterno].'~'.$Fila[ape_materno].'~'.$Fila[telefono];
		return($AdmCodelco);	
	}
	
	function AdmCttoContratista($Ctto)
	{
		$Consulta=" SELECT t1.rut_adm_contratista,t1.nombres,t1.ape_paterno,t1.ape_materno,t1.telefono,t1.email ";
		$Consulta.=" from sget_administrador_contratistas t1 inner join sget_contratos t2 ";
		$Consulta.=" on t1.rut_adm_contratista =t2.rut_adm_contratista where t2.cod_contrato='".$Ctto."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$AdmCodelco=$Fila[rut_adm_contratista].'~'.$Fila["nombres"].'~'.$Fila[ape_paterno].'~'.$Fila[ape_materno].'~'.$Fila[telefono].'~'.$Fila[email];
		return($AdmCodelco);	
	}
	function DescripTipoCtto($Cod)
	{
		$Consulta=" SELECT * from sget_tipo_contrato  ";
		$Consulta.="  where cod_tipo_contrato='".$Cod."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[descrip_tipo_contrato];
		return($Descripcion);	
	}
	function DescripcionMutual($Cod)
	{
		$Consulta=" SELECT * from sget_mutuales_seg  ";
		$Consulta.="  where cod_mutual='".$Cod."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila["abreviatura"];
		return($Descripcion);	
	}
	function DescripcionCiudad($Cod)
	{
		$Descripcion='';
		$Consulta=" SELECT nom_ciudad from sget_ciudades  ";
		$Consulta.="  where cod_ciudad='".$Cod."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[nom_ciudad];
		return($Descripcion);	
	}
	function DescripcionComuna($Cod)
	{
		$Descripcion='';
		$Consulta=" SELECT nom_comuna from sget_comunas  ";
		$Consulta.="  where cod_comuna='".$Cod."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[nom_comuna];
		return($Descripcion);	
	}
	function DescripcionGerencia($Cod)
	{
		$Consulta=" SELECT descrip_gerencias from sget_gerencias  ";
		$Consulta.="  where cod_gerencia='".$Cod."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[descrip_gerencias];
		return($Descripcion);	
	}

	function DescripcionArea($Cod)
	{
		$Consulta=" SELECT descrip_area,cod_cc from sget_areas ";
		$Consulta.="  where cod_area='".$Cod."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[cod_cc]." - ".$Fila[descrip_area];
		return($Descripcion);	
	}
	function DescripcionPrev($RutPrev)
	{
		$Consulta=" SELECT * from sget_prevencionistas  ";
		$Consulta.="  where rut_prev='".$RutPrev."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$Consulta = "SELECT * from proyecto_modernizacion.clase where cod_clase = '".$Fila[cod_clase]."'   ";
			$Resp1=mysql_query($Consulta);
			$Fila1=mysql_fetch_array($Resp1);
			$Consulta = "SELECT * from proyecto_modernizacion.sub_clase  where cod_clase='".$Fila[cod_clase]."' and cod_subclase='".$Fila["cod_subclase"]."'  ";
			$Resp3=mysql_query($Consulta);
			$Fila3=mysql_fetch_array($Resp3);
			if($Fila3["nombre_subclase"] != "" )
				$SubClase='('.$Fila3["nombre_subclase"].')';
			else	
				$SubClase='';
			$Prevencionista=$Fila["nombres"].'~'.$Fila["apellido_paterno"].'~'.$Fila["apellido_materno"].'~'.$Fila[nro_registro].'~'.$Fila[telefono].'~'.$Fila1[nombre_clase].' '.$SubClase;;
		}
		return($Prevencionista);	
	}
	function SubContratista($CmbEmpresa)
	{
		$Consulta=" SELECT * from sget_sub_contratistas  ";
		$Consulta.="  where rut_contratista='".$CmbEmpresa."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Var='S';
		else	
			$Var='N';
		return($Var);	
	}
	function DescripcionRazonSocial($RutE)
	{
		$Consulta=" SELECT * from sget_contratistas  ";
		$Consulta.="  where rut_empresa='".$RutE."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[razon_social];
		return($Descripcion);	
	}
	
	function RetornoPagina($CodSistema,$CodPantalla)
	{
		$Consulta=" SELECT link from proyecto_modernizacion.pantallas  ";
		$Consulta.="  where cod_pantalla='".$CodPantalla."' and cod_sistema='".$CodSistema."'";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=substr($Fila[link],12,strlen($Fila[link]));
		return($Descripcion);	
	}
	function ContabHitosAdm($NH,$P)
	{
		$Consulta=" SELECT count(*) as cantidad from sget_hitos t1 inner join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$P."' ";
		$Consulta.="  where t2.num_hoja_ruta='".$NH."'  ";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		$Fila=mysql_fetch_array($Resp);
			$Cant=$Fila[cantidad];
		$Consulta=" SELECT count(*) as cantau from sget_hitos t1 inner join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$P."' ";
		$Consulta.="  where t2.num_hoja_ruta='".$NH."' and t2.autorizado='S' ";
		//echo $Consulta;
		$Resp2=mysql_query($Consulta);
		$Fila2=mysql_fetch_array($Resp2);
			$CantAut=$Fila2[cantau];
		/*echo "cantidad".$Cant."<br>";
		echo "cantidad_aut".$CantAut."<br>";*/
		if($Cant > 0 )
		{
			if($CantAut > 0)
				$Rech='N';
			else
				$Rech='S';
		 }
		 else
		 	$Rech='S';
		return($Rech);	
	}
	function Registra_Estados($NumHoja,$Fecha,$Rut,$CodPant,$CodEst,$AR,$Tipo)
	{
		$FechaHora= date("Y-m-d G:i:s");
		$Actualizar="UPDATE sget_hoja_ruta set cod_estado='$CodEst' where num_hoja_ruta='".$NumHoja."'";
		mysql_query($Actualizar);
		$Insertar="INSERT INTO sget_reg_estados(num_hoja_ruta,cod_estado,fecha_hora,rut,acept_rech,tipo) values(";
		$Insertar.="'".$NumHoja."','".$CodEst."','".$FechaHora."','".$Rut."','".$AR."','".$Tipo."')";
		mysql_query($Insertar);	
	}
	function ActualizaGen($NH,$P)
	{
		$Consulta=" SELECT count(*) as cantidad from sget_hitos t1 left join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$P."' ";
		$Consulta.="  where t2.num_hoja_ruta='".$NH."'  ";
		$Resp=mysql_query($Consulta);
		$Fila=mysql_fetch_array($Resp);
			$Cant=$Fila[cantidad];
		$Consulta=" SELECT count(*) as cantau from sget_hitos t1 inner join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$P."' ";
		$Consulta.="  where t2.num_hoja_ruta='".$NH."' and t2.autorizado='S' ";
		$Resp2=mysql_query($Consulta);
		$Fila2=mysql_fetch_array($Resp2);
			$CantAut=$Fila2[cantau];
		if($Cant > 0 )
		{
			if($CantAut > 0)
			
			{	if($Cant==$CantAut)
				{
					switch($P)
					{
						case "15"://Autoriza Adm Contratos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=3,cod_estado_pantalla=3 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "14"://Autoriza Gestion Terceros Inicial
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=4,cod_estado_pantalla=4 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "16":////Autoriza Gestion de Riesgos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=5,cod_estado_pantalla=5 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "18":////Autoriza Gestion de RTerceros Final
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=6,cod_estado_pantalla=6 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "19":////Autoriza Gestion de RTerceros Final
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=2,cod_estado_pantalla=2 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;

					}
				}
				else
				{
					switch($P)
					{
						case "15"://Autoriza Adm Contratos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado= 2 ,cod_estado_pantalla=3 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "14"://Autoriza Gestion Terceros Inicial
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=3,cod_estado_pantalla=4 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "16":////Autoriza Gestion de Riesgos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=4, cod_estado_pantalla=5 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "18":////Autoriza Gestion Terceros Final 
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado= 5,cod_estado_pantalla=6 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "19":////Autoriza Gestion Terceros Final 
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado= 1,cod_estado_pantalla=1 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;

					}
				}
		 	}
			else
			{
				switch($P)
				{
					case "15"://Autoriza Adm Contratos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado= 2 ,cod_estado_pantalla=3 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "14"://Autoriza Gestion Terceros Inicial
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=3,cod_estado_pantalla=4 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "16":////Autoriza Gestion de Riesgos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=4, cod_estado_pantalla=5 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "18":////Autoriza Gestion Terceros Final 
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado= 5,cod_estado_pantalla=6 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "19":////Autoriza Gestion Terceros Final 
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado= 1,cod_estado_pantalla=1 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;

				}
			}
		 }
	}
	function CalculaReajuste()
	{
		//REAJUSTE CONTRATO
		$Consulta="SELECT cod_contrato,corr from sget_reajustes_contratos where tipo='C' and estado='P' and fecha_reajustada <='".date('Y-m-d')."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			$PromIpcAcum=0;
			$Consulta="SELECT fecha_inicio,monto_ctto from sget_contratos where cod_contrato='".$Fila["cod_contrato"]."'";
			//echo $Consulta."<br>";
			$RespCtto=mysql_query($Consulta);
			$FilaCtto=mysql_fetch_array($RespCtto);
			$PromIpcAcum=EntregaValorIpc($FilaCtto[fecha_inicio]);
			//echo $PromIpcAcum."<br>";
			if($PromIpcAcum!=0)
			{
				$NewMonto=round($FilaCtto[monto_ctto]+(($FilaCtto[monto_ctto]*$PromIpcAcum)/100));
				$Actualizar="UPDATE  sget_reajustes_contratos SET monto_reajustado='".$NewMonto."',estado='L' where cod_contrato='".$Fila["cod_contrato"]."' and corr='".$Fila["corr"]."'";
				//echo $Actualizar;
				mysql_query($Actualizar);
			}
		}
		//REAJUSTE SUELDO TRABAJADORES DEL CONTRATO
		$Consulta="SELECT cod_contrato,corr from sget_reajustes_contratos where tipo='S' and estado='P' and fecha_reajustada <='".date('Y-m-d')."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			$PromIpcAcum=0;
			$Consulta="SELECT fecha_inicio from sget_contratos where cod_contrato='".$Fila["cod_contrato"]."'";
			$RespCtto=mysql_query($Consulta);
			$FilaCtto=mysql_fetch_array($RespCtto);
			$PromIpcAcum=EntregaValorIpc($FilaCtto[fecha_inicio]);
			if($PromIpcAcum!=0)
			{
				$Consulta="SELECT rut,sueldo,cod_contrato,rut_empresa,fec_ini_ctto,fec_fin_ctto from sget_personal where cod_contrato='".$Fila["cod_contrato"]."' and estado='A' ";
				//echo $Consulta;
				$RespPers=mysql_query($Consulta);
				while($FilaPers=mysql_fetch_array($RespPers))
				{
					$NewMonto=round($FilaPers[sueldo]+(($FilaPers[sueldo]*$PromIpcAcum)/100));
					$Insertar="INSERT INTO sget_personal_historia(cod_contrato,rut_empresa,rut,activo,fecha_ingreso,fecha_termino) values('".$FilaPers["cod_contrato"]."','".$FilaPers[rut_empresa]."','".str_pad(trim($FilaPers["rut"]),10,'0',STR_PAD_LEFT)."','S','".$FilaPers[fec_ini_ctto]."','".$FilaPers[fec_fin_ctto]."',".intval(str_replace('.','',$NewMonto)).")";		
					//echo $Insertar."<br>";
					mysql_query($Insertar);				
				}
				$Actualizar="UPDATE  sget_reajustes_contratos SET estado='L' where cod_contrato='".$Fila["cod_contrato"]."' and corr='".$Fila["corr"]."'";
				//echo $Actualizar;
				mysql_query($Actualizar);
			}
		}
		
	}
	function EntregaValorIpc($FechaIniCtto)
	{
		$Fecha=explode('-',$FechaIniCtto);
		$A�o=$Fecha[0];
		$Mes=$Fecha[1];
		$Dia=0;
		//echo "FECHA: ".$FechaIniCtto."<br>";
		//echo "FECHA: ".date('Y-m-d',mktime(0,0,0,$Mes,$Dia,$A�o,1));
		$FechaAux=explode('-',date('Y-m-d',mktime(0,0,0,$Mes,$Dia,$A�o,1)));
		$ValorIpc1=0;
		$Consulta="SELECT valor from sget_ipc where ano='".$A�o."' and mes='".intval($FechaAux[1])."'";
		//echo $Consulta;
		$RespIpc=mysql_query($Consulta);
		if($FilaIpc=mysql_fetch_array($RespIpc))
		{
			$ValorIpc1=$FilaIpc["valor"];
		}
		$Fecha=explode('-',date('Y-m-d'));
		$A�o=$Fecha[0];
		$Mes=$Fecha[1];
		$Dia=0;
		$FechaAux=explode('-',date('Y-m-d',mktime(0,0,0,$Mes,$Dia,$A�o,1)));
		$ValorIpc2=0;
		$Consulta="SELECT valor from sget_ipc where ano='".$A�o."' and mes='".intval($FechaAux[1])."'";
		//echo $Consulta;
		$RespIpc=mysql_query($Consulta);
		if($FilaIpc=mysql_fetch_array($RespIpc))
		{
			$ValorIpc2=$FilaIpc["valor"];
		}
		//echo $ValorIpc1."<br>";
		//echo $ValorIpc2."<br>"; 
		if($ValorIpc1!=0)
			$Result=$ValorIpc2/$ValorIpc1;
		else
			$Result=0;
		//echo $Result;	
		return($Result);	
		
				
	}
	function resta_fechas($fecha1,$fecha2)
	{
		 // echo "f_1".$fecha1."<br>"; 
		  //echo "f_2".$fecha2."<br>"; 
		  if($fecha1 != '0000-00-00' && $fecha2 != '0000-00-00')
		  {
			  $fecha1=substr($fecha1,8,2)."-".substr($fecha1,5,2)."-".substr($fecha1,0,4);
			  $fecha2=substr($fecha2,8,2)."-".substr($fecha2,5,2)."-".substr($fecha2,0,4);
			  //echo "f1".$fecha1."<br>";
			  //echo "f2".$fecha2."<br>";
			  if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
					  list($dia1,$mes1,$año1)=split("-",$fecha1);
			  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
					  list($dia1,$mes1,$año1)=split("-",$fecha1);
			  if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
					  list($dia2,$mes2,$año2)=split("-",$fecha2);
			  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
					  list($dia2,$mes2,$año2)=split("-",$fecha2);
			  $dif = mktime(0,0,0,$mes1,$dia1,$año1,1) - mktime(0,0,0,$mes2,$dia2,$año2,1);
			  //echo "dif".$dif."<br>";
			  $ndias=floor($dif/(24*60*60));
			 //echo "DIAS:".$ndias."<br><br>";
		 }
		 else 
			 $ndias=0;
		  return($ndias);
	}
	function RecuperaUltHito($HR,$Est,$Rut,$AcepRech,$Tipo)
	{
		$Fecha='';
		$Consulta="SELECT fecha_hora from sget_reg_estados where num_hoja_ruta='".$HR."' and cod_estado='".$Est."' and rut='".$Rut."'";
		$Consulta.=" and acept_rech='".$AcepRech."' and tipo='".$Tipo."' and ult='S'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$Fecha=$Fila["fecha_hora"];
		}
		return($Fecha);
			
		
	}	
?>