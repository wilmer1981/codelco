<?
	//$CodigoDeSistema=25;
	//$CodigoDePantalla=3;
?>
<html>
<head>
<title>Datos Finales - Anodos Rechazados</title>
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
.Estilo1 {color: #9933FF}
-->
</style></head>
<script language="javascript">
function Buscar(opt)
{	
	var f=document.form1;
	
	/*if(f.txtfecha6.value=='')
	{
		alert ("Debe ingresar fecha de inicio");
		f.txtfecha6.focus();
		return false;
	}
	if(f.txtfecha7.value=='')
	{
		alert ("Debe ingresar fecha final");
		f.txtfecha7.focus();
		return false;
	}		*/
	
	switch (opt)
	{
		case "W":
			f.action="AnodosRechazadosDF.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="AnodosRechazadosDF_excel.php?buscarOPT=S" ;
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
    <td width="924">
      <table width="471" border="1" align="center">
        <tr align="center" class="Detalle03">
          <td colspan="2"><strong>Anodos Rechazados </strong></td>
          </tr>
        <tr>
          <td width="257"><div align="center">Desde:<font color="#000000" size="2">
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
</font></div></td>
          <td width="218"><div align="center">Hasta:                <font color="#000000" size="2">
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
                </font><font color="#000000" size="2">
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
                </font></div></td>
          </tr>
      </table>
	  <br>
	  <span class="Estilo1"></span>	  <table width="408" border="0" align="center">
        <tr>
          <td align="center"><input name="BtnBusca" type="button"  id="BtnBusca"    onClick="Buscar('W')"   value="Buscar">     
		                     <input name="BtnImpri" type="button"  value="Imprimir" onClick="imprimir()">         
							 <input name="BtnPlan"  type="button"  id="BtnPlan"     onClick="Buscar('E')"   value="Planilla Excel">            
		                     <input name="BtnVol"   type="button"  id="BtnVol"      style="width:70px "     onClick="Volver()"  value="Volver"></td>
          </tr>
      </table>
	  <br>
	  
	  <table width="577" border="1" align="center" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
          <td colspan="4">ANODOS RECHAZADOS </td>
          </tr>
        <tr class="ColorTabla01">
          <td width="132">PESO SECO (Kg) </td>
          <td width="136">FINO COBRE (Kg) </td>
          <td width="140">FINO PLATA (gr) </td>
          <td width="141">FINO ORO (gr) </td>
		  
		  <?
		  $FechaIni=$ano."-".$mes."-01";
		  $FechaFin=$ano2."-".$mes2."-01";
		  if ($buscarOPT=="S")
		  {
		  			
					$consultar= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$FechaIni' AND '$FechaFin') ORDER BY N_FLUJO";
					$resultados = mysql_query($consultar);
				while($lineas=mysql_fetch_array($resultados))
					{
						echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
						echo "<td>".$formato=number_format($lineas[PESOSECO],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($lineas[FINOCOBRE],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($lineas[FINOPLATA],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($lineas[FINORO],'0',',','.')."</td>";
						echo "</tr>";
						if($lineas[PESOSECO]==0)
							{
								$uno=0;$dos=0;$tres=0;				
							}
						else
							{
								$uno=$lineas[FINOCOBRE]/$lineas[PESOSECO]*100;
								$dos=$lineas[FINOPLATA]/$lineas[PESOSECO]*1000;
								$tres=$lineas[FINORO]/$lineas[PESOSECO]*1000;						
							}
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
					echo "<td>LEY</td>";
					echo "<td>".$english_format_number = number_format($uno, 2, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($dos, 3, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($tres, 3, ',', '')."</td>";
					echo "</tr>";
				}
		  }
		  ?>
        </tr>
      </table>
	  <br>
	  <br>
	  <table width="700" border="1" align="center">
        <tr align="center" class="ColorTabla01">
          <td width="154">Fecha</td>
          <td width="42"> Flujo </td>
          <td width="298">Nombre Producto </td>
          <td width="99">Peso Seco (Kg) </td>
          <td width="78">Fino Cobre (Kg) </td>
          <td width="81">Fino Plata (gr) </td>
          <td width="70">Fino Oro (gr) </td>
		 
		  <?
		  if ($buscarOPT=="S")
		  {			
				$consultas= "SELECT DISTINCT FECHA FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$FechaIni' AND '$FechaFin')";
				//echo $consultas."<br>";
				$RespFecha = mysql_query($consultas);
				while($FilaFecha=mysql_fetch_array($RespFecha))
				{
					$TotMesPSeco=0;$TotMesFCobre=0;$TotMesFPlata=0;$TotMesFOro=0;
					$consultas= "SELECT * FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA ='$FilaFecha["FECHA"]')";
					$resultados = mysql_query($consultas);
					while($codigo=mysql_fetch_array($resultados))
					{
							echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
							echo "<td>".$codigo["FECHA"]."</td>";
							echo "<td>".$codigo[N_FLUJO]."</td>";
							echo "<td>".$codigo[NOM_PRODUCTO]."</td>";
							echo "<td>".$formato=number_format($codigo[P_SECO],'0',',','.')."</td>";
							echo "<td>".$formato=number_format($codigo[F_COBRE],'0',',','.')."</td>";
							echo "<td>".$formato=number_format($codigo[F_PLATA],'0',',','.')."</td>";
							echo "<td>".$formato=number_format($codigo[F_ORO],'0',',','.')."</td>";
							$TotMesPSeco=$TotMesPSeco+$codigo[P_SECO];
							$TotMesFCobre=$TotMesFCobre+$codigo[F_COBRE];
							$TotMesFPlata=$TotMesFPlata+$codigo[F_PLATA];
							$TotMesFOro=$TotMesFOro+$codigo[F_ORO];
							echo "</tr>";
							echo"<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>";
							echo"</tr>";
					}
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFFF' align='center'>" ;
					echo "<td colspan='3' align='right'>TOTALES</td>";
					echo "<td>".$formato=number_format($TotMesPSeco,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($TotMesFCobre,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($TotMesFPlata,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($TotMesFOro,'0',',','.')."</td>";
					echo "</tr>";
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFFF' align='center'>" ;
					echo "<td colspan='3' align='right'>LEY</td>";
					
					if($TotMesPSeco>0)
					{
					echo"<td></td>";
					echo "<td>".$formato=number_format(($TotMesFCobre*100)/$TotMesPSeco,'2',',','.')."</td>";
					echo "<td>".$formato=number_format(($TotMesFPlata*1000)/$TotMesPSeco,'3',',','.')."</td>";
					echo "<td>".$formato=number_format(($TotMesFOro*1000)/$TotMesPSeco,'3',',','.')."</td>";
					
					}
					else{
					
					echo "<td> 0 </td>";
					echo "<td> 0 </td>";//echo "<td>".$formato=number_format(($TotMesFPlata*1000)/$TotMesPSeco,'3',',','.')."</td>";
					echo "<td> 0 </td>";//echo "<td>".$formato=number_format(($TotMesFOro*1000)/$TotMesPSeco,'3',',','.')."</td>";
					echo "</tr>";
					
					}
					//echo "<tr> </tr>";
				}	
		  }
		  ?>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?
		include("../principal/pie_pagina.php");
		include("cerrarconexion.php");
		
	?>
</form>
</body>
</html>
