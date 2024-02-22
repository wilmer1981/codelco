<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include("conectar.php");
?>
<html>
<head>
<title>DATOS FINALES - ENABALPMN</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
</head>
<script language="javascript">
function Buscar(opt)
{	
	var f=document.form1;
	switch (opt)
	{
		case "W":
			f.action="PlantaMetalesDF.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="PlantaMetalesDF_excel.php?buscarOPT=S" ;
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
function Recarga()
{	
	var f=document.form1;
	f.action="PlantaMetalesDF_excel.php?buscarOPT=S&txtflujo="+f.productos.value ;
	f.submit();
}
function Rescatar()
{
	var f=document.form1;
	var Flujo ='';
	Flujo=f.productos.value.split('~');
 	f.txtflujo.value=Flujo[0];
	f.TxtNomProd.value=f.productos.options[f.productos.selectedIndex].text;
}

function Volver(){
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=2';
	f.submit();	
}

</script>
<script language="javascript">
function buscarpro()
{	
	var f=document.form1;
	f.action="PlantaMetalesDF_excel.php?buscarproOPT=S" ;
	f.submit();
}
</script>

<body>
<form name="form1" method="post" action="">


  <table width="770" border="0">
    <tr>
      <td><table width="316" height="78" border="1" align="center">
          <tr align="center" valign="top" class="ColorTabla01">
            <td height="18" colspan="3"><strong>Flujos Historicos Planta de Metales Nobles</strong> </td>
          </tr>
          <tr align="center" valign="top" class="ColorTabla01">
            <td width="137" height="26"><strong>N&uacute;mero de Flujo:</strong></td>
            <td width="33" align="left"><div align="left"><? echo $txtflujo;?></div> </td>
            <td width="124" rowspan="2"><div align="left"><? echo $TxtNomProd;?></div>
            <div align="center"></div></td>
          </tr>
          <tr align="center" valign="top" class="ColorTabla01">
            <td height="26"><strong>Tipo Movimiento: </strong></td>
            <td align="left"><div align="left"><? echo $select2; ?></div></td>
          </tr>
        
      
      
        </table>

		    <p>&nbsp;</p>
		    <table width="491" border="1" align="center" class="TablaDetalle">
            <tr class="ColorTabla01">
				<td width="105">Peso Seco (Kg) </td>
				<td width="123">Fino Cobre (Kg) </td>
				<td width="128">Fino Plata (gr) </td>
				<td width="107">Fino Oro (gr) </td>
      		</tr>
<?
$FechaIni=$ano."-".$mes."-01";
$FechaFin=$ano2."-".$mes2."-01";
	if ($buscarOPT=="S")
	{
		$sql = "SELECT SUM(P_SECO) as PESOSECO, SUM(F_COBRE) as FINOCOBRE, SUM(F_PLATA) as FINOPLATA, SUM(F_ORO) as FINOORO FROM enabalpmn where ((N_FLUJO='$txtflujo') AND (NOM_PRODUCTO='$TxtNomProd') AND (T_MOV='$select2') AND (FECHA BETWEEN '$FechaIni' and '$FechaFin'))"; 	
		$resultados = mysql_query($sql);
		while($linea=mysql_fetch_array($resultados))
			{
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;		
					echo "<td>".$formato=number_format($linea[PESOSECO],'0',',','.')."</td>";
					echo "<td>".$formato=number_format($linea[FINOCOBRE],'0',',','.')."</td>";
					echo "<td>".$formato=number_format($linea[FINOPLATA],'0',',','.')."</td>";
					echo "<td>".$formato=number_format($linea[FINOORO],'0',',','.')."</td>";
					echo "</tr>";
					
					
					
					if($linea[PESOSECO]==0)
						{
						$uno=0;$dos=0;$tres=0;					
						}
					else
						{
						$uno=$linea[FINOCOBRE]/$linea[PESOSECO]*100;
						$dos=$linea[FINOPLATA]/$linea[PESOSECO]*1000;
						$tres=$linea[FINOORO]/$linea[PESOSECO]*1000;
						}
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;		
					echo "<td>LEY</td>";
					echo "<td>".$english_format_number = number_format($uno, 2, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($dos, 2, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($tres, 2, ',', '')."</td>";
					echo "</tr>";
					
			}
	}
	
?>     
		
		  </table>    
   
		    <p>&nbsp;</p>
	      <table width="588" border="1" align="center" class="TablaDetalle">
            <tr align="center" class="ColorTabla01">
              <td width="150"><strong>Fecha</strong></td>
              <td width="107"><strong>Peso Seco (Kg) </strong></td>
              <td width="110"><strong>Fino Cobre (Kg) </strong></td>
              <td width="95"><strong>Fino Plata (gr) </strong></td>
              <td width="92"><strong>Fino Oro (gr) </strong></td>
            </tr>
            <?
			$FechaIni=$ano."-".$mes."-01";
			$FechaFin=$ano2."-".$mes2."-01";
	if ($buscarOPT=="S")
	{
		$sql = "SELECT * FROM enabalpmn where N_FLUJO='$txtflujo' AND  T_MOV='$select2' and NOM_PRODUCTO='$TxtNomProd' and FECHA BETWEEN ' $FechaIni' and '$FechaFin' ORDER BY FECHA"; 
		$resultados = mysql_query($sql);
		while($fila=mysql_fetch_array($resultados))
		{
			echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;		
			echo "<td>".$fila[FECHA]."</td>";
			echo "<td>".$formato=number_format($fila[P_SECO],'0',',','.')."</td>";
			echo "<td>".$formato=number_format($fila[F_COBRE],'0',',','.')."</td>";
			echo "<td>".$formato=number_format($fila[F_PLATA],'0',',','.')."</td>";
			echo "<td>".$formato=number_format($fila[F_ORO],'0',',','.')."</td>";
			echo "</tr>";
		}
	}
	?>
        </table>
     

  <DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<?
		include("cerrarconexion.php");
?>
</form>
</body>
</html>
