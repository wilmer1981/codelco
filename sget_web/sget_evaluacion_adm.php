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
<title>Evaluaci�n Administrador de Contratos</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso,Valor)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case 'N'://GRABAR
			var URL = "../sget_web/sget_evaluacion_adm_proceso.php?Opcion=N";
			window.open(URL,"","top=30,left=30,width=750,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "M":
		
			if(SoloUnElemento(f.name,'CheckCtto','M'))
			{
				Valores=Recuperar(f.name,'CheckCtto');
				if (Valores=="")
				{
					alert("Debe Seleccionar un Elemento para Eliminar");
					return;
				}
				else
				{
					URL="../sget_web/sget_evaluacion_adm_proceso.php?Opcion=M&CmbContrato="+Valores;
					window.open(URL,"","top=30,left=30,width=750,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}	
		break;
		case "C":
			f.action = "sget_evaluacion_adm.php?Buscar=S";
			f.submit();
		break;
		
		case "E"://ELIMINAR
			var Valores="";
			if (confirm("�Desea Eliminar la Evaluaci�n Seleccionada"))
			{
				f.action = "sget_evaluacion_adm01.php?Opcion=E&Valores="+Valor;
				f.submit();
			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=1";
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
 EncabezadoPagina($IP_SERV,'eval_adm_cttos.png')
 ?>
<table width="939" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
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
		<a href="JavaScript:Procesos('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Procesos('M')"><img src="archivos/btn_modificar3.png"  alt="Modificar " align="absmiddle" border="0"></a>&nbsp;	
		<a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>
		</td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
  <tr>
    <td height="17" class='formulario2'>Contrato</td>
    <td colspan="3" class='formulario2'><input name="TxtContrato" type="text" id="TxtContrato" value="<? echo $TxtContrato; ?>" size="25">  </tr>
  <tr>
    <td height="17" class='formulario2'>Descripci&oacute;n</td>
    <td colspan="3" class='formulario2' ><input name="TxtDescripcion" type="text" id="TxtDescripcion" value="<? echo $TxtDescripcion; ?>" size="45">  </tr>
  <tr>
    <td height="17" class='formulario2'>Empresa</td>
    <td colspan="3" class='formulario2'><SELECT name="CmbEmpresa" id="CmbEmpresa" >
      <option value="-1" class="NoSelec">Todos</option>
      <?
	  $Consulta = "SELECT * from sget_contratistas order by razon_social ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEmpresa==$FilaTC["rut_empresa"])
				echo "<option SELECTed value='".$FilaTC["rut_empresa"]."'>".ucfirst($FilaTC["razon_social"])."</option>\n";
			else
				echo "<option value='".$FilaTC["rut_empresa"]."'>".ucfirst($FilaTC["razon_social"])."</option>\n";
		}
			?>
    </SELECT>  </tr>
  
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
 <table width="96%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
      <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
      <td width="1134" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
      <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
<?
	$Consulta="SELECT t5.nombre_subclase as estado_ctto,t4.nombres as nom_contratista,t4.ape_paterno as ape_p_contratista,t4.ape_materno as ape_m_contratista,t3.nombres,t3.ape_paterno,t3.ape_materno,t1.cod_contrato,t1.descripcion,t1.rut_empresa,t2.razon_social,t1.fecha_inicio,t1.fecha_termino,t1.rut_adm_contrato ";
	$Consulta.=" from sget_contratos t1  left join sget_contratistas t2  on t1.rut_empresa=t2.rut_empresa ";
	$Consulta.=" left join  sget_administrador_contratos t3  on t1.rut_adm_contrato=t3.rut_adm_contrato ";
	$Consulta.=" left join  sget_administrador_contratistas t4  on t1.rut_adm_contratista=t4.rut_adm_contratista ";
	$Consulta.=" left join  proyecto_modernizacion.sub_clase t5  on t1.estado=t5.cod_subclase and t5.cod_clase='30007'";
	$Consulta.="  where t1.cod_contrato<>'' ";
	if($TxtContrato!='')
		$Consulta.= " and upper(t1.cod_contrato) like ('%".strtoupper(trim($TxtContrato))."%') ";
	if($TxtDescripcion!='')
		$Consulta.= " and upper(t1.descripcion) like ('%".strtoupper(trim($TxtDescripcion))."%') ";
	if($CmbEmpresa != "-1")
		$Consulta.="  and  t1.rut_empresa='".$CmbEmpresa."' ";
	$RespMod=mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='CheckCtto'>";
	while($FilaMod=mysql_fetch_array($RespMod))
	{
	?>
		<tr>
		<td width="10%" class="TituloTablaVerde" align="center" >&nbsp;</td>
		<td width="15%"class="TituloTablaVerde" align="center" >Contrato</td>
		<td width="25%" class="TituloTablaVerde" align="center">Descripci&oacute;n</td>
		<td width="25%" class="TituloTablaVerde" align="center" >Empresa </td>
		<td width="25%" class="TituloTablaVerde" align="center">Adm.Contrato </td>
		</tr>	
	<?	
		$Contrato=$FilaMod["cod_contrato"];
		$Descripcion=$FilaMod["descripcion"];
		$Empresa=$FilaMod[razon_social];	
		$AdmCtto=$FilaMod["nombres"]."&nbsp;".$FilaMod[ape_paterno]."&nbsp;".$FilaMod[ape_materno];
		$AdmContratista=$FilaMod[nom_contratista]."&nbsp;".$FilaMod[ape_p_contratista]."&nbsp;".$FilaMod[ape_m_contratista];
	?>
		<tr>
		<td><input type="checkbox" name='CheckCtto' class="SinBorde" value="<? echo $FilaMod["cod_contrato"]; ?>"> </td>
		<td><a href="sget_info_ctto.php?Ctto=<? echo $FilaMod["cod_contrato"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Contrato" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp;<?  echo $FilaMod["cod_contrato"]; ?>&nbsp;</td>
		<td><? echo ucfirst(strtolower($Descripcion)); ?>&nbsp;</td>
		<td><a href="sget_info_empresa.php?Emp=<? echo $FilaMod["rut_empresa"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Empresa" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp;<? echo ucfirst(strtolower($Empresa)); ?>&nbsp;</td>
		<td><? echo ucfirst(strtolower($AdmCtto)); ?>&nbsp;</td>
		</tr>
		<tr align="center">
		<td colspan="5">
	    <?
		$Consulta="SELECT nro_evaluacion,fecha from sget_evaluacion_adm where cod_contrato='".$FilaMod["cod_contrato"]."' group by nro_evaluacion";
		//echo $Consulta."<br>";
		$RespEva=mysqli_query($link, $Consulta);
		$ContTot=0;$SumNotaTot=0;
		while($FilaEva=mysql_fetch_array($RespEva))
		{
			?>
			<table width="100%" border="1" cellpadding="0" cellspacing="0">
			<?
			$Consulta="SELECT t1.fecha,t2.nombre_subclase as nom_eva,t3.nombre_subclase as nom_nota,t1.cod_nota from sget_evaluacion_adm t1 inner join proyecto_modernizacion.sub_clase t2 on t1.cod_evaluacion=t2.cod_subclase and t2.cod_clase='30012' ";
			$Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t1.cod_nota=t3.cod_subclase and t3.cod_clase='30013' where cod_contrato='".$FilaMod["cod_contrato"]."' and nro_evaluacion='".$FilaEva[nro_evaluacion]."'";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{
				$Codigos=$FilaMod["cod_contrato"]."~~".$FilaEva[nro_evaluacion];
			?>
				<tr class="BordeFecha">
				<td width="5%" align="center" class="LinkPestana"><a href="JavaScript:Procesos('E','<? echo $Codigos; ?>')"><img src="archivos/elim_hito.png"  border="0"  alt="Elimina Evaluaci�n" align="absmiddle" /></a>&nbsp;Item</td>
				<td width="45%" align="center" class="LinkPestana" colspan="2">Descripcion Evaluaci�n N�&nbsp;<? echo $FilaEva[nro_evaluacion];?>&nbsp;Realizada el&nbsp;<? echo $FilaEva["fecha"];?></td>
				<td width="30%" align="center" class="LinkPestana">Tipo Evaluaci�n</td>
				<td width="5%" align="center" class="LinkPestana">Nota</td>
				</tr>
				<?
				$SumNota=0;$Cont=0;$Item=1;
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					
					?>
					<tr>
					<td align="right"><? echo $Item;?></td>
					<td colspan="2"><? echo $Fila[nom_eva]; ?>&nbsp;</td>
					<td><? echo $Fila[nom_nota]; ?>&nbsp;</td>
					<td align="right"><? echo $Fila[cod_nota]; ?></td>
					</tr>
					<?
					$SumNota=$SumNota+$Fila[cod_nota];
					$SumNotaTot=$SumNotaTot+$Fila[cod_nota];
					$Cont++;
					$ContTot++;
					$Item++;
				}
				?>
				<tr>
				<td colspan="4" align="right" class="LinkPestana">SubTotal Promedio</td>
				<td align="right"><? echo round($SumNota/$Cont,2); ?></td>
				</tr>
			<?
			}
			?>
			</table>			
			<?
		}
		if($ContTot>0)
		{
		?>
		<table width="100%" border="1" cellpadding="0" cellspacing="0">
		<tr class="BordeFecha">
		<td width="80%" colspan="4" align="right" class="LinkPestana">Total Promedio</td>
		<td width="5%" align="right"><? echo round($SumNotaTot/$ContTot,2);?></td>
		</tr>
		</table>
		<?
		}
		?>
		<br> 
		</td></tr>
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
?>
<?
  CierreEncabezado()
?>

</form>
<? 
echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Contrato(s) Eliminado(s) Correctamente');";
	
	echo "</script>";

?>



</body>
</html>