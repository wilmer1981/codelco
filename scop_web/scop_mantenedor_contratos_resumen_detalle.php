	<? //echo "resumen";
		include("../principal/conectar_scop_web.php");	
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">   
function Salir()
{
	window.close();
}
</script>
<link href="../scop_web/estilos/css_scop_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<input type="hidden" name="Opc" value="<? echo $Opc;?>">
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td><img src="../scop_web/archivos/images/interior/esq1em.gif" width="15" /></td>
    <td width="920" background="../scop_web/archivos/images/interior/form_arriba.gif"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" /></td>
    <td ><img src="../scop_web/archivos/images/interior/esq2em.gif" width="15" /></td>
  </tr>
  <tr>
    <td background="../scop_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
    <td align="center">
	<table width="930" border="1" cellpadding="4" cellspacing="0" >
 <tr>	 
   <td align="right" colspan="4"><a href="JavaScript:Salir()"><img src="../scop_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0" /></a></td>
   </tr>
	<tr class="TituloTablaVerdeActiva"> 	 
   <?
	  $Contrato=$Datos;	 		
	  $Consulta1="select num_contrato from scop_contratos where cod_contrato='".$Contrato."'";
	  $Resp1=mysql_query($Consulta1);	
	  if ($Fila1=mysql_fetch_array($Resp1))
	  {
	  	$NumContrato=$Fila1["num_contrato"];
   ?>	
	   <td align="left" colspan="4">Contrato&nbsp;&nbsp;&nbsp;&nbsp;<? echo $NumContrato;?></td>
   <? }?>	  
	   </tr>		
	 <tr>	 
	   <td class="formulario2" colspan="4" align="center">Configuraci�n Flujos Contrato </td>
	 </tr>		
	<?	 	
	  $Consulta1="select distinct tipo_inventario from scop_contratos_flujos where cod_contrato='".$Contrato."' order by tipo_inventario";
	  $Resp1=mysql_query($Consulta1);	
	  while ($Fila1=mysql_fetch_array($Resp1))
	  {
			$TipoInventario=$Fila1[tipo_inventario];
			if($TipoInventario==1)
			{
				$TipoInventario='STOCK INICIAL';
				$TipoMov='3';
			}
			if($TipoInventario==2)
			{
				$TipoInventario='RECEPCI&Oacute;N';
				$TipoMov='2';
			}
			if($TipoInventario==3)
			{
				$TipoInventario='BENEFICIO/EMBARQUE';
				$TipoMov='2';
			}
			if($TipoInventario==4)
			{
				$TipoInventario='STOCK FINAL';
				$TipoMov='3';
			}
		   echo "<tr class='TitulotablaNaranja'>";
			 echo "<td width='7%' align='left' colspan='4'>".$TipoInventario."</td>";
		   echo "</tr>";
			echo "<tr class='TitulotablaVerde'>";
			 echo "<td width='75%' align='center' colspan='2'>Flujo</td>";
			 echo "<td width='20%' align='center' >Tipo Flujo</td>";
			 echo "<td width='20%' align='center' >Signo</td>";
			echo "</tr>"; 
		  $Consulta="select distinct t1.cod_contrato,t1.tipo_flujo,t2.nom_flujo,t1.flujo,t1.signo from scop_contratos_flujos t1 inner join scop_datos_enabal t2 on t1.flujo=t2.cod_flujo and t1.tipo_flujo=t2.origen where t1.cod_contrato='".$Contrato."' and t1.tipo_inventario='".$Fila1[tipo_inventario]."' and t2.tipo_mov='".$TipoMov."'";
		  $Resp=mysqli_query($link, $Consulta);	
		  while ($Fila=mysql_fetch_array($Resp))
		  {
				$Contrato=$Fila["cod_contrato"];
				$NomFlujo=$Fila[nom_flujo];	
				$TipoFlujo=$Fila[tipo_flujo];
				$CodFlujo=$Fila["flujo"];
				if($Fila["signo"]=='1')
					$Signo='+';
				else
					$Signo='-';	
				echo "<tr>";
					echo "<td align='center'>".$CodFlujo."</td>";	
					echo "<td align='left'>".$NomFlujo."</td>";	
					echo "<td align='center'>".$TipoFlujo."</td>";	
					echo "<td align='center'>".$Signo."</td>";	
				echo "</tr>";	
		  }
	  }
	?>
    </table>
        <br>
      &nbsp; </td>
    </td>
    <td width="10" background="../scop_web/archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15"><img src="../scop_web/archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
    <td height="1"background="../scop_web/archivos/images/interior/form_abajo.gif"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15"><img src="../scop_web/archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
  </tr>
</table>
</form>
</body>
</html>	   
