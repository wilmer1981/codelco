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
	
if(!isset($CmbEstado))
	$CmbEstado='-1';	


$MesAnterior=date('Y-m-d',mktime(0,0,0,date('m')-1,date('d'),date('Y')));
$MesAnterior=substr($MesAnterior,5,2);
?>
<html>
<head>
<title>Consulta Empresa Subcontratista</title>
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
			f.action ="sget_rpt_empresas_detallado.php?Recarga=S";
			f.submit();
		break;
		case "C"://BUSCA EMPRESA EN SISTEMA CONTRATOS VENTANAS Y LOS EXPORTA HACIA SISTEMA UCAS
			f.action = "sget_rpt_sub_contratistas.php?Buscar=S";
			f.submit();
		break;
		case "E"://EXCEL
			URL='sget_rpt_sub_contratistas_excel.php?TxtRutPrv='+f.TxtRutPrv.value+"&TxtDv="+f.TxtDv.value+"&TxtRazonSocial="+f.TxtRazonSocial.value+"&TxtFantasia="+f.TxtFantasia.value+"&CmbEstado="+f.CmbEstado.value;
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
 //EncabezadoPagina($IP_SERV,'rpt_empresas.png')
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
    <td height="17" class='formulario2'>Rut Empresa </td>
    <td class="formulario2" >
	
<input name='TxtRutPrv' type='text'   value='<? $TxtRutPrv;?>' size='12' maxlength='8' onBlur=CalculaDv(this.form,'TxtRutPrv','TxtDv') onKeyDown="ValidaIngreso('S',false,this.form,'TxtDv')">-<input name="TxtDv" type="text"  id="TxtDv" value="<? $TxtDv;?>"  size="3" maxlength="1">  </tr>
  <tr>
    <td height="17" class='formulario2'>Raz&oacute;n Social </td>
    <td class='formulario2'><input name="TxtRazonSocial" type="text" id="TxtRazonSocial" value="<? echo $TxtRazonSocial; ?>" size="65">  </tr>
  <tr>
    <td height="17" class='formulario2'>Nombre Fantasia </td>
    <td class='formulario2'><input name="TxtFantasia" type="text" id="TxtFantasia" maxlength="60"  size="65" value="<? echo $TxtFantasia; ?>" ></tr><tr>
    <td width="123"class='formulario2'>Estado</td>
    <td class='formulario2' ><SELECT name="CmbEstado" >
      <option value="-1" class="NoSelec">Todos</option>
      <?
	    $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30007' ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEstado==$FilaTC["cod_subclase"])
				echo "<option SELECTed value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
    </SELECT>
    &nbsp;    
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
		<table width="1199" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
		<tr>
		  <td><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
		  <td width="1188" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
		  <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    	</tr>
		<tr>
		<td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
		<td>
		<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<tr>
			<td width="73" align="center" class="TituloTablaVerde" colspan="16">Empresas&nbsp;SubContratistas</td>
			<td width="73" align="center" class="TituloTablaVerde" colspan="11">Empresas&nbsp;Contratistas</td>
		</tr>
		<tr>
		<td width="73" align="center" class="TituloTablaVerde" >Rut </td>
		<td width="164" align="center" class="TituloTablaVerde">Raz&oacute;n&nbsp;Social </td>
		<td width="199" align="center" class="TituloTablaVerde" >Nombre&nbsp;Fantasia </td>
		<td width="199" align="center" class="TituloTablaVerde" >Mutual </td>
		<td width="199" align="center" class="TituloTablaVerde" >Direcci�n </td>
		<td width="199" align="center" class="TituloTablaVerde" >Correo </td>
		<td width="199" align="center" class="TituloTablaVerde" >Telefono </td>
		<td width="199" align="center" class="TituloTablaVerde" >Fecha Reunion&nbsp;Arranque </td>
		<td width="199" align="center" class="TituloTablaVerde" >Repre. Legal </td>
		<td width="199" align="center" class="TituloTablaVerde" >Adm. Ctto. Subcontratista </td>
		<td width="199" align="center" class="TituloTablaVerde" >Correo</td>
		<td width="199" align="center" class="TituloTablaVerde" >Telefono</td>
		<td width="199" align="center" class="TituloTablaVerde" >Prevencionista</td>
		<td width="199" align="center" class="TituloTablaVerde" >Correo</td>
		<td width="199" align="center" class="TituloTablaVerde" >Telefono</td>
        <!--<td width="76" align="center" class="TituloTablaVerde" >N�mero Trabajadores </td>-->
        <td width="76" align="center" class="TituloTablaVerde" >N�&nbsp;Trabajadores Ingreso&nbsp;Mes <? echo substr($meses[$MesAnterior-1],0,3);?></td>

        <td width="157" class="TituloTablaVerde" align="center">Empresa Contratista</td>
        <td width="74" class="TituloTablaVerde" align="center">Rut Empresa</td>
		<td width="89" class="TituloTablaVerde" align="center">Nro&nbsp;Ctto. </td>
		<td width="115" class="TituloTablaVerde" align="center">Nombre&nbsp;Ctto. </td>
		<td width="72" class="TituloTablaVerde" align="center">Fecha&nbsp;Inicio </td>
        <td width="88" class="TituloTablaVerde" align="center">Fecha&nbsp;T&eacute;rmino </td>
        <td width="88" class="TituloTablaVerde" align="center">Fecha&nbsp;Reuni�n Arranque </td>
		</tr><?
		$Consulta="SELECT day(fechaHora) as diaMenor from uca_web.uca_accesos_personas where month(fechaHora)='".$MesAnterior."' order by fechaHora asc";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_assoc($Resp))
			$DiaMenor=$Fila[diaMenor];
		$FechaMenorUca=date('Y')."-".$MesAnterior."-1 00:00:00";
		$FechaMayorUca=date('Y-m-t',mktime(0,0,0,date('m')-1,1,date('Y')));

		$Consulta=" SELECT *,t1.reunion_arranque as RASUB,t4.nombres as nomPrev,t4.apellido_paterno as apePat,t4.apellido_materno as apeMat,t4.telefono as telePrev from sget_sub_contratistas t1";
		$Consulta.=" inner join sget_contratos t2 on t1.cod_contrato=t2.cod_contrato";
		$Consulta.=" inner join sget_contratistas t3 on t1.rut_empresa=t3.rut_empresa";
		$Consulta.=" left join sget_prevencionistas t4 on t2.rut_prev=t4.rut_prev";
		$Consulta.=" where t1.rut_empresa<>''";	
		if($TxtRutPrv!='')
			$Consulta.= " and t1.rut_empresa= '".str_pad($TxtRutPrv,8,'0',l_pad)."-".$TxtDv."' ";
		if($TxtRazonSocial!='')
			$Consulta.= " and upper(t3.razon_social) like ('%".strtoupper(trim($TxtRazonSocial))."%') ";
		if($TxtFantasia != "")
			$Consulta.= " and upper(t3.nombre_fantasia) like ('%".strtoupper(trim($TxtFantasia))."%') ";
		if($CmbEstado!='-1')	
			$Consulta.="  and  t2.estado='".$CmbEstado."' ";
		$Consulta.=" group by t1.rut_empresa order by t3.razon_social";	
		//echo $Consulta."<br>";
		$RespMod=mysql_query($Consulta);
		$Cont=1;
		while($FilaMod=mysql_fetch_array($RespMod))
		{
			$Empresa=$FilaMod[rut_empresa];
			$RazonSocial=$FilaMod[razon_social];
			$Fantasia=$FilaMod[nombre_fantasia];
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
			$ConCan="SELECT count(rut) as cantTra from des_sget.sget_personal where rut_empresa='".trim($FilaMod[rut_empresa])."' and fec_fin_ctto >= '".date('Y-m-d')."'";
			$RCant=mysql_query($ConCan);$CantidadTraba=0;
			if($FCant=mysql_fetch_array($RCant))
				$CantidadTraba=$FCant[cantTra];
			$Consulta="SELECT count(t1.cod_contrato) as CantContra from sget_sub_contratistas t1 left join sget_contratos t2 on t1.cod_contrato=t2.cod_contrato where t1.rut_empresa='".$FilaMod[rut_empresa]."'";
			//echo $Consulta."<br>";
			$RespCtto2=mysql_query($Consulta);
			$FilaCtto2=mysql_fetch_array($RespCtto2);
			$RowsCtto=$FilaCtto2[CantContra];
			$Mutual='';
			if($FilaMod[cod_mutual_seguridad]!='')
			{
				$Mutual="SELECT descripcion from des_sget.sget_mutuales_seg where cod_mutual='".$FilaMod[cod_mutual_seguridad]."'";
				$RMutual=mysql_query($Mutual);
				if($FMutual=mysql_fetch_array($RMutual))
					$Mutual=$FMutual["descripcion"];
			}
			
			//---------DATOS DE PREVENCIONISTAS--------------------------
			$Prevencionista=$FilaMod[apePat]." ".$FilaMod[apeMat]."".$FilaMod[nomPrev];
			if($FilaMod[email_1]=='')
				$CorreoPrev=$FilaMod[email_2];
			else				
				$CorreoPrev=$FilaMod[email_1];
			?>			
			<td rowspan="<? echo $RowsCtto;	?>" ><?  echo FormatearRun($FilaMod[rut_empresa]); ?>&nbsp;</td>
			<td rowspan="<? echo $RowsCtto;	?>"><? echo FormatearNombre($RazonSocial); ?>&nbsp;</td>
			<td rowspan="<? echo $RowsCtto;	?>"><? echo str_replace(' ','&nbsp;',FormatearNombre($Fantasia)); ?>&nbsp;</td>
			<td rowspan="<? echo $RowsCtto;	?>" align="right"><? echo $Mutual; ?>&nbsp;</td>
			<td rowspan="<? echo $RowsCtto;	?>" align="left"><? echo $FilaMod[calle]; ?>&nbsp;</td>
			<td rowspan="<? echo $RowsCtto;	?>" align="right"><? echo $FilaMod[telefono_comercial]; ?>&nbsp;</td>
			<td rowspan="<? echo $RowsCtto;	?>" align="left"><? echo $FilaMod[mail_empresa]; ?>&nbsp;</td>
			<td rowspan="<? echo $RowsCtto;	?>" align="center"><? echo $FilaMod[RASUB]; ?>&nbsp;</td>
			<td rowspan="<? echo $RowsCtto;	?>" align="left"><? echo $FilaMod[repres_legal1]; ?>&nbsp;</td>
			<td rowspan="<? echo $RowsCtto;	?>" align="left"><? echo $FilaMod[repres_legal2]; ?>&nbsp;</td>
			<td rowspan="<? echo $RowsCtto;	?>" align="left"><? echo $FilaMod[mail_repres_legal2]; ?>&nbsp;</td>
			<td rowspan="<? echo $RowsCtto;	?>" align="left"><? echo $FilaMod[telefono_repres2]; ?>&nbsp;</td>
			<td rowspan="<? echo $RowsCtto;	?>" align="left"><? echo $Prevencionista; ?>&nbsp;</td>
			<td rowspan="<? echo $RowsCtto;	?>" align="left"><? echo $CorreoPrev; ?>&nbsp;</td>
			<td rowspan="<? echo $RowsCtto;	?>" align="left"><? echo $FilaMod[telePrev]; ?>&nbsp;</td>
			<!--<td rowspan="<? echo $RowsCtto;	?>" align="right"><? //echo $CantidadTraba; ?>&nbsp;</td>-->
			<?
			$Consulta="SELECT count(t1.rut) as Cantidad from uca_web.uca_accesos_personas t1 inner join des_sget.sget_personal t2 on t1.rut=t2.rut where fechaHora between '".$FechaMenorUca."' and '".$FechaMayorUca."' and t1.tipo='E' and rut_empresa='".$FilaMod[rut_empresa]."'";
			$Resp=mysql_query($Consulta);
			if($Fila=mysql_fetch_assoc($Resp))
				$CantIngresosMesAnt=$Fila[Cantidad];
			?>
			<td rowspan="<? echo $RowsCtto;	?>" align="right"><? echo $CantIngresosMesAnt; ?>&nbsp;</td>
			<? 
			$Consulta="SELECT * from sget_sub_contratistas t1 left join sget_contratos t2 on t1.cod_contrato=t2.cod_contrato where t1.rut_empresa='".$FilaMod[rut_empresa]."'";
			//echo $Consulta."<br>";
			$RespCtto=mysql_query($Consulta);$VigenteCtto='N';
			while($FilaCtto=mysql_fetch_array($RespCtto))
			{
				$VigenteCtto='S';
			?>
				<? 		
				$Consulta="SELECT * from sget_contratistas where rut_empresa='".$FilaCtto[rut_empresa]."'";
				$RespCuentaEmp=mysql_query($Consulta);
				$FilaCuentaEmp=mysql_fetch_array($RespCuentaEmp);
				$RazonSocial2=$FilaCuentaEmp[razon_social];
				
				$ReunionArranque='';
				if($FilaCtto[fecha_venc_bol_garantia]!='0000-00-00')
					$ReunionArranque=$FilaCtto[fecha_venc_bol_garantia];	
				?>
				<td ><? echo FormatearNombre($RazonSocial2); ?>&nbsp;</td>
				<td ><? echo FormatearRun($FilaCuentaEmp[rut_empresa]); ?>&nbsp;</td>
				<td><? echo $FilaCtto["cod_contrato"]; ?>&nbsp;</td>
				<td><? echo $FilaCtto["descripcion"]; ?>&nbsp;</td>
				<td align="center"><? echo $FilaCtto[fecha_inicio]; ?>&nbsp;</td>
				<td align="center"><? echo $FilaCtto[fecha_termino]; ?>&nbsp;</td>
				<td align="center"><? echo $ReunionArranque; ?>&nbsp;</td>
				</tr>
		  <? 		
			}
			if($VigenteCtto=='N')//SIN CONTRATOS VIGENTES
			{
				?>
				<td colspan="7">Sin Contratos Vigentes&nbsp;</td>
				</tr>
				  <? 		
			}
			$Cont++;
		}
		?></table>
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
  //CierreEncabezado()

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