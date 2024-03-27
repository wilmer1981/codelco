<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");

if(isset($TxtContrato2))
	$TxtContrato=$TxtContrato2;
if (isset($TxtDescripcion2))
	$TxtDescripcion = $TxtDescripcion2;
	
if (isset($CmbEmpresa2))
	$CmbEmpresa = $CmbEmpresa2;
	

 $CodigoDeSistema = 27;
 $CodigoDePantalla = 7;
 if(isset($CodCtto))
 	$TxtBuscaCod=$CodCtto;  
if(!isset($CmbEmpresa))
	$CmbEmpresa='-1';
	
	
?>
<html>
<head>
<title>Mantenedor Contratos</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">

function GenerarExcel(ctto,emp)
{
		var URL = "../sget_web/sget_genera_excel.php?Ctto="+ctto+"&Empresa="+emp;
			window.open(URL,"","top=30,left=30,width=550,height=180,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				
}

function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
		
	switch(TipoProceso)
	{
	
		case 'N'://GRABAR
	//alert ("entro nuevo");
			var URL = "../sget_web/sget_mantenedor_contratos_proceso.php?Opcion=N";    
			window.open(URL,"","top=30,left=30,width=950,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "M":
		//	alert ("entro mod");
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
					//	alert (Valores);
					URL="../sget_web/sget_mantenedor_contratos_proceso.php?Opcion=M&Contrato="+Valores;
					window.open(URL,"","top=30,left=30,width=950,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}	
		break;
		case "C"://BUSCA EMPRESA EN SISTEMA CONTRATOS VENTANAS Y LOS EXPORTA HACIA SISTEMA UCAS
			f.action = "sget_mantenedor_contratos.php?Buscar=S";
			f.submit();
		break;
		case "E"://ELIMINAR
			var Valores="";
			Valores=Recuperar(f.name,'CheckCtto');
			if (Valores=="")
			{
				alert("Debe Seleccionar un Elemento para Eliminar");
				return;
			}
			else
			{
				if (confirm("�Desea Eliminar los Contratos Seleccionados?"))
				{
					f.action = "sget_mantenedor_contratos01.php?Opcion=E&Valores="+Valores;
					f.submit();
				}
			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=32";
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
 <? include("encabezado.php")?>

 <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
 <tr> 
 <td width="958" valign="top">
 <table width="760" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td height="30" align="right" ><table width="770" class="TablaPrincipal2">
            <tr valign="middle"> 
              <td width="271"><img src="archivos\Titulos\mant_contratos.png"></td>
              <td width="179" align="right"><font color="#9E5B3B">&nbsp;<font face="Times New Roman, Times, serif" size="2">Servidor 
                <? 
				$IP_SERV = $HTTP_HOST;
				echo $IP_SERV;?>
              </font></font></td>
              <td width="304" align="right"><font size="2" face="Times New Roman, Times, serif">&nbsp; 
                </font><font color="#9E5B3B" face="Times New Roman, Times, serif">&nbsp; 
                <? 
				//$Fecha_Hora = date("d-m-Y h:i");
				$FechaFor=FechaHoraActual();
				echo $FechaFor." hrs";
				?>
                </font></td>
            </tr>
        </table></td>
    </tr>
  </table>
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
  <tr>
   <td  width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
   <td>
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02" >
	<tr>
	
		 <td align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td align="right" class='formulario2'>
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
		<a href="JavaScript:Procesos('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Procesos('M')"><img src="archivos/btn_modificar3.png"  alt="Modificar " align="absmiddle" border="0"></a>&nbsp;	
		<a href="JavaScript:Procesos('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar " align="absmiddle" border="0"></a>&nbsp;
		<a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>
		</td>
	</tr>
</table>
              <table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
                <tr> 
                  <td height="17" class='formulario2'>Contrato</td>
                  <td colspan="3" class="formulario2" ><input name="TxtContrato" type="text" id="TxtContrato" value="<? echo $TxtContrato; ?>" size="25" maxlength="15"> 
                  
                </tr>
                <tr> 
                  <td height="17" class='formulario2'>Descripci&oacute;n</td>
                  <td colspan="3" class='formulario2'><input name="TxtDescripcion" type="text" id="TxtDescripcion" value="<? echo $TxtDescripcion; ?>" size="45"> 
                </tr>
                <tr> 
                  <td height="17" class='formulario2'>Empresa</td>
                  <td colspan="3" class='formulario2'><SELECT name="CmbEmpresa" id="CmbEmpresa" >
                      <option value="-1" class="NoSelec">Todos</option>
                      <?
	  $Consulta = "SELECT * from sget_contratistas order by razon_social ";			
		$Resp=mysqli_query($link, $Consulta);
		$var1=$Consulta;
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEmpresa==$FilaTC["rut_empresa"])
				echo "<option SELECTed value='".$FilaTC["rut_empresa"]."'>".ucfirst($FilaTC["razon_social"])."</option>\n";
			else
				echo "<option value='".$FilaTC["rut_empresa"]."'>".ucfirst($FilaTC["razon_social"])."</option>\n";
		}
			?>
                    </SELECT> </tr>
                <?
	//echo "DD".$var1;
	?>
              </table></td>
  <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" ><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" ><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
    <br>
 
 <table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
      <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
      <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
      <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
<tr>
<td width="4%" class="TituloTablaVerde" align="center" >&nbsp;</td>
<td width="5%" class="TituloTablaVerde" align="center" >&nbsp;</td>
<td width="12%" class="TituloTablaVerde" align="center" >Rut</td>
<td width="10%" class="TituloTablaVerde"align="center" >Empresa </td>
<td width="10%" class="TituloTablaVerde" align="center" >N� Contrato SAP</td>
<td width="12%" class="TituloTablaVerde" align="center">Descripci&oacute;n</td>
<td width="10%" class="TituloTablaVerde" align="center">Fecha&nbsp;Inicio </td>
<td width="10%" class="TituloTablaVerde"align="center">Fecha&nbsp;T�rmino </td>
<td width="10%" class="TituloTablaVerde" align="center">Adm.Contrato </td>
<td width="10%" class="TituloTablaVerde" align="center">Adm.Contratista</td>
<td width="8%" class="TituloTablaVerde" align="center">Tipo Contrato</td>
</tr>
<?
					

  if($Buscar=='S')
  {
  
  	if(isset($TxtContrato2))
		$TxtContrato=$TxtContrato2;

	if (isset($TxtDescripcion2))
		$TxtDescripcion = $TxtDescripcion2;
	
	if (isset($CmbEmpresa2))
		$CmbEmpresa = $CmbEmpresa2;

 
	$Consulta="SELECT t6.descrip_tipo_contrato,t5.nombre_subclase as estado_ctto,t4.nombres as nom_contratista,t4.ape_paterno as ape_p_contratista,t4.ape_materno as ape_m_contratista,t3.nombres,t3.ape_paterno,t3.ape_materno,t1.cod_contrato,t1.descripcion,t1.rut_empresa,t2.razon_social,t1.fecha_inicio,t1.fecha_termino,t1.rut_adm_contrato ";
	$Consulta.=" from sget_contratos t1  left join sget_contratistas t2  on t1.rut_empresa=t2.rut_empresa ";
	$Consulta.=" left join  sget_administrador_contratos t3  on t1.rut_adm_contrato=t3.rut_adm_contrato ";
	$Consulta.=" left join  sget_administrador_contratistas t4  on t1.rut_adm_contratista=t4.rut_adm_contratista ";
	$Consulta.=" left join  proyecto_modernizacion.sub_clase t5  on t1.estado=t5.cod_subclase and t5.cod_clase='30007'";
	$Consulta.=" left join  sget_tipo_contrato t6  on t1.cod_tipo_contrato=t6.cod_tipo_contrato ";
	$Consulta.="  where t1.cod_contrato<>'' ";
	if($TxtContrato!='')
		$Consulta.= " and upper(t1.cod_contrato) like ('%".strtoupper($TxtContrato)."%') ";
	if($TxtDescripcion!='')
		$Consulta.= " and upper(t1.descripcion) like ('%".strtoupper($TxtDescripcion)."%') ";
	if($CmbEmpresa != "-1")
		$Consulta.="  and  t1.rut_empresa='".$CmbEmpresa."' ";
	/*if($TxtFechaInicio != "")
		$Consulta.=" and  t1.fecha_inicio between '".$TxtFechaInicio." 00:00:00' and '".$TxtFechaTermino." 23:59:59'";
	
		
		$Consulta.="  and  t1.fecha_inicio='".$TxtFechaInicio."' ";
	if($TxtFechaTermino != "")
		$Consulta.="  and  t1.fecha_termino='".$TxtFechaTermino."' ";*/

	$RespMod=mysqli_query($link, $Consulta);
	
	echo "<input type='hidden' name='CheckCtto'>";
	$Cont=1;
	while($FilaMod=mysql_fetch_array($RespMod))
	{
		$Contrato=$FilaMod["cod_contrato"];
		$Descripcion=$FilaMod["descripcion"];
		$Empresa=$FilaMod[razon_social];	
		$FechaInicio=$FilaMod[fecha_inicio];
		$FechaTermino=$FilaMod[fecha_termino];
		$AdmCtto= FormatearNombre($FilaMod["nombres"])."&nbsp;".FormatearNombre($FilaMod[ape_paterno])."&nbsp;".FormatearNombre($FilaMod[ape_materno]);
		$AdmContratista=FormatearNombre($FilaMod[nom_contratista])."&nbsp;".FormatearNombre($FilaMod[ape_p_contratista])."&nbsp;".FormatearNombre($FilaMod[ape_m_contratista]);
		//$Estado=$FilaMod[estado_ctto];
		$TipoCtto=$FilaMod[descrip_tipo_contrato];
		
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
		<td><input type="checkbox" name='CheckCtto' class="SinBorde" value="<? echo $FilaMod["cod_contrato"]; ?>"> </td>
		<td ><a href="JavaScript:GenerarExcel('<? echo $FilaMod["cod_contrato"];?>','<? echo $FilaMod[rut_empresa];?>')"><img src="archivos/exec.png"   alt="Generar Excel para Ingreso de Personal"  border="0" align="absmiddle" /></a></td>
		<td><? echo $FilaMod[rut_empresa];?></td>
		<td><a href="sget_info_empresa.php?Emp=<? echo $FilaMod[rut_empresa];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Empresa" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp;<? echo FormatearNombre($Empresa); ?>&nbsp;</td>
		<td ><a href="sget_info_ctto.php?Ctto=<? echo $FilaMod["cod_contrato"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Contrato" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp;<?  echo $FilaMod["cod_contrato"]; ?>&nbsp;</td>
		<td><? echo FormatearNombre($Descripcion); ?>&nbsp;</td>
		<td align="center"><? echo $FechaInicio; ?>&nbsp;</td>
		<td align="center"><? echo $FechaTermino; ?>&nbsp;</td>
		<td><? echo $AdmCtto; ?>&nbsp;</td>
		<td><? echo $AdmContratista; ?>&nbsp;</td>
		<td><? echo $TipoCtto; ?>&nbsp;</td>
		</tr>
	<?
		$Cont++;
	}
 
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

 </td>
    </tr>
  </table>
	<? include("pie_pagina.php")?>

</form>
<? 
echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Contrato(s) Eliminado(s) Correctamente');";
	
	echo "</script>";

//ACTUALIZAR CAMPO INACTIVO DE CONTRATOS VENCIDOS POR FECHA DE TERMINO
$Consulta="SELECT cod_contrato FROM sget_contratos WHERE fecha_termino < '".date('Y-m-d')."'";
$Resp=mysqli_query($link, $Consulta);
while($Fila=mysql_fetch_array($Resp))
{
	$Actualizar="UPDATE sget_contratos set estado='2' where cod_contrato='".$Fila["cod_contrato"]."'";
	mysql_query($Actualizar);
}
?>
</body>
</html>