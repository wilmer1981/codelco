<?
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	set_time_limit(5000);
	echo "---------------------EMPRESAS-------------------------<br>";
	$Consulta="SELECT * from uca_web.uca_empresas where rut_empresa <>'61704000-K'";
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{
		$Insertar="INSERT INTO sget_contratistas(rut_empresa,razon_social, ";
		$Insertar.=" nombre_fantasia,calle,cod_ciudad,cod_comuna,mail_empresa,telefono_comercial, ";
		$Insertar.=" repres_legal1,telefono_repres1,mail_repres_legal1,celular_repres_legal1, ";
		$Insertar.=" repres_legal2,telefono_repres2,celular_repres_legal2,mail_repres_legal2, ";
		$Insertar.=" nro_regic,cod_mutual_seguridad,nro_registro,fecha_ven_cert,estado,cod_region) ";
		$Insertar.="values ('".$Fila[rut_empresa]."','".strtoupper($Fila[razon_social])."','','".str_replace("'","",strtoupper($Fila["direccion"]))."', ";
		$Insertar.="'0','0','".substr(strtoupper($Fila[email]),0,50)."' ,'".$Fila[fono_comercial]."', ";
		$Insertar.="'','','','','".strtoupper($Fila[contacto])."','".$Fila[fono_contacto]."' , ";
		$Insertar.="'','','','0','','0000-00-00','1','0') ";
		//echo $Insertar."<br>";
		mysql_query($Insertar)or die ($Insertar);
	}
	echo "<script language='javascript'>";
	echo "alert('Empresas Cargadas');";
	echo "</script>";
	echo "<br><br>";
	echo "---------------------CONTRATOS-------------------------<br>";
	$Consulta="SELECT * from uca_web.uca_contratos where cod_contrato<>'9999' and cod_contrato<>'9998'";
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{
		$Insertar="Insert Into sget_contratos(cod_contrato,descripcion,cod_gerencia,cod_area,monto_ctto,rut_empresa,fecha_inicio,fecha_termino";
		$Insertar.=",cod_tipo_contrato,rut_adm_contrato,rut_adm_contratista,fecha_venc_bol_garantia,rut_prev,tipo_cambio,tipo_ctto,aviso_vencimiento,poliza,bono,reajuste,seguro,eco4,sobreTiempo,gratificacion,indemnizacion,estado)";
		$Insertar.="values('".$Fila["cod_contrato"]."','".strtoupper($Fila[descrip_contrato])."','0','0','0','".$Fila[rut_empresa]."','".$Fila[fecha_inicio]."','".$Fila[fecha_termino]."'";
		$Insertar.=",'','','','0000-00-00','','','1','0','','','','','','','','','1')";
		//echo $Insertar."<br>";
		mysql_query($Insertar) or die ($Insertar);
	}
	echo "<script language='javascript'>";
	echo "alert('Contratos Cargados');";
	echo "</script>";
	echo "<br><br>";
	echo "---------------------PERSONAL EXTERNO-------------------------<br>";
	$Consulta="SELECT t1.rut,t1.nombres,t1.ape_paterno,t1.ape_materno,t2.fecha_inicio,t1.fecha_final_ctto,t1.direccion,t1.telefono1,t1.telefono2,t1.rut_empresa,t1.cod_contrato,t1.estado,t1.observacion,t1.nro_tarjeta from uca_web.uca_personas t1 left join uca_web.uca_contratos t2 on t1.cod_contrato=t2.cod_contrato and t1.rut_empresa=t2.rut_empresa where t1.tipo='E' and t1.rut_empresa<>'61704000-K'";
	$Resp=mysql_query($Consulta);$Cont=0;
	while($Fila=mysql_fetch_array($Resp))
	{
		if($Fila[fecha_inicio]=="")
			$FecIniCtto="0000-00-00";
		else
			$FecIniCtto=$Fila[fecha_inicio];
		if($Fila[fecha_final_ctto]=="")
			$FecTerCtto="0000-00-00";
		else
			$FecTerCtto=$Fila[fecha_final_ctto];
		$Insertar="INSERT INTO sget_personal(rut,nombres,ape_paterno,ape_materno,tipo,cod_ciudad,cod_comuna,fec_ini_ctto,fec_fin_ctto,direccion,telefono1,telefono2,rut_empresa,cod_contrato,estado,observacion,nro_tarjeta,sexo,cod_region) values (";
		$Insertar.="'".str_pad(trim($Fila["rut"]),10,'0',STR_PAD_LEFT)."','".str_replace("'","",strtoupper($Fila["nombres"]))."','".str_replace("'","",strtoupper($Fila[ape_paterno]))."','".str_replace("'","",strtoupper($Fila[ape_materno]))."','1','0','0','".$FecIniCtto."','".$FecTerCtto."','".str_replace("'","",strtoupper($Fila["direccion"]))."','".$Fila[telefono1]."','".$Fila[telefono2]."',";
		$Insertar.="'".$Fila[rut_empresa]."','".$Fila["cod_contrato"]."','".$Fila["estado"]."','".$Fila["observacion"]."',";
		$Insertar.="'".str_pad(trim($Fila[nro_tarjeta]),8,'0',STR_PAD_LEFT)."',";	
		$Insertar.="'M','0')";
		//echo $Insertar."<br>";
		mysql_query($Insertar) or die ($Insertar);
		//echo $Insertar;
		$Insertar="INSERT INTO sget_personal_historia(cod_contrato,rut_empresa,rut,activo,fecha_ingreso,fecha_termino,sueldo) values('".$Fila["cod_contrato"]."','".$Fila[rut_empresa]."','".str_pad(trim($Fila["rut"]),10,'0',STR_PAD_LEFT)."','S','".$FecIniCtto."','".$FecTerCtto."',0)";		
		//echo $Insertar."<br>";
		mysql_query($Insertar) or die ($Insertar);
	}
	echo "<script language='javascript'>";
	echo "alert('Personal Externo Cargados');";
	echo "</script>";
?>