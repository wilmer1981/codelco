<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
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

	include("conectar.php");

?>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<table width="770" border="0">
  <tr>
    <td><table width="439" border="1" align="center">
      <tr align="center" valign="top">
        <td colspan="2"><strong>Produccion Oxigeno</strong></td>
        </tr>
      <tr align="center">
        <td width="169" align="center">Desde:<strong>
         <?php echo "$txtfecha3"; ?>
           </strong></td>
        <td width="254" align="center">Hasta:<strong>
          <?php echo "$txtfecha22"; ?>
          </strong></td>
        </tr>
    </table>
	<br>
	<table width="325" border="1" align="center">
      <tr>
        <td width="189">TOTAL PRODUCCION OXIGENO: </td>
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
        <tr>
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
			echo "<td>".$fila["FECHA"]."</td>";	
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

?>
</form>
</body>
</html>
