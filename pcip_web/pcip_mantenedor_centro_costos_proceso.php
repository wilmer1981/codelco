<? include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");


if(!isset($Recarga))
{
	if ($Opcion=='M')
	{
		
		$Consulta="select * from pcip_eec_centro_costos where cod_area = '".$Corr."'";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$CmbGerencias=$Fila["cod_gerencia"];
			$TxtDescripcion=$Fila["descrip_area"];
			$TxtCC=$Fila["cod_cc"];
		}
	}
}	
?>
<html>
<head>
<?
	if ($Opcion=='N')
		echo "<title>Nuevo Centro Costos</title>";
	else	
		echo "<title>Modifica Centro Costos</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmPopupUsuario;
	var Valida=true;
	var Veri="";
	var Adm="";
	var Check="";

	switch(Opcion)
	{	
		case "N":
			f.Opcion.value=Opcion;
			Veri=ValidaCampos();
			if (Veri==true)
			{
				f.action = "pcip_mantenedor_centro_costos_proceso01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "M":
			f.Opcion.value=Opcion;
			Veri=ValidaCampos();
			if (Veri==true)
			{
				f.action = "pcip_mantenedor_centro_costos_proceso01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "R":	
			f.action = "pcip_mantenedor_centro_costos_proceso.php?Recarga=S";
			f.submit();
		break;
		case "NI":
			f.action = "pcip_mantenedor_centro_costos_proceso.php?Opc=N";
			f.submit();
		break;
		
	}
}
function Salir()
{
	window.close();
}
function ValidaCampos()
{
	var f= document.FrmPopupUsuario;
	var Res=true;
	if (f.CmbGerencias.value=="-1")
	{
		alert("Debe Seleccionar Gerencias");
		f.CmbGerencias.focus();
		Res=false;
		return;
	}
	if (f.TxtCC.value=="")
	{
		alert("Debe Ingresar Centros de Costo");
		f.TxtCC.focus();
		Res=false;
		return;
	}
	if (f.TxtDescripcion.value=="")
	{
		alert("Debe Ingresar Descripcion Centro Costos");
		f.TxtDescripcion.focus();
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
<form name="FrmPopupUsuario" method="post" action="">
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
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_cc_n.png" width="450" height="40"><? }else{?><img src="archivos/sub_tit_cc_m.png" width="450" height="40"><? }?></td>
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
           <td width="180" class="formulario2">Gerencia</td>
           <td class="FilaAbeja2"><span class="InputRojo">
<select name="CmbGerencias" style="width:250">
  <option value="-1" selected="selected">Seleccionar</option>
  <?
	  $Consulta = "select cod_gerencia,descrip_gerencias from pcip_eec_gerencias order by descrip_gerencias ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
			if ($CmbGerencias==$Fila["cod_gerencia"])
				echo "<option selected value='".$Fila["cod_gerencia"]."'>".ucfirst($Fila["descrip_gerencias"])."</option>\n";
			else
				echo "<option value='".$Fila["cod_gerencia"]."'>".ucfirst($Fila["descrip_gerencias"])."</option>\n";
		}
			?>
</select>             
(*)</span></td>
         </tr>
         <tr>
           <td width="180" class="formulario2">Codigo</td>
           <td class="FilaAbeja2"><span class="InputRojo"><span class="formulario2">
             <input type="text" name="TxtCC" value="<? echo $TxtCC;?>">
           </span>(*)</span></td>
         </tr>
         <tr>
           <td height="33" class="formulario2">Descripci&oacute;n</td>
           <td class="FilaAbeja2"><span class="InputRojo"><span class="formulario2">
             <input type="text" name="TxtDescripcion" size="70" value="<? echo $TxtDescripcion;?>">
           </span>(*)</span></td>
           </tr>
         <tr>
           <td colspan="2" class='formulario2'>&nbsp;</td>
         </tr>
		 
         <tr>
           <td height="14" colspan="2" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
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
		echo "alert('Ingresado Centro Costos Correctamente');";
echo "</script>";
?>
</body>
</html>
