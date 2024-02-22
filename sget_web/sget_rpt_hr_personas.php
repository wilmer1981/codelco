<?
		include("../principal/conectar_sget_web.php");
		include("funciones/sget_funciones.php");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

 $CodigoDeSistema = 27;
 $CodigoDePantalla = 7;
 if(isset($CodCtto))
 	$TxtBuscaCod=$CodCtto;
if(!isset($CmbEmpresa))
	$CmbEmpresa='-1';
if(!isset($TxtFechaInicio)&&!isset($TxtFechaTermino))
{
	$TxtFechaInicio=date('Y')."-".date('m')."-01";
	$TxtFechaTermino=date('Y-m-d');	
}	
?>
<html>
<head>
<title>Reporte personas por hoja de Ruta</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">

function Limpia()
{
		var f = document.frmPrincipal;
		f.TxtFechaInicio.value=''	
		f.TxtFechaTermino.value=''	
		f.TxtFechaTermino.style.background='#FFFFFF';//
		f.TxtFechaInicio.style.background='#FFFFFF';//
}
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "R":	
			f.action ="sget_rpt_hr_personas.php?Recarga=S";
			f.submit();
		break;
		case "C"://BUSCA EMPRESA EN SISTEMA CONTRATOS VENTANAS Y LOS EXPORTA HACIA SISTEMA UCAS
			f.action = "sget_rpt_hr_personas.php?Buscar=S";
			f.submit();
		break;
		case "E"://EXCEL
			URL='sget_rpt_hr_personas_excel.php?CmbEmpresa='+f.CmbEmpresa.value+'&CmbContrato='+f.CmbContrato.value+"&TxtFechaInicio="+f.TxtFechaInicio.value+"&TxtFechaTermino="+f.TxtFechaTermino.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
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
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="ColorTabla02" >
	<tr>
		<td align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td align="right" class='formulario2'>
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
		
		   	  	<a href="JavaScript:Procesos('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp;
	<a href="JavaScript:Procesos('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a>
		
		<a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>		</td>
	</tr>
</table>
        <table width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
     <tr>
    <td width="168" height="27"class='formulario2'>Fecha &nbsp;Inicio Desde </td>
    <td width="268" class='formulario2' >
	
	<input name="TxtFechaInicio" type="text" readonly   size="10" value="<? echo $TxtFechaInicio; ?>"  >
	&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaInicio,TxtFechaInicio,popCal);return false"></a>&nbsp;<a href="JavaScript:Limpia()"><img src="archivos/ico_eliminar.gif"   alt="Limpiar Fecha "  border="0" align="absmiddle" /></a>
    <td width="122" class='formulario2' >Fecha&nbsp;Inicio Hasta    
    <td width="360" class="formulario2"><input name="TxtFechaTermino" type="text" readonly   size="10"  value="<? echo $TxtFechaTermino; ?>" >      
      &nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaTermino,TxtFechaTermino,popCal);return false">&nbsp;<a href="JavaScript:Limpia()"><img src="archivos/ico_eliminar.gif"   alt="Limpiar Fecha"  border="0" align="absmiddle" /></a>
      </tr>
          <tr>
            <td class="formulario2">Empresa</td>
            <td class="formulario2">
              <SELECT name="CmbEmpresa" id="SELECT" style="width:250" onChange="Procesos('R');" >
                <option value="T" class="NoSelec">Todas</option>
                <?
				$Consulta = "SELECT * from sget_contratistas order by razon_social ";
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbEmpresa==$FilaTC["rut_empresa"])
					{
						echo "<option SELECTed value='".$FilaTC["rut_empresa"]."'>".ucfirst($FilaTC["razon_social"])."</option>\n";
						$Rut=$FilaTC[rut_empresa];
						$Domicilio=$FilaTC[calle];
						$Fono=$FilaTC[telefono_comercial];
						$EMail=$FilaTC[mail_empresa];
						$CodMutual=$FilaTC[cod_mutual_seguridad];
						$FechaVenc=$FilaTC[fecha_ven_cert];
						
					}
					else
						echo "<option value='".$FilaTC["rut_empresa"]."'>".ucfirst($FilaTC["razon_social"])."</option>\n";
				}
				?>
                <option value="*">---SubContratistas---</option>
                <?
				$Consulta1 = "SELECT t2.rut_empresa,t1.razon_social from sget_contratistas t1 inner join sget_sub_contratistas t2 ";
				$Consulta1.= "on t1.rut_empresa=t2.rut_empresa where t2.cod_contrato ='".$CmbContrato."'order by razon_social ";
				$RespSub=mysql_query($Consulta1);
				while ($FilaSub=mysql_fetch_array($RespSub))
				{
					if ($CmbEmpresa==$FilaSub["rut_empresa"])
					{
						echo "<option SELECTed value='".$FilaSub["rut_empresa"]."'>".ucfirst($FilaSub["razon_social"])."</option>\n";
						$Rut=$FilaSub[rut_empresa];
						$Domicilio=$FilaSub[calle];
						$Fono=$FilaSub[telefono_comercial];
						$EMail=$FilaSub[mail_empresa];
						$CodMutual=$FilaSub[cod_mutual_seguridad];
						$FechaVenc=$FilaSub[fecha_ven_cert];
						
					}
					else
						echo "<option value='".$FilaSub["rut_empresa"]."'>".ucfirst($FilaSub["razon_social"])."</option>\n";
				}
				?>
              </SELECT>
            </td>
            <td class="formulario2">&nbsp;</td>
            <td class="formulario2">&nbsp;</td>

            <? 
		if($Check=='S')
		{	
			$checked='checked';
		 	$disabled="";
		}
		else
		{	
			$checked="";
			$disabled="";
		 }
		  
		  ?>
          </tr>
          <tr>
            <td class="formulario2">Contrato</td>
            <td class="formulario2">
              <SELECT name="CmbContrato" style="width:250" onChange="Recarga('<? echo $Opt;?>');">
                <option value="S" SELECTed="SELECTed">Seleccionar</option>
                <?
		$FechaActual=date("Y")."-".date("m")."-".date("d");
		$Consulta="SELECT * from sget_contratos where rut_empresa='".$CmbEmpresa."' order by fecha_termino desc";
		$RespCtto=mysql_query($Consulta);
		while($FilaCtto=mysql_fetch_array($RespCtto))
		{
			if ($FechaActual > $FilaCtto[fecha_termino])
				$Color="red";
			else
				$Color='white';
			if(strtoupper($FilaCtto["cod_contrato"])==strtoupper($CmbContrato))
			{
				echo "<option style='background:".$Color."' value='".$FilaCtto["cod_contrato"]."' SELECTed>".$FilaCtto["cod_contrato"]."--->".strtoupper($FilaCtto["descripcion"])."</option>";
				if($TxtFechaCtto==''||$TxtFechaCtto=='0000-00-00')
					$TxtFechaCtto=$FilaCtto[fecha_termino];
				$FechaIniCtto=$FilaCtto[fecha_inicio];
				$FechaFinCtto=$FilaCtto[fecha_termino];
				$AdmCodelco=$FilaCtto["cod_contrato"];
				$AdmContratista=$FilaCtto["cod_contrato"];
				$AreaTrabajo=$FilaCtto[area_trabajo];
				$TipoCtto=$FilaCtto[cod_tipo_contrato];
				$RutPrev=$FilaCtto[rut_prev];
			}	
			else
				echo "<option style='background:".$Color."' value='".$FilaCtto["cod_contrato"]."'>".$FilaCtto["cod_contrato"]."--->".strtoupper($FilaCtto["descripcion"])."</option>";
		}
		?>
              </SELECT>
            </td>
            <td width="21%" class="formulario2">&nbsp;</td>
            <td colspan="3" class="formulario2">&nbsp;</td>
          </tr>
          <tr>
          <td class="formulario2">&nbsp;</td>
          <td class="formulario2">&nbsp;</td>
            <td class="formulario2">&nbsp;</td>
            <td colspan="3" class="formulario2">&nbsp;</td>
          </tr>
          
      </table>
  </td>
  <td width="15" background="archivos/images/interior/form_der.png"><p>&nbsp;</p>
    </td>
  </tr>
 <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table><br>	
    <table width="944" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
        <td><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
        <td width="914" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
        <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
      </tr>
      <tr>
        <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
        <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td width="11%" class="TituloTablaVerde">&nbsp;</td>
            <td width="8%" align="center" class="TituloTablaVerde">Hoja Ruta </td>
            <td width="11%" align="center" class="TituloTablaVerde">Fecha Ingreso </td>
            <td width="9%" align="center" class="TituloTablaVerde">Contrato</td>
            <td width="17%" align="center" class="TituloTablaVerde">Empresa</td>
            <td width="17%" align="center" class="TituloTablaVerde">Adm.Codelco</td>
            <td width="14%" align="center" class="TituloTablaVerde">Adm.Contratista</td>
            <td width="13%" align="center" class="TituloTablaVerde">Cant.Pers</td>
          </tr>
          <?

if($Buscar=='S')
{
	$Consulta = "SELECT t1.num_hoja_ruta,t1.fecha_ingreso,t1.rut_empresa,t3.razon_social,t1.cod_contrato,t4.descripcion,count(t2.rut_personal) as cant_personas FROM sget_hoja_ruta t1 ";
	$Consulta.="inner join sget_hoja_ruta_nomina t2 on t1.num_hoja_ruta=t2.num_hoja_ruta INNER JOIN sget_contratistas t3 on t1.rut_empresa=t3.rut_empresa INNER JOIN sget_contratos t4 on t1.cod_contrato=t4.cod_contrato ";
	$Consulta.="WHERE t1.fecha_ingreso between '".$TxtFechaInicio."' and '".$TxtFechaTermino."' AND t1.cod_estado_aprobado IN ('14', '7') ";
	$Consulta.="and not isnull(t1.num_hoja_ruta)  ";
	if($CmbEmpresa!='T')
		$Consulta.=" and  t1.rut_empresa='".$CmbEmpresa."' ";
	if($CmbContrato!='S')
		$Consulta.=" and  t1.cod_contrato='".$CmbContrato."' ";
	$Consulta.="group by t1.num_hoja_ruta ORDER BY t1.num_hoja_ruta DESC";	
	//echo $Consulta;
	$Resp = mysql_query($Consulta);
	$cont=1;$TotPers=0;
	while ($Fila_HR=mysql_fetch_array($Resp))
	{
		?>
          <tr>
            <td><a href="sget_hoja_ruta_pdf.php?NumHR=<? echo $Fila_HR["num_hoja_ruta"];?>" target="_blank"><img src="archivos/adobe.png"  alt="Hoja Ruta PDF" border="0" align="absmiddle" /></a> <a href="sget_detalle_estados.php?Opt=M&EsPopup=S&TxtHoja=<? echo $Fila_HR["num_hoja_ruta"];?>" target="_blank"><img src="archivos/btn_observaciones.png"  border="0"   alt="Detalle Hoja de Ruta" align="absmiddle" /></a></td>
            <td ><? echo $Fila_HR["num_hoja_ruta"]."&nbsp;"; ?></td>
            <td ><? echo substr($Fila_HR["fecha_ingreso"],0,10)."&nbsp;"; ?>&nbsp;</td>
            <td ><a  href="sget_info_ctto_ac.php?Ctto=<? echo $Fila_HR["cod_contrato"];?>"  target="_blank"><img src="archivos/info2.png"   alt="Detalle Contrato"  border="0" align="absmiddle" /></a>&nbsp;
			<? 
	  		$DescCtto=DescripCtto($Fila_HR["cod_contrato"]);
			$DescCtto=explode('~',$DescCtto);
			echo $Fila_HR["cod_contrato"]." - ".FormatearNombre($DescCtto[1]); ?></td>
            <td ><a href="sget_info_empresa.php?Emp=<? echo $Fila_HR["rut_empresa"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci&oacute;n Empresa" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp;
              <? 
		    $RazonSoc=DescripcionRazonSocial($Fila_HR["rut_empresa"]);
		  	echo FormatearNombre($RazonSoc)."&nbsp;"; ?></td>
            <td ><?
		   	$VarCodelco=AdmCttoCodelco($Fila_HR["cod_contrato"]);
		   	$array=explode('~',$VarCodelco);
		   	echo FormatearNombre($array[1]).' '.FormatearNombre($array[2]).' '.FormatearNombre($array[3]);
	   		?>
              &nbsp; </td>
            <td ><? 
		  	$VarContratista=AdmCttoContratista($Fila_HR["cod_contrato"]);
	  	 	$array=explode('~',$VarContratista);
	   	 	echo FormatearNombre($array[1]).' '.FormatearNombre($array[2]).' '.FormatearNombre($array[3]);
		  	?>
              &nbsp; </td>
            <?
			$TotPers=$TotPers+intval($Fila_HR[cant_personas]);
			?>
            <td align="right"><? echo $Fila_HR[cant_personas];?> &nbsp; </td>
          </tr>
          <?		
  		$cont++;
	}
}
?>
           <tr>
            <td class="TituloTablaVerde" colspan="7" align="right">Total Personas</td>
            <td class="TituloTablaVerde" align="right"><? echo number_format($TotPers,0,'','.');?></td>
          </tr>
       
        </table></td>
        <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
      </tr>
      <tr>
        <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
        <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
        <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
      </tr>
    </table>
    <br>
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