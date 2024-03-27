<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
if(!isset($Ano))
	$Ano=date('Y');
if(!isset($Mes))
	$Mes=date('m');
if(!isset($Recarga))
{
	if ($Opcion=='M')
	{
		$Consulta="select * from pcip_eec_facturas_suministros where corr = '".$Corr."'";
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$CmbSuministro=$Fila["cod_suministro"];
			$Ano=$Fila["ano"];
			$Mes=$Fila["mes"];
			$TxtValorTotal=$Fila["valor_total"];
			$TxtPrecio=$Fila["precio"];
		}
	}
	else
	{
		$CmbSuministro='';
		$Ano=date('Y');
		$Mes=date('m');
		$TxtValorTotal='';
		$TxtPrecio='';
	}
}
?>
<html>
<head>
<?
	if ($Opcion=='N')
		echo "<title>Nuevo Factura Suministro</title>";
	else	
		echo "<title>Modifica Factura Suministro</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Recarga()
{
	var f= document.FrmPopupProceso;
	f.action = "pcip_mantenedor_facturas_suministros_proceso.php?Opcion=M&Recarga=S";
	f.submit();
}
function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	var Valida=true;
	var Veri="";

	switch(Opcion)
	{	
		case "N":
			f.Opcion.value=Opcion;
			Veri=ValidaCampo();
			if (Veri==true)
			{
				f.action = "pcip_mantenedor_facturas_suministros_proceso01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "M":
			f.Opcion.value=Opcion;
			Veri=ValidaCampo();
			if (Veri==true)
			{
				f.action = "pcip_mantenedor_facturas_suministros_proceso01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "NI":
			f.Opcion.value='N';
			f.action = "pcip_mantenedor_facturas_suministros_proceso.php?Opcion=N";
			f.submit();
		break;

	}
}
function Salir()
{
	window.close();
}
function TeclaPulsada1(tecla) 
{ 
	var Frm=document.FrmPopupProceso;
	var teclaCodigo = event.keyCode; 


		if ((teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
			   		event.keyCode=46;
			   }		
			}   
		}
		
} 
function ValidaCampo()
{
	var f= document.FrmPopupProceso;
	var Res=true;
	if(f.CmbSuministro.value=='-1')
	{
		alert("Debe Seleccionar Suministro");
		f.CmbSuministro.focus();
		Res=false;
		return;
	}
	if(parseInt(f.TxtPrecio.value)=='0'&&parseInt(f.TxtValorTotal.value)=='0' || f.TxtPrecio.value==''&&f.TxtValorTotal.value=='')
	{
		alert("Es requerido un Valor o Precio por Suministros");
		f.TxtValorTotal.focus();
		Res=false;
		return;
	}
	return(Res);
}
</script>

<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #F9F9F9;
}
-->
</style></head>

<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="Opcion" value="<? echo $Opcion;?>">
<input name="Form" type="hidden" value="<? echo $Form; ?>">
<input name="Pagina" type="hidden" value="<? echo $Pagina; ?>">
<input name="Corr" type="hidden" value="<? echo $Corr; ?>">

  <table align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="955" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2x.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_factura_sumi_n.png"><? }else{?><img src="archivos/sub_tit_factura_sumi_m.png"><? }?></td>
       <td align="right">
	   <a href="JavaScript:Proceso('NI')"><img src="archivos/nuevo.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>
	   <a href="JavaScript:Proceso('<? echo $Opcion;?>')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="ColorTabla02" >
         <tr>
           <td width="179" class="formulario2">Tipo Suministro </td>
           <td colspan="3" class="FilaAbeja2"><select name="CmbSuministro" onChange="Recarga()">
			  <option value="-1" class="NoSelec">Seleccionar</option>
			  <?
				$Consulta = "select t1.cod_suministro,t1.nom_suministro,t1.cod_unidad from pcip_eec_suministros t1 where t1.cod_suministro not in ('8','9','10') order by t1.nom_suministro";		
				$Resp=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbSuministro==$FilaTC["cod_suministro"])
					{
						echo "<option selected value='".$FilaTC["cod_suministro"]."'>".ucfirst($FilaTC["nom_suministro"])."</option>\n";
						$Unidad=$FilaTC[cod_unidad];
					}
					else
						echo "<option value='".$FilaTC["cod_suministro"]."'>".ucfirst($FilaTC["nom_suministro"])."</option>\n";
				}
					?>
			</select><? //echo $Consulta;?>
             <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td height="33" class="formulario2">A&ntilde;o</td>
           <td width="244" class="FilaAbeja2"><span class="formulario2">
             <select name="Ano" id="Ano">
               <?
				for ($i=2003;$i<=date("Y");$i++)
				{
					if ($i==$Ano)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				}
				?>
             </select>
           </span></td>
           <td width="603" colspan="2" class="FilaAbeja2" >Mes&nbsp;&nbsp;<span class="formulario2">
             <select name="Mes" id="Mes">
               <?
				for ($i=1;$i<=12;$i++)
				{
					if ($i==$Mes)
						echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
					else
						echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
				}
				?>
             </select>
           </span></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Valor Total </td>
           <td colspan="3" class="FilaAbeja2"><input name="TxtValorTotal" type="text" onKeyDown="SoloNumerosyNegativo(true,this)" maxlength="20" size="20"  class="InputIzq" value="<? echo  number_format($TxtValorTotal,2,',','.'); ?>">&nbsp;&nbsp;US$ <span class="InputRojo">(*)</span> </td>
         </tr>
         <tr>
           <td class='formulario2'>Precio</td>
           <td colspan="3" class="FilaAbeja2" >
		    <input name="TxtPrecio" type="text" maxlength="20" size="20" onKeyDown="SoloNumerosyNegativo(true,this)" class="InputIzq" value="<? echo  number_format($TxtPrecio,2,',','.'); ?>" onKeyDown="TeclaPulsada(true)">&nbsp;&nbsp;US$/<? echo $Unidad;?>
            <span class="InputRojo">(*)</span></tr>		 
         <tr>
           <td height="14" colspan="4" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
         </tr>
       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   <br></td>
   <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>
</form>		
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Ingresada Factura Correctamente');";
	if ($Mensaje=='2')
		echo "alert('La Factura Se Encuentra Ingresado ');";
	if ($Mensaje=='3')
		echo "alert('La Factura Se Modific� Correctamente');";
	if ($Mensaje=='4')
		echo "alert('Modificaci�n Ingresada Correctamente');";
	if ($Mensaje=='5')
		echo "alert(' Modificacion de Factura Eliminada');";
	echo "</script>";
?>
</body>
</html>