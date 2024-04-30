<?
	$CodigoDeSistema=25;
	$CodigoDePantalla=3;
?>
<html>
<head>
<title>Datos Base - Calculo Blister Neto</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
function Volver(){
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=1';
	f.submit();	
}

function Buscar()
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

	f.action="CalcularBlisterDB.php?buscarOPT=S" ;
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
<table width="770" height="330" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal">
  <tr>
    <td align="center" valign="top"><table width="503" height="58" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr align="center" class="Detalle03">
        <td height="14" colspan="2"><strong class="Detalle03">Calcular Blister Neto</strong></td>
      </tr>
      <tr>
        <td width="250" height="19"><div align="right"></div>
          <div align="center">Desde:
              <input name="txtfecha" type="text" id="txtfecha" size="12" value="<?php echo "$txtfecha"; ?>">
            <img src="ico_cal.gif" alt="Pulse Aqui Para Seleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(txtfecha,txtfecha,popCal);return false"> </div></td>
        <td width="246" align="right"><div align="center">Hasta: <strong>
            <input name="txtfecha2" type="text" id="txtfecha2" size="12" value="<?php echo "$txtfecha2"; ?>">
            <img src="ico_cal.gif" alt="Pulse Aqui Para Seleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(txtfecha2,txtfecha2,popCal);return false"> </strong></div></td>
        </tr>
      <tr align="center">
        <td height="22" colspan="2"><input  type="button" name="search" value="Buscar" onClick="Buscar()" style="width:70px ">
&nbsp;
      <input type="button" value="Volver" style="width:70px " onClick="Volver()"></td>
      </tr>
    </table>
      <br>
      <table width="454" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
          <td width="128"> Peso Seco (Kg) </td>
          <td width="108"> Cobre (Kg) </td>
          <td width="100"> Plata (gr) </td>
          <td width="90"> Oro (gr) </td>
        </tr>
        <?php
		if($buscarOPT=="S")
		{	
			$sql= "SELECT Sum(P_SECO) AS PESOSECO, Sum(F_COBRE) AS FINOCOBRE, Sum(F_PLATA) AS FINOPLATA, Sum(F_ORO) AS FINOORO from ENABAL_BASE where ((FECHA BETWEEN '$txtfecha' AND '$txtfecha2') AND 
			(ENABAL_BASE.N_FLUJO=77 Or ENABAL_BASE.N_FLUJO=144 Or ENABAL_BASE.N_FLUJO=139 Or ENABAL_BASE.N_FLUJO=249 Or ENABAL_BASE.N_FLUJO=376 Or ENABAL_BASE.N_FLUJO=257 Or 
			ENABAL_BASE.N_FLUJO=88 Or ENABAL_BASE.N_FLUJO=150) AND (ENABAL_BASE.T_MOV=2))";
			
			$sqldos="SELECT Sum(P_SECO) AS Sseco, Sum(F_COBRE) AS Scobre, Sum(F_PLATA) AS Splata, Sum(F_ORO) AS Soro FROM ENABAL_BASE WHERE ((FECHA BETWEEN '$txtfecha' AND '$txtfecha2') AND 
			ENABAL_BASE.N_FLUJO=40 AND ENABAL_BASE.T_MOV=2)";
						
			$resultados = mysql_query($sql);
			while($fila=mysql_fetch_array($resultados))
			{			
				$resultados2 = mysql_query($sqldos);
				while($fila2=mysql_fetch_array($resultados2))
				{													
					$pseco=$fila2[Sseco]-$fila[PESOSECO];
					$fcobre=$fila2[Scobre]-$fila[FINOCOBRE];
					$fplata=$fila2[Splata]-$fila[FINOPLATA];
					$foro=$fila2[Soro]-$fila[FINOORO];
					
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
					echo "<td>".$formato=number_format($pseco,0,',','.')."</td>";
					echo "<td>".$formato=number_format($fcobre,0,',','.')."</td>";
					echo "<td>".$formato=number_format($fplata,0,',','.')."</td>";
					echo "<td>".$formato=number_format($foro,0,',','.')."</td>";
					echo "</tr>";
					
					if($fila[PESOSECO]==0)
					{
						$uno=0;$dos=0;$tres=0;					
					}else{
						$uno=$fila2[Scobre]/$fila2[Sseco]*100;
						$dos=$fila2[Splata]/$fila2[Sseco]*1000;
						$tres=$fila2[Soro]/$fila2[Sseco]*1000;
					}
				
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>";
					echo "<td> LEYES </td>";
					echo "<td>".$english_format_number = number_format($uno, 2, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($dos, 3, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($tres, 3, ',', '')."</td>";
					echo "</tr>";
					echo "<br>";											    				
	    		}
			}
		}
	?>
      </table>
      <br>
      <table width="752" border="1" align="center" cellpadding="1" cellspacing="0" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
          <td>Fecha </td>
          <td width="47">Flujo</td>
          <td width="181">Producto</td>
          <td width="78">Peso Seco (Kg) </td>
          <td width="82">Fino Cobre (Kg) </td>
          <td width="79">Fino Plata (gr) </td>
          <td width="79">Fino Oro (gr) </td>
        </tr>
        <?php
	if ($buscarOPT=="S")
	{
		
		$sql = "SELECT FECHA, T_MOV, N_FLUJO, NOM_PRODUCTO, P_SECO, F_COBRE, F_PLATA, F_ORO FROM ENABAL_BASE where FECHA BETWEEN '$txtfecha' AND '$txtfecha2' and 
		ENABAL_BASE.T_MOV='2' AND (ENABAL_BASE.N_FLUJO='40' Or ENABAL_BASE.N_FLUJO='77' Or ENABAL_BASE.N_FLUJO='144' Or ENABAL_BASE.N_FLUJO='139' Or ENABAL_BASE.N_FLUJO='249' Or ENABAL_BASE.N_FLUJO='376' 
		Or ENABAL_BASE.N_FLUJO='257' Or ENABAL_BASE.N_FLUJO='88' Or ENABAL_BASE.N_FLUJO='150' )";

		$resultados = mysql_query($sql);
		while($fila=mysql_fetch_array($resultados))
		{
			echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFCC'>";
			echo "<td>".$fila["FECHA"]."</td>";
			echo "<td>".$fila[N_FLUJO]."</td>";
			echo "<td>".$fila[NOM_PRODUCTO]."</td>";			
			echo "<td>".$formato=number_format($fila[P_SECO],0,',','.')."</td>";
			echo "<td>".$formato=number_format($fila[F_COBRE],0,',','.')."</td>";
			echo "<td>".$formato=number_format($fila[F_PLATA],0,',','.')."</td>";
			echo "<td>".$formato=number_format($fila[F_ORO],0,',','.')."</td>";
			echo "</tr>";
		}
	}
	?>
      </table></td>
  </tr>
</table>


<?
	include("cerrarconexion.php");
	include("../principal/pie_pagina.php");
?>
</form>
</body>
</html>
