<?
include('conectar_ori.php');
include('funciones/siper_funciones.php');

if($VisibleDivProceso=='S')
$VisibleDiv='hidden';
if(isset($Pantalla))
	acceso($CookieRut,$Pantalla);

?>
<html>
<head>
<title>SASSO - Mantenedor Verificador</title>

<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">

var popup=0;
function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmPrincipal;
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
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "N":
				Datos=Recuperar(f.name,'CheckRut');
				DivProceso.style.visibility='visible';
				f.Proc.value='N';
				f.Datos.value=Datos;
				f.action='mantenedor_tipo_verificador.php?VisibleDivProceso=S&Buscar=S';
				f.submit();		
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckRut','M'))
			{
				Datos=Recuperar(f.name,'CheckRut');
				DivProceso.style.visibility='visible';
				f.Proc.value='M';
				f.Datos.value=Datos;
				f.action='mantenedor_tipo_verificador.php?VisibleDivProceso=S&Buscar=S';
				f.submit();				
			}	
		break;
		case "G":
			if(f.TxtNombre.value!='')
			{
				if(f.rdvigente[0].checked==true)
					f.Vigente.value='S';
				else
					f.Vigente.value='N';
				DivProceso.style.visibility='hidden';
				f.action='mantenedor_tipo_verificador01.php?Proceso='+f.Proc.value;
				f.submit();
			}
			else
			{
				alert('Debe Ingresar Descripci�n')
				f.TxtNombre.focus();
			}
		break;
		case "C":
				f.action='mantenedor_tipo_verificador.php?Buscar=S';
				f.submit();		
		break;
/*		case "E":
			if(SoloUnElemento(f.name,'CheckRut','E'))
			{
				mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					DatosUni=Recuperar(f.name,'CheckRut');
					URL='proceso_elimina_dato.php?Proceso=E&Parent='+DatosUni+'&Dato=ETV';//ELIMINA TIPO VERIFICADOR
					window.open(URL,"","top=30,left=30,width=500,height=300,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
					//f.action='mantenedor_tipo_verificador01.php?Proceso=E&DatosUni='+DatosUni;
					//f.submit();
				}
			}	
		break;*/
	
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=29&Nivel=1&CodPantalla=6";
		break;
	}	
}
function EliminarControl()
{
	f=document.FrmPrincipal;
	if(SoloUnElemento(f.name,'CheckRut','E'))
	{
		mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
		if(mensaje==true)
		{

			ObsElimina.style.visibility = 'visible';
			Transparente.style.visibility = 'visible';
/*					URL='proceso_elimina_dato.php?Proceso=E&Parent='+DatosUni+'&Dato=ETV';//ELIMINA TIPO VERIFICADOR
			window.open(URL,"","top=30,left=30,width=500,height=300,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
*/					//f.action='mantenedor_tipo_verificador01.php?Proceso=E&DatosUni='+DatosUni;
			//f.submit();
		}
	}	
}
function CerrarDiv()
{
	ObsElimina.style.visibility = 'hidden';
	Transparente.style.visibility = 'hidden';
}
function ConfirmaEliminar()
{
	var f=document.FrmPrincipal;
	if(f.ObsEli.value=='')
	{
		alert('Debe Ingresar Observaci�n de Eliminaci�n');
		f.ObsEli.focus();
		return;
	}
	DatosUni=Recuperar(f.name,'CheckRut');
	f.action='mantenedor_tipo_verificador01.php?Proceso=E&DatosUni='+DatosUni;
	f.submit();
}
function CloseDiv()
{

	DivProceso.style.visibility='hidden';
	DivOCu.style.visibility='visible';
	Transparente2.style.visibility = 'hidden';
}
</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<input name="Datos" type="hidden" value="<? echo $Datos;?>">
<input name="Proc" type="hidden" value="<? echo $Proc;?>">
<input name="Vigente" type="hidden" value="<? echo $Vigente;?>">
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
	 <td align="center" colspan="2" class="TituloCabecera2">Mantenedor Verificadores</td>
	 </tr>
	 <tr>       
	   <td width="52" height="35" align="left" class="formulario"   ><img src="imagenes/LblCriterios.png" /> </td>
       <td align="right" class="formulario" >
	   <div id="DivOCu" style="visibility:<? echo $VisibleDiv;?>">
	   <a href="JavaScript:Proceso('N')"><img src="imagenes/btn_agregar.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp; <a href="JavaScript:Proceso('M')"><img src="imagenes/btn_modificar.png" alt="Modificar" width="30" height="30" border="0" align="absmiddle"></a>&nbsp; <a href="JavaScript:EliminarControl()"><img src="imagenes/btn_eliminar2.png"  alt="Eliminar" width="25" height="25" border="0" align="absmiddle"></a>&nbsp; <a href="JavaScript:Proceso('S')"><img src="imagenes/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a> 
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
	    <td width="5%" align="center" class="TituloCabecera">C�digo</td>
	    <td width="80%" align="center" class="TituloCabecera">Familia de verificadores </td>
	    <td width="80%" align="center" class="TituloCabecera">Descripci�n del Verificador</td>
		 <td width="10%" align="center" class="TituloCabecera">Vigente</td>
        </tr>
      <?
		//if($Buscar=='S')
		//{
			$Consulta = "SELECT * from sgrs_tipo_verificador ";
			if($TxtDescripcion!='')
				$Consulta.= " where upper(DESCRIP_VERIFICADOR) like('%".strtoupper($TxtDescripcion)."%') ";
			$Resp = mysql_query($Consulta);
			echo "<input name='CheckRut' type='hidden'  value=''>";
			$cont=1;
			while ($Fila=mysql_fetch_array($Resp))
			{
			
			if($Fila["ACTIVO"]=='S')
			$VIg='Si';
			else
			$VIg='No';
			
		?>
			 	<tr>
				<td align="center" ><? echo "<input name='CheckRut' class='SinBorde' type='checkbox'  value='".$Fila["COD_VERIFICADOR"]."'"; ?></td>
				<td align="center"><? echo $Fila["COD_VERIFICADOR"]."&nbsp;"; ?></td>
				<td ><? echo $Fila["DESCRIP_VERIFICADOR"]."&nbsp;"; ?></td>
				<td ><textarea name="Obs" cols="50" readonly="readonly"><? echo $Fila["OBS"];?></textarea></td>
				<td align="center" ><? echo $VIg; ?>&nbsp;</td>
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
{
	$VisibleDivProceso='hidden';
	$DivTrans='hidden';
}	
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
<style>
.trans2{
  background-color:#CCCCCC;
  color:#CC0000;
  position:absolute;
  text-align:center;
  top:0px;
  left:10px;
  padding:65px;
  font-size:25px;
  font-weight:bold;
  width:300px;
}
</style>
<div class="trans2" id="Transparente2" align="center" style='FILTER: alpha(opacity=10); overflow:auto; VISIBILITY:<? echo $DivTrans;?>; WIDTH: 100%; height:80%; POSITION: absolute; moz-opacity: .60; opacity: .60;'>
 </div>
<div id="DivProceso" style="visibility:<? echo $VisibleDivProceso;?>;FILTER: alpha(opacity=100);overflow:auto; POSITION: absolute; moz-opacity: .75; opacity: .75;left: 300px; top: 110px; width:500px; height:143px;" align="center">
<table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
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
			$Consulta="Select * from sgrs_tipo_verificador where COD_VERIFICADOR='".$Datos."' ";
			$Resp1 = mysql_query($Consulta);
			if ($Fila1=mysql_fetch_array($Resp1))
			{
			 $TxtCod=$Fila1[COD_VERIFICADOR];
			 $TxtNombre=$Fila1[DESCRIP_VERIFICADOR];
			 $Vigente=$Fila1["ACTIVO"];
			 $OBSVERI=$Fila1[OBS];
			}
			$TxtQLPP=number_format($TxtQLPP,3,',','');
		
		}
		else
		{
			$TxtNombre='';
			$Vigente='S';
		}
	  ?>
	  
        <td class="formulario">Nombre</td>
		<td> <input name="TxtNombre" type="text" id="TxtNombre" value="<? echo $TxtNombre; ?>" maxlength="50" size="60"  maxlength="100"/><span class="InputRojo">(*)</span></td>
      </tr>
	  <tr>
       <td class="formulario">Descripci�n</td>
		<td><textarea name="ObsVeri" cols="60"><? echo $OBSVERI;?></textarea></td>
      </tr>
	     <tr>
        <td class="formulario">Vigente</td>
		<td class="formulario">
		<? 
		if($Vigente=='S')
		{?>Si<input name="rdvigente" type="radio" id="rdvigente" class="SinBorde" checked="checked" >&nbsp;&nbsp;No<input name="rdvigente" type="radio" id="rdvigente" class="SinBorde"  >
		<?
		}
		else
		{?>
			Si<input name="rdvigente" type="radio" id="rdvigente"  class="SinBorde" >&nbsp;&nbsp;No<input name="rdvigente" type="radio" id="rdvigente"  checked="checked"  class="SinBorde" >
		<? }	?>
		</td>
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
 <?
include('div_obs_elimina_mantenedor.php');
?>
</form>
</body>
</html>
<?
echo "<script language='javascript'>";
if($Mensaje!='')
	echo "alert('".$Mensaje."');";
echo "</script>";
?>

