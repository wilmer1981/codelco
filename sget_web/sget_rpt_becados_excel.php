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
<title>Reporte Becados</title>

<form name="frmPrincipal" action="" method="post">
		<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<tr>
		<td  colspan="7" align="center"  class="TituloTablaNaranja" >Datos Personal </td>
		<td colspan="4" align="center" class="TituloTablaVerde">Datos Beneficiario</td>
		</tr>
		<tr>
		<td width="13%" align="center"  class="TituloTablaNaranja" >Run </td>
		<td width="8%" align="center"  class="TituloTablaNaranja">Nombre </td>
		<td width="9%"align="center"  class="TituloTablaNaranja" >Ap.Paterno</td>
		<td width="10%"align="center"  class="TituloTablaNaranja" >Ap.Materno</td>
		<td width="10%"align="center"  class="TituloTablaNaranja" >Cant. Beneficiario</td>
		<td width="11%"align="center"  class="TituloTablaNaranja">Contrato</td>
		<td width="13%" align="center"  class="TituloTablaNaranja">Empresa</td>
		<td width="12%" align="center" class="TituloTablaVerde">Run Beneficiario</td>
		<td width="12%" align="center"  class="TituloTablaVerde">Apellidos</td>
		<td width="8%" align="center"  class="TituloTablaVerde">Nombres</td>
		<td width="4%" align="center"  class="TituloTablaVerde">Edad</td>
		</tr>
		<?
		$Consulta="SELECT t9.rut_becado,t9.nombres as nombres_bec,t9.ape_paterno as ape_paterno_bec,t9.ape_materno as ape_materno_bec,t9.edad,t1.*,t2.abreviatura_afp,t3.nom_comuna,t5.razon_social from sget_personal t1 ";
		$Consulta.=" Inner join sget_becados t9 on t1.rut=t9.rut ";
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
		if($CmbEmpresa != "-1")
			$Consulta.="  and  t1.rut_empresa='".$CmbEmpresa."' ";
		if($CmbSindicato != "-1")
			$Consulta.="  and  t1.cod_sindicato='".$CmbSindicato."' ";
		$Consulta.="  group by t1.rut ";	
		$RespMod=mysql_query($Consulta);
		$Cont=1;
		while($FilaMod=mysql_fetch_array($RespMod))
		{
			$Run=$FilaMod["rut"];
			$RazonSocial=str_replace(' ','&nbsp;',FormatearNombre($FilaMod[razon_social]));
			$Nombre=$FilaMod["nombres"];
			$Paterno=$FilaMod[ape_paterno];	
			$Materno=$FilaMod[ape_materno];
			$Contrato=$FilaMod["cod_contrato"];
			?>
			<tr>
			<? 
			$Consulta="SELECT ifnull(count(*),0) as cant_bec from sget_personal t1 ";
			$Consulta.=" Inner join sget_becados t9 on t1.rut=t9.rut where t1.rut='".$Run."'";
			$RespCantBec=mysql_query($Consulta);
			$FilaCantBec=mysql_fetch_array($RespCantBec);
			$CantBec=$FilaCantBec[cant_bec];
			?>
			<td rowspan="<? echo $CantBec;?>" ><?  echo FormatearRun($Run); ?></td>
			<td rowspan="<? echo $CantBec;?>"><? echo FormatearNombre($Nombre); ?>&nbsp;</td>
			<td rowspan="<? echo $CantBec;?>"><? echo FormatearNombre($Paterno); ?>&nbsp;</td>
			<td rowspan="<? echo $CantBec;?>"><? echo FormatearNombre($Materno); ?>&nbsp;</td>
			<td rowspan="<? echo $CantBec;?>" align="right"><? echo $CantBec; ?>&nbsp;</td>
			<td rowspan="<? echo $CantBec;?>"><? echo $Contrato; ?>&nbsp;</td>
			<td rowspan="<? echo $CantBec;?>"><? echo $RazonSocial; ?>&nbsp;</td>
			<?
			$ContIni=1;
			$Consulta="SELECT t9.rut_becado,t9.nombres as nombres_bec,t9.ape_paterno as ape_paterno_bec,t9.ape_materno as ape_materno_bec,t9.edad from sget_personal t1 ";
			$Consulta.=" Inner join sget_becados t9 on t1.rut=t9.rut where t1.rut='".$Run."'";
			$RespBec=mysql_query($Consulta);
			while($FilaBec=mysql_fetch_array($RespBec))
			{
				if($ContIni>1)
				{
				?>
				<tr>
				<?
				}
				$ContIni++;
				?>
				<td ><? echo FormatearRun($FilaBec[rut_becado]);?>&nbsp;</td>
				<td><? echo  FormatearNombre($FilaBec[ape_paterno_bec])." ".FormatearNombre($FilaBec[ape_materno_bec]);?>&nbsp;</td>
				<td><? echo  FormatearNombre($FilaBec[nombres_bec]);?>&nbsp;</td>
				<td align="right"><? echo  $FilaBec[edad];?>&nbsp;</td>
				</tr>
		<? }
		}
		?>
		</table>
</form>


</body>
</html>