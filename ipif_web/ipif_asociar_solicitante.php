<? session_start();
	include("../principal/conectar_ipif_web.php");
	include("funciones/ipif_funciones.php");
	$arreglo=array();
	
	if(!isset($CmbDivision))
		$CmbDivision='-1';
			?>
<HTML>
<HEAD>
<TITLE>CODELCO - IPIF</TITLE>

</HEAD>
		
<link href="estilos/ipif_style.css" rel="stylesheet" type="text/css">
<BODY>

<script language="javascript" src="funciones/ipif_funciones.js"></script>
<script language="javascript">

function Recargar(El)
{
	var f= document.FrmProyectoVisualizador;
	f.action='ipif_asociar_solicitante.php';
	f.submit();
}
function Proceso(Opc)
{
	var f= document.FrmProyectoVisualizador;
	var Datos='';
	switch(Opc)
	{
		case 'G':
			if(SoloUnElemento(f.name,'Check','E'))
			{
				Datos=Recuperar(f.name,'Check');
				if(f.OPTS.value=='AS')
				{
					f=document.FrmProceso;
					opener.ASD(Datos);
					window.close();
				}
				else
				{
					 window.opener.document.FrmCeco.action='ipif_adm_sistema.php?Op=GP&F='+Datos;
					 window.opener.document.FrmCeco.submit();
					 window.close();
				}
			}
		break;
		
		case 'C':
			window.close();
		break;
			case 'B':
			f.action='ipif_asociar_solicitante.php?Buscar=S';
	f.submit();
		break;
	
	}
	
}


</script>
<link href="estilos/ipif_style.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmProyectoVisualizador" method="post" action="">
<input type="hidden" name="OPTS" value="<? echo $OPTS;?>">
<table width="70%" align="center"  border="0" cellpadding="0"  cellspacing="0"  class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="614" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="15" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="15" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr >
   <td colspan="2" align="right"  > 	<a href="JavaScript:Proceso('B')"><img src="archivos/Find.png" border="0" alt="Buscar" align="absmiddle"></a>&nbsp;<a href="JavaScript:Proceso('G')"><img src='archivos/btn_guardar.png' alt="Guardar" border='0' align="absmiddle" ></a>
&nbsp;<a href="JavaScript:Proceso('C')"><img src='archivos/close.png' alt="Cerrar" border='0' align="absmiddle"></a></td>
  <tr >
         <td width="25%" class="formulario">Nombres</td>
         <td colspan="2" ><input name="TxtNombre" type="text" id="TxtNombre" size="50" value="<? echo $TxtNombre; ?>" maxlength="100"></td>
        </tr>
        <tr>
          <td class="formulario" >Paterno</td>
          <td colspan="2" ><input name="TxtPaterno" type="text" id="TxtPaterno" size="50" value="<? echo $TxtPaterno; ?>" maxlength="100">        
        <tr>
          <td class="formulario">Materno</td>
          <td colspan="2" ><input name="TxtMaterno" type="text" id="TxtMaterno" size="50" value="<? echo $TxtMaterno; ?>" maxlength="100">        
    
        <tr>
          <td class="formulario">Cuenta </td>
          <td colspan="2" ><input name="TxtCuenta" type="text" id="TxtCuenta"  value="<? echo $TxtCuenta; ?>" maxlength="50"></td>
        </tr>
    </table> 
	 <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
    <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15"></td>
	<td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15"></td>
  </tr>
  </table> 
 <?
if($Buscar=='S')
{?>
<br>
<table width="70%" align="center"  border="0" cellpadding="0"  cellspacing="0"  class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="614" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="15" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="15" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>

<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
  <tr>
    <td colspan="2" align="center"  class="TituloCabecera" >&nbsp;</td>
    <td width="63%" class="TituloCabecera" align="center" >Nombre</td>
    <td width="29%" class="TituloCabecera" align="center">Cuenta</td>
  </tr>

<?
	$Encontro=false;
	$Cont=0;
	$Consulta = "select t1.* from proyecto_modernizacion.funcionarios t1 ";
	$Consulta.= " where t1.cuenta_red <>'' and  not isnull(cuenta_red)";
	if($TxtNombre!='')
	{	
		$Consulta.=" and upper(t1.nombres) like '%".trim(strtoupper($TxtNombre))."%' ";	
	}
	if($TxtPaterno != '')
	{
		$Consulta.=" and upper(t1.apellido_paterno) like '%".trim(strtoupper($TxtPaterno))."%' ";	
	}
	if($TxtMaterno != '')
	{
		$Consulta.=" and upper(t1.apellido_materno) like '%".trim(strtoupper($TxtMaterno))."%' ";	
	}

	if($TxtCuenta!='')	
		$Consulta.=" and  upper(t1.cuenta_red) like '%".trim(strtoupper($TxtCuenta))."%'";	
	$Consulta.=" order by apellido_paterno,apellido_materno,nombres asc ";		
	echo "<input name='Check' type='hidden'  value=''>";
	$Cont=1;
	$Resp = mysql_query($Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		?>
	    <tr >
		<td width="4%" align='center'><? echo $Cont;?> </td>	
		<td width="4%" align='center' ><input type='checkbox' name='Check' value='<? echo $Fila[cuenta_red];?>' class='SinBorde' >		</td>
		<td align='left' ><? echo ucwords(strtolower($Fila["apellido_paterno"].' '.$Fila["apellido_materno"].' '.$Fila[nombres])); ?>&nbsp;</td>
		<td ><? echo $Fila[cuenta_red]; ?>&nbsp;</td>
		</tr>
		<?
	$Cont=$Cont+1;
	}
	?>
</table>
  <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
    <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15"></td>
	<td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15"></td>
  </tr>
  </table> 
  <?
}
	?>
</form>
</BODY>

