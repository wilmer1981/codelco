<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<html>
<head>
<title>Datos Finales - Produccion Cobre Electrolitico</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>

<script language="javascript" type="text/JavaScript">

function Buscar(opt)
{	
	var f=document.form1;
	switch (opt)
	{
		case "W":
			f.action="CobreElectroDF.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="CobreElectroDF_excel.php?buscarOPT=S" ;
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

function Volver()
{
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=2';
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
<table width="758" height="330" border="0">
  <tr>
    <td align="center" valign="top">      <table width="503" border="1" align="center">
      <tr align="center">
        <td colspan="2"><strong>Produccion Cobre Electrolitico </strong></td>
      </tr>
      <tr align="center">
        <td width="271" align="left"><div align="center">A&Ntilde;O:</div>          </td>
        <td width="216" align="left"><? echo $ano; ?></td>
        </tr>
    </table>
	<br>
	<br>
      <table width="531" border="1" cellpadding="1">
        <tr>
          <td width="25" >A&Ntilde;O</td>
          <td width="28" >ITEM</td>
          <td width="22" >ENE</td>
          <td width="20" >FEB</td>
          <td width="24" >MAR</td>
          <td width="22" >ABR</td>
          <td width="24" >MAY</td>
          <td width="21" >JUN</td>
          <td width="19" >JUL</td>
          <td width="16" >AG</td>
          <td width="21" >SEP</td>
          <td width="24" >OCT</td>
          <td width="25" >NOV</td>
          <td width="55" >DIC </td>
          <td width="63" >TOTAL</td>
		  <?
		  if ($buscarOPT="S")
		  {
		  $j=0;
		 $Valores=array("0","0","0","0","0","0","0","0","0","0","0","0");
		$fechainicio=$ano."-"."01"."-01";
		$fechafinal=$ano."-"."12"."-31";
			while ($fechainicio <= $fechafinal)
			{
				$forma=str_pad(substr($fechainicio,5,2),2,"0",STR_PAD_LEFT);
				$fechaini=$ano."-$forma"."-01";
				$fechafin=$ano."-$forma"."-31";
				$consulta= "SELECT Sum(F_COBRE) AS SUMA FROM ENABAL WHERE ((ENABAL.FECHA BETWEEN '$fechaini' AND '$fechafin')  AND ENABAL.T_MOV=2 AND
				(ENABAL.N_FLUJO=171 Or ENABAL.N_FLUJO=125 Or ENABAL.N_FLUJO=126 Or ENABAL.N_FLUJO=235 or ENABAL.N_FLUJO=196 Or ENABAL.N_FLUJO=214 Or ENABAL.N_FLUJO=162 Or ENABAL.N_FLUJO=163))";
				$resultado=mysql_query($consulta);
				if ($linea=mysql_fetch_array($resultado))
					$Valores[intval($forma-1)]=$linea[SUMA];//echo "<td>".$numero=number_format($linea[FINO],'0',',','.')."</td>";
				$fechainicio=date('Y-m-d',mktime(0,0,0,substr($fechainicio,5,2)+1,substr($fechainicio,8,2),substr($fechainicio,0,4)));
				$j=$j+1;
				}
		echo "<tr>";
		echo "<td>$ano</td>";
		echo "<td><strong>Total Cobre Electrolitico (TMF)</strong></td>";
		$suma=0;
		while(list($c,$v)=each($Valores))
		{
		if($v!="")
		{
			echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
			$suma=$suma+$v;
			}	
		}
				echo "<td align='right'>".$formato=number_format($suma,'0',',','.')."</td>";
				echo "</td>";
}

		?>
        </tr>
      </table></td>
	  </table>     

<?
		include("cerrarconexion.php");
?>
</form>
</body>
</html>