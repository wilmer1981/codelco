<?
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

set_time_limit(3000);
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$HHMens=ObtieneHHMens();
?>
<html>
<head>
<title>Reporte Empresas Consolidado Excel</title>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
    <tr>
      <td height="17" class='formulario2'>Rut Empresa </td>
      <td colspan="2" class="formulario2" ><? $TxtRutPrv."-".$TxtDv;?></td>
    </tr>
    <tr>
      <td height="17" class='formulario2'>Raz&oacute;n Social </td>
      <td colspan="2" class='formulario2'><? echo $TxtRazonSocial; ?></td>
    </tr>
    <tr>
      <td width="123"class='formulario2'>Estado Contrato </td>
      <td width="97" class='formulario2' >
          <?
	    $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30007' and cod_subclase='".$CmbEstado."' ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			echo ucfirst($FilaTC["nombre_subclase"]);
		}
		?>
      <td width="686" class='formulario2' >Estado Trabajador
            <?
	    $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30007' and cod_subclase='".$CmbEstado2."' ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			echo ucfirst($FilaTC["nombre_subclase"]);
		}
			?>
    </tr>
    <tr>
      <td class='formulario2'><span class="FilaAbeja2">Fecha de Busqueda</span></td>
      <td colspan="2" class='formulario2' >Desde&nbsp;<? echo $TxtFecha." Hasta ".$TxtFechaH; ?>&nbsp;</td>
    </tr>
  </table>
  <br>
	<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
	<tr>
	<td width="20" align="center" class="TituloTablaVerde">Empresa</td>
	<td width="14" align="center" class="TituloTablaVerde" >Rut</td>
	<td width="20" class="TituloTablaVerde" align="center">Contrato</td>
	<td width="15" class="TituloTablaVerde" align="center">Nro&nbsp;Contrato</td>
	<td width="15" class="TituloTablaVerde" align="center">Fec.Ini.Ctto.</td>
	<td width="15" class="TituloTablaVerde" align="center">Fec.Ter.Ctto.</td>
	<td width="15" class="TituloTablaVerde" align="center">Tipo Ctto.</td>
	<td width="8" class="TituloTablaVerde" align="center">Centro&nbsp;Costo </td>
	<td width="10" class="TituloTablaVerde" align="center">Funcionario</td>
	<td width="14" class="TituloTablaVerde" align="center">Run</td>
	<td width="8" class="TituloTablaVerde" align="center">Nro.Tarjeta</td>
	<td width="8" class="TituloTablaVerde" align="center">Activo</td>
	<td width="8" class="TituloTablaVerde" align="center">Genero</td>
	<td width="8" class="TituloTablaVerde" align="center">Turno</td>
	<td width="2" class="TituloTablaVerde" align="center">E</td>
	<td width="2" class="TituloTablaVerde" align="center">S</td>
	<td width="3" class="TituloTablaVerde" align="center">Total<br>HH</td>
	</tr>
    <?
		$TotEnt=0;$TotSal=0;$TotHH=0;
		$Consulta="SELECT t2.cod_tipo_contrato,t2.fecha_inicio,t2.fecha_termino,t1.rut_empresa, t1.razon_social,t2.cod_contrato,t2.descripcion as NomCtto,cod_area,t3.rut,t3.nro_tarjeta,";
		$Consulta.=" t3.nombres,t3.ape_paterno,t3.ape_materno,t3.sexo,t3.cod_turno,t4.descrip_turno,t5.activo from sget_contratistas t1  ";
		$Consulta.=" inner join  sget_contratos t2 on t1.rut_empresa=t2.rut_empresa ";
		$Consulta.=" inner join sget_personal_historia t5 on t2.rut_empresa=t5.rut_empresa and t2.cod_contrato=t5.cod_contrato ";
		$Consulta.=" inner join sget_personal t3 on t5.rut=t3.rut ";
		$Consulta.=" left join  sget_turnos t4 on t4.cod_turno=t3.cod_turno ";
		//$Consulta.=" inner join sget_personal_historia as t5 on t1.rut=t5.rut ";
		//$Consulta.=" and (t1.fechahora >= concat(t5.fecha_ingreso,' 00:00:00') and t1.fechahora <= concat(t5.fecha_termino,' 23:59:59'))"; 
		
		$Consulta.="  where t1.rut_empresa<>'' ";
		if($TxtRutPrv!='')
			$Consulta.= " and t1.rut_empresa= '".str_pad($TxtRutPrv,8,'0',l_pad)."-".$TxtDv."' ";
		if($TxtRazonSocial!='')
			$Consulta.= " and upper(t1.razon_social) like ('%".strtoupper(trim($TxtRazonSocial))."%') ";
		if($CmbEstado!='-1')	
			$Consulta.="  and  t2.estado='".$CmbEstado."' ";
		if($CmbEstado2!='-1'&&$CmbEstado!='2')
		{	
			if($CmbEstado2=='1')
				$Consulta.="  and  t5.activo='S' ";
			else
				$Consulta.="  and  t5.activo='N' ";	
		}
		//$Consulta.=" group by t1.rut_empresa";
		$Consulta.=" order by t1.razon_social,NomCtto,t3.ape_paterno,t3.ape_materno,t3.nombres";
		//echo $Consulta."<br>";
		$RespMod=mysqli_query($link, $Consulta);
		$Cont=0;
		while($FilaMod=mysql_fetch_array($RespMod))
		{
			$MuestraReg=BuscaMarcas($FilaMod[rut_empresa],$FilaMod["cod_contrato"],$FilaMod["rut"],$CmbEstado2,$TxtFecha,$TxtFechaH);
			if($MuestraReg>0)
			{
				$Par=($Cont % 2);
				if($Par==1)
				{
					?>
					<tr class="FilaAbeja">
					<?
				}
				else
				{
					?>
					<tr class="FilaAbeja">
					<? 
				}
				$CC=DescripcionArea($FilaMod["cod_area"]);
				?>
				<td><? echo FormatearNombre($FilaMod[razon_social]); ?>&nbsp;</td>
				<td><? echo FormatearRun($FilaMod[rut_empresa]); ?>&nbsp;</td>
				<td><? echo ucwords(strtolower($FilaMod[NomCtto])); ?>&nbsp;</td>
				<td><? echo $FilaMod["cod_contrato"]; ?>&nbsp;</td>
				<td><? echo $FilaMod[fecha_inicio]; ?>&nbsp;</td>
				<td><? echo $FilaMod[fecha_termino]; ?>&nbsp;</td>
				<td>
				<? 
				if($FilaMod[cod_tipo_contrato]=='P')
					echo "Permanente"; 
				else
					echo "No Permanente"; 
				?>&nbsp;
				</td>
				<td><? echo $CC; ?>&nbsp;</td>
				<td><? echo ucwords(strtolower($FilaMod[ape_paterno]." ".$FilaMod[ape_materno]." ".$FilaMod["nombres"]));?>&nbsp;</td>
				<td><? echo $FilaMod["rut"]; ?>&nbsp;</td>
				<td align="center"><? echo $FilaMod[nro_tarjeta]; ?>&nbsp;</td>
				<td align="center"><? echo $FilaMod["activo"]; ?>&nbsp;</td>
				<td align="center"><? echo $FilaMod[sexo]; ?>&nbsp;</td>
				<td align="center">
				<? 
					if($FilaMod[descrip_turno]!='')
						echo substr($FilaMod[descrip_turno],0,5);
					else
						echo "Sin Turno";
				?>
				&nbsp;</td>
				<?
					$Entradas=CalculaES_HH('E',$FilaMod["rut"],$FilaMod[nro_tarjeta],$FilaMod[cod_turno],$TxtFecha,$TxtFechaH);
					$Salidas=CalculaES_HH('S',$FilaMod["rut"],$FilaMod[nro_tarjeta],$FilaMod[cod_turno],$TxtFecha,$TxtFechaH);
					//$HH=CalculaES_HH('HH',$FilaMod["rut"],$FilaMod[nro_tarjeta],$FDesde,$FHasta);
					$HH=HHxTurno($FilaMod[cod_turno],$Entradas);
					$TotEnt=$TotEnt+$Entradas;
					$TotSal=$TotSal+$Salidas;
					$TotHH=$TotHH+$HH;
					$CantMeses=DifMeses($TxtFecha,$TxtFechaH);
					$TopeCantMesHH=$CantMeses*$HHMens;
					
						
					
				?>
				<td align="right"><? echo number_format($Entradas,0,'','.');?></td>
				<td align="right"><? echo number_format($Salidas,0,'','.');?></td>
				<td align="right">
				<?
					if($TopeCantMesHH<$HH)
					{
						echo "<span style='color:#FF0000'>".number_format($HH,0,'','.')."</span>";
					}
					else
					{

						echo number_format($HH,0,'','.');
					}	
				?>
				</td>
				</tr>
			<?
				$Cont++;
			   }
		}	   
		?>
		<tr>
			<td align="left" colspan="14">Cantidad de Registros:&nbsp;<? echo $Cont;?></td> 
			<td align="right"><? echo number_format($TotEnt,0,'','.');?></td>
			<td align="right"><? echo number_format($TotSal,0,'','.');?></td>
			<td align="right"><? echo number_format($TotHH,0,'','.');?></td>
		</tr>
	  </table>
	<? 
function CalculaES_HH($Tipo,$Rut,$Tarjeta,$Turno,$FDesde,$FHasta)
{
	$Cant=0;$ContHrs=0;
	switch($Tipo)
	{
		case "E":
		case "S":
			$Consulta="SELECT ifnull(count(*),0) as cant from uca_web.uca_accesos_personas where rut='".$Rut."' and tipo='".$Tipo."' ";
			//$Consulta.="and nro_tarjeta='".$Tarjeta."' ";
			$Consulta.="and fechahora between '".$FDesde." 00:00:00' and '".$FHasta." 23:59:59'";
			$RespCalc=mysqli_query($link, $Consulta);
			$FilaCalc=mysql_fetch_array($RespCalc);
			//if($Rut=='13850949-4')
			//	echo $Consulta."<br>";
			$Cant=$FilaCalc["cant"];
		break;
	
	}
	return($Cant);
}
function HHxTurno($CodTurno,$Entradas)
{
	switch($CodTurno)
	{
		case "1"://ADMINISTRATIVO
			$HH=$Entradas*9;
		break;
		case "2"://TURNOS A
			$HH=$Entradas*8;
		break;
		case "3"://TURNOS AB
			$HH=$Entradas*8;
		break;
		case "4"://TURNOS ABC
			$HH=$Entradas*12;
		break;
		default:
			$HH=$Entradas*9;//SIN TURNO ASIGNADO
		break;
	}
	return($HH);

}
function BuscaMarcas($RutEmp,$CodCtto,$Rut,$Estado,$FDesde,$FHasta)
{
	global $DatosRegMostrados;
	
	$MuestraReg=0;
	/*$Consulta = "SELECT distinct t3.rut_empresa, t1.rut, t3.razon_social from ";
	$Consulta.= " uca_web.uca_accesos_personas as t1 inner join sget_personal as t2 on t1.rut=t2.rut ";
	$Consulta.= " inner join sget_personal_historia as t5 on t1.rut=t5.rut ";
	$Consulta.= " and (t1.fechahora >= concat(t5.fecha_ingreso,' 00:00:00') and t1.fechahora <= concat(t5.fecha_termino,' 23:59:59'))"; 
	$Consulta.= " inner join sget_contratistas as t3 on t2.rut_empresa=t3.rut_empresa";
	$Consulta.= " where t1.rut='".$Rut."' and t1.fechahora between '".$FDesde." 00:00:00' and '".$FHasta." 23:59:59' and t2.rut_empresa <> '61704000-k'";
	$Consulta.= " and t2.rut_empresa = '".$RutEmp."' and t2.cod_contrato = '".$CodCtto."'";
	$Consulta.=" and t2.nro_tarjeta<>'00000000' and t2.estado<>'I' ";*/
	
	$Consulta = "SELECT count(*) as cant_reg from sget_personal as t1 ";
	$Consulta.= "inner join sget_personal_historia as t2 on t1.rut=t2.rut and t2.rut_empresa = '".$RutEmp."' and t2.cod_contrato = '".$CodCtto."' ";
	switch($Estado)
	{
		case "1":
			$Consulta.=" and t2.activo='S' ";
		break;
		case "2":
			$Consulta.=" and t2.activo='N' ";
		break;
	}
	$Consulta.= "inner join uca_web.uca_accesos_personas as t3 on t2.rut=t3.rut ";
	$Consulta.= "and (t3.fechahora >= concat(t2.fecha_ingreso,' 00:00:00') and t3.fechahora <= concat(t2.fecha_termino,' 23:59:59'))"; 
	$Consulta.= "where t1.rut='".$Rut."' and (t3.fechahora between '".$FDesde." 00:00:00' and '".$FHasta." 23:59:59') ";
	$Consulta.= "group by t1.rut,t2.cod_contrato,t2.rut_empresa ";
	$RespMarcas=mysqli_query($link, $Consulta);
	//if($Rut=='13850949-4')
	//	echo $Consulta."<br>";
	if($FilaMarcas=mysql_fetch_array($RespMarcas))
	{
		$MuestraReg=$FilaMarcas["cant_reg"];
		//PARA TRABAJADORES QUE TIENEN 2 HISTORIAL DENTRO DEL MISMO CONTRATO Y RANGO DE FECHAS
		if($DatosRegMostrados!='')
		{
			$Datos=explode('~',$DatosRegMostrados);
			
			if($Datos[0]==$CodCtto&&$Datos[1]==$Rut&&$Datos[2]>=$FDesde&&$Datos[3]<=$FHasta)
			{
				//echo "if(".$Datos[0]."==".$CodCtto."&&".$Datos[1]."==".$Rut."&&".$Datos[2].">=".$FDesde."&&".$Datos[3]."<=".$FHasta.")<br>";
				$MuestraReg=0;
			}
		}
		$DatosRegMostrados=$CodCtto."~".$Rut."~".$FDesde."~".$FHasta;
		
	}

	return($MuestraReg);
}
function DifMeses($FecIni,$FecFin)
{

//$fechaInicio ="13-01-2011"; 
//$fechaActual = "12-02-2011"; 

$diaActual = substr($FecFin, 8, 2); 
$mesActual = substr($FecFin, 5, 2); 
$anioActual = substr($FecFin, 0, 4); 
$diaInicio = substr($FecIni, 8, 2); 
$mesInicio = substr($FecIni, 5, 2); 
$anioInicio = substr($FecIni, 0, 4); 

$b = 0; 
$mes = $mesInicio-1; 
if($mes==2)
{ 
	if(($anioActual%4==0 && $anioActual%100!=0) || $anioActual%400==0)
	{ 
		$b = 29; 
	}
	else
	{ 
		$b = 28; 
	} 
} 
else 
	if($mes<=7)
	{ 
		if($mes==0)
		{ 
			$b = 31; 
		} 

	else if($mes%2==0){ 

$b = 30; 

} 

else{ 

$b = 31; 

} 

} 

else if($mes>7){ 

if($mes%2==0){ 

$b = 31; 

} 

else{ 

$b = 30; 

} 

} 

if(($anioInicio>$anioActual) || ($anioInicio==$anioActual && $mesInicio>$mesActual) || 

($anioInicio==$anioActual && $mesInicio == $mesActual && $diaInicio>$diaActual)){ 

echo "La fecha de inicio ha de ser anterior a la fecha Actual"; 

}else{ 

if($mesInicio <= $mesActual){ 

$anios = $anioActual - $anioInicio; 

if($diaInicio <= $diaActual){ 

$meses = $mesActual - $mesInicio; 

$dies = $diaActual - $diaInicio; 

}else{ 

if($mesActual == $mesInicio){ 

$anios = $anios - 1; 

} 

$meses = ($mesActual - $mesInicio - 1 + 12) % 12; 

$dies = $b-($diaInicio-$diaActual); 

} 

}
else
{ 
	$anios = $anioActual - $anioInicio - 1; 
	
	if($diaInicio > $diaActual){ 
	
	$meses = $mesActual - $mesInicio -1 +12; 
	
	$dies = $b - ($diaInicio-$diaActual); 
	
	}
	else
	{ 
	$meses = $mesActual - $mesInicio + 12; 
	$dies = $diaActual - $diaInicio; 
	} 

}
} 
//echo "MESES:".(intval($meses)+1);
return(intval($meses)+1);

/*echo "A�os: ".$anios." <br />"; 

echo "Meses: ".$meses." <br />"; 

echo "D�as: ".$dies." <br />"; */


}
function ObtieneHHMens()
{
	    $HHMens=180;//DEFAULT
		$Consulta = "SELECT valor_subclase1 as cant_hh from proyecto_modernizacion.sub_clase where cod_clase='30026' and cod_subclase='1'";			
		$RespSC=mysqli_query($link, $Consulta);
		if ($FilaSC=mysql_fetch_array($RespSC))
		{
			$HHMens=$FilaSC[cant_hh];
			//echo "HH MENS: ".$HHMens;
		}
		return($HHMens);
}
?>
</form>
</body>
</html>