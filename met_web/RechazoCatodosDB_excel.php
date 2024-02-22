<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<html>
<head>
<title>Datos Bases - Porcentaje Rechazo Catodos</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
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

<script language="javascript">
function Buscar(opt)
{	
	var f=document.form1;
	switch (opt)
	{
		case "W":
			f.action="RechazoCatodosDB.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="RechazoCatodosDB_excel.php?buscarOPT=S" ;
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

<body>
<form name="form1" method="post" action="">
  <?
	include("conectar.php");
?>
  <DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>

<table width="770" height="330" border="1">
  <tr>
    <td width="1119" align="center" valign="top">
      <table width="503" border="1" align="center">
        <tr align="center">
          <td colspan="2"><strong>Porcentaje Rechazo Catodos</strong> </td>
        </tr>
        <tr>
          <td width="223" align="right">
            <div align="center"><strong>A&ntilde;o: </strong></div></td>
          <td width="264" align="center"><? echo $ano; ?>
</td>
        </tr>
      </table>
      <br>
      <table width="470" height="28" border="1" cellspacing="0">
        <tr align="center">
          <td>A&ntilde;o</td>
          <td>Descripcion</td>
          <td>Ene</td>
          <td>Feb</td>
          <td>Mar</td>
          <td>Abr</td>
          <td>May</td>
          <td>Jun</td>
          <td>Jul</td>
          <td>Ago</td>
          <td>Sep</td>
          <td>Oct</td>
          <td>Nov</td>
          <td>Dic</td>
          <td>Total</td>
        </tr>
        <?
		if ($buscarOPT=="S")
		{
		$fechainicio=$ano."-"."01"."-01";
		$fechafinal=$ano."-"."12"."-31";
		$Valores=array("0","0","0","0","0","0","0","0","0","0","0","0");
		$Rechazo=array("0","0","0","0","0","0","0","0","0","0","0","0");
			$j=0;
			while ($fechainicio <= $fechafinal)
			{
			
				$forma=str_pad(substr($fechainicio,5,2),2,"0",STR_PAD_LEFT);
				$fechaini=$ano."-$forma"."-01";
				$fechafin=$ano."-$forma"."-31";
					$sql="SELECT SUM(F_COBRE) AS FINO FROM ENABAL_BASE WHERE T_MOV='2' AND (N_FLUJO='214' OR N_FLUJO='171' OR N_FLUJO='196') AND FECHA BETWEEN '$fechaini' AND '$fechafin'";
					$resultado=mysql_query($sql);
					if ($linea=mysql_fetch_array($resultado))
					{
						$Valores[intval($forma-1)]=$linea[FINO];//echo "<td>".$numero=number_format($linea[FINO],'0',',','.')."</td>";
					}
							$consultar= "SELECT SUM(F_COBRE) as PESOSECO FROM ENABAL_BASE WHERE ((T_MOV='2') AND  N_FLUJO='214' AND FECHA BETWEEN '$fechaini' AND '$fechafin')";
								$consulta= "SELECT SUM(F_COBRE) as PESOSECO1 FROM ENABAL_BASE WHERE ((T_MOV='2') AND N_FLUJO='196'  AND FECHA BETWEEN '$fechaini' AND '$fechafin')";
								$consultas= "SELECT SUM(F_COBRE) as PESOSECO2 FROM ENABAL_BASE WHERE ((T_MOV='2') AND N_FLUJO='171'  AND FECHA BETWEEN '$fechaini' AND '$fechafin')";
								$resultados = mysql_query($consultar);
								$resultados1 = mysql_query($consulta);
								$resultados2 = mysql_query($consultas);
								if($codigo=mysql_fetch_array($resultados))
								{
									$fc=$codigo[PESOSECO];
								}
								if($cod=mysql_fetch_array($resultados1))
								{
									$fc1=$cod[PESOSECO1];
								}
								if($co=mysql_fetch_array($resultados2))
								{
									$fc2=$co[PESOSECO2];
								}
								$porcentaje= (($fc-$fc2)/($fc-$fc2+$fc1)*100);
								$Rechazo[intval($forma-1)]=$porcentaje;
				$fechainicio=date('Y-m-d',mktime(0,0,0,substr($fechainicio,5,2)+1,substr($fechainicio,8,2),substr($fechainicio,0,4)));
				$j=$j+1;
				}
		echo "<tr>";
		echo "<td>$ano</td>";
		echo "<td><strong>Fino Cu</strong></td>";
		$suma=0;
		$suma2=0;
		while(list($c,$v)=each($Valores))
		{
		if($v!="")
		{
			echo "<td align='right'>".$formato=number_format($v,'0',',','.')."</td>";
			$suma=$suma+$v;
			}	
		}
		$sumat=0;
		echo "<td>".$formato=number_format($suma,'0',',','.')."</td>";
		}
		echo "<tr>";
		echo "<td>$ano</td>";
		echo "<td><strong>% Rechazo</strong></td>";
		while(list($c,$v)=each($Rechazo))
		{
		if($v!="")
		{
		$k=$formato=number_format($v,'2',',','');
			echo "<td align='right'>".$k."</td>";
			$sumat=$k;
			$total=$total+$sumat;
			}	
		}
		$porcentaje=$total/12;
		echo "<td>".$formato=number_format($porcentaje,'2',',','')."</td>";
?>
      </table>
</table>
</td>
    </td>
  </tr>
</table>
<?
		include("cerrarconexion.php");
 ?>
</form> 
</body>
</html>
