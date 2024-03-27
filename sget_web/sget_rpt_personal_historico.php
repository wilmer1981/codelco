<?
		include("../principal/conectar_sget_web.php");
		include("funciones/sget_funciones.php");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

?>
<html>
<head>
<title>Reporte Personas Historico</title>

<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Limpia()
{
	var f = document.frmpersonal;
	f.TxtFInicio.value=''	
	f.TxtFTermino.value=''	
	f.TxtFInicio.style.background='#FFFFFF';//
	f.TxtFTermino.style.background='#FFFFFF';//
}
function Procesos(TipoProceso)
{
	var f = document.frmpersonal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "R":	
			f.action ="sget_rpt_personal_historico.php?Recarga=S";
			f.submit();
		break;
		case "C"://BUSCAR
			if(f.TxtFInicio.value!=''&&f.TxtFTermino.value=='')
				f.TxtFTermino.value=f.TxtFInicio.value;
			f.action = "sget_rpt_personal_historico.php?Buscar=S";
			f.submit();
		break;
		case "E"://EXCEL
			URL='sget_rpt_personal_historico_excel.php?TxtRutPrv='+f.TxtRutPrv.value+"&TxtDv="+f.TxtDv.value+"&TxtApellido="+f.TxtApellido.value+"&TxtFInicio="+f.TxtFInicio.value+"&TxtFTermino="+f.TxtFTermino.value;
			URL=URL+"&TxtCtto="+f.TxtCtto.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
			break;
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=22";
		break;
	}
}
</script>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>

<form name="frmpersonal" action="" method="post">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'rpt_personal.png')
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
		<td align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td align="right" class='formulario2'>
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
		
		   	  	<a href="JavaScript:Procesos('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp;
	<a href="JavaScript:Procesos('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a>
		
		<a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>		</td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
  <tr>
    <td width="155" height="17" class='formulario2'>Run</td>
    <td width="349" class="formulario2" >
	
<input name='TxtRutPrv' type='text'   value='<? $TxtRutPrv;?>' size='12' maxlength='8' onBlur=CalculaDv(this.form,'TxtRutPrv','TxtDv') onKeyDown="ValidaIngreso('S',false,this.form,'TxtDv')">-<input name="TxtDv" type="text"  id="TxtDv" value="<? $TxtDv;?>"  size="3" maxlength="1">      
    <td width="148" class="formulario2" >
    
    <td width="250" class="formulario2" >
  </tr>
  <tr>
    <td height="17" class='formulario2'>Apellido Paterno </td>
    <td class='formulario2'><input name="TxtApellido" type="text" id="TxtApellido" value="<? echo $TxtApellido; ?>" size="45">      
    <td class='formulario2'>
    
    <td class='formulario2'>
  </tr>
  <tr>
    <td class='formulario2'>Contrato</td>
    <td class='formulario2' ><input name="TxtCtto" type="text" id="TxtCtto" value="<? echo $TxtCtto; ?>" size="25"> </td>
    <td colspan="2" class='formulario2' >&nbsp;</td>
    </tr>
  <tr>
    <td class='formulario2'>Fecha Inicio Ctto. </td>
    <td class='formulario2' ><input name="TxtFInicio" type="text" readonly   size="10" value="<? echo $TxtFInicio; ?>"  >
      <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFInicio,TxtFInicio,popCal);return false">&nbsp;<a href="JavaScript:Limpia(1)"></a> Fecha Termino Ctto.
      <input name="TxtFTermino" type="text" readonly   size="10" value="<? echo $TxtFTermino; ?>"  >
      <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFTermino,TxtFTermino,popCal);return false">&nbsp;<a href="JavaScript:Limpia()"><img src="archivos/ico_eliminar.gif"   alt="Limpiar Fecha "  border="0" align="absmiddle" /></a></td>
    <td colspan="2" class='formulario2' >&nbsp;</td>
  </tr>
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
		<tr>
		<td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
		<td>
		<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<tr>
		<td width="12%" align="center"  class="TituloTablaVerde" >Run </td>
		<td width="8%" align="center"  class="TituloTablaVerde">Nombre </td>
		<td width="8%"align="center"  class="TituloTablaVerde" >Ap.Paterno</td>
		<td width="7%"align="center"  class="TituloTablaVerde" >Ap.Materno</td>
		<td width="5%" align="center"  class="TituloTablaVerde">Sexo</td>
		<td width="8%"align="center"  class="TituloTablaVerde">Contrato</td>
		<td width="8%" align="center"  class="TituloTablaVerde">Empresa</td>
		<td width="9%" align="center"  class="TituloTablaVerde">Fec.&nbsp;Inicio</td>
		<td width="9%" align="center"  class="TituloTablaVerde">Fec.&nbsp;Termino</td>
		<td width="9%" align="center"  class="TituloTablaVerde">Nro. Tarjeta</td>
		</tr>
		<?
		$Consulta="SELECT t1.cod_contrato,t1.rut_empresa,t1.rut,fecha_ingreso,t1.fecha_termino,t2.nombres,t2.ape_paterno,t2.ape_materno,t2.sexo,t2.nro_tarjeta,t5.razon_social from sget_personal_historia t1 ";
		$Consulta.=" left join sget_personal t2  on t1.rut=t2.rut ";
		$Consulta.=" left join sget_contratos t4  on t1.cod_contrato=t4.cod_contrato ";
		$Consulta.=" left join sget_contratistas t5  on t1.rut_empresa=t5.rut_empresa ";
		$Consulta.="  where t1.rut<>''";// and t1.activo='N' 
		if($TxtRutPrv!='')
			$Consulta.= " and t1.rut= '".str_pad($TxtRutPrv,8,'0',l_pad)."-".$TxtDv."' ";
		if($TxtApellido!='')
			$Consulta.= " and upper(t2.ape_paterno) like ('%".strtoupper(trim($TxtApellido))."%') ";
		if($TxtCtto != "")
			$Consulta.= " and upper(t1.cod_contrato) like ('%".strtoupper(trim($TxtCtto))."%') ";
		if($TxtFInicio!=''&&$TxtFTermino)
			$Consulta.= " and t1.fecha_ingreso >= '".$TxtFInicio."' and  t1.fecha_termino <= '".$TxtFTermino."'";	
		$Consulta.=" group by t1.rut order by t2.ape_paterno";
		//echo $Consulta;
		$RespMod=mysqli_query($link, $Consulta);
		$Cont=0;
		while($FilaMod=mysql_fetch_array($RespMod))
		{
			$Run=$FilaMod["rut"];
			$RazonSocial=str_replace(' ','&nbsp;',FormatearNombre($FilaMod[razon_social]));
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
			$FechaInicio=$FilaMod[fecha_ingreso];
			$FechaTermino=$FilaMod[fecha_termino];
		
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
			?>
			
			<td >
				<a  href="sget_info_personal.php?run=<? echo $Run;?>"  target="_blank"><img src="archivos/info2.png"   alt="Informaci�n Personal"  border="0" align="absmiddle" /></a><?  echo FormatearRun($Run); ?></td>
			<td><? echo FormatearNombre($Nombre); ?>&nbsp;</td>
			<td><? echo FormatearNombre($Paterno); ?>&nbsp;</td>
			<td><? echo FormatearNombre($Materno); ?>&nbsp;</td>
			<td><? echo $Sexo; ?>&nbsp;</td>
			<td><a href="sget_info_ctto_ac.php?Ctto=<? echo $FilaMod["cod_contrato"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Contrato" border="0"  align="absmiddle" /></a><? echo $Contrato; ?>&nbsp;</td>
			<td><a href="sget_info_empresa.php?Emp=<? echo $FilaMod["rut_empresa"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Empresa" border="0"  align="absmiddle" /></a><? echo $RazonSocial; ?>&nbsp;</td>
			<td><? echo $FechaInicio; ?>&nbsp;</td>
			<td><? echo $FechaTermino; ?>&nbsp;</td>
			<!--<td><? echo $AFP; ?>&nbsp;</td>-->
			<td ><? echo $NroTarjeta; ?>&nbsp;</td>
			<!--<td><? echo ucwords(strtolower($Comuna)); ?>&nbsp;</td>-->
			</tr>
		<?
			$Cont++;
		}
		?>
		<tr><td width="12%" align="left"  class="TituloTablaVerde" colspan="10" >Cantidad Registros:&nbsp;<? echo number_format($Cont,0,'','.');?></td></tr>
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