<?
	$CodigoDeSistema=25;
	$CodigoDePantalla=3;
?>
<html>
<head>
<title>Datos Base - Produccion de Acido</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>

<script language="javascript" type="text/JavaScript">

function Buscar(opt)
{	
	var f=document.form1;

	if(f.txtfecha.value=='')
	{
		alert ("Debe ingresar fecha de inicio");
		f.txtfecha.focus();
		return false;
	}
	if(f.txtfecha2.value=='')
	{
		alert ("Debe ingresar fecha final");
		f.txtfecha2.focus();
		return false;
	}		
		
	switch (opt)
	{
		case "W":
			f.action="ProduccionAcidoDB.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="ProduccionAcidoDB_excel.php?buscarOPT=S" ;
			f.submit();
			break;
	}
	
	
}
function imprimir()
{
	var f=document.form1;
		f.BtnBusca.style.visibility='hidden';
		f.BtnImpri.style.visibility='hidden';
		f.BtnPlan.style.visibility='hidden';
		f.BtnVol.style.visibility='hidden';
		window.print();
		f.BtnBusca.style.visibility='';
		f.BtnImpri.style.visibility='';
		f.BtnPlan.style.visibility='';
		f.BtnVol.style.visibility='';
}

function Volver(){
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=1';
		f.submit();	
}

</script>
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<form name="form1" method="post" action="">
<?
	include("../principal/encabezado.php");
	include("conectar.php");
?>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>

  <table width="770" border="1" class="TablaPrincipal">
    <tr>
      <td valign="top"><table width="427" border="1" align="center">
        <tr align="center" class="Detalle03">
          <td colspan="2"><strong>Produccion Acido Sulfurico </strong></td>
        </tr>
        <tr align="center">
          <td width="247" align="center">Desde:<strong>
            <input name="txtfecha" type="text" id="txtfecha" size="12" value="<?php echo "$txtfecha"; ?>">
            <img src="ico_cal.gif" alt="Pulse Aqui Para Seleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(txtfecha,txtfecha,popCal);return false"> </strong></td>
          <td width="226" align="left"><div align="center">Hasta:<strong>
              <input name="txtfecha2" type="text" id="txtfecha23" value="<?php echo "$txtfecha2"; ?>" size="12">
            <img src="ico_cal.gif" alt="Pulse Aqui Para Seleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(txtfecha2,txtfecha2,popCal);return false"> </strong></div></td>
          </tr>
        <tr align="center">
          <td colspan="2"><input name="BtnBusca" type="button" id="BtnBusca" style="width:70px " onClick="Buscar('W')" value="Buscar">
              <input name="BtnImpri" type="button" style="width:70px " value="Imprimir" onClick="imprimir()">
              <input name="BtnPlan" type="button" id="BtnPlan" onClick="Buscar('E')" value="Planilla Excel">
              <input name="BtnVol" type="submit" id="BtnVol" style="width:70px " onClick="Volver()" value="Volver"></td>
        </tr>
      </table>
        <br>
        <?php  
 	if($buscarOPT=="S")
 	{
			$consulta= "SELECT ENABAL_BASE.FECHA, ENABAL_BASE.T_MOV, ENABAL_BASE.N_FLUJO, ENABAL_BASE.NOM_PRODUCTO, ENABAL_BASE.P_SECO FROM ENABAL_BASE WHERE ((ENABAL_BASE.FECHA BETWEEN '$txtfecha' AND '$txtfecha2') 
			AND ENABAL_BASE.T_MOV=2 AND ((ENABAL_BASE.N_FLUJO=6) or (ENABAL_BASE.N_FLUJO=499) or (ENABAL_BASE.N_FLUJO=500)))";										
	
			$sumAcido="SELECT Sum(P_SECO) AS SUMA FROM ENABAL_BASE WHERE (ENABAL_BASE.T_MOV=2 AND ((ENABAL_BASE.N_FLUJO=6) or (ENABAL_BASE.N_FLUJO=499)) AND (ENABAL_BASE.FECHA BETWEEN '$txtfecha' AND '$txtfecha2'))";
			
			$resAcido="SELECT Sum(P_SECO) AS RESTA FROM ENABAL_BASE WHERE (ENABAL_BASE.T_MOV=2 AND (ENABAL_BASE.N_FLUJO=500) AND (ENABAL_BASE.FECHA BETWEEN '$txtfecha' AND '$txtfecha2'))";
		
		$totalsuma = mysql_query($sumAcido);			
		if($filauno=mysql_fetch_array($totalsuma))
		{	
			$Sum=$filauno[SUMA];
	 	}else
			$Sum=0;
		
		$totalresta = mysql_query($resAcido);
		if($filados=mysql_fetch_array($totalresta))
		{
			 $Res=$filados[RESTA];			 	
		}else		
			$Res=0;
			
		$TOTAL=$Sum-$Res;echo $res;
		
		echo "<table border='1' width='402' bgcolor='#FFFFCC' align='center'>";
		echo "<tr align='center'>";
 		echo "<td width='351'><strong>Total Produccion de Acido Sulfurico:</strong></td>";	
		echo "<td width='181'><strong>".$formato=number_format($TOTAL,'0',',','.')."</strong></td>";
		echo "</tr>";
		echo "</table>";
		echo "<br>";
		echo "<table width='702' border='1' align='center'>";
    	echo "<tr align='center'  class='ColorTabla01'>";
    	echo "<td width='150'>Fecha</td>";
    	echo "<td width='75'>Num Flujo </td>";
    	echo  "<td width='351'>Producto</td>";
    	echo "<td width='79'>Peso Seco (kg)</td>";		
    	echo "</tr>";
	
		$resultadosdos = mysql_query($consulta);			
		while($fila=mysql_fetch_array($resultadosdos))
		{
			echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFCC' align='center'>";
			echo "<td>".$fila["FECHA"]."</td>";
			echo "<td>".$fila[N_FLUJO]."</td>";
			echo "<td>".$fila[NOM_PRODUCTO]."</td>";			
			echo "<td>".$formato=number_format($fila[P_SECO],'0',',','.')."</td>";						
			echo "</tr>";
		}
	}
  ?>
  </table>
  <?
		include("cerrarconexion.php");
		include("../principal/pie_pagina.php");

?>
</form>
</body>
</html>
