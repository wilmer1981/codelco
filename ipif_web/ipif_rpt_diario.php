<?  session_start();
	session_register('NumNov');
	$NumNov='';
	include("../principal/conectar_ipif_web.php");
	include("funciones/ipif_funciones.php");
	$FechaSist=date("d/m/Y");
	if(!isset($TxtFecha))
		$TxtFecha=date("d-m-Y");
	if(!isset($TxtFecha2))
		$TxtFecha2=date("d-m-Y");
	$CODIGOCLASE=CODIGOCLASE();	
?>
<title>
Novedades Diarias
</title>
<link href="estilos/ipif_style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/ipif_funciones.js"></script>
<script language="javascript">
function Proceso(Opt)
{
	var f=document.FrmProceso;
	switch (Opt)
	{
		case "B":
			f.action='ipif_rpt_diario.php?Buscar=S';
			f.submit();
		break;
		case "ADM":
		
		case "I":
			window.print();
			break;
		case "S":
			window.close();
		break;
	}
}
function Mod(NS)
{
	//alert(NS);
	var URL="ipif_solicitud_visualizacion.php?Opt=M&NumNov2="+NS;
	var opciones='top=0,left=2,toolbar=0,resizable=1,menubar=0,status=1,width=1050,height=600,scrollbars=1';
	window.open(URL,'',opciones)

}
</script>

<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=180 scrolling=no height=180></IFRAME></DIV>
<form name="FrmProceso" action="" method="post" ENCTYPE="multipart/form-data">
 <?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'novedades_diarias.png',$CookieRut)
 ?>
  <table width="970" align="center"  border="0" cellpadding="0"  cellspacing="0"  class="TablaPricipalColor" >
  <tr>
	<td height="15"><img src="archivos/images/interior/esq01.png" width="15" height="15"></td>
	<td width="970" height="15"background="archivos/images/interior/form_arriba0.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq02.png" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq0.png">&nbsp;</td>
   <td><table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">

     <tr>
       <td height="8" colspan="2" align="left" class="formulario" >	     </td>
       <td colspan="2" class="formulario" >&nbsp;</td>
       <td width="362" colspan="2" align="right" >
	   	<a href="JavaScript:Proceso('B')"><img src="archivos/Find.png"  border="0" alt="Buscar" align="absmiddle"></a>
		<a href="JavaScript:Proceso('I')"><img src="archivos/impresora.png" border="0" alt="Imprimir" align="absmiddle" /></a> 
	    <a href="JavaScript:Proceso('S')"><img src="archivos/close.png"  alt="Volver " border="0" align="absmiddle" /></a>	   </td>
       </tr>
     <tr>
       <td width="84" align="left" class="formulario" >Descripci&oacute;n</td>
       <td colspan="2" align="left" class="formulario" ><label>
         <input type="text" name="TxtDescripcion" value="<? echo $TxtDescripcion; ?>" size="100">
       </label></td>
       <td colspan="3" >&nbsp;</td>
     </tr>
     <tr>
       <td align="left" class="formulario" >Fecha</td>
       <td width="140" align="left" class="formulario" ><input name="TxtFecha" type="text" style="width:70" id="TxtFecha" value="<? echo $TxtFecha; ?>" />
         <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFecha,TxtFecha,popCal);return false"></td>
       <td width="324"  align="left" class="formulario" ><input name="TxtFecha2" type="text" style="width:70" id="TxtFecha2" value="<? echo $TxtFecha2; ?>" />
         <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFecha2,TxtFecha2,popCal);return false"></td>
       <td colspan="3" >&nbsp;</td>
     </tr>
     <tr>
       <td align="left" class="formulario" >Tipo</td>
       <td colspan="2" align="left" class="formulario" ><select name="CmbTipo" id="CmbPerfil" >
         <option value="-1" class="InputRojo">Todos</option>
         <?
				$Consulta = "select * from ipif_parametros_sistema where cod_parametro in ('3','4','5')  ";			
				$Respp=mysql_query($Consulta);
				while ($FilaCrit=mysql_fetch_array($Respp))
				{
					if ($CmbTipo==$FilaCrit["cod_parametro"])
						echo "<option selected value='".$FilaCrit["cod_parametro"]."'>".ucfirst($FilaCrit["descripcion"])."</option>\n";
					else
						echo "<option value='".$FilaCrit["cod_parametro"]."'>".ucfirst($FilaCrit["descripcion"])."</option>\n";
				}
				?>
       </select>
	     </td>
       <td colspan="3" >&nbsp;</td>
     </tr>
     
       </table>
	 <table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
		<tr class="TituloCabecera">
		<td width="75"  class="TituloCabecera" >N&deg; Novedad </td>
		<td width="86" class="TituloCabecera"  >Turno</td>
		<td width="86" class="TituloCabecera"  >Fecha</td>
		<td width="478"  class="TituloCabecera" >Novedad</td>
		<td width="172"  class="TituloCabecera" >Originador</td>
		<td width="42" class="TituloCabecera"  >&nbsp;</td>
		<td width="37" class="TituloCabecera"  >&nbsp;</td>
		</tr>
		<?
		if($Buscar=='S')
		{
			$Cuenta=CuentaRut($CookieRut);
			$Ceco=CECOFuncionario($Cuenta);
			$FechaI=FechaAMD($TxtFecha);
			$FechaT=FechaAMD($TxtFecha2);
			$Consulta="select * from ipif_novedades where fecha_ingreso between '".$FechaI."' and '".$FechaT."' and ceco_origen='".$Ceco."' ";
			if($TxtDescripcion != '')
				$Consulta.=" and  upper(observacion) like '%".strtoupper($TxtDescripcion)."%' ";
			if($CmbTipo!='-1')
				switch($CmbTipo)
				{
					case "3":
						$Consulta.=" and mantencion='S' ";
					break;
					case "4":
						$Consulta.=" and envio_jefe='S' ";
					break;
					case "5":
						$Consulta.=" and (mantencion <> 'S' and envio_jefe <> 'S') ";
					break;
				}
				
			$RespSolp=mysql_query($Consulta);
			//echo $Consulta;
			while($FilaSolp=mysql_fetch_array($RespSolp))
			{
				$TxtFecha=$FilaSolp[fecha_ingreso];
				$textnovedad=$FilaSolp["observacion"];
				$InfGer=$FilaSolp[informe_gerencia];
				$Dia=substr($FilaSolp[fecha_ingreso],8,2);
				$T='T'.Turno($FilaSolp[turno]);
				$Hora=substr($FilaSolp[hora],0,5);
				$Codigo=$Dia.'-'.$T.'-'.$Hora;
				$Candado=$FilaSolp[estado];
				if($Candado==1)
					$Candado=1;
				else	
					$Candado=2;
			?>
			<tr >
			<td ><? echo $FilaSolp["nro_solicitud"]; ?></a>&nbsp;</td>
			<td ><? echo $Codigo; ?>&nbsp;</td>
			<td >
			 <?
			 echo FechaAMD($FilaSolp[fecha_ingreso]);
			?>&nbsp;
			</td>
			<td ><? echo $FilaSolp["observacion"]; ?>&nbsp;</td>
			<td ><? echo NombreOrig($FilaSolp[rut_originador]); ?>&nbsp;</td>
			<td align="center">
			<?
			if($Candado == '1')
			{
				?>
				<img src="archivos/candado_abierto.png"  border="0" alt="Novedad Pendiente" align="absmiddle">
			<?
			}
			else
			{
				?>
				<img src="archivos/candado_cerrado.gif"  border="0" alt="Novedad Cerrada" align="absmiddle">
				
			<?
			}
			?>
			</td>
			<td ><a href="JavaScript:Mod('<? echo $FilaSolp["nro_solicitud"];?>')"><img src="archivos/Find.png"  border="0" alt="Ver Novedad" align="absmiddle"></a></td>
			</tr>
			<?
			}
		}	
		 
	?>
   </table>
   </td>
   <td  width="15" background="archivos/images/interior/form_der0.png">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq03.png" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo0.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq04.png" width="15" height="15" /></td>
  </tr>
  </table>
  <?
  
  
  CierreEncabezado()
  
  
  ?>
</form>
</body>
