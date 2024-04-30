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
?>
<html>
<head>
<title>Reporte Documentaci�n Factura</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">

function Limpia(op)
{
	var f = document.frmPrincipal;
	switch(op)
	{
		case '1':
			f.TxtFingrD.value=''	
			f.TxtFingrF.value=''	
			f.TxtFingrD.style.background='#FFFFFF';//
			f.TxtFingrF.style.background='#FFFFFF';//
		break;
		case '2':
			f.TxtFcontD.value=''	
			f.TxtFcontF.value=''	
			f.TxtFcontD.style.background='#FFFFFF';//
			f.TxtFcontF.style.background='#FFFFFF';//
		break;
		case '3':
			f.TxtFlibD.value=''	
			f.TxtFlibF.value=''	
			f.TxtFlibD.style.background='#FFFFFF';//
			f.TxtFlibF.style.background='#FFFFFF';//
		break;

	}
}
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "R":	
			f.action ="sget_rpt_documentacion_factura.php?Recarga=S";
			f.submit();
		break;
		case "C"://BUSCA EMPRESA EN SISTEMA CONTRATOS VENTANAS Y LOS EXPORTA HACIA SISTEMA UCAS
			f.action = "sget_rpt_documentacion_factura.php?Buscar=S";
			f.submit();
		break;
		case "E"://EXCEL
			URL='sget_rpt_documentacion_factura_excel.php?CmbEmpresa='+f.CmbEmpresa.value+'&TxtContrato='+f.TxtContrato.value+"&CmbAnoDF="+f.CmbAnoDF.value+"&CmbMesDF="+f.CmbMesDF.value+"&TxtFingrD="+f.TxtFingrD.value+"&TxtFingrF="+f.TxtFingrF.value+"&TxtFcontD="+f.TxtFcontD.value;
			URL=URL+"&TxtFcontF="+f.TxtFcontF.value+"&TxtFlibD="+f.TxtFlibD.value+"&TxtFlibF="+f.TxtFlibF.value;
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
 EncabezadoPagina($IP_SERV,'rpt_documentacion_factura.png')
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
<table width="100%" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="17" class='formulario2'>Empresa</td>
    <td colspan="2" class="formulario2" ><input name="TxtEmpresa" type="text" id="TxtEmpresa" maxlength="20"  size="6" value="<? echo $TxtEmpresa; ?>" >
      <a href="JavaScript:Procesos('R')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>
      <SELECT name="CmbEmpresa" id="CmbEmpresa" >
        <option value="-1" class="NoSelec">Todas</option>
        <?
	  $Consulta = "SELECT * from sget_contratistas where estado='1' ";
	  if($TxtEmpresa!='')
	  	 $Consulta.= "and  upper(razon_social) like '%".strtoupper(trim($TxtEmpresa))."%' ";
	 	$Consulta.= " order by razon_social ";
		$Resp=mysqli_query($link, $Consulta);
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
    <td width="175"class='formulario2'>Nro. Contrato</td>
    <td width="134" class='formulario2' ><input name="TxtContrato" type="text" id="TxtContrato" value="<? echo $TxtContrato; ?>" size="25"></td>
    <td width="609" class='formulario2' >A&ntilde;o
      <SELECT name="CmbAnoDF" id="CmbAnoDF" >
      <option  value ='T'>Todos</option>
      <?
		for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
	{
		if (isset($CmbAnoDF))
		{
			if ($i==$CmbAnoDF)
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
      Mes&nbsp;&nbsp;
      <SELECT name="CmbMesDF" id="CmbMesDF" >
        	<option  value ='T'>Todos</option>  <?
		 for($i=1;$i<13;$i++)
		{
			if (isset($CmbMesDF))
			{
				if ($i==$CmbMesDF)
				{
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}
				else
				{
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
			}
			else
			{
				if ($i==date("n"))
				{
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}
				else
				{
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
			}
		}
		?>
      </SELECT>    </tr>
  
	<tr>
  <td height="25" class="formulario2"> Fecha Ingreso Documento </td>
            <td class="formulario2" >Desde
              <input name="TxtFingrD" type="text" readonly   size="10" value="<? echo $TxtFingrD; ?>"  >
              <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFingrD,TxtFingrD,popCal);return false">&nbsp;<a href="JavaScript:Limpia()"></a></td>
            <td class="formulario2" >Hasta
              <input name="TxtFingrF" type="text" readonly   size="10" value="<? echo $TxtFingrF; ?>"  >
                <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFingrF,TxtFingrF,popCal);return false">&nbsp;<a href="JavaScript:Limpia('1')"><img src="archivos/ico_eliminar.gif"   alt="Limpiar Fecha "  border="0" align="absmiddle" /></a></td>
          </tr>
	<tr>
	  <td height="33" class="formulario2">Fecha&nbsp;Ingreso Contabilidad </td>
	  <td class="formulario2">Desde
	    <input name="TxtFcontD" type="text" readonly   size="10"  value="<? echo $TxtFcontD; ?>" >
<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFcontD,TxtFcontD,popCal);return false">&nbsp;<a href="JavaScript:Limpia()"></a></td>
	  <td class="formulario2" >Hasta
          <input name="TxtFcontF" type="text" readonly   size="10" value="<? echo $TxtFcontF; ?>"  >
          <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFcontF,TxtFcontF,popCal);return false">&nbsp;<a href="JavaScript:Limpia('2')"><img src="archivos/ico_eliminar.gif"   alt="Limpiar Fecha "  border="0" align="absmiddle" /></a></td>
	  </tr>
	<tr> 
		    <td height="33" class="formulario2">Fecha Liberaci&oacute;n </td>
            <td class="formulario2">Desde
              <input name="TxtFlibD" type="text" readonly   size="10" value="<? echo $TxtFlibD; ?>"  >
              <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFlibD,TxtFlibD,popCal);return false">&nbsp;<a href="JavaScript:Limpia(1)"></a></td>
            <td class="formulario2" >Hasta
              <input name="TxtFlibF" type="text" readonly   size="10" value="<? echo $TxtFlibF; ?>"  >
                <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFlibF,TxtFlibF,popCal);return false">&nbsp;<a href="JavaScript:Limpia('3')"><img src="archivos/ico_eliminar.gif"   alt="Limpiar Fecha "  border="0" align="absmiddle" /></a></td>
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
		<table width="100%"  border="0"  align="center" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
		<tr>
		  <td><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
		  <td width="914" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
		  <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    	</tr>
		<tr>
		<td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
		<td>
		<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<?
		
		$Consulta=" SELECT t1.*,t2.fecha_inicio,t2.fecha_termino,t3.rut_empresa,t3.razon_social from sget_facturas_contrato t1 ";
		$Consulta.=" inner join sget_contratos t2  on t1.cod_contrato=t2.cod_contrato  inner join sget_contratistas t3 ";
		$Consulta.=" on t2.rut_empresa=t3.rut_empresa where t1.cod_contrato<>''";
		if($CmbEmpresa!='-1')
			$Consulta.= " and t2.rut_empresa= '".$CmbEmpresa."'";
		if($TxtContrato!='')
			$Consulta.= " and upper(t1.cod_contrato) like ('%".strtoupper(trim($TxtContrato))."%') ";
		if($CmbAnoDF!='T')
			$Consulta.= " and t1.ano= '".$CmbAnoDF."'";
		if($CmbMesDF!='T')
			$Consulta.= " and t1.mes= '".$CmbMesDF."'";
		if($TxtFingrD!=''&&$TxtFingrF!='' )
			$Consulta.="  and  t1.fecha_ing_doc between '".$TxtFingrD."' and '".$TxtFingrF."'";
		if($TxtFcontD!=''&&$TxtFcontF!='' )
			$Consulta.="  and  t1.fecha_ing_cont between '".$TxtFcontD."' and '".$TxtFcontF."'";		
		if($TxtFlibD!=''&&$TxtFlibF!='' )
			$Consulta.="  and  t1.fecha_liber between '".$TxtFlibD."' and '".$TxtFlibF."'";
		$Consulta.=" order by t3.rut_empresa,t1.cod_contrato,t1.ano,t1.mes";
		$RespMod=mysqli_query($link, $Consulta);
		echo "<input type='hidden' name='CheckCtto'>";
		$Cont=1;		$Encontro='N';
		while($FilaMod=mysql_fetch_array($RespMod))
		{
			$Contrato=$FilaMod["cod_contrato"];
			if($EmpAnt!=$FilaMod[rut_empresa])
			{
				?>
				<tr class="BordeFecha">
				<td colspan="7" class="LinkPestana"><a  href="sget_info_empresa.php?Emp=<? echo $FilaMod[rut_empresa];?>"  target="_blank"><img src="archivos/info2.png"   alt="Informaci�n Empresa"  border="0" align="absmiddle" /></a>&nbsp;Empresa&nbsp;&nbsp;<? echo $FilaMod[rut_empresa];?>&nbsp;&nbsp;&nbsp;<? echo $FilaMod[razon_social];?></td>
				</tr>
				<?
			}
		
			if($ContratoAnt!=$FilaMod["cod_contrato"])
			{
				?>
				<tr class="BordeFecha">
				<td colspan="7" class="LinkPestana"><a  href="sget_info_ctto_ac.php?Ctto=<? echo $FilaMod["cod_contrato"];?>"  target="_blank"><img src="archivos/info2.png"   alt="Detalle Contrato"  border="0" align="absmiddle" /></a>&nbsp;Contrato&nbsp;&nbsp;<? echo $Contrato;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Inicio&nbsp;<? echo $FilaMod["fecha_inicio"];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Termino&nbsp;<? echo $FilaMod[fecha_termino] ?>&nbsp;</td>
				</tr>
			
			  <tr>
			  <td class="TituloTablaVerde" >A&Ntilde;O</td>
			  <td class="TituloTablaVerde" >MES</td>
			  <td class="TituloTablaVerde" >Nro.&nbsp;Factura </td>
			  <td class="TituloTablaVerde" >Fecha&nbsp;Ingreso&nbsp;Contabilidad </td>
			  <td class="TituloTablaVerde" >Fecha&nbsp;Ingreso&nbsp;Documentos </td>
			  <td class="TituloTablaVerde" >Fecha&nbsp;Liberaci&oacute;n </td>
			  <td class="TituloTablaVerde" >Dotaci&oacute;n</td>
			</tr>
		
				<?
				$AnoAnt='';$MesAnt='';
			}
			
			if($AnoAnt!=$FilaMod["ano"])
			{
				?>
				<tr class="FilaAbeja">
				<td colspan="7"><? echo $FilaMod["ano"]."&nbsp;";?></td>
				</tr>
				<?
			}
			if($MesAnt!=$FilaMod["mes"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           )
			{
			?>
				<tr class="FilaAbeja">
				<td>&nbsp;</td>
				<td colspan="6"><? echo $meses[$FilaMod["mes"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           -1]."&nbsp;";?></td>
				</tr>
			<?
			}
			$EmpAnt=$FilaMod[rut_empresa];
			$ContratoAnt=$FilaMod["cod_contrato"];
			$AnoAnt=$FilaMod["ano"];
			$MesAnt=$FilaMod["mes"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ;
			?>
		
		
		<tr class="FilaAbeja">
					
			<td colspan="2">&nbsp;</td>
			<td><? echo $FilaMod[nro_factura];?>&nbsp;</td>
			<td><? echo $FilaMod[fecha_ing_cont]; ?>&nbsp;</td>
			<td><? echo $FilaMod[fecha_ing_doc]; ?>&nbsp;</td>
			<td><? echo $FilaMod[fecha_liber]; ?>&nbsp;</td>
			<td><? echo $FilaMod[dotacion]; ?>&nbsp;</td>
		</tr>
		<?
			$Cont++;
			$Encontro='S';
		}
		if($Encontro=='N')
		{?>
			<tr>
			<td colspan="7"  align="center">No se encontraron Registros asociados a la consulta</td>
			</tr>
			<?
			
		}
		?></table>
	  </td>
	  <td width="1" background="archivos/images/interior/form_der.gif">&nbsp;</td>
	  </tr>
	  <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>
	<br><? 
	
}	
  CierreEncabezado()
?>
</form>

</body>
</html>