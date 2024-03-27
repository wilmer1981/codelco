<?  header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$CodigoDeSistema = 27;
	$CodigoDePantalla = 7;
	if(!isset($CmbSexo))
		$CmbSexo="-1";
	if(!isset($CmbEmpresa))
		$CmbEmpresa='-1';
?>
<html>
<head>
<title>Reporte Personas</title>

<form name="frmPrincipal" action="" method="post">


		
		<table  border="1" >
		<tr>
		
		<td   align="center" >Run </td>
		<td   align="center">Nombre </td>
		<td  align="center" >Ap.Paterno</td>
		<td  align="center" >Ap.Materno</td>
		<td   align="center">Sexo</td>
		<td  align="center">Contrato</td>
		<td   align="center">Empresa</td>
		<td  align="center" >Fec.&nbsp;Inicio</td>
		<td  align="center" >Fec.&nbsp;Termino</td>
		<td   align="center">AFP</td>
		<td   align="center">Nro. Tarjeta</td>
		<td   align="center">Comuna</td>
		</tr>
		<?
		$Consulta="SELECT t1.*,t2.abreviatura_afp,t3.nom_comuna,t5.razon_social from sget_personal t1 ";
		$Consulta.=" left join sget_afp t2 on t1.cod_afp=t2.cod_afp ";
		$Consulta.=" left join sget_comunas t3  on t1.cod_comuna=t3.cod_comuna";
		$Consulta.=" left join sget_contratos t4  on t1.cod_contrato=t4.cod_contrato";
		$Consulta.=" left join sget_contratistas t5  on t1.rut_empresa=t5.rut_empresa";
		$Consulta.=" left join sget_sindicato t6  on t1.cod_sindicato=t6.cod_sindicato";
		$Consulta.=" left join sget_cargos t7 on t1.cargo=t7.cod_cargo";
		$Consulta.=" left join sget_ciudades t8  on t1.cod_ciudad=t8.cod_ciudad";
		$Consulta.="  where t1.rut<>'' ";
		if($TxtRutPrv!='')
			$Consulta.= " and t1.rut= '".str_pad($TxtRutPrv,8,'0',l_pad)."-".$TxtDv."' ";
		if($TxtApellido!='')
			$Consulta.= " and upper(t1.ape_paterno) like ('%".strtoupper(trim($TxtApellido))."%') ";
		if($CmbSexo != "-1")
			$Consulta.="  and  t1.sexo='".$CmbSexo."' ";
		if($CmbTipoPersona != "-1")
			$Consulta.="  and  t1.tipo='".$CmbTipoPersona."' ";
		if($CmbAfp != "-1")
			$Consulta.="  and  t1.cod_afp='".$CmbAfp."' ";
		if($CmbSalud != "-1")
			$Consulta.="  and  t1.cod_salud='".$CmbSalud."' ";
		if($CmbCiudad != "-1")
			$Consulta.="  and  t1.cod_ciudad='".$CmbCiudad."' ";
		if($CmbComunas != "-1")
			$Consulta.="  and  t1.cod_comuna='".$CmbComunas."' ";
		if($CmbCargo != "-1")
			$Consulta.="  and  t1.cargo='".$CmbCargo."' ";
		if($TxtCtto != "")
			$Consulta.= " and upper(t1.cod_contrato) like ('%".strtoupper(trim($TxtCtto))."%') ";
		if($TxtFInicio!=''&&$TxtFTermino)
			$Consulta.= " and t1.fec_ini_ctto >= '".$TxtFInicio."' and  fec_fin_ctto <= '".$TxtFTermino."'";	
		if($CmbEmpresa != "-1")
			$Consulta.="  and  t1.rut_empresa='".$CmbEmpresa."' ";
		if($CmbSindicato != "-1")
			$Consulta.="  and  t1.cod_sindicato='".$CmbSindicato."' ";
		if($TxtTarjeta != "")
			$Consulta.="  and  t1.nro_tarjeta like '".$TxtTarjeta."%' ";
		if($CmbEstado!='-1')
			$Consulta.="  and  t1.estado ='".$CmbEstado."' ";
		if($CmbCertAnt!='-1')
		{	switch($CmbCertAnt)
			{
				case "N":
					$Consulta.="  and  (t1.certificado_ant ='".$CmbCertAnt."' or t1.certificado_ant IS NULL)";
				break;
				case "S":
					$Consulta.="  and  t1.certificado_ant ='".$CmbCertAnt."' ";
				break;
				case "D":
					$Consulta.="  and  t1.fecha_certif >='".date('Y-m-d')."' ";
				break;
				case "V":
					$Consulta.="  and  (t1.fecha_certif < '".date('Y-m-d')."' or t1.fecha_certif ='0000-00-00' or t1.fecha_certif IS NULL)";
				break;
				
			}
		}
		if($CmbTipoCtto!='S')
			$Consulta.="  and  t1.tipo_ctto ='".$CmbTipoCtto."' ";
		$Consulta.=" order by t1.ape_paterno";	
		$RespMod=mysqli_query($link, $Consulta);
		$Cont=0;
		while($FilaMod=mysql_fetch_array($RespMod))
		{
			$Run=$FilaMod["rut"];
			$RazonSocial=$FilaMod[razon_social];
			$Nombre=$FilaMod["nombres"];
			$Paterno=$FilaMod[ape_paterno];	
			$Materno=$FilaMod[ape_materno];
			$Sexo='';
			switch($FilaMod[sexo])
			{
				case 'M':
					$Sexo='Masculino';
				break;
				case 'F':
					$Sexo='Femenino';
				break;
			}
			
			$Contrato=$FilaMod["cod_contrato"];
			$AFP=$FilaMod[abreviatura_afp];
			$NroTarjeta=$FilaMod[nro_tarjeta];
			$Comuna=$FilaMod[nom_comuna];
			$FechaInicio=$FilaMod[fec_ini_ctto];
			$FechaTermino=$FilaMod[fec_fin_ctto];
			?><tr>
			<td ><?  echo $Run; ?>&nbsp;</td>
			<td><? echo ucwords(strtolower($Nombre)); ?>&nbsp;</td>
			<td><? echo ucwords(strtolower($Paterno)); ?>&nbsp;</td>
			<td><? echo ucwords(strtolower($Materno)); ?>&nbsp;</td>
			<td><? echo $Sexo; ?>&nbsp;</td>
			<td><? echo $Contrato; ?>&nbsp;</td>
			<td><? echo $RazonSocial; ?>&nbsp;</td>
			<td><? echo $FechaInicio; ?>&nbsp;</td>
			<td><? echo $FechaTermino; ?>&nbsp;</td>
			<td><? echo $AFP; ?>&nbsp;</td>
			<td ><? echo $NroTarjeta; ?>&nbsp;</td>
			<td><? echo ucwords(strtolower($Comuna)); ?>&nbsp;</td>
			</tr>
		<?
			$Cont++;
		}
		?></table>
	


</form>


</body>
</html>