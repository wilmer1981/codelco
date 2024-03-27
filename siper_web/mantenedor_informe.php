<?
include('conectar_ori.php');
include('funciones/siper_funciones.php');

if($VisibleDivProceso=='S')
$VisibleDiv='hidden';
?>
<html>
<head>
<title>Mantenedor Informes</title>

<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">

var popup=0;
function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmPrincipalInforme;
	var teclaCodigo = event.keyCode;
	
	
		if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39) &&(teclaCodigo != 190 ))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
					event.keyCode=46;
			   }		
			}   
		}
		else
		{
			if ((teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo != 188 )&&(teclaCodigo != 190 ))
			{
				event.keyCode=46;
			}	
		}
	
} 
function Proceso(Opc)
{
	var f=document.FrmPrincipalInforme;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "N":
				Datos=Recuperar(f.name,'CheckRut');
				DivProceso.style.visibility='visible';
				f.Proc.value='N';
				f.Datos.value=Datos;
				f.action='mantenedor_informe.php?VisibleDivProceso=S&Buscar=S';
				f.submit();		
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckRut','M'))
			{
				Datos=Recuperar(f.name,'CheckRut');
				DivProceso.style.visibility='visible';
				f.Proc.value='M';
				f.Datos.value=Datos;
				f.action='mantenedor_informe.php?VisibleDivProceso=S&Buscar=S';
				f.submit();				
			}	
		break;
		case "G":
				if(f.TxtNombre.value=='')
				{
					alert('Debe Ingresar Nombre del Archivo');
					f.TxtNombre.focus();
					return;
				}	
				f.action='mantenedor_informe01.php?Proceso='+f.Proc.value;
				f.submit();
				
		
		break;
		case "C":
				f.action='mantenedor_informe.php?Buscar=S';
				f.submit();		
		break;
		case "E":
			if(SoloUnElemento(f.name,'CheckRut','E'))
			{
				mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					DatosUni=Recuperar(f.name,'CheckRut');
					f.action='mantenedor_informe01.php?Proceso=E&DatosUni='+DatosUni;
					f.submit();
				}
			}	
		break;
	
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=29&Nivel=1&CodPantalla=6";
		break;
	}	
}
function CloseDiv()
{

	DivProceso.style.visibility='hidden';
	DivOCu.style.visibility='visible';
}
</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipalInforme" method="post" enctype="multipart/form-data">
<input name="Datos" type="hidden" value="<? echo $Datos;?>">
<input name="Proc" type="hidden" value="<? echo $Proc;?>">

<table width="71%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
	<td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
	<td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
	<td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
   <td align="center"><table width="96%" border="0" cellpadding="0"  cellspacing="0">
     <tr>
	 <td align="center" colspan="2" class="TituloCabecera2">Mantenedor de Informes</td>
	 </tr>
     <tr>
       <td width="52" height="35" align="left" class="formulario"   ><img src="imagenes/LblCriterios.png" /> </td>
       <td align="right" class="formulario" >
	   <div id="DivOCu" style="visibility:<? echo $VisibleDiv;?>">
	   <a href="JavaScript:Proceso('N')"><img src="imagenes/btn_agregar.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp; <a href="JavaScript:Proceso('M')"><img src="imagenes/btn_modificar.png" alt="Modificar" width="30" height="30" border="0" align="absmiddle"></a>&nbsp; <a href="JavaScript:Proceso('E')"><img src="imagenes/btn_eliminar2.png"  alt="Eliminar" width="25" height="25" border="0" align="absmiddle"></a>&nbsp; <a href="JavaScript:Proceso('S')"><img src="imagenes/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a> 
       </div></td>
	 </tr>
     <tr>
       <td colspan="3" class="formulario">Descripci�n
         <input name="TxtDescripcion" type="text" id="TxtDescripcion" value="<? echo $TxtDescripcion; ?>" size="30" />
         <a href="JavaScript:Proceso('C')"><img src="imagenes/Btn_buscar.gif"   alt="Buscar" width="20" height="20"  border="0" align="absmiddle" /></a>
         </td>
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
   </table></td>
   <td width="1%" background="imagenes/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
  </table><br>	
<table width="71%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
    <td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
    <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
      <tr>
        <td width="5%" class="TituloCabecera" align="center"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckRut','ChkTodos');"></td>
	    <td width="10%" align="center" class="TituloCabecera">Adjunto</td>
		<td width="65%" align="center" class="TituloCabecera">Descripci�n</td>
          <td width="10%" align="center" class="TituloCabecera">Fecha</td>
		  <td width="10%" align="center" class="TituloCabecera">Funcionario</td>
	     </tr>
      <?
		//if($Buscar=='S')
		//{
			$Consulta = "SELECT * from sgrs_informes  ";
			$Consulta.=" where not isnull(CINFORME)  ";
			if($TxtDescripcion!='')
				$Consulta.= " and upper(CVINFORME) like('%".strtoupper($TxtDescripcion)."%') ";
			$Resp = mysqli_query($link, $Consulta);
			echo "<input name='CheckRut' type='hidden'  value=''>";
			$cont=1;
			while ($Fila=mysql_fetch_array($Resp))
			{
			$NombreUser='';
				ObtieneUsuario($Fila[CUSUARIO],&$NombreUser);
		?>
			 	<tr>
				<td align="center" ><? echo "<input name='CheckRut' class='SinBorde' type='checkbox'  value='".$Fila["CINFORME"]."'"; ?></td>
				<td align="center"><a href="informes/<? echo $Fila["TNARCHIVO"];?>" target="_blank"><img src="imagenes/btn_adjuntar2.png" height="20" alt="Ver Informe Adjunto" width="20" border="0" align="absmiddle" /></a></td>
				<td ><? echo $Fila["CVINFORME"]."&nbsp;"; ?></td>
				<td align="center" ><? echo $Fila["FINFORME"]; ?>&nbsp;</td>
				<td align="center" ><? echo $NombreUser; ?>&nbsp;</td>
			  </tr>
			  <?		$cont++;
			}
		//}
?>
    </table></td>
    <td width="1%" background="imagenes/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
</table><br>
<? 
if (!isset($VisibleDivProceso))
	$VisibleDivProceso='hidden';
?>
<!--<div id="DivOCu" style="visibility:<? echo $VisibleDivProceso;?>;FILTER: alpha(opacity=100);overflow:auto;  POSITION: absolute; moz-opacity: .75; opacity: .75;left: 672px; top: 33px; width:150px; height:80px;" align="center">
<table width="100%">
  <tr>
    <td >&nbsp;</td>
  </tr>
    <tr>
    <td >&nbsp;</td>
  </tr>
  </table>
</div>-->

<div id="DivProceso" style="visibility:<? echo $VisibleDivProceso;?>;FILTER: alpha(opacity=100);overflow:auto; POSITION: absolute; moz-opacity: .75; opacity: .75;left: 380px; top: 37px; width:466px; height:143px;" align="center">
<table width="55%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td ><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td ><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
    <td align="center"><table width="403" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td  colspan="2"align="right"><a href="JavaScript:Proceso('G')"><img src="imagenes/btn_guardar.png"  border="0"  alt="Grabar" align="absmiddle" /></a><a href="JavaScript:CloseDiv()"><img src="imagenes/btn_salir.png"  border="0"  alt="Cerra" align="absmiddle" /></a></td>
      </tr>
	  <tr>
	  
	  <? 
	  	if($Proc=='M')
		{
			$Consulta="Select * from sgrs_informes where CINFORME='".$Datos."' ";
			$Resp1 = mysqli_query($link, $Consulta);
			if ($Fila1=mysql_fetch_array($Resp1))
			{
			 $TxtNombre=$Fila1[CVINFORME];
		
			}
		
		}
		else
		{
		 	$TxtNombre='';
		}
	  ?>
        <td class="formulario">Descripci�n</td>
		<td> <input name="TxtNombre" type="text" id="TxtNombre" value="<? echo $TxtNombre; ?>" size="40"  maxlength="100"/><span class="InputRojo">(*)</span></td>
      </tr>
	    <tr>
        <td class="formulario">Adj. Documento</td>
		<td><input type="file" name="archivo1" ></td>
		  </tr>
 
       </table></td>
    <td width="1%" background="imagenes/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
</table>
</div>
</form>
</body>
</html>
<?
echo "<script language='javascript'>";
if($Mensaje!='')
	echo "alert('".$Mensaje."');";
echo "</script>";
?>
