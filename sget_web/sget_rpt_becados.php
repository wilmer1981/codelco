<?
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
<style type="text/css">
<!--
body {
	background-image: url(archivos/f1.gif);
}
-->
</style>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">

function Procesos(TipoProceso)
{
	var f = document.frmpersonal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "R":	
			f.action ="sget_rpt_becados.php?Recarga=S";
			f.submit();
		break;
		case "C"://BUSCA EMPRESA EN SISTEMA CONTRATOS VENTANAS Y LOS EXPORTA HACIA SISTEMA UCAS
			f.action = "sget_rpt_becados.php?Buscar=S";
			f.submit();
		break;
		case "E"://EXCEL
			URL='sget_rpt_becados_excel.php?TxtRutPrv='+f.TxtRutPrv.value+"&TxtDv="+f.TxtDv.value+"&TxtApellido="+f.TxtApellido.value+"&CmbSexo="+f.CmbSexo.value+"&CmbTipoPersona="+f.CmbTipoPersona.value;
			URL=URL+"&CmbAfp="+f.CmbAfp.value+"&CmbSalud="+f.CmbSalud.value+"&CmbCiudad="+f.CmbCiudad.value+"&CmbComunas="+f.CmbComunas.value+"&CmbCargo="+f.CmbCargo.value;
			URL=URL+"&TxtCtto="+f.TxtCtto.value+"&CmbSindicato="+f.CmbSindicato.value+"&CmbEmpresa="+f.CmbEmpresa.value;
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

<form name="frmpersonal" action="" method="post">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'rpt_becados.png')
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
    <td height="17" class='formulario2'>Run</td>
    <td colspan="3" class="formulario2" >
	
<input name='TxtRutPrv' type='text'   value='<? $TxtRutPrv;?>' size='12' maxlength='8' onBlur=CalculaDv(this.form,'TxtRutPrv','TxtDv') onKeyDown="ValidaIngreso('S',false,this.form,'TxtDv')">-<input name="TxtDv" type="text"  id="TxtDv" value="<? $TxtDv;?>"  size="3" maxlength="1">  </tr>
  <tr>
    <td height="17" class='formulario2'>Apellido Paterno </td>
    <td colspan="3" class='formulario2'><input name="TxtApellido" type="text" id="TxtApellido" value="<? echo $TxtApellido; ?>" size="45">  </tr>
  <tr>
    <td height="17" class='formulario2'>Sexo</td>
    <td width="353" class='formulario2'><SELECT name="CmbSexo" >
      <?
		if ($CmbSexo=="-1")	
		{	
			echo "<option SELECTed value='-1' class='NoSelec'>Todos</option>";
			echo "<option value='M'>Masculino</option>\n";
			echo "<option value='F'>Femenino</option>\n";
		}	 
		if ($CmbSexo=="F")
		{	
			echo "<option value='-1' class='NoSelec'>Todos</option>";
			echo "<option value='M'>Masculino</option>\n";
			echo "<option SELECTed value='F'>Femenino</option>\n";
		}
		if ($CmbSexo=="M")
		{	
			echo "<option value='-1' class='NoSelec'>Todos</option>";
			echo "<option SELECTed value='M'>Masculino</option>\n";
			echo "<option  value='F'>Femenino</option>\n";
		}	 ?>
    </SELECT>
    <td width="148" class='formulario2'>Tipo de Persona  </td>   
    <td width="250" class='formulario2'><SELECT name="CmbTipoPersona">
		<option value="-1" SELECTed="SELECTed">Todos</option>
		<?
		$Consulta="SELECT * from sget_tipo_persona order by descrip_tipo";
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{ 
			if($CmbTipoPersona==$Fila[cod_tipo])
				echo "<option value='".$Fila[cod_tipo]."' SELECTed>".$Fila[descrip_tipo]."</option>";
			else	
				echo "<option value='".$Fila[cod_tipo]."'>".$Fila[descrip_tipo]."</option>";
		}
		?>
        </SELECT></td>   </tr>
  <tr>
    <td class='formulario2'>AFP</td>
    <td class='formulario2' ><SELECT name="CmbAfp">
		<option value="-1" SELECTed="SELECTed">Todos</option>
		<?
		$Consulta="SELECT * from sget_afp where estado='1' order by descripcion_afp";
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($CmbAfp==$Fila[cod_afp])
				echo "<option value='".$Fila[cod_afp]."' SELECTed>".$Fila[descripcion_afp]."</option>";
			else	
				echo "<option value='".$Fila[cod_afp]."'>".$Fila[descripcion_afp]."</option>";
		}
		?>		
        </SELECT></td> 
    
    <td class='formulario2' >Sistema de Salud</td>   
    <td class='formulario2' ><SELECT name="CmbSalud">
            <option value="-1" class="NoSelec">Todos</option>
            <?
	  $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30011' ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbSalud==$FilaTC["cod_subclase"])
				echo "<option SELECTed value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
          </SELECT> </td>   
  </tr>
   <tr>
     <td class="formulario2">Ciudad</td>
        <td align="left" class="formulario2"><SELECT name="CmbCiudad" onChange="Procesos('R')">
		<option value="-1" SELECTed="SELECTed">Todos</option>
		<?
		$Consulta="SELECT * from sget_ciudades order by nom_ciudad";
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($CmbCiudad==$Fila["cod_ciudad"])
				echo "<option value='".$Fila["cod_ciudad"]."' SELECTed>".$Fila[nom_ciudad]."</option>";
			else	
				echo "<option value='".$Fila["cod_ciudad"]."'>".$Fila[nom_ciudad]."</option>";
		}
		?>		  
		
        </SELECT>
        </td>
        <td align="left" class="formulario2">Comuna</td>
		<td class="formulario2">   <SELECT name="CmbComunas">
		<option value="-1" SELECTed="SELECTed">Todos</option>
		<?
		$Consulta="SELECT t2.cod_comuna,t2.nom_comuna from sget_comunas_por_ciudad t1 inner join sget_comunas t2 on t1.cod_comuna=t2.cod_comuna where cod_ciudad='".$CmbCiudad."' order by nom_comuna";
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($CmbComunas==$Fila[cod_comuna])
				echo "<option value='".$Fila[cod_comuna]."' SELECTed>".$Fila[nom_comuna]."</option>";
			else	
				echo "<option value='".$Fila[cod_comuna]."'>".$Fila[nom_comuna]."</option>";
		}
		?>		  		  
          </SELECT></td>
   <tr>
    <td class='formulario2'>Cargo</td>
    <td colspan="3" class='formulario2' ><SELECT name="CmbCargo">
		<option value="-1" SELECTed="SELECTed">Todos</option>
		<?
		$Consulta="SELECT * from sget_cargos order by descrip_cargo";
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($CmbCargo==$Fila[cod_cargo])
				echo "<option value='".$Fila[cod_cargo]."' SELECTed>".$Fila[descrip_cargo]."</option>";
			else	
				echo "<option value='".$Fila[cod_cargo]."'>".$Fila[descrip_cargo]."</option>";
		}
		?>
        </SELECT>	</td>
  </tr>
  <tr>
    <td class='formulario2'>Contrato</td>
    <td class='formulario2' ><input name="TxtCtto" type="text" id="TxtCtto" value="<? echo $TxtCtto; ?>" size="25"> </td>
    <td class='formulario2' >Sindicato</td>
    <td class='formulario2' ><SELECT name="CmbSindicato">
		<option value="-1" SELECTed="SELECTed">Todos</option>
		<?
		$Consulta="SELECT * from sget_sindicato where estado='1' order by descripcion";
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($CmbSindicato==$Fila[cod_sindicato])
				echo "<option value='".$Fila[cod_sindicato]."' SELECTed>".$Fila["descripcion"]."</option>";
			else	
				echo "<option value='".$Fila[cod_sindicato]."'>".$Fila["descripcion"]."</option>";
		}
		?>		
		
        </SELECT></td>
  </tr>
  <tr>
    <td width="151"class='formulario2'>Empresa</td>
  <td colspan="3" class='formulario2'><input name="TxtEmpresa" type="text" id="TxtEmpresa" maxlength="20"  size="6" value="<? echo $TxtEmpresa; ?>" >
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
    </SELECT> </td></tr>
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
				<tr class="formulario2">
				<? 
			}
			$Consulta="SELECT ifnull(count(*),0) as cant_bec from sget_personal t1 ";
			$Consulta.=" Inner join sget_becados t9 on t1.rut=t9.rut where t1.rut='".$Run."'";
			$RespCantBec=mysql_query($Consulta);
			$FilaCantBec=mysql_fetch_array($RespCantBec);
			$CantBec=$FilaCantBec[cant_bec];
			?>
			<td rowspan="<? echo $CantBec;?>" ><a  href="sget_info_personal.php?run=<? echo $Run;?>"  target="_blank"><img src="archivos/info2.png"   alt="Informaci�n Personal"  border="0" align="absmiddle" /></a><?  echo FormatearRun($Run); ?></td>
			<td rowspan="<? echo $CantBec;?>"><? echo FormatearNombre($Nombre); ?>&nbsp;</td>
			<td rowspan="<? echo $CantBec;?>"><? echo FormatearNombre($Paterno); ?>&nbsp;</td>
			<td rowspan="<? echo $CantBec;?>"><? echo FormatearNombre($Materno); ?>&nbsp;</td>
			<td rowspan="<? echo $CantBec;?>" align="right"><? echo $CantBec; ?>&nbsp;</td>
			<td rowspan="<? echo $CantBec;?>"><a href="sget_info_ctto_ac.php?Ctto=<? echo $FilaMod["cod_contrato"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Contrato" border="0"  align="absmiddle" /></a><? echo $Contrato; ?>&nbsp;</td>
			<td rowspan="<? echo $CantBec;?>"><a href="sget_info_empresa.php?Emp=<? echo $FilaMod["rut_empresa"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Empresa" border="0"  align="absmiddle" /></a><? echo $RazonSocial; ?>&nbsp;</td>
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