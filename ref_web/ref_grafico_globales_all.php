<?php 	
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 1;
	include("../principal/conectar_ref_web.php");
   	if (strlen($DiaIni)== 1)
		$DiaIni = "0".$DiaIni;
	if (strlen($MesIni)== 1)
		$MesIni = "0".$MesIni;
	if (strlen($DiaFin)== 1)
		$DiaFin = "0".$DiaFin;
	if (strlen($MesFin)== 1)
		$MesFin = "0".$MesFin;
   $FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
   $FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;

?>
<html>
<head>
<script language="JavaScript">
function Imprimir(f)
{
	window.print();
}
</script>

<title>Grafico Corocircuitos  entre <?php echo $FechaInicio;?> y <?php echo $FechaTermino;?></title>
<LINK href="archivos/petalos.css" type=text/css rel=stylesheet>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngCircuito" method="post" action="">
  <table width="965" border="0" class="TablaPrincipal" left="5" cellpadding="5" cellspacing="0">
  <tr>
      <td width="903" align="center">
	  <br>
	  <table width="700" border="4" class="tablainterior">
	  <?php 
	     $cmbcircuito='01';
		 echo "<td><img src='ref_grafico_globales_cortocircuitos.php?FechaInicio=".$FechaInicio."&FechaTermino=".$FechaTermino."&cmbcircuito=".$cmbcircuito."'></td>"; 
		  $cmbcircuito='02';
		 echo "<td><img src='ref_grafico_globales_cortocircuitos.php?FechaInicio=".$FechaInicio."&FechaTermino=".$FechaTermino."&cmbcircuito=".$cmbcircuito."'></td>"; 
      ?>
	  </table>
	  <table width="700" border="4" class="tablainterior">
	  <?php 
	     $cmbcircuito='03';
		 echo "<td><img src='ref_grafico_globales_cortocircuitos.php?FechaInicio=".$FechaInicio."&FechaTermino=".$FechaTermino."&cmbcircuito=".$cmbcircuito."'></td>"; 
		 $cmbcircuito='04';
		 echo "<td><img src='ref_grafico_globales_cortocircuitos.php?FechaInicio=".$FechaInicio."&FechaTermino=".$FechaTermino."&cmbcircuito=".$cmbcircuito."'></td>"; 
      ?>
       </table>
	  <table width="700" border="4" class="tablainterior">
	  <?php 
	     $cmbcircuito='05';
		 echo "<td><img src='ref_grafico_globales_cortocircuitos.php?FechaInicio=".$FechaInicio."&FechaTermino=".$FechaTermino."&cmbcircuito=".$cmbcircuito."'></td>"; 
		 $cmbcircuito='06';
		 echo "<td><img src='ref_grafico_globales_cortocircuitos.php?FechaInicio=".$FechaInicio."&FechaTermino=".$FechaTermino."&cmbcircuito=".$cmbcircuito."'></td>"; 
      ?>
       </table>
	
	 <br>
        <input name="gImprimir1" type="button" value="Imprimir" onClick="Imprimir(this.form)" >
        <br></td>
  </tr>
</table>
</form>
</body>
</html>

