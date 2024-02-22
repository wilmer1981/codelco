<?
	$CodigoDeSistema=25;
	$CodigoDePantalla=3;
?>
<html>
<head>
<title>Datos Base - Produccion de Oxigeno</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>

<script language="javascript" type="text/JavaScript">

function Buscar(opt)
{	
	var f=document.form1;
	
	if(f.txtfecha2.value=='')
	{
		alert ("Debe ingresar fecha de inicio");
		f.txtfecha2.focus();
		return false;
	}
	if(f.txtfecha22.value=='')
	{
		alert ("Debe ingresar fecha final");
		f.txtfecha22.focus();
		return false;
	}		
		
	switch (opt)
	{
		case "W":
			f.action="ProduccionOxigenoDB.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="ProduccionOxigenoDB_excel.php?buscarOPT=S" ;
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
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
<table width="770" border="0" class="TablaPrincipal">
  <tr>
    <td><table width="494" border="1" align="center" class="TablaPrincipal">
      <tr align="center" valign="top" class="Detalle03">
        <td colspan="2"><strong>Produccion Oxigeno</strong></td>
        </tr>
      <tr align="center">
        <td width="340" align="center"><div align="center">Desde:<strong>
            <input name="txtfecha3" type="text" id="txtfecha2" size="12" value="<?php echo "$txtfecha3"; ?>">
            <img src="ico_cal.gif" alt="Pulse Aqui Para Seleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(txtfecha3,txtfecha3,popCal);return false"> </strong></div></td>
        <td width="344" align="right"><div align="center">Hasta:<strong>
            <input name="txtfecha22" type="text" id="txtfecha22" size="12" value="<?php echo "$txtfecha22"; ?>">
            <img src="ico_cal.gif" alt="Pulse Aqui Para Seleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(txtfecha22,txtfecha22,popCal);return false"> </strong></div></td>
        </tr>
      <tr align="center">
        <td colspan="2"><input name="BtnBusca" type="button" id="BtnBusca" style="width:70px " onClick="Buscar('W')" value="Buscar">
            <input name="BtnImpri" type="button"  style="width:70px " value="Imprimir" onClick="imprimir()">
            <input name="BtnPlan" type="button" id="BtnPlan" onClick="Buscar('E')" value="Planilla Excel">
            <input name="BtnVol" type="button" id="BtnVol" style="width:70px " onClick="Volver()" value="Volver"></td>
      </tr>
    </table>
	<br>
	<table width="325" border="1" align="center" class="TablaDetalle">
      <tr class="Detalle03">
        <td width="170">Total Producci&oacute;n Ox&iacute;geno:</td>
		<?
		if ($buscarOPT=="S")
		{
				$sqltotal="SELECT Sum(P_SECO) AS SUMA FROM ENABAL WHERE T_MOV='2' AND N_FLUJO='800' AND FECHA BETWEEN '$txtfecha3' AND '$txtfecha22'";
				$total = mysql_query($sqltotal);			
				if($fila=mysql_fetch_array($total))
				{	
					echo "<td>".$formato=number_format($fila[SUMA],'0',',','.')."</td>";
				}
				
		}
		?>
      </tr>
    </table>
      <br>
      <table width="700" border="1">
        <tr class="ColorTabla01">
          <td><div align="center">Fecha</div></td>
          <td><div align="center">Peso Seco</div></td>
          <td><div align="center">Fino Cobre </div></td>
          <td><div align="center">Fino Plata </div></td>
          <td><div align="center">Fino Oro </div></td>
		  
		        <?php  
 	if($buscarOPT=="S")
 	{
		$consulta= "SELECT * FROM ENABAL WHERE FECHA BETWEEN '$txtfecha3' AND '$txtfecha22' AND T_MOV='2' AND N_FLUJO='800'";										
		$resultadosdos = mysql_query($consulta);
		while($fila=mysql_fetch_array($resultadosdos))
		{
			echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
			echo "<td>".$fila[FECHA]."</td>";		
			echo "<td>".$formato=number_format($fila[P_SECO],'0',',','.')."</td>";
			echo "<td>".$formato=number_format($fila[F_COBRE],'0',',','.')."</td>";
			echo "<td>".$formato=number_format($fila[F_PLATA],'0',',','.')."</td>";
			echo "<td>".$formato=number_format($fila[F_ORO],'0',',','.')."</td>";
		}
	}
  ?>
        </tr>
      </table>
</td>
  </tr>
</table>
<?
include("cerrarconexion.php");
include("../principal/pie_pagina.php");
?>
</form>
</body>
</html>
