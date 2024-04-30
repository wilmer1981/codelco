<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
		include("../principal/conectar_sget_web.php");
		include("funciones/sget_funciones.php");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

 $CodigoDeSistema = 27;
 $CodigoDePantalla = 7;
 if(isset($CodCtto))
 	$TxtBuscaCod=$CodCtto;
if(!isset($CmbEmpresa))
	$CmbEmpresa='-1';
?>
<html>
<head>
<title>Reporte Contratos</title>
<body>
<form name="frmPrincipal" action="" method="post"><?
	$dif=0;
	if($TxtFechaInicio != "")
	{		
		$dif=resta_fechas($TxtFechaTermino,$TxtFechaInicio);
	}
 
   	if($dif>=0)
  	{
		?>


		<table border="1">
		<tr>
		<td align="center" >N�</td>
		<td align="center">Rut</td>
		<td align="center" >Digito</td>
		<td align="center" >Empresa </td>
		<td align="center" >Contrato</td>
		<td align="center" >Descripci&oacute;n</td>
		<td align="center" >Monto</td>
		<td align="center" >Periodo Fact.</td>
		<td align="center" >Fecha&nbsp;Inicio </td>
		<td align="center" >Fecha&nbsp;Termino </td>
		<td align="center" >Adm.Codelco </td>
		<td align="center" >Email</td>
		<td align="center" >Telefono </td>
		<td align="center" >Adm.Contratista</td>
		<td align="center" >Email</td>
		<td align="center" >Telefono </td>
		<td align="center" >Gerencia</td>
		<td align="center">Area</td>
		<td align="center">Dotac.</td>
		
		</tr><?
		$CuentaDotacion= 0;
		$Consulta="SELECT t6.descrip_tipo_contrato,t5.nombre_subclase as estado_ctto,t4.nombres as nom_contratista,t4.ape_paterno as ape_p_contratista,t4.ape_materno as ape_m_contratista,t4.telefono as telefonoc,t4.email as emailc,t3.nombres,t3.ape_paterno,t3.ape_materno,t3.email,t3.telefono,t1.cod_contrato,t1.descripcion,t1.rut_empresa,t2.razon_social,t1.fecha_inicio,t1.fecha_termino,t1.rut_adm_contrato,t1.monto_ctto,t1.periodo_facturacion,t1.cod_gerencia,t1.cod_area ";
		$Consulta.=" from sget_contratos t1  left join sget_contratistas t2  on t1.rut_empresa=t2.rut_empresa ";
		$Consulta.=" left join  sget_administrador_contratos t3  on t1.rut_adm_contrato=t3.rut_adm_contrato ";
		$Consulta.=" left join  sget_administrador_contratistas t4  on t1.rut_adm_contratista=t4.rut_adm_contratista ";
		$Consulta.=" left join  proyecto_modernizacion.sub_clase t5  on t1.estado=t5.cod_subclase and t5.cod_clase='30007'";
		$Consulta.=" left join  sget_tipo_contrato t6  on t1.cod_tipo_contrato=t6.cod_tipo_contrato ";
		
		$Consulta.="  where t1.cod_contrato<>'' ";
		if($TxtContrato!='')
			$Consulta.= " and upper(t1.cod_contrato) like ('%".strtoupper(trim($TxtContrato))."%') ";
		if($TxtDescripcion!='')
			$Consulta.= " and upper(t1.descripcion) like ('%".strtoupper(trim($TxtDescripcion))."%') ";
		if($CmbEmpresa != "-1")
			$Consulta.="  and  t1.rut_empresa='".$CmbEmpresa."' ";
		if($CmbTipoCtto != "-1")
			$Consulta.="  and  t1.cod_tipo_contrato='".$CmbTipoCtto."' ";
		if($CmbAdmCtto != "-1")
			$Consulta.="  and  t1.rut_adm_contrato='".$CmbAdmCtto."' ";
		if($CmbEstado != "-1")
			$Consulta.="  and  t1.estado='".$CmbEstado."' ";
		if($CmbGerencias != "-1")
			$Consulta.="  and  t1.cod_gerencia='".$CmbGerencias."' ";
		if($CmbAreas != "-1")
			$Consulta.="  and  t1.cod_area='".$CmbAreas."' ";
		if($TxtFechaInicio != "")
		{		
			$Consulta.=" and  t1.fecha_inicio between '".$TxtFechaInicio." 00:00:00' and '".$TxtFechaTermino." 23:59:59'";
			$dif=resta_fechas($TxtFechaTermino,$TxtFechaInicio);
		}
		if($CmbAvisoVenc!='-1')
		{
			$Consulta.="  and  t1.aviso_vencimiento='".$CmbAvisoVenc."' ";
		}
		if($CmbAcuerdo!='T')
			$Consulta.="  and  t1.acuerdo_marco='".$CmbAcuerdo."' ";
		if($CmbClasificacion!= 'T')
			$Consulta.="  and t1.clasificacion = '".$CmbClasificacion."'";	
		$Consulta.= " order by t2.razon_social";
		//echo "WW".$Consulta;
		$RespMod=mysqli_query($link, $Consulta);
		echo "<input type='hidden' name='CheckCtto'>";
		
		$Cont=1;
		$Contador = 0;
		while($FilaMod=mysql_fetch_array($RespMod))
		{
			$Mostrar='S';
			if($CmbAvisoVenc!='-1')
			{
				$MesDesc=$CmbAvisoVenc;
				$Fecha=explode('-',$FilaMod[fecha_termino]);
				if($MesDesc>12)
				{	
					$A�o=abs(intval($Fecha[0])-1);
					$MesDesc=abs($MesDesc-12);
				}
				else
					$A�o=$Fecha[0];
				if($MesDesc<=12)
					$Mes=(intval($Fecha[1])-intval($MesDesc));
				else
					$Mes=$Fecha[1];
				$Dia=$Fecha[2];
				$FechaAviso=date('Y-m-d',mktime(0,0,0,$Mes,$Dia,$A�o,1));
				//echo $FechaAviso."<br>";
				if(date('Y-m-d')>=$FechaAviso)
					$Mostrar='S';
				else
					$Mostrar='N';
			}
			$Contador = $Contador + 1;
			$Contrato=$FilaMod["cod_contrato"];
			$TipoCtto=$FilaMod[descrip_tipo_contrato];
			$Descripcion=$FilaMod["descripcion"];
			$Empresa=$FilaMod[razon_social];	
			$FechaInicio=$FilaMod["fecha_inicio"];
			$FechaTermino=$FilaMod[fecha_termino];
			$AdmCtto=$FilaMod["nombres"]."&nbsp;".$FilaMod[ape_paterno]."&nbsp;".$FilaMod[ape_materno];
			$AdmContratista=$FilaMod[nom_contratista]."&nbsp;".$FilaMod[ape_p_contratista]."&nbsp;".$FilaMod[ape_m_contratista];
			$Estado=$FilaMod[estado_ctto];
			$RutEmpresa = $FilaMod[rut_empresa];
			$RUT1=substr($RutEmpresa,0,2);
			$RUT2=substr($RutEmpresa,2,3);
			$RUT3=substr($RutEmpresa,5,3);
			$RUT4=substr($RutEmpresa,9,1);
		
			$RUTN=$RUT1.".".$RUT2.".".$RUT3;
			$RUTD=$RUT4;
			$Monto = $FilaMod[monto_ctto];
			$Consulta="SELECT nombre_subclase as Nombre from proyecto_modernizacion.sub_clase";
			$Consulta.= " where cod_clase = '30019' and cod_subclase = '".$FilaMod[periodo_facturacion]."'";
		//	echo "CC".$Consulta;
			$RespSub=mysqli_query($link, $Consulta);
			if ($FilaSub=mysql_fetch_array($RespSub))
				$PeriodoFact = $FilaSub["Nombre"];
			else
				$PeriodoFact = "Sin Periodo de Fact.";	
			if($Mostrar=='S')
			{
			
				?>
				<td><? echo $Cont; ?>&nbsp;</td>
				<td><? echo $RUTN; ?>&nbsp;</td>
				<td><? echo $RUTD; ?>&nbsp;</td>
				<td><? echo ucfirst(strtolower(str_replace(' ','&nbsp;',$Empresa))); ?>&nbsp;</td>
				<td><? echo $FilaMod["cod_contrato"]; ?>&nbsp;</td>
				<td><? echo ucwords(strtolower($Descripcion)); ?>&nbsp;</td>
				<td align="right"><? echo  number_format($Monto,0,'','.') ?>&nbsp;</td>
				<?
				$Consulta = "SELECT ano,mes from sget_facturas_contrato  where cod_contrato = '".$FilaMod["cod_contrato"]."' ";
				$RespFac=mysqli_query($link, $Consulta);
			//	echo "SS".$Consulta;
				if ($FilaFac=mysql_fetch_array($RespFac))
				{ 
					$AnoFac = $FilaFac["ano"];
					$MesFac = $FilaFac["mes"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ;
					//$meses[$FilaMod[mes];
					//echo "RR".$AnoFac."--".$MesFac;
				//	echo "<td>".$FilaGer[descrip_gerencias]."; </td>";
				}
				
				?>
				<td><? echo $PeriodoFact; ?>&nbsp;</td>
				<td><? echo $FechaInicio; ?>&nbsp;</td>
				<td><? echo $FechaTermino; ?>&nbsp;</td>
				<td><? echo $AdmCtto; ?>&nbsp;</td>
				<td><? echo $FilaMod[email] ?>&nbsp;</td>
				<td><? echo $FilaMod[telefono] ?>&nbsp;</td>
				<td><? echo $AdmContratista; ?>&nbsp;</td>
				<td><? echo $FilaMod[emailc] ?>&nbsp;</td>
				<td><? echo $FilaMod[telefonoc] ?>&nbsp;</td>
				<?
				$Consulta = "SELECT descrip_gerencias from sget_gerencias  where cod_gerencia = '". $FilaMod[cod_gerencia]."' ";
				$RespGer=mysqli_query($link, $Consulta);
				
				if ($FilaGer=mysql_fetch_array($RespGer))
				{ 
					echo "<td>".$FilaGer[descrip_gerencias]." </td>";
				}
				$Consulta = "SELECT descrip_area  from sget_areas where cod_area = '". $FilaMod["cod_area"]."' ";
				$Consulta.= " and cod_gerencia = '".$FilaMod[cod_gerencia]."'";
				
				$RespAre=mysqli_query($link, $Consulta);
				if($FilaAre=mysql_fetch_array($RespAre))
				{
					echo "<td>".$FilaAre[descrip_area]." </td>";
				}
				?>
				
				<td align="right">
				<? 
				$Consulta="SELECT count(rut) as Cantidad from sget_personal where cod_contrato='".$FilaMod["cod_contrato"]."' and estado='A'";
				$RespCant=mysqli_query($link, $Consulta);
				if($FilaCant=mysql_fetch_array($RespCant))
				{
					echo $FilaCant[Cantidad];
				}
				else
				{
					echo "0";
				}
				$CuentaDotacion=$CuentaDotacion+$FilaCant[Cantidad];
				
			?>
				&nbsp;</td>

				
				
			</tr>
			<?
			$Cont++;
			}
			
		}	
		?>
		</table>
	<? 
	}
	else
	{
	?>	<table border="1"  >
		<tr>
		<td  align="center" >Las fechas No han sido correctamente Ingresada</td>
		</tr></table>
	<? }
?>
		  <table border="1">
	  	<tr>
		<td bgcolor="#3399FF" bordercolorlight="#3399FF" align="center" >Total Dotaci�n :</td>
			
			<td colspan='17' bgcolor="#3399FF" bordercolorlight="#3399FF" >&nbsp;</td>
			<td align="right" bgcolor="#3399FF" bordercolorlight="#3399FF" > <? echo $CuentaDotacion; ?>&nbsp;</td>
		</tr>
	  </table>


</form>

</body>
</html>