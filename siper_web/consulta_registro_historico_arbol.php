<?php
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
		$Consulta="select CTAREA from sgrs_areaorg where CAREA='".$v."'";
		$Resp=mysqli_query($link,$Consulta);
		$Fila=mysqli_fetch_array($Resp);
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
		$Consulta="select CTAREA from sgrs_areaorg where CAREA='".$v."'";
		$Resp=mysqli_query($link,$Consulta);
		$Fila=mysqli_fetch_array($Resp);
		if($Nivel2<$Fila[CTAREA])
			$Nivel2=$Fila[CTAREA];
		$Consulta="select min(CTAREA) as tarea_mayor from sgrs_areaorg where CPARENT like '".$SelTarea2."%' and CAREA<>'".$v."'";
		$Resp=mysqli_query($link,$Consulta);
		$Fila=mysqli_fetch_array($Resp);
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
			if(f.SelTarea.value=='')
			{
				alert('Debe Seleccionar Área a Consultar');
				return;
			}
			//f.action='consulta_registro.php?SelTarea='+f.SelTarea.value;
			//f.submit();
			window.opener.document.FrmPrincipal.action ='consulta_registro_historico.php?Pro=R&NivelOrg='+f.SelTarea.value;
			window.opener.document.FrmPrincipal.submit();
			window.close();
		break;
		case "S":
			window.opener.document.FrmPrincipal.action ='consulta_registro_historico.php';
			window.opener.document.FrmPrincipal.submit();
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
	
	f.action='consulta_registro_historico_arbol.php';
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
	f.location='consulta_registro_historico_arbol.php?CodSelTarea='+f.SelTarea.value;
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
	
	f.action='consulta_registro_historico_arbol.php';
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
	f.location='consulta_registro_historico_arbol.php?CodSelTarea='+f.SelTarea2.value;
	f.submit();	
}

</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<form name="FrmOrganica" method="post" action="">
<input type="hidden" value="<?php echo $Nivel;?>" name="Nivel">
<input type="hidden" value="<?php echo $Navega;?>" name="Navega">
<input type="hidden" value="<?php echo $Estado;?>" name="Estado">
<input type="hidden" value="<?php echo $SelTarea;?>" name="SelTarea">
<table width="70%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
	<td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
	<td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
	<td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
   <td align="center"><table width="96%" border="0" cellpadding="0"  cellspacing="0">
     <tr>
	 <td align="center" colspan="2" class="TituloCabecera2">Niveles en Area Organizacional </td>
	 </tr>
	 <tr>       
	   <td width="52" height="35" align="left" class="formulario"   >&nbsp;</td>
       <td align="right" class="formulario" >
	   <div id="DivOCu" style="visibility:<?php echo $VisibleDiv;?>">
	   <a href="JavaScript:Proceso('G')"><img src="imagenes/btn_activo.png"  border="0"  alt="Area Seleccionada" align="absmiddle"/></a>
	   <a href="JavaScript:Proceso('S')"><img src="imagenes/btn_inactivo.png"  border="0"  alt="Cerrar" align="absmiddle"/></a>&nbsp;</div></td>
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
<table width="70%" height="30%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
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
        <td align="center" valign="top">
		<div style='position:relative; left:0px; top:0px; width:100%; height:300; OVERFLOW:auto;' id='OrganicaGen'>
		<table border='0' cellpadding='0' cellspacing='0' >
		<?php
		CrearArbolNivelArea($Navega,$Estado,$SelTarea,$CookieRut,'N');
		?>
		</table></div>		
		</td>
      </tr>
      <?php

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
</body>
</html>


