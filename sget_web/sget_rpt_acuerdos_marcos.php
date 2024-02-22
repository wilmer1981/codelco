<?
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	if(isset($CodCtto))
		$TxtBuscaCod=$CodCtto;
	if(!isset($CmbEmpresa))
		$CmbEmpresa='-1';
?>
<html>
<head>
<title>Reporte Control Acuerdos Marcos</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	switch(TipoProceso)
	{
		case "C":
			f.action = "sget_rpt_acuerdos_marcos.php?Buscar=S";
			f.submit();
		break;
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=22";
		break;
		case "E"://EXCEL
			//URL='sget_rpt_acuerdos_marcos_excel.php';
			URL='sget_rpt_acuerdos_marcos_excel.php?TxtContrato='+f.TxtContrato.value+"&TxtDescripcion="+f.TxtDescripcion.value+"&CmbAno="+f.CmbAno.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
			break;
	
	}
	
}
</script>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">

</style></head>
<body>
   
<form name="frmPrincipal" action="" method="post">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'rpt_acuerdos_marcos.png')
 ?>
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
  <tr>
    <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
   <td>
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02" >
	<tr>
		<td align="left" class="formulario2"><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td align="right" class="formulario2">
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>&nbsp;   
		<a href="JavaScript:Procesos('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Procesos('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a>&nbsp;
		<a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>
		</td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
  <tr>
    <td width="26%" height="17" class='formulario2'>Contrato</td>
    <td class="formulario2"><input name="TxtContrato" type="text" id="TxtContrato" value="<? echo $TxtContrato; ?>" size="25">  </tr>
  <tr>
    <td height="17" class='formulario2'>Descripci&oacute;n</td>
    <td class="formulario2"><input name="TxtDescripcion" type="text" id="TxtDescripcion" value="<? echo $TxtDescripcion; ?>" size="45">  </tr>
  <tr>
    <td height="17" class='formulario2'>A&ntilde;o</td>
    <td class="formulario2" ><span class="borderbajo">
      <SELECT name="CmbAno" id="CmbAno"  onChange="Proceso('R','<? echo $CmbAno; ?>')">
        <option value="T"  SELECTed="SELECTed">Todos</option>
        <?
	for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
	{
		if (isset($CmbAno))
		{
			if ($i==$CmbAno)
			{
				echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
				echo "<option value='".$i."'>".$i."</option>";
			}
		}
		else
		{
			if ($i==date("Y"))
			{
				echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
				echo "<option value='".$i."'>".$i."</option>";
			}
		}
	}
	?>
      </SELECT>
    </span>
  </tr>
  
<!--  <tr>
    <td width="70"class='formulario2'>Fecha&nbsp;Inicio </td>
    <td ><input name="TxtFechaInicio" type="text" readonly   size="10" value="<? echo $TxtFechaInicio; ?>" >&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaInicio,TxtFechaInicio,popCal);return false">   
    <td width="84" class='formulario2' >Fecha&nbsp;Termino     
    <td width="146" ><input name="TxtFechaTermino" type="text" readonly   size="10"  value="<? echo $TxtFechaTermino; ?>" >&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaTermino,TxtFechaTermino,popCal);return false">    </tr>
	-->
</table>
  </td>
  <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
  </tr>
  <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
    <br>
  <?
  if($Buscar=='S')
  {
   ?>
 <table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
 <tr>
		  <td><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
		  <td width="920" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
		  <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
   	</tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
<tr>
<td width="8%" class="TituloTablaVerde" align="center" rowspan="2">A�o</td>
<td width="10%" class="TituloTablaVerde" align="center" rowspan="2">Rut</td>
<td width="18%" class="TituloTablaVerde" align="center" rowspan="2">Empresa</td>
<td width="10%"class="TituloTablaVerde" align="center" rowspan="2">Contrato</td>
<!--<td width="20%" class="TituloCabecera" align="center">Descripci&oacute;n</td>-->
<td width="10%"class="TituloTablaVerde" align="center" rowspan="2">Dotac. Trab.</td>
<td width="10%"class="TituloTablaVerde" align="center" rowspan="2">Trab. Sindicaliz.</td>
<td width="10%"class="TituloTablaVerde" align="center" rowspan="2">Nombre Sindicato</td>
<td width="10%"class="TituloTablaVerde" align="center" rowspan="2">Dotaci�n Seguro Acc.</td>
<td width="10%"class="TituloTablaVerde" align="center" rowspan="2">N� P�liza Seg. Complem.</td>
<?
$Consulta="SELECT t1.nombre_subclase as nom_eva,t1.cod_subclase as cod_eva from proyecto_modernizacion.sub_clase t1 where t1.cod_clase='30014' order by cod_subclase";
//echo $Consulta."<br>";
$RespBonos=mysql_query($Consulta);
while($FilaBonos=mysql_fetch_array($RespBonos))
{
	echo "<td class='TituloTablaVerde' width='1%' colspan='2' align='center'>".$FilaBonos[nom_eva]."&nbsp;</td>";
}

?>
</tr>	
<tr>
<?
$RespBonos=mysql_query($Consulta);
while($FilaBonos=mysql_fetch_array($RespBonos))
{
	echo "<td class='TituloTablaVerde' width='1%' align='center'>Dot.</td>";
	echo "<td class='TituloTablaVerde' width='1%' align='center'>Tot.Pag</td>";
}
?>
</tr>
<?
	$Consulta="SELECT t1.cod_contrato,t1.ano,t2.descripcion,t2.rut_empresa ";
	$Consulta.=" from sget_bonos_contratistas t1  inner join sget_contratos t2  on t1.cod_contrato=t2.cod_contrato ";
	$Consulta.=" left join  sget_administrador_contratos t3  on t2.rut_adm_contrato=t3.rut_adm_contrato ";
	$Consulta.="  where t1.cod_contrato<>'' ";
	if($TxtContrato!='')
		$Consulta.= " and upper(t1.cod_contrato) like ('%".strtoupper(trim($TxtContrato))."%') ";
	if($TxtDescripcion!='')
		$Consulta.= " and upper(t2.descripcion) like ('%".strtoupper(trim($TxtDescripcion))."%') ";
	if($CmbEmpresa != "-1")
		$Consulta.="  and  t2.rut_empresa='".$CmbEmpresa."' ";
	if($CmbAno!= "T")
		$Consulta.="  and  t1.ano='".$CmbAno."' ";
	$Consulta.=" group by t1.cod_contrato,t1.ano";	
	$RespCtto=mysql_query($Consulta);
	echo "<input type='hidden' name='CheckCtto'>";
	while($FilaCtto=mysql_fetch_array($RespCtto))
	{
		$A�o=$FilaCtto["ano"];
		$Contrato=$FilaCtto["cod_contrato"];
		$Descripcion=$FilaCtto["descripcion"];
		$RutEmp=$FilaCtto[rut_empresa];
		$DescripEmp=DescripcionRazonSocial($RutEmp);
	    ?>
		<tr>
		<td align="center"><? echo $A�o;?></td>
		<td align="left"><a href="sget_info_empresa.php?Emp=<? echo $FilaCtto[rut_empresa];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Empresa" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp;<? echo FormatearRun($RutEmp); ?>&nbsp;</td>
		<td><? echo FormatearNombre($DescripEmp); ?>&nbsp;</td>
		<td><a href="sget_info_ctto_ac.php?Ctto=<? echo $FilaCtto["cod_contrato"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Contrato" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp;<?  echo $FilaCtto["cod_contrato"]; ?>&nbsp;</td>
		<!--<td><? //echo ucfirst(strtolower($Descripcion)); ?>&nbsp;</td>-->
		<td align="center"><? echo PersonasBonosCttoAnual($Contrato,$A�o);?>&nbsp;</td>
		<td align="center"><? echo PersonasSindicalizCtto($Contrato);?>&nbsp;</td>
		<td align="center"><? echo SindicatosCtto($Contrato);?>&nbsp;</td>
		<td align="center"><? echo DotacionSegAcc($Contrato);?>&nbsp;</td>
		<td align="center"><? echo NumPolizaCtto($Contrato);?>&nbsp;</td>
		<?
		$Consulta="SELECT t1.nombre_subclase as nom_eva,t1.cod_subclase as cod_eva from proyecto_modernizacion.sub_clase t1 where t1.cod_clase='30014' order by cod_subclase";
		//echo $Consulta."<br>";
		$RespBonos=mysql_query($Consulta);
		while($FilaBonos=mysql_fetch_array($RespBonos))
		{
			$Consulta="SELECT ifnull(count(*),0) as cant,ifnull(sum(monto),0) as monto from sget_bonos_contratistas where cod_contrato='".$FilaCtto["cod_contrato"]."' and num_bono='".$FilaBonos[cod_eva]."' and ano='".$FilaCtto["ano"]."' group by cod_contrato";
			//echo $Consulta."<br>";
			$Resp2=mysql_query($Consulta);
			if($Fila2=mysql_fetch_array($Resp2))
			{
				echo "<td align='center'>".$Fila2["cant"]."&nbsp;</td>";
				echo "<td align='center'>".number_format($Fila2[monto],0,'','.')."&nbsp;</td>";	
			}
			else
			{
				echo "<td align='center'>&nbsp;</td>";
				echo "<td align='center'>&nbsp;</td>";	
			}
		}
		?>
		</tr>
		<?
	}
	?>
	</table>
  </td>
  <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>
<? 
}
CierreEncabezado()
?>
</form>
</body>
</html>