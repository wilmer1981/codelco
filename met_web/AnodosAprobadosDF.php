<?
	$CodigoDeSistema=25;
	$CodigoDePantalla=3;
?>
<html>
<head>
<title>Datos Finales - Anodos Aprobados</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>

<script language="javascript">
function Buscar(opt)
{	
	var f=document.form1;

	/*if(f.FechaIni.value=='')
	{
		alert ("Debe ingresar fecha de inicio");
		f.FechaIni.focus();
		return false;
	}
	if(f.FechaFin.value=='')
	{
		alert ("Debe ingresar fecha final");
		f.FechaFin.focus();
		return false;
	}	*/		
	
	switch (opt)
	{
		case "W":
			f.action="AnodosAprobadosDF.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="AnodosAprobadosDF_excel.php?buscarOPT=S" ;
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
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=2';
	f.submit();	
}

</script>
<form name="form1" method="post" action="">

<?
	include("../principal/encabezado.php");
	include ("conectar.php");
?>
<table width="956" border="0">
<table width="914" height="330" border="0" class="TablaPrincipal">
  <td width="904"><tr>
    <td><table width="598" border="1" align="center">
      <tr align="center" class="Detalle03">
        <td colspan="5"><p><strong>Anodos Aprobados Finales</strong></p>          </td>
      </tr>
      <tr>
        <td width="124" align="right">Desde:</td>
        <td width="170"><font color="#000000" size="2">
<select name="mes" size="1" id="select7" style="FONT-FACE:verdana;FONT-SIZE:10">
  <?
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($buscarOPT=='S')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes)
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }		
		}
		else
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==date("n"))
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
</select>          
<select name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
            <?
		if($buscarOPT=='S')
		{
			for ($i=date("Y")-10;$i<=date("Y")+1;$i++)	
			{
				if ($i==$ano)
				{
				echo "<option selected value ='$i'>$i</option>";
				}
				else	
				{
				echo "<option value='".$i."'>".$i."</option>";
				}
			}
		}
		else
		{
			for ($i=date("Y")-10;$i<=date("Y")+1;$i++)	
			{
				if ($i==date("Y"))
				{
				echo "<option selected value ='$i'>$i</option>";
				}
				else	
				{
				echo "<option value='".$i."'>".$i."</option>";
				}
			 }   
		}	
	?>
          </select>
        </font></td>
        <td width="41" align="right"> Hasta:</td>
        <td width="235"><font color="#000000" size="2">
          <select name="mes2" size="1" id="select" style="FONT-FACE:verdana;FONT-SIZE:10">
            <?
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($buscarOPT=='S')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes2)
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }		
		}
		else
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==date("n"))
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
          </select>
          <select name="ano2" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
            <?
	if($buscarOPT=='S')
	{
	    for ($i=date("Y")-10;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano2)
			{
			echo "<option selected value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
        }
	}
	else
	{
	    for ($i=date("Y")-10;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option selected value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	
?>
          </select>
        </font></td>
      </tr>
    </table>
    <table width="501" border="0" align="center">
        <tr align="center">
          <td><input name="BtnBusca" type="Button" id="BtnBusca" onClick="Buscar('W')"  value="Buscar">            <input name="BtnImpri" type="Button"   value="Imprimir" onClick="imprimir()">            <input name="BtnPlan" type="Button" id="BtnPlan" onClick="Buscar('E')"  value="Planilla Excel">            <input name="BtnVol" type="Button" id="BtnVol" onClick="Volver()"  value="Volver"></td>
        </tr>
      </table>
      <br>
      <table width="575" border="1" align="center" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
        <td colspan="4">ANODOS APROBADOS FINALES </td>
        </tr>
		<tr class="ColorTabla01">
          <td width="132">PESO SECO (Kg)</td>
          <td width="136">FINO COBRE (Kg) </td>
          <td width="140">FINO PLATA (gr) </td>
          <td width="139">FINO ORO (gr) </td>
	    <?
		  if ($buscarOPT=="S")
		  {
			  $FechaIni=$ano."-".$mes."-01";
			  $FechaFin=$ano2."-".$mes2."-01";
				
				
				$consultt= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal WHERE T_MOV='2' AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND FECHA BETWEEN '$FechaIni' AND '$FechaFin'";
				$consultar= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal WHERE T_MOV='2' AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$FechaIni' AND '$FechaFin'";
				$resultados = mysql_query($consultt);
				$resultados1=mysql_query($consultar);
				if($lineas=mysql_fetch_array($resultados))
				{
					$atpc=$lineas[PESOSECO];
					$atfc=$lineas[FINOCOBRE];
					$atfp=$lineas[FINOPLATA];
					$atfo=$lineas[FINORO];
				}
				if($lineas1=mysql_fetch_array($resultados1))
					{
						$arps=$lineas1[PESOSECO];
						$arfc=$lineas1[FINOCOBRE];
						$arfp=$lineas1[FINOPLATA];
						$arfo=$lineas1[FINORO];
					}

			}
			$uno=$atpc-$arps;
			$dos=$atfc-$arfc;
			$tres=$atfp-$arfp;
			$cuatro=$atfo-$arfo;
			
			echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
			echo "<td>".$formato=number_format($uno,0,',','.')."</td>";
			echo "<td>".$formato=number_format($dos,0,',','.')."</td>";
			echo "<td>".$formato=number_format($tres,0,',','.')."</td>";
			echo "<td>".$formato=number_format($cuatro,0,',','.')."</td>";
			echo "</tr>";
			
		  
		  if ($buscarOPT=="S")
		  {
				$consultar= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$FechaIni' AND '$FechaFin') ORDER BY N_FLUJO";
				$resultados = mysql_query($consultar);
				while($lineas=mysql_fetch_array($resultados))
			    {
					if($uno==0)
						{
							$uno1=0;$dos1=0;$tres1=0;				
						}
					else
						{
							$uno1=$dos/$uno*100;
							$dos1=$tres/$uno*1000;
							$tres1=$cuatro/$uno*1000;						
						}
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
					echo "<td>LEY</td>";
					echo "<td>".$english_format_number = number_format($uno1, 2, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($dos1, 3, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($tres1, 3, ',', '')."</td>";
					echo "</tr>";
  				}
  			}
			?>
        </tr>
      </table>
      <br>
      <table width="768" border="1" align="center" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
          <td colspan="8">ANODOS APROBADOS POR MES  </td>
        </tr>
        <tr align="center" class="ColorTabla01">
          <td width="100">Fecha</td>
          <td width="89">Peso Seco (Kg) </td>
          <td width="100">Fino Cobre (Kg) </td>
          <td width="76">Fino Plata (gr) </td>
          <td width="84">Fino Oro (gr) </td>
       <?
	    if ($buscarOPT=="S")
		  {			
				$FechaIni=$ano."-".$mes."-01";
			  	$FechaFin=$ano2."-".$mes2."-01";
				
				$consultas= "SELECT DISTINCT FECHA FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$FechaIni' AND '$FechaFin')";
				$RespFecha = mysql_query($consultas);
				while($FilaFecha=mysql_fetch_array($RespFecha))
				{		$apps=0;$apco=0;$appl=0;$apor=0;
						$consultt= "SELECT  SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND (FECHA = '$FilaFecha["FECHA"]'))";
						$consultar= "SELECT  SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND (FECHA ='$FilaFecha["FECHA"]'))";
						
						$resultados = mysql_query($consultt);
						$resultados1= mysql_query($consultar);
						while($codigo=mysql_fetch_array($resultados))
								{
									$apps=$codigo[PESOSECO];
									$apco=$codigo[FINOCOBRE];
									$appl=$codigo[FINOPLATA];
									$apor=$codigo[FINORO];
								}
												
						while($codigo2=mysql_fetch_array($resultados1))
								{
									$arps=$codigo2[PESOSECO];
									$arco=$codigo2[FINOCOBRE];
									$arpl=$codigo2[FINOPLATA];
									$aror=$codigo2[FINORO];
								
								}
								
						$uno=$apps-$arps;
						$dos=$apco-$arco;
						$tres=$appl-$arpl;
						$cuatro=$apor-$aror;
						
						echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
						echo "<td>".$FilaFecha["FECHA"]."</td>";
						echo "<td>".$formato=number_format($uno,'0',',','.')."</td>";
						echo "<td>".$formato=number_format($dos,'0',',','.')."</td>";
						echo "<td>".$formato=number_format($tres,'0',',','.')."</td>";
						echo "<td>".$formato=number_format($cuatro,'0',',','.')."</td>";
		
				}
			
			} 
		  ?>
	    </tr>
      </table>
      <br>
      <br>      <span class="ColorTabla01"><br>
      </span>
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
