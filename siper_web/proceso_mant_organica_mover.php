<?
include('conectar_ori.php');
include('funciones/siper_funciones.php');
if($MostrarMensaje!='S')
	$Mensaje='';
$Cont=1;$Nivel=0;
$Codigos=explode(',',$SelTarea);
while(list($c,$v)=each($Codigos))
{
	if($v!=''&&$v!='0')
	{
		$Consulta="SELECT CTAREA from sgrs_areaorg where CAREA='".$v."'";
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysql_fetch_array($Resp);
		if($Nivel<$Fila[CTAREA])
			$Nivel=$Fila[CTAREA];
	}	
}
//echo "NIVEL ARBOL 1: ".$Nivel."<BR>";
$Cont=1;$Nivel2=0;
$Codigos=explode(',',$SelTarea2);
while(list($c,$v)=each($Codigos))
{
	if($v!=''&&$v!='0')
	{
		$Consulta="SELECT CTAREA from sgrs_areaorg where CAREA='".$v."'";
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysql_fetch_array($Resp);
		if($Nivel2<$Fila[CTAREA])
			$Nivel2=$Fila[CTAREA];
		$Consulta="SELECT min(CTAREA) as tarea_mayor from sgrs_areaorg where CPARENT like '".$SelTarea2."%' and CAREA<>'".$v."'";
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysql_fetch_array($Resp);
		$NivelInferior=$Fila[tarea_mayor];
			
	}	
}
//echo "NIVEL ARBOL 2: ".$Nivel2."<BR>";

if($VisibleDivProceso=='S')
$VisibleDiv='hidden';
?>
<html>
<head>
<title>Movimientos de Niveles en Area Organizacional</title>

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
	var f=document.FrmOrganica;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "G":
			if(f.Nivel.value==0)
			{
				alert('Debe Seleccionar Nivel Origen');
				return;
			}
			if(f.Nivel2.value==0)
			{
				alert('Debe Seleccionar Nivel Destino');
				return;
			}
			if(f.Nivel.value!='4'&&f.Nivel2.value!='5')
			{
				if(f.Nivel.value<=f.Nivel2.value)
				{
					alert('El Nivel Origen a Mover debe ser de Inferior al Nivel Destino');
					return;
				}
			}
			if(confirm('Esta Seguro de Mover el Nivel Seleccionado'))
			{
				ObsElimina.style.visibility = 'visible';
				Transparente.style.visibility = 'visible';
			}
			/*if(f.Nivel.value<f.NivelInferior.value)
			{
				alert('El SubNivel del Nivel de Destino posee\n un Nivel inferior a Nivel Origen a Mover');
				return;
			}*/
			/*if(confirm('Esta Seguro de Mover el Nivel Seleccionado'))
			{
				f.action='proceso_mant_organica_mover01.php?Proceso=G';
				f.submit();
			}*/
		break;
		case "S":
			//window.opener.document.Mantenedor.action = "proceso_mant_organica.php";
			//window.opener.document.Mantenedor.submit();
			window.close();
		break;
	}	
}
function BuscaHijos(Codigo,Filtro)
{
	var f=document.FrmOrganica;
	var Estados='';
	
	f.Navega.value=Codigo;
	//f.SelTarea.value='';
	f.Estado.value=Codigo;
	if(Filtro!='S')
	  f.SelTarea.value='';
	var EstadoItem='';
	
	EstadoItem=f.Estado.value.split(",");
	for (var i=0;i<EstadoItem.length;i++)
	{
		if(EstadoItem[i]!='')
			Estados=Estados+"A,";
	}
	f.Estado.value=Estados.substr(Estados,Estados.length-2,2);
	f.Estado.value=f.Estado.value+"C";
	
	f.action='proceso_mant_organica_mover.php';
	f.submit();
}
function SelecItem(Codigo)
{
	var f=document.FrmOrganica;
	
	//alert(Codigo);
	f.Navega.value=Codigo;
}
function ItemSelec(Codigo)
{
	var f=document.FrmOrganica;
	
	f.SelTarea.value=Codigo;
	f.location='proceso_mant_organica_mover.php?CodSelTarea='+f.SelTarea.value;
	f.submit();	
}
function BuscaHijos2(Codigo,Filtro)
{
	var f=document.FrmOrganica;
	var Estados='';
	
	f.Navega2.value=Codigo;
	//f.SelTarea.value='';
	f.Estado2.value=Codigo;
	if(Filtro!='S')
	  f.SelTarea2.value='';
	var EstadoItem='';
	
	EstadoItem=f.Estado2.value.split(",");
	for (var i=0;i<EstadoItem.length;i++)
	{
		if(EstadoItem[i]!='')
			Estados=Estados+"A,";
	}
	f.Estado2.value=Estados.substr(Estados,Estados.length-2,2);
	f.Estado2.value=f.Estado2.value+"C";
	
	f.action='proceso_mant_organica_mover.php';
	f.submit();
}
function SelecItem2(Codigo)
{
	var f=document.FrmOrganica;
	
	//alert(Codigo);
	f.Navega2.value=Codigo;
}
function ItemSelec2(Codigo)
{
	var f=document.FrmOrganica;
	
	f.SelTarea2.value=Codigo;
	f.location='proceso_mant_organica_mover.php?CodSelTarea='+f.SelTarea2.value;
	f.submit();	
}
function ConfirmaEliminar()
{
	var f=document.FrmOrganica;
	/*if(f.Nivel.value<f.NivelInferior.value)
	{
		alert('El SubNivel del Nivel de Destino posee\n un Nivel inferior a Nivel Origen a Mover');
		return;
	}*/
		f.action='proceso_mant_organica_mover01.php?Proceso=G';
		f.submit();
}
function CerrarDiv()
{
	ObsElimina.style.visibility = 'hidden';
	Transparente.style.visibility = 'hidden';
	
}
</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<form name="FrmOrganica" method="post" action="">
<input type="hidden" value="<? echo $Nivel;?>" name="Nivel">
<input type="hidden" value="<? echo $Navega;?>" name="Navega">
<input type="hidden" value="<? echo $Estado;?>" name="Estado">
<input type="hidden" value="<? echo $SelTarea;?>" name="SelTarea">
<input type="hidden" value="<? echo $Navega2;?>" name="Navega2">
<input type="hidden" value="<? echo $Estado2;?>" name="Estado2">
<input type="hidden" value="<? echo $SelTarea2;?>" name="SelTarea2">
<input type="hidden" value="<? echo $Nivel2;?>" name="Nivel2">
<input type="hidden" value="<? echo $NivelInferior;?>" name="NivelInferior">
<?
include('div_obs_elimina_mantenedor_mover.php');
?>
<table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
	<td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
	<td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
	<td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
   <td align="center"><table width="96%" border="0" cellpadding="0"  cellspacing="0">
     <tr>
	 <td align="center" colspan="2" class="TituloCabecera2">Movimientos de Niveles en Area Organizacional </td>
	 </tr>
	 <tr>       
	   <td width="52" height="35" align="left" class="formulario"   >&nbsp;</td>
       <td align="right" class="formulario" >
	   <div id="DivOCu" style="visibility:<? echo $VisibleDiv;?>">
	   <a href="JavaScript:Proceso('G')"><img src="imagenes/genera.gif"  border="0"  alt="Grabar" align="absmiddle"/></a>&nbsp;<a href="JavaScript:Proceso('S')"><img src="imagenes/btn_salir.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a>       </div></td>
	 </tr>
     <tr>
       <td colspan="3" class="formulario">&nbsp;</td>
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
<table width="100%" height="80%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
    <td width="98%" height="15" valign="top" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
    <td valign="top">
	<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
      <tr>
        <td width="50%" class="TituloCabecera" align="center"> Nivel Organizacional Origen</td>
	    <td width="50%" align="center" class="TituloCabecera">Nivel Organizacional Destino</td>
      </tr>
      <tr>
        <td align="center" valign="top">
		<div style='position:relative; left:0px; top:0px; width:100%; height:500; OVERFLOW:auto;' id='OrganicaGen'>
		<table border='0' cellpadding='0' cellspacing='0' >
		<?
		CrearArbol($Navega,$Estado,$SelTarea,$CookieRut,'N');
		?>
		</table></div>		
		</td>
        <td align="center">
		<div style='position:relative; left:0px; top:0px; width:100%; height:500; OVERFLOW:auto;' id='OrganicaGen'>
		<table border='0' cellpadding='0' cellspacing='0' >
		<?
		CrearArbol2($Navega2,$Estado2,$SelTarea2,$CookieRut,'N');
		?>
		</table></div>		
		</td>
      </tr>
      <?

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
</form>
<?
echo "<script language='javascript'>";
if($Mensaje!='')
	echo "alert('".$Mensaje."');";
echo "</script>";
?>
</body>
</html>


