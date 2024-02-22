<? include("../principal/conectar_scop_web.php");

	$Valores2=explode("~",$Valores);
	$Consulta="select * from scop_carry_cost_proceso where  corr='".$Valores2[0]."' and parcializacion='".$Valores2[1]."' and cod_ley='".$Valores2[2]."' and cod_tipo_titulo='2'";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$Cod=$Fila["corr"]."~".$Fila[parcializacion]."~".$Fila["cod_ley"];
		$TxtExistente=$Fila["valor"];
	}		
?>
<html>
<head>
<?
	echo "<title>Modifica Precios Carry Cost</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/scop_funciones.js"></script>
<script language="JavaScript">
function Modificar(Opc,Datos,TipoEst)
{
	var f= document.FrmPopupProceso;
	if(f.TxtNuevo.value=='')
	{
		alert("Debe Ingresar Precio Para Modificar");
		f.TxtNuevo.focus();
		return;
	}
	f.action = "scop_proceso_cobertura_carry_cost01.php?Opcion="+Opc+"&TipoEst="+TipoEst+"&Datos="+Datos;
	f.submit();
}
function Salir(Datos)
{
   var f= document.FrmPopupProceso;
   window.opener.document.FrmPrincipal.action='scop_proceso_cobertura_carry_cost.php?Buscar=S&TipoEst='+Datos;
   window.opener.document.FrmPrincipal.submit();
   window.close();
}
</script>
</head>
<?
	echo '<body onLoad="document.FrmPopupProceso.TxtNuevo.focus();">';
?>
<link href="../scop_web/estilos/css_scop_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="../scop_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="1067" height="15"background="../scop_web/archivos/images/interior/form_arriba.gif"><img src="../sget_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="../scop_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../scop_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="85%" align="left"><img src="../scop_web/archivos/subtitulos/sub_tit_precios_carry_cost_m.png"></td>
       <td width="15%" align="right">
	   <a href="JavaScript:Modificar('MPCC','<? echo $Cod?>','<? echo $TipoEst?>')"><img src="../scop_web/archivos/grabar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir('<? echo $TipoEst?>')"><img src="../scop_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="0" >
	     <tr>
		 	<? 
			if($Valores2[2]==1)
			{
				$Ley='Cobre';
				$Uni='[cUSD/Lb]';
			}
			if($Valores2[2]==2)
			{
				$Ley='Plata';
				$Uni='[cUSD/Oz]';
			}
			if($Valores2[2]==3)
			{
				$Ley='Oro';
				$Uni='[USD/Oz]';
			}
			?>
           <td width="149" class="formulario2">Precio Existente <? echo $Ley;?></td>
           <td colspan="4" class="formulario2">
		   <? echo number_format($TxtExistente,3,',','.'); ?>&nbsp;&nbsp;<? echo $Uni;?></td>
         </tr>
		<tr>	 		 		  				 				  	 
           <td width="149" class="formulario2">Nuevo Precio </td>
           <td class="formulariosimple"><span class="formulario2">
             <input name="TxtNuevo" onKeyDown="SoloNumerosyNegativo(true,this)" maxlength= "10"  size="12" type="text" id="TxtNuevo">
             &nbsp;<? echo $Uni;?></span></td>
           </tr>
       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   </td>
   <td width="15" background="../scop_web/archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="19" height="15"><img src="../scop_web/archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="../scop_web/archivos/images/interior/form_abajo.gif"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>			
</form>
</body>
</html>