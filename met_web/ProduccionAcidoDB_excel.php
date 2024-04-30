<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
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
		f.BtnGra.style.visibility='hidden';
		f.BtnVol.style.visibility='hidden';
		window.print();
		f.BtnBusca.style.visibility='';
		f.BtnImpri.style.visibility='';
		f.BtnPlan.style.visibility='';
		f.BtnGra.style.visibility='';
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
	include("conectar.php");
?>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>

  <table width="770" border="0">
    <tr>
      <td valign="top"><table width="322" border="1" align="center">
        <tr align="center">
          <td colspan="2"><strong>Produccion Acido Sulfurico </strong></td>
        </tr>
        <tr align="center">
          <td width="164" align="right">Desde:<strong>
           <?php echo "$txtfecha"; ?>
             </strong></td>
          <td width="142" align="center">Hasta:<strong>
            <?php echo "$txtfecha2"; ?>
          </strong></td>
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
		
		echo "<table border='1' align='center'>";
		echo "<tr align='center'>";
 		echo "<td>Total Produccion de Acido Sulfurico:</td>";	
		echo "<td>".$formato=number_format($TOTAL,'0',',','.')."</td>";
		echo "</tr>";
		echo "</table>";
		echo "<br>";
		echo "<table width='200' border='1' align='center'>";
    	echo "<tr>";
    	echo "<td align='center'>Fecha</td>";
    	echo "<td align='center'>Num Flujo </td>";
    	echo  "<td align='center'>Producto</td>";
    	echo "<td align='center'>Peso Seco (kg)</td>";		
    	echo "</tr>";
	
		$resultadosdos = mysql_query($consulta);			
		while($fila=mysql_fetch_array($resultadosdos))
		{
			echo "<tr>";
			echo "<td align='center'>".$fila["FECHA"]."</td>";
			echo "<td align='center'>".$fila[N_FLUJO]."</td>";
			echo "<td align='center'>".$fila[NOM_PRODUCTO]."</td>";			
			echo "<td align='center'>".$formato=number_format($fila[P_SECO],'0',',','.')."</td>";						
			echo "</tr>";
		}
	}
  ?>
  </table>
  <?
		include("cerrarconexion.php");
?>
</form>
</body>
</html>
