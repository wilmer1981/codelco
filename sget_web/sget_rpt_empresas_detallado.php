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
?>
<html>
<head>
<title>Reporte Empresas</title>
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
			f.action = "sget_rpt_empresas_detallado.php?Buscar=S";
			f.submit();
		break;
		case "E"://EXCEL
			URL='sget_rpt_empresas_detallado_excel.php?TxtRutPrv='+f.TxtRutPrv.value+"&TxtDv="+f.TxtDv.value+"&TxtRazonSocial="+f.TxtRazonSocial.value+"&TxtFantasia="+f.TxtFantasia.value+"&CmbMutuales="+f.CmbMutuales.value+"&CmbEstado="+f.CmbEstado.value;
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
    <td colspan="3" class="formulario2" >
	
<input name='TxtRutPrv' type='text'   value='<? $TxtRutPrv;?>' size='12' maxlength='8' onBlur=CalculaDv(this.form,'TxtRutPrv','TxtDv') onKeyDown="ValidaIngreso('S',false,this.form,'TxtDv')">-<input name="TxtDv" type="text"  id="TxtDv" value="<? $TxtDv;?>"  size="3" maxlength="1">  </tr>
  <tr>
    <td height="17" class='formulario2'>Raz&oacute;n Social </td>
    <td colspan="3" class='formulario2'><input name="TxtRazonSocial" type="text" id="TxtRazonSocial" value="<? echo $TxtRazonSocial; ?>" size="65">  </tr>
  <tr>
    <td height="17" class='formulario2'>Nombre Fantasia </td>
    <td colspan="3" class='formulario2'><input name="TxtFantasia" type="text" id="TxtFantasia" maxlength="60"  size="65" value="<? echo $TxtFantasia; ?>" ></tr><tr>
    <td width="123"class='formulario2'>Mutual Seguridad </td>
    <td width="114" class='formulario2' ><SELECT name="CmbMutuales" >
               <option value="-1" class="NoSelec">Todas</option>
               <?
			  $Consulta = "SELECT * from sget_mutuales_seg where estado='1' order by descripcion ";			
			  $Resp3=mysql_query($Consulta);
			  while ($Fila3=mysql_fetch_array($Resp3))
			  {
				if ($CmbMutuales==$Fila3["cod_mutual"])
					echo "<option SELECTed value='".$Fila3["cod_mutual"]."'>".ucfirst($Fila3["abreviatura"])."</option>\n";
				else
					echo "<option value='".$Fila3["cod_mutual"]."'>".ucfirst($Fila3["abreviatura"])."</option>\n";
			  }
			 ?>
             </SELECT>         
  <td width="50" class="formulario2" >Estado&nbsp;</td>
			<td width="615" class="formulario2">
			<SELECT name="CmbEstado" >
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
            </SELECT>			</td>

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
		  <td width="1188" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
		  <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    	</tr>
		<tr>
		<td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
		<td>
		<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<tr>
		
		<td width="111" rowspan="2" align="center" class="TituloTablaVerde" >Rut&nbsp;Empresa </td>
		<td width="95" rowspan="2" align="center" class="TituloTablaVerde">Raz&oacute;n&nbsp;Social </td>
		<td width="98" rowspan="2"align="center" class="TituloTablaVerde" >Nombre&nbsp;Fantasia </td>
		<td width="70" rowspan="2" align="center"  class="TituloTablaVerde">Mutual&nbsp;Seguridad </td>
		<td width="70" rowspan="2" align="center"  class="TituloTablaVerde">Direcci&oacute;n</td>
		<td width="140" rowspan="2" align="center"  class="TituloTablaVerde">Tel&eacute;fono </td>
		<td width="140" rowspan="2" align="center"  class="TituloTablaVerde">Correo </td>
		<td width="140" rowspan="2" align="center"  class="TituloTablaVerde">Repre.Legal</td>
		<td colspan="13" class="TituloTablaVerde"align="center">Datos Contrato </td>
		</tr>
		<tr>
		<td width="62" class="TituloTablaVerde" align="center">Nro&nbsp;Ctto. </td>
		<td width="62" class="TituloTablaVerde" align="center">Nombre&nbsp;Ctto. </td>
		<td width="61" class="TituloTablaVerde" align="center">Centro&nbsp;Costo </td>
		<td width="78" class="TituloTablaVerde" align="center">Fecha&nbsp;Inicio </td>
        <td width="34" class="TituloTablaVerde" align="center">Fecha&nbsp;Termino </td>
		<td width="40" class="TituloTablaVerde" align="center">Reuni�n&nbsp;Arranque </td>
		<td width="34" class="TituloTablaVerde" align="center">Adm.&nbsp;Ctto Codelco</td>
		<td width="34" class="TituloTablaVerde" align="center">Email</td>
		<td width="68" class="TituloTablaVerde" align="center">Adm.&nbsp;Ctto Empresa</td>
		<td width="34" class="TituloTablaVerde" align="center">Email</td>
		<td width="24" class="TituloTablaVerde" align="center">Prevencionista</td>
		<td width="34" class="TituloTablaVerde" align="center">Categoria Prev.</td>
		</tr><?
		$Consulta="SELECT count(t4.cod_contrato) as row, t1.*,t2.*,t3.* from sget_contratistas t1  left join sget_mutuales_seg t2 on t1.cod_mutual_seguridad=t2.cod_mutual ";
		$Consulta.=" left join  proyecto_modernizacion.sub_clase t3  on t1.estado=t3.cod_subclase and t3.cod_clase='30007'";
		$Consulta.=" inner join  sget_contratos t4  on t1.rut_empresa=t4.rut_empresa ";
		$Consulta.="  where t1.rut_empresa<>'' ";
		if($TxtRutPrv!='')
			$Consulta.= " and t1.rut_empresa= '".str_pad($TxtRutPrv,8,'0',l_pad)."-".$TxtDv."' ";
		if($TxtRazonSocial!='')
			$Consulta.= " and upper(t1.razon_social) like ('%".strtoupper(trim($TxtRazonSocial))."%') ";
		if($TxtFantasia != "")
			$Consulta.= " and upper(t1.nombre_fantasia) like ('%".strtoupper(trim($TxtFantasia))."%') ";
		if($CmbMutuales != "-1")
			$Consulta.="  and  t1.cod_mutual_seguridad='".$CmbMutuales."' ";
		if($CmbEstado!='-1')	
			$Consulta.="  and  t4.estado='".$CmbEstado."' ";
			
		$Consulta.=" group by t1.rut_empresa order by razon_social";
		
		$RespMod=mysql_query($Consulta);
		
		$Cont=1;
		while($FilaMod=mysql_fetch_array($RespMod))
		{
			$Empresa=$FilaMod[rut_empresa];
			$RazonSocial=$FilaMod[razon_social];
			$Direccion=$FilaMod[calle];
			$Fantasia=$FilaMod[nombre_fantasia];
			$Mutual=DescripcionMutual($FilaMod[cod_mutual_seguridad]);
			$Nombre=FormatearNombre($FilaMod[repres_legal1]);
			$Email=$FilaMod[mail_empresa];
			$Telefono=$FilaMod[telefono_comercial];
			$Celular=$FilaMod[celular_repres_legal1];
			$RepLegal=$FilaMod[repres_legal1];
			$Estado=$FilaMod[estado_emp];
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
			
			<td rowspan="<? echo $FilaMod[row];	?>" ><?  echo FormatearRun($FilaMod[rut_empresa]); ?>&nbsp;</td>
			<td rowspan="<? echo $FilaMod[row];	?>"><? echo FormatearNombre($RazonSocial); ?>&nbsp;</td>
			<td rowspan="<? echo $FilaMod[row];	?>"><? echo str_replace(' ','&nbsp;',FormatearNombre($Fantasia)); ?>&nbsp;</td>
			<td rowspan="<? echo $FilaMod[row];	?>"><? echo $Mutual; ?>&nbsp;</td>
			<td rowspan="<? echo $FilaMod[row];	?>"><? echo $Direccion; ?>&nbsp;</td>
			<td rowspan="<? echo $FilaMod[row];	?>"><? echo $Telefono; ?>&nbsp;</td>
			<td rowspan="<? echo $FilaMod[row];	?>"><? echo $Email; ?>&nbsp;</td>
			<td rowspan="<? echo $FilaMod[row];	?>"><? echo $RepLegal; ?>&nbsp;</td>
			
			<? 
				$Consulta="SELECT * from sget_contratos where rut_empresa='".$FilaMod[rut_empresa]."'";
				if($CmbEstado!='-1')	
					$Consulta.="  and  estado='".$CmbEstado."' ";
				//echo $Consulta."<br>";
				$RespCtto=mysql_query($Consulta);
				while($FilaCtto=mysql_fetch_array($RespCtto))
				{
				
				$DatosContrato= AdmCodelco($FilaCtto[rut_adm_contrato]);
				$DatosContratista=AdmCttoContratista($FilaCtto["cod_contrato"]);
				$MCtto=explode('~',$DatosContrato);
				$ADMCTTO=$MCtto[1]."&nbsp;".$MCtto[2]."&nbsp;".$MCtto[3];
				$EmailCtto=$MCtto[5];
				$MCttista=explode('~',$DatosContratista);
				$ADMCTTISTA=$MCttista[1]."&nbsp;".$MCttista[2]."&nbsp;".$MCttista[3];
				$EmailCtta=$MCttista[5];
				$DatosPrev=DescripcionPrev($FilaCtto[rut_prev]);
				$MPrev=explode('~',$DatosPrev);
				$PREVCIO=$MPrev[0]."&nbsp;".$MPrev[1]."&nbsp;".$MPrev[2];
				$CATPREV=$MPrev[5]."&nbsp;".$MPrev[6];
				
				$ReunArranque='';
				if($FilaCtto[fecha_venc_bol_garantia]!='' && $FilaCtto[fecha_venc_bol_garantia]!='0000-00-00')
					$ReunArranque=$FilaCtto[fecha_venc_bol_garantia];
				?>
				<td><? echo $FilaCtto["cod_contrato"]; ?>&nbsp;</td>
				<td><? echo $FilaCtto["descripcion"]; ?>&nbsp;</td>
				<td><? 
				$Area=DescripcionArea($FilaCtto["cod_area"]);
				echo $Area; ?>&nbsp;</td>
				<td><? echo $FilaCtto[fecha_inicio]; ?>&nbsp;</td>
				<td ><? echo $FilaCtto[fecha_termino]; ?>&nbsp;</td>
				<td align="center"><? echo $ReunArranque; ?>&nbsp;</td>
				<td ><? echo $ADMCTTO ?>&nbsp;</td>
				<td ><? echo $EmailCtto ?>&nbsp;</td>
				<td ><? echo $ADMCTTISTA; ?>&nbsp;</td>
				<td ><? echo $EmailCtta ?>&nbsp;</td>
				<td ><? echo $PREVCIO; ?>&nbsp;</td>
				<td ><? echo $CATPREV; ?>&nbsp;</td>
				</tr><? 
			
				}
				?>
				
			
			
		<?
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