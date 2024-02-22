<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="javascript" type="text/JavaScript">

function Buscar()
{	
 	var f=document.form1;
	f.action="Residuos.php?buscarOPT=S";
	f.submit();
}

function Volver(){
	var f=document.form1;
	f.action='Principal.php';
	f.submit();	
}

</script>


</head>

<?php
include("conectar.php");
?>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="form1" method="post" action="">
<table width="732" border="0" align="center">
  <tr>
    <td width="87">&nbsp;</td>
    <td width="62">&nbsp;</td>
    <td width="112">&nbsp;</td>
    <td width="56">&nbsp;</td>
    <td width="118">&nbsp;</td>
    <td width="87">&nbsp;</td>
    <td width="87">&nbsp;</td>
    <td width="89">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Producto</td>
    <td><select name="productos" >
    <?php 
		$consulta= "Select distinct RESIDUO from rises ";
		$resultados = mysql_query($consulta);
		while($columna=mysql_fetch_array($resultados))
		{
			echo "<option value='".$columna[RESIDUO]."'selected>".$columna[RESIDUO]."</option>";
		}
	?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Fecha</td>
    <td><input type="text" name="txtfecha" size="8" >
		<img src="ico_cal.gif" alt="Pulse Aqui Para Seleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(txtfecha,txtfecha,popCal);return false">	
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text" name="txtfecha2" size="8">
		<img src="ico_cal.gif" alt="Pulse Aqui Para Seleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(txtfecha2,txtfecha2,popCal);return false">
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3"><div align="center">
          <input type="button" name="search" value="Buscar" onClick="Buscar()" style="width:70px ">      
          <input type="submit" name="Submit6" value="Volver" style="width:70px " onClick="Volver()">
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>

<?php  
 	if($buscarOPT=="S")
 	{
		echo "<table width='702' border='1' align='center'>";
    	echo "<tr align='center'>";
    	echo "<td width='150'>ID</td>";
    	echo "<td width='75'>Residuo</td>";
    	echo "<td width='75'>A�o</td>";
    	echo  "<td width='351'>Mes</td>";
    	echo "<td width='79'>Peso</td>";
    	echo "<td width='79'>Produccion</td>";
    	echo "<td width='79'>Embarque</td>";
    	echo "<td width='79'>S_Final</td>";						
    	echo "</tr>";

		$consulta= "SELECT RISES.ID, RISES.RESIDUO, RISES.ANO, RISES.MES, RISES.PESO, RISES.PRODUCCION, RISES.EMBARQUE, RISES.S_FINAL FROM RISES WHERE ((RISES.FECHA BETWEEN '$txtfecha' AND '$txtfecha2') AND (ENABAL.NOM_PRODUCTO='$productos')";
					
		$resultado = mysql_query($consulta);			
		while($fila=mysql_fetch_array($resultado))
		{
			echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFCC' align='center'>";
			echo "<td>".$fila[ID]."</td>";
			echo "<td>".$fila[RESIDUO]."</td>";
			echo "<td>".$fila[ANO]."</td>";
			echo "<td>".$fila[MES]."</td>";			
			echo "<td>".$fila["peso"]."</td>";
			echo "<td>".$fila[PRODUCCION]."</td>";
			echo "<td>".$fila[EMBARQUE]."</td>";
			echo "<td>".$fila[S_FINAL]."</td>";									
			echo "</tr>";
		}
	}				
?>

</form>
</body>
</html>
