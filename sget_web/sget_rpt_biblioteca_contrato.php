<?
		include("../principal/conectar_sget_web.php");
		include("funciones/sget_funciones.php");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

 $CodigoDeSistema = 30;
 $CodigoDePantalla = 7;
 if(isset($CodCtto))
 	$TxtBuscaCod=$CodCtto;
if(!isset($CmbEmpresa))
	$CmbEmpresa='-1';

$Consulta ="SELECT nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =30";
$Respuesta = mysql_query($Consulta);
$Fila=mysql_fetch_array($Respuesta);
$Nivel=$Fila["nivel"];  		
	
?>
<html>
<head>
<title>Reporte Biblioteca Contratos</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "R":	
			f.action ="sget_rpt_biblioteca_contrato.php?Recarga=S";
			f.submit();
		break;
		case "C"://BUSCA EMPRESA EN SISTEMA CONTRATOS VENTANAS Y LOS EXPORTA HACIA SISTEMA UCAS
			f.action = "sget_rpt_biblioteca_contrato.php?Buscar=S";
			f.submit();
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

<form name="frmPrincipal" action="" method="post">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'doc_contrato.png')
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
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="ColorTabla02" >
	<tr>
		<td align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td align="right" class='formulario2'>
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
		<a href="JavaScript:Procesos('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a>
		<a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>
		</td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="168" height="17" class='formulario2'>Nro. Contrato</td>
    <td width="750" class="formulario2" ><input name="TxtContrato" type="text" id="TxtContrato" value="<? echo $TxtContrato; ?>" size="25">  </tr>
  <tr>
    <td height="17" class='formulario2'>Descripci&oacute;n Contrato </td>
    <td class='formulario2'><input name="TxtDescripcion" type="text" id="TxtDescripcion" value="<? echo $TxtDescripcion; ?>" size="65">  </tr>
  <tr>
    <td height="17" class='formulario2'>Empresa</td>
    <td class='formulario2'><input name="TxtEmpresa" type="text" id="TxtEmpresa" maxlength="20"  size="6" value="<? echo $TxtEmpresa; ?>" >
			<a href="JavaScript:Procesos('R')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>
<SELECT name="CmbEmpresa" id="CmbEmpresa" >
      <option value="-1" class="NoSelec">Todas</option>
      <?
	  $Consulta = "SELECT * from sget_contratistas where estado='1' ";
	  if($TxtEmpresa!='')
	  	 $Consulta.= "and  upper(razon_social) like '%".strtoupper(trim($TxtEmpresa))."%' ";
	 	$Consulta.= " order by razon_social ";
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if (strtoupper($CmbEmpresa)==strtoupper($FilaTC["rut_empresa"]))
				echo "<option SELECTed value='".$FilaTC["rut_empresa"]."'>".$FilaTC["rut_empresa"]." - ".ucfirst($FilaTC["razon_social"])."</option>\n";
			else
				echo "<option value='".$FilaTC["rut_empresa"]."'>".$FilaTC["rut_empresa"]." - ".ucfirst($FilaTC["razon_social"])."</option>\n";
		}
			?>
    </SELECT>  </tr>
  <tr>
    <td height="17" class='formulario2'>Tipo de Documento</td>
    <td class='formulario2'><SELECT name="CmbTipoDoc" style="width:150" >
      <option value="S">Todos</option>
      <?
	  	$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30010'   ";
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($Fila["cod_subclase"]==$CmbTipoDoc)
				echo "<option value='".$Fila["cod_subclase"]."' SELECTed>".$Fila["nombre_subclase"]."</option>";
			else
				echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
		}
	  
	  ?>
    </SELECT>  
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
  	$dif=0;
	if($TxtFechaInicio != "")
	{		
		$dif=resta_fechas($TxtFechaTermino,$TxtFechaInicio);
	}
  
  if($Buscar=='S')
  {
   
   	if($dif>=0)
  	{
  
		?>
		<table width="960"  border="0"  align="center" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
		<tr>
		  <td><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
		  <td width="914" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
		  <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    	</tr>
		<tr>
		<td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
		<td><table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" >
          <tr>
            <td colspan="6" align="left" class="TituloTablaNaranja" >Documentos Existentes</td>
          </tr>
          <tr align="center">
            <td width="10%" class="TituloTablaVerde">Contrato</td>
			<td width="15%" class="TituloTablaVerde">Tipo</td>
            <td width="30%" class="TituloTablaVerde">Archivo</td>
            <td width="10%" class="TituloTablaVerde">Fecha</td>
            <td width="25%" class="TituloTablaVerde">Obs</td>
            <td width="15%" class="TituloTablaVerde">Tama&ntilde;o(Kb)</td>
          </tr>
          <?
		  $Dir='doc';
		  $Consulta="SELECT * from sget_documentos t1 inner join sget_contratos t2 on t1.num_hoja_ruta=t2.cod_contrato ";
		  $Consulta.="left join sget_contratistas t3  on t2.rut_empresa=t3.rut_empresa where t1.cod_referencia='C' ";
			if($TxtContrato!='')
				$Consulta.= " and upper(t1.num_hoja_ruta) like ('%".strtoupper(trim($TxtContrato))."%') ";
			if($TxtDescripcion!='')
				$Consulta.= " and upper(t2.descripcion) like ('%".strtoupper(trim($TxtDescripcion))."%') ";
			if($CmbEmpresa != "-1")
				$Consulta.="  and  t2.rut_empresa='".$CmbEmpresa."' ";
			if($CmbTipoDoc != "S")
				$Consulta.="  and  t1.cod_tipo_doc='".$CmbTipoDoc."' ";
		  if($Nivel!='1')
		  		$Consulta.= " and t2.rut_adm_contrato='".$CookieRut."'";	
		  $Consulta.=" order by fecha_hora";
		  //echo $Consulta;
		  $Resp=mysql_query($Consulta);
		  while($Fila=mysql_fetch_array($Resp))
		  {
				echo "<tr>\n";
				echo "<td><a href='sget_info_ctto_ac.php?Ctto=".$Fila[num_hoja_ruta]."'  target='_blank'><img src='archivos/info2.png'   alt='Detalle Contrato'  border='0' align='absmiddle' /></a>&nbsp;".$Fila[num_hoja_ruta]."</td>";
				$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30010' and cod_subclase='".$Fila[cod_tipo_doc]."'";
				$Resp2=mysql_query($Consulta);
				$Fila2=mysql_fetch_array($Resp2);
				echo "<td>".$Fila2["nombre_subclase"]."</td>";
				echo "<td ><a href=\"".$Dir."/".$Fila[nombre_archivo]."\" target='_blank'><img src='archivos/atachar.png'   alt='Click Para Abrir Documento'  border='0' align='absmiddle' />".substr($Fila[nombre_archivo],12)."</a></td>\n";
				echo "<td align='center' >".str_replace('-','/',$Fila["fecha_hora"])."</td>\n";
				echo "<td align='center' >".$Fila["observacion"]."&nbsp;</td>\n";
				$Peso=filesize($Dir."/".$Fila[nombre_archivo]);
				echo "<td align='right'>".number_format($Peso/1000,3,",",".")."</td>\n";
				echo "</tr>\n";
		  }	 
		?>
        </table></td>
	  <td width="22" background="archivos/images/interior/form_der.gif">&nbsp;</td>
	  </tr>
	  <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>
	<? 
	}
}	
  CierreEncabezado()
?>
</form>
<? 
if ($dif<0)
{
	echo "<script languaje='JavaScript'>";
	echo "alert('Las fechas No han sido correctamente Ingresadas');";
	echo "Limpia();";
	echo "</script>";
}
?>



</body>
</html>