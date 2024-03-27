<?
		include("../principal/conectar_sget_web.php");
		include("funciones/sget_funciones.php");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$FechaHoy = date("Y-m-d");
 $CodigoDeSistema = 27;
 $CodigoDePantalla = 7;
 if(isset($CodCtto))
 	$TxtBuscaCod=$CodCtto;
if(!isset($CmbEmpresa))
	$CmbEmpresa='-1';
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
			f.action ="sget_rpt_empresas.php?Recarga=S";
			f.submit();
		break;
		case "C"://BUSCA EMPRESA EN SISTEMA CONTRATOS VENTANAS Y LOS EXPORTA HACIA SISTEMA UCAS
			f.action = "sget_rpt_empresas.php?Buscar=S";
			f.submit();
		break;
		case "E"://EXCEL
			URL='sget_rpt_empresas_excel.php?TxtRutPrv='+f.TxtRutPrv.value+"&TxtDv="+f.TxtDv.value+"&TxtRazonSocial="+f.TxtRazonSocial.value+"&TxtFantasia="+f.TxtFantasia.value+"&CmbMutuales="+f.CmbMutuales.value;
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
 EncabezadoPagina($IP_SERV,'rpt_empresas.png')
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
	
<input name='TxtRutPrv' type='text'   value='<? $TxtRutPrv;?>' size='12' maxlength='8' onBlur=CalculaDv(this.form,'TxtRutPrv','TxtDv') onKeyDown="ValidaIngreso('S',false,this.form,'TxtDv')">-<input name="TxtDv" type="text"  id="TxtDv" value="<? $TxtDv;?>"  size="3" maxlength="1">
  </tr>
  <tr>
    <td height="17" class='formulario2'>Raz&oacute;n Social </td>
    <td class='formulario2'><input name="TxtRazonSocial" type="text" id="TxtRazonSocial" value="<? echo $TxtRazonSocial; ?>" size="65">  </tr>
  <tr>
    <td height="17" class='formulario2'>Nombre Fantasia </td>
    <td class='formulario2'><input name="TxtFantasia" type="text" id="TxtFantasia" maxlength="60"  size="65" value="<? echo $TxtFantasia; ?>" ></tr><tr>
    <td width="123"class='formulario2'>Mutual Seguridad </td>
    <td class='formulario2' ><SELECT name="CmbMutuales" >
               <option value="-1" class="NoSelec">Todas</option>
               <?
			  $Consulta = "SELECT * from sget_mutuales_seg where estado='1' order by descripcion ";			
			  $Resp3=mysqli_query($link, $Consulta);
			  while ($Fila3=mysql_fetch_array($Resp3))
			  {
				if ($CmbMutuales==$Fila3["cod_mutual"])
					echo "<option SELECTed value='".$Fila3["cod_mutual"]."'>".ucfirst($Fila3["abreviatura"])."</option>\n";
				else
					echo "<option value='".$Fila3["cod_mutual"]."'>".ucfirst($Fila3["abreviatura"])."</option>\n";
			  }
			 ?>
             </SELECT>     </tr>

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
		
		<td width="170" rowspan="2" align="center" class="TituloTablaVerde" >Rut&nbsp;Empresa </td>
		<td width="120" rowspan="2" align="center" class="TituloTablaVerde">Raz&oacute;n&nbsp;Social </td>
		<td width="181" rowspan="2"align="center" class="TituloTablaVerde" >Nombre&nbsp;Fantasia </td>
		<td width="188" rowspan="2" align="center"  class="TituloTablaVerde">Mutual&nbsp;Seguridad </td>
		<td width="100" rowspan="2" align="center"  class="TituloTablaVerde">Venc.Cert.</td>
		<td colspan="4" class="TituloTablaVerde"align="center">Datos&nbsp;Representante&nbsp;Legal  </td>
		<td width="117" rowspan="2" align="center" class="TituloTablaVerde">Cant.&nbsp;Ctto </td>
		</tr>
		<tr>
		<td width="129" class="TituloTablaVerde" align="center">Nombre</td>
		<td width="95" class="TituloTablaVerde" align="center">E-Mail</td>
		<td width="78" class="TituloTablaVerde" align="center">Nro.&nbsp;Telefono</td>
<td width="68" class="TituloTablaVerde" align="center">Nro.&nbsp;Celular</td>
		</tr><?
		$Consulta="SELECT * from sget_contratistas t1  left join sget_mutuales_seg t2 on t1.cod_mutual_seguridad=t2.cod_mutual ";
		$Consulta.=" left join  proyecto_modernizacion.sub_clase t3  on t1.estado=t3.cod_subclase and t3.cod_clase='30007'";
	
		$Consulta.="  where t1.rut_empresa<>'' ";
		if($TxtRutPrv!='')
			$Consulta.= " and t1.rut_empresa= '".str_pad($TxtRutPrv,8,'0',l_pad)."-".$TxtDv."' ";
		if($TxtRazonSocial!='')
			$Consulta.= " and upper(t1.razon_social) like ('%".strtoupper(trim($TxtRazonSocial))."%') ";
		if($TxtFantasia != "")
			$Consulta.= " and upper(t1.nombre_fantasia) like ('%".strtoupper(trim($TxtFantasia))."%') ";
		
		if($CmbMutuales != "-1")
			$Consulta.="  and  t1.cod_mutual_seguridad='".$CmbMutuales."' ";
		$RespMod=mysqli_query($link, $Consulta);
		$Cont=1;
		while($FilaMod=mysql_fetch_array($RespMod))
		{
			$Empresa=$FilaMod[rut_empresa];
			$RazonSocial=$FilaMod[razon_social];
			$Fantasia=$FilaMod[nombre_fantasia];
			$Mutual=$FilaMod["abreviatura"];
			$FechaVenc = $FilaMod[fecha_ven_cert];	
			$Nombre=FormatearNombre($FilaMod[repres_legal1]);
			$Email=$FilaMod[mail_repres_legal1];
			$Telefono=$FilaMod[telefono_repres1];
			$Celular=$FilaMod[celular_repres_legal1];
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
			<td >
				<a  href="sget_info_empresa.php?Emp=<? echo $Empresa;?>"  target="_blank"><img src="archivos/info2.png"   alt="Informaci�n Empresa"  border="0" align="absmiddle" /></a><?  echo FormatearRun($FilaMod[rut_empresa]); ?>&nbsp;&nbsp;</td>
			<td><? echo FormatearNombre($RazonSocial); ?>&nbsp;</td>
			<td><? echo str_replace(' ','&nbsp;',FormatearNombre($Fantasia)); ?>&nbsp;</td>
			<td><? echo $Mutual; ?>&nbsp;</td>
			<?
				if ($FechaVenc<=$FechaHoy)
				{ 
					echo '<td align="center" bgcolor="#FFFFFF" class="InputRojo">'.$FechaVenc.'</td>';
				}
				else 
				{ 
					echo '<td align="center">'.$FechaVenc.'</td>';
				} 
			?>
			<td ><? echo $Nombre; ?>&nbsp;</td>
			<td><? echo $Email; ?>&nbsp;</td>
			<td><? echo $Telefono; ?>&nbsp;</td>
			<td ><? echo $Celular; ?>&nbsp;</td>
				<td align="right"><? 
				$Consulta="SELECT count(rut_empresa) as Cantidad from sget_contratos where rut_empresa='".$FilaMod[rut_empresa]."' and estado='1'";
				$RespCant=mysqli_query($link, $Consulta);
				if($FilaCant=mysql_fetch_array($RespCant))
				{
				echo $FilaCant[Cantidad];
				}
				else
				{echo "0";
				 }?>
				
			
				&nbsp;</td>
			</tr>
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