<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
if(!isset($Ano))
 	$Ano=date('Y');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	var Valores='';
	switch(Opcion)
	{	
		case "G":
			//alert(Opcion);
			f.action = "pcip_mantenedor_asignaciones_proceso01.php?Opcion="+Opcion+"&Ano="+f.Ano.value+"&AnoFin="+f.AnoFin.value;
			f.submit();
			break;
	}
}
function Salir()
{
	window.close();
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
<input type="Hidden" name="Valores" value="<? echo $Valores;?>">
<input name="Form" type="hidden" value="<? echo $Form; ?>">

  <table width="396"  border="0" align="center" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="955" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2x.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="85%" align="left"><img src="archivos/sub_tit_cambiar_ano.png"></td>
       <td width="15%" align="right">
	   <a href="JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> 
	   <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
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
		 <td width="218" align="right" class='formulario2'>A&ntilde;os Actuales con Datos
		 <td width="270" class='formulario2'>
		   <span class="formulario2">
            <select name="Ano" id="Ano">
            <?
			$Consulta="select distinct(ano) from pcip_svp_productos_procedencias";
			$Resp=mysql_query($Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				if ($Ano==$Fila[ano])
					echo "<option selected value='".$Fila["ano"]."'>".ucfirst($Fila["ano"])."</option>\n";
				else
					echo "<option value='".$Fila["ano"]."'>".ucfirst($Fila["ano"])."</option>\n";
			}		
			?>
            </select><? //echo $Consulta;?>
            </span>		  </td>
		</tr>		 
        <tr>
		 <td width="218" align="right" class='formulario2'>A&ntilde;o a cambiar
		 <td width="270" class='formulario2'>
		   <span class="formulario2">
            <select name="AnoFin" id="AnoFin">
            <?
			for ($i=date("Y")-6;$i<=date("Y");$i++)
			{
				$Consulta="select distinct(ano) from pcip_svp_productos_procedencias where ano='".$i."'";
				$Resp=mysql_query($Consulta);
				if(!$Fila=mysql_fetch_array($Resp))
				{
					if ($i==$AnoFin)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				}		
			}
			?>
            </select>
            </span>		  </td>
		</tr>		 
         <tr>
           <td height="14" colspan="2" class="formulario2">&nbsp;</td>
         </tr>
       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td align="center" class="TituloTablaVerde"></td>
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
		echo "alert('Registro (s) Cambiados Exitosamente');";
	echo "</script>";

?>	
</body>
</html>
